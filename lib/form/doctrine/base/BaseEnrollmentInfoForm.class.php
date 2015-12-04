<?php

/**
 * EnrollmentInfo form base class.
 *
 * @method EnrollmentInfo getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseEnrollmentInfoForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                             => new sfWidgetFormInputHidden(),
      'student_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Student'), 'add_empty' => false)),
      'student_uid'                    => new sfWidgetFormInputText(),
      'program_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Program'), 'add_empty' => false)),
      'section_id'                     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramSection'), 'add_empty' => true)),
      'academic_year'                  => new sfWidgetFormInputText(),
      'year'                           => new sfWidgetFormInputText(),
      'semester'                       => new sfWidgetFormInputText(),
      'leftout'                        => new sfWidgetFormInputCheckbox(),
      'academic_status'                => new sfWidgetFormInputText(),
      'semester_action'                => new sfWidgetFormInputText(),
      'payment_status'                 => new sfWidgetFormInputText(),
      'enrollment_action'              => new sfWidgetFormInputText(),
      'mention'                        => new sfWidgetFormInputText(),
      'previous_chrs'                  => new sfWidgetFormInputText(),
      'semester_chrs'                  => new sfWidgetFormInputText(),
      'total_chrs'                     => new sfWidgetFormInputText(),
      'previous_grade_points'          => new sfWidgetFormInputText(),
      'semester_grade_points'          => new sfWidgetFormInputText(),
      'total_grade_points'             => new sfWidgetFormInputText(),
      'previous_repeated_chrs'         => new sfWidgetFormInputText(),
      'semester_repeated_chrs'         => new sfWidgetFormInputText(),
      'total_repeated_chrs'            => new sfWidgetFormInputText(),
      'previous_repeated_grade_points' => new sfWidgetFormInputText(),
      'semester_repeated_grade_points' => new sfWidgetFormInputText(),
      'total_repeated_grade_points'    => new sfWidgetFormInputText(),
      'program_checklist_id'           => new sfWidgetFormInputText(),
      'created_at'                     => new sfWidgetFormDateTime(),
      'updated_at'                     => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                             => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'student_id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Student'))),
      'student_uid'                    => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'program_id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Program'))),
      'section_id'                     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramSection'), 'required' => false)),
      'academic_year'                  => new sfValidatorString(array('max_length' => 10)),
      'year'                           => new sfValidatorInteger(array('required' => false)),
      'semester'                       => new sfValidatorInteger(array('required' => false)),
      'leftout'                        => new sfValidatorBoolean(array('required' => false)),
      'academic_status'                => new sfValidatorInteger(array('required' => false)),
      'semester_action'                => new sfValidatorInteger(array('required' => false)),
      'payment_status'                 => new sfValidatorInteger(array('required' => false)),
      'enrollment_action'              => new sfValidatorInteger(array('required' => false)),
      'mention'                        => new sfValidatorString(array('max_length' => 5, 'required' => false)),
      'previous_chrs'                  => new sfValidatorInteger(array('required' => false)),
      'semester_chrs'                  => new sfValidatorInteger(array('required' => false)),
      'total_chrs'                     => new sfValidatorInteger(array('required' => false)),
      'previous_grade_points'          => new sfValidatorNumber(array('required' => false)),
      'semester_grade_points'          => new sfValidatorNumber(array('required' => false)),
      'total_grade_points'             => new sfValidatorNumber(array('required' => false)),
      'previous_repeated_chrs'         => new sfValidatorNumber(array('required' => false)),
      'semester_repeated_chrs'         => new sfValidatorNumber(array('required' => false)),
      'total_repeated_chrs'            => new sfValidatorNumber(array('required' => false)),
      'previous_repeated_grade_points' => new sfValidatorNumber(array('required' => false)),
      'semester_repeated_grade_points' => new sfValidatorNumber(array('required' => false)),
      'total_repeated_grade_points'    => new sfValidatorNumber(array('required' => false)),
      'program_checklist_id'           => new sfValidatorInteger(array('required' => false)),
      'created_at'                     => new sfValidatorDateTime(),
      'updated_at'                     => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('enrollment_info[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'EnrollmentInfo';
  }

}
