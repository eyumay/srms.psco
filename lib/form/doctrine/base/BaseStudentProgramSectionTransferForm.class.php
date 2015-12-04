<?php

/**
 * StudentProgramSectionTransfer form base class.
 *
 * @method StudentProgramSectionTransfer getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStudentProgramSectionTransferForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'student_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Student'), 'add_empty' => false)),
      'section_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramSection'), 'add_empty' => false)),
      'to_section' => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'student_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Student'))),
      'section_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramSection'))),
      'to_section' => new sfValidatorString(array('max_length' => 200)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'StudentProgramSectionTransfer', 'column' => array('student_id', 'section_id')))
    );

    $this->widgetSchema->setNameFormat('student_program_section_transfer[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StudentProgramSectionTransfer';
  }

}
