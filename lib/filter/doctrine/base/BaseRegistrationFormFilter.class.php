<?php

/**
 * Registration filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseRegistrationFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'enrollment_info_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentInfo'), 'add_empty' => true)),
      'date'               => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'is_grade_complain'  => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_reexam'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_makeup'          => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_add'             => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_drop'            => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_underloaded'     => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'is_overloaded'      => new sfWidgetFormChoice(array('choices' => array('' => 'yes or no', 1 => 'yes', 0 => 'no'))),
      'AC'                 => new sfWidgetFormFilterInput(),
      'remark'             => new sfWidgetFormFilterInput(),
      'created_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'         => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'enrollment_info_id' => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('EnrollmentInfo'), 'column' => 'id')),
      'date'               => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'is_grade_complain'  => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_reexam'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_makeup'          => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_add'             => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_drop'            => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_underloaded'     => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'is_overloaded'      => new sfValidatorChoice(array('required' => false, 'choices' => array('', 1, 0))),
      'AC'                 => new sfValidatorPass(array('required' => false)),
      'remark'             => new sfValidatorPass(array('required' => false)),
      'created_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'         => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('registration_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Registration';
  }

  public function getFields()
  {
    return array(
      'id'                 => 'Number',
      'enrollment_info_id' => 'ForeignKey',
      'date'               => 'Date',
      'is_grade_complain'  => 'Boolean',
      'is_reexam'          => 'Boolean',
      'is_makeup'          => 'Boolean',
      'is_add'             => 'Boolean',
      'is_drop'            => 'Boolean',
      'is_underloaded'     => 'Boolean',
      'is_overloaded'      => 'Boolean',
      'AC'                 => 'Text',
      'remark'             => 'Text',
      'created_at'         => 'Date',
      'updated_at'         => 'Date',
    );
  }
}
