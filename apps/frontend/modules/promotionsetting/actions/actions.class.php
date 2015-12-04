<?php

/**
 * promotionsetting actions.
 *
 * @package    srmsnew
 * @subpackage promotionsetting
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class promotionsettingActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    /*$this->programId = $this->getUser()->getAttribute('programId');
    $this->program = Doctrine_Core::getTable('Program')->find($this->programId);
    $this->forward404Unless($this->programId);      
      
    $this->promotion_settings = Doctrine_Core::getTable('PromotionSetting')
      ->createQuery('a')
      ->execute();
     * 
     */
      $this->getUser()->getAttributeHolder()->remove('programId');; 
      $this->redirect('curriculum/index');      
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->programId = $this->getUser()->getAttribute('programId');
    $this->program = Doctrine_Core::getTable('Program')->find($this->programId);
    $this->forward404Unless($this->programId); 
      
    $this->promotion_setting = Doctrine_Core::getTable('PromotionSetting')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->promotion_setting);
  }

  public function executeNew(sfWebRequest $request)
  {   
    $promotionsetting   = new PromotionSetting();
    
    $this->programId = $this->getUser()->getAttribute('programId');
    $this->program = Doctrine_Core::getTable('Program')->find($this->programId);
    $this->forward404Unless($this->programId);
      
    $this->form = new FrontendPromotionSettingForm($promotionsetting, $this->programId);
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->programId = $this->getUser()->getAttribute('programId');
    $this->program = Doctrine_Core::getTable('Program')->find($this->programId);
    $this->forward404Unless($this->programId); 
    $promotionSetting = new PromotionSetting();
      
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new PromotionSettingForm($promotionSetting, $this->programId);

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->programId = $this->getUser()->getAttribute('programId');
    $this->program = Doctrine_Core::getTable('Program')->find($this->programId);
    $this->forward404Unless($this->programId); 
    
    $this->forward404Unless($promotion_setting = Doctrine_Core::getTable('PromotionSetting')->find(array($request->getParameter('id'))), sprintf('Object promotion_setting does not exist (%s).', $request->getParameter('id')));
    $this->form = new FrontendPromotionSettingForm($promotion_setting, $this->programId );
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->programId = $this->getUser()->getAttribute('programId');
    $this->program = Doctrine_Core::getTable('Program')->find($this->programId);
    $this->forward404Unless($this->programId); 
      
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($promotion_setting = Doctrine_Core::getTable('PromotionSetting')->find(array($request->getParameter('id'))), sprintf('Object promotion_setting does not exist (%s).', $request->getParameter('id')));
    $this->form = new PromotionSettingForm($promotion_setting, $this->programId);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    //$request->checkCSRFProtection();

    $this->forward404Unless($promotion_setting = Doctrine_Core::getTable('PromotionSetting')->find(array($request->getParameter('id'))), sprintf('Object promotion_setting does not exist (%s).', $request->getParameter('id')));
    $promotion_setting->delete();   


    $programId=$this->getUser()->getAttribute('programId');
      $this->getUser()->setFlash('notice', 'Successfully Deleted Promotion Setting');
      $this->redirect('curriculum/programDetail?programId='.$programId);
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $promotion_setting = $form->save();
      $programId = $this->getUser()->getAttribute('programId'); 
      $this->getUser()->getAttributeHolder()->remove('programId'); 
      $this->redirect('curriculum/programDetail?programId='.$programId);
    }
  }
}
