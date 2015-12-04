<?php

/**
 * BaseDepartment
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property integer $faculty_id
 * @property string $description
 * @property Faculty $Faculty
 * @property Doctrine_Collection $Programs
 * @property Doctrine_Collection $Instructor
 * @property Doctrine_Collection $Courses
 * @property Doctrine_Collection $Users
 * 
 * @method string              getName()        Returns the current record's "name" value
 * @method integer             getFacultyId()   Returns the current record's "faculty_id" value
 * @method string              getDescription() Returns the current record's "description" value
 * @method Faculty             getFaculty()     Returns the current record's "Faculty" value
 * @method Doctrine_Collection getPrograms()    Returns the current record's "Programs" collection
 * @method Doctrine_Collection getInstructor()  Returns the current record's "Instructor" collection
 * @method Doctrine_Collection getCourses()     Returns the current record's "Courses" collection
 * @method Doctrine_Collection getUsers()       Returns the current record's "Users" collection
 * @method Department          setName()        Sets the current record's "name" value
 * @method Department          setFacultyId()   Sets the current record's "faculty_id" value
 * @method Department          setDescription() Sets the current record's "description" value
 * @method Department          setFaculty()     Sets the current record's "Faculty" value
 * @method Department          setPrograms()    Sets the current record's "Programs" collection
 * @method Department          setInstructor()  Sets the current record's "Instructor" collection
 * @method Department          setCourses()     Sets the current record's "Courses" collection
 * @method Department          setUsers()       Sets the current record's "Users" collection
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseDepartment extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('department');
        $this->hasColumn('name', 'string', 250, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 250,
             ));
        $this->hasColumn('faculty_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('description', 'string', 500, array(
             'type' => 'string',
             'length' => 500,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Faculty', array(
             'local' => 'faculty_id',
             'foreign' => 'id'));

        $this->hasMany('Program as Programs', array(
             'local' => 'id',
             'foreign' => 'department_id'));

        $this->hasMany('Instructor', array(
             'local' => 'id',
             'foreign' => 'department_id'));

        $this->hasMany('Course as Courses', array(
             'local' => 'id',
             'foreign' => 'department_id'));

        $this->hasMany('User as Users', array(
             'local' => 'id',
             'foreign' => 'department_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}