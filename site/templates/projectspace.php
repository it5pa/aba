<!DOCTYPE html>
<html lang="en" class=projectspace>
<head>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0">
  <?= css([
    'assets/css/prism.css',
    'assets/css/lightbox.css',
    'assets/css/index.css',
    '@auto'
  ]) ?>
  <title><?= $site->title()->esc() ?> | <?= $page->title()->esc() ?></title>
  <link rel="shortcut icon" type="image/x-icon" href="<?= url('favicon.ico') ?>">
</head>
<body style="width: 90vw;">

    <!-- AirSalon Button -->
  <div class="space-navigation-air">
  <div class="space-navigation-air-inner">
    <a href="<?= $site->find('airsalon')->url() ?>" 
    class="space-navigation-air-link" 
    aria-label="Air Salon">
    <!-- <span class="cursor-tooltip">Air Salon</span> -->
    </a>  
  </div>
</div>

<main class="main-projectspace">
  <section class="projectspace-nav">
    <div class="projectspace-nav__inner">
      <nav class="projectspace-nav__links">
        <div class="projectspace-nav-left">
        <p class="projectspace"><a href=#>ABA Projectspace</a></p>
          <p class="projectspace"><a href="#about-projectspace">About</a></p>
        </div>
        <div class="projectspace-nav-right">
            <p class="projectspace"><a href="#projectspace-present">Upcoming & Recently</a></p>
          <p class="projectspace"><a href="#archive-projectspace">Archive</a></p>
        </div>  
      </nav>
    </div>
        </section>

<main class="projectspace-main">
  <section id="projectspace-present" class="projectspace-present">
  <?php foreach ($page->currentexhibitions()->toStructure() as $exhibition): ?>
    <div class="projectspace-slider">
      <div class="slides-wrapper">
          <!-- Slide 1: Title, Artist, Date -->
          <div class="slide">
            <?php 
              $start = $exhibition->start_date()->isNotEmpty() ? $exhibition->start_date()->toDate() : null;
              $end = $exhibition->end_date()->isNotEmpty() ? $exhibition->end_date()->toDate() : null;
            ?>
            <?php if ($start): ?>
              <p class="projectspace-date">
                <?php
              $startDay = date('d', $start);
              $startMonth = date('M', $start);
              $startYear = date('Y', $start);
              if ($end) {
                $endDay = date('d', $end);
                $endMonth = date('M', $end);
                $endYear = date('Y', $end);
                if ($startMonth === $endMonth && $startYear === $endYear) {
                  // Only show day for start, full for end
                  echo $startDay;
                } else {
                  // Show full start date
                  echo date('d M Y', $start);
                }
                echo ' – ' . date('d M Y', $end);
              } else {
                // No end date, show full start date
                echo date('d M Y', $start);
              }
                ?>
              </p>
            <?php endif ?>
              </p>
            <div class="projectspace-window-front">
              <h1 class="projectspace-title"><?= $exhibition->title()->esc() ?></h1>
              <p class="projectspace-artist"><?= $exhibition->artist()->esc() ?></p>
            </div>
          </div>

            <!-- Description Slide -->
          <div class="slide">
            <div class="description">
              <?= $exhibition->description()->kirbytext() ?>
            </div>
          </div> 

          <!-- Image Slide -->
          <?php foreach ($exhibition->image()->toFiles() as $img): ?>
            <div class="slide">
              <img src="<?= $img->url() ?>" alt="Image for <?= $exhibition->title()->esc() ?>" />
            </div>
          <?php endforeach ?>
      </div>
      <!-- Navigation Arrows (moved outside of .slides-wrapper) -->
      <div class="click-zone left-zone"></div>
      <div class="click-zone right-zone"></div> 
    </div>
  <?php endforeach ?>
</section>

  <section id="about-projectspace">
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
    <!-- <?php if ($image = $page->content()->get('image')->toFile()): ?>
       <img src="<?= $image->url() ?>" alt="Project Space Image">
    <?php endif ?>  -->
  </section>

  <section id="archive-projectspace">
    <p>Coming soon</p>
</section>

<?php snippet('footer') ?>
