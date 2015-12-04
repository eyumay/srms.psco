<?php

/**
 * BaseStudentProgramSectionTransfer
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $student_id
 * @property integer $section_id
 * @property string $to_section
 * @property Student $Student
 * @property ProgramSection $ProgramSection
 * 
 * @method integer                       getStudentId()      Returns the current record's "student_id" value
 * @method integer                       getSectionId()      Returns the current record's "section_id" value
 * @method string                        getToSection()      Returns the current record's "to_section" value
 * @method Student                       getStudent()        Returns the current record's "Student" value
 * @method ProgramSection                getProgramSection() Returns the current record's "ProgramSection" value
 * @method StudentProgramSectionTransfer setStudentId()      Sets the current record's "student_id" value
 * @method StudentProgramSectionTransfer setSectionId()      Sets the current record's "section_id" value
 * @method StudentProgramSectionTransfer setToSection()      Sets the current record's "to_section" value
 * @method StudentProgramSectionTransfer setStudent()        Sets the current record's "Student" value
 * @method StudentProgramSectionTransfer setProgramSection() Sets the current record's "ProgramSection" value
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStudentProgramSectionTransfer extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('student_program_section_transfer');
        $this->hasColumn('student_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('section_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('to_section', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 200,
             ));


        $this->index('student_program_section_transfer_index', array(
             'fields' => 
             array(
              0 => 'student_id',
              1 => 'section_id',
             ),
             'type' => 'unique',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Student', array(
             'local' => 'student_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasOne('ProgramSection', array(
             'local' => 'section_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}