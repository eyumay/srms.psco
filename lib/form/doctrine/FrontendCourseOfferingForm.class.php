<?php 
class FrontendCourseOfferingForm extends BaseForm  
{
  public function __construct($courseChecklist = NULL )
  {
    $this->courseChecklist     = $courseChecklist;   
    
    parent::__construct();
  }    
  public function configure()
  { 

    $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array(
            'multiple' => true,
            'choices' => $this->courseChecklist,
            'renderer_class' => 'sfWidgetFormSelectDoubleList',
            'renderer_options' => array(
                'associated_first' => false,
                'label_unassociated' => 'Allowed courses',
                'label_associated' => 'Courses to offer'
                )));        
    $this->validatorSchema['course_id'] = new sfValidatorPass();
    
    $this->widgetSchema->setNameFormat('courseChecklist[%s]');												 
  }
}