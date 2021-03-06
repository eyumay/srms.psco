<?php

/**
 * BaseStatusSetting
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $year
 * @property integer $semester
 * @property float $min_grade_point
 * @property float $max_grade_point
 * @property string $status
 * 
 * @method integer       getYear()            Returns the current record's "year" value
 * @method integer       getSemester()        Returns the current record's "semester" value
 * @method float         getMinGradePoint()   Returns the current record's "min_grade_point" value
 * @method float         getMaxGradePoint()   Returns the current record's "max_grade_point" value
 * @method string        getStatus()          Returns the current record's "status" value
 * @method StatusSetting setYear()            Sets the current record's "year" value
 * @method StatusSetting setSemester()        Sets the current record's "semester" value
 * @method StatusSetting setMinGradePoint()   Sets the current record's "min_grade_point" value
 * @method StatusSetting setMaxGradePoint()   Sets the current record's "max_grade_point" value
 * @method StatusSetting setStatus()          Sets the current record's "status" value
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStatusSetting extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('status_setting');
        $this->hasColumn('year', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('semester', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('min_grade_point', 'float', null, array(
             'type' => 'float',
             'notnull' => true,
             ));
        $this->hasColumn('max_grade_point', 'float', null, array(
             'type' => 'float',
             'notnull' => true,
             ));
        $this->hasColumn('status', 'string', 50, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 50,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}