<?php 
class FrontendCourseAddEnrollmentForm extends BaseForm
{  
  private $courseIdNamePairArray = '';
  private $studentId = '';
  private $sectionIdNamePairArray = '';
  private $enrollmentAction = ''; 

  public function __construct($studentId = NULL , $sectionIdNamePairArray = NULL, $courseIdNamePairArray = NULL, $enrollmentAction = NULL )
  {
    $this->courseIdNamePairArray     = $courseIdNamePairArray;
    $this->studentId            = $studentId;
    $this->sectionIdNamePairArray          = $sectionIdNamePairArray;
    $this->enrollmentAction = $enrollmentAction; 
    
    parent::__construct();
  }  
  public function configure()
  { 
         $this->courseIdNamePairArray[''] = 'Select Repeatable Courses';
         $this->sectionIdNamePairArray[''] = 'Select Active Section To Enroll Student'; 
         
         $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array(
                            'choices' => $this->courseIdNamePairArray ));          
	 $this->validatorSchema['course_id'] = new sfValidatorString();
         
         $this->widgetSchema['section_id'] = new sfWidgetFormChoice(array(
                            'choices' => $this->sectionIdNamePairArray ));          
	 $this->validatorSchema['section_id'] = new sfValidatorString();         


         $this->widgetSchema['student_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->studentId));
         $this->validatorSchema['student_id'] = new sfValidatorNumber();
         
         $this->widgetSchema['enrollment_action'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->enrollmentAction));
         $this->validatorSchema['enrollment_action'] = new sfValidatorNumber();
         
         $this->widgetSchema->setNameFormat('courseaddenrollmentform[%s]');
         
  }
}