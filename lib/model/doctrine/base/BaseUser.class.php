<?php

/**
 * BaseUser
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property string $login
 * @property string $password
 * @property string $first_name
 * @property string $fathers_name
 * @property string $grand_fathers_name
 * @property string $privilege
 * @property string $gender
 * @property string $email
 * @property integer $department_id
 * @property boolean $is_active
 * @property Department $Department
 * @property Doctrine_Collection $AuditLogs
 * 
 * @method string              getLogin()              Returns the current record's "login" value
 * @method string              getPassword()           Returns the current record's "password" value
 * @method string              getFirstName()          Returns the current record's "first_name" value
 * @method string              getFathersName()        Returns the current record's "fathers_name" value
 * @method string              getGrandFathersName()   Returns the current record's "grand_fathers_name" value
 * @method string              getPrivilege()          Returns the current record's "privilege" value
 * @method string              getGender()             Returns the current record's "gender" value
 * @method string              getEmail()              Returns the current record's "email" value
 * @method integer             getDepartmentId()       Returns the current record's "department_id" value
 * @method boolean             getIsActive()           Returns the current record's "is_active" value
 * @method Department          getDepartment()         Returns the current record's "Department" value
 * @method Doctrine_Collection getAuditLogs()          Returns the current record's "AuditLogs" collection
 * @method User                setLogin()              Sets the current record's "login" value
 * @method User                setPassword()           Sets the current record's "password" value
 * @method User                setFirstName()          Sets the current record's "first_name" value
 * @method User                setFathersName()        Sets the current record's "fathers_name" value
 * @method User                setGrandFathersName()   Sets the current record's "grand_fathers_name" value
 * @method User                setPrivilege()          Sets the current record's "privilege" value
 * @method User                setGender()             Sets the current record's "gender" value
 * @method User                setEmail()              Sets the current record's "email" value
 * @method User                setDepartmentId()       Sets the current record's "department_id" value
 * @method User                setIsActive()           Sets the current record's "is_active" value
 * @method User                setDepartment()         Sets the current record's "Department" value
 * @method User                setAuditLogs()          Sets the current record's "AuditLogs" collection
 * 
 * @package    srmsnew
 * @subpackage model
 * @author     EyuelG
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseUser extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('user');
        $this->hasColumn('login', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('password', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('first_name', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('fathers_name', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('grand_fathers_name', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('privilege', 'string', 200, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 200,
             ));
        $this->hasColumn('gender', 'string', 10, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 10,
             ));
        $this->hasColumn('email', 'string', 100, array(
             'type' => 'string',
             'notnull' => true,
             'length' => 100,
             ));
        $this->hasColumn('department_id', 'integer', null, array(
             'type' => 'integer',
             'notnull' => true,
             ));
        $this->hasColumn('is_active', 'boolean', null, array(
             'type' => 'boolean',
             'notnull' => true,
             ));


        $this->index('login_index', array(
             'fields' => 
             array(
              0 => 'login',
             ),
             'type' => 'unique',
             ));
        $this->index('email_index', array(
             'fields' => 
             array(
              0 => 'email',
             ),
             'type' => 'unique',
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('Department', array(
             'local' => 'department_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $this->hasMany('AuditLog as AuditLogs', array(
             'local' => 'id',
             'foreign' => 'user_id'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}