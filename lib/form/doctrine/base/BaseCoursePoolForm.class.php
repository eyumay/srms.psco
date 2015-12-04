<?php

/**
 * CoursePool form base class.
 *
 * @method CoursePool getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseCoursePoolForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                 => new sfWidgetFormInputHidden(),
      'enrollment_info_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentInfo'), 'add_empty' => false)),
      'course_id'          => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Course'), 'add_empty' => false)),
    ));

    $this->setValidators(array(
      'id'                 => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'enrollment_info_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('EnrollmentInfo'))),
      'course_id'          => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Course'))),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'CoursePool', 'column' => array('enrollment_info_id', 'course_id')))
    );

    $this->widgetSchema->setNameFormat('course_pool[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'CoursePool';
  }

}
