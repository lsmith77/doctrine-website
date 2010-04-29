<?php
/*
 * Edit this file to customise your model class
 *
 * auto-generated by the sfDoctrine plugin
 */
class BlogPost extends BaseBlogPost
{
  public function filterSetName($name)
  {
    $this->setSlug(Common::createSlug($name));
    
    return $name;
  }

  public function getRecordRoute()
  {
    return $this->getRoute();
  }

  public function getRoute()
  {
    return '@blog_post?slug=' . $this->getSlug();
  }
  
  public function getType()
  {
    return 'Blog Post';
  }

  public function getFormattedBody()
  {
    if (strtotime($this->getCreatedAt()) >= strtotime(date('2008-10-17'))) {
      return DocConverter::renderMarkup($this->_get('body'), 'markdown');
    } else {
      return $this->_get('body');
    }
  }
}