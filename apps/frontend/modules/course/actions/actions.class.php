<?php

/**
 * course actions.
 *
 * @package    srmsnew
 * @subpackage course
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class courseActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->departmentId = $this->getUser()->getAttribute('departmentId');
    $this->department = Doctrine_Core::getTable('Department')->find($this->departmentId);
    $this->forward404Unless($this->department);
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->departmentId = $this->getUser()->getAttribute('departmentId');
    $this->department = Doctrine_Core::getTable('Department')->find($this->departmentId);
    $this->forward404Unless($this->department);
    
    $this->course = Doctrine_Core::getTable('Course')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->course);
  }

  public function executeNew(sfWebRequest $request)
  {

    $this->departmentId = $this->getUser()->getAttribute('departmentId');
    $this->department = Doctrine_Core::getTable('Department')->find($this->departmentId);  
    $this->forward404Unless($this->department);
    
    $course = new Course();
    $this->form = new FrontendCourseForm($course, $this->departmentId);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->departmentId = $this->getUser()->getAttribute('departmentId');
    $this->department = Doctrine_Core::getTable('Department')->find($this->departmentId);
    $this->forward404Unless($this->department);
    
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    
    $course = new Course();
    $this->form = new FrontendCourseForm($course, $this->getUser()->getAttribute('departmentId'));

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->departmentId = $this->getUser()->getAttribute('departmentId');
    $this->department = Doctrine_Core::getTable('Department')->find($this->departmentId);
    $this->forward404Unless($this->department);
        
    $this->forward404Unless($this->course = Doctrine_Core::getTable('Course')->find(array($request->getParameter('id'))), sprintf('Object course does not exist (%s).', $request->getParameter('id')));
    
    if($this->course->checkToEdit() )
        $this->form = new FrontendCourseForm($this->course, $this->getUser()->getAttribute('departmentId'));
    else
    {
        $this->getUser()->setFlash('error', 'Unable To Edit Course Information: Possible Reasons are:
             
            (1) Course has been added to curriculum already, or 
            (2) Course is added to curriculum as prerequisite to other courses 
            Please make sure course is clear from above mentioned cases, and go back to remove course. 
');
        $this->redirect('course/index');        
    }
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($course = Doctrine_Core::getTable('Course')->find(array($request->getParameter('id'))), sprintf('Object course does not exist (%s).', $request->getParameter('id')));
    $this->form = new FrontendCourseForm($course, $this->getUser()->getAttribute('departmentId'));

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();   
    $this->forward404Unless($course = Doctrine_Core::getTable('Course')->find(array($request->getParameter('id'))), sprintf('Object course does not exist (%s).', $request->getParameter('id')));
    
    if(!$course->checkToDelete() )
    {
        $this->getUser()->setFlash('error', 'Unable To Delete Course: Possible Reasons are:
             
            (1) Course has been added to curriculum already, or 
            (2) Course is added to curriculum as prerequisite to other courses 
            Please make sure course is clear from above mentioned cases, and go back to remove course. 
');
        $this->redirect('course/index');
    } 
    else
    {
        $course->delete();
        $this->getUser()->setFlash('flash', 'Successfully Deleted Course From Program.');
        $this->redirect('course/index');    
    }
    
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $course = $form->save();
      $this->getUser()->setFlash('notice', 'Save was successful');
      $this->redirect('course/index');
    }
  }
}
