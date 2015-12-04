<?php

/**
 * CourseChecklist form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     EyuelG
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CourseChecklistForm extends BaseCourseChecklistForm
{ 
  private $departmentId     = NULL;
  
  public function __construct($courseChecklistObj = NULL, $departmentId = NULL)
  {
    $this->departmentId     = $departmentId;
    
    
    parent::__construct($courseChecklistObj);
  }     
  public function configure()
  {
      $this->useFields(array('program_id', 'year', 'semester', 'course_type', 'status')); 
      $programIdArray  = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($this->departmentId);
      
      $this->widgetSchema['course_type'] = new sfWidgetFormChoice(array('choices'=> FormChoices::getCourseTypeChoices() )); 
      $this->setValidator['course_type'] = new sfWidgetFormChoice(array('choices'=> FormChoices::getCourseTypeChoices() )); 
  
      $this->widgetSchema['semester'] = new sfWidgetFormChoice(array('choices'=> FormChoices::getSemesterChoices() )); 
      $this->setValidator['Semester'] = new sfWidgetFormChoice(array('choices'=> FormChoices::getSemesterChoices() ));       

      $this->widgetSchema['year'] = new sfWidgetFormChoice(array('choices'=> FormChoices::getYearChoices() )); 
      $this->setValidator['year'] = new sfWidgetFormChoice(array('choices'=> FormChoices::getYearChoices() ));             

      $this->widgetSchema['program_id'] = new sfWidgetFormChoice(array('choices'=> $programIdArray ));
      $this->setValidator['program_id'] = new sfWidgetFormChoice(array('choices'=> $programIdArray ));         
      
  }
}
