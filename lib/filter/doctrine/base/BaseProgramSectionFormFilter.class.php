<?php

/**
 * ProgramSection filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseProgramSectionFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'program_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Program'), 'add_empty' => true)),
      'center_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Center'), 'add_empty' => true)),
      'academic_advisor_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Instructor'), 'add_empty' => true)),
      'academic_calendar_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AcademicCalendar'), 'add_empty' => true)),
      'number_of_student'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'academic_year'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'year'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'semester'             => new sfWidgetFormFilterInput(),
      'section_number'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_activated'         => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_promoted'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'program_id'           => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Program'), 'column' => 'id')),
      'center_id'            => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Center'), 'column' => 'id')),
      'academic_advisor_id'  => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Instructor'), 'column' => 'id')),
      'academic_calendar_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('AcademicCalendar'), 'column' => 'id')),
      'number_of_student'    => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'academic_year'        => new sfValidatorPass(array('required' => false)),
      'year'                 => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'semester'             => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'section_number'       => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'is_activated'         => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_promoted'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('program_section_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProgramSection';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'program_id'           => 'ForeignKey',
      'center_id'            => 'ForeignKey',
      'academic_advisor_id'  => 'ForeignKey',
      'academic_calendar_id' => 'ForeignKey',
      'number_of_student'    => 'Number',
      'academic_year'        => 'Text',
      'year'                 => 'Number',
      'semester'             => 'Number',
      'section_number'       => 'Number',
      'is_activated'         => 'Boolean',
      'is_promoted'          => 'Boolean',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
    );
  }
}
