<?php

/**
 * Instructor filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseInstructorFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'department_id'        => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Department'), 'add_empty' => true)),
      'academic_position_id' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'instructor_id_number' => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'date_of_birth'        => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'gender'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'picture'              => new sfWidgetFormFilterInput(),
      'title'                => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'qualification'        => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'acadamic_position'    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'town'                 => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'woreda'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'kebele'               => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'house_number'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nationality'          => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'ethnicity'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'telephone'            => new sfWidgetFormFilterInput(),
      'remark'               => new sfWidgetFormFilterInput(),
      'created_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'           => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'department_id'        => new sfValidatorDoctrineChoice(array('required' => false, 'model' => $this->getRelatedModelName('Department'), 'column' => 'id')),
      'academic_position_id' => new sfValidatorSchemaFilter('text', new sfValidatorInteger(array('required' => false))),
      'instructor_id_number' => new sfValidatorPass(array('required' => false)),
      'date_of_birth'        => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'gender'               => new sfValidatorPass(array('required' => false)),
      'picture'              => new sfValidatorPass(array('required' => false)),
      'title'                => new sfValidatorPass(array('required' => false)),
      'qualification'        => new sfValidatorPass(array('required' => false)),
      'acadamic_position'    => new sfValidatorPass(array('required' => false)),
      'town'                 => new sfValidatorPass(array('required' => false)),
      'woreda'               => new sfValidatorPass(array('required' => false)),
      'kebele'               => new sfValidatorPass(array('required' => false)),
      'house_number'         => new sfValidatorPass(array('required' => false)),
      'nationality'          => new sfValidatorPass(array('required' => false)),
      'ethnicity'            => new sfValidatorPass(array('required' => false)),
      'telephone'            => new sfValidatorPass(array('required' => false)),
      'remark'               => new sfValidatorPass(array('required' => false)),
      'created_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'           => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('instructor_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Instructor';
  }

  public function getFields()
  {
    return array(
      'id'                   => 'Number',
      'department_id'        => 'ForeignKey',
      'academic_position_id' => 'Number',
      'instructor_id_number' => 'Text',
      'date_of_birth'        => 'Date',
      'gender'               => 'Text',
      'picture'              => 'Text',
      'title'                => 'Text',
      'qualification'        => 'Text',
      'acadamic_position'    => 'Text',
      'town'                 => 'Text',
      'woreda'               => 'Text',
      'kebele'               => 'Text',
      'house_number'         => 'Text',
      'nationality'          => 'Text',
      'ethnicity'            => 'Text',
      'telephone'            => 'Text',
      'remark'               => 'Text',
      'created_at'           => 'Date',
      'updated_at'           => 'Date',
    );
  }
}
