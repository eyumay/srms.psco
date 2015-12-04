<?php

/**
 * ProgramSection form base class.
 *
 * @method ProgramSection getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProgramSectionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'program_id'           => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Program'), 'add_empty' => false)),
      'center_id'            => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Center'), 'add_empty' => false)),
      'academic_advisor_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Instructor'), 'add_empty' => true)),
      'academic_calendar_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AcademicCalendar'), 'add_empty' => false)),
      'number_of_student'    => new sfWidgetFormInputText(),
      'academic_year'        => new sfWidgetFormInputText(),
      'year'                 => new sfWidgetFormInputText(),
      'semester'             => new sfWidgetFormInputText(),
      'section_number'       => new sfWidgetFormInputText(),
      'is_activated'         => new sfWidgetFormInputCheckbox(),
      'is_promoted'          => new sfWidgetFormInputCheckbox(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'program_id'           => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Program'))),
      'center_id'            => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Center'))),
      'academic_advisor_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Instructor'), 'required' => false)),
      'academic_calendar_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AcademicCalendar'))),
      'number_of_student'    => new sfValidatorInteger(),
      'academic_year'        => new sfValidatorString(array('max_length' => 255)),
      'year'                 => new sfValidatorInteger(),
      'semester'             => new sfValidatorInteger(array('required' => false)),
      'section_number'       => new sfValidatorInteger(),
      'is_activated'         => new sfValidatorBoolean(array('required' => false)),
      'is_promoted'          => new sfValidatorBoolean(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'ProgramSection', 'column' => array('program_id', 'academic_year', 'year', 'semester', 'section_number', 'center_id')))
    );

    $this->widgetSchema->setNameFormat('program_section[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProgramSection';
  }

}
