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
