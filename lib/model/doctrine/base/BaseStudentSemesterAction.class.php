<?php

/**
 * BaseStudentSemesterAction
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $name
 * @property integer $value
 * @property string $description
 * 
 * @method string                getName()        Returns the current record's "name" value
 * @method integer               getValue()       Returns the current record's "value" value
 * @method string                getDescription() Returns the current record's "description" value
 * @method StudentSemesterAction setName()        Sets the current record's "name" value
 * @method StudentSemesterAction setValue()       Sets the current record's "value" value
 * @method StudentSemesterAction setDescription() Sets the current record's "description" value
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStudentSemesterAction extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('student_semester_action');
        $this->hasColumn('name', 'string', 35, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 35,
             ));
        $this->hasColumn('value', 'integer', null, array(
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
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}