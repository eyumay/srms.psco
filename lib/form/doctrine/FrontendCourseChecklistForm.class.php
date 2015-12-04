<?php 
class FrontendCourseChecklistForm extends BaseForm 
{  
  private $programId = '';
  private $semester; 
  private $year; 
  private $courseIds='';

  public function __construct($programId = NULL , $courseIds = NULL, $year = NULL, $semester = NULL )
  {
    $this->programId = $programId;
    $this->courseIds = $courseIds;
    $this->year      = $year;
    $this->semester  = $semester; 
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
         
         $this->widgetSchema['year'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->year));
         $this->validatorSchema['year'] = new sfValidatorNumber();    
         
         $this->widgetSchema['semester'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->semester));
         $this->validatorSchema['semester'] = new sfValidatorNumber();         
         
         $this->widgetSchema->setNameFormat('coursechecklistform[%s]');
         
  }
}