<?php 
class CourseRegistrationForm extends BaseForm  
{  
  private $studentIds = '';
  private $courseIds='';

  public function __construct($enrollmentInfoIds = NULL , $courseIds = NULL )
  {
    $this->enrollmentInfoIds = $enrollmentInfoIds;
    $this->courseIds = $courseIds;
    parent::__construct();
  }  
  public function configure()
  { 
    $this->widgetSchema['student_id'] = new sfWidgetFormChoice(array(
            'multiple' => true,
            'choices' => $this->enrollmentInfoIds,
            'renderer_class' => 'sfWidgetFormSelectDoubleList',
            'renderer_options' => array(
                'associated_first' => false,
                'label_unassociated' => 'Students to Register',
                'label_associated' => 'Registered STudents'
                )));    
    $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array(
            'multiple' => true,
            'choices' => $this->courseIds,
            'renderer_class' => 'sfWidgetFormSelectDoubleList',
            'renderer_options' => array(
                'associated_first' => false,
                'label_unassociated' => 'Courses to Assign',
                'label_associated' => 'Assigned Courses'
                )));

	 $this->validatorSchema['course_id'] = new sfValidatorPass();               
    $this->validatorSchema['student_id'] = new sfValidatorPass();	     
    
    $this->widgetSchema->setNameFormat('courseregistrationform[%s]');												 
  }
}