<?php

/**
 * Registration form base class.
 *
 * @method Registration getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRegistrationForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'enrollment_info_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentInfo'), 'add_empty' => false)),
      'date'               => new sfWidgetFormDate(),
      'is_grade_complain'  => new sfWidgetFormInputCheckbox(),
      'is_reexam'          => new sfWidgetFormInputCheckbox(),
      'is_makeup'          => new sfWidgetFormInputCheckbox(),
      'is_add'             => new sfWidgetFormInputCheckbox(),
      'is_drop'            => new sfWidgetFormInputCheckbox(),
      'is_underloaded'     => new sfWidgetFormInputCheckbox(),
      'is_overloaded'      => new sfWidgetFormInputCheckbox(),
      'AC'                 => new sfWidgetFormInputText(),
      'remark'             => new sfWidgetFormInputText(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'enrollment_info_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentInfo'))),
      'date'               => new sfValidatorDate(),
      'is_grade_complain'  => new sfValidatorBoolean(array('required' => false)),
      'is_reexam'          => new sfValidatorBoolean(array('required' => false)),
      'is_makeup'          => new sfValidatorBoolean(array('required' => false)),
      'is_add'             => new sfValidatorBoolean(array('required' => false)),
      'is_drop'            => new sfValidatorBoolean(array('required' => false)),
      'is_underloaded'     => new sfValidatorBoolean(array('required' => false)),
      'is_overloaded'      => new sfValidatorBoolean(array('required' => false)),
      'AC'                 => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'remark'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('registration[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Registration';
  }

}
