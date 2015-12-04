<?php

/**
 * BaseSectionCourseOffering
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $course_id
 * @property integer $grade_status
 * @property integer $instructor_id
 * @property integer $section_id
 * @property Course $Course
 * @property Instructor $Instructor
 * @property ProgramSection $ProgramSection
 * 
 * @method integer               getCourseId()       Returns the current record's "course_id" value
 * @method integer               getGradeStatus()    Returns the current record's "grade_status" value
 * @method integer               getInstructorId()   Returns the current record's "instructor_id" value
 * @method integer               getSectionId()      Returns the current record's "section_id" value
 * @method Course                getCourse()         Returns the current record's "Course" value
 * @method Instructor            getInstructor()     Returns the current record's "Instructor" value
 * @method ProgramSection        getProgramSection() Returns the current record's "ProgramSection" value
 * @method SectionCourseOffering setCourseId()       Sets the current record's "course_id" value
 * @method SectionCourseOffering setGradeStatus()    Sets the current record's "grade_status" value
 * @method SectionCourseOffering setInstructorId()   Sets the current record's "instructor_id" value
 * @method SectionCourseOffering setSectionId()      Sets the current record's "section_id" value
 * @method SectionCourseOffering setCourse()         Sets the current record's "Course" value
 * @method SectionCourseOffering setInstructor()     Sets the current record's "Instructor" value
 * @method SectionCourseOffering setProgramSection() Sets the current record's "ProgramSection" value
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseSectionCourseOffering extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('section_course_offering');
        $this->hasColumn('course_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('grade_status', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('instructor_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('section_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));


        $this->index('section_course_offering_index', array(
             'fields' => 
             array(
              0 => 'course_id',
              1 => 'section_id',
             ),
             'type' => 'unique',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Course', array(
             'local' => 'course_id',
             'foreign' => 'id'));

        $this->hasOne('Instructor', array(
             'local' => 'instructor_id',
             'foreign' => 'id'));

        $this->hasOne('ProgramSection', array(
             'local' => 'section_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}