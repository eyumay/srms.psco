<?php

/**
 * User form base class.
 *
 * @method User getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseUserForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'login'              => new sfWidgetFormInputText(),
      'password'           => new sfWidgetFormInputText(),
      'first_name'         => new sfWidgetFormInputText(),
      'fathers_name'       => new sfWidgetFormInputText(),
      'grand_fathers_name' => new sfWidgetFormInputText(),
      'privilege'          => new sfWidgetFormInputText(),
      'gender'             => new sfWidgetFormInputText(),
      'email'              => new sfWidgetFormInputText(),
      'department_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => false)),
      'is_active'          => new sfWidgetFormInputCheckbox(),
      'created_at'         => new sfWidgetFormDateTime(),
      'updated_at'         => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'login'              => new sfValidatorString(array('max_length' => 100)),
      'password'           => new sfValidatorString(array('max_length' => 100)),
      'first_name'         => new sfValidatorString(array('max_length' => 100)),
      'fathers_name'       => new sfValidatorString(array('max_length' => 100)),
      'grand_fathers_name' => new sfValidatorString(array('max_length' => 100)),
      'privilege'          => new sfValidatorString(array('max_length' => 200)),
      'gender'             => new sfValidatorString(array('max_length' => 10)),
      'email'              => new sfValidatorString(array('max_length' => 100)),
      'department_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Department'))),
      'is_active'          => new sfValidatorBoolean(),
      'created_at'         => new sfValidatorDateTime(),
      'updated_at'         => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('login'))),
        new sfValidatorDoctrineUnique(array('model' => 'User', 'column' => array('email'))),
      ))
    );

    $this->widgetSchema->setNameFormat('user[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

}
