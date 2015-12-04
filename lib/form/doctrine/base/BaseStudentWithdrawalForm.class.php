<?php

/**
 * StudentWithdrawal form base class.
 *
 * @method StudentWithdrawal getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStudentWithdrawalForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'enrollment_info_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentInfo'), 'add_empty' => false)),
      'withdrawal_date'    => new sfWidgetFormDate(),
      'AC'                 => new sfWidgetFormInputText(),
      'remark'             => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'enrollment_info_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentInfo'))),
      'withdrawal_date'    => new sfValidatorDate(),
      'AC'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'remark'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('student_withdrawal[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StudentWithdrawal';
  }

}
