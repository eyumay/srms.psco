<?php

/**
 * student actions.
 *
 * @package    srmsnew
 * @subpackage student
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class studentActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->getUser()->setAttribute('activelink', 1);
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);         
        
    $studentArray = Doctrine_Core::getTable('EnrollmentInfo')->getDepartmentStudets(array_keys($programs));

    $this->pager = new sfDoctrinePager('Student',10);    
    $this->pager->getQuery()->from('Student a')->whereIn('a.id', array_keys($studentArray));  
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();  
    
    
    
    $departments = new Student();
    $this->departments = $departments->getAllDepartments();  
  }
  public function executeList(sfWebRequest $request)
  {
    $this->students = Doctrine_Core::getTable('Student')
      ->createQuery('a')
      ->execute();
  }
  

  public function executeShow(sfWebRequest $request)
  {
    $this->showEdit                 = FALSE;
    $this->showPrintGradeReport     = FALSE; 
    $this->showDelete               = FALSE;
    
    
    $this->student = Doctrine_Core::getTable('Student')->findOneById($request->getParameter('id'));
    $this->forward404Unless($this->student);
    
    if(SemesterActions::checkModifyStudentProfile($this->student))
    {
        $this->showEdit                 = TRUE;
        $this->showDelete               = TRUE;       
    }       
    
    
  }

  public function executeNew(sfWebRequest $request)
  {    
    $this->form = new StudentForm($this->getUser()->getAttribute('departmentId'));
  } 

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new StudentForm($this->getUser()->getAttribute('departmentId'));

    /*$this->processForm($request, $this->form);

    $this->setTemplate('new');
    */ 
    if($this->processForm($request, $this->form))
    {
        $this->getUser()->setFlash('notice', 'Student has been successfully admitted to a program');
        if($request->getParameter('sectionId') != '') 
            $this->redirect('programsection/sectiondetail/?id='.$request->getParameter('sectionId'));
        else
            $this->redirect('student/index');        
    } 
    else 
    {
        if($request->getParameter('sectionId') != '')
        {
            $sectionId  = $request->getParameter('sectionId');
            $this->sectionDetail = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);
            //$this->form = new StudentForm($this->getUser()->getAttribute('departmentId'), $sectionId);   
            $this->setTemplate('new');
        }
        else
        {
            $this->getUser()->setFlash('error', 'Error in form');
            $this->setTemplate('new'); // don't render createSuccess.php, but newSuccess.php
        }
    }
    //$this->setTemplate('new');    
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($student = Doctrine_Core::getTable('Student')->find(array($request->getParameter('id'))), sprintf('Object student does not exist (%s).', $request->getParameter('id')));
    $this->form = new FrontendStudentForm($student);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($student = Doctrine_Core::getTable('Student')->find(array($request->getParameter('id'))), sprintf('Object student does not exist (%s).', $request->getParameter('id')));
    $this->form = new FrontendStudentForm($student);

    $this->processForm($request, $this->form);
    
    $this->getUser()->setFlash('notice', 'Successfully updated student profile'); 
    $this->redirect('student/show/?id='.$request->getParameter('id'));
    //$this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();
    $id = $request->getParameter('id');
    $this->forward404Unless($student = Doctrine_Core::getTable('Student')->find(array($request->getParameter('id'))), sprintf('Object student does not exist (%s).', $request->getParameter('id')));
    
    $studentCenter = Doctrine_Query::create()
      ->from('StudentCenter')
      ->where('student_id =?', $id )
      ->execute();
    $this->forward404Unless($studentCenter); 

    $enrollmentInfo = Doctrine_Query::create()
      ->from('EnrollmentInfo')
      ->where('student_id =?', $id )
      ->execute();
    $this->forward404Unless($enrollmentInfo); 
            
    //$student->delete();
    $studentCenter->delete();
    $enrollmentInfo->delete();
    $student->delete();

    $this->redirect('student/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $student = $form->save();
      return true;
    }
    else{
    	return false; 
    }
  }
  public function executeFilter(sfWebRequest $request) 
  {
    $students = Doctrine_Core::getTable('Student')
      ->createQuery('a')
      ->orderBy('a.created_at DESC');

    $student_uid = $request->getParameter('student_uid');
    $studentname = $request->getParameter('studentname');
    $fstudentname = $request->getParameter('fstudentname');
    $gfstudentname = $request->getParameter('fgstudentname');
    $department = $request->getParameter('department');
    // $college = $request->getParameter('college');

    if ($student_uid == 'Enter Student Id' && $studentname == 'Enter Student Name'
           &&$fstudentname=='Enter Father Name'&&$gfstudentname=='Enter GFather Name'
           && $department == '0') { 
             $this->redirect('students_list');
    } 
            
    if ($student_uid != 'Enter Student Id') {
        $students->orWhere('a.student_uid like ?', $student_uid.'%');
    }
    if ($studentname != 'Enter Student Name') {
        $students->orWhere('a.name like ?', $studentname.'%');
    }
    if ($studentname != 'Enter Father Name') {
        $students->orWhere('a.fathers_name like ?', $fstudentname.'%');
    }
         
    $this->pager = new sfDoctrinePager('Student', 10);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
    $this->students = $students->execute();
    $departments = new Student();
    $this->departments = $departments->getAllDepartments();
    //$this->colleges = $departments->getAllColleges();
  }








  public function executeShowregistrationfilterform(sfWebRequest $request)
  {    
    $this->registrationFilterForm = new FilterForm($this->getUser()->getAttribute('departmentId'));
  }

  public function executeShowregistrationfilterformresults(sfWebRequest $request)
  {
	 $this->registrationFilterForm = new FilterForm($this->getUser()->getAttribute('departmentId'));
	 $this->processRegistrationFilterForm($request, $this->registrationFilterForm);
	 $this->setTemplate('showregistrationfilterform');    
  }  
 
  public function processRegistrationFilterForm(sfWebRequest $request, sfForm $registrationFilterForm )
  {    
    $registrationFilterForm->bind($request->getParameter('filterform'));
    if ($registrationFilterForm->isValid())
    {
		## get form values 	   
        $formData	= $this->registrationFilterForm->getValues();  
	$programId	= $formData['program_id'];
        $academicYear	= $formData['academic_year'];
	## passing $academicYear creates a problem on URL, so pass it using session 
	$this->getUser()->setAttribute('academicYear', $academicYear);
	$year		= $formData['year'];
	$semester	= $formData['semester'];
        $centerId       = $formData['center_id'];
     		 
	$this->redirect('student/showformtoregister?programId='.$programId.'&year='.$year.'&semester='.$semester.'&centerId='.$centerId ); 
    }
  } 
  
  
  public function executeShowformtoregister(sfWebRequest $request)
  {
        ## Also show filter form 
        $this->registrationFilterForm = new FilterForm($this->getUser()->getAttribute('departmentId'));
        $programId		= $request->getParameter('programId');  
        $academicYear		= $this->getUser()->getAttribute('academicYear');
        $this->getUser()->setAttribute('academicYear', NULL );
        $semester		= $request->getParameter('semester');
        $year			= $request->getParameter('year');
        $centerId               = $request->getParameter('centerId');

        ## One Batch is combination of: program_id, academic_year, year, and semester
        if(Doctrine_Core::getTable('EnrollmentInfo')
                ->checkIfEnrolledToProgram($programId, $academicYear, $year, $semester))
        {
            if(Doctrine_Core::getTable('ProgramSection')
                    ->checkIfSectionIsCreated($programId, $academicYear, $year, $semester, $centerId))
            {
                $section        = Doctrine_Core::getTable('ProgramSection')
                        ->getOneBatchCurrentSection($programId, $academicYear, $year, $semester, $centerId);  
                 
                if( Doctrine_Core::getTable('EnrollmentInfo')
                        ->checkIfEnrolledToSection($programId, $academicYear, $year, $semester, $section['id']))
                {
                    if(Doctrine_Core::getTable('SectionCourseOffering')
                                ->checkIfCourseIsDefined($section['id']))
                    {                                      
                        if(!Doctrine_Core::getTable('EnrollmentInfo')
                            ->checkIfRegisteredToSemesterCourses($programId, $academicYear, $year, $semester, $section['id']))  
                        {                                
                            $coursesToOffer = Doctrine_Core::getTable('SectionCourseOffering')
                                        ->getOneBatchOneSemesterCourses($section['id']);
                            $enrollments = Doctrine_Core::getTable('EnrollmentInfo')
                                    ->getOneBatchEnrollments($programId, $academicYear, $year, $semester, $centerId);

                            foreach($coursesToOffer as $course)
                            {
                                    $courseIds[$course->getCourseId()]          = $course->getCourse();

                            }
                            foreach($enrollments as $enrollment)
                            {
                                    $enrollmentInfoIds[$enrollment->getId()]    = $enrollment->getStudent();
                            }                                

                            ## Create the form
                            $this->registrationForm = new CourseRegistrationForm($enrollmentInfoIds, $courseIds);                                                        
                        }
                        else
                        {
                            $this->getUser()->setFlash('notice', 'This batch is already registered to Semester Courses!');
                            $this->redirect('student/showregistrationfilterform');                             
                        }
                    }
                    else
                    {
                        $this->getUser()->setFlash('notice', 'Course was not defined for this batch: Please go to course offering and define semester courses!');
                        $this->redirect('student/showregistrationfilterform');                             
                    }                            
                }
                else
                {
                    $this->getUser()->setFlash('notice', 'Filter for registration failed: This batch was not enrolled to section' );
                    $this->redirect('student/showregistrationfilterform');                        
                }
            }
            else 
            {
                $this->getUser()->setFlash('error', 'Section was not created for this batch!');
                $this->redirect('student/showregistrationfilterform');                          
            }
        }
        else
        {
                $this->getUser()->setFlash('error', 'This batch does not exist, or not Enrolled to a program');
                $this->redirect('student/showregistrationfilterform');
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
	   
	   foreach( $enrollmentInfoIds as $enrollmentId )
	   {
               $enrollmentDetail = Doctrine_Core::getTable('EnrollmentInfo')
                       ->findOneStudentEnrollmentInforById($enrollmentId);
               $checkIfStudentCanRegister = Doctrine_Core::getTable('StudentCourseGrade')
                       ->checkIfStudentCanRegister($enrollmentDetail->getStudentId(), $courseIds);
               if($checkIfStudentCanRegister)
               {
                       
                   Doctrine_Core::getTable('EnrollmentInfo')->setSemesterActionToRegistered($enrollmentId);
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
	   }
            $this->getUser()->setFlash('notice', 'Registration was successfull '.$enrollmentDetail->getStudentId());
            $this->redirect('programsection/index');
            ## Check filter combination availability [program_id, academic_year, year, semester], then return section]   

    }
  }      

  public function executeChooseProgramSection(sfWebRequest $request)
  {
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
    $orderBy='';
    $isActivated = TRUE; 
      
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
        $this->program_sections = Doctrine_Core::getTable('ProgramSection')->getAllProgramSections(array_keys($this->programs), $orderBy, TRUE );  
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
  
  public function executeAdmission(sfWebRequest $request)
  {
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);            
    
    ## Pass Program infomation         
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);       
      
    $sectionId  = $request->getParameter('sectionId');
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);
    $this->frontendStudentForm = new FrontendStudentForm();
    
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
          
          $this->student = new Student();
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
          
          $enrollment = new EnrollmentInfo();
          ## MAKE ADMISSION ENROLLMENT
          //makeEnrollment($enrollmentObj, $toAcademicYear, $toYear, $toSemester, $toSectionId, $enrollmentAction, $studentId)
          $enrollment->makeEnrollment(
                  $enrollment, 
                  $this->program_section->getAcademicYear(), 
                  $this->program_section->getYear(), 
                  $this->program_section->getSemester(), 
                  null, 
                  sfConfig::get('app_admission_enrollment'), 
                  $this->student->getId(), 
                  $this->program_section);
          
          $auditlog = new AuditLog();
          $auditlog->addNewLogInfo($this->getUser()->getAttribute('userId'), 'Performed Student Student Admission'); 
          
          $this->getUser()->setFlash('notice', 'Student Admission Was Successful '); 
          $this->redirect('student/admissionList/?sectionId='.$sectionId); 
       }
       else
          $this->getUser()->setFlash('error', 'Error With Student Admission Form'); 
    }       
    
  }   
  
  public function executeAdmissionList(sfWebRequest $request)
  {
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);            
    
    ## Pass Program infomation         
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);       
      
    $sectionId  = $request->getParameter('sectionId');
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);     

    ## GET Admissions, if there are any!
    $this->admission_enrollments = Doctrine_Core::getTable('EnrollmentInfo')->getAdmissions($this->program_section); 
        
    
  }   
  public function executeAdmissionEdit(sfWebRequest $request)
  {
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);            
    
    ## Pass Program infomation         
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId);       
      
    $sectionId  = $request->getParameter('sectionId');    
    $this->program_section = Doctrine_Core::getTable('ProgramSection')->findOneById($sectionId);     
    $this->forward404Unless($this->program_section);

    ## GET Admissions, if there are any!
    $this->admission_enrollments = Doctrine_Core::getTable('EnrollmentInfo')->getAdmissions($this->program_section);       
      
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
          $auditlog->addNewLogInfo($this->getUser()->getAttribute('userId'), 'Performed Student Admission Profile Edit'); 
          
          $this->getUser()->setFlash('notice', 'Admission Profile Edit Was Successful '); 
          $this->redirect('student/admissionList/?sectionId='.$sectionId);      
           
       }
       else
          $this->getUser()->setFlash('error', 'Error with Admission Form');     
    }
  }
  
  public function executeAdmissionDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();
    $studentId = $request->getParameter('studentId');
    $sectionId = $request->getParameter('sectionId'); 
    $this->forward404Unless($student = Doctrine_Core::getTable('Student')->find(array($request->getParameter('studentId'))), sprintf('Object student does not exist (%s).', $request->getParameter('studentId')));
    $this->forward404Unless($program_section = Doctrine_Core::getTable('ProgramSection')->find(array($request->getParameter('sectionId'))), sprintf('Object ProgramSection does not exist (%s).', $request->getParameter('sectionId')));
    
    $student->deleteAdmission(); 
    
    $this->getUser()->setFlash('notice', 'Student Admission Delete Was Successful.'); 
    $this->redirect('student/admissionList/?sectionId='.$sectionId);
  }  
  
}
