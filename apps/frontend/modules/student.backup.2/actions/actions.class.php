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
    $this->students = Doctrine_Core::getTable('Student')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->student = Doctrine_Core::getTable('Student')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->student);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new StudentForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new StudentForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($student = Doctrine_Core::getTable('Student')->find(array($request->getParameter('id'))), sprintf('Object student does not exist (%s).', $request->getParameter('id')));
    $this->form = new StudentForm($student);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($student = Doctrine_Core::getTable('Student')->find(array($request->getParameter('id'))), sprintf('Object student does not exist (%s).', $request->getParameter('id')));
    $this->form = new StudentForm($student);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($student = Doctrine_Core::getTable('Student')->find(array($request->getParameter('id'))), sprintf('Object student does not exist (%s).', $request->getParameter('id')));
    $student->delete();

    $this->redirect('student/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $student = $form->save();

      $this->redirect('student/edit?id='.$student->getId());
    }
  }
}
