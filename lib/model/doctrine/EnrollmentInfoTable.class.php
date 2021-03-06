<?php

/**
 * EnrollmentInfoTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class EnrollmentInfoTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object EnrollmentInfoTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('EnrollmentInfo');
    }
    public function enrollStudentsToSection($enrollmentIds = NULL, $sectionIds = null )
    {
      if($enrollmentIds == NULL)
      	return false;  	
    	foreach($enrollmentIds as $enrollmentId)
    	{
      	if(!Doctrine_Core::getTable('EnrollmentInfo')->check($enrollmentId)->count() == 1)
				return false;      	   
      	Doctrine_Core::getTable('EnrollmentInfo')
      	   ->findOneStudentEnrollmentInforById($enrollmentId)->updateEnrollmentSection($sectionIds);     	    	 
    	}
    	return true; 
    }
    public function findOneStudentEnrollmentInforById($enrollmentId = null)    
    {
      $q = Doctrine_Query::create()
        ->from('EnrollmentInfo ei__')
        ->where('ei__.id = ?', $enrollmentId); 
		return $q->fetchOne();  
    }
    public function getStudentEnrollmentInfo($enrollmentId = null)
    {
      $q = Doctrine_Query::create()
        ->from('EnrollmentInfo ei__')
        ->where('ei__.id = ?', $enrollmentId);
		return $q->fetchOne();
    }
    public function check($enrollmentId = null)    
    {
      $q = Doctrine_Query::create()
        ->from('EnrollmentInfo ei__')
        ->where('ei__.id = ?', $enrollmentId); 
		return $q->execute();  
    }    
    public function getOneBatchEnrollments($programId=null, $academicYear=null, $year=null, $semester=null, $centerId=NULL )
    {
        ## Find students at given center
        $centerStudentsArray    = Doctrine_Core::getTable('StudentCenter')->getCenterStudents($centerId);       
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')                
                ->andWhere('u.program_id = ?', $programId)
                ->andWhere('u.academic_year = ?', $academicYear )
                ->andWhere('u.year = ?', $year)
                ->andWhere('u.semester = ?', $semester)
                ->andWhereIn('u.student_id', array_keys($centerStudentsArray));
        
        return $q->execute();
    }

    public function getAdmissions($programSectionObj  = NULL  )
    {
        $centerStudentsArray = array(); 
        if(!is_null($programSectionObj))
        {
            ## Find students at given center
            $centerStudentsArray    = Doctrine_Core::getTable('StudentCenter')->getCenterStudents($programSectionObj->getCenterId() );       
            
            //$centerStudentsArray    = StudentCenterTable::getCenterStudents($programSectionObj->getCenterId()); 
            
            if(is_null($centerStudentsArray))
                return NULL; 
            
            $q = Doctrine_Query::create()
                    ->from('EnrollmentInfo u')                      
                    ->where('u.program_id = ?', $programSectionObj->getProgramId() )  
                    ->andWhereIn('u.student_id', $centerStudentsArray)
                    ->andWhere('u.academic_year = ?', $programSectionObj->getAcademicYear() )
                    ->andWhere('u.semester = ?', $programSectionObj->getSemester() )
                    ->andWhere('u.year = ?', $programSectionObj->getYear())
                    ->andWhere('u.semester_action = ?', sfConfig::get('app_enrolled_semester_action'))
                    ->andWhere('u.enrollment_action = ?', sfConfig::get('app_admission_enrollment'));

            if($q->execute()->count() != 0 )
                return $q->execute();
            else
                return null; 
        }
        else
            return null; 
    }    
    
    public function getOneBatchNotRegisteredEnrollments($programId=null, $academicYear=null, $year=null, $semester=null )
    {
	     $semesterAction1 = 0; ##JUst enrolled
             $semesterAction2 = 2; ##Just Promotted
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->andWhere('u.program_id = ?', $programId)
                ->andWhere('u.academic_year = ?', $academicYear )
                ->andWhere('u.year = ?', $year)
                ->andWhere('u.semester = ?', $semester)
                ->andWhere('u.semester_action = ?', $semesterAction1)
                ->orWhere('u.semester_action = ?', $semesterAction2);
        
        return $q->execute();        
    }  
   
    
    public function getNotRegisteredBySectionId( $sectionId = NULL )
    { ## As registered enrollments are already enrolled to a class!!
        
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')                
                ->Where('u.section_id = ?', $sectionId )
                ->andWhere('u.semester_action = ?', 0 )
                ->andWhere('u.leftout = ?', 0 );
        
        
        return $q->execute();        
    }    

    public function getAllNotRegisteredBySectionId( $sectionId = NULL )
    { ## As registered enrollments are already enrolled to a class!!
        
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')                
                ->Where('u.section_id = ?', $sectionId )
                ->andWhere('u.semester_action = ?', 0 );
        
        
        return $q->execute();        
    }     
    
    public function getEnrollmentDetailById($enrollmentId)
    {
        return Doctrine::getTable('EnrollmentInfo')->findOneById($enrollmentId); 	 	
    }  
    public function checkIfEnrolledToSection($programId, $academicYear, $year, $semester, $sectionId ) 
    {
        ## TRUE -> Batch is enrolled to section, FALSE->Batch is not yet ENROLLED to SECTION        
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->where('u.program_id = ?', $programId)
                ->andWhere('u.academic_year = ?', $academicYear )
                ->andWhere('u.year = ?', $year)
                ->andWhere('u.semester = ?', $semester)
                ->andWhere('u.section_id = ?', $sectionId);  
        if($q->execute()->count() == 0 )        
            return FALSE; 
        else
            return TRUE;
    }
    public function checkToSectionEnrollment($sectionId)
    {
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->andWhere('u.section_id = ?', $sectionId);  
        if($q->execute()->count() == 0 )        
            return FALSE; 
        else
            return TRUE;        
    }
    public function checkIfEnrolledToProgram($programId, $academicYear, $year, $semester) 
    {
        ## TRUE -> Batch is enrolled to Program, FALSE->Batch is not yet ENROLLED to PROGRAM
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->andWhere('u.program_id = ?', $programId)
                ->andWhere('u.academic_year = ?', $academicYear )
                ->andWhere('u.year = ?', $year)
                ->andWhere('u.semester = ?', $semester);
        if($q->execute()->count() == 0 )        
            return FALSE; 
        else
            return TRUE;
    }
    public function checkIfRegisteredToSemesterCourses($programId, $academicYear, $year, $semester, $sectionId) 
    {
        ## TRUE -> Batch is Registered, FALSE->Batch is Not Registered
        $semesterAction = 1;##1-Registered, 0-Just enrolled to program, 2- Promotted, 3- Withdrawn, 4-Under, 5- Readmitted, 6- Dismissed, 7- ADR,
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->andWhere('u.program_id = ?', $programId)
                ->andWhere('u.academic_year = ?', $academicYear )
                ->andWhere('u.year = ?', $year)
                ->andWhere('u.semester = ?', $semester)
                ->andWhere('u.section_id = ?', $sectionId)
                ->andWhere('u.semester_action = ?', $semesterAction);
        if($q->execute()->count() == 0 )        
            return FALSE; 
        else
            return TRUE;
    }    

    public function checkIfRegistered($sectionId) 
    {
        ## TRUE -> Batch is Registered, FALSE->Batch is Not Registered
        ##1-Registered, 0-Just enrolled to program, 2- Promotted, 3- Withdrawn, 4-Under, 5- Readmitted, 6- Dismissed, 7- ADR,
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->where('u.section_id = ?', $sectionId)
                ->andWhere('u.semester_action = ?', sfConfig::get('app_registered_semester_action'));
        if($q->execute()->count() == 0 )        
            return FALSE;
        else
            return TRUE;
    }      
    public function getDepartmentStudets($programIdArray ) 
    {
        ## TRUE -> Batch is enrolled to section, FALSE->Batch is not yet ENROLLED to SECTION        
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->whereIn('u.program_id', $programIdArray);
        $studentArray[] = array();
        foreach($q->execute() as $student)
            $studentArray[$student->getStudentId()] = $student->getStudentId(); 
        
        return $studentArray; 
    } 
       
    public function updateCreditHours($enrollmentId = NULL, $courseChr=NULL ) 
    {
             
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->where('u.id = ?', $enrollmentId); 
        
        $enrollment     = $q->fetchOne();
        
        $enrollment->setSemesterChrs($enrollment->getSemesterChrs()+$courseChr);
        $enrollment->setTotalChrs($enrollment->getTotalChrs()+$courseChr);
        $enrollment->save(); 
    }     

    public function updateGradePoints($enrollment = NULL, $course = NULL, $oneStudentCourseGrade = NULL ) 
    {        
        $enrollment->setSemesterGradePoints(
                $enrollment->getSemesterGradePoints()+ $course->getCreditHoure() *  
                Doctrine_Core::getTable('Grade')
                    ->getGradeDetailById($oneStudentCourseGrade->getGradeId())->getValue()
                );

        $enrollment->setTotalGradePoints(
                $enrollment->getTotalGradePoints()+ $course->getCreditHoure() *  
                Doctrine_Core::getTable('Grade')
                    ->getGradeDetailById($oneStudentCourseGrade->getGradeId())->getValue()
                );        
        //$enrollment->setTotalChrs($enrollment->getTotalChrs()+$courseChr);
        
        $enrollment->save(); 
    }  

    public function checkToGenerateConsolidate($enrollment = NULL )
    {
        
        ## 1. Check if all grades are submitted, 
        ## 2. Check if semester is ended, with in defined period,       

        ## Later on to add, 
        #  1. Check grade submission for each course against checklist breakdown,
        #       i.  Check expected courses for given semester
        #       II. Check expected credit hours .... etc
       
        if(Doctrine_Core::getTable('SectionCourseOffering')->checkIfGradeSubmittedForAllCourses($enrollment->getSectionId()))
            return TRUE;
        else
            return FALSE;        
    } 
    
    public function checkIfEnrolledToSectionBySectionId( $sectionId = NULL ) 
    {       
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->where('u.section_id = ?', $sectionId);
        
        if($q->execute()->count() == 0 )        
            return FALSE; 
        else
            return TRUE;
    }
    public function checkIfRegisteredBySectionId( $sectionId = NULL ) 
    {   
        $registered     = sfConfig::get('app_registered_semester_action'); 
        $promoted       = sfConfig::get('app_promoted_semester_action');
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->where('u.section_id = ?', $sectionId);
        
        
        foreach($q->execute() as $ei)
        {
            if($ei->getSemesterAction() == $registered || $ei->getSemesterAction() == $promoted )        
                return TRUE;        
        }
        
        return FALSE; 
    }     
    public function getEnrollmentsBySectionId( $sectionId = NULL ) 
    {   
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo ei')
                ->where('ei.section_id = ?', $sectionId)
                ->andWhere('ei.leftout = ?', FALSE);
        
        return $q->execute(); 
    }     
    
    public function getOneStudentEnrollment( $sectionId = NULL, $studentId = NULL ) 
    {   
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->where('u.section_id = ?', $sectionId)
                ->andWhere('u.student_id = ?', $studentId);
        
        return $q->fetchOne(); 
    }  

    public function getEnrollmentsByStudentIds($studentIdsArray = NULL )
    {
                
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')                
                ->whereIn('u.student_id', $studentIdsArray );
        
        return $q->execute();
    }    
    
    public function checkIfStudentIsEnrolledToSection($sectionId = NULL, $studentId = NULL)
    {
        $q = Doctrine_Query::create()
                ->from('EnrollmentInfo u')
                ->andWhere('u.section_id = ?', $sectionId)
                ->andWhere('u.student_id = ?', $studentId);  
        if($q->execute()->count() == 0 )        
            return FALSE; 
        else
            return TRUE;        
    }  

    public function getEnrollmentDetail($studentId = NULL, $sectionId = NULL )    
    {
      $q = Doctrine_Query::create()
        ->from('EnrollmentInfo ei__')
        ->where('ei__.student_id = ?', $studentId)
        ->andWhere('ei__.section_id = ?', $sectionId); 
    
      return $q->fetchOne();  
    }       
    
    public function getEnrollmentsUnderCourse($sectionId=NULL, $studentIds=NULL)
    {
      $q = Doctrine_Query::create()
        ->from('EnrollmentInfo ei__')
        ->whereIn('ei__.student_id', $studentIds)
        ->andWhere('ei__.section_id = ?', $sectionId); 
    
      return $q->execute();  
    }

    public function getWithGradedStudentCourses($sectionId = NULL)
    {
        $q = $this->createQuery('e')
                ->leftJoin('e.Registrations r')
                ->leftJoin('r.StudentCourseGrades scg')
                ->where('e.section_id = ?', $sectionId )
                ->andWhere('e.leftout = ?', FALSE)
                ->andWhere('scg.is_calculated = ?', 1);

        return $q->execute();
    }
    public function getWithStudentCourses($enrollmentId = NULL)
    {
        $q = $this->createQuery('e')
                ->leftJoin('e.Registrations r')
                ->leftJoin('r.StudentCourseGrades scg')
                ->where('e.id = ?', $enrollmentId)
                ->andWhere('r.is_grade_complain = ?', 0)
                ->andWhere('r.is_makeup = ?', 0)
                ->andWhere('r.is_reexam = ?', 0)
                ->andWhere('r.is_drop = ?', 0)
                ->andWhere('r.is_add = ?', 0);

        return $q->fetchOne();
    }
    public function getSectionEnrolledStudentIdsArray($sectionId = NULL)
    {
        
        if(!is_null($sectionId) )
        {
            $studentIdsArray = array();
            $q = $this->createQuery('e')
                    ->where('e.section_id = ?', $sectionId)
                    ->andWhere('e.leftout = ?', FALSE ); 

            if($q->execute()->count() != 0)
            {
                foreach($q->execute() as $enrollment)
                  $studentIdsArray[] = $enrollment->getStudentId();   
                return $studentIdsArray; 
            }
            else
                return null;
        
        }
        else
            return null;
    }       
    public function checkIfCourseHasBeenAdded($programSectionObj = NULL, $studentId = NULL, $courseId = NULL)
    {
        
        if(!is_null($programSectionObj) || is_null($studentId) || is_null($courseId) )
        {
            $q = $this->createQuery('e')
                    ->leftJoin('e.CoursePools cp')
                    ->where('e.program_id = ?', $programSectionObj->getProgramId())
                    ->andWhere('e.year = ?', $programSectionObj->getYear())
                    ->andWhere('e.semester = ?', $programSectionObj->getSemester())
                    ->andWhere('e.academic_year = ?', $programSectionObj->getAcademicYear())
                    ->andWhere('e.student_id = ?', $studentId)
                    ->andWhere('e.leftout = ?', TRUE )
                    ->andWhere('cp.course_id = ?', $courseId); 

            if($q->execute()->count() != 0)
            {
                return TRUE;
            }
            else
                return FALSE;
        
        }
        else
            return null;
    }          
    
    public function getLeftoutEnrollments($enrollmentObj = null)
    {
        
        if(!is_null($enrollmentObj) )
        {
            $q = $this->createQuery('e')
                    ->where('e.student_id = ?', $enrollmentObj->getStudentId())
                    ->andWhere('e.leftout = ?', TRUE )
                    ->andWhere('e.year = ?', $enrollmentObj->getYear() )
                    ->andWhere('e.semester = ?', $enrollmentObj->getSemester() )
                    ->andWhere('e.academic_year = ?', $enrollmentObj->getAcademicYear() )
                    ->andWhere('e.program_id = ?', $enrollmentObj->getProgramId() ); 

            if($q->execute()->count() != 0)
            {
                return $q->execute();
            }
            else
                return null;
        
        }
        else
            return null;        
    }
    
    public function getStudentSemesterEnrollments($enrollmentObj)
    {
        
    }
}

