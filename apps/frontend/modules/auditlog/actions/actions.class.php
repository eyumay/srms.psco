<?php

/**
 * auditlog actions.
 *
 * @package    srmsnew
 * @subpackage auditlog
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class auditlogActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->audit_logs = Doctrine_Core::getTable('AuditLog')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->audit_log = Doctrine_Core::getTable('AuditLog')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->audit_log);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new AuditLogForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new AuditLogForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($audit_log = Doctrine_Core::getTable('AuditLog')->find(array($request->getParameter('id'))), sprintf('Object audit_log does not exist (%s).', $request->getParameter('id')));
    $this->form = new AuditLogForm($audit_log);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($audit_log = Doctrine_Core::getTable('AuditLog')->find(array($request->getParameter('id'))), sprintf('Object audit_log does not exist (%s).', $request->getParameter('id')));
    $this->form = new AuditLogForm($audit_log);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($audit_log = Doctrine_Core::getTable('AuditLog')->find(array($request->getParameter('id'))), sprintf('Object audit_log does not exist (%s).', $request->getParameter('id')));
    $audit_log->delete();

    $this->redirect('auditlog/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $audit_log = $form->save();

      $this->redirect('auditlog/edit?id='.$audit_log->getId());
    }
  }
}
