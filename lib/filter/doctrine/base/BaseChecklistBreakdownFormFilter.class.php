<?php

/**
 * ChecklistBreakdown filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseChecklistBreakdownFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'program_checklist_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramChecklist'), 'add_empty' => true)),
      'program_section_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramSection'), 'add_empty' => true)),
      'semester_type_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SemesterType'), 'add_empty' => true)),
      'year'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'semester'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'program_checklist_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ProgramChecklist'), 'column' => 'id')),
      'program_section_id'   => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('ProgramSection'), 'column' => 'id')),
      'semester_type_id'     => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('SemesterType'), 'column' => 'id')),
      'year'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'semester'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('checklist_breakdown_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ChecklistBreakdown';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'program_checklist_id' => 'ForeignKey',
      'program_section_id'   => 'ForeignKey',
      'semester_type_id'     => 'ForeignKey',
      'year'                 => 'Number',
      'semester'             => 'Number',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
    );
  }
}
