<?php

/**
 * managesection actions.
 *
 * @package    srmsnew
 * @subpackage managesection
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class managesectionActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    
    $orderBy='';
      
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId); 
    
    
    if($request->getParameter('sortBy')=='program')
        $orderBy='program_id'; 
    if($request->getParameter('sortBy')=='center')
        $orderBy='center_id';         
    if($request->getParameter('sortBy')=='academicYear')
        $orderBy='academic_year';
    
    if( !empty($this->programs) )
    {
        $this->program_sections = Doctrine_Core::getTable('ProgramSection')->getAllProgramSections(array_keys($this->programs), $orderBy );  
    }
    
    ## Pass Program infomation 
    
    
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId); 
    
    ## Data from filter form
    $year               = $request->getParameter('year');
    $semester		= $request->getParameter('semester');
    $academicYear	= $request->getParameter('academic_year');
    $programId		= $request->getParameter('program_id');
    $centerId		= $request->getParameter('center_id');  
    $activeClass        = $request->getParameter('active_class'); 
    
    ##Check if Filter Form is Submitted
    if($year != '' || $semester != '' || $programId != '' || $academicYear != '' || $centerId != '' || $activeClass != '' )
    {
        $this->programSections = Doctrine_Core::getTable('ProgramSection')
        ->createQuery('a') ;
        
        if($programId == '')
            $this->programSections->andWhereIn('a.program_id', array_keys($this->programs)); 
        
        if($year !='' )
            $this->programSections->andWhere('a.year = ?', $year);
        if($semester !='' )
            $this->programSections->andWhere('a.semester = ?', $semester);
        if($academicYear !='' )
            $this->programSections->andWhere('a.academic_year = ?', $academicYear);        
        if($programId !='' )
            $this->programSections->andWhere('a.program_id = ?', $programId);
        if($centerId !='' )
            $this->programSections->andWhere('a.center_id = ?', $centerId);         
        if($activeClass !='' )
            $this->programSections->andWhere('a.is_activated = ?', TRUE);         
        $this->program_sections = $this->programSections->execute();                         
        
    }

    
  }
  public function executeDelete(sfWebRequest $request)
  {
      $programSectionId     = $request->getParameter('programSectionId'); 
      
      $programSection = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId);
      
      if($programSection->hasEnrollments()) ## Inspect further if the section has enrollments already
      {
          if($programSection->checkToUnenroll())
          {
              foreach($programSection->getEnrollmentInfos() as $ei )
              {
                  $ei->unenroll();
              }
              if($programSection->hasCourseOffers()) ## Check and remove offerred courses!!
                  $programSection->unofferCourses();

              $programSection->delete();   
              $this->getUser()->setFlash('notice', 'Successfuly Deleted Program Section');
              $this->redirect('managesection/index');              
          }
          else
          {
                $this->getUser()->setFlash('error', 'This Section Cannot Be Deleted, Contact Database Administration!');
                $this->redirect('managesection/index');              
          }
      }
      else
      {
          if($programSection->hasCourseOffers()) ## Check and remove offerred courses!!
              $programSection->unofferCourses();
          
          $programSection->delete();         

          $this->getUser()->setFlash('notice', 'Successfuly Deleted Program Section');
          $this->redirect('managesection/index'); 

      }
  }  
  
  public function executeRemoveEnrollments(sfWebRequest $request)
  {
      $programSectionId     = $request->getParameter('programSectionId'); 
      
      $programSection = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId);
      
      if($programSection->hasEnrollments()) ## Inspect further if the section has enrollments already
      {
          if($programSection->checkToUnenroll())
          {
              foreach($programSection->getEnrollmentInfos() as $ei )
              {
                  $ei->unenroll();
              }
              $this->getUser()->setFlash('notice', 'Successfuly Removed Enrollments From Selected Program Section');
              $this->redirect('managesection/index');              
          }
          else
          {
                $this->getUser()->setFlash('error', 'Enrollments Cannot Be Removed, Contact Database Administration!');
                $this->redirect('managesection/index');              
          }
      }
      else
      {     
          $this->getUser()->setFlash('error', 'Selected Program Section Has No Enrollments To Remove!');
          $this->redirect('managesection/index'); 

      }
  }  
  
  public function executeEdit(sfWebRequest $request)
  {
      
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId); 
    
    if( !empty($this->programs) )
    {
        $this->program_sections = Doctrine_Core::getTable('ProgramSection')->getActiveProgramSections(array_keys($this->programs) );  
    }
    
    $this->centers          = Doctrine_Core::getTable('Center')->getAllCenters();
    $this->years            = FormChoices::getYearChoices();
    $this->academicYears    = FormChoices::getAcademicYear();
    $this->semesters        = FormChoices::getSemesterChoices();      
    $departmentId   = $this->getUser()->getAttribute('departmentId');
    $this->programs = Doctrine_Core::getTable('Program')->getProgramsByDepartmentId($departmentId); 
          
    $programSectionId     = $request->getParameter('programSectionId');       
    $this->forward404Unless($programSection = Doctrine_Core::getTable('ProgramSection')->find(array($request->getParameter('programSectionId'))), sprintf('Object program_section does not exist (%s).', $request->getParameter('programSectionId')));
    
    if($programSection->checkToEdit()) 
    {
        $this->programSectionForm = new FrontendProgramSectionForm($programSection, $departmentId); 
    }
    else
    {     
        $this->getUser()->setFlash('error', 'Cannot Be Editted: Editting Allowed Only For Year 1 and Semester 1 Program Sections!!');
        $this->redirect('managesection/index'); 
    }
    if($request->isMethod('post'))
    {
         
        $this->programSectionForm->bind($request->getParameter($this->programSectionForm->getName()), $request->getFiles($this->programSectionForm->getName()));
        
        if($this->programSectionForm->isValid())
        {
            $programSectionData = $this->programSectionForm->getValues();
            $this->programSectionForm->save(); 
            
            if($programSection->hasEnrollments())
            {
                $programSection->updateEnrollments($programSectionData['program_id'], $programSectionData['academic_year'], $programSectionData['year'], $programSectionData['semester']);
            }
            
            $this->getUser()->setFlash('notice', 'Program Section Information Updated Successfully! ');
            $this->redirect('managesection/index');    
        }
        else
            $this->getUser()->setFlash('error', 'The Form Has Errors, Please Correct And Try Again.'.$this->programSectionForm->getName());            
    }
  }

  public function executeToggleStatus(sfWebRequest $request)
  {
      $programSectionId     = $request->getParameter('programSectionId'); 
      
      $programSection = Doctrine_Core::getTable('ProgramSection')->findOneById($programSectionId);
      
      $programSection->toggleStatus();
      
      if($programSection->isActivated())
      {
          $this->getUser()->setFlash('notice', 'Activated Program Section Successfully');
          $this->redirect('managesection/index'); 
      }
      else
      {
          $this->getUser()->setFlash('notice', 'Disactivated Program Section Successfully');
          $this->redirect('managesection/index');         
      }
  }    
}
