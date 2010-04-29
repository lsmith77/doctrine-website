<?php

/**
 * sfGuardUser form.
 *
 * @package    form
 * @subpackage sfGuardUser
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 6174 2007-11-27 06:22:40Z fabien $
 */
class sfGuardUserForm extends PluginsfGuardUserForm
{
  public function configure()
  {
    $choices = sfGuardUser::getSvnAccessItems();
    $this->widgetSchema['svn_access'] = new sfWidgetFormSelectMany(array('multiple' => true, 'choices' => $choices));
  }
}