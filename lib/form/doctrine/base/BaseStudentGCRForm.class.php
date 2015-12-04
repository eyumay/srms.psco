<?php

/**
 * StudentGCR form base class.
 *
 * @method StudentGCR getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStudentGCRForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'student_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Student'), 'add_empty' => false)),
      'program_checklist_id' => new sfWidgetFormInputText(),
      'semester'             => new sfWidgetFormInputText(),
      'total_credits'        => new sfWidgetFormInputText(),
      'total_gradepoints'    => new sfWidgetFormInputText(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'student_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Student'))),
      'program_checklist_id' => new sfValidatorInteger(),
      'semester'             => new sfValidatorInteger(),
      'total_credits'        => new sfValidatorInteger(),
      'total_gradepoints'    => new sfValidatorInteger(),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('student_gcr[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StudentGCR';
  }

}
