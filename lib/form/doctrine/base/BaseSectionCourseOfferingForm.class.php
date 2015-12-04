<?php

/**
 * SectionCourseOffering form base class.
 *
 * @method SectionCourseOffering getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseSectionCourseOfferingForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'            => new sfWidgetFormInputHidden(),
      'course_id'     => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Course'), 'add_empty' => false)),
      'grade_status'  => new sfWidgetFormInputText(),
      'instructor_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Instructor'), 'add_empty' => true)),
      'section_id'    => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramSection'), 'add_empty' => false)),
      'created_at'    => new sfWidgetFormDateTime(),
      'updated_at'    => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'            => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'course_id'     => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Course'))),
      'grade_status'  => new sfValidatorInteger(),
      'instructor_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Instructor'), 'required' => false)),
      'section_id'    => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('ProgramSection'))),
      'created_at'    => new sfValidatorDateTime(),
      'updated_at'    => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'SectionCourseOffering', 'column' => array('course_id', 'section_id')))
    );

    $this->widgetSchema->setNameFormat('section_course_offering[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'SectionCourseOffering';
  }

}
