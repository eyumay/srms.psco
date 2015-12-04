<?php

/**
 * Student filter form base class.
 *
 * @package    srmsnew
 * @subpackage filter
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormFilterGeneratedTemplate.php 29570 2010-05-21 14:49:47Z Kris.Wallsmith $
 */
abstract class BaseStudentFormFilter extends BaseFormFilterDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'student_uid'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'name'                   => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'fathers_name'           => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'grandfathers_name'      => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'mother_name'            => new sfWidgetFormFilterInput(),
      'date_of_birth'          => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'admission_year'         => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'sex'                    => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'nationality'            => new sfWidgetFormFilterInput(array('with_empty' => false)),
      'photo'                  => new sfWidgetFormFilterInput(),
      'birth_location'         => new sfWidgetFormFilterInput(),
      'residence_city'         => new sfWidgetFormFilterInput(),
      'residence_woreda'       => new sfWidgetFormFilterInput(),
      'residence_kebele'       => new sfWidgetFormFilterInput(),
      'residence_house_number' => new sfWidgetFormFilterInput(),
      'ethinicity'             => new sfWidgetFormFilterInput(),
      'telephone'              => new sfWidgetFormFilterInput(),
      'email'                  => new sfWidgetFormFilterInput(),
      'created_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
      'updated_at'             => new sfWidgetFormFilterDate(array('from_date' => new sfWidgetFormDate(), 'to_date' => new sfWidgetFormDate(), 'with_empty' => false)),
    ));

    $this->setValidators(array(
      'student_uid'            => new sfValidatorPass(array('required' => false)),
      'name'                   => new sfValidatorPass(array('required' => false)),
      'fathers_name'           => new sfValidatorPass(array('required' => false)),
      'grandfathers_name'      => new sfValidatorPass(array('required' => false)),
      'mother_name'            => new sfValidatorPass(array('required' => false)),
      'date_of_birth'          => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDate(array('required' => false)), 'to_date' => new sfValidatorDateTime(array('required' => false)))),
      'admission_year'         => new sfValidatorPass(array('required' => false)),
      'sex'                    => new sfValidatorPass(array('required' => false)),
      'nationality'            => new sfValidatorPass(array('required' => false)),
      'photo'                  => new sfValidatorPass(array('required' => false)),
      'birth_location'         => new sfValidatorPass(array('required' => false)),
      'residence_city'         => new sfValidatorPass(array('required' => false)),
      'residence_woreda'       => new sfValidatorPass(array('required' => false)),
      'residence_kebele'       => new sfValidatorPass(array('required' => false)),
      'residence_house_number' => new sfValidatorPass(array('required' => false)),
      'ethinicity'             => new sfValidatorPass(array('required' => false)),
      'telephone'              => new sfValidatorPass(array('required' => false)),
      'email'                  => new sfValidatorPass(array('required' => false)),
      'created_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
      'updated_at'             => new sfValidatorDateRange(array('required' => false, 'from_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 00:00:00')), 'to_date' => new sfValidatorDateTime(array('required' => false, 'datetime_output' => 'Y-m-d 23:59:59')))),
    ));

    $this->widgetSchema->setNameFormat('student_filters[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'Student';
  }

  public function getFields()
  {
    return array(
      'id'                     => 'Number',
      'student_uid'            => 'Text',
      'name'                   => 'Text',
      'fathers_name'           => 'Text',
      'grandfathers_name'      => 'Text',
      'mother_name'            => 'Text',
      'date_of_birth'          => 'Date',
      'admission_year'         => 'Text',
      'sex'                    => 'Text',
      'nationality'            => 'Text',
      'photo'                  => 'Text',
      'birth_location'         => 'Text',
      'residence_city'         => 'Text',
      'residence_woreda'       => 'Text',
      'residence_kebele'       => 'Text',
      'residence_house_number' => 'Text',
      'ethinicity'             => 'Text',
      'telephone'              => 'Text',
      'email'                  => 'Text',
      'created_at'             => 'Date',
      'updated_at'             => 'Date',
    );
  }
}
