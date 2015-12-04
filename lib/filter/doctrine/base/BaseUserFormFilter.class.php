<?php

/**
 * User filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseUserFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'login'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'password'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'first_name'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fathers_name'       => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'grand_fathers_name' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'privilege'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'gender'             => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'email'              => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'department_id'      => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => true)),
      'is_active'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'login'              => new sfValidatorPass(array('required' => false)),
      'password'           => new sfValidatorPass(array('required' => false)),
      'first_name'         => new sfValidatorPass(array('required' => false)),
      'fathers_name'       => new sfValidatorPass(array('required' => false)),
      'grand_fathers_name' => new sfValidatorPass(array('required' => false)),
      'privilege'          => new sfValidatorPass(array('required' => false)),
      'gender'             => new sfValidatorPass(array('required' => false)),
      'email'              => new sfValidatorPass(array('required' => false)),
      'department_id'      => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Department'), 'column' => 'id')),
      'is_active'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('user_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'User';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'login'              => 'Text',
      'password'           => 'Text',
      'first_name'         => 'Text',
      'fathers_name'       => 'Text',
      'grand_fathers_name' => 'Text',
      'privilege'          => 'Text',
      'gender'             => 'Text',
      'email'              => 'Text',
      'department_id'      => 'ForeignKey',
      'is_active'          => 'Boolean',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
