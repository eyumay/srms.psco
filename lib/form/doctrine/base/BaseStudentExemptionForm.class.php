<?php

/**
 * StudentExemption form base class.
 *
 * @method StudentExemption getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseStudentExemptionForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'         => new sfWidgetFormInputHidden(),
      'student_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Student'), 'add_empty' => false)),
      'course_id'  => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('Course'), 'add_empty' => false)),
      'reason'     => new sfWidgetFormInputText(),
      'grade'      => new sfWidgetFormTextarea(),
      'remark'     => new sfWidgetFormInputText(),
      'created_at' => new sfWidgetFormDateTime(),
      'updated_at' => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'         => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'student_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Student'))),
      'course_id'  => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('Course'))),
      'reason'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'grade'      => new sfValidatorString(array('required' => false)),
      'remark'     => new sfValidatorString(array('max_length' => 255, 'required' => false)),
      'created_at' => new sfValidatorDateTime(),
      'updated_at' => new sfValidatorDateTime(),
    ));

    $this->validatorSchema->setPostValidator(
      new sfValidatorDoctrineUnique(array('model' => 'StudentExemption', 'column' => array('student_id', 'course_id')))
    );

    $this->widgetSchema->setNameFormat('student_exemption[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'StudentExemption';
  }

}
