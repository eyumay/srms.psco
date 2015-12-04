<?php

/**
 * Program form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class ProgramForm extends BaseProgramForm
{
  private $department   = '';
  private $program      = '';
  
  public function __construct($program=NULL, $department = NULL)
  {
    $this->departmentId = $department;
    $this->program      = $program;
    
    parent::__construct($this->program);
  }     
  public function configure()
  {
    $this->widgetSchema['department_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->departmentId));
    $this->validatorSchema['department_id'] = new sfValidatorNumber();
    
    unset($this['created_at'], $this['updated_at']);  
  }
}
