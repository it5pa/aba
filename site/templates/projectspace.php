<?php
/*
  Snippets are a great way to store code snippets for reuse
  or to keep your templates clean.

  This header snippet is reused in all templates.
  It fetches information from the `site.txt` content file
  and contains the site navigation.

  More about snippets:
  https://getkirby.com/docs/guide/templates/snippets
*/
?>
<!DOCTYPE html>
<html lang="en" class="projectspace">
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">

  <?php
  /*
    In the title tag we show the title of our
    site and the title of the current page
  */
  ?>
  <?= css([
    'assets/css/prism.css',
    'assets/css/lightbox.css',
    'assets/css/index.css',
    '@auto'
  ]) ?>
  <title><?= $site->title()->esc() ?> | <?= $page->title()->esc() ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
</head>
<body class="projectspace">
  <section class="projectspace-nav">
    <div class="projectspace-nav__inner">
      <nav class="projectspace-nav__links">
        <div class="projectspace-nav-left">
        <p class="projectspace"><a href="<?=$page->url()?>">ABA Projectspace</a></p>
          <p class="projectspace"><a href="#about-projectspace">About</a></p>
        </div>
        <div class="projectspace-nav-right">
          <p class="projectspace"><a href="#Present">Upcoming & Recently</a></p>
          <p class="projectspace"><a href="#Archive">Archive</a></p>
        </div>  
      </nav>
    </div>
        </section>

<main class="projectspace-main">
  <section id="projectspace-present" class="projectspace-present">
  <?php foreach ($page->currentexhibitions()->toStructure() as $exhibition): ?>
    <div class="projectspace-present-window">
      <?php if ($start = $exhibition->date_range()->start_date()->toDate()): ?>
        <p class="projectspace-date">
          <?= $start->format('d M Y') ?>
          <?php if ($end = $exhibition->date_range()->end_date()->toDate()): ?>
            – <?= $end->format('d M Y') ?>
          <?php endif ?>
        </p>
      <?php endif ?>

      <div class="projectspace-window-front">
        <h1 class="projectspace-title"><?= $exhibition->title()->esc() ?></h1>
        <p class="projectspace-artist"><?= $exhibition->artist()->esc() ?></p>
      </div>

      <?php if ($image = $exhibition->image()->toFile()): ?>
        <img src="<?= $image->url() ?>" alt="<?= $exhibition->title()->esc() ?>" />
      <?php endif ?>

      <div class="description">
        <?= $exhibition->description()->kirbytext() ?>
      </div>
    </div>
  <?php endforeach ?>
</section>

  <section id="about-projectspace">
<?php if ($image = $page->content()->get('image')->toFile()): ?>
  <img src="<?= $image->url() ?>" alt="Project Space Image">
<?php endif ?>
    <div class="projectspace-about-columns">
      <div class="projectspace-about-column">
        <p><?= $page->about()->kt() ?></p>
      </div>
      <div class="projectspace-about-column">
        <p><?= $page->address()->kt() ?></p>
        <p>
          <a href="mailto:<?= $page->email()->esc() ?>" class="visit-appointment-link">Visit by appointment</a>
        </p>
      </div>
    </div>
  </section>
</main>

<?php snippet('footer') ?>
