<?php

/**
 * regrade actions.
 *
 * @package    srmsnew
 * @subpackage regrade
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class exemptionActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {

    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);



    if( !empty($this->programs) )
    {
        $this->program_sections = Doctrine_Core::getTable('ProgramSection')
                ->createQuery('a')
                ->whereIn('program_id', array_keys($this->programs))
                ->execute();
    }

    ## Pass Program infomation


    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();


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
        $this->redirect('exemption/index');
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
                $this->redirect('exemption/index');
            }

        }
        else {
            $this->getUser()->setFlash('error', "This section not yet created");
            $this->redirect('exemption/index');
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
        $this->redirect('exemption/sectionformfilter');
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
            $this->redirect('exemption/index');
        }
    }
  }

  public function executeSectiondetail(sfWebRequest $request)
  {
      $programSectionId     = $request->getParameter('id');

      ## check if this section id is allowed one,
      # use inarray .... php function,
      #if()

      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($programSectionId);

      ## STORE sectiondetail on session for use by promotion setting, just to display class information;
      $this->getUser()->setAttribute('sectionDetail', $this->sectionDetail);
  }

  public function executeCreatePromotionSetting(sfWebRequest $request)
  {
      $this->frontendPromotionSettingForm = New FrontendPromotionSettingForm();
  }

  public function executeProcessPromotion(sfWebRequest $request)
  {
      ## find section detail
      $this->programSectionId     = $request->getParameter('id');

      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId);
      $this->forward404Unless($this->sectionDetail);

      $enrollments          = Doctrine_Core::getTable('EnrollmentInfo')->getEnrollmentsBySectionId($this->programSectionId);
      $this->forward404Unless($enrollments);

      foreach ($enrollments as $enrollment)
          $studentIds[]     = $enrollment->getStudentId();

      $this->students       = Doctrine_Core::getTable('Student')->getStudentsListByStudentIds($studentIds);
      $this->forward404Unless($this->students);

      ## Get promotion information if available for existing class,
      $this->promotionInfo       = Doctrine_Core::getTable('PromotionSetting')
              ->getOnePromotionSetting(
                      $this->sectionDetail->getProgramId(),
                      $this->sectionDetail->getYear(),
                      $this->sectionDetail->getSemester()
              );
      $this->forward404Unless($this->promotionInfo);

  }

  public function executeStudentExemptionDetail(sfWebRequest $request)
  {
      ## <SectionDetail>, <StudentDetail>, <GradedCourses> <CreateForm> <activatedRegrades> ## THESE ARE NEEDED STEP BY STEP
      $this->showActivatedExemptions        = FALSE;
      $this->showFormToActivate             = FALSE;
      $this->showFormToSubmitGrade          = FALSE;
      $this->showApprovedExemptions         = FALSE; 
      $activatedCourseArray                 = array();
      $gradedCourseArray                    = array();
      $coursesToBeExempted                  = array(); 
      
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId   = $request->getParameter('sectionId');
      $this->studentId          = $request->getParameter('studentId');
      $this->enrollmentId       = $request->getParameter('enrollmentId');

      ## RETRIEVE STUDENT REGISTERED COURSES UNDER ONE SEMESTER ENROLLMENT,
      $this->enrollment = Doctrine::getTable('EnrollmentInfo')->getWithStudentCourses($this->enrollmentId);
      $this->forward404Unless($this->enrollment);

      foreach($this->enrollment->getRegistrations() as $registration )
              {
                $registrationId = $registration->getId(); 
                foreach($registration->getStudentCourseGrades() as $scg)
                        {                            
                            if($scg->getIsExempted() == 2 || $scg->getIsExempted() == 3)
                                    {
                                        $activatedCourseArray[$scg->getCourseId()] = $scg->getCourse();
                                        $this->showActivatedExemptions = TRUE;
                            }
                            if($scg->getIsExempted() == 1 )
                                    {
                                        $this->showApprovedExemptions == TRUE;
                                    }
                            if($scg->getIsExempted() == 3 )
                                    $gradedCourseArray[$scg->getCourseId()] =  $scg->getCourse();
                            if($scg->getIsExempted() == 0 )
                                    $coursesToBeExempted[$scg->getCourseId()] =  $scg->getCourse();
                        }
              }



      #showExemptedCourses
      $gradeChoices = Doctrine::getTable('Grade')->getAllLetterGradeChoices();
      $this->getUser()->setAttribute('activatedCourseArray', $activatedCourseArray);
      $this->getUser()->setAttribute('registrationId', $gradeChoices);
      
      $this->frontendExemptionRequestForm = new FrontendExemptionRequestForm($registrationId, $this->enrollment->getStudentId(), $coursesToBeExempted);
      $this->frontendExemptionSubmissionForm = new FrontendExemptionSubmissionForm($registrationId, $this->enrollment->getStudentId(), $activatedCourseArray, $gradeChoices);

      if ($request->isMethod('post'))
      {
        $this->frontendExemptionRequestForm->bind($request->getParameter('exemptionrequestform'));
        if ($this->frontendExemptionRequestForm->isValid())
        {

	   $formData            = $this->frontendExemptionRequestForm->getValues();

	   $this->courseId            = $formData['course_id'];
           $this->registrationId      = $formData['registration_id'];
	   $this->studentId           = $formData['student_id'];
           

           if($this->courseId == '' || $this->registrationId == '' || $this->studentId == '')
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions ');
                $this->redirect('exemption/studentExemptionDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
           }

           #Find given StudentCourseGradeObject
           $studentCourseGrade = Doctrine::getTable('StudentCourseGrade')->getOneRegisteredCourse($this->registrationId, $this->studentId, $this->courseId  );
           $this->forward404Unless($studentCourseGrade);
           $studentCourseGrade->setIsExempted(2);
           $studentCourseGrade->save();

            ##Do Logging!!
           $newLog = new AuditLog();
           $action = 'User has performed Activation of Course Exemption Process ';
           $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);              
           
          $this->getUser()->setFlash('notice', 'Successfuly Activated Course Exemption Process');
          $this->redirect('exemption/studentExemptionDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
        }
      }
      #$this->sectionCourses   = Doctrine_Core::getTable('Course')->getCoursesByCourseIds($courseIds);

  }

  public function executeDoexemptionsubmission(sfWebRequest $request)
  {
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId   = $request->getParameter('sectionId');
      $this->studentId          = $request->getParameter('studentId');
      $this->enrollmentId       = $request->getParameter('enrollmentId');

      $this->activatedCourseIdsArray = $this->getUser()->getAttribute('activatedCourseArray');
      $gradeChoices = $this->getUser()->getAttribute('gradeChoices');      
      $registrationId = $this->getUser()->getAttribute('registrationId');

      $this->frontendExemptionSubmissionForm = new FrontendExemptionSubmissionForm($registrationId, $this->studentId, $this->activatedCourseIdsArray, $gradeChoices);
      if ($request->isMethod('post'))
      {
        $this->frontendExemptionSubmissionForm->bind($request->getParameter('exemptionsubmissionform'));
        if ($this->frontendExemptionSubmissionForm->isValid())
        {

	   $formData            = $this->frontendExemptionSubmissionForm->getValues();

	   $this->courseId            = $formData['course_id']; ## ID returned is id of StudentCourseGrade
           $this->gradeId             = $formData['grade_id'];
	   $this->studentId           = $formData['student_id'];
           $this->registrationId    = $formData['registration_id'];

           if($this->courseId == '' || $this->gradeId == '' || $this->studentId == '' || $this->registrationId == '' )
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions ');
                $this->redirect('exemption/studentExemptionDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
           }

           ##Find StudentCourseGrade for this course and save updates,
           $studentCourseGrade = Doctrine_Core::getTable('StudentCourseGrade')->getOneRegisteredCourse($this->registrationId, $this->studentId, $this->courseId);
           $studentCourseGrade->setGradeId($this->gradeId);
           $studentCourseGrade->setIsExempted(3);
           $studentCourseGrade->setGradeStatus(1); 
           $studentCourseGrade->save();

            ##Do Logging!!
           $newLog = new AuditLog();
           $action = 'User has performed Course Exemption Grade Entry ';
           $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);              
           
           $this->getUser()->setFlash('notice', 'Successfuly Saved New Exemption Grade Value');
           $this->redirect('exemption/studentExemptionDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
        }
        $this->getUser()->setFlash('error', 'Error occured'.$this->courseId.' r='.$this->registrationId.' sid='.$this->registrationId.' gid='.$this->gradeId);
        $this->redirect('exemption/studentExemptionDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
      }
  }

  public function executeCancelexemption(sfWebRequest $request)
  {
      #1. get requests
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId   = $request->getParameter('sectionId');
      $this->studentId          = $request->getParameter('studentId');
      $this->enrollmentId       = $request->getParameter('enrollmentId');
      $this->studentCourseGradeId = $request->getParameter('studentCourseGradeId');## for new course

     #2. Update new course - Deactivate new course
     $courseToCancelExemption = Doctrine_Core::getTable('StudentCourseGrade')->findOneById($this->studentCourseGradeId);
     $this->forward404Unless($courseToCancelExemption);
     $courseToCancelExemption->setIsExempted(0);
     $courseToCancelExemption->setGradeId(NULL);
     $courseToCancelExemption->save();
     
            ##Do Logging!!
           $newLog = new AuditLog();
           $action = 'Department Head has performed Cancellation of Exemption Process ';
           $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);        

     #4 Redirect to where it was
     $this->getUser()->setFlash('notice', 'Exemption Was Cancelled Successfully');
     $this->redirect('exemption/studentExemptionDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);

  }

  public function executeApproveexemption(sfWebRequest $request)
  {
      #1. get requests
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId   = $request->getParameter('sectionId');
      $this->studentId          = $request->getParameter('studentId');
      $this->enrollmentId       = $request->getParameter('enrollmentId');
      $this->studentNewCourseGradeId       = $request->getParameter('studentCourseGradeId');
      
      $studentNewCourseGrade = Doctrine_Core::getTable('StudentCourseGrade')->findOneById($this->studentNewCourseGradeId);
      $studentNewCourseGrade->setIsCalculated(0);
      $studentNewCourseGrade->setIsExempted(1);
      $studentNewCourseGrade->save();
            ##Do Logging!!
           $newLog = new AuditLog();
           $action = 'Department Head has Approved Exemption Grade ';
           $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);   
           
      #Redirect to where it was
      $this->getUser()->setFlash('notice', 'Exemption Approval Was Successful');
      $this->redirect('exemption/studentExemptionDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);

  }

  public static function getNextACYearForSection($year, $semester, $currentACYear)
  {
      if( ($year==1 && $semester==2) ||  ($year==2 && $semester==2) || ($year==3 && $semester==2) || ($year==4 && $semester==2) )
      {
          #DO SOME Calculations and return $AC
          $yearPieces   =  explode('/', $currentACYear);
          $before       = intval($yearPieces[0]);
          $after        = intval($yearPieces[1]);

          #increment each
          $before++;
          $after++;

          #rejoin them
          return $before.'/'.$after;
      }
      else{
          #return itself

          return $currentACYear;
      }
  }
}
