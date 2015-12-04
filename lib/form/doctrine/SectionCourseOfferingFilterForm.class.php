<?php 
class SectionCourseOfferingFilterForm extends BaseForm  
{
  private $gradeChoices     = NULL;
  private $enrollments      = NULL;
  private $courses          = NULL; 
  private $departmentId     = NULL; 

  public function __construct($departmentId = NULL )
  {
    $this->departmentId     = $departmentId;   
    
    parent::__construct();
  }    
  public function configure()
  { 

    $this->setWidget('program_id', new sfWidgetFormChoice(array(
                            'choices' => Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($this->departmentId)
    						))
    );
    
    $this->setWidget('academic_year', new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getAcademicYear(),
    						))
    );
    
    $this->setWidget('year',  new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getYearChoices()    						
    						))
    );
    
    $this->setWidget('semester', new sfWidgetFormChoice(array(
                            'choices' => FormChoices::getSemesterChoices() 
    						))
    );
    $this->setWidget('center_id', new sfWidgetFormDoctrineChoice(array(
    						'model' => 'Center',
    						'add_empty' => 'Select Center'
    						))
    );     
  
    $this->setWidget('course_id',  new sfWidgetFormDoctrineChoice(array(
							            'multiple' => true,
							            'model' => 'Course',
							            'renderer_class' => 'sfWidgetFormSelectDoubleList',
							            'renderer_options' => array(
							                'associated_first' => false,
							                'label_unassociated' => 'All courses',
							                'label_associated' => 'Semester Courses'
							                )))      
    );
    
    $this->widgetSchema->setLabels(array(
    'program_id' => 'Program',
    'academic_year' => 'Academic Year'
    ));

    $this->validatorSchema['program_id'] = new sfValidatorNumber(array( 'required' => true ));
    $this->validatorSchema['center_id'] = new sfValidatorNumber(array( 'required' => true ));
	 $this->validatorSchema['academic_year'] = new sfValidatorString(array( 'required' => true ));
    $this->validatorSchema['year'] = new sfValidatorNumber(array( 'required' => true ));
	 $this->validatorSchema['semester'] = new sfValidatorNumber(array( 'required' => true ));	                
    $this->validatorSchema['course_id'] = new sfValidatorPass();
    
    $this->widgetSchema->setNameFormat('filterform[%s]');												 
  }
}