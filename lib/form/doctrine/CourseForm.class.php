<?php

/**
 * Course form.
 *
 * @package    srmsnew
 * @subpackage form
 * @author     Your name here
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class CourseForm extends BaseCourseForm
{
  /* private $departmentId     = NULL;
  
  public function __construct($departmentId = NULL)
  {
    $this->departmentId     = $departmentId;
    
    
    parent::__construct();
  }
   *
   */
  public function configure()
  {
    unset($this['created_at'], $this['updated_at'], $this['aproval_date'], $this['ac_minutes']);
    
    ##   Embedd CourseChecklistForm 
    /*$courseChecklist          = new CourseChecklist();
    $courseChecklist->Course  = $this->getObject();    
    $courseChecklistForm      = new CourseChecklistForm($courseChecklist, $this->departmentId);
    
    $this->embedForm('coursechecklist', $courseChecklistForm);
     * 
     */
  }
}
