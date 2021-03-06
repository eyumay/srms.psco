<?php

/**
 * BaseStudentInfo
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $student_id
 * @property integer $program_id
 * @property string $section_id
 * @property integer $academic_year
 * @property integer $year
 * @property integer $semester
 * @property boolean $leftout
 * @property integer $advisor
 * @property integer $status
 * @property string $mention
 * @property integer $action
 * @property integer $previous_chrs
 * @property integer $semester_chrs
 * @property integer $total_chrs
 * @property float $previous_grade_points
 * @property float $semester_grade_points
 * @property float $total_grade_points
 * @property float $previous_repeated_chrs
 * @property float $semester_repeated_chrs
 * @property float $total_repeated_chrs
 * @property float $previous_repeated_grade_points
 * @property float $semester_repeated_grade_points
 * @property float $total_repeated_grade_points
 * @property integer $program_checklist_id
 * @property Student $Student
 * @property Program $Program
 * @property StudentStatus $StudentStatus
 * @property Instructor $Instructor
 * @property ActionOnStudent $ActionOnStudent
 * @property Doctrine_Collection $Registration
 * @property Doctrine_Collection $StudentReadmission
 * @property Doctrine_Collection $StudentWithdrawal
 * 
 * @method integer             getStudentId()                      Returns the current record's "student_id" value
 * @method integer             getProgramId()                      Returns the current record's "program_id" value
 * @method string              getSectionId()                      Returns the current record's "section_id" value
 * @method integer             getAcademicYear()                   Returns the current record's "academic_year" value
 * @method integer             getYear()                           Returns the current record's "year" value
 * @method integer             getSemester()                       Returns the current record's "semester" value
 * @method boolean             getLeftout()                        Returns the current record's "leftout" value
 * @method integer             getAdvisor()                        Returns the current record's "advisor" value
 * @method integer             getStatus()                         Returns the current record's "status" value
 * @method string              getMention()                        Returns the current record's "mention" value
 * @method integer             getAction()                         Returns the current record's "action" value
 * @method integer             getPreviousChrs()                   Returns the current record's "previous_chrs" value
 * @method integer             getSemesterChrs()                   Returns the current record's "semester_chrs" value
 * @method integer             getTotalChrs()                      Returns the current record's "total_chrs" value
 * @method float               getPreviousGradePoints()            Returns the current record's "previous_grade_points" value
 * @method float               getSemesterGradePoints()            Returns the current record's "semester_grade_points" value
 * @method float               getTotalGradePoints()               Returns the current record's "total_grade_points" value
 * @method float               getPreviousRepeatedChrs()           Returns the current record's "previous_repeated_chrs" value
 * @method float               getSemesterRepeatedChrs()           Returns the current record's "semester_repeated_chrs" value
 * @method float               getTotalRepeatedChrs()              Returns the current record's "total_repeated_chrs" value
 * @method float               getPreviousRepeatedGradePoints()    Returns the current record's "previous_repeated_grade_points" value
 * @method float               getSemesterRepeatedGradePoints()    Returns the current record's "semester_repeated_grade_points" value
 * @method float               getTotalRepeatedGradePoints()       Returns the current record's "total_repeated_grade_points" value
 * @method integer             getProgramChecklistId()             Returns the current record's "program_checklist_id" value
 * @method Student             getStudent()                        Returns the current record's "Student" value
 * @method Program             getProgram()                        Returns the current record's "Program" value
 * @method StudentStatus       getStudentStatus()                  Returns the current record's "StudentStatus" value
 * @method Instructor          getInstructor()                     Returns the current record's "Instructor" value
 * @method ActionOnStudent     getActionOnStudent()                Returns the current record's "ActionOnStudent" value
 * @method Doctrine_Collection getRegistration()                   Returns the current record's "Registration" collection
 * @method Doctrine_Collection getStudentReadmission()             Returns the current record's "StudentReadmission" collection
 * @method Doctrine_Collection getStudentWithdrawal()              Returns the current record's "StudentWithdrawal" collection
 * @method StudentInfo         setStudentId()                      Sets the current record's "student_id" value
 * @method StudentInfo         setProgramId()                      Sets the current record's "program_id" value
 * @method StudentInfo         setSectionId()                      Sets the current record's "section_id" value
 * @method StudentInfo         setAcademicYear()                   Sets the current record's "academic_year" value
 * @method StudentInfo         setYear()                           Sets the current record's "year" value
 * @method StudentInfo         setSemester()                       Sets the current record's "semester" value
 * @method StudentInfo         setLeftout()                        Sets the current record's "leftout" value
 * @method StudentInfo         setAdvisor()                        Sets the current record's "advisor" value
 * @method StudentInfo         setStatus()                         Sets the current record's "status" value
 * @method StudentInfo         setMention()                        Sets the current record's "mention" value
 * @method StudentInfo         setAction()                         Sets the current record's "action" value
 * @method StudentInfo         setPreviousChrs()                   Sets the current record's "previous_chrs" value
 * @method StudentInfo         setSemesterChrs()                   Sets the current record's "semester_chrs" value
 * @method StudentInfo         setTotalChrs()                      Sets the current record's "total_chrs" value
 * @method StudentInfo         setPreviousGradePoints()            Sets the current record's "previous_grade_points" value
 * @method StudentInfo         setSemesterGradePoints()            Sets the current record's "semester_grade_points" value
 * @method StudentInfo         setTotalGradePoints()               Sets the current record's "total_grade_points" value
 * @method StudentInfo         setPreviousRepeatedChrs()           Sets the current record's "previous_repeated_chrs" value
 * @method StudentInfo         setSemesterRepeatedChrs()           Sets the current record's "semester_repeated_chrs" value
 * @method StudentInfo         setTotalRepeatedChrs()              Sets the current record's "total_repeated_chrs" value
 * @method StudentInfo         setPreviousRepeatedGradePoints()    Sets the current record's "previous_repeated_grade_points" value
 * @method StudentInfo         setSemesterRepeatedGradePoints()    Sets the current record's "semester_repeated_grade_points" value
 * @method StudentInfo         setTotalRepeatedGradePoints()       Sets the current record's "total_repeated_grade_points" value
 * @method StudentInfo         setProgramChecklistId()             Sets the current record's "program_checklist_id" value
 * @method StudentInfo         setStudent()                        Sets the current record's "Student" value
 * @method StudentInfo         setProgram()                        Sets the current record's "Program" value
 * @method StudentInfo         setStudentStatus()                  Sets the current record's "StudentStatus" value
 * @method StudentInfo         setInstructor()                     Sets the current record's "Instructor" value
 * @method StudentInfo         setActionOnStudent()                Sets the current record's "ActionOnStudent" value
 * @method StudentInfo         setRegistration()                   Sets the current record's "Registration" collection
 * @method StudentInfo         setStudentReadmission()             Sets the current record's "StudentReadmission" collection
 * @method StudentInfo         setStudentWithdrawal()              Sets the current record's "StudentWithdrawal" collection
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStudentInfo extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('student_info');
        $this->hasColumn('student_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('program_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('section_id', 'string', 5, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 5,
             ));
        $this->hasColumn('academic_year', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('year', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('semester', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('leftout', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => false,
             'default' => 0,
             ));
        $this->hasColumn('advisor', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('status', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('mention', 'string', 5, array(
             'type' => 'string',
             'notnull' => false,
             'length' => 5,
             ));
        $this->hasColumn('action', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('previous_chrs', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('semester_chrs', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('total_chrs', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('previous_grade_points', 'float', null, array(
             'type' => 'float',
             'notnull' => false,
             ));
        $this->hasColumn('semester_grade_points', 'float', null, array(
             'type' => 'float',
             'notnull' => false,
             ));
        $this->hasColumn('total_grade_points', 'float', null, array(
             'type' => 'float',
             'notnull' => false,
             ));
        $this->hasColumn('previous_repeated_chrs', 'float', null, array(
             'type' => 'float',
             'notnull' => false,
             ));
        $this->hasColumn('semester_repeated_chrs', 'float', null, array(
             'type' => 'float',
             'notnull' => false,
             ));
        $this->hasColumn('total_repeated_chrs', 'float', null, array(
             'type' => 'float',
             'notnull' => false,
             ));
        $this->hasColumn('previous_repeated_grade_points', 'float', null, array(
             'type' => 'float',
             'notnull' => false,
             ));
        $this->hasColumn('semester_repeated_grade_points', 'float', null, array(
             'type' => 'float',
             'notnull' => false,
             ));
        $this->hasColumn('total_repeated_grade_points', 'float', null, array(
             'type' => 'float',
             'notnull' => false,
             ));
        $this->hasColumn('program_checklist_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Student', array(
             'local' => 'student_id',
             'foreign' => 'id'));

        $this->hasOne('Program', array(
             'local' => 'program_id',
             'foreign' => 'id'));

        $this->hasOne('StudentStatus', array(
             'local' => 'status',
             'foreign' => 'id'));

        $this->hasOne('Instructor', array(
             'local' => 'advisor',
             'foreign' => 'id'));

        $this->hasOne('ActionOnStudent', array(
             'local' => 'action',
             'foreign' => 'id'));

        $this->hasMany('Registration', array(
             'local' => 'id',
             'foreign' => 'student_info_id'));

        $this->hasMany('StudentReadmission', array(
             'local' => 'id',
             'foreign' => 'student_info_id'));

        $this->hasMany('StudentWithdrawal', array(
             'local' => 'id',
             'foreign' => 'student_info_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}