<?php

/**
 * StudentCourse form base class.
 *
 * @method StudentCourse getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStudentCourseForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'student_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Student'), 'add_empty' => false)),
      'instructor_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Instructor'), 'add_empty' => false)),
      'registration_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Registration'), 'add_empty' => false)),
      'course_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Course'), 'add_empty' => false)),
      'grade_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Grade'), 'add_empty' => false)),
      'is_repeated'          => new sfWidgetFormInputCheckbox(),
      'is_academic_repeated' => new sfWidgetFormInputCheckbox(),
      'is_dropped'           => new sfWidgetFormInputCheckbox(),
      'is_added'             => new sfWidgetFormInputCheckbox(),
      'is_leftout'           => new sfWidgetFormInputCheckbox(),
      'remark'               => new sfWidgetFormInputText(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'student_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Student'))),
      'instructor_id'        => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Instructor'))),
      'registration_id'      => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Registration'))),
      'course_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Course'))),
      'grade_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Grade'))),
      'is_repeated'          => new sfValidatorBoolean(array('required' => false)),
      'is_academic_repeated' => new sfValidatorBoolean(array('required' => false)),
      'is_dropped'           => new sfValidatorBoolean(array('required' => false)),
      'is_added'             => new sfValidatorBoolean(array('required' => false)),
      'is_leftout'           => new sfValidatorBoolean(array('required' => false)),
      'remark'               => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('student_course[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StudentCourse';
  }

}
