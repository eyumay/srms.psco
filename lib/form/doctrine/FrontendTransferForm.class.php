<?php

/**
 * Grade form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     Eyuel G.
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FrontendTransferForm extends BaseForm
{
  private $fromSectionId        = NULL;
  private $studentId            = NULL;
  private $toSectionIdNamePair  = NULL; 

  public function __construct($studentId = NULL, $fromSectionId = NULL, $toSectionIdNamePair = NULL )
  {
    $this->fromSectionId        = $fromSectionId;
    $this->studentId                    = $studentId; 
    $this->toSectionIdNamePair                  = $toSectionIdNamePair;
    
    
    parent::__construct();
  }
   
  public function configure() 
  {
    ## SET WIDGETS$this->setWidgets(array(
    $this->setWidget( 
        'to_section_id',  new sfWidgetFormChoice(array(
                           'choices' => $this->toSectionIdNamePair,
                           'label'   => 'Move to New Section'
            )) 				
    );


    $this->setWidget( 
        'from_section_id', new sfWidgetFormInputHidden(array(), array('value'=> $this->fromSectionId) 	
    ));    
    $this->setWidget( 
        'student_id', new sfWidgetFormInputHidden(array(), array('value'=> $this->studentId) 	
    ));        

    ## SET VALIDATORS
    $this->setValidator('from_section_id', new sfValidatorNumber());
    $this->setValidator('to_section_id', new sfValidatorNumber());
    $this->setValidator('student_id', new sfValidatorNumber());
    $this->widgetSchema->setNameFormat('transferform[%s]');
  }
}

