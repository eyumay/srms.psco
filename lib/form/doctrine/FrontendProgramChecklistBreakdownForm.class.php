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
class FrontendProgramChecklistBreakdownForm extends BaseForm {
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

    $this->widgetSchema['year'] = new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getYearChoices(),
    ));
    $this->widgetSchema['semester'] = new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getSemesterChoices(),
    ));
    $this->widgetSchema['semester_type_id'] = new sfWidgetFormChoice(array(
                            'choices' => Doctrine::getTable('SemesterType')->getAllSemesterTypesArray(),
    ));

    $this->widgetSchema['semester_min_chr'] =  new sfWidgetFormInputText();

    $this->widgetSchema['semester_max_chr'] =  new sfWidgetFormInputText();
    

    ## Validators
    $this->validatorSchema['semester_min_chr'] = new sfValidatorNumber();
    $this->validatorSchema['semester_max_chr'] = new sfValidatorNumber();
    $this->validatorSchema['semester_type_id'] = new sfValidatorNumber();
    $this->validatorSchema['year'] = new sfValidatorString();
    $this->validatorSchema['semester'] = new sfValidatorNumber(array( 'required' => true )); ;
    $this->validatorSchema['program_id'] = new sfValidatorNumber(array( 'required' => true ));

    $this->widgetSchema->setNameFormat('promotionsettingform[%s]');
  }
}

?>
