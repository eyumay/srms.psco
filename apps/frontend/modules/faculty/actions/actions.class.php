<?php

/**
 * faculty actions.
 *
 * @package    srmsnew
 * @subpackage faculty
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class facultyActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->facultys = Doctrine_Core::getTable('Faculty')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->faculty = Doctrine_Core::getTable('Faculty')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->faculty);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new FacultyForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new FacultyForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($faculty = Doctrine_Core::getTable('Faculty')->find(array($request->getParameter('id'))), sprintf('Object faculty does not exist (%s).', $request->getParameter('id')));
    $this->form = new FacultyForm($faculty);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($faculty = Doctrine_Core::getTable('Faculty')->find(array($request->getParameter('id'))), sprintf('Object faculty does not exist (%s).', $request->getParameter('id')));
    $this->form = new FacultyForm($faculty);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($faculty = Doctrine_Core::getTable('Faculty')->find(array($request->getParameter('id'))), sprintf('Object faculty does not exist (%s).', $request->getParameter('id')));
    $faculty->delete();

    $this->redirect('faculty/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $faculty = $form->save();

      $this->redirect('faculty/edit?id='.$faculty->getId());
    }
  }
}
