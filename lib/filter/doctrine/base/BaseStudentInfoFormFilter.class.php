<?php

/**
 * StudentInfo filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStudentInfoFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'student_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Student'), 'add_empty' => true)),
      'program_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Program'), 'add_empty' => true)),
      'section_id'                     => new sfWidgetFormFilterInput(),
      'academic_year'                  => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'year'                           => new sfWidgetFormFilterInput(),
      'semester'                       => new sfWidgetFormFilterInput(),
      'leftout'                        => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'advisor'                        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Instructor'), 'add_empty' => true)),
      'status'                         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('StudentStatus'), 'add_empty' => true)),
      'mention'                        => new sfWidgetFormFilterInput(),
      'action'                         => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ActionOnStudent'), 'add_empty' => true)),
      'previous_chrs'                  => new sfWidgetFormFilterInput(),
      'semester_chrs'                  => new sfWidgetFormFilterInput(),
      'total_chrs'                     => new sfWidgetFormFilterInput(),
      'previous_grade_points'          => new sfWidgetFormFilterInput(),
      'semester_grade_points'          => new sfWidgetFormFilterInput(),
      'total_grade_points'             => new sfWidgetFormFilterInput(),
      'previous_repeated_chrs'         => new sfWidgetFormFilterInput(),
      'semester_repeated_chrs'         => new sfWidgetFormFilterInput(),
      'total_repeated_chrs'            => new sfWidgetFormFilterInput(),
      'previous_repeated_grade_points' => new sfWidgetFormFilterInput(),
      'semester_repeated_grade_points' => new sfWidgetFormFilterInput(),
      'total_repeated_grade_points'    => new sfWidgetFormFilterInput(),
      'program_checklist_id'           => new sfWidgetFormFilterInput(),
      'created_at'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'                     => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'student_id'                     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Student'), 'column' => 'id')),
      'program_id'                     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Program'), 'column' => 'id')),
      'section_id'                     => new sfValidatorPass(array('required' => false)),
      'academic_year'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'year'                           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'semester'                       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'leftout'                        => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'advisor'                        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Instructor'), 'column' => 'id')),
      'status'                         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('StudentStatus'), 'column' => 'id')),
      'mention'                        => new sfValidatorPass(array('required' => false)),
      'action'                         => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ActionOnStudent'), 'column' => 'id')),
      'previous_chrs'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'semester_chrs'                  => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_chrs'                     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'previous_grade_points'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'semester_grade_points'          => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_grade_points'             => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'previous_repeated_chrs'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'semester_repeated_chrs'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_repeated_chrs'            => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'previous_repeated_grade_points' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'semester_repeated_grade_points' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'total_repeated_grade_points'    => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'program_checklist_id'           => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'                     => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('student_info_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StudentInfo';
  }

  public function getFields()
  {
    return array(
      'id'                             => 'Number',
      'student_id'                     => 'ForeignKey',
      'program_id'                     => 'ForeignKey',
      'section_id'                     => 'Text',
      'academic_year'                  => 'Number',
      'year'                           => 'Number',
      'semester'                       => 'Number',
      'leftout'                        => 'Boolean',
      'advisor'                        => 'ForeignKey',
      'status'                         => 'ForeignKey',
      'mention'                        => 'Text',
      'action'                         => 'ForeignKey',
      'previous_chrs'                  => 'Number',
      'semester_chrs'                  => 'Number',
      'total_chrs'                     => 'Number',
      'previous_grade_points'          => 'Number',
      'semester_grade_points'          => 'Number',
      'total_grade_points'             => 'Number',
      'previous_repeated_chrs'         => 'Number',
      'semester_repeated_chrs'         => 'Number',
      'total_repeated_chrs'            => 'Number',
      'previous_repeated_grade_points' => 'Number',
      'semester_repeated_grade_points' => 'Number',
      'total_repeated_grade_points'    => 'Number',
      'program_checklist_id'           => 'Number',
      'created_at'                     => 'Date',
      'updated_at'                     => 'Date',
    );
  }
}
