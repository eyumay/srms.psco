<?php

/**
 * Registration
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    ##PACKAGE##
 * @subpackage ##SUBPACKAGE##
 * @author     ##NAME## <##EMAIL##>
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
class Registration extends BaseRegistration
{
    public function getActiveStudentCourseGrades()
    {
        $q = Doctrine_Query::create()
        ->from('StudentCourseGrade scg')
                ->where('scg.registration_id = ?', $this->getId());

        return Doctrine::getTable('StudentCourseGrade')->getActiveStudentCourseGrades($q);
    }

    public function checkIfStudentCanRegister()
    {
    
    }

    public function doRegistration($regType = null , $enrollment = null , $courseArray = null, $droppableCoursesArray = null )
    {  
       if($regType == sfConfig::get('app_normal_registration')) 
       {           
       }
       
       elseif($regType == sfConfig::get('app_drop_registration'))
       {                                     
               if(!empty($droppableCoursesArray)) 
               {
                    $this->doNormalRegistration($enrollment->getId(), $enrollment->getStudentId(), $courseArray);  
                    Doctrine_Core::getTable('StudentCourseGrade')->dropStudentCourses($enrollment->getStudentId(), $droppableCoursesArray);  ## Drops registered active courses     
                    $enrollment->updateEnrollmentSemesterAction(sfConfig::get('app_registered_semester_action')); 

                    return TRUE; 
               }
               else
                   return FALSE; 
       }                          
       /*elseif($regType == sfConfig::get('app_normal_registration'))
       {
           return "normal registration ";
       }
       */
       
       elseif($regType == sfConfig::get('app_add_registration'))
       {
           $enrollment->updateEnrollmentSemesterAction(sfConfig::get('app_registered_semester_action')); 
           
           $this->doAddRegistration($enrollment->getId(), $enrollment->getStudentId(), $courseArray);            
       }
       /*
        * 
       elseif($regType == sfConfig::get('app_makeup_registration'))
       {
           return 'makeup registration'; 
       }
       elseif($regType == sfConfig::get('app_reexam_registration'))
       {
           return 'reexam registration'; 
       }
       elseif($regType == sfConfig::get('app_grade_complain_registration'))
       {
           return 'grade complain registration'; 
       }
       elseif($regType == sfConfig::get('app_exemption_registration'))
       {
           return 'exemption registration'; 
       } 
        * 
        */    
       else
           return FALSE; 
    }
    
    public function doNormalRegistration($enrollmentInfoId = null, $studentId, $semesterCourseIdsArray)
    {
        if($enrollmentInfoId == '')
            return FALSE; 
        else
        {
            $this->setEnrollmentInfoId($enrollmentInfoId);
            $this->setDate(date('Y-m-d')); 
            $this->save(); 
            
            ##Also save courses
            foreach($semesterCourseIdsArray as $scId )
            {
                $scg = new StudentCourseGrade();
                $scg->registerStudentCourse($this->getId(), $studentId, $scId);                
            }   
            
            return TRUE;
        }
    }
    public function doAddRegistration($enrollmentInfoId = null, $studentId = null , $courseArray = null)
    {
       $this->setEnrollmentInfoId($enrollmentInfoId);
       $this->setIsAdd(TRUE);
       $this->setDate(date('Y-m-d')); 
       $this->save();                        

        ##Also save courses
        foreach($courseArray as $scId )
        {
            $scg = new StudentCourseGrade();
            $scg->addStudentCourse($this->getId(),$studentId, $scId);                
        } 
    }
    
    public function unregister()
    {
        if($this->hasStudentCourseGrades())
        {
            foreach ($this->getStudentCourseGrades() as $scg)
               $scg->delete ();
        }
        $this->delete(); 
    }
    
    public function hasStudentCourseGrades()
    {
        if($this->getStudentCourseGrades()->count() != 0)
            return TRUE;
        else
            return FALSE; 
    }
    
    public function register($enrollmentInfoId = NULL, $courseIdsArray = NULL)
    {
        if(is_null($courseIdsArray))
            return FALSE;
        if(is_null($enrollmentInfoId))
            return FALSE;        
        ## Then Set Objects
        $this->setEnrollmentInfoId( $enrollmentInfoId );
        $this->setDate(date('Y-m-d')); 
        $this->save(); 
        
        ## Call upon StudentCourseRegistration
        foreach($courseIdsArray as $courseId=>$courseName)
        {
            $scg    = new StudentCourseGrade();
            if(!$scg->register($this->getEnrollmentInfo()->getStudentId(), $this->getId(), $courseId))
                return FALSE;
        }
        
        return TRUE;
    }
    
    public function isNormal()
    {
        if(!$this->getIsDrop() && !$this->getIsAdd() && !$this->getIsGradeComplain() && !$this->getIsMakeup() && !$this->getIsReexam())
            return TRUE;
        
        return FALSE;
    }
    
    public function drop($courseIdsArray = NULL)
    {
        if(is_null($courseIdsArray))
            return FALSE;
        
        ## DEOS the course exist !!
        foreach($this->getStudentCourseGrades() as $scg )
        {
            if($scg->isOkToDrop($courseIdsArray))
            {
                foreach($courseIdsArray  as $courseId=>$courseName)
                {
                    if($scg->getCourseId() == $courseId)
                        if($scg->drop())
                            return TRUE;
                }
            }
        }        
        
        
        return FALSE;
    }  
    
    public function registerWithDrop($enrollmentInfoId = NULL, $courseIdsArrayToRegister = NULL, $courseIdsArrayToDrop = NULL )
    {
        if(is_null($enrollmentInfoId))
            return FALSE;
        if(is_null($courseIdsArrayToRegister))
            return FALSE;        
        if(is_null($courseIdsArrayToDrop))
            return FALSE;           
        
        $this->setEnrollmentInfoId( $enrollmentInfoId );
        $this->setDate(date('Y-m-d')); 
        $this->save(); 
        
        ## Call upon StudentCourseRegistration
        foreach($courseIdsArrayToRegister as $courseId=>$courseName)
        {
            $scg    = new StudentCourseGrade();
            if(!$scg->register($this->getEnrollmentInfo()->getStudentId(), $this->getId(), $courseId))
                return FALSE;
        }
        foreach($courseIdsArrayToDrop as $courseId=>$courseName)
        {
            $scg    = new StudentCourseGrade();
            if(!$scg->registerWithDrop($this->getEnrollmentInfo()->getStudentId(), $this->getId(), $courseId))
                return FALSE;
        }        
        
        return TRUE;
    }
}