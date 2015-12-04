<?php 
class FrontendRegradeRequestForm extends BaseForm
{  
  private $enrollmentInfoId = '';
  private $studentId = '';
  private $courseArray = '';

  public function __construct($enrollmentInfoId = NULL , $studentId = NULL, $courseArray = NULL )
  {
    $this->enrollmentInfoId     = $enrollmentInfoId;
    $this->studentId            = $studentId;
    $this->courseArray          = $courseArray;
    
    parent::__construct();
  }  
  public function configure()
  { 
         $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array(
                            'choices' => $this->courseArray ));          
	 $this->validatorSchema['course_id'] = new sfValidatorString();

         $this->widgetSchema['regrade_reason'] = new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getRegradeTypeChoices() ));
	 $this->validatorSchema['regrade_reason'] = new sfValidatorString();

         $this->widgetSchema['ac'] = new sfWidgetFormInput();
         $this->validatorSchema['ac'] = new sfValidatorString();

         $this->widgetSchema['remark'] = new sfWidgetFormInput();
         $this->validatorSchema['remark'] = new sfValidatorString();

         $this->widgetSchema['student_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->studentId));
         $this->validatorSchema['student_id'] = new sfValidatorNumber();
         
         $this->widgetSchema['enrollment_info_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->enrollmentInfoId));
         $this->validatorSchema['enrollment_info_id'] = new sfValidatorNumber();
         
         $this->widgetSchema->setNameFormat('regraderequestform[%s]');
         
  }
}