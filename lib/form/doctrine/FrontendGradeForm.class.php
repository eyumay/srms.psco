<?php

/**
 * Grade form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     Eyuel G.
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class FrontendGradeForm extends BaseForm
{
  private $gradeChoices     = NULL;
  private $enrollments      = NULL;
  private $courses          = NULL; 

  public function __construct($enrollments = NULL, $courses = NULL, $gradeChoices = NULL )
  {
    $this->gradeChoices     = $gradeChoices;
    $this->enrollments      = $enrollments;
    $this->courses          = $courses; 
    
    
    parent::__construct();
  }
   
  public function configure() 
  {
    ## SET WIDGETS$this->setWidgets(array(
    $sNum   = 1;
    foreach ($this->enrollments as $enrollment)
    {
        $this->setWidget( 
            'grade_id_'.$enrollment->getStudentId(),  new sfWidgetFormChoice(array(
                               'choices' => $this->gradeChoices,
                               'label'   => $sNum.'. '.$enrollment->getStudent()
                )) 				
        );
        $sNum++; 
    }
    $courseChoices      = array();
    $courseChoices['']   = 'Select course please';
    foreach ($this->courses as $course)
    {
        $courseChoices[$course->getCourseId()] = $course->getCourse(); 
    }
    $this->setWidget( 
        'course_id',  new sfWidgetFormChoice(array(
                           'choices' => $courseChoices,
                           'label'   => 'Select a course'
                )) 				
        );    

    ## SET VALIDATORS
    foreach ($this->enrollments as $enrollment)
    {
            $this->setValidator('grade_id_'.$enrollment->getStudentId(), new sfValidatorNumber());
    }
    $this->setValidator('course_id', new sfValidatorNumber());
    $this->widgetSchema->setNameFormat('gradeform[%s]');
  }
}

