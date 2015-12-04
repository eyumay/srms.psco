<?php

/**
 * RelatedCourses form base class.
 *
 * @method RelatedCourses getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseRelatedCoursesForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                         => new sfWidgetFormInputHidden(),
      'course_id'                  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Course'), 'add_empty' => false)),
      'prerequisite_course_number' => new sfWidgetFormInputText(),
      'course_relation_type'       => new sfWidgetFormInputText(),
      'date_from'                  => new sfWidgetFormDate(),
      'date_to'                    => new sfWidgetFormDate(),
      'created_at'                 => new sfWidgetFormDateTime(),
      'updated_at'                 => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'course_id'                  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Course'))),
      'prerequisite_course_number' => new sfValidatorString(array('max_length' => 100)),
      'course_relation_type'       => new sfValidatorString(array('max_length' => 100)),
      'date_from'                  => new sfValidatorDate(array('required' => false)),
      'date_to'                    => new sfValidatorDate(array('required' => false)),
      'created_at'                 => new sfValidatorDateTime(),
      'updated_at'                 => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'RelatedCourses', 'column' => array('course_relation_type', 'course_id', 'prerequisite_course_number')))
    );

    $this->widgetSchema->setNameFormat('related_courses[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'RelatedCourses';
  }

}
