<?php

/**
 * course actions.
 *
 * @package    srmsnew
 * @subpackage course
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class courseActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    /*$this->filterform = new SectionCourseOfferingFilterForm($this->getUser()->getAttribute('departmentId'));
    $this->courses = Doctrine_Core::getTable('Course')
      ->createQuery('a')
      ->execute();
     *
     */

      # Department List
      $this->departments    = Doctrine_Core::getTable('Department')->getAllDepartments();
      
      #Program List
      //$this->departments    = Doctrine_Core::getTable('Department')->getAllDepartments();
      #Available Course List
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->course = Doctrine_Core::getTable('Course')->find(array($request->getParameter('id')));
    $this->forward404Unless($this->course);
  }

  public function executeNew(sfWebRequest $request)
  {
    $this->form = new CourseForm($this->getUser()->getAttribute('departmentId'));
  }

  public function executeCreate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST));

    $this->form = new CourseForm();

    $this->processForm($request, $this->form);

    $this->setTemplate('new');
  }

  public function executeEdit(sfWebRequest $request)
  {
    $this->forward404Unless($course = Doctrine_Core::getTable('Course')->find(array($request->getParameter('id'))), sprintf('Object course does not exist (%s).', $request->getParameter('id')));
    $this->form = new CourseForm($course);
  }

  public function executeUpdate(sfWebRequest $request)
  {
    $this->forward404Unless($request->isMethod(sfRequest::POST) || $request->isMethod(sfRequest::PUT));
    $this->forward404Unless($course = Doctrine_Core::getTable('Course')->find(array($request->getParameter('id'))), sprintf('Object course does not exist (%s).', $request->getParameter('id')));
    $this->form = new CourseForm($course);

    $this->processForm($request, $this->form);

    $this->setTemplate('edit');
  }

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->forward404Unless($course = Doctrine_Core::getTable('Course')->find(array($request->getParameter('id'))), sprintf('Object course does not exist (%s).', $request->getParameter('id')));
    $course->delete();

    $this->redirect('course/index');
  }

  protected function processForm(sfWebRequest $request, sfForm $form)
  {
    $form->bind($request->getParameter($form->getName()), $request->getFiles($form->getName()));
    if ($form->isValid())
    {
      $course = $form->save();

      $this->redirect('course/edit?id='.$course->getId());
    }
  }
  
  
  
  
  public function executeAssigncourse(sfWebRequest $request )
  {
	 $this->filterform = new SectionCourseOfferingFilterForm($this->getUser()->getAttribute('departmentId'));
	 $this->processCourseOfferingFilterForm($request, $this->filterform);
	 //$this->redirect('course/index');
	 $this->setTemplate('assigncourse');    
  }
  public function processCourseOfferingFilterForm(sfWebRequest $request, sfForm $filterform )
  {
    ## Bind form 
    //$filterform->bind($request->getParameter($filterform->getName()), $request->getFiles($filterform->getName()));
    
    $filterform->bind($request->getParameter('filterform'));
    if ($filterform->isValid())
    {
		## get form values 	   
	   $formData		= $this->filterform->getValues();  
	   $courseIds		= $formData['course_id'];
	   if($courseIds == NULL ) {
	   	$this->getUser()->setFlash('error', 'Courses must be added to bucket');
	   	$this->redirect('course/index');
	   }
	   $programId		= $formData['program_id'];
           $academicYear	= $formData['academic_year'];
           $year		= $formData['year'];
	   $semester		= $formData['semester'];
           $centerId		= $formData['center_id'];
  		
  		## Check filter combination availability [program_id, academic_year, year, semester], then return section]   
  		if(Doctrine_Core::getTable('ProgramSection')->checkIfSectionIsCreated($programId, $academicYear, $year, $semester, $centerId))
  		{
  			## Assign courses to one section 
  			$sections = Doctrine_Core::getTable('ProgramSection')->getBatchSection($programId, $academicYear, $year, $semester, $centerId);
  			$sectionId = $sections->getId();  						
			$numberOfAssignedCourses    = SectionCourseOffering::assignCoursesToOneSection($courseIds, $sectionId);
                        if($numberOfAssignedCourses == 0)
                            $this->getUser()->setFlash('notice', 'Selected courses are already defined');                       
                        else
                        {
                            $center = Doctrine_Core::getTable('Center')->getCenterById($centerId);
                            $this->getUser()->setFlash('notice', $numberOfAssignedCourses.' courses have been assigned to section at: '.$center->getName());                       
                        }
  		}
  		else
  		{
  			$this->getUser()->setFlash('error', 'This Program has not a section defined!');
  			$this->redirect('course/index');
  		} 
      //$this->getUser()->setFlash('notice', 'Success'); 
      //$this->redirect('course/index');
    }
        

    
  }
  
}
