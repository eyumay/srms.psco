<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FrontendPromotionSetting
 *
 * @author eyumay
 */
class FrontendPromotionSettingForm extends BaseForm {
    //put your code here
  private $programId     = NULL;

  public function __construct( $programId = NULL )
  {
    $this->programId     = $programId;
    
    parent::__construct();
  }  
  
  public function configure()
  {
    $this->widgetSchema['program_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->programId));

    $this->widgetSchema['current_year'] = new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getYearChoices(),
    ));

    $this->widgetSchema['current_semester'] = new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getSemesterChoices()
    ));

    $this->widgetSchema['to_year'] =  new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getYearChoices()
    ));

    $this->widgetSchema['to_semester'] =  new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getSemesterChoices()
    ));

    ## Validators
    $this->validatorSchema['current_year'] = new sfValidatorString();
    $this->validatorSchema['current_semester'] = new sfValidatorString();
    $this->validatorSchema['to_year'] = new sfValidatorString();
    $this->validatorSchema['to_semester'] = new sfValidatorNumber(array( 'required' => true )); ;
    $this->validatorSchema['program_id'] = new sfValidatorNumber(array( 'required' => true ));

    $this->widgetSchema->setNameFormat('promotionsettingform[%s]');
  }
}

?>
