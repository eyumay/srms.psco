<?php

/**
 * submitgrade actions.
 *
 * @package    srmsnew
 * @subpackage submitgrade
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class submitgradeActions extends sfActions
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
    $departmentId   = $this->getUser()->getAttribute('departmentId');
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
      
    $sectionId  = $request->getParameter('sectionId');
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);
    $this->forward404Unless($this->program_section);
    
     
    $this->courseIsDefined            = FALSE;                   
    $this->studentsAreEnrolled        = FALSE;
    
    $this->enrollmentsCannotRegister  = array();
    $this->enrollmentsCanRegister     = array();
    $this->coursesWithPrerequisites   = array();
      
    #### check if courses are defined, otherwise ####
    if($this->program_section->hasCourseOffers())  
    {
        $this->courseIsDefined            = TRUE;
    }
    
    ## check IF Section Is Registered For Given Course
      
      
     /* 
      //$programSectionId     = $request->getParameter('id'); 
      
      //$this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($programSectionId);
      //$this->getUser()->setAttribute('sectionDetail', $this->sectionDetail); 
      
          
      if( Doctrine_Core::getTable('EnrollmentInfo')
                ->checkToSectionEnrollment($this->program_section->getId()))
      {
        if(Doctrine_Core::getTable('SectionCourseOffering')->checkIfCourseIsDefined( $this->program_section->getId() ))  
        {          
            $this->studentsAreEnrolled    = TRUE;          
            if(Doctrine_Core::getTable('EnrollmentInfo')->checkIfRegistered( $this->program_section->getId() ))           
            {
                $this->coursesToOffer   = Doctrine_Core::getTable('SectionCourseOffering')
                                ->getOneBatchOneSemesterCourses($this->program_section->getId());     
                $this->courseIsDefined        = TRUE;   
            }
            else {
              $this->getUser()->setFlash('notice', 'This batch is NOT REGISTERED to Semester Courses, please go to Registration!');
              $this->redirect('submitgrade/index');  
            }
        }
        else {
           $this->getUser()->setFlash('error', 'No Students to submit grade!');
          $this->redirect('submitgrade/index');           
        }
      }
      else {
         $this->getUser()->setFlash('error', 'No Courses Defined !');
         $this->redirect('submitgrade/index');             
      }  

     */
      
  } 

  public function executeEntergrade(sfWebRequest $request)
  {
      $programSectionId             = $request->getParameter('sectionId'); 
      $courseId                     = $request->getParameter('courseId'); 
      $this->studentIdsArray        = array(); 
      $this->studentIdNamePairArray = array(); 
      $this->enrollmentIdNamePairArray = array();
      $enrollmentIdsArray           = array();
      
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
      
      
      
      
      $this->courseDetail = Doctrine_Core::getTable('Course')->findOneById($courseId);
      $this->forward404Unless($this->courseDetail);
      
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId)->getWithCourseStudents($courseId); 
      $this->forward404Unless($this->sectionDetail);
      
      $this->getUser()->setAttribute('sectionStudentsForGradeSubmission', $this->sectionDetail); 
      
      foreach($this->sectionDetail->getEnrollmentInfos() as $enrollment)    
      {
         $this->enrollmentIdNamePairArray[$enrollment->getId()]= $enrollment->getStudent();             
         $enrollmentIdsArray[] = $enrollment->getId();
      }
      
      $gradeChoices     = submitgradeActions::getGradeChoicesAsArray(
                                    Doctrine_Core::getTable('Grade')->getAllLetterGradeChoices());   
      $this->gradeForm        = new FrontendGradeSubmissionForm($this->enrollmentIdNamePairArray, $this->courseDetail->getId(),$gradeChoices);      
      
      ## KEEP IN SESSION GRADE FORM DATAS FOR LATER USE,
      $this->getUser()->setAttribute('courseId', $this->courseDetail->getId());
      $this->getUser()->setAttribute('studentIdNamePairArray', $this->enrollmentIdNamePairArray);
      $this->getUser()->setAttribute('sectionId',$programSectionId );    
      $this->getUser()->setAttribute('enrollmentIdsArray',$enrollmentIdsArray);
  }

  public function executeViewCourseGrade(sfWebRequest $request)
  {
      
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);            
    
    ## Pass Program infomation         
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
    $this->programs         = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);       
      
    $sectionId              = $request->getParameter('sectionId');
    $courseId               = $request->getParameter('courseId');
    
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);
    $this->forward404Unless($this->program_section);
    $this->course = Doctrine_Core::getTable('Course')->findOneById($courseId);
    $this->forward404Unless($this->course);
    
    ## check if valid course is being requested 
    if(!$this->program_section->courseIsOffered($courseId))  
    {
        $this->getUser()->setFlash('error', 'Invalid Request, If You Think This Is Unappropriates System Feedback, Please Contact The DB Administrator.');
        $this->redirect('submitgrade/sectiondetail?sectionId='.$sectionId); 
    } 
    
    ## check If Course Has Students
    if(!$this->program_section->courseHasStudents($courseId))  
    {
        $this->getUser()->setFlash('error', 'Requested Course Does Not Have Registered Students');
        $this->redirect('submitgrade/sectiondetail?sectionId='.$sectionId); 
    }    
    
    if(!$this->program_section->courseHasGrade($courseId))  
    {
        $this->getUser()->setFlash('error', 'Requested Course Does Not Have Grades');
        $this->redirect('submitgrade/sectiondetail?sectionId='.$sectionId); 
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
        $this->redirect('submitgrade/index');
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
                $this->redirect('submitgrade/index');                
            }
                    
        }
        else {
            $this->getUser()->setFlash('error', "This section not yet created");
            $this->redirect('submitgrade/index');                
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
        $this->redirect('submitgrade/sectionformfilter');
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
            $this->redirect('submitgrade/index');                
        }        
    }
  }     
  
  public function executeFilterresult(sfWebRequest $request)
  {
      $this->gradeFilterForm = new FilterForm($this->getUser()->getAttribute('departmentId'));
      $this->processFilterresult($request, $this->gradeFilterForm);
      $this->setTemplate('filterresult');
  }

  public function processFilterresult(sfWebRequest $request, sfForm $gradeFilterForm )
  {
    $gradeFilterForm->bind($request->getParameter('filterform'));
    
    if ($gradeFilterForm->isValid())
    {
        ## get form values
	$formData		= $this->gradeFilterForm->getValues();
	$programId		= $formData['program_id'];
	$academicYear           = $formData['academic_year'];
	## passing $academicYear creates a problem on URL, so pass it using session
	$this->getUser()->setAttribute('academicYear', $academicYear);
         
	$year                   = $formData['year'];
	$semester		= $formData['semester'];
        $centerId               = $formData['center_id'];

        ## Redirect to other page, to show form to submit grade            
        $this->redirect('submitgrade/showgradesubmission?programId='.$programId.'&year='.$year.'&semester='.$semester.'&centerId='.$centerId);                      
    }
  }  

  public function executeDogradesubmission(sfWebRequest $request)
  {
      $programSectionId             = $request->getParameter('sectionId'); 
      $courseId                     = $request->getParameter('courseId'); 
      $this->studentIdsArray        = array(); 
      $this->studentIdNamePairArray = array(); 
      $this->enrollmentIdNamePairArray = array();
      $enrollmentIdsArray           = array();
      
      $departmentId   = $this->getUser()->getAttribute('departmentId');
      $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);            
    
      ## Pass Program infomation         
      $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
      $this->years            = FormChoices::getYearChoices();
      $this->academicYears    = FormChoices::getAcademicYear();
      $this->semesters        = FormChoices::getSemesterChoices();      
      $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);       
      
      //$sectionId  = $request->getParameter('sectionId');
      //$this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);
      //$this->forward404Unless($this->program_section);      
      
    ## Also show filter form
    $this->gradeFilterForm = new FilterForm($this->getUser()->getAttribute('departmentId'));
    ## Recreate the GRADE SUBMISSION Form,
    $this->gradeForm = new FrontendGradeSubmissionForm(
            $this->getUser()->getAttribute('studentIdNamePairArray'), 
            $this->getUser()->getAttribute('courseId'),
            $this->gradeChoices     = submitgradeActions::getGradeChoicesAsArray(Doctrine_Core::getTable('Grade')->getAllLetterGradeChoices())
    ); 
    
    $this->processDogradesubmission($request, $this->gradeForm);
    
    $this->setTemplate('dogradesubmission');    
  }

  public function processDogradesubmission( sfWebRequest $request, sfForm $gradeForm )
  { 
    $gradeForm->bind($request->getParameter('gradeform'));
    if ($gradeForm->isValid())
    {
        ## get form values 	   
	$formData                   = $this->gradeForm->getValues(); 
        //$enrollmentGradeIdPair      = $formData['grade']
        $courseId                   = $formData['course_id'];
        
        
        # GET sessions and delete them, 
        $sectionDetail = $this->getUser()->getAttribute('sectionStudentsForGradeSubmission'); 
        $sectionId = $this->getUser()->getAttribute('sectionId'); 
        
        $courseDetail = Doctrine_Core::getTable('Course')->findOneById($courseId); 
        $enrollmentIdsArray = $this->getUser()->getAttribute('enrollmentIdsArray'); 
        $this->forward404Unless($courseDetail); 
        ##update only EnrollmentInfo
        foreach($enrollmentIdsArray as $enrollmentId)
        { 
                    $gradeId      = $formData['grade_id_'.$enrollmentId];
                    $enrollmentTosave = Doctrine_Core::getTable('EnrollmentInfo')->findOneById($enrollmentId); 
                    $this->forward404Unless($enrollmentTosave); 
                    
                    $gradeDetail = Doctrine_Core::getTable('Grade')->findOneById($gradeId); 
                    $this->forward404Unless($gradeDetail);                    
                    
                    $enrollmentTosave->updateEnrollmentInfoForGradeSubmission($courseDetail, $gradeDetail);
                    
        }
        
        foreach($enrollmentIdsArray as $enrollmentId)
        {  
            $gradeId      = $formData['grade_id_'.$enrollmentId];
            $enrollmentTosave = Doctrine_Core::getTable('EnrollmentInfo')->findOneById($enrollmentId)->getWithStudentCourseGrade($sectionId, $courseId); 
            $this->forward404Unless($enrollmentTosave); 
            
            foreach($enrollmentTosave->getRegistrations() as $registration)
            {
                foreach($registration->getStudentCourseGrades() as $scg )
                {                                                                                 
                    $scg->updateGrade($gradeId);  
                    $scg->updateGradeStatus($gradeId);  
                }
            }
        } 
        
        ##update SectionCourseOffering that grade has been submitted ... 
        $sectionCourseOffering = Doctrine_Core::getTable('SectionCourseOffering')->getOneSectionsOneCourse($sectionId, $courseId);
        $sectionCourseOffering->updateCourseGradeStatusGradeSubmitted();
        	
           ##Do Logging!!
           $newLog = new AuditLog();
           $action = 'User has submitted Student Grades';
           $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);
        
  	$this->getUser()->setFlash('notice', 'Grade submission was successfull ');
  	$this->redirect('submitgrade/sectiondetail/?sectionId='.$sectionId);  
    }
  }        

  public static function getGradeChoicesAsArray($gradeObject = NULL )
  {
      $gradeChoices     = array();
      $gradeChoices['']  = " --- Select grade --- " ; 
      foreach($gradeObject as $gradeObj )
          $gradeChoices[$gradeObj->getId()] = $gradeObj->getGradeChar();
        
      return $gradeChoices;
  }  
}
