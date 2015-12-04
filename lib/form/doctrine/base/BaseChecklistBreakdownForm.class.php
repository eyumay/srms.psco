<?php

/**
 * ChecklistBreakdown form base class.
 *
 * @method ChecklistBreakdown getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseChecklistBreakdownForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'program_checklist_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramChecklist'), 'add_empty' => false)),
      'program_section_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramSection'), 'add_empty' => false)),
      'semester_type_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('SemesterType'), 'add_empty' => false)),
      'year'                 => new sfWidgetFormInputText(),
      'semester'             => new sfWidgetFormInputText(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'program_checklist_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramChecklist'))),
      'program_section_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramSection'))),
      'semester_type_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('SemesterType'))),
      'year'                 => new sfValidatorInteger(),
      'semester'             => new sfValidatorInteger(),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('checklist_breakdown[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'ChecklistBreakdown';
  }

}
