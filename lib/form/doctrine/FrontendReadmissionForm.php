<?php 
class FrontendReadmissionForm extends BaseForm
{  
  private $programSectionIdNamePairArray = '';
  private $enrollmentId = '';


  public function __construct($enrollmentId = NULL , $programSectionIdNamePairArray = NULL)
  {
    $this->programSectionIdNamePairArray    = $programSectionIdNamePairArray;
    $this->enrollmentId                     = $enrollmentId;

    
    parent::__construct();
  }  
  public function configure()
  { 
         $this->courseIdNamePairArray[''] = 'Select Program Sections';         
         
         $this->widgetSchema['section_id'] = new sfWidgetFormChoice(array(
                            'choices' => $this->programSectionIdNamePairArray ));          
	 $this->validatorSchema['section_id'] = new sfValidatorString();             

         $this->widgetSchema['enrollment_id'] = new sfWidgetFormInputHidden(array(), array('value'=>$this->enrollmentId));
         $this->validatorSchema['enrollment_id'] = new sfValidatorNumber();         
         
         $this->widgetSchema->setNameFormat('readmissionform[%s]');
         
  }
}