<?php 
class FilterForm extends BaseForm
{
  private $departmentId     = NULL; 

  public function __construct($departmentId = NULL )
  {
    $this->departmentId     = $departmentId;   
    
    parent::__construct();
  } 
  
  public function configure()
  {
    
     /*$this->setWidgets(array(
    'program_id'		=>new sfWidgetFormDoctrineChoice(array(
    						'model' => 'Program',
    						'add_empty' => 'Select Program'
    						)), 
    'academic_year'	=>new sfWidgetFormChoice(array(
    						'choices' => FormChoices::getAcademicYear(),
    						)), 
    'year'				=>new sfWidgetFormChoice(array(
    						'choices' => FormChoices::getYearChoices()    						
    						)),	 
    'semester'			=>new sfWidgetFormChoice(array(
    						'choices' => FormChoices::getSemesterChoices() 
    						)), 
    'center_id'		=>new sfWidgetFormDoctrineChoice(array(
    						'model' => 'Center',
    						'add_empty' => 'Select Center'
    						))
    ));
      * 
      */
    
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
    
    
    $this->widgetSchema->setLabels(array(
    'program_id' => 'Program',
    'academic_year' => 'Academic Year'
    ));

    $this->validatorSchema['program_id'] = new sfValidatorNumber();
    $this->validatorSchema['academic_year'] = new sfValidatorString();
    $this->validatorSchema['year'] = new sfValidatorString();
    $this->validatorSchema['semester'] = new sfValidatorNumber(array( 'required' => true ));
    $this->validatorSchema['center_id'] = new sfValidatorNumber(array( 'required' => true ));
    
    $this->widgetSchema->setNameFormat('filterform[%s]');
  }
} 