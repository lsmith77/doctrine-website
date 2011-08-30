<?php
/**
 * documentation actions.
 *
 * @package    doctrine_website
 * @subpackage documentation
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 2692 2006-11-15 21:03:55Z fabien $
 */
class documentationActions extends sfActions
{
  public function executeApi()
  {
    $this->project = Project::getProject($this->getRequestParameter('slug'));
    $this->forward404Unless($this->project);

    $this->version = $this->project->getVersion($this->getRequestParameter('version'));
    $this->forward404Unless($this->version);

    $this->setLayout(false);
    sfConfig::set('sf_web_debug', false);
  }

  public function executeApi_navigation()
  {
    $this->project = Project::getProject($this->getRequestParameter('slug'));
    $this->forward404Unless($this->project);

    $this->version = $this->project->getVersion($this->getRequestParameter('version'));
    $this->forward404Unless($this->version);

    $this->setLayout(false);
    sfConfig::set('sf_web_debug', false);
  }

  public function executeGlobal_index()
  {
    $this->getResponse()->setTitle('Doctrine - Documentation');
    $this->projects = Project::getAllProjects();
  }

  public function executeIndex()
  {
    $this->project = Project::getProject($this->getRequestParameter('slug'));
    $this->forward404Unless($this->project);

    if ( !($version = $this->getRequestParameter('version') == 'current')) {
        $version = $this->project->getLatestVersion()->getSlug();
    }

    $this->version = $this->project->getVersion($version);
    $this->forward404Unless($this->version);

    $this->documentationItems = $this->version->getDocumentationItems($this->getRequestParameter('version'));

    $this->getResponse()->setTitle('Doctrine - '.$this->project->getTitle().' Documentation ('.$this->version->getSlug().')');
  }

  public function executeItem_index()
  {
    $this->project = Project::getProject($this->getRequestParameter('slug'));
    $this->forward404Unless($this->project);

    $this->version = $this->project->getVersion($this->getRequestParameter('version'));
    $this->forward404Unless($this->version);

    $this->documentationItem = $this->version->getDocumentationItem($this->getRequestParameter('item'));
    if ($this->documentationItem->isReStructuredTextDocumentation()) {
      return $this->redirect($this->documentationItem->getReStDocRedirectUrl(), 302);
    }

    $this->renderer = $this->documentationItem->getRenderer(
      $this->getRequestParameter('sf_culture'),
      $this->getUser(),
      $this->getRequestParameter('format', 'DoctrineXhtml')
    );

    $this->getResponse()->setTitle('Doctrine - '.$this->documentationItem->getTitle());
  }

  public function executeItem_chapter()
  {
    $this->project = Project::getProject($this->getRequestParameter('slug'));
    $this->forward404Unless($this->project);

    $this->version = $this->project->getVersion($this->getRequestParameter('version'));
    $this->forward404Unless($this->version);

    $this->documentationItem = $this->version->getDocumentationItem($this->getRequestParameter('item'));
    if ($this->documentationItem->isReStructuredTextDocumentation()) {
      return $this->redirect($this->documentationItem->getReStDocRedirectUrl(
        $this->getRequestParameter('chapter')), 302
      );
    }

    $this->renderer = $this->documentationItem->getRenderer(
      $this->getRequestParameter('sf_culture'),
      $this->getUser(),
      $this->getRequestParameter('chapter')
    );

    $this->getResponse()->setTitle('Doctrine - '.$this->documentationItem->getTitle().' - '.$this->renderer->getChapter()->getName());
  }

  public function executeWhats_new()
  {
      $this->project = Project::getProject($this->getRequestParameter('slug'));
      $this->forward404Unless($this->project);

      $this->version = $this->project->getVersion($this->getRequestParameter('version'));
      $this->forward404Unless($this->version);

      $this->markdown = $this->version->getWhatsNewMarkdown();
      $this->forward404Unless($this->markdown);
  }
}