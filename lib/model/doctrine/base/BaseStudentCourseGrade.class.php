<?php

/**
 * BaseStudentCourseGrade
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $student_id
 * @property integer $instructor_id
 * @property integer $registration_id
 * @property integer $course_id
 * @property integer $grade_id
 * @property boolean $is_repeated
 * @property boolean $is_academic_repeated
 * @property boolean $is_dropped
 * @property boolean $is_added
 * @property boolean $is_calculated
 * @property integer $is_exempted
 * @property integer $regrade_status
 * @property boolean $grade_status
 * @property string $remark
 * @property Grade $Grade
 * @property Student $Student
 * @property Registration $Registration
 * @property Instructor $Instructor
 * @property Course $Course
 * 
 * @method integer            getStudentId()            Returns the current record's "student_id" value
 * @method integer            getInstructorId()         Returns the current record's "instructor_id" value
 * @method integer            getRegistrationId()       Returns the current record's "registration_id" value
 * @method integer            getCourseId()             Returns the current record's "course_id" value
 * @method integer            getGradeId()              Returns the current record's "grade_id" value
 * @method boolean            getIsRepeated()           Returns the current record's "is_repeated" value
 * @method boolean            getIsAcademicRepeated()   Returns the current record's "is_academic_repeated" value
 * @method boolean            getIsDropped()            Returns the current record's "is_dropped" value
 * @method boolean            getIsAdded()              Returns the current record's "is_added" value
 * @method boolean            getIsCalculated()         Returns the current record's "is_calculated" value
 * @method integer            getIsExempted()           Returns the current record's "is_exempted" value
 * @method integer            getRegradeStatus()        Returns the current record's "regrade_status" value
 * @method boolean            getGradeStatus()          Returns the current record's "grade_status" value
 * @method string             getRemark()               Returns the current record's "remark" value
 * @method Grade              getGrade()                Returns the current record's "Grade" value
 * @method Student            getStudent()              Returns the current record's "Student" value
 * @method Registration       getRegistration()         Returns the current record's "Registration" value
 * @method Instructor         getInstructor()           Returns the current record's "Instructor" value
 * @method Course             getCourse()               Returns the current record's "Course" value
 * @method StudentCourseGrade setStudentId()            Sets the current record's "student_id" value
 * @method StudentCourseGrade setInstructorId()         Sets the current record's "instructor_id" value
 * @method StudentCourseGrade setRegistrationId()       Sets the current record's "registration_id" value
 * @method StudentCourseGrade setCourseId()             Sets the current record's "course_id" value
 * @method StudentCourseGrade setGradeId()              Sets the current record's "grade_id" value
 * @method StudentCourseGrade setIsRepeated()           Sets the current record's "is_repeated" value
 * @method StudentCourseGrade setIsAcademicRepeated()   Sets the current record's "is_academic_repeated" value
 * @method StudentCourseGrade setIsDropped()            Sets the current record's "is_dropped" value
 * @method StudentCourseGrade setIsAdded()              Sets the current record's "is_added" value
 * @method StudentCourseGrade setIsCalculated()         Sets the current record's "is_calculated" value
 * @method StudentCourseGrade setIsExempted()           Sets the current record's "is_exempted" value
 * @method StudentCourseGrade setRegradeStatus()        Sets the current record's "regrade_status" value
 * @method StudentCourseGrade setGradeStatus()          Sets the current record's "grade_status" value
 * @method StudentCourseGrade setRemark()               Sets the current record's "remark" value
 * @method StudentCourseGrade setGrade()                Sets the current record's "Grade" value
 * @method StudentCourseGrade setStudent()              Sets the current record's "Student" value
 * @method StudentCourseGrade setRegistration()         Sets the current record's "Registration" value
 * @method StudentCourseGrade setInstructor()           Sets the current record's "Instructor" value
 * @method StudentCourseGrade setCourse()               Sets the current record's "Course" value
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStudentCourseGrade extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('student_course_grade');
        $this->hasColumn('student_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('instructor_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('registration_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('course_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('grade_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('is_repeated', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('is_academic_repeated', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('is_dropped', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('is_added', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('is_calculated', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 1,
             ));
        $this->hasColumn('is_exempted', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('regrade_status', 'integer', null, array(
             'type' => 'integer',
             'default' => 0,
             ));
        $this->hasColumn('grade_status', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('remark', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Grade', array(
             'local' => 'grade_id',
             'foreign' => 'id'));

        $this->hasOne('Student', array(
             'local' => 'student_id',
             'foreign' => 'id'));

        $this->hasOne('Registration', array(
             'local' => 'registration_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Instructor', array(
             'local' => 'instructor_id',
             'foreign' => 'id'));

        $this->hasOne('Course', array(
             'local' => 'course_id',
             'foreign' => 'id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}