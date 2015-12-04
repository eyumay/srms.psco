<?php

/**
 * PromotionSetting form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PromotionSettingForm extends BasePromotionSettingForm
{
    //put your code here
  private $currentAcademicYear  = NULL;
  private $currentYear          = NULL;
  private $currentSemester      = NULL;
  private $sectionId            = NULL;
  
  public function __construct( $sectiontId = NULL, $currAcademicYear=NULL, $currYear=NULL, $currSemester=NULL)
  {
    $this->sectionId            = $sectiontId;    
    $this->currentAcademicYear  = $currAcademicYear;
    $this->currentYear          = $currYear;
    $this->currentSemester      = $currSemester;
    
    
    parent::__construct();
  }  
  
  public function configure()
  { 
    /* $this->widgetSchema['section_id'] = new sfWidgetFormInputHidden( array(), array('value'=>$this->sectionId) );
    $this->widgetSchema['current_year'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->currentYear));
    $this->widgetSchema['current_academic_year'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->currentAcademicYear));
    $this->widgetSchema['current_semester'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->currentSemester));
     * 
     */
    
    $this->widgetSchema['program_id'] = new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Program'), 'add_empty' => 'Please select Program' ));
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
  }
}
