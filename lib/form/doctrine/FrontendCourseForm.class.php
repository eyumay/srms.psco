<?php 
class FrontendCourseForm extends CourseForm
{  
  private $department = '';
  private $course = '';
  
  public function __construct($course=NULL, $department = NULL)
  {
    $this->departmentId = $department;
    $this->course = $course;
    
    parent::__construct($this->course);
  }  
  public function configure()
  { 
         $this->widgetSchema['department_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->departmentId));
         $this->validatorSchema['department_id'] = new sfValidatorNumber();
         
         $this->widgetSchema['credit_houre'] = new sfWidgetFormChoice(array('choices'=> FormChoices::getCreditHourChoices() ));
         $this->validatorSchema['credit_houre'] = new sfValidatorNumber();
         
         unset($this['created_at'], $this['updated_at'], $this['aproval_date'], $this['ac_minutes']);
  }
}