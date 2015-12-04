<?php

/**
 * EnrollmentInfo form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG 
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */ 
class FrontendEnrollmentInfoForm extends BaseEnrollmentInfoForm
{
  
  private $departmentId     = NULL;
  
  public function __construct($enrollmentInfoObj, $departmentId = NULL)
  {
    $this->departmentId     = $departmentId;
    
    
    parent::__construct($enrollmentInfoObj);
  }  
  
  public function configure()
  {
    $programIdArray  = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($this->departmentId);
    $this->useFields(array('program_id', 'academic_year')); 
    ##   Student Program information
    $this->widgetSchema['academic_year'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->getObject()->getAcademicYear() ));
    /* $this->setWidget['program_id'] = new sfWidgetFormDoctrineChoice(array(
       'model' => $this->getRelatedModelName('Program'),
       'add_empty' => 'Select Program ',
    ));
     * 
     */   
    $this->widgetSchema['program_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->getObject()->getProgramId() )); 

    
    ##   Validator 
    $this->setValidator['program_id'] = new sfWidgetFormDoctrineChoice(array(
       'model' => $this->getRelatedModelName('Program'),
    )); 
    $this->validatorSchema['academic_year'] = new sfValidatorChoice(array('choices' => array_keys(FormChoices::getAcademicYear()), 'required' => true ));     
    
    unset($this['created_at'], $this['updated_at']);   
  } 
}
