<?php

/**
 * BaseProgramSection
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $program_id
 * @property integer $center_id
 * @property integer $academic_advisor_id
 * @property integer $academic_calendar_id
 * @property integer $number_of_student
 * @property string $academic_year
 * @property integer $year
 * @property integer $semester
 * @property integer $section_number
 * @property boolean $is_activated
 * @property boolean $is_promoted
 * @property Program $Program
 * @property AcademicCalendar $AcademicCalendar
 * @property Instructor $Instructor
 * @property Center $Center
 * @property Doctrine_Collection $SectionCourseOfferings
 * @property Doctrine_Collection $EnrollmentInfos
 * @property Doctrine_Collection $StudentProgramSectionTransfers
 * 
 * @method integer             getProgramId()                      Returns the current record's "program_id" value
 * @method integer             getCenterId()                       Returns the current record's "center_id" value
 * @method integer             getAcademicAdvisorId()              Returns the current record's "academic_advisor_id" value
 * @method integer             getAcademicCalendarId()             Returns the current record's "academic_calendar_id" value
 * @method integer             getNumberOfStudent()                Returns the current record's "number_of_student" value
 * @method string              getAcademicYear()                   Returns the current record's "academic_year" value
 * @method integer             getYear()                           Returns the current record's "year" value
 * @method integer             getSemester()                       Returns the current record's "semester" value
 * @method integer             getSectionNumber()                  Returns the current record's "section_number" value
 * @method boolean             getIsActivated()                    Returns the current record's "is_activated" value
 * @method boolean             getIsPromoted()                     Returns the current record's "is_promoted" value
 * @method Program             getProgram()                        Returns the current record's "Program" value
 * @method AcademicCalendar    getAcademicCalendar()               Returns the current record's "AcademicCalendar" value
 * @method Instructor          getInstructor()                     Returns the current record's "Instructor" value
 * @method Center              getCenter()                         Returns the current record's "Center" value
 * @method Doctrine_Collection getSectionCourseOfferings()         Returns the current record's "SectionCourseOfferings" collection
 * @method Doctrine_Collection getEnrollmentInfos()                Returns the current record's "EnrollmentInfos" collection
 * @method Doctrine_Collection getStudentProgramSectionTransfers() Returns the current record's "StudentProgramSectionTransfers" collection
 * @method ProgramSection      setProgramId()                      Sets the current record's "program_id" value
 * @method ProgramSection      setCenterId()                       Sets the current record's "center_id" value
 * @method ProgramSection      setAcademicAdvisorId()              Sets the current record's "academic_advisor_id" value
 * @method ProgramSection      setAcademicCalendarId()             Sets the current record's "academic_calendar_id" value
 * @method ProgramSection      setNumberOfStudent()                Sets the current record's "number_of_student" value
 * @method ProgramSection      setAcademicYear()                   Sets the current record's "academic_year" value
 * @method ProgramSection      setYear()                           Sets the current record's "year" value
 * @method ProgramSection      setSemester()                       Sets the current record's "semester" value
 * @method ProgramSection      setSectionNumber()                  Sets the current record's "section_number" value
 * @method ProgramSection      setIsActivated()                    Sets the current record's "is_activated" value
 * @method ProgramSection      setIsPromoted()                     Sets the current record's "is_promoted" value
 * @method ProgramSection      setProgram()                        Sets the current record's "Program" value
 * @method ProgramSection      setAcademicCalendar()               Sets the current record's "AcademicCalendar" value
 * @method ProgramSection      setInstructor()                     Sets the current record's "Instructor" value
 * @method ProgramSection      setCenter()                         Sets the current record's "Center" value
 * @method ProgramSection      setSectionCourseOfferings()         Sets the current record's "SectionCourseOfferings" collection
 * @method ProgramSection      setEnrollmentInfos()                Sets the current record's "EnrollmentInfos" collection
 * @method ProgramSection      setStudentProgramSectionTransfers() Sets the current record's "StudentProgramSectionTransfers" collection
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseProgramSection extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('program_section');
        $this->hasColumn('program_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('center_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('academic_advisor_id', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('academic_calendar_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('number_of_student', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('academic_year', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('year', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('semester', 'integer', null, array(
             'type' => 'integer',
             'notnull' => false,
             ));
        $this->hasColumn('section_number', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('is_activated', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));
        $this->hasColumn('is_promoted', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             'default' => 0,
             ));


        $this->index('batch_section_index', array(
             'fields' => 
             array(
              0 => 'program_id',
              1 => 'academic_year',
              2 => 'year',
              3 => 'semester',
              4 => 'section_number',
              5 => 'center_id',
             ),
             'type' => 'unique',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Program', array(
             'local' => 'program_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('AcademicCalendar', array(
             'local' => 'academic_calendar_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('Instructor', array(
             'local' => 'academic_advisor_id',
             'foreign' => 'id'));

        $this->hasOne('Center', array(
             'local' => 'center_id',
             'foreign' => 'id'));

        $this->hasMany('SectionCourseOffering as SectionCourseOfferings', array(
             'local' => 'id',
             'foreign' => 'section_id'));

        $this->hasMany('EnrollmentInfo as EnrollmentInfos', array(
             'local' => 'id',
             'foreign' => 'section_id'));

        $this->hasMany('StudentProgramSectionTransfer as StudentProgramSectionTransfers', array(
             'local' => 'id',
             'foreign' => 'section_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}