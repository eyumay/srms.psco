<?php

/**
 * StudentExemptionTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class StudentExemptionTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object StudentExemptionTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('StudentExemption');
    }
    
    public function getExemptedCourses($studentId = null )
    {
        if(!is_null($studentId))
        {
            $q = Doctrine_Query::create()
                    ->from('StudentExemption se')
                    ->where('se.student_id = ?', $studentId); 
            
            if($q->execute()->count() != 0)
                return $q->execute(); 
            else
                return null; 
        }
        else 
            return null;
    }
    
    public function checkIfCourseIsExempted($studentId = null, $courseId = null )
    {
        if(!is_null($studentId) || !is_null($courseId))
        {
            $q = Doctrine_Query::create()
                    ->from('StudentExemption se')
                    ->where('se.student_id = ?', $studentId)
                    ->andWhere('se.course_id = ?', $courseId); 
            
            if($q->execute()->count() != 0)
                return TRUE; 
            else
                return FALSE; 
        }
        else 
            return null;
    }   
}