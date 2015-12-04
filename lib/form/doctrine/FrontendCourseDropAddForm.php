<?php 
class FrontendCourseDropAddForm extends BaseForm  
{
  public function __construct($studentIdsArray = NULL, $courseIdsArray = NULL )
  {
    $this->courseIdsArray       = $courseIdsArray;   
    $this->studentIdsArray      = $studentIdsArray;         
    
    parent::__construct();
  }    
  public function configure()
  { 

    $this->widgetSchema['student_id'] = new sfWidgetFormChoice(array(
            'multiple' => true,
            'choices' => $this->studentIdsArray,
            'renderer_class' => 'sfWidgetFormSelectDoubleList',
            'renderer_options' => array(
                'associated_first' => false,
                'label_unassociated' => 'Students',
                'label_associated' => 'Dropping Student'
                )));        
    $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array(
            'multiple' => true,
            'choices' => $this->courseIdsArray,
            'renderer_class' => 'sfWidgetFormSelectDoubleList',
            'renderer_options' => array(
                'associated_first' => false,
                'label_unassociated' => 'Droppable courses',
                'label_associated' => 'Course to drop'
                ))); 
    
    
    $this->validatorSchema['course_id'] = new sfValidatorPass();
    $this->validatorSchema['student_id'] = new sfValidatorPass();
    
    $this->widgetSchema->setNameFormat('studentCourseDropForm[%s]');												 
  }
}