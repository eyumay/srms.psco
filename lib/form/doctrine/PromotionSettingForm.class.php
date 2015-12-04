<?php

/**
 * PromotionSetting form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PromotionSettingForm extends BaseForm
{
    //put your code here
  private $programId  = NULL;

  
  public function __construct( $promotion_obj, $programId)
  {
    $this->programId            =  $programId;    
    
    
    parent::__construct($promotion_obj);
  }  
  
  public function configure()
  { 
    //parent::configure();
    
    //$this->widgetSchema['program_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->programId));
  
    $this->widgetSchema['current_year'] = new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getYearChoices(),
    ));
    $this->widgetSchema['current_academic_year'] = new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getAcademicYear(),
    ));
    $this->widgetSchema['current_semester'] = new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getSemesterChoices() 
    ));    
    
    $this->widgetSchema['to_academic_year'] =  new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getAcademicYear(),
    ));
    
    $this->widgetSchema['to_year'] =  new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getYearChoices()    						
    ));
    
    $this->widgetSchema['to_semester'] =  new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getSemesterChoices() 
    ));    
    
    ## Validators
    $this->validatorSchema['current_academic_year'] = new sfValidatorString();
    $this->validatorSchema['current_year'] = new sfValidatorString();
    $this->validatorSchema['current_semester'] = new sfValidatorString();
    $this->validatorSchema['to_academic_year'] = new sfValidatorString();
    $this->validatorSchema['to_year'] = new sfValidatorString();
    $this->validatorSchema['to_semester'] = new sfValidatorNumber(array( 'required' => true ));  
    //$this->validatorSchema['program_id'] = new sfValidatorNumber(array( 'required' => true ));
  }
}
