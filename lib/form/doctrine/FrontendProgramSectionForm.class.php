<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
class FrontendProgramSectionForm extends ProgramSectionForm
{
  private $departmentId     = NULL;

  public function __construct( $programSectionObj=NULL, $departmentId = NULL )
  {
    $this->departmentId         = $departmentId; 
    $this->programSectionObj    = $programSectionObj;
    
    parent::__construct($this->programSectionObj);
  }  
  
  public function configure()
  {
       parent::configure();
       if($this->departmentId != '')
       {
        $this->widgetSchema['program_id'] = new sfWidgetFormChoice(array(
            'choices' => Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($this->departmentId)
        ));
        $this->widgetSchema->setLabels(array(
            'program_id'=>'Program *',
        ));
       }
  }
}
