<?php 
class FrontendExemptionRequestForm extends BaseForm
{  
  private $registrationId = '';
  private $studentId = '';
  private $courseArray = '';

  public function __construct($registrationId = NULL , $studentId = NULL, $courseArray = NULL )
  {
    $this->registrationId     = $registrationId;
    $this->studentId            = $studentId;
    $this->courseArray          = $courseArray;
    
    parent::__construct();
  }  
  public function configure()
  { 
         $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array(
                            'choices' => $this->courseArray ));          
	 $this->validatorSchema['course_id'] = new sfValidatorString();


         $this->widgetSchema['student_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->studentId));
         $this->validatorSchema['student_id'] = new sfValidatorNumber();
         
         $this->widgetSchema['registration_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->registrationId));
         $this->validatorSchema['registration_id'] = new sfValidatorNumber();
         
         $this->widgetSchema->setNameFormat('exemptionrequestform[%s]');
         
  }
}