<?php

/**
 * StudentWithdrawal form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FrontendStudentWithdrawalForm extends BaseForm
{
  private $enrollmentInfoId = '';
  public function __construct( $enrollmentId = NULL )
  { 
    $this->enrollmentInfoId     = $enrollmentId;
    
    parent::__construct();
  }  
    
  public function configure()
  { 
         $this->widgetSchema['ac'] = new sfWidgetFormInput();
         $this->validatorSchema['ac'] = new sfValidatorString();

         $this->widgetSchema['remark'] = new sfWidgetFormInput();
         $this->validatorSchema['remark'] = new sfValidatorString();

         
         $this->widgetSchema['enrollment_info_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->enrollmentInfoId));
         $this->validatorSchema['enrollment_info_id'] = new sfValidatorNumber();
         
         $this->widgetSchema->setNameFormat('withdrawalform[%s]');
         
  }
  
}
