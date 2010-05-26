<?php

class DoctrineReleaseTask extends sfBaseTask
{
  protected function configure()
  {
    $this->addArguments(array(
      new sfCommandArgument('project', sfCommandArgument::REQUIRED, 'The project slug.'),
      new sfCommandArgument('version', sfCommandArgument::REQUIRED, 'The project version slug.')
    ));

    $this->namespace        = 'doctrine';
    $this->name             = 'release';
    $this->briefDescription = '';
    $this->detailedDescription = <<<EOF
The [doctrine:release|INFO] task creates a new release.
Call it with:

  [php symfony doctrine:release orm|INFO]
EOF;
  }

  protected function execute($arguments = array(), $options = array())
  {
    $project = new Project($arguments['project']);
    $version = $project->getVersion($arguments['version']);

    if (!$this->askConfirmation(sprintf('Are you sure you want to generate a release for the %s? (y/n)', $project->getSlug())))
    {
      return 1;
    }
    $this->logSection('doctrine', 'Updating sources...');
    $version->updateSource();

    $name = $version->getNextReleaseName();
    if (!$this->askConfirmation(sprintf('The next release to generate is %s, do you want to continue? (y/n)', $name)))
    {
      return 1;
    }

    $path = $version->generateReleasePackage($name);
    if (file_exists($path)) {
      $this->logSection('doctrine', 'Package generated successfully...');
      $this->logSection('doctrine', $path);
      if (!$this->askConfirmation(sprintf('Do you want to install the new version to the pirum PEAR server? (y/n)', $project->getSlug())))
      {
        return 1;
      }
      $this->logSection('doctrine', sprintf('Adding %s to project version releases', $name));
      $version->addNewRelease($name);

      chdir(sfConfig::get('sf_root_dir'));
      passthru('pirum add pear '.$path);
  
      $this->logSection('doctrine', 'Copying package to downloads directory.');
      $info = pathinfo($path);
      copy($path, sfConfig::get('sf_web_dir').'/downloads/'.$info['basename']);
    }
  }
}