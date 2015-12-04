<?php 
class FrontendExemptionGradeSubmissionForm extends BaseForm 
{  
  private $studentExemptionObj='';

  public function __construct($seObj = NULL)
  {
    $this->studentExemptionObj = $seObj;
    
    parent::__construct();
  }  
  public function configure()
  { 
    ## SET WIDGETS$this->setWidgets(array(
    $sNum   = 1;
    foreach ($this->studentExemptionObj as $seObj)
    {
        ## checkIfEnrollment is clearance enrollment

        $this->setWidget( 
            's_exemption_id'.$seObj->getId(),  new sfWidgetFormChoice(array(
                               'choices' => FormChoices::getExemptionGradeTypes(),
                               'label'   => $sNum.'. '.$seObj->getCourse()
                )) 				
        );
            
        $sNum++; 
    }  

    ## SET VALIDATORS
    foreach ($this->studentExemptionObj as $seObj)
    {
            $this->setValidator('s_exemption_id'.$seObj->getId(), new sfValidatorString());
    }
    $this->widgetSchema->setNameFormat('exemptiongradesubmissionform[%s]');
         
  }
}