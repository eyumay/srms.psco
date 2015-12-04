<?php

/**
 * PromotionSetting filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BasePromotionSettingFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'program_id'       => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Program'), 'add_empty' => true)),
      'current_year'     => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'current_semester' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'to_year'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'to_semester'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'created_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'       => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'program_id'       => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Program'), 'column' => 'id')),
      'current_year'     => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'current_semester' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'to_year'          => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'to_semester'      => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'created_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'       => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('promotion_setting_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'PromotionSetting';
  }

  public function getFields()
  {
    return array(
      'id'               => 'Number',
      'program_id'       => 'ForeignKey',
      'current_year'     => 'Number',
      'current_semester' => 'Number',
      'to_year'          => 'Number',
      'to_semester'      => 'Number',
      'created_at'       => 'Date',
      'updated_at'       => 'Date',
    );
  }
}
