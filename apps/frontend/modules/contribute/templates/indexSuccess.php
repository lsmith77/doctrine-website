<?php echo $renderer->render() ?>

<?php slot('right'); ?>
  <h2>Table of Contents</h2>
  <ul class="tree">
    <?php echo $renderer->renderToc() ?>
  </ul>
<?php end_slot() ?>