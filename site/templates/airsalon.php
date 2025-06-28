<?php snippet('header-space') ?>

<section id="airsalonintro" class="airsalonintro">
  <h1 class="air-salon-title"><?= $page->title()->esc() ?></h1> 
  <div class="airsalon-nextup">
    <h2 class="air-salon-headline next">Next up</h2>
  <?php 
  $nextShowId = $page->next_show()->value(); // Get the selected "Next" show ID
  $nextShow = $page->radio_shows()->toStructure()->findBy('id', $nextShowId); // Find the show in the structure
  ?>
  <?php if ($nextShow): ?>
    <h2 class="air-salon-headline">
    <time datetime="<?= $nextShow->air_time()->toDate('c') ?>">
        <?= $nextShow->air_time()->toDate('F j') ?>,16:00–17:00 <!-- Show air time -->
      </time></br></br>
      <span style="font-style:italic">
        <a href="#show-<?= $nextShow->id() ?>" class="next-show-link">
          <?= $nextShow->title()->esc() ?>
        </a>
      </span></br> 
      <span><?= $nextShow->host()->esc() ?></span></br> <!-- Show host -->
    </h2>
  <?php else: ?>
    <h2 class="air-salon-headline">No upcoming shows at the moment – explore the archive.</h2>
  <?php endif; ?>
</div>
  <div class="airsalon-description">
    <h2 class="air-salon-headline"> <?= Str::replace(
            $page->tagline()->kt(),
            '<a ',
            '<a target="_blank" '
          ) ?>
    </h2>
    <h2 class="air-salon-headline">
      <span>88.4 MHz in Berlin</span></br>
      <span>90,7 MHz in Potsdam</span>
    </h2>
    <h2 class="air-salon-headline navigation">
      <a href="#archive">Archive</a></br>
      <a href="#airsalon-about">About</a>
    </h2>
  </div>
</section>

<section id="archive" class="airsalon-archive">
  <!-- Year Navigation Button -->
  <div class="year-navigation">
    <button id="year-toggle-button" class="year-toggle-button">2023</button>
    <ul id="year-list" class="year-list" style="display: none;">
      <?php
      $years = [];
      foreach ($page->radio_shows()->toStructure() as $show) {
        $year = $show->air_time()->toDate('Y');
        if (!in_array($year, $years)) {
          $years[] = $year;
          echo "<li><a href='#year-$year' class='year-link'>$year</a></li>";
        }
      }
      ?>
    </ul>
  </div>

  <ul class="airsalon-list">
    <?php foreach ($page->radio_shows()->toStructure() as $show): ?>
      <?php $year = $show->air_time()->toDate('Y'); ?>
      <li id="year-<?= $year ?>" class="airsalon-item">
        <a href="#" class="airsalon-title" data-toggle="show-<?= $show->id() ?>">
          <div class="airsalon-header">
            <?= $show->title()->esc() ?>
            <span><?= $show->host()->esc() ?></span>
            <time datetime="<?= $show->air_time()->toDate('c') ?>">
              <?= $show->air_time()->toDate('F j') ?>
            </time>
          </div>
        </a>
        <div id="show-<?= $show->id() ?>" class="airsalon-details">
          <div class="airsalon-details-content">
            <div class="airsalon-details-description"><?= $show->description()->kt() ?>
              <?php if ($show->guests()->isNotEmpty()): ?>
                  </br>With: <?= $show->guests()->kt() ?>
              <?php endif; ?>
            </div>  
            <div class="play-button-container">
              <?php if ($show->audio_link()->isNotEmpty()): ?>
                <button class="play-button" data-audio="<?= $show->audio_link()->esc() ?>"></button>
              <?php else: ?>
                <span class="up-next-text"></span>
              <?php endif; ?>
            </div>
          </div>
        </div>
      </li>
    <?php endforeach ?>
  </ul>
</section>

<!-- Global Mixcloud Player -->
<div id="global-mixcloud-player" class="mixcloud-player-container">
  <iframe 
    id="mixcloud-iframe" 
    class="mixcloud-player" 
    width="100%" 
    height="120" 
    src="" 
    frameborder="0" 
    allow="autoplay">
  </iframe>
</div>

<section id="airsalon-about" class="airsalon-about"> 
  <div class="airsalon-about-text">
    <?= $page->about()->kt() ?>
    <a href="#archive">Archive</a>
  </section>
    
<?php snippet('footer') ?>