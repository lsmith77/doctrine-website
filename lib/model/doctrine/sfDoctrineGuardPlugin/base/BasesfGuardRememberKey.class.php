<?php

/**
 * BasesfGuardRememberKey
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $user_id
 * @property string $remember_key
 * @property string $ip_address
 * @property sfGuardUser $sfGuardUser
 * 
 * @method integer            getId()           Returns the current record's "id" value
 * @method integer            getUserId()       Returns the current record's "user_id" value
 * @method string             getRememberKey()  Returns the current record's "remember_key" value
 * @method string             getIpAddress()    Returns the current record's "ip_address" value
 * @method sfGuardUser        getSfGuardUser()  Returns the current record's "sfGuardUser" value
 * @method sfGuardRememberKey setId()           Sets the current record's "id" value
 * @method sfGuardRememberKey setUserId()       Sets the current record's "user_id" value
 * @method sfGuardRememberKey setRememberKey()  Sets the current record's "remember_key" value
 * @method sfGuardRememberKey setIpAddress()    Sets the current record's "ip_address" value
 * @method sfGuardRememberKey setSfGuardUser()  Sets the current record's "sfGuardUser" value
 * 
 * @package    doctrine_website
 * @subpackage model
 * @author     Jonathan H. Wage
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BasesfGuardRememberKey extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('sf_guard_remember_key');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('remember_key', 'string', 32, array(
             'type' => 'string',
             'length' => 32,
             ));
        $this->hasColumn('ip_address', 'string', 50, array(
             'type' => 'string',
             'primary' => true,
             'length' => 50,
             ));

        $this->option('symfony', array(
             'form' => false,
             'filter' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser', array(
             'local' => 'user_id',
             'foreign' => 'id',
             'onDelete' => 'CASCADE'));

        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($timestampable0);
    }
}