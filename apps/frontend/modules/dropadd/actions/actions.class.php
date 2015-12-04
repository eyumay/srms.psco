<?php

/**
 * dropadd actions.
 *
 * @package    srmsnew
 * @subpackage dropadd
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dropaddActions extends sfActions
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
      $this->courseOfferingDefined = FALSE; 
      $leftout = FALSE;
      
      $this->program_section  = Doctrine_Core::getTable('ProgramSection')->findOneById($request->getParameter('id'));
      $this->forward404Unless($this->program_section);      
  }  
  
  public function executeStudentdropadd(sfWebRequest $request)
  {
        $this->courseOfferingDefined      = FALSE; 
        $this->showChecklist              = FALSE; 
        $this->showAdds                   = FALSE;
        $this->showDrops                  = FALSE;
        $this->showExemptions             = FALSE;
        $this->showDropRegistrationLink   = FALSE; 
        $this->isRegistered               = FALSE; 
        $this->showRegistrations          = FALSE;
        $this->showCourseChecklists       = FALSE;                                

        $this->semesterChecklists         = array();
        $this->semesterAdds               = array();
        $this->semesterDrops              = array();
        $this->semesterExemptions         = array();
        $this->semesterRegistrations      = array(); 
        $this->coursesChecklists          = array();
        $pCourseIdsArray                  = array();
        $normalCourse                     = array();
        $droppableCourse                  = array();     


        $programSectionId = $request->getParameter('sectionId'); 
        $studentId        = $request->getParameter('studentId'); 
        $enrollmentId     = $request->getParameter('enrollmentId'); 

        $this->sectionId = $request->getParameter('sectionId'); 
        $this->studentId        = $request->getParameter('studentId'); 
        $this->enrollmentId     = $request->getParameter('enrollmentId'); 

        $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId);
        $this->forward404Unless($this->sectionDetail); 

        $this->student = Doctrine_Core::getTable('Student')->findOneById($studentId)->getEverything();
        $this->forward404Unless($this->student);
      
        if(!is_null($this->student))
        {
            ## student is available, 
            foreach($this->student->getEnrollmentInfos() as $enrollment)
            {
                if($enrollment->getSectionId() == $this->sectionDetail->getId())
                {                
                    if($enrollment->getSemesterAction() == 1 && !$enrollment->getLeftout() )
                        $this->isRegistered = TRUE; 
                    else
                        $this->showDropRegistrationLink = TRUE;                                          
                    foreach($enrollment->getRegistrations() as $registration )
                    {
                        foreach($registration->getStudentCourseGrades() as $scg)
                        {

                            if($scg->getIsCalculated() && !$scg->getIsAdded() )
                            {
                                $this->showRegistrations = TRUE;
                                $this->semesterRegistrations[$scg->getCourseId()] = $scg->getCourse(); 
                            }
                            if($scg->getIsAdded()){
                                $this->showAdds = TRUE;
                                $this->semesterAdds[$scg->getCourseId()] = $scg->getCourse();
                            }
                            if($scg->getIsDropped()){
                                $this->showDrops = TRUE;
                                $this->semesterDrops[$scg->getCourseId()] = $scg->getCourse();
                            }
                            if($scg->getIsExempted()){
                                $this->showExemptions = TRUE;
                                $this->semesterExemptions[$scg->getGrade()] = $scg->getCourse();
                            }                                                        
                        }

                    }
                } 
                if($enrollment->getSectionId() != $this->sectionDetail->getId() && !$enrollment->getLeftout() )
                {
                    foreach($enrollment->getRegistrations() as $rg)
                    {
                        foreach($rg->getStudentCourseGrades() as $scg)
                        {
                            if($scg->getIsCalculated() && !$scg->getIsDropped() && !$scg->getIsAdded() && !$scg->getIsExempted() && $scg->getGrade() =='F' )
                            {
                                $this->coursesChecklists[$scg->getCourseId()] = $scg->getCourse(); 
                                $this->showCourseChecklists = TRUE; 
                            }
                        }
                    }
                }                  
            }
      }
      else
      {
          ##nothing to show
      }
      
      if(Doctrine_Core::getTable('SectionCourseOffering')->checkIfCourseIsDefined($this->sectionDetail->getId() ))
      {
          $this->courseOfferingDefined = TRUE; 
          
      }
      
      
      
      
      
      
      if($this->courseOfferingDefined && !$this->isRegistered )
      {
          $scos = Doctrine_Core::getTable('SectionCourseOffering')->getSectionSemesterCourses($programSectionId);
          foreach($scos as $sco)
          {
              $pCourseIdsArray = Doctrine_Core::getTable('RelatedCourses')->getPrerequisiteCourseIdsArray($sco->getCourseId());
              if(!is_null($pCourseIdsArray))
              {
                  if(Doctrine_Core::getTable('StudentCourseGrade')->checkIfStudentIsClearForCourses($studentId, $pCourseIdsArray) )
                  {
                      $normalCourse[] = $sco->getCourseId();
                      $this->showChecklist = TRUE; 
                  }
                  
                  else
                      $droppableCourse[] = $sco->getCourseId();
              }
              else ## course do not have prerequisite
                  $normalCourse[] = $sco->getCourseId(); 
          }
          if(is_null($droppableCourse))
              $this->showDropRegistration = FALSE; ##Prevent drop registration if student do not have detected droppable courses
          
          
          $this->getUser()->setAttribute('normalCourse', $normalCourse);
          $this->getUser()->setAttribute('droppableCourse', $droppableCourse);
      }
                
  }    
  public function executeAdd(sfWebRequest $request)
  {
      $this->failedCoursesIdNamePairArray   = array(); 
      $failedCourseIdsArray           = array();
      $this->programSectionsIdNamePairArray           = array();
      $this->coursePoolsArray               = array();
      $this->showFailedCourses              = FALSE;
      $this->showClearanceEnrollmentForm    = FALSE; 
      $this->showAddEnrollmentForm    = FALSE;       
      
      
      $this->programSectionId   = $request->getParameter('sectionId'); ##SECTION
      $this->studentId          = $request->getParameter('studentId'); ##STUDENT
      $this->courseId          = $request->getParameter('courseId');##COURSE BEING ADDED
      ##1 
      $this->sectionDetail      = Doctrine_Core::getTable('ProgramSection')->findOneById($this->programSectionId); ##GET SECTION
      $this->forward404Unless($this->programSectionId); 
      ##2 && 3
      $this->student = Doctrine_Core::getTable('Student')->findOneById($this->studentId)->getWithActiveCourses();
      $this->forward404Unless($this->student); 
      ##4
      $this->courseDetail = Doctrine_Core::getTable('Course')->findOneById($this->courseId);
      $this->forward404Unless($this->courseDetail); 
      
      $this->failedCoursesIdNamePairArray[$this->courseDetail->getId()] = $this->courseDetail->getName();      
      
      
      
      //$this->studentInfo = $this->student->getSectionEnrollmentInfo($this->sectionDetail->getId());
      
      $coursesInPool = Doctrine_Core::getTable('CoursePool')->getCoursesInCoursePool();  
      if(!(is_null($coursesInPool))) {          
        foreach($coursesInPool as $coursePool )
            $this->coursePoolsArray[] = $coursePool->getCourseId();
      }
      
      #1. Display Failed courses!
      foreach($this->student->getEnrollmentInfos() as $enrollment )
      {
          foreach($enrollment->getRegistrations() as $registration ) {
              foreach($registration->getStudentCourseGrades() as $scg ) {
                  if($scg->checkIfStudentCourseIsFailed()) {
                      $this->showFailedCourses    = TRUE;
                        if (!(in_array($scg->getCourseId(), $this->coursePoolsArray))){
                            
                            $failedCourseIdsArray[] = $scg->getCourseId();                            
                        }
                  }
              }
          }                    
       }
      
      if($this->showFailedCourses)
      {
          #Get ProgramSections offering these courses!
          $departments = Doctrine_Core::getTable('Department')->getAllDepartments(); 
          $this->forward404Unless($departments); 
          
          foreach($departments as $department)
          {
              if($department->checkCourseOffering($failedCourseIdsArray, $this->sectionDetail->getId()) )
              {         
                $this->showClearanceEnrollmentForm = TRUE; 
                foreach($department->getWithActiveProgramSectionCourseOfferings($failedCourseIdsArray, $this->sectionDetail->getId())->getPrograms() as $program)  
                {
                    foreach($program->getProgramSections() as $programSection)
                    {
                        $section = $programSection->getProgram().' at '.$programSection->getCenter().' center, Year-'.$programSection->getYear().' Sem-'.$programSection->getSemester();
                        $this->programSectionsIdNamePairArray[$programSection->getId()] = $section;
                        
                    }
                }
              }
          }
          
      }
      ##Display form if there are available active sections!
      if($this->showClearanceEnrollmentForm)
          $this->courseAddEnrollmentForm = new FrontendCourseAddEnrollmentForm ($this->student->getId(), $this->programSectionsIdNamePairArray, $this->failedCoursesIdNamePairArray, sfConfig::get('app_clearance_enrollment'));
      
      
      
      
      if($request->isMethod('POST'))
      {
         $this->courseAddEnrollmentForm->bind($request->getParameter('courseaddenrollmentform'));
         if ($this->courseAddEnrollmentForm->isValid())
         {
	    $formData            = $this->courseAddEnrollmentForm->getValues();
            
            $courseId           = $formData['course_id'];
            $sectionId          = $formData['section_id'];
            $enrollmentAction   = $formData['enrollment_action'];
            $studentId          = $formData['student_id'];
            
            if($courseId == '' || $sectionId == '' || $enrollmentAction == '' || $studentId == '')
            {
                $this->getUser()->setFlash('error', 'Error with Add Form'); 
                $this->redirect('dropadd/add/?studentId='.$this->student->getId().'&sectionId='.$this->sectionDetail->getId());
            }
            
            ## 1. find enrollment for the course to clear
            $studentWithEnrollment = Doctrine_Core::getTable('Student')->findOneById($studentId)->getEnrollmentInfoByCourse($courseId);
            $this->forward404Unless($studentWithEnrollment);             
            
            foreach($studentWithEnrollment->getEnrollmentInfos() as $enrollment)
                $studentCourseEnrollment = $enrollment;
                       
            
            ## 2. find section to which student is going to enrolled to
            $newSection  = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);
            $this->forward404Unless($newSection);
            
            #makeEnrollment
            $newEnrollment = new EnrollmentInfo();
            $newEnrollment->makeEnrollment($studentCourseEnrollment, $this->sectionDetail->getAcademicYear(), $this->sectionDetail->getYear(), $this->sectionDetail->getSemester(), $newSection->getId(), $enrollmentAction);
            $newEnrollment->save();
            
            ## 2. createCoursePool
            $coursePool = new CoursePool();
            $coursePool->createCoursePool($newEnrollment->getId(), $courseId); 
            $coursePool->save(); 

            ##Do Logging!!
           $newLog = new AuditLog();
           $action = 'User has performed add enrollment for student ';
           $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);           
            
            $this->getUser()->setFlash('notice', 'Add was successful - studentId:'.$studentId.' courseId:'.$courseId.' sectionId:'.$sectionId.' enrollmentAction:'.$enrollmentAction); 
            $this->redirect('dropadd/sectiondetail/?id='.$this->sectionDetail->getId());
         }
         else
            $this->getUser()->setFlash('error', 'Error with Add Form'); 
      }
      
      
  }  
  
  public function executeDrop(sfWebRequest $request)
  {      
      $this->program_section        = Doctrine_Core::getTable('ProgramSection')->findOneById($request->getParameter('id'));
      $this->forward404Unless($this->program_section);
      
      if($this->program_section->isRegistered())
      {   
          if(!$this->program_section->checkIfGradeIsSubmitted())
          {
            $registeredCourseIdsArray     = $this->program_section->getCourseOffers(); 
            $registeredStudentIdsArray    = $this->program_section->getRegisteredStudents();    
            $this->studentCourseDropForm = new FrontendCourseDropAddForm($registeredStudentIdsArray, $registeredCourseIdsArray); 


            if ($request->isMethod('post'))
            {

              $this->studentCourseDropForm->bind($request->getParameter('studentCourseDropForm'));
              if ($this->studentCourseDropForm->isValid())
              {
                     ## get form values 	   
                     $formData		= $this->studentCourseDropForm->getValues();  
                     $studentIds        = $formData['student_id']; 
                     $courseIds		= $formData['course_id'];                    
                     if($courseIds == '' | $studentIds == '') {
                          $this->getUser()->setFlash('error', 'Courses must be added to bucket');
                          $this->redirect('dropadd/drop?id='.$this->program_section->getId());
                     }
                    
                    ## GET COURSE IDS NAME PAIR FROM COURSE IDS
                    $courseIdsArrayToDrop = CourseTable::getCourseIdsNameArray($courseIds); 
                    if(is_null($courseIdsArrayToDrop))
                    {
                        $this->getUser()->setFlash('error', ' Error With Course: System Unable To Locate Selected Courses In System'); 
                        $this->redirect('dropadd/drop?id='.$this->program_section->getId());                         
                    }
                        
                    foreach($studentIds as $studentId)
                    {
                        $student    = Doctrine_Core::getTable('Student')->findOneById($studentId);                                                
                        if(!$student->drop($this->program_section->getId(), $courseIdsArrayToDrop))
                        {
                          $this->getUser()->setFlash('error', 'Drop Process Aborted');
                          $this->redirect('dropadd/drop?id='.$this->program_section->getId());                            
                        }
                    }
                     
                    $this->getUser()->setFlash('notice', ' Drop Was Successful!'); 
                    $this->redirect('dropadd/sectiondetail?id='.$this->program_section->getId());                      

              }
              else
              {
                $this->getUser()->setFlash('error', ' Error With The Form'); 
                $this->redirect('dropadd/drop?id='.$this->program_section->getId());                   
              }
 
            }
          }
          else
          {
            $this->getUser()->setFlash('error', ' Drop Not Allowed After Grade Submission !'); 
            $this->redirect('dropadd/sectiondetail?id='.$this->program_section->getId());                        
          }
      }
      else
      {
          $this->getUser()->setFlash('error', ' Drop Not Allowed When Students Are Not Registered !'); 
          $this->redirect('dropadd/sectiondetail?id='.$this->program_section->getId());          
      }
  }
  public function executeStudentdrop(sfWebRequest $request)
  {      
      $this->program_section        = Doctrine_Core::getTable('ProgramSection')->findOneById($request->getParameter('sectionId'));
      $this->forward404Unless($this->program_section);
      $this->student        = Doctrine_Core::getTable('Student')->findOneById($request->getParameter('studentId'));
      $this->forward404Unless($this->student);         
      
      if($this->program_section->isRegistered())
      {   
          if(!$this->program_section->checkIfGradeIsSubmitted())
          {
            $registeredCourseIdsArray     = $this->student->getRegisteredCourses($this->program_section->getId()); 
            $registeredStudentIdsArray    = $this->student->getStudentIdNamePair();    
            $this->studentCourseDropForm = new FrontendCourseDropAddForm($registeredStudentIdsArray, $registeredCourseIdsArray); 


            if ($request->isMethod('post'))
            {

              $this->studentCourseDropForm->bind($request->getParameter('studentCourseDropForm'));
              if ($this->studentCourseDropForm->isValid())
              {
                     ## get form values 	   
                     $formData		= $this->studentCourseDropForm->getValues();  
                     $studentIds        = $formData['student_id']; 
                     $courseIds		= $formData['course_id'];                    
                     if($courseIds == '' | $studentIds == '') {
                          $this->getUser()->setFlash('error', 'Courses must be added to bucket');
                          $this->redirect('dropadd/studentdrop?sectionId='.$this->program_section->getId().'&studentId='.$this->student->getId());
                     }
                    
                    ## GET COURSE IDS NAME PAIR FROM COURSE IDS
                    $courseIdsArrayToDrop = CourseTable::getCourseIdsNameArray($courseIds); 
                    if(is_null($courseIdsArrayToDrop))
                    {
                        $this->getUser()->setFlash('error', ' Error With Course: System Unable To Locate Selected Courses In System'); 
                        $this->redirect('dropadd/studentdrop?sectionId='.$this->program_section->getId().'&studentId='.$this->student->getId());                         
                    }
                        
                    foreach($studentIds as $studentId)
                    {
                        $student    = Doctrine_Core::getTable('Student')->findOneById($studentId);                                                
                        if(!$student->drop($this->program_section->getId(), $courseIdsArrayToDrop))
                        {
                          $this->getUser()->setFlash('error', 'Drop Process Aborted, May Be You Are Dropping The Same Course Again');
                          $this->redirect('dropadd/sectiondetail?id='.$this->program_section->getId());                            
                        }
                    }
                     
                    $this->getUser()->setFlash('notice', ' Drop Was Successful!'); 
                    $this->redirect('dropadd/sectiondetail?id='.$this->program_section->getId());                      

              }
              else
              {
                $this->getUser()->setFlash('error', ' Error With The Form'); 
                $this->redirect('dropadd/studentdrop?sectionId='.$this->program_section->getId().'&studentId'.$this->student->getId());
              }
 
            }
          }
          else
          {
            $this->getUser()->setFlash('error', ' Drop Not Allowed After Grade Submission !'); 
            $this->redirect('dropadd/sectiondetail?id='.$this->program_section->getId());                        
          }
      }
      else
      {
          $this->getUser()->setFlash('error', ' Drop Not Allowed When Students Are Not Registered !'); 
          $this->redirect('dropadd/sectiondetail?id='.$this->program_section->getId());          
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
            $this->redirect('dropadd/index');                
        }        
    }
  }

  public function executeDropcourse(sfWebRequest $request)
  {
    $this->studentCourseDropForm = new FrontendCourseDropAddForm(); 
	 $this->processDropcourse($request, $this->studentCourseDropForm);
	 $this->setTemplate('drop');    
  }  
 
  public function processDropcourse(sfWebRequest $request, sfForm $studentCourseDropForm )
  {    
    $studentCourseDropForm->bind($request->getParameter('studentCourseDropForm'));
    if ($studentCourseDropForm->isValid())
    {
		## get form values 	   
	   $formData            = $this->studentCourseDropForm->getValues();  
	   $courseIds		= $formData['course_id'];
	   $studentId           = $formData['student_id'];
	   
           if($courseIds == '' || $studentId == '')
           {
                $this->getUser()->setFlash('error', 'Error occured, please redo actions ');
                $this->redirect('dropadd/index');               
           }
           foreach($courseIds as $courseId)
           {
               if(!Doctrine_Core::getTable('StudentCourseGrade')->checkIfCourseIsDropped($studentId, $courseId))
                       Doctrine_Core::getTable('StudentCourseGrade')->dropCourse($studentId, $courseId);               
           }
           
            $this->getUser()->setFlash('notice', 'Course has been successfully drop for student: '.Doctrine_Core::getTable('Student')
                                                                                                    ->getStudentDetailById($studentId));
            $this->redirect('dropadd/index');
    }
  }  
}
