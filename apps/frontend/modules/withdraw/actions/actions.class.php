<?php

/**
 * withdraw actions.
 *
 * @package    srmsnew
 * @subpackage withdraw
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class withdrawActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->student_withdrawals = Doctrine_Core::getTable('StudentWithdrawal')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->student_withdrawal = Doctrine_Core::getTable('StudentWithdrawal')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->student_withdrawal);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->showWithdrawalForm   = FALSE;
    $enrollmentId               = null; 
    
    $studentId                  = $request->getParameter('studentId');
    $this->student              = Doctrine_Core::getTable('Student')->findOneById($studentId);
    $this->forward404Unless($this->student); 
    
    foreach($this->student->getEnrollmentInfos() as $enrollment)
    {
        if(!$enrollment->getLeftout() )
        {
            if($enrollment->getSemesterAction() == sfConfig::get('app_registered_semester_action') || $enrollment->getSemesterAction() == sfConfig::get('app_enrolled_semester_action')) {
                $enrollmentId = $enrollment->getId();
                $this->showWithdrawalForm   = TRUE; 
            }
        }
    }
    
    $this->form = new FrontendStudentWithdrawalForm($enrollmentId);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new FrontendStudentWithdrawalForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($student_withdrawal = Doctrine_Core::getTable('StudentWithdrawal')->find(array($request->getParameter('id'))), sprintf('Object student_withdrawal does not exist (%s).', $request->getParameter('id')));
    $this->form = new StudentWithdrawalForm($student_withdrawal);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($student_withdrawal = Doctrine_Core::getTable('StudentWithdrawal')->find(array($request->getParameter('id'))), sprintf('Object student_withdrawal does not exist (%s).', $request->getParameter('id')));
    $this->form = new StudentWithdrawalForm($student_withdrawal);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($student_withdrawal = Doctrine_Core::getTable('StudentWithdrawal')->find(array($request->getParameter('id'))), sprintf('Object student_withdrawal does not exist (%s).', $request->getParameter('id')));
    $student_withdrawal->delete();

    $this->redirect('withdraw/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $student_withdrawal = $form->save();

      $this->redirect('withdraw/edit?id='.$student_withdrawal->getId());
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

  public function executeWithdrawstudent(sfWebRequest $request)
  {
    $this->showWithdrawalForm   = FALSE;
    $enrollmentId               = null; 
    
    $studentId                  = $request->getParameter('studentId');
    $this->student              = Doctrine_Core::getTable('Student')->findOneById($studentId);
    $this->forward404Unless($this->student); 
    
    foreach($this->student->getEnrollmentInfos() as $enrollment)
    {
        if(!$enrollment->getLeftout() )
        {
            if($enrollment->getSemesterAction() == sfConfig::get('app_registered_semester_action') || $enrollment->getSemesterAction() == sfConfig::get('app_enrolled_semester_action')) {
                $enrollmentId = $enrollment->getId();
                $this->showWithdrawalForm   = TRUE; 
            }
        }
    }
    
    $this->withdrawalForm = new FrontendStudentWithdrawalForm($enrollmentId);
  
    if($request->isMethod('POST'))
    {
       $this->withdrawalForm->bind($request->getParameter('withdrawalform'));
       if ($this->withdrawalForm->isValid())
       {
          $formData            = $this->withdrawalForm->getValues();

          $ac          = $formData['ac'];            
          $remark          = $formData['remark'];            
          $enrollmentId          = $formData['enrollment_info_id']; ##ID of either ADR or WITHDRAWAL

          if($enrollmentId == '' || $ac == '')
          {
              $this->getUser()->setFlash('error', 'Error with Add Form'); 
              $this->redirect('readmission/withdraw/?studentId='.$this->student->getId());
          }

          $studentWitdrawal = new StudentWithdrawal();
          $studentWitdrawal->setEnrollmentInfoId($enrollmentId);
          $studentWitdrawal->setAC($ac);
          $studentWitdrawal->setRemark($remark);
          $studentWitdrawal->setWithdrawalDate(date('Y-m-d H:m:s'));
          $studentWitdrawal->save(); 

          $enrollmentToWithdraw = Doctrine_Core::getTable('EnrollmentInfo')->findOneById($enrollmentId); 
          $enrollmentToWithdraw->withdrawEnrollment();
          $enrollmentToWithdraw->save();
   
          $auditlog = new AuditLog();
          $auditlog->addNewLogInfo($this->getUser()->getAttribute('userId'), 'Performed Student Withdrawal'); 
          
          $this->getUser()->setFlash('notice', 'Student Withdrawal was Successful '); 
          $this->redirect('withdraw/index');      
           
       }
       else
          $this->getUser()->setFlash('error', 'Error with Withdrawal Form'); 
    }  
  }
  
}
