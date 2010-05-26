<div id="documentation">
  <?php echo $renderer->render() ?>
</div>

<?php slot('right'); ?>
  <h2>Table of Contents</h2>
  <ul class="tree">
    <?php echo $renderer->renderToc() ?>
  </ul>
<?php end_slot() ?>