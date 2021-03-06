<?php

/**
 * BasePromotionSetting
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $program_id
 * @property integer $current_year
 * @property integer $current_semester
 * @property integer $to_year
 * @property integer $to_semester
 * @property Program $Program
 * 
 * @method integer          getProgramId()        Returns the current record's "program_id" value
 * @method integer          getCurrentYear()      Returns the current record's "current_year" value
 * @method integer          getCurrentSemester()  Returns the current record's "current_semester" value
 * @method integer          getToYear()           Returns the current record's "to_year" value
 * @method integer          getToSemester()       Returns the current record's "to_semester" value
 * @method Program          getProgram()          Returns the current record's "Program" value
 * @method PromotionSetting setProgramId()        Sets the current record's "program_id" value
 * @method PromotionSetting setCurrentYear()      Sets the current record's "current_year" value
 * @method PromotionSetting setCurrentSemester()  Sets the current record's "current_semester" value
 * @method PromotionSetting setToYear()           Sets the current record's "to_year" value
 * @method PromotionSetting setToSemester()       Sets the current record's "to_semester" value
 * @method PromotionSetting setProgram()          Sets the current record's "Program" value
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasePromotionSetting extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('promotion_setting');
        $this->hasColumn('program_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('current_year', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('current_semester', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('to_year', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('to_semester', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));


        $this->index('promotion_index', array(
             'fields' => 
             array(
              0 => 'program_id',
              1 => 'current_year',
              2 => 'current_semester',
              3 => 'to_year',
              4 => 'to_semester',
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

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}