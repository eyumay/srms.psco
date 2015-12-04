<?php

/**
 * BaseAutoincrement
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $entity_name
 * @property integer $last_value
 * 
 * @method string        getEntityName()  Returns the current record's "entity_name" value
 * @method integer       getLastValue()   Returns the current record's "last_value" value
 * @method Autoincrement setEntityName()  Sets the current record's "entity_name" value
 * @method Autoincrement setLastValue()   Sets the current record's "last_value" value
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAutoincrement extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('autoincrement');
        $this->hasColumn('entity_name', 'string', 255, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 255,
             ));
        $this->hasColumn('last_value', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}