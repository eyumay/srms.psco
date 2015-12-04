<?php

/**
 * sectioncourseoffering actions.
 *
 * @package    srmsnew
 * @subpackage sectioncourseoffering
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sectioncourseofferingActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    
    $orderBy='';
      
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId); 
    
    
    if($request->getParameter('sortBy')=='program')
        $orderBy='program_id'; 
    if($request->getParameter('sortBy')=='center')
        $orderBy='center_id';         
    if($request->getParameter('sortBy')=='academicYear')
        $orderBy='academic_year';
    
    if( !empty($this->programs) )
    {
        $this->program_sections = Doctrine_Core::getTable('ProgramSection')->getAllProgramSections(array_keys($this->programs), $orderBy );  
    }
    
    ## Pass Program infomation 
    
    
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
    
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId); 
    
    ## Data from filter form
    $year               = $request->getParameter('year');
    $semester		= $request->getParameter('semester');
    $academicYear	= $request->getParameter('academic_year');
    $programId		= $request->getParameter('program_id');
    $centerId		= $request->getParameter('center_id');  
    $activeClass        = $request->getParameter('active_class'); 
    
    ##Check if Filter Form is Submitted
    if($year != '' || $semester != '' || $programId != '' || $academicYear != '' || $centerId != '' || $activeClass != '' )
    {
        $this->programSections = Doctrine_Core::getTable('ProgramSection')
        ->createQuery('a') ;
        
        if($programId == '')
            $this->programSections->andWhereIn('a.program_id', array_keys($this->programs)); 
        
        if($year !='' )
            $this->programSections->andWhere('a.year = ?', $year);
        if($semester !='' )
            $this->programSections->andWhere('a.semester = ?', $semester);
        if($academicYear !='' )
            $this->programSections->andWhere('a.academic_year = ?', $academicYear);        
        if($programId !='' )
            $this->programSections->andWhere('a.program_id = ?', $programId);
        if($centerId !='' )
            $this->programSections->andWhere('a.center_id = ?', $centerId);         
        if($activeClass !='' )
            $this->programSections->andWhere('a.is_activated = ?', TRUE);         
        $this->program_sections = $this->programSections->execute();                         
        
    }      
  }
  
  public function executeSectiondetail(sfWebRequest $request)
  {
      /*$programSectionId             = $request->getParameter('id'); 
      $this->showCourseOfferings    = FALSE; 
      $this->canBeDeleted           = TRUE; 
      
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($programSectionId);
      $this->forward404Unless($this->sectionDetail); 
      
      foreach($this->sectionDetail->getEnrollmentInfos() as $enrollment)
      {
           if(!SemesterActions::checkToDeleteCourseOffering($enrollment))
               $this->canBeDeleted  = FALSE;
      }
      
      ## STORE sectiondetail on session for use by promotion setting, just to display class information;
      $this->getUser()->setAttribute('sectionDetail', $this->sectionDetail); 
      
      
      if(Doctrine_Core::getTable('SectionCourseOffering')->checkIfCourseIsDefined($programSectionId))
      {
          $this->showCourseOfferings = TRUE; 
          $this->sectionSemesterCourses = Doctrine_Core::getTable('SectionCourseOffering')->getSectionSemesterCourses($programSectionId);
      }      
       * 
       */
      
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);            
    
    ## Pass Program infomation         
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);       
      
    $sectionId  = $request->getParameter('sectionId');
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);
    $this->forward404Unless($this->program_section);
    
     
    $this->hasCourseOffers            = FALSE;                   
      
    #### check if courses are defined, otherwise ####
    if($this->program_section->hasCourseOffers())  
    {
        $this->hasCourseOffers            = TRUE;
    }      
  }  
  
  public function executeProgramlevelofferingdetail(sfWebRequest $request)
  {
      $programSectionId     = $request->getParameter('id'); 
      $this->showCourseOfferings = FALSE; 
      
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($programSectionId);
      
      ## STORE sectiondetail on session for use by promotion setting, just to display class information;
      $this->getUser()->setAttribute('sectionDetail', $this->sectionDetail); 
      
      
      if(Doctrine_Core::getTable('SectionCourseOffering')->checkIfCourseIsDefined($programSectionId))
      {
          $this->showCourseOfferings = TRUE; 
          $this->sectionSemesterCourses = Doctrine_Core::getTable('SectionCourseOffering')->getSectionSemesterCourses($programSectionId);
      }
      
      /*     
       * 
       */
  }  
  
  public function executeOffersemestercourses(sfWebRequest $request)
  {    
      
    $sectionId  = $request->getParameter('sectionId');
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);
    $this->forward404Unless($this->program_section);
    
     
    $this->hasCourseOffers            = FALSE;                   
      
    #### check if courses are defined, otherwise ####
    if($this->program_section->hasCourseOffers())  
    {
        $this->hasCourseOffers            = TRUE;
    } 
    
    
    
    
      $programSectionId     = $request->getParameter('sectionId'); 
      $this->showSectionCourseOfferingForm = FALSE;
      $this->showForm = TRUE;
      
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($programSectionId);
      
      ## STORE sectiondetail on session for use by promotion setting, just to display class information;
      $this->getUser()->setAttribute('sectionDetail', $this->sectionDetail);                
      
      if($this->courseCheclistIsDefined = Doctrine_Core::getTable('CourseChecklist')
              ->checkIfCourseChecklistDefined($this->sectionDetail->getProgramId(), $this->sectionDetail->getYear(), $this->sectionDetail->getSemester()
              ) )
      {
        $this->showSectionCourseOfferingForm = TRUE; 
        $courseChecklist = Doctrine_Core::getTable('CourseChecklist')->getSemesterCourseChecklists(
                $this->sectionDetail->getProgramId(),
                $this->sectionDetail->getYear(), 
                $this->sectionDetail->getSemester()                
              ); 
        
        if($this->courseCheclistIsDefined = Doctrine_Core::getTable('SectionCourseOffering')->checkIfCourseIsDefined($programSectionId))
            $this->showForm = FALSE;    
        
        $coursesToOffer = array();
        foreach( $courseChecklist as $course )
            $coursesToOffer[$course->getCourseId()] = $course->getCourse();
        
        $this->courseChecklistForm = new FrontendCourseOfferingForm($coursesToOffer);
        
        $this->getUser()->setAttribute('coursesToOffer', $coursesToOffer); 

        
      }        
  }
  
  public function executeProgramlevelofferingnew(sfWebRequest $request)
  {
      $programId          = $request->getParameter('programId'); 
      $this->year         = $request->getParameter('year'); 
      $this->semester     = $request->getParameter('semester'); 
      
      $this->showSectionCourseOfferingForm = FALSE;
      $this->showForm = TRUE;                 
      
      $this->program = Doctrine_Core::getTable('Program')->findOneById($programId);
      $this->forward404Unless($this->program);
      
      $courseChecklist = Doctrine_Core::getTable('CourseChecklist')->getSemesterCourseChecklists($programId, $this->year, $this->semester); 
      if(!is_null($courseChecklist))
      {
        $this->showSectionCourseOfferingForm = TRUE;   
        
        $coursesToOffer = array();
        foreach( $courseChecklist as $course )
            $coursesToOffer[$course->getCourseId()] = $course->getCourse();
        $this->getUser()->setAttribute('coursesToOffer', $coursesToOffer);                         
      }    
      $this->courseChecklistForm = new FrontendCourseOfferingForm($coursesToOffer); 
      
      
      if ($request->isMethod('post'))
      {
 
        $this->courseChecklistForm->bind($request->getParameter('courseChecklist'));
        if ($this->courseChecklistForm->isValid())
        {
               ## get form values 	   
               $formData		= $this->courseChecklistForm->getValues();  
               $courseIds		= $formData['course_id'];
               if($courseIds == '' ) {
                    $this->getUser()->setFlash('error', 'Courses must be added to bucket');
                    $this->redirect('sectioncourseoffering/index');
               }

               ## checkfor each program section that course is not offered, then offer it
               $check=0;
               foreach($this->program->getProgramSections() as $ps)
               {
                   if(!Doctrine_Core::getTable('SectionCourseOffering')->checkIfCourseIsDefined($ps->getId()))
                   {
                        $numberOfAssignedCourses    = SectionCourseOffering::assignCoursesToOneSection($courseIds, $ps->getId());
                        if($numberOfAssignedCourses != 0)
                        {                         
                             $check++;
                        }                                   
                   }
               }
               
               if($check != 0)
               {
                    $newLog = new AuditLog();
                    $action = 'User has performed Course Offering at Program Level for Year'.$this->year.' Semester'.$this->semester;
                    $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);   

                    $this->getUser()->setFlash('notice', $numberOfAssignedCourses.' courses have been assigned to all sections under selected program'); 
                    $this->redirect('sectioncourseoffering/index');                    
               }
               else
               {
                    $this->getUser()->setFlash('error', 'Selected courses are already defined');  
                    $this->redirect('sectioncourseoffering/index');                   
               }
               
        }
        $this->getUser()->setFlash('error', ' Unable to save course offering, offering form was empty !'); 
        $this->redirect('sectioncourseoffering/index');  
      }
  }  
  
  public function executeDeletesemestercourses(sfWebRequest $request)
  {
      $check                = FALSE;
      $programSectionId     = $request->getParameter('sectionId');
      $oneProgramSection    = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId);
      $this->forward404Unless($oneProgramSection);
      
      if($oneProgramSection->sectionIsPromoted() )
      {
        $newLog = new AuditLog();
        $action = 'User has attempted to delete Semester Course Offerings ';
        $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);          
        $this->getUser()->setFlash('error', 'Unable to Delete, This Section Is Promoted.');
        $this->redirect('sectioncourseoffering/sectiondetail?sectionId='.$oneProgramSection->getId() );          
      } 
      
      if($oneProgramSection->hasRegisteredStudents() )
      {
        $newLog = new AuditLog();
        $action = 'User has attempted to delete Semester Course Offerings ';
        $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);          
        $this->getUser()->setFlash('error', 'Unable to Delete, there are students registered to these courses!'
                                    .'Please consider deleting student registrations first!');
        $this->redirect('sectioncourseoffering/sectiondetail?sectionId='.$oneProgramSection->getId() );          
      }    
      
      if($oneProgramSection->checkIfGradeIsSubmitted() )
      {
        $newLog = new AuditLog();
        $action = 'User has attempted to delete Semester Course Offerings ';
        $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);          
        $this->getUser()->setFlash('error', 'Unable to Delete, Grade Is Submitted For One Or All Courses.');
        $this->redirect('sectioncourseoffering/sectiondetail?sectionId='.$oneProgramSection->getId() );          
      }
      
      if(!$check)
      {
        $oneProgramSection->unofferCourses();
        $newLog = new AuditLog();
        $action = 'User has attempted to delete Semester Course Offerings ';
        $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);          
        $this->getUser()->setFlash('notice', 'Successfuly Removed Offered Courses.');
        $this->redirect('sectioncourseoffering/sectiondetail?sectionId='.$oneProgramSection->getId() );                            
      }

      
  }
  
  public function executeDeletesemestercourse(sfWebRequest $request)
  {
      $programSectionId     = $request->getParameter('sectionId');
      $courseId             = $request->getParameter('course');
      
      $oneProgramSection    = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId);
      $this->forward404Unless($oneProgramSection);      
      
      if($oneProgramSection->courseHasStudents($courseId))
      {                   
        $newLog = new AuditLog();
        $action = 'User has attempted to delete One Offered Semester Course ';
        $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);          
        $this->getUser()->setFlash('error', 'Unable To Delete This Offered Course: Course Has Registered Students');
        $this->redirect('sectioncourseoffering/sectiondetail?sectionId='.$oneProgramSection->getId() );          
      }
      else
      {
        $oneProgramSection->unofferCourse($courseId);
        
        $newLog = new AuditLog();
        $action = 'Successfully Removed One Of Offered Courses.';
        $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);          
        $this->getUser()->setFlash('notice', 'Successfuly Removed One Offered Course.');
        
        $this->redirect('sectioncourseoffering/sectiondetail?sectionId='.$oneProgramSection->getId() );           
          
      }
  }
 
  public function executeFilter(sfWebRequest $request) 
  {
    ## Data from filter form
    $year               = $request->getParameter('year');
    $semester		= $request->getParameter('semester');
    $academicYear	= $request->getParameter('academic_year');
    $programId		= $request->getParameter('program_id');
    $centerId		= $request->getParameter('center_id');
    $this->program_id   = $request->getParameter('program_id'); ##  
    
    # save above data temporarily, and delete it on the next action, 
  
  
    ## Data to redisplay the filter, later to be binded to the form 
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($this->getUser()->getAttribute('departmentId')); 
    $this->centers = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years  = FormChoices::getYearChoices();
    $this->academicYears  = FormChoices::getAcademicYear();
    $this->semesters  = FormChoices::getSemesterChoices();  
    
    	 
    ## Process filtering,
    if ($year == 0 || $semester == 0 || $programId == 0 || $academicYear == 0 || $centerId == 0) ## All fields are required
    { 
        $this->getUser()->setFlash('error', "All filters should be selected");
        $this->redirect('sectioncourseoffering/index');
    }
    else {
        # Check if section exists, or is ready!
        if(Doctrine_Core::getTable('ProgramSection')->checkIfSectionIsCreated($programId, $academicYear, $year, $semester, $centerId))
        {
            # Get sectionId and continue,
            $oneSectionDetail   = Doctrine_Core::getTable('ProgramSection')->getBatchSection($programId, $academicYear, $year, $semester, $centerId ); 
            $sectionId          = $oneSectionDetail->getId();
            if(!Doctrine_Core::getTable('EnrollmentInfo')->checkIfEnrolledToSection($programId, $academicYear, $year, $semester, $sectionId))
            {
                # So, batch is not enrolled, do enrollment here           
                $this->enrollments = Doctrine_Core::getTable('EnrollmentInfo')
                    ->getOneBatchToEnrollToSection($programId, $academicYear, $year, $semester, $centerId); 
                
                foreach( $this->enrollments as $enrollment )
                    $enrollmentInfoIds[$enrollment->getId()] = $enrollment->getStudent();                     
                $this->getUser()->setAttribute('enrollmentInfoIds', $enrollmentInfoIds );

                $sectionIds[$oneSectionDetail->getId()] = 'Default Section '.$oneSectionDetail->getSectionNumber();                     
                
                $this->getUser()->setAttribute('sectionIds', $sectionIds ); 

                ## create and pass forms here! 
                $this->studentsToEnroll = new StudentToSectionEnrollmentForm($enrollmentInfoIds, $sectionIds);                
            }
            else {
                $this->getUser()->setFlash('error', "This batch is already enrolled");
                $this->redirect('sectioncourseoffering/index');                
            }
                    
        }
        else {
            $this->getUser()->setFlash('error', "This section not yet created");
            $this->redirect('sectioncourseoffering/index');                
        }        
    }
  }
  
  public function executeSectionformfilter(sfWebRequest $request) 
  {
    ## Data from filter form
    $year               = $request->getParameter('year');
    $semester		= $request->getParameter('semester');
    $academicYear	= $request->getParameter('academic_year');
    $programId		= $request->getParameter('program_id');
    $centerId		= $request->getParameter('center_id');
    $this->program_id   = $request->getParameter('program_id'); ##  
    
    # save above data temporarily, and delete it on the next action, 
  
  
    ## Data to redisplay the filter, later to be binded to the form 
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($this->getUser()->getAttribute('departmentId')); 
    $this->centers = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years  = FormChoices::getYearChoices();
    $this->academicYears  = FormChoices::getAcademicYear();
    $this->semesters  = FormChoices::getSemesterChoices();  
    
    	 
    ## Process filtering,
    if ($year == 0 || $semester == 0 || $programId == 0 || $academicYear == 0 || $centerId == 0) ## All fields are required
    { 
        $this->getUser()->setFlash('error', "All filters should be selected");
        $this->redirect('sectioncourseoffering/sectionformfilter');
    }
    else {
        $this->getUser()->setAttribute('selectedYear', $year);
        $this->getUser()->setAttribute('selectedSemester', $semester);
        $this->getUser()->setAttribute('selectedAcademicYear', $academicYear);
        $this->getUser()->setAttribute('selectedProgramId', $programId );
        $this->getUser()->setAttribute('selectedCenterId', $centerId ); 
        
        # Check if section exists, or is ready!
        if(Doctrine_Core::getTable('ProgramSection')->checkIfSectionIsCreated($programId, $academicYear, $year, $semester, $centerId))
        {
            ## Redirect and display class information 
            $this->oneSectionDetail   = Doctrine_Core::getTable('ProgramSection')->getBatchSection($programId, $academicYear, $year, $semester, $centerId ); 
                                    
        }
        else {
            $this->getUser()->setFlash('error', "This section not yet created");
            $this->redirect('sectioncourseoffering/index');                
        }        
    }
  }    

  public function executeDoSectionCourseOffering(sfWebRequest $request)
  {
      $coursesToOffer = $this->getUser()->getAttribute('coursesToOffer');
      
      $this->courseChecklistForm = new FrontendCourseOfferingForm($coursesToOffer);
      $this->processSectionCourseOffering($request, $this->courseChecklistForm);
      $this->setTemplate('registration');    
  }  
 
  public function processSectionCourseOffering(sfWebRequest $request, sfForm $courseChecklistForm )
  {    
     $courseChecklistForm->bind($request->getParameter('courseChecklist'));
    if ($courseChecklistForm->isValid())
    {
		## get form values 	   
	   $formData		= $this->courseChecklistForm->getValues();  
	   $courseIds		= $formData['course_id'];
	   if($courseIds == NULL ) {
	   	$this->getUser()->setFlash('error', 'Courses must be added to bucket');
	   	$this->redirect('sectioncourseoffering/index');
	   }
  		           
            $section = $this->getUser()->getAttribute('sectionDetail');
            $numberOfAssignedCourses    = SectionCourseOffering::assignCoursesToOneSection($courseIds, $section->getId());
            if($numberOfAssignedCourses == 0)
                $this->getUser()->setFlash('notice', 'Selected courses are already defined');                       
            else
            {
            ##Do Logging!!
                $newLog = new AuditLog();
                $action = 'User has performed Course Offering for section ';
                $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);   
           
                $this->getUser()->setFlash('notice', $numberOfAssignedCourses.' courses have been assigned to section'); 
                $this->redirect('sectioncourseoffering/index');
            }
    }
    $this->getUser()->setFlash('error', 'System error occured !'); 
    $this->redirect('sectioncourseoffering/index');
  } 
  
  
  
  
  
  
  
  
  
  
  
  
  
  
  

  public function executeShow(sfWebRequest $request)
  {
    $this->section_course_offering = Doctrine_Core::getTable('SectionCourseOffering')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->section_course_offering);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new SectionCourseOfferingForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new SectionCourseOfferingForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($section_course_offering = Doctrine_Core::getTable('SectionCourseOffering')->find(array($request->getParameter('id'))), sprintf('Object section_course_offering does not exist (%s).', $request->getParameter('id')));
    $this->form = new SectionCourseOfferingForm($section_course_offering);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($section_course_offering = Doctrine_Core::getTable('SectionCourseOffering')->find(array($request->getParameter('id'))), sprintf('Object section_course_offering does not exist (%s).', $request->getParameter('id')));
    $this->form = new SectionCourseOfferingForm($section_course_offering);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($section_course_offering = Doctrine_Core::getTable('SectionCourseOffering')->find(array($request->getParameter('id'))), sprintf('Object section_course_offering does not exist (%s).', $request->getParameter('id')));
    $section_course_offering->delete();

    $this->redirect('sectioncourseoffering/index');
    
    $this->redirect('sectioncourseoffering/sectiondetail?id='.$section_course_offering->getId());
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $section_course_offering = $form->save();

      $this->redirect('sectioncourseoffering/edit?id='.$section_course_offering->getId());
    }
  }
}
