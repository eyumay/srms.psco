<?php

/**
 * program actions.
 *
 * @package    srmsnew
 * @subpackage program
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class programActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->departmentId = $this->getUser()->getAttribute('departmentId');
    $this->department = Doctrine_Core::getTable('Department')->find($this->departmentId);
    $this->forward404Unless($this->department); 
    
    $this->programs = Doctrine_Core::getTable('Program')->getDeparmentPrograms($this->departmentId);
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->departmentId = $this->getUser()->getAttribute('departmentId');
    $this->department = Doctrine_Core::getTable('Department')->find($this->departmentId);
    $this->forward404Unless($this->department); 
      
    $this->program = Doctrine_Core::getTable('Program')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->program);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->departmentId = $this->getUser()->getAttribute('departmentId');
    $this->department = Doctrine_Core::getTable('Department')->find($this->departmentId);
    $this->forward404Unless($this->department); 
    
    $program = new Program(); 
    $this->form = new ProgramForm($program, $this->departmentId);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->departmentId = $this->getUser()->getAttribute('departmentId');
    $this->department = Doctrine_Core::getTable('Department')->find($this->departmentId);
    $this->forward404Unless($this->department);       
      
    $this->forward404Unless($request->isMethod(sfRequest::POST));
    
    $program = new Program(); 
    $this->form = new ProgramForm($program, $this->departmentId);

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->departmentId = $this->getUser()->getAttribute('departmentId');
    $this->department = Doctrine_Core::getTable('Department')->find($this->departmentId);
    $this->forward404Unless($this->department); 
      
    $this->forward404Unless($program = Doctrine_Core::getTable('Program')->find(array($request->getParameter('id'))), sprintf('Object program does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProgramForm($program, $this->departmentId);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->departmentId = $this->getUser()->getAttribute('departmentId');
    $this->department = Doctrine_Core::getTable('Department')->find($this->departmentId);
    $this->forward404Unless($this->department); 
      
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($program = Doctrine_Core::getTable('Program')->find(array($request->getParameter('id'))), sprintf('Object program does not exist (%s).', $request->getParameter('id')));
    $this->form = new ProgramForm($program, $this->departmentId);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($program = Doctrine_Core::getTable('Program')->find(array($request->getParameter('id'))), sprintf('Object program does not exist (%s).', $request->getParameter('id')));
    $program->delete();

    $this->redirect('program/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $program = $form->save();

      $this->redirect('program/edit?id='.$program->getId());
    }
  }
}
