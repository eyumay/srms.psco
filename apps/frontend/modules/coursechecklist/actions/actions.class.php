<?php

/**
 * coursechecklist actions.
 *
 * @package    srmsnew
 * @subpackage coursechecklist
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class coursechecklistActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->course_checklists = Doctrine_Core::getTable('CourseChecklist')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->course_checklist = Doctrine_Core::getTable('CourseChecklist')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->course_checklist);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CourseChecklistForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CourseChecklistForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $departmentId = $this->getUser()->getAttribute('departmentId'); 
    
    $this->forward404Unless($course_checklist = Doctrine_Core::getTable('CourseChecklist')->find(array($request->getParameter('id'))), sprintf('Object course_checklist does not exist (%s).', $request->getParameter('id')));
    $this->form = new CourseChecklistForm($course_checklist, $departmentId);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($course_checklist = Doctrine_Core::getTable('CourseChecklist')->find(array($request->getParameter('id'))), sprintf('Object course_checklist does not exist (%s).', $request->getParameter('id')));
    $this->form = new CourseChecklistForm($course_checklist);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($course_checklist = Doctrine_Core::getTable('CourseChecklist')->find(array($request->getParameter('id'))), sprintf('Object course_checklist does not exist (%s).', $request->getParameter('id')));
    $course_checklist->delete();

    $this->redirect('coursechecklist/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $course_checklist = $form->save();

      $this->redirect('coursechecklist/edit?id='.$course_checklist->getId());
    }
  }
}
