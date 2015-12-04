<?php

/**
 * BaseAuditLog
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $user_id
 * @property string $action
 * @property User $User
 * 
 * @method integer  getUserId()  Returns the current record's "user_id" value
 * @method string   getAction()  Returns the current record's "action" value
 * @method User     getUser()    Returns the current record's "User" value
 * @method AuditLog setUserId()  Sets the current record's "user_id" value
 * @method AuditLog setAction()  Sets the current record's "action" value
 * @method AuditLog setUser()    Sets the current record's "User" value
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseAuditLog extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('audit_log');
        $this->hasColumn('user_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('action', 'string', 500, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 500,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('User', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}