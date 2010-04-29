<?php
// auto-generated by sfViewConfigHandler
// date: 2010/04/29 15:05:03
$response = $this->context->getResponse();


  $templateName = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_template', $this->actionName);
  $this->setTemplate($templateName.$this->viewName.$this->getExtension());



  if (null !== $layout = sfConfig::get('symfony.view.'.$this->moduleName.'_'.$this->actionName.'_layout'))
  {
    $this->setDecoratorTemplate(false === $layout ? false : $layout.$this->getExtension());
  }
  else if (null === $this->getDecoratorTemplate() && !$this->context->getRequest()->isXmlHttpRequest())
  {
    $this->setDecoratorTemplate('' == 'layout' ? false : 'layout'.$this->getExtension());
  }
  $response->addHttpMeta('content-type', 'text/html', false);
  $response->addMeta('title', 'Doctrine - PHP Object Persistence Libraries and More', false, false);
  $response->addMeta('robots', 'index, follow', false, false);
  $response->addMeta('description', 'Doctrine is a PHP ORM(object relational mapper) for PHP that sits on top of a powerful DBAL(database abstraction layer)', false, false);
  $response->addMeta('keywords', 'doctrine, php orm, database, orm, object relational mapper, database abstraction layer', false, false);
  $response->addMeta('language', 'en', false, false);

  $response->addStylesheet('main', '', array ());
  $response->addStylesheet('layout', '', array ());
  $response->addStylesheet('documentation', '', array ());
  $response->addJavascript('/js/mootools-min.js', '', array ());
  $response->addJavascript('/js/documentation_toc.js', '', array ());


