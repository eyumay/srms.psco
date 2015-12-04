<?php

/**
 * regrade actions.
 *
 * @package    srmsnew
 * @subpackage regrade
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class centerchangeActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {

    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);



    if( !empty($this->programs) )
    {
        $this->program_sections =  Doctrine_Core::getTable('ProgramSection')->getActiveProgramSections(array_keys($this->programs) );
    }

    ## Pass Program infomation


    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();


  }

  public function executeFilterToEnrollToSection(sfWebRequest $request)
  {

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
        $this->redirect('programsection/index');
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
                $this->redirect('programsection/index');
            }

        }
        else {
            $this->getUser()->setFlash('error', "This section not yet created");
            $this->redirect('programsection/index');
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
        $this->redirect('programsection/sectionformfilter');
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
            $this->redirect('programsection/index');
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

  public function executeStudentTransferDetail(sfWebRequest $request)
  {
      ## <SectionDetail>, <StudentDetail>, <GradedCourses> <CreateForm> <activatedRegrades> ## THESE ARE NEEDED STEP BY STEP
      $this->showToSectionForm          = FALSE;
      $this->sectionIdNamePairArray     = array();             

      
      $this->departmentName = $this->getUser()->getAttribute('departmentName');
      $this->departmentId = $this->getUser()->getAttribute('departmentId');

      $this->programSectionId   = $request->getParameter('sectionId');
      $this->studentId          = $request->getParameter('studentId');
      $this->enrollmentId       = $request->getParameter('enrollmentId');     
      
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->findOneById($this->programSectionId);
      $this->forward404Unless($this->sectionDetail);
      $this->studentDetail  = Doctrine_Core::getTable('Student')->getStudentDetailById($this->studentId);   
      $this->forward404Unless($this->studentDetail);
      

      ## Prepare program section ID Name Pair
      if(Doctrine_Core::getTable('Department')->findOneById($this->departmentId)->checkIfActiveProgramSectionsExist($this->sectionDetail->getId(), $this->sectionDetail->getYear(), $this->sectionDetail->getSemester(), $this->sectionDetail->getAcademicYear()))
      {
        $this->showToSectionForm = TRUE;
        $this->sectionIdNamePairArray[''] = '--- Please Select New Section --- '; 
        $this->departmentDetail = Doctrine_Core::getTable('Department')->findOneById($this->departmentId)->getWithActiveProgramSections($this->sectionDetail->getId(), $this->sectionDetail->getYear(), $this->sectionDetail->getSemester(), $this->sectionDetail->getAcademicYear());
        $this->forward404Unless($this->departmentDetail);      
        foreach($this->departmentDetail->getPrograms() as $p)
            foreach($p->getProgramSections() as $ps)
                $this->sectionIdNamePairArray[$ps->getId()]='Center '.$ps->getCenter().' '.$ps->getProgram().' Year: '.$ps->getYear().' Semester: '.$ps->getSemester().' A.Year: '.$ps->getAcademicYear();
      }
      
      $this->centerchangeForm  = new FrontendCenterChangeForm($this->studentDetail->getId(), $this->sectionDetail->getId(), $this->sectionIdNamePairArray);
          
      ### PROCESS THE FORM IF SUBMITTED ###
      if ($request->isMethod('post'))
      {
        $this->centerchangeForm->bind($request->getParameter('centerchangeform'));
        if ($this->centerchangeForm->isValid())
        {

	   $formData            = $this->centerchangeForm->getValues();

	   $fromSectionId      = $formData['from_section_id'];
           $toSectionId       = $formData['to_section_id'];
	   $studentId         = $formData['student_id'];           

           if($fromSectionId == '' || $toSectionId == '' || $studentId == '')
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions ');
                $this->redirect('centerchange/studentTransferDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
           }
           
           ##Do saving here!!
           #1. Find EnrollmentInfo and update it
           $enrollmentToUpdate = Doctrine_Core::getTable('EnrollmentInfo')->findOneById($this->enrollmentId)->updateCenterChange($toSectionId);
           
           #2. Add to Transfer
           //$studentTransfer = new StudentProgramSectionTransfer();
           $newSection = Doctrine_Core::getTable('ProgramSection')->findOneById($toSectionId);
           $toSection = $newSection->getCenter().' Center '.$newSection->getProgram().' Year '.$newSection->getYear().' Sememster'.$newSection->getSemester(). ' AC Year '.$newSection->getAcademicYear(); 
           
           $newTransfer = new StudentProgramSectionTransfer();
           $newTransfer->addNewStudentProgramSectionTransfer($studentId, $fromSectionId, $toSection); 
           
           ##Do Logging!!
           $newLog = new AuditLog();
           $action = "User has changed student Center to ";
           $action .= $newSection->getCenter().' Center '.$newSection->getProgram().' Year '.$newSection->getYear().' Sememster'.$newSection->getSemester(). ' AC Year '.$newSection->getAcademicYear(); 
           $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);

          $this->getUser()->setFlash('notice', 'Successfuly Transferred Student'.' '.$fromSectionId.' '.$toSectionId.' '.$studentId.' '.$this->enrollmentId);
          $this->redirect('centerchange/sectiondetail?id='.$this->programSectionId);
        }
      }
  }

  public function executeDoregradesubmission(sfWebRequest $request)
  {
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId   = $request->getParameter('sectionId');
      $this->studentId          = $request->getParameter('studentId');
      $this->enrollmentId       = $request->getParameter('enrollmentId');

      $this->activatedCourseIdsArray = $this->getUser()->getAttribute('activatedCourseIdsArray');
      $gradeChoices = $this->getUser()->getAttribute('gradeChoices');      

      $this->frontendRegradeSubmissionForm = new FrontendRegradeSubmissionForm($this->enrollmentId, $this->studentId, $this->activatedCourseIdsArray, $gradeChoices);
      if ($request->isMethod('post'))
      {
        $this->frontendRegradeSubmissionForm->bind($request->getParameter('regradesubmissionform'));
        if ($this->frontendRegradeSubmissionForm->isValid())
        {

	   $formData            = $this->frontendRegradeSubmissionForm->getValues();

	   $this->courseId            = $formData['course_id']; ## ID returned is id of StudentCourseGrade
           $this->gradeId             = $formData['grade_id'];
	   $this->studentId           = $formData['student_id'];
           $this->enrollmentInfoId    = $formData['enrollment_info_id'];

           if($this->courseId == '' || $this->gradeId == '' || $this->studentId == '' || $this->enrollmentInfoId == '' )
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions ');
                $this->redirect('regrade/studentRegradeDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
           }

           ##Find StudentCourseGrade for this course and save updates,
           $studentCourseGrade = Doctrine_Core::getTable('StudentCourseGrade')->findOneById($this->courseId);
           $studentCourseGrade->setGradeId($this->gradeId);
           $studentCourseGrade->setRegradeStatus(3);
           $studentCourseGrade->setGradeStatus(1); 
           $studentCourseGrade->save();

           $this->getUser()->setFlash('notice', 'Successfuly Saved New Grade Value');
           $this->redirect('regrade/studentRegradeDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
        }
        $this->getUser()->setFlash('error', 'Error occured');
        $this->redirect('regrade/studentRegradeDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
      }
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
