<?php

/**
 * BaseBlogPost
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @property integer $id
 * @property integer $sf_guard_user_id
 * @property string $name
 * @property clob $body
 * @property boolean $is_published
 * @property sfGuardUser $User
 * @property Doctrine_Collection $Tags
 * @property Doctrine_Collection $BlogPostTags
 * @property Doctrine_Collection $Comments
 * 
 * @method integer             getId()               Returns the current record's "id" value
 * @method integer             getSfGuardUserId()    Returns the current record's "sf_guard_user_id" value
 * @method string              getName()             Returns the current record's "name" value
 * @method clob                getBody()             Returns the current record's "body" value
 * @method boolean             getIsPublished()      Returns the current record's "is_published" value
 * @method sfGuardUser         getUser()             Returns the current record's "User" value
 * @method Doctrine_Collection getTags()             Returns the current record's "Tags" collection
 * @method Doctrine_Collection getBlogPostTags()     Returns the current record's "BlogPostTags" collection
 * @method Doctrine_Collection getComments()         Returns the current record's "Comments" collection
 * @method BlogPost            setId()               Sets the current record's "id" value
 * @method BlogPost            setSfGuardUserId()    Sets the current record's "sf_guard_user_id" value
 * @method BlogPost            setName()             Sets the current record's "name" value
 * @method BlogPost            setBody()             Sets the current record's "body" value
 * @method BlogPost            setIsPublished()      Sets the current record's "is_published" value
 * @method BlogPost            setUser()             Sets the current record's "User" value
 * @method BlogPost            setTags()             Sets the current record's "Tags" collection
 * @method BlogPost            setBlogPostTags()     Sets the current record's "BlogPostTags" collection
 * @method BlogPost            setComments()         Sets the current record's "Comments" collection
 * 
 * @package    doctrine_website
 * @subpackage model
 * @author     Jonathan H. Wage
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class BaseBlogPost extends sfDoctrineRecord
{
    public function setTableDefinition()
    {
        $this->setTableName('blog_post');
        $this->hasColumn('id', 'integer', 4, array(
             'type' => 'integer',
             'primary' => true,
             'autoincrement' => true,
             'length' => 4,
             ));
        $this->hasColumn('sf_guard_user_id', 'integer', 4, array(
             'type' => 'integer',
             'length' => 4,
             ));
        $this->hasColumn('name', 'string', 255, array(
             'type' => 'string',
             'length' => 255,
             ));
        $this->hasColumn('body', 'clob', null, array(
             'type' => 'clob',
             ));
        $this->hasColumn('is_published', 'boolean', null, array(
             'type' => 'boolean',
             'default' => false,
             ));
    }

    public function setUp()
    {
        parent::setUp();
        $this->hasOne('sfGuardUser as User', array(
             'local' => 'sf_guard_user_id',
             'foreign' => 'id'));

        $this->hasMany('Tag as Tags', array(
             'refClass' => 'BlogPostTag',
             'local' => 'blog_post_id',
             'foreign' => 'tag_id'));

        $this->hasMany('BlogPostTag as BlogPostTags', array(
             'local' => 'id',
             'foreign' => 'blog_post_id'));

        $this->hasMany('RecordComment as Comments', array(
             'local' => 'id',
             'foreign' => 'record_id'));

        $sluggable0 = new Doctrine_Template_Sluggable(array(
             'fields' => 
             array(
              0 => 'name',
             ),
             ));
        $timestampable0 = new Doctrine_Template_Timestampable();
        $this->actAs($sluggable0);
        $this->actAs($timestampable0);
    }
}