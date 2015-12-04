<?php 
class FrontendCourseChecklistPrerequisiteForm extends BaseForm 
{  
  private $programId = '';
  private $courseIds='';
  private $courseNumbers='';
  
  public function __construct($programId = NULL , $courseIds = NULL, $courseNumbers = NULL)
  {
    $this->programId        = $programId;
    $this->courseIds        = $courseIds;
    $this->courseNumbers    = $courseNumbers; 
    
    parent::__construct();
  }  
  public function configure()
  { 
      
      $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array('choices'=> $this->courseIds ));
      $this->validatorSchema['course_id'] = new sfValidatorNumber(); 
         
      $this->widgetSchema['course_number'] = new sfWidgetFormChoice(array(
            'multiple' => true,
            'choices' => $this->courseNumbers,
            'renderer_class' => 'sfWidgetFormSelectDoubleList',
            'renderer_options' => array(
                'associated_first' => false,
                'label_unassociated' => 'Courses To Prerequistie',
                'label_associated' => 'Prerequisite Courses'
         )));
	 $this->validatorSchema['course_number'] = new sfValidatorPass(); 
         
         
         $this->widgetSchema['program_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->programId));
         $this->validatorSchema['program_id'] = new sfValidatorNumber();         


      $this->widgetSchema->setNameFormat('coursechecklistform[%s]');
         
  }
}