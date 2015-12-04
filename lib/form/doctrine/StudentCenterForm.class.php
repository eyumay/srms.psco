<?php

/**
 * StudentCenter form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class StudentCenterForm extends BaseStudentCenterForm
{
  public function configure()
  {
      $this->useFields(array('center_id')); 
      $this->setWidget('center_id',  new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Center'), 'add_empty' => 'Please select Center' )));
      $this->setValidator('center_id', new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Center')))); 
      $this->widgetSchema->setLabels(array(
          'center_id'=>'Center *'
      ))     ;
  }
}
