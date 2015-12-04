<?php

/**
 * StudentGCR filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStudentGCRFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'student_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Student'), 'add_empty' => true)),
      'program_checklist_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'semester'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'total_credits'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'total_gradepoints'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'student_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Student'), 'column' => 'id')),
      'program_checklist_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'semester'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_credits'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_gradepoints'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('student_gcr_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StudentGCR';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'student_id'           => 'ForeignKey',
      'program_checklist_id' => 'Number',
      'semester'             => 'Number',
      'total_credits'        => 'Number',
      'total_gradepoints'    => 'Number',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
    );
  }
}
