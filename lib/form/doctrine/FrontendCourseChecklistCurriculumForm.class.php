<?php 
class FrontendCourseChecklistCurriculumForm extends BaseForm 
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
         

      $this->widgetSchema['year'] = new sfWidgetFormChoice(array('choices'=> FormChoices::getYearChoices() ));
      $this->validatorSchema['year'] = new sfValidatorNumber();
      
      $this->widgetSchema['semester'] = new sfWidgetFormChoice(array('choices'=> FormChoices::getSemesterChoices() ));
      $this->validatorSchema['semester'] = new sfValidatorNumber();



      $this->widgetSchema->setNameFormat('coursechecklistform[%s]');
         
  }
}