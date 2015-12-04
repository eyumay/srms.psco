<?php 
class FrontendExemptionForm extends BaseForm 
{  
  private $courseIds='';

  public function __construct($courseIds = NULL)
  {
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
         
         
      $this->widgetSchema->setNameFormat('frontendexemptionform[%s]');
         
  }
}