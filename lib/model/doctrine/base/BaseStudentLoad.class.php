<?php

/**
 * BaseStudentLoad
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $enrollment_info_id
 * @property integer $overload
 * @property integer $underload
 * 
 * @method string      getEnrollmentInfoId()   Returns the current record's "enrollment_info_id" value
 * @method integer     getOverload()           Returns the current record's "overload" value
 * @method integer     getUnderload()          Returns the current record's "underload" value
 * @method StudentLoad setEnrollmentInfoId()   Sets the current record's "enrollment_info_id" value
 * @method StudentLoad setOverload()           Sets the current record's "overload" value
 * @method StudentLoad setUnderload()          Sets the current record's "underload" value
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseStudentLoad extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('student_load');
        $this->hasColumn('enrollment_info_id', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('overload', 'integer', null, array(
             'type' => 'integer',
             ));
        $this->hasColumn('underload', 'integer', null, array(
             'type' => 'integer',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}