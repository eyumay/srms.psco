<?php

/**
 * curriculum actions.
 *
 * @package    srmsnew
 * @subpackage curriculum
 * @author     EyuelG
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class curriculumActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
     //$this->forward('default', 'module');
     // $this->showAcademicPrograms     = FALSE;
     // $this->departments = Doctrine_Core::getTable('Department')->getAllDepartments();

      $this->departmentId = $this->getUser()->getAttribute('departmentId');
      $this->departmentDetail = Doctrine_Core::getTable('Department')->find($this->departmentId);
      $this->forward404Unless($this->departmentDetail);      
      
      $this->departments = Doctrine_Core::getTable('Department')->getDepartmentById($this->departmentId);
      $this->forward404Unless($this->departments);      
      
      $this->programs = Doctrine_Core::getTable('Program')->getAllPrograms();
      if( $this->programs->count() != 0 )
      {
          $this->showAcademicPrograms = TRUE;
      }
  }
  public function executeProgramDetail(sfWebRequest $request)
  {
    #for Program Detail 
    $this->showChecklist        = FALSE;
    $this->showCourseChecklist  = FALSE; 
    $this->showPromotionSetting = FALSE;
    
    $this->program = Doctrine_Core::getTable('Program')->find(array($request->getParameter('programId')));
    $this->forward404Unless($this->program);  
    $this->getUser()->setAttribute('programId', $this->program->getId());
    
    
    #program Checklist
    $this->pChecklistBreakdowns = Doctrine_Query::create()
      ->from('ProgramChecklistBreakdown')
      ->where('program_id =?', $this->program->getId())
      ->orderBy('year')
      ->execute();
    
    if($this->pChecklistBreakdowns->count() !=0 )
    {
        $this->showChecklist = TRUE;        
    }
    
    #course breakdowns
    $this->courseBreakdowns = Doctrine_Query::create()
      ->from('CourseChecklist')
      ->where('program_id =?', $this->program->getId())
      ->groupBy('year, semester')
      ->execute();    
    
    if($this->courseBreakdowns->count() != 0 )
    {
        $this->showCourseChecklist = TRUE;
    }
    
    #Promotion Setting
     $this->promotionSettings = Doctrine_Query::create()
      ->from('PromotionSetting')
      ->where('program_id =?', $this->program->getId())
      ->orderBy('current_year, current_semester')
      ->execute();    
    
    if($this->promotionSettings->count() != 0 )
    {
        $this->showPromotionSetting = TRUE;
    }   
  }
  public function executeCoursechecklistshow(sfWebRequest $request)
  {
      $this->showSemesterCourse = FALSE;
      ## get passed parameters, and fetch data with it,
      $programId = $request->getParameter('programId'); 
      $this->year = $request->getParameter('year'); 
      $this->semester = $request->getParameter('semester'); 
      
      ## PROGRAM,
      $this->program = Doctrine_Core::getTable('Program')->find(array($programId));
      $this->forward404Unless($this->program);
      
      $this->semesterCourses = Doctrine_Core::getTable('CourseChecklist')->getSemesterCourseChecklists($programId, $this->year, $this->semester);
    
      if($this->semesterCourses->count() != 0 )
      {
        $this->showSemesterCourse = TRUE;
      }            
  }  
  public function executeCoursechecklistredefine(sfWebRequest $request)
  {      
      $this->showSemesterCourse = FALSE;
      
      ## get passed parameters, and fetch data with it,
      $programId = $request->getParameter('programId'); 
      $this->program = Doctrine_Core::getTable('Program')->find(array($programId));
      $this->forward404Unless($this->program);
      
      $this->year = $request->getParameter('year'); 
      $this->semester = $request->getParameter('semester');      
      
      ## Create Form (programId, courseIds, year, semester
      //$courseChecklist = Doctrine_Core::getTable('CourseChecklist')->getSemesterCourseChecklists($programId, $this->year, $this->semester); 
      //$this->forward404Unless($courseChecklist);
      
      $allCourses = Doctrine_Query::create()
      ->from('Course c')
      ->where('c.department_id = ?', $this->getUser()->getAttribute('departmentId'))
      ->execute(); 
      $this->forward404Unless($allCourses);
      
      $courseIds = array();
      foreach($allCourses as $checklist)
          $courseIds[$checklist->getId()] = $checklist->getName();
      ## TODO 
      #
      ## Check semester maximum load and display notice
      # Program Object has it all->
      
      $this->courseChecklistForm = new FrontendCourseChecklistForm($programId, $courseIds, $this->year, $this->semester);
      
      if ($request->isMethod('post'))
      {
        $this->courseChecklistForm->bind($request->getParameter('coursechecklistform'));
        if ($this->courseChecklistForm->isValid())
        {

	   $formData            = $this->courseChecklistForm->getValues();  
	   $courseIds		= $formData['course_id'];
	   $programId           = $formData['program_id'];
           $semester            = $formData['semester'];
           $year                = $formData['year'];
	   
           if($courseIds == '' || $programId == '' || $semester == '' || $year == '' )
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions ');
                $this->redirect('curriculum/programDetail?programId='.$programId);               
           }    
           
          ## Delete all courses defined for this semester
          $this->forward404Unless($semesterCourseChecklist = Doctrine_Core::getTable('CourseChecklist')
                  ->getSemesterCourseChecklists($programId, $this->year, $this->semester), 
                  sprintf('Object program does not exist (%s).', $programId));
          $semesterCourseChecklist->delete();
          
          ## Save the newly submitted values,
          foreach($courseIds as $courseId)
          {
              $cChecklist	= new CourseChecklist();
              $cChecklist->setCourseId($courseId);
              $cChecklist->setProgramId($programId);
              $cChecklist->setYear($year);
              $cChecklist->setSemester($semester);
              $cChecklist->setStatus(TRUE);
              $cChecklist->save();
          }          
          
          $this->getUser()->setFlash('notice', 'Successfuly Redifined Semester Courses'); 
          $this->redirect('curriculum/programDetail?programId='.$programId);
        }
      }
    }    

  public function executeCoursechecklistadd(sfWebRequest $request)
  {
      $this->showSemesterCourse = FALSE;
      ## get passed parameters, and fetch data with it,
      $programId = $request->getParameter('programId'); 
      $this->year = $request->getParameter('year'); 
      $this->semester = $request->getParameter('semester'); 
      
      ## PROGRAM,
      $this->program = Doctrine_Core::getTable('Program')->find(array($programId));
      $this->forward404Unless($this->program);
      
      $this->semesterCourses = Doctrine_Core::getTable('CourseChecklist')->getSemesterCourseChecklists($programId, $this->year, $this->semester);
    
      if($this->semesterCourses->count() != 0 )
      {
        $this->showSemesterCourse = TRUE;
      }   
      ###################################################################### DATA FOR FORM DISPLAY,
      $allCourses = Doctrine_Query::create()
      ->from('Course c')
      ->where('c.department_id = ?', $this->getUser()->getAttribute('departmentId'))
      ->execute(); 
      $this->forward404Unless($allCourses);
      
      $courseIds = array();
      foreach($allCourses as $checklist)
          $courseIds[$checklist->getId()] = $checklist->getName();
      
      $this->courseChecklistForm = new FrontendCourseChecklistForm($programId, $courseIds, $this->year, $this->semester);
      
      if ($request->isMethod('post'))
      {
        $this->courseChecklistForm->bind($request->getParameter('coursechecklistform'));
        if ($this->courseChecklistForm->isValid())
        {

	   $formData            = $this->courseChecklistForm->getValues();  
	   $courseIds		= $formData['course_id'];
	   $programId           = $formData['program_id'];
           $semester            = $formData['semester'];
           $year                = $formData['year'];
	   
           if($courseIds == '' || $programId == '' || $semester == '' || $year == '' )
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions ');
                $this->redirect('curriculum/programDetail?programId='.$programId);               
           }               
          
          ## Save the newly submitted values,
          $found    = FALSE;
          $notFound = FALSE; 
          foreach($courseIds as $courseId)
          {
              if(!Doctrine_Core::getTable('CourseChecklist')->checkIfOneCourseChecklistDefined( $programId, $courseId, $year, $semester ))
              {
                $found = TRUE;
                $cChecklist	= new CourseChecklist();
                $cChecklist->setCourseId($courseId);
                $cChecklist->setProgramId($programId);
                $cChecklist->setYear($year);
                $cChecklist->setSemester($semester);
                $cChecklist->setStatus(TRUE);
                $cChecklist->save();                  
              }
              else
                  $notFound = TRUE;              
          }          
          
          if($found && $notFound) {
            $this->getUser()->setFlash('notice', 'Successfuly Added Some Courses'); 
            $this->redirect('curriculum/programDetail?programId='.$programId);
          }
          if(!$found && $notFound) {
            $this->getUser()->setFlash('notice', 'Nothing Performed, may be you have selected already defined courses'); 
            $this->redirect('curriculum/programDetail?programId='.$programId);
          }     
          if($found && !$notFound) {
            $this->getUser()->setFlash('notice', 'Successfuly Added Courses'); 
            $this->redirect('curriculum/programDetail?programId='.$programId);
          }           

        }
      }      
  }
  
  public function executeCoursechecklistremove(sfWebRequest $request)
  {
      $this->showSemesterCourse = FALSE;
      ## get passed parameters, and fetch data with it,
      $programId = $request->getParameter('programId'); 
      $this->year = $request->getParameter('year'); 
      $this->semester = $request->getParameter('semester'); 
      
      ## PROGRAM,
      $this->program = Doctrine_Core::getTable('Program')->find(array($programId));
      $this->forward404Unless($this->program);
      
      $this->semesterCourses = Doctrine_Core::getTable('CourseChecklist')->getSemesterCourseChecklists($programId, $this->year, $this->semester);
    
      if($this->semesterCourses->count() != 0 )
      {
        $this->showSemesterCourse = TRUE;
      }   
      ###################################################################### DATA FOR FORM DISPLAY,
      $allSemesterChecklists = Doctrine_Core::getTable('CourseChecklist')->getSemesterCourseChecklists( $programId , $this->year , $this->semester);
      $this->forward404Unless($allSemesterChecklists);
      
      $courseIds = array();
      foreach($allSemesterChecklists as $checklist)
          $courseIds[$checklist->getCourseId()] = $checklist->getCourse();
      
      $this->courseChecklistForm = new FrontendCourseChecklistForm($programId, $courseIds, $this->year, $this->semester);
      
      if ($request->isMethod('post'))
      {
        $this->courseChecklistForm->bind($request->getParameter('coursechecklistform'));
        if ($this->courseChecklistForm->isValid())
        {

	   $formData            = $this->courseChecklistForm->getValues();  
	   $courseIds		= $formData['course_id'];
	   $programId           = $formData['program_id'];
           $semester            = $formData['semester'];
           $year                = $formData['year'];
	   
           if($courseIds == '' || $programId == '' || $semester == '' || $year == '' )
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions ');
                $this->redirect('curriculum/programDetail?programId='.$programId);               
           }               
          
          foreach($courseIds as $courseId)
          {     
            ## Delete all courses defined for this semester
            $this->forward404Unless($semesterCourseChecklist = Doctrine_Core::getTable('CourseChecklist')
                    ->getOneCourseChecklist( $programId, $courseId, $year, $semester ), 
                    sprintf('Object program does not exist (%s).', $programId));
            $semesterCourseChecklist->delete();
          }          
          
  
          $this->getUser()->setFlash('notice', 'Successfuly Removed Course From Curriculum'); 
          $this->redirect('curriculum/programDetail?programId='.$programId);
      
        }
      }      
  } 

  public function executeCoursechecklistnew(sfWebRequest $request)
  {      
      $this->showSemesterCourse = FALSE;
      
      ## get passed parameters, and fetch data with it,
      $programId        = $request->getParameter('programId');
      $this->year       = $request->getParameter('year');
      $this->semester   = $request->getParameter('semester');
      
      $this->program = Doctrine_Core::getTable('Program')->find(array($programId));
      $this->forward404Unless($this->program);    
      
      $allCourses = Doctrine_Query::create()
      ->from('Course c')
      ->where('c.department_id = ?', $this->getUser()->getAttribute('departmentId'))
      ->orderBy('name')      
      ->execute(); 
      $this->forward404Unless($allCourses);
      
      $courseIds = array();
      foreach($allCourses as $checklist)
          $courseIds[$checklist->getId()] = $checklist->getName();
      ## TODO 
      #
      ## Check semester maximum load and display notice
      # Program Object has it all->
      
      $this->courseChecklistForm = new FrontendCourseChecklistCurriculumForm($programId, $courseIds);
      
      if ($request->isMethod('post'))
      {
        $this->courseChecklistForm->bind($request->getParameter('coursechecklistform'));
        if ($this->courseChecklistForm->isValid())
        {

	   $formData            = $this->courseChecklistForm->getValues();  
	   $courseIds		= $formData['course_id'];
	   $programId           = $formData['program_id'];
           $semester            = $formData['semester'];
           $year                = $formData['year'];
	   
           if($courseIds == '' || $programId == '' || $semester == '' || $year == '' )
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions ');
                $this->redirect('curriculum/programDetail?programId='.$programId);               
           }    
           
          #ABORT action if any year and semester is repeated,
          foreach($courseIds as $courseId)
          {
              if(Doctrine_Core::getTable('CourseChecklist')->checkIfCourseChecklistDefined( $programId, $year, $semester ))
              {
                $this->getUser()->setFlash('error', 'It seems that you are redefining for already created curriculum');
                $this->redirect('curriculum/programDetail?programId='.$programId);                  
              }
          }

          #ABORT action if any course is redefined,
          foreach($courseIds as $courseId)
          {
              if(Doctrine_Core::getTable('CourseChecklist')->checkIfCourseIsAddedToChecklist( $programId, $courseId ))
              {
                $this->getUser()->setFlash('error', 'Some courses seems to be defined again');
                $this->redirect('curriculum/programDetail?programId='.$programId);
              }
          }
          
          ## Save the newly submitted values,
          foreach($courseIds as $courseId)
          {
              $cChecklist	= new CourseChecklist();
              $cChecklist->setCourseId($courseId);
              $cChecklist->setProgramId($programId);
              $cChecklist->setYear($year);
              $cChecklist->setSemester($semester);
              $cChecklist->setStatus(TRUE);
              $cChecklist->save();
          }          
          
          $this->getUser()->setFlash('notice', 'Successfuly Redifined Semester Courses'); 
          $this->redirect('curriculum/programDetail?programId='.$programId);
        }
      }
    }  
  
  public function executeCoursechecklistcategory(sfWebRequest $request)
  {      
      $this->showSemesterCourse = FALSE;
      
      ## get passed parameters, and fetch data with it,
      $programId        = $request->getParameter('programId');
      $this->year       = $request->getParameter('year');
      $this->semester   = $request->getParameter('semester');
      
      $this->program = Doctrine_Core::getTable('Program')->find(array($programId));
      $this->forward404Unless($this->program);    
      
      $curriculumCourses = Doctrine_Query::create()
      ->from('CourseChecklist')
      ->where('program_id = ?', $programId)
      ->execute(); 
      $this->forward404Unless($curriculumCourses);
      
      $courseIds = array();
      foreach($curriculumCourses as $checklist)
          $courseIds[$checklist->getCourseId()] = $checklist->getCourse();
      
      $this->courseChecklistForm = new FrontendCourseChecklistCategoryForm($programId, $courseIds);
      
      if ($request->isMethod('post'))
      {
        $this->courseChecklistForm->bind($request->getParameter('coursechecklistform'));
        if ($this->courseChecklistForm->isValid())
        {

	   $formData            = $this->courseChecklistForm->getValues();  
	   $courseIds		= $formData['course_id'];
	   $programId           = $formData['program_id'];
           $courseType          = $formData['course_type'];
	   
           if($courseIds == '' || $programId == '' )
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions ');
                $this->redirect('curriculum/programDetail?programId='.$programId);               
           }               
          
          ## Save the newly submitted values,
          foreach($courseIds as $courseId)
          {
              $cChecklist = new CourseChecklist(); 
              $cChecklist	= Doctrine_Core::getTable('CourseChecklist')->getOneCourseChecklistByProgramAndCourseId($programId, $courseId);
              $this->forward404Unless($cChecklist);
              
              $cChecklist->setCourseType($courseType);
              $cChecklist->save();
          }          
          
          $this->getUser()->setFlash('notice', 'Successfuly Categorized Selected Courses'); 
          $this->redirect('curriculum/programDetail?programId='.$programId);
        }
      }
    }  
    
  public function executeCourseprerequisite(sfWebRequest $request)
  {      
      
      ## get passed parameters, and fetch data with it,
      $programId        = $request->getParameter('programId');
      $this->year       = $request->getParameter('year');
      $this->semester   = $request->getParameter('semester');
      
      $this->program = Doctrine_Core::getTable('Program')->find(array($programId));
      $this->forward404Unless($this->program);    
      
      $curriculumCourses = Doctrine_Query::create()
      ->from('CourseChecklist')
      ->where('program_id = ?', $programId)
      ->execute(); 
      $this->forward404Unless($curriculumCourses);
      
      $courseIds = array();
      $courseIds['']    = 'Select Course' ;
      foreach($curriculumCourses as $checklist)
          $courseIds[$checklist->getCourseId()] = $checklist->getCourse();
      
      $courseNumbers        = array();       
      foreach($curriculumCourses as $checklist)
          $courseNumbers[$checklist->getCourse()->getCourseNumber()] = $checklist->getCourse();     
      
      $this->courseChecklistForm = new FrontendCourseChecklistPrerequisiteForm($programId, $courseIds, $courseNumbers);
      
      if ($request->isMethod('post'))
      {
        $this->courseChecklistForm->bind($request->getParameter('coursechecklistform'));
        if ($this->courseChecklistForm->isValid())
        {

	   $formData            = $this->courseChecklistForm->getValues();  
	   $courseId		= $formData['course_id'];
           $courseNumbers	= $formData['course_number'];
	   $programId           = $formData['program_id'];
	   
           if($courseId == '' || $programId == '' || $courseNumbers == '' )
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions ');
                $this->redirect('curriculum/programDetail?programId='.$programId);               
           }               
          
          ## Save the newly submitted values,
          $checkIfSaved = FALSE;
          foreach($courseNumbers as $cNumber)
          {
              ## check if already defined, ...
              if(!Doctrine_Core::getTable('RelatedCourses')->checkIfPrerequisiteExists($courseId, $cNumber) )
              { 
                $checkIfSaved = TRUE;
                $relatedCourses = new RelatedCourses(); 

                $relatedCourses->setCourseId($courseId);
                $relatedCourses->setPrerequisiteCourseNumber($cNumber);
                $relatedCourses->setCourseRelationType('prerequisite'); 

                $relatedCourses->save();
              }
          }          
          
          if(!$checkIfSaved)
          {
                $this->getUser()->setFlash('error', 'Nothing Performed, seems like you redefined prerequisite courses ');
                $this->redirect('curriculum/programDetail?programId='.$programId);          
          }
          $this->getUser()->setFlash('notice', 'Successfuly Created Prerequisites '); 
          $this->redirect('curriculum/programDetail?programId='.$programId);
        }
      }
    }
    
  /*public function executeCoursechecklistdelete(sfWebRequest $request)
  {
    ## get passed parameters, and fetch data with it,
    $programId        = $request->getParameter('programId');
    $this->year       = $request->getParameter('year');
    $this->semester   = $request->getParameter('semester');
    
    ## Check if course has been offered [##COURSEOFFERING] .......
    ## 
    
    $this->forward404Unless($course = Doctrine_Core::getTable('Course')->find(array($request->getParameter('id'))), sprintf('Object course does not exist (%s).', $request->getParameter('id')));
    $course->delete();

    $this->redirect('course/index');
  } 
   * 
   */ 
  public function executeCourseprerequisiteshow(sfWebRequest $request)
  {
      $this->showProgramCourseChecklists = FALSE;
      ## get passed parameters, and fetch data with it,
      $this->programId = $request->getParameter('programId'); 
      $this->year = $request->getParameter('year'); 
      $this->semester = $request->getParameter('semester'); 
      
      ## PROGRAM,
      $this->program = Doctrine_Core::getTable('Program')->find(array($this->programId));
      $this->forward404Unless($this->program);
      
      ## COURSE BREAKDOWN!!
      $this->programCourseChecklists = Doctrine_Core::getTable('CourseChecklist')->getProgramCourseChecklists($this->programId);
    
      if($this->programCourseChecklists->count() != 0 )
      {
        $this->showProgramCourseChecklists = TRUE;
      }            
  }   
  public function executeCourseprerequisitedelete(sfWebRequest $request)
  {
    $programId = $this->getUser()->getAttribute('programId'); 
    $this->forward404Unless($relatedCourses = Doctrine_Core::getTable('RelatedCourses')->getPrerequisiteCourses($request->getParameter('courseId')), sprintf('Object Related Course does not exist (%s).', $request->getParameter('courseId')));
    $relatedCourses->delete();
    
    $this->getUser()->setFlash('notice', ' Prerequisite Course Deletion was successful'); 
    $this->redirect('curriculum/programDetail?programId='.$programId);      
  }

  public function executePromotionsettingnew(sfWebRequest $request)
  {
      $this->showSemesterCourse = FALSE;

      ## get passed parameters, and fetch data with it,
      $this->programId        = $request->getParameter('programId');

      $this->program = Doctrine_Core::getTable('Program')->find(array($this->programId));
      $this->forward404Unless($this->program);

      $this->frontendPromotionSettingForm = new FrontendPromotionSettingForm($this->programId);

      if ($request->isMethod('post'))
      {
        $this->frontendPromotionSettingForm->bind($request->getParameter('promotionsettingform'));
        if ($this->frontendPromotionSettingForm->isValid())
        {

	   $formData            = $this->frontendPromotionSettingForm->getValues();
           $programId           = $formData['program_id'];
	   $currentYear		= $formData['current_year'];	   
           $currentSemester     = $formData['current_semester'];
           $toYear              = $formData['to_year'];
           $toSemester          = $formData['to_semester'];

           if($currentYear == '' || $programId == '' || $currentSemester == '' || $toYear == '' || $toSemester == '')
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions p='.$programId.' currenty='.$currentYear.' currentS='.$currentSemester.' toy='.$toYear.' toS='.$toSemester);
                $this->redirect('curriculum/programDetail?programId='.$this->programId);
           }

          ## Save the newly submitted values,
          $promotionSetting = new PromotionSetting();
          $promotionSetting->setProgramId($programId);
          $promotionSetting->setCurrentYear($currentYear);
          $promotionSetting->setCurrentSemester($currentSemester);
          $promotionSetting->setToYear($toYear);
          $promotionSetting->setToSemester($toSemester);
          $promotionSetting->save();

          $this->getUser()->setFlash('notice', 'Successfuly Defined Promotion Settings');
          $this->redirect('curriculum/programDetail?programId='.$programId);
        }
      }
    }
  public function executeProgramchecklistbreakdownnew(sfWebRequest $request)
  {
      $this->showSemesterCourse = FALSE;

      ## get passed parameters, and fetch data with it,
      $this->programId        = $request->getParameter('programId');

      $this->program = Doctrine_Core::getTable('Program')->find(array($this->programId));
      $this->forward404Unless($this->program);

      $this->frontendProgramChecklistBreakdownForm = new FrontendProgramChecklistBreakdownForm($this->programId);

      if ($request->isMethod('post'))
      {
        $this->frontendProgramChecklistBreakdownForm->bind($request->getParameter('promotionsettingform'));
        if ($this->frontendProgramChecklistBreakdownForm->isValid())
        {

	   $formData            = $this->frontendProgramChecklistBreakdownForm->getValues();
           $programId           = $formData['program_id'];
	   $year		= $formData['year'];
           $semester     = $formData['semester'];
           $semesterTyptId              = $formData['semester_type_id'];
           $semesterMinChr          = $formData['semester_min_chr'];
           $semesterMaxChr          = $formData['semester_max_chr'];

           if($year == '' || $semester == '' || $semesterTyptId == '' || $semesterMinChr == '' || $semesterMaxChr == '' || $programId=='')
           {
                $this->getUser()->setFlash('error', 'Error occured: nothing performed, please redo actions p='.$programId.' currenty='.$currentYear.' currentS='.$currentSemester.' toy='.$toYear.' toS='.$toSemester);
                $this->redirect('curriculum/programDetail?programId='.$this->programId);
           }

          ## Save the newly submitted values,
          $programChecklistBreakdown = new ProgramChecklistBreakdown();
          $programChecklistBreakdown->setYear($year);
          $programChecklistBreakdown->setSemester($semester);
          $programChecklistBreakdown->setSemesterTypeId($semesterTyptId);
          $programChecklistBreakdown->setProgramId($programId);
          $programChecklistBreakdown->setSemesterMinChr($semesterMinChr);
          $programChecklistBreakdown->setSemesterMaxChr($semesterMaxChr);
          $programChecklistBreakdown->save();


          $this->getUser()->setFlash('notice', 'Successfuly Defined Promotion Settings');
          $this->redirect('curriculum/programDetail?programId='.$programId);
        }
      }
    }
}
