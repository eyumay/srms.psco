<?php

/**
 * StatusSetting filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStatusSettingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'year'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'semester'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'min_grade_point' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'max_grade_point' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'status'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'      => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'year'            => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'semester'        => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'min_grade_point' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'max_grade_point' => new sfValidatorSchemaFilter('text', new sfValidatorNumber(array('required' => false))),
      'status'          => new sfValidatorPass(array('required' => false)),
      'created_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'      => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('status_setting_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StatusSetting';
  }

  public function getFields()
  {
    return array(
      'id'              => 'Number',
      'year'            => 'Number',
      'semester'        => 'Number',
      'min_grade_point' => 'Number',
      'max_grade_point' => 'Number',
      'status'          => 'Text',
      'created_at'      => 'Date',
      'updated_at'      => 'Date',
    );
  }
}
