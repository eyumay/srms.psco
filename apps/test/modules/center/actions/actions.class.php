<?php

/**
 * center actions.
 *
 * @package    srmsnew
 * @subpackage center
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class centerActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->centers = Doctrine_Core::getTable('Center')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->center = Doctrine_Core::getTable('Center')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->center);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CenterForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CenterForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($center = Doctrine_Core::getTable('Center')->find(array($request->getParameter('id'))), sprintf('Object center does not exist (%s).', $request->getParameter('id')));
    $this->form = new CenterForm($center);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($center = Doctrine_Core::getTable('Center')->find(array($request->getParameter('id'))), sprintf('Object center does not exist (%s).', $request->getParameter('id')));
    $this->form = new CenterForm($center);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($center = Doctrine_Core::getTable('Center')->find(array($request->getParameter('id'))), sprintf('Object center does not exist (%s).', $request->getParameter('id')));
    $center->delete();

    $this->redirect('center/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $center = $form->save();

      $this->redirect('center/edit?id='.$center->getId());
    }
  }
}
