<?php

/**
 * StudentCenter form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FrontendStudentCenterForm extends BaseStudentCenterForm
{
  public function configure()
  {
	  $this->useFields(array('center_id')); 
	  //$this->setWidget('center_id',  new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Center'), 'add_empty' => 'Please select Center' )));
	  //$this->setValidator('center_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Center')))); 
          unset($this['created_at'], $this['updated_at']);  
          
         $this->setWidget('center_id',  new sfWidgetFormInputHidden(array(), array('value'=>$this->getObject()->getCenterId() )));
         $this->setValidator('center_id',  new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Center'))));
  }
}
