<?php

/**
 * Grade form base class.
 *
 * @method Grade getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseGradeForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'grade_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GradeType'), 'add_empty' => false)),
      'gradechar'     => new sfWidgetFormInputText(),
      'is_removable'  => new sfWidgetFormInputCheckbox(),
      'is_repeated'   => new sfWidgetFormInputCheckbox(),
      'is_calculated' => new sfWidgetFormInputCheckbox(),
      'min_value'     => new sfWidgetFormInputText(),
      'max_value'     => new sfWidgetFormInputText(),
      'value'         => new sfWidgetFormInputText(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'grade_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('GradeType'))),
      'gradechar'     => new sfValidatorPass(),
      'is_removable'  => new sfValidatorBoolean(),
      'is_repeated'   => new sfValidatorBoolean(),
      'is_calculated' => new sfValidatorBoolean(),
      'min_value'     => new sfValidatorNumber(),
      'max_value'     => new sfValidatorNumber(),
      'value'         => new sfValidatorNumber(),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Grade', 'column' => array('gradechar')))
    );

    $this->widgetSchema->setNameFormat('grade[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Grade';
  }

}
