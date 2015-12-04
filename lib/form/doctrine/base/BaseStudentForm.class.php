<?php

/**
 * Student form base class.
 *
 * @method Student getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStudentForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                     => new sfWidgetFormInputHidden(),
      'student_uid'            => new sfWidgetFormInputText(),
      'name'                   => new sfWidgetFormInputText(),
      'fathers_name'           => new sfWidgetFormInputText(),
      'grandfathers_name'      => new sfWidgetFormInputText(),
      'mother_name'            => new sfWidgetFormInputText(),
      'date_of_birth'          => new sfWidgetFormDate(),
      'admission_year'         => new sfWidgetFormInputText(),
      'sex'                    => new sfWidgetFormInputText(),
      'nationality'            => new sfWidgetFormInputText(),
      'photo'                  => new sfWidgetFormInputText(),
      'birth_location'         => new sfWidgetFormInputText(),
      'residence_city'         => new sfWidgetFormInputText(),
      'residence_woreda'       => new sfWidgetFormInputText(),
      'residence_kebele'       => new sfWidgetFormInputText(),
      'residence_house_number' => new sfWidgetFormInputText(),
      'ethinicity'             => new sfWidgetFormInputText(),
      'telephone'              => new sfWidgetFormInputText(),
      'email'                  => new sfWidgetFormInputText(),
      'created_at'             => new sfWidgetFormDateTime(),
      'updated_at'             => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                     => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'student_uid'            => new sfValidatorString(array('max_length' => 255)),
      'name'                   => new sfValidatorString(array('max_length' => 255)),
      'fathers_name'           => new sfValidatorString(array('max_length' => 255)),
      'grandfathers_name'      => new sfValidatorString(array('max_length' => 255)),
      'mother_name'            => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'date_of_birth'          => new sfValidatorDate(),
      'admission_year'         => new sfValidatorString(array('max_length' => 255)),
      'sex'                    => new sfValidatorString(array('max_length' => 255)),
      'nationality'            => new sfValidatorString(array('max_length' => 255)),
      'photo'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'birth_location'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'residence_city'         => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'residence_woreda'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'residence_kebele'       => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'residence_house_number' => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'ethinicity'             => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'telephone'              => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'email'                  => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'             => new sfValidatorDateTime(),
      'updated_at'             => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(array(
        new sfValidatorDoctrineUnique(array('model' => 'Student', 'column' => array('student_uid'))),
        new sfValidatorDoctrineUnique(array('model' => 'Student', 'column' => array('name', 'fathers_name', 'grandfathers_name', 'date_of_birth'))),
      ))
    );

    $this->widgetSchema->setNameFormat('student[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Student';
  }

}
