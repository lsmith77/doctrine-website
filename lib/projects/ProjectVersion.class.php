<?php

class ProjectVersion
{
  public $project;
  public $data;

  public function __construct($project, $data)
  {
    $this->project = $project;
    $this->data = $data;
  }

  public function getOtherVersions()
  {
    $versions = $this->project->getVersions();
    foreach ($versions as $key => $version)
    {
      if ($version->getSlug() === $this->getSlug())
      {
        unset($versions[$key]);
      }
    }
    return $versions;
  }

  public function getProject()
  {
    return $this->project;
  }

  public function getSvnCheckoutCommand()
  {
    return isset($this->data['svn_checkout_command']) ? $this->data['svn_checkout_command'] : null;
  }

  public function getGitCheckoutCommand()
  {
    return isset($this->data['git_checkout_command']) ? $this->data['git_checkout_command'] : null;
  }

  public function getSlug()
  {
    return $this->data['slug'];
  }

  public function getIssuesLink()
  {
    return $this->data['issues_link'];
  }

  public function getStability()
  {
    return isset($this->data['stability']) ? $this->data['stability'] : 'alpha';
  }

  public function getApiSourcePath()
  {
      return isset($this->data['api_source_path']) ? $this->data['api_source_path'] : null;
  }

  public function getDocumentationItems()
  {
    $items = array();
    if (isset($this->data['documentation_items']))
    {
      foreach ($this->data['documentation_items'] as $item => $data)
      {
        $items[$item] = new DocumentationItem($this, $data);
      }
    }
    return $items;
  }

  public function getDocumentationItem($item)
  {
    return new DocumentationItem($this, $this->data['documentation_items'][$item]);
  }

  public function getRelease($slug)
  {
    $release = $this->data['releases'][$slug];
    $release['slug'] = $slug;
    return new ProjectVersionRelease($this, $release);
  }

  public function getReleases()
  {
    $releases = array();
    if (isset($this->data['releases']))
    {
      foreach (array_reverse($this->data['releases']) as $slug => $release)
      {
        $release['slug'] = $slug;
        $releases[$slug] = new ProjectVersionRelease($this, $release);
      }
    }
    return $releases;
  }

  public function getLatestRelease()
  {
    return current($this->getReleases());
  }

  public function getNextReleaseName()
  {
    $code = file_get_contents(sfConfig::get('sf_data_dir').'/'.$this->data['version_file']);
    preg_match_all("/const VERSION = '(.*)';/", $code, $matches);
    return str_replace('-DEV', null, $matches[1][0]);
  }

  public function generateReleasePackage($name)
  {
    preg_match_all("/[0-9].[0-9].[0-9]([A-Z]+)[0-9]/", $name, $matches);
    $stability = strtolower($matches[1][0]);
    $buildProperties = sprintf('version=%s
stability=%s
build.dir=build
dist.dir=dist
report.dir=reports
log.archive.dir=logs
svn.path=/usr/bin/svn
test.phpunit_configuration_file=
test.phpunit_generate_coverage=0
test.pmd_reports=0
test.pdepend_exec=
test.phpmd_exec=', $name, $stability);
    file_put_contents(sfConfig::get('sf_data_dir').'/'.$this->data['source_path'].'/build.properties', $buildProperties);
    
    chdir(sfConfig::get('sf_data_dir').'/'.$this->data['source_path']);
    passthru('phing build-packages');
    return sfConfig::get('sf_data_dir').'/'.$this->data['source_path'].'/dist/Doctrine'.strtoupper($this->project->getShortTitle()).'-'.$name.'.tgz';
  }

  public function addNewRelease($name)
  {
    $packageName = 'Doctrine'.strtoupper($this->project->getShortTitle()).'-'.$name.'.tgz';
    $release = array(
      'package_name' => $packageName,
      'git_checkout_command' => $this->getGitCheckoutCommand(),
      'svn_checkout_command' => $this->getSvnCheckoutCommand(),
      'pear_install_command' => 'pear install pear.doctrine-project.org/'.$packageName
    );
    $projects = Project::getProjectsData();
    $projects[$this->project->getSlug()]['versions'][$this->getSlug()]['releases'][$name] = $release;
    file_put_contents(sfConfig::get('sf_config_dir').'/projects.yml', sfYaml::dump($projects, 10));
    chdir(sfConfig::get('sf_root_dir'));
    passthru('git add config/projects.yml');
    passthru("git commit -m'Updating projects.yml'");
    passthru('git push');
  }

  public function getUpdateSourceCommand()
  {
    return $this->data['update_source_command'];
  }

  public function updateSource()
  {
    if ($command = $this->getUpdateSourceCommand())
    {
      chdir(sfConfig::get('sf_data_dir'));
      passthru($command);
      return true;
    }
  }


  public function getBrowseSourceLink()
  {
    return $this->data['browse_source_link'];
  }

  public function __toString()
  {
    return $this->getSlug();
  }
}