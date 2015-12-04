<?php

/**
 * Course form base class.
 *
 * @method Course getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCourseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'grade_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GradeType'), 'add_empty' => false)),
      'department_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => false)),
      'course_number' => new sfWidgetFormInputText(),
      'name'          => new sfWidgetFormInputText(),
      'credit_houre'  => new sfWidgetFormInputText(),
      'ac_minutes'    => new sfWidgetFormInputText(),
      'aproval_date'  => new sfWidgetFormDate(),
      'description'   => new sfWidgetFormTextarea(),
      'status'        => new sfWidgetFormInputCheckbox(),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'grade_type_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('GradeType'))),
      'department_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Department'))),
      'course_number' => new sfValidatorString(array('max_length' => 250)),
      'name'          => new sfValidatorString(array('max_length' => 250)),
      'credit_houre'  => new sfValidatorInteger(),
      'ac_minutes'    => new sfValidatorString(array('max_length' => 250, 'required' => false)),
      'aproval_date'  => new sfValidatorDate(array('required' => false)),
      'description'   => new sfValidatorString(array('max_length' => 500, 'required' => false)),
      'status'        => new sfValidatorBoolean(array('required' => false)),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'Course', 'column' => array('department_id', 'course_number')))
    );

    $this->widgetSchema->setNameFormat('course[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Course';
  }

}
