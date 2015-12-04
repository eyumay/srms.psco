<?php

/**
 * ProgramChecklist form base class.
 *
 * @method ProgramChecklist getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseProgramChecklistForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                  => new sfWidgetFormInputHidden(),
      'program_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Program'), 'add_empty' => false)),
      'number_of_semesters' => new sfWidgetFormInputText(),
      'total_maximum_chr'   => new sfWidgetFormInputText(),
      'total_minimum_chr'   => new sfWidgetFormInputText(),
      'number_of_years'     => new sfWidgetFormInputText(),
      'max_number_of_years' => new sfWidgetFormInputText(),
      'status'              => new sfWidgetFormInputCheckbox(),
      'remark'              => new sfWidgetFormTextarea(),
      'created_at'          => new sfWidgetFormDateTime(),
      'updated_at'          => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                  => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'program_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Program'))),
      'number_of_semesters' => new sfValidatorInteger(),
      'total_maximum_chr'   => new sfValidatorInteger(),
      'total_minimum_chr'   => new sfValidatorInteger(),
      'number_of_years'     => new sfValidatorInteger(),
      'max_number_of_years' => new sfValidatorInteger(),
      'status'              => new sfValidatorBoolean(array('required' => false)),
      'remark'              => new sfValidatorString(array('max_length' => 4000)),
      'created_at'          => new sfValidatorDateTime(),
      'updated_at'          => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'ProgramChecklist', 'column' => array('program_id')))
    );

    $this->widgetSchema->setNameFormat('program_checklist[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ProgramChecklist';
  }

}
