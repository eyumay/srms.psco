<?php

/**
 * studentcenter actions.
 *
 * @package    srmsnew
 * @subpackage studentcenter
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class studentcenterActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->student_centers = Doctrine_Core::getTable('StudentCenter')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->student_center = Doctrine_Core::getTable('StudentCenter')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->student_center);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new StudentCenterForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new StudentCenterForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($student_center = Doctrine_Core::getTable('StudentCenter')->find(array($request->getParameter('id'))), sprintf('Object student_center does not exist (%s).', $request->getParameter('id')));
    $this->form = new StudentCenterForm($student_center);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($student_center = Doctrine_Core::getTable('StudentCenter')->find(array($request->getParameter('id'))), sprintf('Object student_center does not exist (%s).', $request->getParameter('id')));
    $this->form = new StudentCenterForm($student_center);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($student_center = Doctrine_Core::getTable('StudentCenter')->find(array($request->getParameter('id'))), sprintf('Object student_center does not exist (%s).', $request->getParameter('id')));
    $student_center->delete();

    $this->redirect('studentcenter/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $student_center = $form->save();

      $this->redirect('studentcenter/edit?id='.$student_center->getId());
    }
  }
}
