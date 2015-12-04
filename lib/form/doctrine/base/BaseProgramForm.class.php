<?php

/**
 * Program form base class.
 *
 * @method Program getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProgramForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'name'                => new sfWidgetFormInputText(),
      'department_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => false)),
      'program_type_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramType'), 'add_empty' => false)),
      'enrollment_type_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentType'), 'add_empty' => false)),
      'minor'               => new sfWidgetFormInputText(),
      'number_of_semesters' => new sfWidgetFormInputText(),
      'total_max_chr'       => new sfWidgetFormInputText(),
      'total_min_chr'       => new sfWidgetFormInputText(),
      'number_of_years'     => new sfWidgetFormInputText(),
      'max_number_of_years' => new sfWidgetFormInputText(),
      'approval_date'       => new sfWidgetFormDate(),
      'status'              => new sfWidgetFormInputCheckbox(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'name'                => new sfValidatorString(array('max_length' => 255)),
      'department_id'       => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Department'))),
      'program_type_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramType'))),
      'enrollment_type_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentType'))),
      'minor'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'number_of_semesters' => new sfValidatorInteger(),
      'total_max_chr'       => new sfValidatorInteger(),
      'total_min_chr'       => new sfValidatorInteger(),
      'number_of_years'     => new sfValidatorInteger(),
      'max_number_of_years' => new sfValidatorInteger(),
      'approval_date'       => new sfValidatorDate(array('required' => false)),
      'status'              => new sfValidatorBoolean(),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Program', 'column' => array('department_id', 'name')))
    );

    $this->widgetSchema->setNameFormat('program[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Program';
  }

}
