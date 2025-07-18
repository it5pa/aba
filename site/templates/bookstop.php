<!DOCTYPE html>
<html lang="en">
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
<body>
  <div class="header">
  <div class="header-space-inner">
    <!-- Toggle Button -->
    <button class="menu-toggle" aria-label="Toggle menu"></button> 
    <!-- Logo -->
    <!-- <a href="https://airberlinalexanderplatz.de/" target="blank"><img src="<?= url('assets/icons/aba-web.svg') ?>" alt="ABA Logo" class="logo">
    </a> -->
  </div>
    <nav class="menu">
      <?php foreach ($site->children()->listed() as $item): ?>
        <a <?php e($item->isOpen(), 'aria-current="page"') ?> href="<?= $item->url() ?>"><?= $item->title()->esc() ?></a>
      <?php endforeach ?>
    </nav>
</div>
  <main class="main">
  </main>
<?php snippet('footer') ?>
