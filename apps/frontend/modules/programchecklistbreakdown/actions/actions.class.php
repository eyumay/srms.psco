<?php

/**
 * programchecklistbreakdown actions.
 *
 * @package    srmsnew
 * @subpackage programchecklistbreakdown
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class programchecklistbreakdownActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->program_checklist_breakdowns = Doctrine_Core::getTable('ProgramChecklistBreakdown')
      ->createQuery('a')
      ->execute();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->program_checklist_breakdown = Doctrine_Core::getTable('ProgramChecklistBreakdown')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->program_checklist_breakdown);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new ProgramChecklistBreakdownForm();
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new ProgramChecklistBreakdownForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($program_checklist_breakdown = Doctrine_Core::getTable('ProgramChecklistBreakdown')->find(array($request->getParameter('id'))), sprintf('Object program_checklist_breakdown does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProgramChecklistBreakdownForm($program_checklist_breakdown);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($program_checklist_breakdown = Doctrine_Core::getTable('ProgramChecklistBreakdown')->find(array($request->getParameter('id'))), sprintf('Object program_checklist_breakdown does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProgramChecklistBreakdownForm($program_checklist_breakdown);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404Unless($program_checklist_breakdown = Doctrine_Core::getTable('ProgramChecklistBreakdown')->find(array($request->getParameter('id'))), sprintf('Object program_checklist_breakdown does not exist (%s).', $request->getParameter('id')));
    $program_checklist_breakdown->delete();

     $programId=$this->getUser()->getAttribute('programId');
     $this->getUser()->setFlash('notice', 'Successfully Deleted Program Checklist');
      $this->redirect('curriculum/programDetail?programId='.$programId);
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $program_checklist_breakdown = $form->save();

      $this->redirect('programchecklistbreakdown/edit?id='.$program_checklist_breakdown->getId());
    }
  }
}
