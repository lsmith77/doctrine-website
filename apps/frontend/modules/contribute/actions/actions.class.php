<?php

/**
 * contribute actions.
 *
 * @package    doctrine_website
 * @subpackage contribute
 * @author     Jonathan H. Wage
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class contributeActions extends sfActions
{
  public function executeIndex(sfWebRequest $request)
  {
    $this->getResponse()->setTitle('Doctrine - Contributors and Collaborators Guide');
    
    $toc = new Sensei_Doc_Toc(sfConfig::get('sf_data_dir').'/documentation/contributors-guide/en.txt');
    $this->renderer = new ContributorDocRenderer($toc);
    $this->renderer->setOption('title', 'Doctrine Project Contributors Guide');
    $this->renderer->setOption('author', 'Doctrine Core Team');
    $this->renderer->setOption('version', '1.0');
    $this->renderer->setOption('subject', 'Guide for Doctrine Project contributors and collaborators.');
    $this->renderer->setOption('template', '%CONTENT%');

    $wiki = Text_Wiki::singleton('Doc');
    $wiki->setFormatConf('Xhtml', 'translate', HTML_SPECIALCHARS);
  }
}

class ContributorDocRenderer extends Sensei_Doc_Renderer_Xhtml
{
  protected function _renderToc($section)
  {
      $output = '';

      if ($section instanceof Sensei_Doc_Toc) {
          $class = ' class="tree"';
      } elseif ($section !== $this->_options['section']) {
          $class = ' class="closed"';
      } else {
          $class = '';
      }

      if (!$section instanceof Sensei_Doc_Toc) {
          $output .= '<ul' . $class . '>' . "\n";       
      }

      for ($i = 0; $i < $section->count(); $i++) {
          $child = $section->getChild($i);

          $text = $child->getName();
          $href = $this->makeUrl($child);

          $output .= '<li><a href="' . $href . '">' . $text . '</a>';

          if ($child->count() > 0) {
              $output .= "\n";
              $output .= $this->_renderToc($child);
          }

          $output .= '</li>' . "\n";
      }

      if (!$section instanceof Sensei_Doc_Toc) {
        $output .= '</ul>' . "\n";
      }
  
      return $output;
  }

  protected function _renderSection(Sensei_Doc_Section $section)
  {
    $output = '';

    $level = $section->getLevel();
    
    $title = $section->getName();

    if ($level === 1) {
        $class = ' class="chapter"';
    } else {
        $class = ' class="section"';
    }

    $output .= '<div' . $class .'>' . "\n";

    $output .= "<h$level>";

    if ( ! ($this->_options['section'] instanceof Sensei_Doc_Section)
    || ($level > $this->_options['section']->getLevel())) {
        $anchor = $this->makeAnchor($section);
        $output .= '<a href="#' . $anchor . '" id="' . $anchor . '">';
        $output .= $title . '</a>';
    } else {
        $output .= $title;
    }

    $output .= "</h$level>";

    $output .= $this->_renderMarkup($section->getText());

    // Render children of this section recursively
    for ($i = 0; $i < count($section); $i++) {
        $output .= $this->_renderSection($section->getChild($i));
    }

    $output .= '</div>' . "\n";

    return $output;
  }

  protected function _renderMarkup($markup)
  {
    return DocConverter::renderMarkup($markup, 'markdown');
  }
}