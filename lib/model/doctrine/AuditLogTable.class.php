<?php

/**
 * AuditLogTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
class AuditLogTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object AuditLogTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('AuditLog');
    }
}