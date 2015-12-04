<?php

/**
 * ProgramChecklist filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProgramChecklistFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'program_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Program'), 'add_empty' => true)),
      'number_of_semesters' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'total_maximum_chr'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'total_minimum_chr'   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'number_of_years'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'max_number_of_years' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'status'              => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'remark'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'program_id'          => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Program'), 'column' => 'id')),
      'number_of_semesters' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_maximum_chr'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'total_minimum_chr'   => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'number_of_years'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'max_number_of_years' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'status'              => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'remark'              => new sfValidatorPass(array('required' => false)),
      'created_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('program_checklist_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProgramChecklist';
  }

  public function getFields()
  {
    return array(
      'id'                  => 'Number',
      'program_id'          => 'ForeignKey',
      'number_of_semesters' => 'Number',
      'total_maximum_chr'   => 'Number',
      'total_minimum_chr'   => 'Number',
      'number_of_years'     => 'Number',
      'max_number_of_years' => 'Number',
      'status'              => 'Boolean',
      'remark'              => 'Text',
      'created_at'          => 'Date',
      'updated_at'          => 'Date',
    );
  }
}
