<?php use_stylesheet('documentation') ?>

<ul id="breadcrumb_trail">
  <li><?php echo link_to('Home', '@homepage') ?></li>
  <li><?php echo link_to('Projects', '@projects') ?></li>
  <li><?php echo link_to($project->getTitle(), $project->getRoute()) ?></li>
  <li><?php echo link_to('Download', '@download?slug='.$project->getSlug()) ?></li>
  <li class="last"><?php echo $sf_request->getParameter('release') ?></li>
</ul>

<?php echo button_to('Download ' . $release->getSlug() . ' Package', $release->getPackageLink(), 'class=download-button') ?>

<?php if ($command = $release->getSvnCheckoutCommand()): ?>
  <h2>Checkout from Subversion</h2>
  <pre class="command-line"><code>$ <?php echo $command ?></code></pre>
<?php endif; ?>

<?php if ($command = $release->getGitCheckoutCommand()): ?>
  <h2>Checkout from github</h2>
  <pre class="command-line"><code>$ <?php echo $command ?></code></pre>
<?php endif; ?>

<?php if ($release->canBePearInstalled()): ?>
  <h2>Install via PEAR</h2>

  <pre class="command-line"><code>$ <?php echo $release->getPearInstallCommand() ?></code></pre>
<?php endif; ?>