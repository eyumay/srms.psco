<?php

/**
 * CourseChecklist form base class.
 *
 * @method CourseChecklist getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCourseChecklistForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'          => new sfWidgetFormInputHidden(),
      'course_id'   => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Course'), 'add_empty' => false)),
      'program_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Program'), 'add_empty' => false)),
      'year'        => new sfWidgetFormInputText(),
      'semester'    => new sfWidgetFormInputText(),
      'course_type' => new sfWidgetFormInputText(),
      'status'      => new sfWidgetFormInputCheckbox(),
      'created_at'  => new sfWidgetFormDateTime(),
      'updated_at'  => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'          => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'course_id'   => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Course'))),
      'program_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Program'))),
      'year'        => new sfValidatorInteger(),
      'semester'    => new sfValidatorInteger(),
      'course_type' => new sfValidatorString(array('max_length' => 50, 'required' => false)),
      'status'      => new sfValidatorBoolean(array('required' => false)),
      'created_at'  => new sfValidatorDateTime(),
      'updated_at'  => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'CourseChecklist', 'column' => array('program_id', 'course_id', 'year', 'semester')))
    );

    $this->widgetSchema->setNameFormat('course_checklist[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CourseChecklist';
  }

}
