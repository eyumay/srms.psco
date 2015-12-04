<?php

/**
 * regrade actions.
 *
 * @package    srmsnew
 * @subpackage regrade
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class regradeActions extends sfActions
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

  public function executeShow(sfWebRequest $request)
  {
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->program_section);
  }

  public function executeNew(sfWebRequest $request)
  {
    $departmentId           = $this->getUser()->getAttribute('departmentId');
    $this->form = new FrontendProgramSectionForm($departmentId);
  }

  public function executeCreate(sfWebRequest $request)
  {

    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $departmentId           = $this->getUser()->getAttribute('departmentId');
    $this->form = new FrontendProgramSectionForm($departmentId);
	 /*
    $this->processForm($request, $this->form);

    $this->setTemplate('new');
    */

    if($this->processForm($request, $this->form))
    {
        $this->getUser()->setFlash('notice', 'A Section for Program has been successfully created');
        $this->redirect('programsection/index');
    }
	 else
	 {
        $this->getUser()->setFlash('error', 'Error in form');
        $this->setTemplate('new'); // don't render createSuccess.php, but newSuccess.php
    }
    //$this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($program_section = Doctrine_Core::getTable('ProgramSection')->find(array($request->getParameter('id'))), sprintf('Object program_section does not exist (%s).', $request->getParameter('id')));
    $this->form = new FrontendProgramSectionForm($program_section);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($program_section = Doctrine_Core::getTable('ProgramSection')->find(array($request->getParameter('id'))), sprintf('Object program_section does not exist (%s).', $request->getParameter('id')));
    $this->form = new FrontendProgramSectionForm($program_section);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($program_section = Doctrine_Core::getTable('ProgramSection')->find(array($request->getParameter('id'))), sprintf('Object program_section does not exist (%s).', $request->getParameter('id')));
    $program_section->delete();

    $this->redirect('programsection/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    /*
    if ($form->isValid())
    {
      $program_section = $form->save();

      $this->redirect('programsection/edit?id='.$program_section->getId());
    }
    */
    if ($form->isValid())
    {
      $form->save();
      return true;
    }
    else{
    	return false;
    }
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



  public function executeEnrolltosection(sfWebRequest $request)
  {

    ## Data to redisplay the filter, later to be binded to the form
    $departmentId           = $this->getUser()->getAttribute('departmentId');
    $this->programs			= Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();


    ## Retrieve $enrollmentInfoIds and $sectionIds from session variable, and delete it
    $enrollmentInfoIds      = $this->getUser()->getAttribute('enrollmentInfoIds');
    $sectionIds             = $this->getUser()->getAttribute('sectionIds');

	 $this->studentsToEnroll    = new StudentToSectionEnrollmentForm($enrollmentInfoIds, $sectionIds);
	 if($this->processEnrolltosectionform($request, $this->studentsToEnroll))
	 {
	 	## do saving form here ...
		 $this->getUser()->setFlash('notice', 'perfecto');
		 $this->setTemplate('enrolltosection');
	 }
	 $this->getUser()->setFlash('error', 'No selected student to enroll to section ');
	 $this->setTemplate('enrolltosection');
  }
  public function processEnrolltosectionform(sfWebRequest $request, sfForm $studentsToEnroll )
  {

    $studentsToEnroll->bind($request->getParameter('studenttosectionenrollmentform'));
    if ($studentsToEnroll->isValid())
    {
        $formData           = $this->studentsToEnroll->getValues();
 	$enrollmentInfoId   = $formData['enrollment_info_id'];
 	$sectionId          = $formData['section_id'];


        if($enrollmentInfoId == '' ) {
          return false;
        }

        if(!Doctrine_Core::getTable('EnrollmentInfo')->enrollStudentsToSection($enrollmentInfoId, $sectionId))
        {
            $this->getUser()->setFlash('error', 'Failed to perform requested action');
            $this->redirect('programsection/index');
	}
	$this->getUser()->setFlash('notice', 'Successfully Enrolled Students to Section');
	$this->redirect('programsection/index');
	return true;
    }

    return false;
  }



########### START: Enroll Selected Students to Selected OR Any Program Section  #######################
  public function executeShowfiltertoenrollselected(sfWebRequest $request)
  {
    $this->filterToEnrollSelectedFormFilter = new FilterForm($this->getUser()->getAttribute('departmentId'));
  }

  public function executeShowfiltertoenrollselectedresult(sfWebRequest $request)
  {
    $this->filterToEnrollSelectedFormFilter = new FilterForm($this->getUser()->getAttribute('departmentId'));
	 $this->processShowfiltertoenrollselectedresultform($request, $this->filterToEnrollSelectedFormFilter);
	 $this->setTemplate('showfiltertoenrollselected');
  }
  public function processShowfiltertoenrollselectedresultform(sfWebRequest $request, sfForm $filterToEnrollSelectedFormFilter )
  {
    $filterToEnrollSelectedFormFilter->bind($request->getParameter('filterform'));
    if ($filterToEnrollSelectedFormFilter->isValid())
    {
		## get form values
	   $formData		= $this->filterToEnrollSelectedFormFilter->getValues();
	   $programId		= $formData['program_id'];
		$academicYear	= $formData['academic_year'];
		## passing $academicYear creates a problem on URL, so pass it using session
		$this->getUser()->setAttribute('academicYear', $academicYear);
		$year				= $formData['year'];
		$semester		= $formData['semester'];

		$this->redirect('programsection/showformtoselectandenroll?programId='.$programId.'&year='.$year.'&semester='.$semester);
    }
  }
  public function executeShowformtoselectandenroll(sfWebRequest $request)
  {
    $this->filterToEnrollSelectedFormFilter = new FilterForm($this->getUser()->getAttribute('departmentId'));
  }
  public function executeDoenrollselectedtosection(sfWebRequest $request)
  {
    $this->filterToEnrollSelectedFormFilter = new FilterForm($this->getUser()->getAttribute('departmentId'));
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

  public function executeGenerateConsolidate(sfWebRequest $request)
  {
      $programSectionId     = $request->getParameter('id');
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($programSectionId);
  }

  public function executePrintStudentSlip(sfWebRequest $request)
  {
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId     = $request->getParameter('id');
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId);
      $this->programName          = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId)->getProgram();

      $enrollments          = Doctrine_Core::getTable('EnrollmentInfo')->getEnrollmentsBySectionId($this->programSectionId);
      foreach ($enrollments as $enrollment)
          $studentIds[]     = $enrollment->getStudentId();

      $this->students       = Doctrine_Core::getTable('Student')->getStudentsListByStudentIds($studentIds);


  }

  public function executePrintSemesterSlip(sfWebRequest $request)
  {
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId     = $request->getParameter('id');

      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId);

      $this->programName          = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId)->getProgram();

      $courses       = Doctrine_Core::getTable('SectionCourseOffering')->getOneBatchOneSemesterCourses($this->programSectionId);
      foreach($courses as $course)
          $courseIds[]  = $course->getCourseId();

      $this->sectionCourses   = Doctrine_Core::getTable('Course')->getCoursesByCourseIds($courseIds);



  }
  public function executeGenerateGradeReport(sfWebRequest $request)
  {
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId     = $request->getParameter('id');

      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId);

      $this->programName          = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId)->getProgram();

      $courses       = Doctrine_Core::getTable('SectionCourseOffering')->getOneBatchOneSemesterCourses($this->programSectionId);
      foreach($courses as $course)
          $courseIds[]  = $course->getCourseId();

      $this->sectionCourses   = Doctrine_Core::getTable('Course')->getCoursesByCourseIds($courseIds);

      $enrollments          = Doctrine_Core::getTable('EnrollmentInfo')->getEnrollmentsBySectionId($this->programSectionId);
      foreach ($enrollments as $enrollment)
          $studentIds[]     = $enrollment->getStudentId();

      $this->students       = Doctrine_Core::getTable('Student')->getStudentsListByStudentIds($studentIds);
  }

  public function executeGenerateCumulativeGradeReport(sfWebRequest $request)
  {
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId     = $request->getParameter('id');

      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId);

      $this->programName          = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId)->getProgram();

      $courses       = Doctrine_Core::getTable('SectionCourseOffering')->getOneBatchOneSemesterCourses($this->programSectionId);
      foreach($courses as $course)
          $courseIds[]  = $course->getCourseId();

      $this->sectionCourses   = Doctrine_Core::getTable('Course')->getCoursesByCourseIds($courseIds);

      $enrollments          = Doctrine_Core::getTable('EnrollmentInfo')->getEnrollmentsBySectionId($this->programSectionId);
      foreach ($enrollments as $enrollment)
          $studentIds[]     = $enrollment->getStudentId();

      $this->students       = Doctrine_Core::getTable('Student')->getStudentsListByStudentIds($studentIds);
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

  public function executeDoPromotion(sfWebRequest $request)
  {
      ## find section detail
      $i=1;
      $this->programSectionId     = $request->getParameter('id');

      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId);

      $enrollments          = Doctrine_Core::getTable('EnrollmentInfo')->getEnrollmentsBySectionId($this->programSectionId);

      ## Get promotion information if available for existing class,
      $this->promotionInfo       = Doctrine_Core::getTable('PromotionSetting')
              ->getOnePromotionSetting(
                      $this->sectionDetail->getProgramId(),
                      $this->sectionDetail->getYear(),
                      $this->sectionDetail->getSemester()
              );
      $this->forward404Unless($this->promotionInfo);


      //$this->enrollmentsToCreate[] = Array();

      ## Create section,
      $this->sectionToCreate = new ProgramSection();
      $this->sectionToCreate->setProgramId($this->sectionDetail->getProgramId());
      $this->sectionToCreate->setCenterId($this->sectionDetail->getCenterId());
      $this->sectionToCreate->setAcademicCalendarId($this->sectionDetail->getAcademicCalendarId());
      $academicYearToSave = ProgramSectionActions::getNextACYearForSection(
              $this->sectionDetail->getYear(),
              $this->sectionDetail->getSemester(),
              $this->sectionDetail->getAcademicYear()
              );
      $this->sectionToCreate->setAcademicYear($academicYearToSave);
      $this->sectionToCreate->setYear($this->promotionInfo->getToYear());
      $this->sectionToCreate->setSemester($this->promotionInfo->getToSemester());
      $this->sectionToCreate->setSectionNumber($this->sectionDetail->getSectionNumber());
      $this->sectionToCreate->setIsActivated(TRUE);
      $this->sectionToCreate->save();

      $this->sectionDetail->setIsPromoted(TRUE);
      //$this->sectionDetail->setIsActivated(TRUE);
      $this->sectionDetail->save();

      foreach ($enrollments as $enrollment)
      {
          ## get student status with given ENROLLMENT,
          $status = Statuses::getStudentStatus($enrollment);

          if($status == 'PASS' || $status == 'WARNING')
          {
              $this->enrollmentsToCreate = new EnrollmentInfo();
              $this->enrollmentsToCreate->setStudentId($enrollment->getStudentId()) ;
              $this->enrollmentsToCreate->setAcademicYear($this->promotionInfo->getToAcademicYear()) ;
              $this->enrollmentsToCreate->setYear($this->promotionInfo->getToYear()) ;
              $this->enrollmentsToCreate->setSemester($this->promotionInfo->getToSemester()) ;
              $this->enrollmentsToCreate->setSectionId($this->sectionToCreate->getId()) ;
              $this->enrollmentsToCreate->setProgramId($enrollment->getProgramId()) ;
              $this->enrollmentsToCreate->setTotalChrs($enrollment->getTotalChrs()) ;
              $this->enrollmentsToCreate->setTotalGradePoints($enrollment->getTotalGradePoints()) ;
              $this->enrollmentsToCreate->setTotalRepeatedChrs($enrollment->getTotalRepeatedChrs()) ;
              $this->enrollmentsToCreate->setTotalRepeatedGradePoints($enrollment->getTotalRepeatedGradePoints()) ;
              $this->enrollmentsToCreate->setPreviousChrs($enrollment->getSemesterChrs()) ;
              $this->enrollmentsToCreate->setPreviousGradePoints($enrollment->getSemesterGradePoints()) ;
              $this->enrollmentsToCreate->setPreviousRepeatedChrs($enrollment->getSemesterRepeatedChrs()) ;
              $this->enrollmentsToCreate->setPreviousRepeatedGradePoints($enrollment->getSemesterRepeatedGradePoints()) ;
              $this->enrollmentsToCreate->save();


              $studentIds[]     = $enrollment->getStudentId();

              $this->enrollmentCount = $i;
              $i++;
          }

      }
      $this->getUser()->setFlash('notice', 'Promotion was successfull');
      $this->redirect('programsection/index');


  }

  public function executeGenerateGradeReportPdf(sfWebRequest $request)
  {
      $departmentName = $this->getUser()->getAttribute('departmentName');

      $programSectionId     = $request->getParameter('id');

      $sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($programSectionId);

      $programName          = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($programSectionId)->getProgram();

      $courses       = Doctrine_Core::getTable('SectionCourseOffering')->getOneBatchOneSemesterCourses($programSectionId);
      foreach($courses as $course)
          $courseIds[]  = $course->getCourseId();

      $sectionCourses   = Doctrine_Core::getTable('Course')->getCoursesByCourseIds($courseIds);

      $enrollments          = Doctrine_Core::getTable('EnrollmentInfo')->getEnrollmentsBySectionId($programSectionId);
      foreach ($enrollments as $enrollment)
          $studentIds[]     = $enrollment->getStudentId();

      $students       = Doctrine_Core::getTable('Student')->getStudentsListByStudentIds($studentIds);
  }

  public function executeStudentRegradeDetail(sfWebRequest $request)
  {
      ## <SectionDetail>, <StudentDetail>, <GradedCourses> <CreateForm> <activatedRegrades> ## THESE ARE NEEDED STEP BY STEP
      $this->showCourseGrades               = FALSE;
      $this->showFormResult                 = FALSE;
      $this->showActivatedRegrade           = FALSE;
      $this->registrationIdsArray           = array();
      $this->coursesIdsArray                = array();
      $this->regradeRegistrationIdsArray    = array();
      $this->activatedCourseIdsArray        = array();
      
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId   = $request->getParameter('sectionId');
      $this->studentId          = $request->getParameter('studentId');
      $this->enrollmentId       = $request->getParameter('enrollmentId');

      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId);
      $this->studentDetail  = Doctrine_Core::getTable('Student')->getStudentDetailById($this->studentId);

      $this->programName          = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId)->getProgram();

      ## RETRIEVE STUDENT REGISTERED COURSES UNDER ONE SEMESTER ENROLLMENT,

      #1. Find enrollment
      $this->enrollment   = Doctrine_Core::getTable('EnrollmentInfo')->findOneStudentEnrollmentInforById($this->enrollmentId);
      $this->forward404Unless($this->enrollment);

      #2. Find all Registrations per enrollment above
      $this->registrations = Doctrine_Core::getTable('Registration')->getEnrollmentRegistrations($this->enrollment->getId());
      $this->forward404Unless($this->registrations);
      foreach($this->registrations as $registration)
              {
                $this->registrationIdsArray[$registration->getId()] = $registration->getId();
                if(($registration->getIsGradeComplain()==TRUE) || ($registration->getIsMakeup()==TRUE) || ($registration->getIsReexam() == TRUE))
                        {                    
                    $this->regradeRegistrationIdsArray[$registration->getId()] = $registration->getId();
                }
              }

      #3. Find all courses [StudentCourseGrade] under each Registration, a)Calculatables, b)Have Grade
      $this->activeGradedStudentCourses       = Doctrine_Core::getTable('StudentCourseGrade')->getActiveRegistrationCourses($this->registrationIdsArray, $this->studentId);
      $this->forward404Unless($this->activeGradedStudentCourses);
      #3.1 Check if there graded courses
      if($this->activeGradedStudentCourses->count() != 0)
              $this->showCourseGrades = TRUE;

      #3.2 Find all courses [StudentCourseGrade] under each Registration, a)Calculatables, b)Have Grade c)not under regrade process (not activated)
      $this->activeNotReGradedStudentCourses       = Doctrine_Core::getTable('StudentCourseGrade')->getActiveRegistrationNotRegradedCourses($this->registrationIdsArray, $this->studentId);
      $this->forward404Unless($this->activeNotReGradedStudentCourses);


      #4. PREPARE REGRADE REQUEST FORM
      ##COURSE
      $this->coursesIdsArray[''] = 'Select Course to Regrade';
      foreach($this->activeNotReGradedStudentCourses as $course)
        $this->coursesIdsArray[$course->getCourseId()] = $course->getCourse();
      ##REGRADE - FROM FormChoices
      ##AC MINUTE, REMARK

      ## THE FORM
      $this->frontendRegradeRequestForm = new FrontendRegradeRequestForm($this->enrollmentId, $this->studentId, $this->coursesIdsArray);
      

      #5. ACTIVATED REGRADES
      #5.1 - Get all special / regrade registrations
      $this->activatedCoursesForRegrade = Doctrine_Core::getTable('StudentCourseGrade')->getActivatedCoursesForRegrade($this->regradeRegistrationIdsArray, $this->studentId);
      $this->forward404Unless($this->activatedCoursesForRegrade);
      #5.2 - Arrange activated regradable courses for form
      if($this->activatedCoursesForRegrade->count() != 0) 
      {
        $this->showActivatedRegrade = TRUE;
        $this->activatedCourseIdsArray[''] = '-- Select Course To Regrade --';
        foreach($this->activatedCoursesForRegrade as $activatedCFR)
            $this->activatedCourseIdsArray[$activatedCFR->getId()] = $activatedCFR->getCourse();

        #KEEP COURSE ID ARRAY ON SESSION, TO BE USED WHEN REGRADE VALUE IS ENTERED
        $this->getUser()->setAttribute('activatedCourseIdsArray',$this->activatedCourseIdsArray );

      }

      #6. DATAWORKER FOR VIEW
      $gradeChoices     = Doctrine_Core::getTable('Grade')->getAllLetterGradeChoices();
      $this->getUser()->setAttribute('gradeChoices',$gradeChoices ); ## created for use when new regrade value is entered,
      $this->frontendRegradeSubmissionForm = new FrontendRegradeSubmissionForm($this->enrollmentId, $this->studentId, $this->activatedCourseIdsArray, $gradeChoices);

      ### PROCESS THE FORM IF SUBMITTED ###
      if ($request->isMethod('post'))
      {
        $this->frontendRegradeRequestForm->bind($request->getParameter('regraderequestform'));
        if ($this->frontendRegradeRequestForm->isValid())
        {

	   $formData            = $this->frontendRegradeRequestForm->getValues();

	   $this->courseId            = $formData['course_id'];
           $this->regradeReason       = $formData['regrade_reason'];
	   $this->studentId           = $formData['student_id'];
           $this->enrollmentInfoId    = $formData['enrollment_info_id'];
           $this->remark              = $formData['remark'];
           $this->ac                  = $formData['ac'];
           

           if($this->courseId == '' || $this->regradeReason == '' || $this->studentId == '' || $this->enrollmentInfoId == '' )
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions ');
                $this->redirect('regrade/studentRegradeDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
           }

          ## REGISTER STUDENT BASED ON ENROLLMENTINFO FOR SPECIFIED REGRADE REASON          
          $registration	= new Registration();
	  $registration->setEnrollmentInfoId($this->enrollmentInfoId);
          $registration->setAc($this->ac);
	  $registration->setDate(date('m-d-Y'));
          $registration->setRemark($this->remark);

          if($this->regradeReason == 'gradecomplain')
                  $registration->setIsGradeComplain(TRUE);
          if($this->regradeReason == 'reexam')
                  $registration->setIsReexam(TRUE);
          if($this->regradeReason == 'makeup')
                  $registration->setIsMakeup(TRUE);
	  $registration->save();

          ## STUDENTCOURSEGRADE -----------> NEW COURSE RE-REGISTERED
          $student = new StudentCourseGrade();
          $student->setStudentId($this->studentId);
          $student->setRegistrationId($registration->getId());
          $student->setCourseId($this->courseId);
          $student->setIsRepeated(TRUE);
          $student->setIsCalculated(FALSE);
          $student->setRegradeStatus(2);
          $student->save();

          ## STUDENTCOURSEGRADE ------------> EXISTING COURSE / ONE NEEDED TO BE CHANGED
          $normalRegistration = Doctrine_Core::getTable('Registration')->getNormalRegistrationByEnrollmentId($this->enrollmentInfoId);
          $oldStudentCourseGrade = Doctrine_Core::getTable('StudentCourseGrade')
                                        ->getRegisteredGradedCourse($normalRegistration->getId(), $this->studentId, $this->courseId );
          $oldStudentCourseGrade->setRegradeStatus(4);
          $oldStudentCourseGrade->save();

          //$this->showFormResult=TRUE;

           ##Do Logging!!
           $newLog = new AuditLog();
           $action = 'The Department Head has Activated  Student Regreade Process';
           $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);          
          
          $this->getUser()->setFlash('notice', 'Successfuly Activated Regrade Process');
          $this->redirect('regrade/studentRegradeDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
        }
      }
      #$this->sectionCourses   = Doctrine_Core::getTable('Course')->getCoursesByCourseIds($courseIds);

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

           ##Do Logging!!
           $newLog = new AuditLog();
           $action = 'Dataworker has Changed  Student Grades';
           $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);
           
           $this->getUser()->setFlash('notice', 'Successfuly Saved New Grade Value');
           $this->redirect('regrade/studentRegradeDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
        }
        $this->getUser()->setFlash('error', 'Error occured');
        $this->redirect('regrade/studentRegradeDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);
      }
  }

  public function executeCancelregrade(sfWebRequest $request)
  {
      #1. get requests
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId   = $request->getParameter('sectionId');
      $this->studentId          = $request->getParameter('studentId');
      $this->enrollmentId       = $request->getParameter('enrollmentId');
      $this->studentCourseGradeId = $request->getParameter('studentCourseGradeId');## for new course

     #2. Update new course - Deactivate new course
     $newCourse = Doctrine_Core::getTable('StudentCourseGrade')->findOneById($this->studentCourseGradeId);
     $this->forward404Unless($newCourse);
     $newCourse->setRegradeStatus(6);
     $newCourse->save();

     #3. Update old course - Deactivate the course regrade_status=5
     #3.1 Get normal registraion by enrollmentInfoId
     $normalRegistration = Doctrine_Core::getTable('Registration')->getNormalRegistrationByEnrollmentId($this->enrollmentId);
     #3.2 Get Old course/ Old course registered under normal registration
     $oldCourse = Doctrine_Core::getTable('StudentCourseGrade')->getOneNormalRegistrationCourse($normalRegistration->getId(), $newCourse->getCourseId());
     $oldCourse->setRegradeStatus(5);
     $oldCourse->save();

     #4 Redirect to where it was
     
                $newLog = new AuditLog();
                $action = 'User has Cancelled Regrade Process .....';
                $newLog->addNewLogInfo($this->getUser()->getAttribute('userId'), $action);         
     $this->getUser()->setFlash('notice', 'Regrade Cancellation Was Successful'); 
     $this->redirect('regrade/studentRegradeDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);

  }

  public function executeApproveregrade(sfWebRequest $request)
  {
      #1. get requests
      $this->departmentName = $this->getUser()->getAttribute('departmentName');

      $this->programSectionId   = $request->getParameter('sectionId');
      $this->studentId          = $request->getParameter('studentId');
      $this->enrollmentId       = $request->getParameter('enrollmentId');
      $this->studentNewCourseGradeId       = $request->getParameter('studentCourseGradeId');
      #2.1 New course [new regrade]
      $studentNewCourseGrade = Doctrine_Core::getTable('StudentCourseGrade')->findOneById($this->studentNewCourseGradeId);
      $studentNewCourseGrade->setIsCalculated(1);
      $studentNewCourseGrade->setRegradeStatus(1);
      
      ##2.2 EnrollmentInfo
      $enrollmentBeforePromotion = Doctrine_Core::getTable('EnrollmentInfo')->findOneStudentEnrollmentInforById($this->enrollmentId) ;
      $this->forward404Unless($enrollmentBeforePromotion); 
      ##2.3 Find detail about New course (chr, related grade point)
      $gradeValue = $studentNewCourseGrade->getGrade()->getValue();
      $courseChr  = $studentNewCourseGrade->getCourse()->getCreditHoure();
      $gradePoint = $gradeValue*$courseChr;
      ##2.3 Update EnrollmentInfo about the new grade
      $enrollmentBeforePromotion->setSemesterChrs($enrollmentBeforePromotion->getSemesterChrs()+$courseChr);
      $enrollmentBeforePromotion->setTotalChrs($enrollmentBeforePromotion->getTotalChrs()+$courseChr);
      $enrollmentBeforePromotion->setSemesterGradePoints($enrollmentBeforePromotion->getSemesterGradePoints() + $gradePoint);
      $enrollmentBeforePromotion->setTotalGradePoints($enrollmentBeforePromotion->getTotalGradePoints()+$gradePoint);


      #Old Course [Previous course value]
      $normalRegistration = Doctrine_Core::getTable('Registration')->getNormalRegistrationByEnrollmentId($this->enrollmentId);
      $oldCourse = Doctrine_Core::getTable('StudentCourseGrade')->getOneNormalRegistrationCourse($normalRegistration->getId(), $studentNewCourseGrade->getCourseId());
      $oldCourse->setIsCalculated(0);
      
      ##EnrollmentInfo - for old course [This time, old course's gp & chr to be added to repeated rows]
      $oldCourseGradeValue = $oldCourse->getGrade()->getValue();
      $oldCourseChr        = $oldCourse->getCourse()->getCreditHoure();
      $oldGradePoint       = $oldCourseGradeValue * $oldCourseChr;
      $enrollmentBeforePromotion->setSemesterRepeatedChrs($enrollmentBeforePromotion->getSemesterRepeatedChrs()+$oldCourseChr);
      $enrollmentBeforePromotion->setTotalRepeatedChrs($enrollmentBeforePromotion->setTotalRepeatedChrs()+$oldCourseChr);
      $enrollmentBeforePromotion->setSemesterRepeatedGradePoints($enrollmentBeforePromotion->getSemesterRepeatedGradePoints() + $oldGradePoint);
      $enrollmentBeforePromotion->setTotalRepeatedGradePoints($enrollmentBeforePromotion->getTotalRepeatedGradePoints() + $oldGradePoint);

      ## SAVE ALL
      $studentNewCourseGrade->save();
      $oldCourse->save();
      $enrollmentBeforePromotion->save();
      
      #Redirect to where it was
      $this->getUser()->setFlash('notice', 'Regrade Approval Was Successful');
      $this->redirect('regrade/studentRegradeDetail?sectionId='.$this->programSectionId.'&studentId='.$this->studentId.'&enrollmentId='.$this->enrollmentId);

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
