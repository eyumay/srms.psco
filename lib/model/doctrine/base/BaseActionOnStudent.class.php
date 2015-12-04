<?php

/**
 * BaseActionOnStudent
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $action_name
 * @property string $description
 * @property Doctrine_Collection $StudentInfos
 * 
 * @method string              getActionName()   Returns the current record's "action_name" value
 * @method string              getDescription()  Returns the current record's "description" value
 * @method Doctrine_Collection getStudentInfos() Returns the current record's "StudentInfos" collection
 * @method ActionOnStudent     setActionName()   Sets the current record's "action_name" value
 * @method ActionOnStudent     setDescription()  Sets the current record's "description" value
 * @method ActionOnStudent     setStudentInfos() Sets the current record's "StudentInfos" collection
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseActionOnStudent extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('action_on_student');
        $this->hasColumn('action_name', 'string', 35, array(
             'type' => 'string',
             'notnull' => true,
             'unique' => true,
             'length' => 35,
             ));
        $this->hasColumn('description', 'string', 500, array(
             'type' => 'string',
             'length' => 500,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasMany('StudentInfo as StudentInfos', array(
             'local' => 'id',
             'foreign' => 'action'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}