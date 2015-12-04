<?php

/**
 * sectioncourseoffering actions.
 *
 * @package    srmsnew
 * @subpackage sectioncourseoffering
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class readmissionActions extends sfActions
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

  public function executeReadmissiondetail(sfWebRequest $request)
  {
    $this->student = Doctrine_Core::getTable('Student')->findOneById($request->getParameter('id'));
    $this->forward404Unless($this->student);
    
  } 
  
  public function executeReadmitstudent(sfWebRequest $request)
  {     
      $this->showReadmissionForm        = FALSE;
      $programSectionIdNamePairArray    = array();
      
      $programSectionIdNamePairArray[''] = 'Select Program Section'; 
      
      ## Create form 
      $enrollmentId = $request->getParameter('enrollmentId'); 
      $this->enrollmentDetail = Doctrine_Core::getTable('EnrollmentInfo')->findOneById($enrollmentId);
      $this->forward404Unless($this->enrollmentDetail); 
      
      $this->student = $this->enrollmentDetail->getStudent();
      
      ## get sections available
      $programSections = Doctrine_Core::getTable('ProgramSection')->getActiveProgramSectionsForReadmission($this->enrollmentDetail->getProgramId(), $this->enrollmentDetail->getYear(), $this->enrollmentDetail->getSemester() );
      if(!is_null($programSections) ) {
          
          $this->showReadmissionForm = TRUE; 
                    
          foreach($programSections as $ps)
             $programSectionIdNamePairArray[$ps->getId()] = $ps->getProgram().' at '.$ps->getCenter().' Year'.$ps->getYear().' Semester'.$ps->getSemester().', '.$ps->getAcademicYear(); 
          
             
      }
      
      ## the form
      $this->readmissionForm = new FrontendReadmissionForm($enrollmentId, $programSectionIdNamePairArray);
      
      if($request->isMethod('POST'))
      {
         $this->readmissionForm->bind($request->getParameter('readmissionform'));
         if ($this->readmissionForm->isValid())
         {
	    $formData            = $this->readmissionForm->getValues();
            
            $sectionId          = $formData['section_id'];            
            $enrollmentId          = $formData['enrollment_id']; ##ID of either ADR or WITHDRAWAL
            
            if($enrollmentId == '' || $sectionId == '')
            {
                $this->getUser()->setFlash('error', 'Error with Add Form'); 
                $this->redirect('readmission/readmitstudent/?enrollmentId='.$this->enrollmentDetail->getId());
            }
            
            $auditlog = new AuditLog();
            $auditlog->addNewLogInfo($this->getUser()->getAttribute('userId'), 'Performed Student Readmission'); 
            
            $enrollment = new EnrollmentInfo();
            $enrollment->makeEnrollment($this->enrollmentDetail, null, null, null, $sectionId, sfConfig::get('app_readmission_enrollment'));
            
            $this->getUser()->setFlash('notice', 'Student Readmission was Successful '.$enrollmentId.' '.$sectionId); 
            $this->redirect('readmission/index');                       
         }
         else
            $this->getUser()->setFlash('error', 'Error with Readmission Form'); 
      }
      
      
  }  
    
 
}
