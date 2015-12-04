<?php

/**
 * StudentCourseGrade filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStudentCourseGradeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'student_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Student'), 'add_empty' => true)),
      'instructor_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Instructor'), 'add_empty' => true)),
      'registration_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Registration'), 'add_empty' => true)),
      'course_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Course'), 'add_empty' => true)),
      'grade_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Grade'), 'add_empty' => true)),
      'is_repeated'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_academic_repeated' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_dropped'           => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_added'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_calculated'        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_exempted'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'regrade_status'       => new sfWidgetFormFilterInput(),
      'grade_status'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'remark'               => new sfWidgetFormFilterInput(),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'student_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Student'), 'column' => 'id')),
      'instructor_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Instructor'), 'column' => 'id')),
      'registration_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Registration'), 'column' => 'id')),
      'course_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Course'), 'column' => 'id')),
      'grade_id'             => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Grade'), 'column' => 'id')),
      'is_repeated'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_academic_repeated' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_dropped'           => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_added'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_calculated'        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_exempted'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'regrade_status'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'grade_status'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'remark'               => new sfValidatorPass(array('required' => false)),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('student_course_grade_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StudentCourseGrade';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'student_id'           => 'ForeignKey',
      'instructor_id'        => 'ForeignKey',
      'registration_id'      => 'ForeignKey',
      'course_id'            => 'ForeignKey',
      'grade_id'             => 'ForeignKey',
      'is_repeated'          => 'Boolean',
      'is_academic_repeated' => 'Boolean',
      'is_dropped'           => 'Boolean',
      'is_added'             => 'Boolean',
      'is_calculated'        => 'Boolean',
      'is_exempted'          => 'Number',
      'regrade_status'       => 'Number',
      'grade_status'         => 'Boolean',
      'remark'               => 'Text',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
    );
  }
}
