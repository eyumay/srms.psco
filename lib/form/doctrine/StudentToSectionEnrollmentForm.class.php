<?php 
class StudentToSectionEnrollmentForm extends BaseForm  
{  
  private $enrollmentInfoIds = '';
  private $sectionIds = '';

  public function __construct($enrollmentInfoIds = NULL, $sectionIds = NULL )
  {
    $this->enrollmentInfoIds = $enrollmentInfoIds;
    $this->sectionIds = $sectionIds;
    parent::__construct();
  }  
  public function configure()
  { 
    $this->widgetSchema['enrollment_info_id'] = new sfWidgetFormChoice(array(
            'multiple' => true,
            'choices' => $this->enrollmentInfoIds,
            'renderer_class' => 'sfWidgetFormSelectDoubleList',
            'renderer_options' => array(
                'associated_first' => false,
                'label_unassociated' => 'Available student for section enrollment',
                'label_associated' => 'Students to enroll'
                )));    
    $this->widgetSchema['section_id'] = new sfWidgetFormChoice(array('choices' => $this->sectionIds)); 
    
    $this->validatorSchema['section_id'] = new sfValidatorPass();
	 $this->validatorSchema['enrollment_info_id'] = new sfValidatorPass();                   
    
    $this->widgetSchema->setNameFormat('studenttosectionenrollmentform[%s]');												 
  }
}