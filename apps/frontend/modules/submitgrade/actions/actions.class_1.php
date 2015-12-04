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
    #$this->gradeFilterForm = new FilterForm($this->getUser()->getAttribute('departmentId'));

    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId); 
    
    
    
    if( !empty($this->programs) )
    {
        $this->program_sections = Doctrine_Core::getTable('ProgramSection')        
                ->createQuery('a')
                ->whereIn('program_id', array_keys($this->programs) )
                ->execute();
    }
    
    ## Pass Program infomation 
    
    
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
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


  public function executeShowgradesubmission(sfWebRequest $request)
  {


        $this->gradeFilterForm = new FilterForm($this->getUser()->getAttribute('departmentId'));

        $programId      = $request->getParameter('programId');
        $academicYear   = $this->getUser()->getAttribute('academicYear');    
        $semester       = $request->getParameter('semester');
        $year           = $request->getParameter('year');
        $centerId       = $request->getParameter('centerId');  
        
	## One Batch is combination of: program_id, academic_year, year, and semester
	if(Doctrine_Core::getTable('EnrollmentInfo')
                       ->checkIfEnrolledToProgram($programId, $academicYear, $year, $semester))
	{
            if(Doctrine_Core::getTable('ProgramSection')
                ->checkIfSectionIsCreated($programId, $academicYear, $year, $semester, $centerId))
            {  
                $section        = Doctrine_Core::getTable('ProgramSection')
                                ->getOneBatchCurrentSection($programId, $academicYear, $year, $semester, $centerId);
                if(Doctrine_Core::getTable('SectionCourseOffering')
                                    ->checkIfCourseIsDefined($section['id']))
                {                                     
                    if(Doctrine_Core::getTable('EnrollmentInfo')
                                ->checkIfRegisteredToSemesterCourses($programId, $academicYear, $year, $semester, $section['id']))  
                    {                                
                        ## Check if Grade is submitted,
                        if(!Doctrine_Core::getTable('SectionCourseOffering')
                                ->checkIfGradeSubmittedForAllCourses($section['id']))
                        {
                            ## find courses with out grade
                            $availableCourses   = Doctrine_Core::getTable('SectionCourseOffering')->getAllowedCoursesForGrade($section['id']); 
                            
                            ## get enrollments
                            $enrollments = Doctrine_Core::getTable('EnrollmentInfo')
                                    ->getOneBatchEnrollments($programId, $academicYear, $year, $semester, $centerId );
                            
                            ## Prepare Grade Choices and course choices to pass
                            $gradeChoices     = submitgradeActions::getGradeChoicesAsArray(
                                    Doctrine_Core::getTable('Grade')->getAllLetterGradeChoices());                           

                            $this->gradeForm        = new FrontendGradeForm($enrollments, $availableCourses, $gradeChoices);
                            ## Keep enrollments, courses and gradechoices for later use!
                            $this->getUser()->setAttribute('enrollments', $enrollments); 
                           
                            $this->getUser()->setAttribute('courses', $availableCourses);
                            $this->getUser()->setAttribute('sectionId', $section['id']);
                        }
                        else
                        {
                            $this->getUser()->setFlash('notice', 'Grade is already submitted for all courses!');
                            $this->redirect('submitgrade/index');                                                           
                        }
                    }
                    else
                    {
                        $this->getUser()->setFlash('error', 'This batch is NOT registered to Semester Courses!');
                        $this->redirect('submitgrade/index');                             
                    }
                }
                else
                {
                    $this->getUser()->setFlash('notice', 'Course was not defined for this batch: Please go to course offering and define semester courses!');
                    $this->redirect('submitgrade/index');                        
                }
            }
            else 
            {
                $this->getUser()->setFlash('error', 'Section was not created for this batch!');
                $this->redirect('submitgrade/index');                          
            }
        }
        else
        {
            $this->getUser()->setFlash('error', 'This batch does not exist, or not Enrolled to a program');
            $this->redirect('submitgrade/index');
	}        

 }
  

  public function executeDogradesubmission(sfWebRequest $request)
  {
    ## Also show filter form
    $this->gradeFilterForm = new FilterForm($this->getUser()->getAttribute('departmentId'));
    ## Recreate the GRADE SUBMISSION Form,
    $this->gradeForm = new FrontendGradeForm($this->getUser()->getAttribute('enrollments'),
            $this->getUser()->getAttribute('courses'),
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
	$formData       = $this->gradeForm->getValues(); 
        $courseId       = $formData['course_id'];
        
        
        # GET sessions and delete them, 
        $enrollments    = $this->getUser()->getAttribute('enrollments');         
       
        ## Unset all sessions,
        //$this->getUser()->getAttributeHolder()->remove('enrollments');
        $this->getUser()->getAttributeHolder()->remove('courses');
        $this->getUser()->getAttributeHolder()->remove('studentIds');  ## delete it
        
        foreach($enrollments as $enrollment)
        {
            ## for each enrollment, find one registration information 
            $enrollmentId   =   $enrollment->getId(); 
            $registrationId = Doctrine_Core::getTable('Registration')
                    ->getRegistrationByEnrollmentId($enrollmentId)->getId();
            $oneStudentCourseGrade = Doctrine_Core::getTable('StudentCourseGrade')->updateOneStudentGrade(
                    $registrationId, 
                    $enrollment->getStudentId(), 
                    $courseId, 
                    $formData['grade_id_'.$enrollment->getStudentId()]
                    );
            ## Update credit hourse
            $course     = Doctrine_Core::getTable('Course')->getOneCourseDetail($courseId);
            Doctrine_Core::getTable('EnrollmentInfo')->updateCreditHours(
                    $enrollment->getId(), 
                    $course->getCreditHoure()
            );
            Doctrine_Core::getTable('EnrollmentInfo')->updateGradePoints(
                    $enrollment, 
                    $course, 
                    $oneStudentCourseGrade  
            );            
            
            
        }
        
        ## Finally, update grade for a given course is submitted,
            /* @var $sectionId type */
        $sectionId = $this->getUser()->getAttribute('sectionId');
        $this->getUser()->getAttributeHolder()->remove('sectionId');
        
        $sectionCourseOfferingObj   = new SectionCourseOffering();
        $sectionCourseOfferingObj   = Doctrine_Core::getTable('SectionCourseOffering')->getOneSectionsOneCourse($sectionId, $courseId);
        $sectionCourseOfferingObj->updateCourseGradeStatusGradeSubmitted();
        $sectionCourseOfferingObj->save();        
	  
  	$this->getUser()->setFlash('notice', 'Grade submission was successfull ');
  	$this->redirect('submitgrade/index');  
       

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
