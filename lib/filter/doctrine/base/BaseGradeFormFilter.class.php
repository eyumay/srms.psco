<?php

/**
 * Grade filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseGradeFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'grade_type_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('GradeType'), 'add_empty' => true)),
      'gradechar'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'is_removable'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_repeated'   => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_calculated' => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'min_value'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'max_value'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'value'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'    => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'grade_type_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('GradeType'), 'column' => 'id')),
      'gradechar'     => new sfValidatorPass(array('required' => false)),
      'is_removable'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_repeated'   => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_calculated' => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'min_value'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'max_value'     => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'value'         => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'created_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'    => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('grade_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Grade';
  }

  public function getFields()
  {
    return array(
      'id'            => 'Number',
      'grade_type_id' => 'ForeignKey',
      'gradechar'     => 'Text',
      'is_removable'  => 'Boolean',
      'is_repeated'   => 'Boolean',
      'is_calculated' => 'Boolean',
      'min_value'     => 'Number',
      'max_value'     => 'Number',
      'value'         => 'Number',
      'created_at'    => 'Date',
      'updated_at'    => 'Date',
    );
  }
}
