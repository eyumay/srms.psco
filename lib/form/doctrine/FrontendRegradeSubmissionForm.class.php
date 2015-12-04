<?php 
class FrontendRegradeSubmissionForm extends BaseForm
{  
  private $enrollmentInfoId = '';
  private $studentId = '';
  private $courseArray = '';
  private $gradeChoices = '';

  public function __construct($enrollmentInfoId = NULL , $studentId = NULL, $courseArray = NULL, $gradeChoices = NULL )
  {
    $this->enrollmentInfoId     = $enrollmentInfoId;
    $this->studentId            = $studentId;
    $this->courseArray          = $courseArray;
    $this->gradeChoices         = $gradeChoices;
    
    parent::__construct();
  }  
  public function configure()
  { 
         $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array(
                            'choices' => $this->courseArray ));          
	 $this->validatorSchema['course_id'] = new sfValidatorString();

         $this->widgetSchema['grade_id'] = new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getGradeChoicesAsArray($this->gradeChoices) ));
	 $this->validatorSchema['grade_id'] = new sfValidatorNumber();

         $this->widgetSchema['student_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->studentId));
         $this->validatorSchema['student_id'] = new sfValidatorNumber();
         
         $this->widgetSchema['enrollment_info_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->enrollmentInfoId));
         $this->validatorSchema['enrollment_info_id'] = new sfValidatorNumber();
         
         $this->widgetSchema->setNameFormat('regradesubmissionform[%s]');
         
  }
}