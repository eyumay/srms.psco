<?php

/**
 * PromotionSetting form base class.
 *
 * @method PromotionSetting getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BasePromotionSettingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'               => new sfWidgetFormInputHidden(),
      'program_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Program'), 'add_empty' => false)),
      'current_year'     => new sfWidgetFormInputText(),
      'current_semester' => new sfWidgetFormInputText(),
      'to_year'          => new sfWidgetFormInputText(),
      'to_semester'      => new sfWidgetFormInputText(),
      'created_at'       => new sfWidgetFormDateTime(),
      'updated_at'       => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'               => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'program_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Program'))),
      'current_year'     => new sfValidatorInteger(),
      'current_semester' => new sfValidatorInteger(),
      'to_year'          => new sfValidatorInteger(),
      'to_semester'      => new sfValidatorInteger(),
      'created_at'       => new sfValidatorDateTime(),
      'updated_at'       => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'PromotionSetting', 'column' => array('program_id', 'current_year', 'current_semester', 'to_year', 'to_semester')))
    );

    $this->widgetSchema->setNameFormat('promotion_setting[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PromotionSetting';
  }

}
