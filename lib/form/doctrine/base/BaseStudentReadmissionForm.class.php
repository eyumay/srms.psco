<?php

/**
 * StudentReadmission form base class.
 *
 * @method StudentReadmission getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStudentReadmissionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'enrollment_info_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentInfo'), 'add_empty' => false)),
      'readmission_date'   => new sfWidgetFormDate(),
      'AC'                 => new sfWidgetFormInputText(),
      'remark'             => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'enrollment_info_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentInfo'))),
      'readmission_date'   => new sfValidatorDate(),
      'AC'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'remark'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'StudentReadmission', 'column' => array('enrollment_info_id', 'readmission_date')))
    );

    $this->widgetSchema->setNameFormat('student_readmission[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StudentReadmission';
  }

}
