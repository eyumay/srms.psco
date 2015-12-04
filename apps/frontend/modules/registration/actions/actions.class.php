<?php

/**
 * registration actions.
 *
 * @package    srmsnew
 * @subpackage registration
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class registrationActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
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
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);            
    
    ## Pass Program infomation         
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);       
      
    $sectionId  = $request->getParameter('id');
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);
    $this->forward404Unless($this->program_section);      
      
      $this->showRegistrationForm       = FALSE;
      $showStudentCanRegister           = FALSE;
      $showStudentCanNotRegister        = FALSE;
      $this->showAddEnrollments         = FALSE;
      $this->sectionIsPromoted          = TRUE;
      
      $this->enrollmentsCannotRegister  = array();
      $this->enrollmentsCanRegister     = array();
      $coursesForRegistration           = array(); 
      
      $this->courseOfferingDefined      = FALSE; 
      
      ## DEPARTMENT ID FROM SESSION, USED TO FETCH PREREQUISITE COURSES LIMITED TO WORKING DEPARTMENT
      $this->departmentId                     = $this->getUser()->getAttribute('departmentId');
      
      $programSectionId     = $request->getParameter('id'); 
      
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId);
      $this->forward404Unless($this->sectionDetail); 
      
      if(Doctrine_Core::getTable('SectionCourseOffering')->checkIfCourseIsDefined($this->sectionDetail->getId() ))
      {
          $this->courseOfferingDefined = TRUE; 
          
      }
      
      //$enrolledStudentIds = Doctrine_Core::getTable('EnrollmentInfo')->getSectionEnrolledStudentIdsArray($programSectionId); 
      $enrollments = $this->sectionDetail->getEnrollmentInfos(); 
      
      $scos = Doctrine_Core::getTable('SectionCourseOffering')->getSectionSemesterCourses($programSectionId);
      $coursesForRegistration = Doctrine_Core::getTable('SectionCourseOffering')->getSectionSemesterCoursesArray($programSectionId);
      if(!$this->sectionDetail->sectionIsPromoted())
      {
        $this->sectionIsPromoted = FALSE; 
        if(!is_null($enrollments))
        {
            foreach($enrollments as $enrollment )
            {   

                if( $enrollment->getSemesterAction() == sfConfig::get('app_enrolled_semester_action') || 
                    $enrollment->getSemesterAction() == sfConfig::get('app_registered_semester_action') || 
                    $enrollment->getSemesterAction() == sfConfig::get('app_promoted_semester_action') )  ## consider only registered|Enrolled|Promoted semester actions, the rest are ADs, ....
                {
                    if($enrollment->getSemesterAction() != sfConfig::get('app_registered_semester_action') && !$enrollment->getLeftout())
                    {
                      $studentIsClear                   = TRUE; 
                      foreach($scos as $sco )
                      {
                        $pCourseIdsArray = Doctrine_Core::getTable('RelatedCourses')->getPrerequisiteCourseIdsArray($departmentId, $sco->getCourseId());
                        if(!is_null($pCourseIdsArray))
                        {
                            if(!Doctrine_Core::getTable('StudentCourseGrade')->checkIfStudentIsClearForCourses($enrollment->getStudentId(), $pCourseIdsArray) )
                            {
                                $studentIsClear = FALSE;    
                            }
                        }

                      }                  
                      if(!$studentIsClear){
                        $showStudentCanNotRegister = TRUE;
                        $this->enrollmentsCannotRegister[$enrollment->getId()]     = $enrollment->getStudent();                  
                      }
                      else {
                        $showStudentCanRegister = TRUE;
                        $this->enrollmentsCanRegister[$enrollment->getId()]     = $enrollment->getStudent();       
                      }
                      $this->showRegistrationForm = TRUE;
                    }
                }

            }

            $this->registrationForm = new CourseRegistrationForm($this->enrollmentsCanRegister, $coursesForRegistration);


           ##Checking to display if there are ADD ENROLLMENTS 
           if(Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId)->checkAddEnrollments())
           {
               $this->addEnrollments = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId)->getWithAddEnrollments();
               foreach ($this->addEnrollments->getEnrollmentInfos() as $enrollment)
               {
                   if($enrollment->getSemesterAction() != sfConfig::get('app_withdrawn_semester_action'))
                      $this->showAddEnrollments = TRUE; 
               }             
           }          
        }
      }
      
      
      
  }  

  public function executeSectionregistration(sfWebRequest $request)
  {  
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);            
    
    ## Pass Program infomation         
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);       
      
    $sectionId  = $request->getParameter('id');
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);
    $this->forward404Unless($this->program_section);      
      
      $this->showRegistrationForm       = FALSE;
      $showStudentCanRegister           = FALSE;
      $showStudentCanNotRegister        = FALSE;
      $this->showAddEnrollments         = FALSE;
      $this->sectionIsPromoted          = TRUE;
      
      $this->enrollmentsCannotRegister  = array();
      $this->enrollmentsCanRegister     = array();
      $coursesForRegistration           = array(); 
      
      $this->courseOfferingDefined      = FALSE; 
      
      ## DEPARTMENT ID FROM SESSION, USED TO FETCH PREREQUISITE COURSES LIMITED TO WORKING DEPARTMENT
      $departmentId                     = $this->getUser()->getAttribute('departmentId');
      
      $programSectionId     = $request->getParameter('id'); 
      
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId);
      $this->forward404Unless($this->sectionDetail); 
      
      if(Doctrine_Core::getTable('SectionCourseOffering')->checkIfCourseIsDefined($this->sectionDetail->getId() ))
      {
          $this->courseOfferingDefined = TRUE; 
          
      }
      
      //$enrolledStudentIds = Doctrine_Core::getTable('EnrollmentInfo')->getSectionEnrolledStudentIdsArray($programSectionId); 
      $enrollments = $this->sectionDetail->getEnrollmentInfos(); 
      
      $scos = Doctrine_Core::getTable('SectionCourseOffering')->getSectionSemesterCourses($programSectionId);
      $coursesForRegistration = Doctrine_Core::getTable('SectionCourseOffering')->getSectionSemesterCoursesArray($programSectionId);
      if(!$this->sectionDetail->sectionIsPromoted())
      {
        $this->sectionIsPromoted = FALSE; 
        if(!is_null($enrollments))
        {
            foreach($enrollments as $enrollment )
            {   

                if( $enrollment->getSemesterAction() == sfConfig::get('app_enrolled_semester_action') || 
                    $enrollment->getSemesterAction() == sfConfig::get('app_registered_semester_action') || 
                    $enrollment->getSemesterAction() == sfConfig::get('app_promoted_semester_action') )  ## consider only registered|Enrolled|Promoted semester actions, the rest are ADs, ....
                {
                    if($enrollment->getSemesterAction() != sfConfig::get('app_registered_semester_action') && !$enrollment->getLeftout())
                    {
                      $studentIsClear                   = TRUE; 
                      foreach($scos as $sco )
                      {
                        $pCourseIdsArray = Doctrine_Core::getTable('RelatedCourses')->getPrerequisiteCourseIdsArray($departmentId, $sco->getCourseId());
                        if(!is_null($pCourseIdsArray))
                        {
                            if(!Doctrine_Core::getTable('StudentCourseGrade')->checkIfStudentIsClearForCourses($enrollment->getStudentId(), $pCourseIdsArray) )
                            {
                                $studentIsClear = FALSE;    
                            }
                        }

                      }                  
                      if(!$studentIsClear){
                        $showStudentCanNotRegister = TRUE;
                        $this->enrollmentsCannotRegister[$enrollment->getId()]     = $enrollment->getStudent();                  
                      }
                      else {
                        $showStudentCanRegister = TRUE;
                        $this->enrollmentsCanRegister[$enrollment->getId()]     = $enrollment->getStudent();       
                      }
                      $this->showRegistrationForm = TRUE;
                    }
                }

            }

            $this->registrationForm = new CourseRegistrationForm($this->enrollmentsCanRegister, $coursesForRegistration);


           ##Checking to display if there are ADD ENROLLMENTS 
           if(Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId)->checkAddEnrollments())
           {
               $this->addEnrollments = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId)->getWithAddEnrollments();
               foreach ($this->addEnrollments->getEnrollmentInfos() as $enrollment)
               {
                   if($enrollment->getSemesterAction() != sfConfig::get('app_withdrawn_semester_action'))
                      $this->showAddEnrollments = TRUE; 
               }             
           }          
        }
      }
      
      
      
  }    
  
  public function executeStudentregistration(sfWebRequest $request)
  {  
    $this->drops                        = FALSE;
    $this->showRegisterWithDropLink     = FALSE;
    $this->showNormalRegistrationLink   = FALSE; 
    
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);            
    
    ## Pass Program infomation         
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);       
      
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($request->getParameter('sectionId'));
    $this->forward404Unless($this->program_section);      
    
    $this->student = Doctrine_Core::getTable('Student')->findOneById($request->getParameter('studentId'));
    $this->forward404Unless($this->student);    
    
    $this->isRegistered     = FALSE;
    $this->hasDrops         = FALSE;
    $this->hasCourseOffers  = FALSE;
    $this->studentEnrollment  = $this->program_section->getStudentEnrollmentInfo($this->student->getId());  
    if($this->studentEnrollment->isRegistered())
    {
        $this->isRegistered   = TRUE; 
    }
    else
    {
        if($this->studentEnrollment->hasPrerequisiteProblem($departmentId))
        {
            $this->hasDrops             = TRUE;
            $this->droppableCourses     = $this->studentEnrollment->getDroppableCourses($departmentId);
            $this->registrationCourses  = $this->studentEnrollment->getRegistrationCourses($departmentId); 
            if( $this->program_section->hasCourseOffers())
            {
                $this->hasCourseOffers          = TRUE; 
            }
        }        
        else
        {
            $this->registrationCourses  = $this->program_section->getCourseOffers();            
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
        $this->redirect('dropadd/sectionformfilter');
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
            $this->redirect('registration/index');                
        }        
    }
  }

  public function executeRegistration(sfWebRequest $request)
  {
    $this->registrationForm = new CourseRegistrationForm(); 
	 $this->processRegistration($request, $this->registrationForm);
	 $this->setTemplate('registration');    
  }  
 
  public function processRegistration(sfWebRequest $request, sfForm $registrationForm )
  {    
    $registrationForm->bind($request->getParameter('courseregistrationform'));
    if ($registrationForm->isValid())
    {
		## get form values 	   
	   $formData            = $this->registrationForm->getValues();  
	   $courseIds		= $formData['course_id'];
	   $enrollmentInfoIds	= $formData['student_id'];
	   
           if($courseIds == '' || $enrollmentInfoIds == '')
           {
                $this->getUser()->setFlash('error', 'Error occured, please redo actions ');
                $this->redirect('registration/index');               
           }
           
	   foreach( $enrollmentInfoIds as $enrollmentId )
	   {
               $enrollmentDetail = Doctrine_Core::getTable('EnrollmentInfo')
                       ->findOneStudentEnrollmentInforById($enrollmentId);
                   $sectionId       = $enrollmentDetail->getSectionId(); 
                   $enrollmentDetail->updateEnrollmentSemesterAction(sfConfig::get('app_registered_semester_action')); 
		   $registration	= new Registration();
		   $registration->setEnrollmentInfoId($enrollmentId);
		   $registration->setDate(date('m-d-Y'));
		   $registration->save(); 	   	
		   foreach($courseIds as $courseId)
		   {
		   	$studentCourse	= new StudentCourseGrade();
		   	$studentCourse->setCourseId($courseId);
		   	$studentCourse->setRegistrationId($registration->getId());
		   	$studentCourse->setStudentId(Doctrine_Core::getTable('EnrollmentInfo')->getEnrollmentDetailById($enrollmentId)->getStudentId());
		   	$studentCourse->save();
		   }                   
	   }
           
                $newLog = new AuditLog();
                $action = 'User has Registered Students Student Record Management System';
                $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);               
            $this->getUser()->setFlash('notice', 'Student Registration was successfull ');
            $this->redirect('registration/sectiondetail?id='.$sectionId);
            ## Check filter combination availability [program_id, academic_year, year, semester], then return section]   

    }
  }  
  
  public function executeRegisterwithadd(sfWebRequest $request )
  {
      $courseToAddRegisterArray = array();
      ##get course and enrollmentInfoObj for Add Registration
      $courseToAddRegisterArray[] = $request->getParameter('courseId');
      
      
      $enrollmentInfoObjToAdd = Doctrine_Core::getTable('EnrollmentInfo')->findOneById($request->getParameter('enrollmentId'));
      $this->forward404Unless($enrollmentInfoObjToAdd);
      
      ##Disable previous course
      $oneScg = Doctrine_Core::getTable('StudentCourseGrade')->getOneStudentOneCourseGrade($enrollmentInfoObjToAdd->getStudentId(), $request->getParameter('courseId'));
      $this->forward404Unless($oneScg);      
      $oneScg->setIsCalculated(FALSE); 
      $oneScg->save();
      
      $addRegistration = new Registration();            
      $anyValue = $addRegistration->doRegistration(sfConfig::get('app_add_registration'), $enrollmentInfoObjToAdd, $courseToAddRegisterArray);
      
      ## clear attributes holding session values
      $this->getUser()->getAttributeHolder()->remove('courseIdToAdd');
      $this->getUser()->getAttributeHolder()->remove('enrollmentInfoObjToAdd');
      
                $newLog = new AuditLog();
                $action = 'User Registered Student With Add System - Student has Added Course';
                $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);    
      
      $this->getUser()->setFlash('notice', 'Registration was successfull '.$anyValue);
      $this->redirect('registration/index');
  }
  
  public function executeRegisterwithdrop(sfWebRequest $request )
  {
        $errmsg                   = '';
        $msg                      = ''; 
        $departmentId             = $this->getUser()->getAttribute('departmentId');      
        $program_section          = Doctrine_Core::getTable('ProgramSection')->findOneById($request->getParameter('sectionId'));
        $this->forward404Unless($program_section);      
        $student                  = Doctrine_Core::getTable('Student')->findOneById($request->getParameter('studentId'));
        $this->forward404Unless($student);

        $currentEnrollment        = $program_section->getStudentEnrollmentInfo($student->getId());
        $courseIdsArrayToRegister = $currentEnrollment->getRegistrationCourses($departmentId);
        $courseIdsArrayToDrop     = $currentEnrollment->getDroppableCourses($departmentId);

        if(is_null($courseIdsArrayToRegister))
          $errmsg               .= ' [Code 1]  - System Cannot Locate Allowable Registration Courses';          
        if(is_null($courseIdsArrayToDrop))
          $errmsg               .= ' [Code 2] - System Cannot Locate Droppable Courses';                                  
        if($errmsg != '')
          $this->redirect('registration/studentregistration?sectionId='.$program_section->getId().'&studentId='.$student->getId());      
                  
        if($student->registerWithDrop($program_section->getId(), $courseIdsArrayToRegister, $courseIdsArrayToDrop))
            $msg                .= 'Semester Registration With Postrequisite Drop Was Successful.';
        else
            $errmsg             .= 'Registration With Drop Was Not Successful.';                             

        
        if($errmsg != '')      
        {
            $this->getUser()->setFlash('error', $errmsg.' Notices: '.$msg);
            $this->redirect('registration/studentregistration?sectionId='.$program_section->getId().'&studentId='.$student->getId());
        }
        if($msg != '')
        {
            $this->getUser()->setFlash('notice', $msg);
            $this->redirect('registration/studentregistration?sectionId='.$program_section->getId().'&studentId='.$student->getId());          
        }
  }
  
  public function executeRegister(sfWebRequest $request )
  {     
        $program_section          = Doctrine_Core::getTable('ProgramSection')->findOneById($request->getParameter('sectionId'));
        $this->forward404Unless($program_section);      
        $student                  = Doctrine_Core::getTable('Student')->findOneById($request->getParameter('studentId'));
        $this->forward404Unless($student);   
        $courseIdsArrayToRegister = $program_section->getCourseOffers();


        if(is_null($courseIdsArrayToRegister)){  
          $this->getUser()->setFlash('error', ' [Code 1]  - System Unable To Locate Allowable Registration Courses');
          $this->redirect('registration/studentregistration?sectionId='.$program_section->getId().'&studentId='.$student->getId());  
        }                             
        
        if($student->register($program_section->getId(), $courseIdsArrayToRegister))
        {
            $this->getUser()->setFlash('notice', 'Registration Was Successful,');
            $this->redirect('registration/studentregistration?sectionId='.$program_section->getId().'&studentId='.$student->getId());            
        }
        else
        {
            $this->getUser()->setFlash('error', 'Error With Student Registration.');
            $this->redirect('registration/studentregistration?sectionId='.$program_section->getId().'&studentId='.$student->getId());            
        }                            
  }  
}
