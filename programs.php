<?php include 'includes/header.php'; ?>
<h1 class="section-title">Наши программы</h1>

<div class="programs-grid">
  <?php
  $programs = [ /* тот же массив, что был раньше */ ];
  foreach ($programs as $p) { ?>
    <div class="program-card">
      <div class="program-header"></div>
      <div class="program-content">
        <h3 class="program-title"><?= htmlspecialchars($p['title']) ?></h3>
        <p class="program-subtitle"><?= htmlspecialchars($p['subtitle']) ?></p>
        <span class="program-age"><?= htmlspecialchars($p['age']) ?></span>
        <p class="program-description"><?= htmlspecialchars($p['desc']) ?></p>
        <a href="contacts.php" class="program-button">Записаться на программу</a>
      </div>
    </div>
  <?php } ?>
</div>
<?php include 'includes/footer.php'; ?>