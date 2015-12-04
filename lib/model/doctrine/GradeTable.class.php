<?php

/**
 * GradeTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class GradeTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object GradeTable
     */
    static public $majorCourseFailureGrades     = array('D+', 'D', 'D-', 'F');
    static public $nonMajorCourseFailureGrades  = array('F');
    
    static function getMajorCourseFailureGrades()
    {
        return self::$majorCourseFailureGrades;
    }
    
    static function getNonMajorCourseFailureGrades()
    {
        return self::$nonMajorCourseFailureGrades;
    }   
    
    public static function getInstance()
    {
        return Doctrine_Core::getTable('Grade');
    }
    public function getAllLetterGradeChoices()
    {
        $q = Doctrine_Query::create()
            ->from('Grade ei__');
        return $q->execute();
    }
    
    public static function getGradeChoicesAsArray($gradeObject = NULL )
    {
        $gradeChoices = array();
        foreach($gradeObject as $gradeObj )
            $gradeChoices[$gradeObj->getId()] = $gradeObj->getGradeChar();
        
        return $gradeChoices;
    }
    public function getGradeDetailById($id = NULL)
    {
        /* $q = Doctrine_Query::create()
            ->from('Grade ei__')
            ->where('ei__.id = ?', $id);
         * 
         */
        
        return Doctrine_Core::getTable('Grade')->findOneById($id);
    }
    public function getClearanceGradeChoice()
    {
        $grade = array('C', 'C-', 'D+', 'D', 'D-', 'F', 'NG', 'I');
        $gradeChoicesForFail = array(''=>'--- Select grade ---');
        $q = Doctrine_Query::create()
                ->from('Grade')
                ->whereIn('gradechar', $grade);
        
        foreach($q->execute() as $g)
            $gradeChoicesForFail[$g->getId()] = $g->getGradechar();
        
        return $gradeChoicesForFail;
    }
}