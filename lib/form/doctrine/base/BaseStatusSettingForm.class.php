<?php

/**
 * StatusSetting form base class.
 *
 * @method StatusSetting getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStatusSettingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'              => new sfWidgetFormInputHidden(),
      'year'            => new sfWidgetFormInputText(),
      'semester'        => new sfWidgetFormInputText(),
      'min_grade_point' => new sfWidgetFormInputText(),
      'max_grade_point' => new sfWidgetFormInputText(),
      'status'          => new sfWidgetFormInputText(),
      'created_at'      => new sfWidgetFormDateTime(),
      'updated_at'      => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'              => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'year'            => new sfValidatorInteger(),
      'semester'        => new sfValidatorInteger(),
      'min_grade_point' => new sfValidatorNumber(),
      'max_grade_point' => new sfValidatorNumber(),
      'status'          => new sfValidatorString(array('max_length' => 50)),
      'created_at'      => new sfValidatorDateTime(),
      'updated_at'      => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('status_setting[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StatusSetting';
  }

}
