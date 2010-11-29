<?php use_stylesheet('contributors.css') ?>
<?php use_helper('I18N', 'Contributor', 'Text'); ?>

<ul id="breadcrumb_trail">
  <li><?php echo link_to('Home', '@homepage', 'class=cms_page_navigation') ?></li>
  <li class="last">About</li>
</ul>

<h2>About the Doctrine Project</h2>

<p>The Doctrine Project is the home of a selected set of PHP libraries primarily
focused on providing persistence services and related functionality.</p>

<h2>Core Team</h2>

<div id="core_team">
  <?php foreach ($contributors as $contributor): ?>
    <div class="contributor_box">
      <?php echo contributor_photo($contributor); ?>
      <div class="info">
        <span class="name" title="<?php echo $contributor->getNick(); ?>"><?php echo $contributor->getName(); ?></span>
        <span class="role"><?php echo $contributor->getRole(); ?></span>
        <span class="about" id="<?php echo $contributor->getId(); ?>_about">
          <?php if ($about = $contributor->getAbout()): ?>
            <?php echo nl2br($about); ?>
          <?php endif; ?>
        </span>

        <?php if ($email = $contributor->getEmail()): ?>
          <span class="email"><?php echo mail_to($email, $email); ?></span>
        <?php endif; ?>

        <?php if ( ! $contributor->getActive()): ?>
          <span class="inactive">In-Active</span>
        <?php endif; ?>
      </div>
    </div>
  <?php endforeach; ?>
</div>

<div id="other_contributors">
  <h2>Other Contributors</h2>
  <ul>
    <?php foreach ($otherContributors as $contributor): ?>
      <li>
        <?php echo $contributor->getName() ?> (<?php echo $contributor->getNick() ?>)
        <p><?php echo $contributor->getRole(); ?>. <?php echo $contributor->getAbout() ?></p>
      </li>
    <?php endforeach; ?>
  </ul>

  <h2>Companies</h2>
  <p>While it is the individuals who work on the project code, some contributions are done on
  company time so we like to give recognition to those companies. Below is a list of companies
  who have contributed significant resources to the project in the past or now:</p>

  <p>
    <img src="<?php echo image_path('/uploads/assets/opensky_logo.png') ?>" />
    <h3><a href="http://engineering.shopopensky.com" target="_BLANK">The OpenSky Project</a></h3>
    <p>The OpenSky Project contributes developers resources to work on the Doctrine MongoDB
    Object Document Mapper. Bulat Shakirzyanov (avalanche123) and Jonathan H. Wage (jwage)
    are both full-time employees at OpenSky.</p>
  </p>

  <p>
    <img src="<?php echo image_path('/uploads/assets/sensio_logo.gif') ?>" />
    <h3><a href="http://www.sensiolabs.org" target="_BLANK">Sensio Labs</a></h3>
    <p>Sensio Labs, the creators of the Symfony framework, sponsored the Doctrine project
    in many ways over the years including employing Jonathan H. Wage full-time to work on
    and speak about open source.</p>
  </p>
</div>