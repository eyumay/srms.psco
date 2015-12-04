<?php

/**
 * Instructor form base class.
 *
 * @method Instructor getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseInstructorForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'department_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => false)),
      'academic_position_id' => new sfWidgetFormInputText(),
      'instructor_id_number' => new sfWidgetFormInputText(),
      'date_of_birth'        => new sfWidgetFormDate(),
      'gender'               => new sfWidgetFormInputText(),
      'picture'              => new sfWidgetFormInputText(),
      'title'                => new sfWidgetFormInputText(),
      'qualification'        => new sfWidgetFormInputText(),
      'acadamic_position'    => new sfWidgetFormInputText(),
      'town'                 => new sfWidgetFormInputText(),
      'woreda'               => new sfWidgetFormInputText(),
      'kebele'               => new sfWidgetFormInputText(),
      'house_number'         => new sfWidgetFormInputText(),
      'nationality'          => new sfWidgetFormInputText(),
      'ethnicity'            => new sfWidgetFormInputText(),
      'telephone'            => new sfWidgetFormInputText(),
      'remark'               => new sfWidgetFormTextarea(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'department_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Department'))),
      'academic_position_id' => new sfValidatorInteger(),
      'instructor_id_number' => new sfValidatorString(array('max_length' => 250)),
      'date_of_birth'        => new sfValidatorDate(),
      'gender'               => new sfValidatorString(array('max_length' => 30)),
      'picture'              => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'title'                => new sfValidatorString(array('max_length' => 250)),
      'qualification'        => new sfValidatorString(array('max_length' => 255)),
      'acadamic_position'    => new sfValidatorString(array('max_length' => 255)),
      'town'                 => new sfValidatorString(array('max_length' => 255)),
      'woreda'               => new sfValidatorString(array('max_length' => 250)),
      'kebele'               => new sfValidatorString(array('max_length' => 250)),
      'house_number'         => new sfValidatorString(array('max_length' => 250)),
      'nationality'          => new sfValidatorString(array('max_length' => 255)),
      'ethnicity'            => new sfValidatorString(array('max_length' => 255)),
      'telephone'            => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'remark'               => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Instructor', 'column' => array('instructor_id_number')))
    );

    $this->widgetSchema->setNameFormat('instructor[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Instructor';
  }

}
