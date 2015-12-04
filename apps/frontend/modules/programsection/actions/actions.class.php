<?php

/**
 * programsection actions.
 *
 * @package    srmsnew
 * @subpackage programsection
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class programsectionActions extends sfActions
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

  public function executeEditstudent(sfWebRequest $request)
  {     
      
    $sectionId  = $request->getParameter('sectionId');    
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);     
    $this->forward404Unless($this->program_section);      
      
    $this->forward404Unless($this->student = Doctrine_Core::getTable('Student')->find(array($request->getParameter('studentId'))), sprintf('Object student does not exist (%s).', $request->getParameter('studentId')));
    $this->frontendStudentForm = new FrontendStudentForm($this->student);
    
    if($request->isMethod('POST'))
    {
       $this->frontendStudentForm->bind($request->getParameter('studentform'));
       if ($this->frontendStudentForm->isValid())
       {        
          $formData                 = $this->frontendStudentForm->getValues();
          
          
          $studentUID               = $formData['student_uid'];
          $name                     = $formData['name'];
          $fathersName              = $formData['fathers_name'];            
          $grandfathersName         = $formData['grandfathers_name'];
          $motherName               = $formData['mother_name'];
          $dateOfBirth              = $formData['date_of_birth'];
          $sex                      = $formData['sex'];
          $nationality              = $formData['nationality'];
          $birthLocation            = $formData['birth_location'];
          $residenceCity            = $formData['residence_city'];
          $residenceWoreda          = $formData['residence_woreda'];
          $residenceKebele          = $formData['residence_kebele'];
          $residenceHourseNumber    = $formData['residence_house_number'];
          $ethnicity                = $formData['ethnicity'];
          $telephone                = $formData['telephone'];            
          $email                    = $formData['email']; 
          
          if(!Doctrine_Core::getTable('Student')->findOneByStudentUid($studentUID))
          {
            $this->student->setStudentUid($studentUID);
            $this->student->setName($name);
            $this->student->setFathersName($fathersName);
            $this->student->setGrandfathersName($grandfathersName);
            $this->student->setMotherName($motherName);
            $this->student->setDateOfBirth($dateOfBirth);
            $this->student->setSex($sex);
            $this->student->setAdmissionYear(date('Y'));
            $this->student->setNationality($nationality);
            $this->student->setBirthLocation($birthLocation);
            $this->student->setResidenceCity($residenceCity);
            $this->student->setResidenceWoreda($residenceWoreda);
            $this->student->setResidenceKebele($residenceKebele);
            $this->student->setResidenceHouseNumber($residenceHourseNumber);
            $this->student->setEthinicity($ethnicity);
            $this->student->setTelephone($telephone);
            $this->student->setEmail($email);
            $this->student->save();

            $auditlog = new AuditLog();
            $auditlog->addNewLogInfo($this->getUser()->getAttribute('userId'), 'Performed Student Profile Edit'); 

            $this->getUser()->setFlash('notice', 'Student Profile Edit Was Successful '); 
            $this->redirect('programsection/sectiondetail?id='.$sectionId);      
          }
          else
          {
            $this->getUser()->setFlash('error', 'Error: Duplicate Student ID Number Is Not Allowed');             
          }
              
           
       }
       else
          $this->getUser()->setFlash('error', 'Error with student edit form');     
    }
  }  
  public function executeShow(sfWebRequest $request)
  {
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->program_section);
  }

  public function executeNew(sfWebRequest $request)
  {
    $departmentId           = $this->getUser()->getAttribute('departmentId');
    $this->form = new FrontendProgramSectionForm(NULL, $departmentId);
  }

  public function executeCreate(sfWebRequest $request)
  {
  
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $departmentId           = $this->getUser()->getAttribute('departmentId');
    $this->form = new FrontendProgramSectionForm(NULL, $departmentId);
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
    $orderBy='';
    $this->showStudentsToEnroll = FALSE; 
    if($request->getParameter('showStudentsToEnroll') == 'YES')
    {
        $this->showStudentsToEnroll = TRUE; 
        $this->sectionDetail = Doctrine_Core::getTable('ProgramSection')->findOneById($request->getParameter('sectionId'));
        
        ## GET Admissions, if there are any!
        $this->admission_enrollments = Doctrine_Core::getTable('EnrollmentInfo')->getAdmissions($this->sectionDetail); 
        
        
    }
        
    
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
                    ->getAdmissions($oneSectionDetail); 
                
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
	$this->redirect('programsection/filterToEnrollToSection');          
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
      $programSectionId             = $request->getParameter('id'); 
      
      $leftout                      = FALSE;
      $this->showTransferDetails    = FALSE;      
      $this->check                   = FALSE;
      
      ## Control variables
      $this->showPrintStudentList               = FALSE;
      $this->showPrintSemesterSlip              = FALSE;
      $this->showGenerateConsolidate            = FALSE;
      $this->showPromote                        = FALSE;
      $this->showGenerateGradeReport            = FALSE;
      $this->showGenerateCumulativeGradeReport  = FALSE;   
      
      $this->showSectionIsCreated               = FALSE;
      $this->showEnrolledToSection              = FALSE; 
      $this->showCourseIdDefined                = FALSE;
      $this->showRegistered                     = FALSE;
      $this->showGradeIsSubmitted               = FALSE;
      $this->showPromotionSettingIsDefined      = FALSE;
      $this->showAddNewStudent                  = TRUE;
      $this->showAdmissions                     = FALSE;

      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId); 
      $this->forward404Unless($this->sectionDetail); 
      
      if(Doctrine_Core::getTable('EnrollmentInfo')->checkIfEnrolledToSectionBySectionId($programSectionId))
          $this->check  = TRUE; 
      
      if(Doctrine_Core::getTable('StudentProgramSectionTransfer')->checkIfTransferExists( $programSectionId))
      {
          $this->transfers = Doctrine_Core::getTable('StudentProgramSectionTransfer')->getTransfers($programSectionId);
          $this->showTransferDetails = TRUE;
      }

     
      if(Doctrine_Core::getTable('ProgramSection')->checkIfSectionIsCreatedById($this->sectionDetail->getId() ) )
          $this->showSectionIsCreated = TRUE;
      if(Doctrine_Core::getTable('EnrollmentInfo')->checkIfEnrolledToSectionBySectionId($this->sectionDetail->getId() ) ) {
          $this->showEnrolledToSection = TRUE;
          $this->showPrintStudentList          = TRUE;
      }
      else
      {
          if( !is_null(Doctrine_Core::getTable('EnrollmentInfo')->getAdmissions($this->sectionDetail ) ) )
          {
              $this->showAdmissions = TRUE;
              $this->admissions = Doctrine_Core::getTable('EnrollmentInfo')->getAdmissions($this->sectionDetail ); 
          }
      }
      
      if(Doctrine_Core::getTable('SectionCourseOffering')->checkIfCourseIsDefined($this->sectionDetail->getId() ) )
      {
          $this->showCourseIdDefined = TRUE;
          $this->showPrintSemesterSlip         = TRUE;
      }
      if(Doctrine_Core::getTable('EnrollmentInfo')->checkIfRegisteredBySectionId($this->sectionDetail->getId() ) )
      {
          $this->showRegistered = TRUE; 
          $this->showAddNewStudent = FALSE;
      }
      
      if(Doctrine_Core::getTable('SectionCourseOffering')->checkIfGradeSubmittedBySectionId($this->sectionDetail->getId() ) )
      {
          $this->showGradeIsSubmitted       = TRUE;
          $this->showGenerateConsolidate    = TRUE; 
                 
          $this->showGenerateCumulativeGradeReport    = TRUE; 
          
          if($this->sectionDetail->getYear()==1 && $this->sectionDetail->getSemester()==1 ){ 
              $this->showGenerateCumulativeGradeReport    = FALSE;
          }           
          
          if(Doctrine_Core::getTable('PromotionSetting')                                    
                ->checkIfPromotionSettingIsDefined($this->sectionDetail->getProgramId(), $this->sectionDetail->getYear(), $this->sectionDetail->getSemester()) )
          {
              $this->showPromotionSettingIsDefined      = TRUE;
              if(!Doctrine_Core::getTable('ProgramSection')->checkIfSectionIsPromoted($this->sectionDetail->getId() ) )
                  $this->showPromote = TRUE;
          }
          if($this->sectionDetail->getYear() == 1 && $this->sectionDetail->getSemester() ==1 )
              $this->showGenerateGradeReport    = TRUE; 
      }      
      
      ## STORE sectiondetail on session for use by promotion setting, just to display class information;
      $this->getUser()->setAttribute('sectionDetail', $this->sectionDetail); 

      
      /*$this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId); 
      $this->forward404Unless($this->sectionDetail); 
      
      ## get StudentCenter Array
      //$this->studentCenterArray = Doctrine_Core::getTable('StudentCenter')->getCenterStudents($this->sectionDetail->getCenterId());
      
      $this->admissions = Doctrine_Core::getTable('EnrollmentInfo')->getAdmissions($this->sectionDetail); 
       * 
       */
  }
  
  public function executeGenerateConsolidate(sfWebRequest $request)
  {
      /*$programSectionId     = $request->getParameter('id'); 
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId)->getWithStudents(FALSE);
       * 
       */
      
      $studentIdsArray      = array();
      $this->departmentName = $this->getUser()->getAttribute('departmentName');
      
      $this->programSectionId     = $request->getParameter('id'); 
      
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId);
      
      $this->programName          = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId)->getProgram();
      
      foreach($this->sectionDetail->getEnrollmentInfos() as $enrollmentInfo )
      {
          if(!$enrollmentInfo->getLeftout())
          {
              $studentIdsArray[] = $enrollmentInfo->getStudentId();
          }
      }
      
      ##GET ALL students, in given sectionId, year and semester, with all enrollmentInfos
      $this->students = Doctrine_Core::getTable('Student')->getStudents($studentIdsArray, $this->sectionDetail);       
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
      /*$this->departmentName = $this->getUser()->getAttribute('departmentName');
      
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

      $this->enrollments = Doctrine::getTable('EnrollmentInfo')->getWithGradedStudentCourses($this->programSectionId);
      $this->forward404Unless($this->enrollments); 
       * 
       */
      $studentIdsArray      = array();
      $this->departmentName = $this->getUser()->getAttribute('departmentName');
      
      $this->programSectionId     = $request->getParameter('id'); 
      
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId);
      
      $this->programName          = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId)->getProgram();
      
      foreach($this->sectionDetail->getEnrollmentInfos() as $enrollmentInfo )
      {
          if(!$enrollmentInfo->getLeftout())
          {
              $studentIdsArray[] = $enrollmentInfo->getStudentId();
          }
      }
      
      ##GET ALL students, in given sectionId, year and semester, with all enrollmentInfos
      $this->students = Doctrine_Core::getTable('Student')->getStudents($studentIdsArray, $this->sectionDetail);      
  }
  
  public function executeGenerateCumulativeGradeReport(sfWebRequest $request)
  {
      $studentIdsArray      = array();
      $this->departmentName = $this->getUser()->getAttribute('departmentName');
      
      $this->programSectionId     = $request->getParameter('id'); 
      
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId);
      
      $this->programName          = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($this->programSectionId)->getProgram();
      
      foreach($this->sectionDetail->getEnrollmentInfos() as $enrollmentInfo )
      {
          if(!$enrollmentInfo->getLeftout())
          {
              $studentIdsArray[] = $enrollmentInfo->getStudentId();
          }
      }
      
      ##GET ALL students, in given sectionId, year and semester, with all enrollmentInfos
      $this->students = Doctrine_Core::getTable('Student')->getStudents($studentIdsArray, $this->sectionDetail);      
  }
  public function executeCreatePromotionSetting(sfWebRequest $request)
  {
      $this->frontendPromotionSettingForm = New FrontendPromotionSettingForm(); 
  }  
  
  public function executeProcessPromotion(sfWebRequest $request)
  {
      ## find section detail
      $leftout = FALSE;
      $studentIdsArray = array();
      $this->programSectionId     = $request->getParameter('id');
            
      //$this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->findOneById($this->programSectionId)->getWithStudents($leftout);
      //$this->forward404Unless($this->sectionDetail);           
      
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->findOneById($this->programSectionId);
      
      foreach($this->sectionDetail->getEnrollmentInfos() as $enrollmentInfo )
      {
          if(!$enrollmentInfo->getLeftout())
          {
              $studentIdsArray[] = $enrollmentInfo->getStudentId();
          }
      }
      
      ##GET ALL students, in given sectionId, year and semester, with all enrollmentInfos
      $this->students = Doctrine_Core::getTable('Student')->getStudents($studentIdsArray, $this->sectionDetail);  
      
      
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
      $studentIdsArray = array();
      $this->programSectionId     = $request->getParameter('id');
               
      $this->sectionDetail  = Doctrine_Core::getTable('ProgramSection')->findOneById($this->programSectionId);
      $this->forward404Unless($this->sectionDetail);
      
      foreach($this->sectionDetail->getEnrollmentInfos() as $enrollmentInfo )
      {
          if(!$enrollmentInfo->getLeftout())
          {
              $studentIdsArray[] = $enrollmentInfo->getStudentId();
          }
      }
      
      ##GET ALL students, in given sectionId, year and semester, with all enrollmentInfos
      $this->students = Doctrine_Core::getTable('Student')->getStudents($studentIdsArray, $this->sectionDetail);  
      
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
              $this->promotionInfo->getCurrentYear(),                                                                                    
              $this->promotionInfo->getCurrentSemester(),                                                                                     
              $this->sectionDetail->getAcademicYear()
              );
      $this->sectionToCreate->setAcademicYear($academicYearToSave); 
      $this->sectionToCreate->setYear($this->promotionInfo->getToYear()); 
      $this->sectionToCreate->setSemester($this->promotionInfo->getToSemester()); 
      $this->sectionToCreate->setSectionNumber($this->sectionDetail->getSectionNumber());
      $this->sectionToCreate->setIsActivated(TRUE);
      
      $this->sectionToCreate->save();
      
      $this->sectionDetail->setIsPromoted(TRUE);
      $this->sectionDetail->setIsActivated(FALSE);
      $this->sectionDetail->save();


     foreach($this->students as $student) ##Promoted Enrollment Info must contain everything from previous semester(Add enrollment detail + Normal Enrollment Detail)
      {
        foreach ($student->getEnrollmentInfos() as $enrollmentObj)
        {
            if(!$enrollmentObj->getLeftout())
            {
                $leftoutEnrollments = Doctrine_Core::getTable('EnrollmentInfo')->getLeftoutEnrollments($enrollmentObj);
                if(!is_null($leftoutEnrollments))
                {
                    foreach($leftoutEnrollments as $loe)
                    {
                        ##modify existing $enrollment Module
                        $enrollmentObj->setTotalChrs($enrollmentObj->getTotalChrs() + $loe->getTotalChrs() );
                        $enrollmentObj->setTotalGradePoints($enrollmentObj->getTotalGradePoints() + $loe->getTotalGradePoints());
                        $enrollmentObj->setTotalRepeatedChrs($enrollmentObj->getTotalRepeatedChrs() + $loe->getTotalRepeatedChrs() );
                        $enrollmentObj->setTotalRepeatedGradePoints($enrollmentObj->getTotalRepeatedGradePoints() + $loe->getTotalRepeatedGradePoints() );
                    }
                }                  
            }

        }
      }  

      foreach($this->students as $student)
      {
        foreach ($student->getEnrollmentInfos() as $enrollment)
        {
            if(!$enrollment->getLeftout())
            {
                ## get student status with given ENROLLMENT,
                $status = Statuses::getStudentStatus($student->getEnrollmentInfos(), $this->sectionDetail->getYear(), $this->sectionDetail->getSemester()); 

                if($status == 'PASS' || $status == 'WARNING')
                {              
                    $enrollmentsToCreate = new EnrollmentInfo();
                    $toAcademicYear = ProgramSectionActions::getNextACYearForSection(
                            $this->promotionInfo->getCurrentYear(), 
                            $this->promotionInfo->getCurrentSemester(), 
                            $this->sectionDetail->getAcademicYear() 
                    );
                    if($status == 'PASS')
                        $enrollment->setAcademicStatus(sfConfig::get('app_passing_status'));                    
                    if($status == 'WARNING')
                        $enrollment->setAcademicStatus(sfConfig::get('app_warning_status'));                    
                    $enrollmentsToCreate->makeEnrollment($enrollment, $toAcademicYear, $this->promotionInfo->getToYear(), $this->promotionInfo->getToSemester(), $this->sectionToCreate->getId(), sfConfig::get('app_promotion_enrollment'));                      
                } 
                else 
                {   
                    if($status == 'AD')
                        $enrollment->setAcademicStatus(sfConfig::get('app_ad_status'));
                    if($status == 'ADR')
                    {
                        $enrollment->setAcademicStatus(sfConfig::get('app_adr_status'));
                        $enrollment->setSemesterAction(sfConfig::get('app_dismissed_semester_action'));
                        $enrollment->setLeftout(TRUE); 
                    }
                    if($status == 'WITHDRAWAL')
                        $enrollment->setAcademicStatus(sfConfig::get('app_withdrawal_status'));                    
                    if($status == 'DROPOUT')
                        $enrollment->setAcademicStatus(sfConfig::get('app_dropout_status'));                    
                    $enrollment->setSemesterAction(sfConfig::get('app_dismissed_semester_action'));
                    $enrollment->save();
                }
            }

        }
      }

      $this->getUser()->setFlash('notice', 'Promotion was successfull');
      $this->redirect('programsection/index');   
      
      
  }
  
  public function executeGenerateSemesterSlipPdf(sfWebRequest $request)
  {
      $count = 1; 
      $totalChr = 0; 
      $departmentName = $this->getUser()->getAttribute('departmentName');
      
      $programSectionId     = $request->getParameter('id'); 
      
      $sectionDetail  = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($programSectionId);
      
      $programName          = Doctrine_Core::getTable('ProgramSection')->getOneProgramSectionById($programSectionId)->getProgram();
            
      $courses       = Doctrine_Core::getTable('SectionCourseOffering')->getOneBatchOneSemesterCourses($programSectionId);
      foreach($courses as $course)
          $courseIds[]  = $course->getCourseId();
      
      $sectionCourses   = Doctrine_Core::getTable('Course')->getCoursesByCourseIds($courseIds);      
      
      $html = "<h4 style='margin:0px; padding:0px;' align='center'>Public Service College of Oromia</h4>";
      $html .= "<h4 style='margin:0px; padding:0px;' align='center'>Education Team of ".$departmentName." </h4>"; 
      $html .= "<h4 style='margin:0px; padding:0px;' align='center'>Registration Slip</h4>"; 
      $html .= "<h4 style='margin:0px; padding:0px;' align='center'> ". $programName." Program </h4>";       
      $html .= "<table width='686' style='font-size:11px;'>";
      $html .= "<tr><td align='left' valign='top'>&nbsp;</td>"; 
      $html .= "<td align='left' valign='top'>&nbsp;</td></tr>"; 
      $html .= "<tr><td width='311' align='left' valign='top'>"; 
      $html .= "First Name: _________________________<br>"; 
      $html .= "Father's Name: _______________________<br>"; 
      $html .= "G.Fathers Name: ______________________ <br>"; 
      $html .= "ID.No: _____________________________<br>"; 
      $html .= "Signature: ___________________________<br>"; 
      $html .= "Date: ______________________________ </td>"; 
      $html .= "<td width='281' align='left' valign='top'>      Program: ". $programName ." <br>" ;
      $html .= "Year: ". $sectionDetail->getYear()." <br> "; 
      $html .= "Semester: ". $sectionDetail->getSemester(). "<br />    "; 
      $html .= "Academic Year: ". $sectionDetail->getAcademicYear(); 
      $html .= "</td></tr>"; 
      
      $html .= "<tr> <td> &nbsp; </td> <td> &nbsp; </td> </tr>"; 
      $html .= "</table>"; 
      $html .= "  <table width='528' border='1' cellspacing='0' style='font-size:11px;'  cellpadding='5px'>";
      $html .= "    <tr style='background-color: #000099; color:#FFFFFF'>";
      $html .= "      <td width='36'>No. </td>";
      $html .= "      <td width='138'>Course Code  </td>";
      $html .= "      <td width='250'>Course Title </td>";
      $html .= "      <td width='86'>Credit Hours </td>"; 
      $html .= "    </tr>";
      
      foreach($sectionCourses as $course )
      {
        $html .= "      <tr>        ";
        $html .= "          <td> ". $count.".  </td> ";
        $html .= "          <td> ". $course->getName()." </td>";
        $html .= "          <td> ". $course->getCourseNumber() ." </td>";
        $html .= "          <td> ". $course->getCreditHoure(); 
        $totalChr += $course->getCreditHoure();
        $html .=  "        </td>        ";
        $html .=  "     </tr> "   ;
        $count++;
      }
      
      
      $html .= "      <tr> ";
      $html .= "          <td colspan='4' align='right'> Total credit hours: ". $totalChr ."</td> ";
      $html .=  "     </tr> ";   
      $html .=  " </table>"; 

      $html .= "  <table width='686'  style='font-size:11px;'>";
      $html .= "    <tr>";
      $html .= "      <td colspan='3'>&nbsp; </td>"; 
      $html .= "    </tr>"; 
      $html .= "    <tr>";
      $html .= "      <td colspan='3'>&nbsp;</td>"; 
      $html .= "    </tr>";

      $html .= "    <tr>";
      $html .= "      <td width='311' align='center' valign='top'>Finance Officer</td>";
      $html .= "      <td width='281' align='center' valign='top'>Student Advisor (Center coordinator) </td>";
      $html .= "      <td width='281' align='center' valign='top'>Education Team </td>";
      $html .= "   </tr>"; 
      $html .= "    <tr>"; 
      $html .= "      <td align='center' valign='top'>&nbsp;</td>";
      $html .= "      <td align='center' valign='top'>&nbsp;</td>"; 
      $html .= "      <td align='center' valign='top'>&nbsp;</td>"; 
      $html .= "    </tr>"; 
      $html .= "    <tr>"; 
      $html .= "      <td align='center' valign='top'>________________________________</td>"; 
      $html .= "      <td align='center' valign='top'>________________________________</td>"; 
      $html .= "      <td align='center' valign='top'>________________________________</td>";
      $html .= "    </tr>";
      $html .= "    <tr>";
      $html .= "     <td align='center' valign='top'>Date &amp; Signature </td>";
      $html .= "      <td align='center' valign='top'>Date &amp; Signature</td>";
      $html .= "      <td align='center' valign='top'>Date &amp; Signature</td>"; 
      $html .= "    </tr>"; 
      $html .= "    <tr>"; 
      $html .= "      <td align='left' valign='top'>&nbsp;</td>"; 
      $html .= "      <td align='right' valign='top'>&nbsp;</td>"; 
      $html .=  "     <td align='right' valign='top'>&nbsp;</td>"; 
      $html .=  "   </tr>"; 
      $html .=  "   <tr>";
      $html .= "      <td colspan='3' align='left' valign='top' style='font-size:11px;'>Note:- - This Registration Form is invalid without the stamp of the education team <br>";
      $html .= "  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- Tution fee will be calculated based on credit hours. <br>";
      $html .= "  &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;- One copy should be submitted to education team (department) </td>";
      $html .= "    </tr>";

      $html .= "</table>";

      $dompdf = new DOMPDF();
      $dompdf->load_html($html);
      $dompdf->render();
      $dompdf->stream("student_semester_slip.pdf");

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
 public function executeViewStudentsToEnroll(sfWebRequest $request) 
 {
     $this->forward404Unless($program_section = Doctrine_Core::getTable('ProgramSection')->find(array($request->getParameter('sectionId'))), sprintf('Object ProgramSection does not exist (%s).', $request->getParameter('sectionId')));
     
     $this->redirect('programsection/filterToEnrollToSection/?sectionId='.$program_section->getId().'&showStudentsToEnroll=YES');
 }
 
 public function executeEnroll(sfWebRequest $request)
 {
     ## Get Request parameters
     $sectionId     = $request->getParameter('sectionId');
     $enrollmentId  = $request->getParameter('enrollmentId'); 
     $showStudentsToEnroll = $request->getParameter('showStudentsToEnroll');
     
     ## Perform Enrollment
     $enrollment = Doctrine_Core::getTable('EnrollmentInfo')->findOneById($enrollmentId);
     $this->forward404Unless($enrollment);
     
     $enrollment->setSectionId($sectionId);
     $enrollment->save(); 
     
     ## Test redirecting to where it was before
     $this->getUser()->setFlash('notice', 'Successfully Enrolled Selected Student'); 
     $this->redirect('programsection/filterToEnrollToSection/?sectionId='.$sectionId.'&showStudentsToEnroll=YES');
 }
 public function executeUnenroll(sfWebRequest $request)
 {
     ## Get Request parameters
     $sectionId     = $request->getParameter('sectionId');
     $enrollmentId  = $request->getParameter('enrollmentId'); 
     $showStudentsToEnroll = $request->getParameter('showStudentsToEnroll');
     
      ## Perform Unenrollment
     $enrollment = Doctrine_Core::getTable('EnrollmentInfo')->findOneById($enrollmentId);
     $this->forward404Unless($enrollment);
     
     $enrollment->unenroll(); 
     
     ## Test redirecting to where it was before
     $this->getUser()->setFlash('notice', 'Successfully Removed Student From Enrollment'); 
     $this->redirect('programsection/filterToEnrollToSection/?sectionId='.$sectionId.'&showStudentsToEnroll=YES');
 } 
}
