<?php 
class FrontendCourseChecklistCategoryForm extends BaseForm 
{  
  private $programId = '';
  private $courseIds='';

  public function __construct($programId = NULL , $courseIds = NULL)
  {
    $this->programId = $programId;
    $this->courseIds = $courseIds;
    
    parent::__construct();
  }  
  public function configure()
  { 
          $this->widgetSchema['course_id'] = new sfWidgetFormChoice(array(
            'multiple' => true,
            'choices' => $this->courseIds,
            'renderer_class' => 'sfWidgetFormSelectDoubleList',
            'renderer_options' => array(
                'associated_first' => false,
                'label_unassociated' => 'Courses To Add To Curriculum',
                'label_associated' => 'Curriculum Courses'
         )));
	 $this->validatorSchema['course_id'] = new sfValidatorPass(); 
         
         
         $this->widgetSchema['program_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->programId));
         $this->validatorSchema['program_id'] = new sfValidatorNumber();         
         
         ## Choices [Radio Options]
         $this->widgetSchema['course_type'] =  new sfWidgetFormChoice(array(
          'expanded' => true,
          'choices'  => array('major' => 'Major Course', 'supportive' => 'Supportive Course', 'common' => 'Common Course'), 
         ));    
         $this->validatorSchema['course_type'] = new sfValidatorString();

      $this->widgetSchema->setNameFormat('coursechecklistform[%s]');
         
  }
}