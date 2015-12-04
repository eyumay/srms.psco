<?php

/**
 * AcademicCalendarEvents form base class.
 *
 * @method AcademicCalendarEvents getObject() Returns the current form's model object
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormGeneratedTemplate.php 29553 2010-05-20 14:33:00Z Kris.Wallsmith $
 */
abstract class BaseAcademicCalendarEventsForm extends BaseFormDoctrine
{
  public function setup()
  {
    $this->setWidgets(array(
      'id'                   => new sfWidgetFormInputHidden(),
      'event_id'             => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('CalendarEvents'), 'add_empty' => false)),
      'academic_calendar_id' => new sfWidgetFormDoctrineChoice(array('model' => $this->getRelatedModelName('AcademicCalendar'), 'add_empty' => false)),
      'start_date'           => new sfWidgetFormDate(),
      'end_date'             => new sfWidgetFormDate(),
      'created_at'           => new sfWidgetFormDateTime(),
      'updated_at'           => new sfWidgetFormDateTime(),
    ));

    $this->setValidators(array(
      'id'                   => new sfValidatorChoice(array('choices' => array($this->getObject()->get('id')), 'empty_value' => $this->getObject()->get('id'), 'required' => false)),
      'event_id'             => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('CalendarEvents'))),
      'academic_calendar_id' => new sfValidatorDoctrineChoice(array('model' => $this->getRelatedModelName('AcademicCalendar'))),
      'start_date'           => new sfValidatorDate(),
      'end_date'             => new sfValidatorDate(array('required' => false)),
      'created_at'           => new sfValidatorDateTime(),
      'updated_at'           => new sfValidatorDateTime(),
    ));

    $this->widgetSchema->setNameFormat('academic_calendar_events[%s]');

    $this->errorSchema = new sfValidatorErrorSchema($this->validatorSchema);

    $this->setupInheritance();

    parent::setup();
  }

  public function getModelName()
  {
    return 'AcademicCalendarEvents';
  }

}
