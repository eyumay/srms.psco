<?php

/**
 * Program filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProgramFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'name'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'department_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => true)),
      'program_type_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramType'), 'add_empty' => true)),
      'enrollment_type_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentType'), 'add_empty' => true)),
      'minor'               => new sfWidgetFormFilterInput(),
      'number_of_semesters' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'total_max_chr'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'total_min_chr'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'number_of_years'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'max_number_of_years' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'approval_date'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate())),
      'status'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'name'                => new sfValidatorPass(array('required' => false)),
      'department_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Department'), 'column' => 'id')),
      'program_type_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ProgramType'), 'column' => 'id')),
      'enrollment_type_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('EnrollmentType'), 'column' => 'id')),
      'minor'               => new sfValidatorPass(array('required' => false)),
      'number_of_semesters' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_max_chr'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_min_chr'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'number_of_years'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'max_number_of_years' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'approval_date'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'status'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('program_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Program';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'name'                => 'Text',
      'department_id'       => 'ForeignKey',
      'program_type_id'     => 'ForeignKey',
      'enrollment_type_id'  => 'ForeignKey',
      'minor'               => 'Text',
      'number_of_semesters' => 'Number',
      'total_max_chr'       => 'Number',
      'total_min_chr'       => 'Number',
      'number_of_years'     => 'Number',
      'max_number_of_years' => 'Number',
      'approval_date'       => 'Date',
      'status'              => 'Boolean',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
    );
  }
}
