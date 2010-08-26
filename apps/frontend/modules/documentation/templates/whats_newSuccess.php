<?php slot('top1') ?>
  <?php echo get_partial('documentation/version_menu', array(
    'version' => $version,
    'project' => $project
  )) ?>
<?php end_slot() ?>

<?php use_helper('Documentation') ?>

<ul id="breadcrumb_trail">
  <li><?php echo link_to('Home', '@homepage') ?></li>
  <li><?php echo link_to('Projects', '@projects') ?></li>
  <li><?php echo link_to($project->getTitle(), $project->getRoute()) ?></li>
  <li><?php echo link_to('Documentation', '@project_documentation?slug='.$project->getSlug().'&version='.$sf_request->getParameter('version')) ?></li>
  <li class="last">What's New</li>
</ul>

<div id="documentation">
  <?php echo DocConverter::renderMarkup($markdown) ?>
  <?php echo get_partial('main/help') ?>
</div>