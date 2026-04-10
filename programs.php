<?php include 'includes/header.php'; ?>
<h1 class="section-title">Наши программы</h1>

<div class="programs-grid">
  <?php
  $programs = [
    [
      'title' => 'Alg CUBE',
      'subtitle' => 'Основы алгоритмики и логики (Scratch)',
      'age' => '8–12 лет',
      'desc' => 'Развитие логического мышления, алгоритмов и первых навыков программирования через увлекательные проекты в Scratch. Дети создают свои первые игры и анимации.'
    ],
    [
      'title' => 'Cyber CUBE',
      'subtitle' => 'Кибергигиена и кибербезопасность',
      'age' => '11–14 лет',
      'desc' => 'Как защищать свои данные в интернете, распознавать мошенников, работать с паролями и безопасно пользоваться гаджетами. Практические уроки цифровой гигиены.'
    ],
    [
      'title' => 'Python CUBE',
      'subtitle' => 'Программирование на Python + ИИ',
      'age' => '12–17 лет',
      'desc' => 'Изучение современного языка Python. Создание ботов, простых игр, анализ данных и первые шаги в искусственном интеллекте.'
    ],
    [
      'title' => 'ROBO CUBE',
      'subtitle' => 'Программирование роботов',
      'age' => '10–14 лет',
      'desc' => 'Сборка и программирование роботов на Arduino и LEGO. Учимся управлять механизмами, решать инженерные задачи и соревноваться с роботами.'
    ],
    [
      'title' => 'SYS CUBE',
      'subtitle' => 'Системное администрирование',
      'age' => '12–17 лет',
      'desc' => 'Настройка компьютеров, серверов, сетей и облачных сервисов. Учимся устанавливать ОС, работать с Linux, настраивать безопасность систем.'
    ],
    [
      'title' => 'VR/AR CUBE',
      'subtitle' => 'Виртуальная и дополненная реальность',
      'age' => '11–17 лет',
      'desc' => 'Создание собственных VR/AR-проектов в Unity. Разработка интерактивных миров, 3D-моделей и приложений дополненной реальности.'
    ]
  ];
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