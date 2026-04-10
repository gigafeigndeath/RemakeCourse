<?php include 'includes/header.php'; ?>

<!-- HERO -->
<section class="hero">
    <div class="container">
        <h1 class="hero-title">IT-КУБ • НАХОДКА</h1>
        <p class="hero-subtitle">Бесплатное дополнительное образование в сфере информационных технологий<br>для детей и подростков от 7 до 17 лет</p>
        <a href="programs.php" class="btn btn-primary hero-btn">Выбрать программу</a>
    </div>
</section>




<!-- ====================== НАШИ НАПРАВЛЕНИЯ (КАРТОЧКИ + МОДАЛКА) ====================== -->
<section class="directions-section">
    <div class="container">
        <h2 class="section-title">Наши направления</h2>
        
        <div class="cards-grid" id="directionsGrid">
            <!-- Alg CUBE -->
            <div class="direction-card" data-id="alg">
                <img src="assets/images/alg1.png" alt="Alg CUBE" class="card-icon">
                <h3>Alg CUBE</h3>
                <p class="card-subtitle">Алгоритмы и программирование</p>
            </div>

            <!-- Cyber CUBE -->
            <div class="direction-card" data-id="cyber">
                <img src="assets/images/kuber1.png" alt="Cyber CUBE" class="card-icon">
                <h3>Cyber CUBE</h3>
                <p class="card-subtitle">Кибербезопасность</p>
            </div>

            <!-- Python CUBE -->
            <div class="direction-card" data-id="python">
                <img src="assets/images/photo1.png" alt="Python CUBE" class="card-icon">
                <h3>Python CUBE</h3>
                <p class="card-subtitle">Программирование на Python</p>
            </div>

            <!-- ROBO CUBE -->
            <div class="direction-card" data-id="robo">
                <img src="assets/images/robo.png" alt="ROBO CUBE" class="card-icon">
                <h3>ROBO CUBE</h3>
                <p class="card-subtitle">Робототехника</p>
            </div>

            <!-- SYS CUBE -->
            <div class="direction-card" data-id="sys">
                <img src="assets/images/syst1.png" alt="SYS CUBE" class="card-icon">
                <h3>SYS CUBE</h3>
                <p class="card-subtitle">Системное администрирование</p>
            </div>

            <!-- VR/AR CUBE -->
            <div class="direction-card" data-id="vr">
                <img src="assets/images/vr1.png" alt="VR/AR CUBE" class="card-icon">
                <h3>VR/AR CUBE</h3>
                <p class="card-subtitle">Виртуальная и дополненная реальность</p>
            </div>
        </div>
    </div>
</section>

<!-- МОДАЛЬНОЕ ОКНО -->
<div id="modal" class="modal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeModal()">✕</button>
        <div id="modal-body">
            <!-- JS будет подставлять контент -->
        </div>
    </div>
</div>




<!-- ====================== СОЦСЕТИ И ПАРТНЁРЫ ====================== -->
<h2 class="section-title">Мы в соцсетях и партнёры</h2>

<div class="social-partners-section">
  <!-- Соцсети -->
  <div class="social-networks">
    <h3 class="block-title">Мы в соцсетях</h3>
    <div class="social-links">
      <a href="https://vk.com/itcubenhk" target="_blank" class="social-item">
        <div class="social-icon">VK</div>
        <span class="social-name">ВКонтакте</span>
      </a>
      <!-- Добавляй другие соцсети сюда -->
    </div>
  </div>

  <!-- Партнёры -->
  <div class="partners-block">
    <h3 class="block-title">Наши партнёры</h3>
    <div class="partners-grid">
      <div class="partner-item">
        <img src="assets/partners/federal.png" alt="Федеральный проект" class="partner-logo">
        <span class="partner-name">Федеральный проект</span>
      </div>
      <div class="partner-item">
        <img src="assets/partners/minpros.png" alt="Минпросвещения" class="partner-logo">
        <span class="partner-name">Минпросвещения РФ</span>
      </div>
      <div class="partner-item">
        <img src="assets/partners/nakhodka.png" alt="Администрация Находки" class="partner-logo">
        <span class="partner-name">Администрация г. Находка</span>
      </div>
    </div>
  </div>
</div>
<script>
// Данные направлений
const directions = {
    alg: {
        title: "Alg CUBE — Алгоритмы и программирование",
        age: "7–17 лет",
        text: `<p>Развиваем логическое мышление через алгоритмы, структуры данных и основы программирования. Дети учатся решать задачи, писать код и создавать свои первые программы.</p>
               <p>На занятиях мы используем Scratch, Python и визуальные алгоритмы. Идеально для тех, кто хочет понять, как работает компьютер изнутри.</p>`
    },
    cyber: {
        title: "Cyber CUBE — Кибербезопасность",
        age: "12–17 лет",
        text: `<p>Учим защищать информацию, выявлять уязвимости и противостоять хакерским атакам. Практические занятия по этичному хакированию, шифрованию и сетевой безопасности.</p>`
    },
    python: {
        title: "Python CUBE — Программирование на Python",
        age: "10–17 лет",
        text: `<p>Самый популярный язык программирования в мире. Учим создавать ботов, нейросети, игры и веб-приложения. От первых строк кода до реальных проектов для портфолио.</p>`
    },
    robo: {
        title: "ROBO CUBE — Робототехника",
        age: "9–15 лет",
        text: `<p>Собираем и программируем настоящих роботов. Участие в соревнованиях, работа с Arduino и LEGO SPIKE. Развиваем инженерное мышление и командную работу.</p>`
    },
    sys: {
        title: "SYS CUBE — Системное администрирование",
        age: "13–17 лет",
        text: `<p>Учим настраивать серверы, сети, Linux и Windows. Работа с облачными технологиями, мониторинг и защита инфраструктуры. Подготовка к реальной IT-профессии.</p>`
    },
    vr: {
        title: "VR/AR CUBE — Виртуальная и дополненная реальность",
        age: "11–17 лет",
        text: `<p>Создаём свои миры в Unity и Unreal Engine. Разработка игр, интерактивных приложений и виртуальных экскурсий. Будущее технологий в твоих руках!</p>`
    }
};

function openModal(id) {
    const data = directions[id];
    document.getElementById('modal-body').innerHTML = `
        <h2>${data.title}</h2>
        <p class="age">${data.age}</p>
        ${data.text}
        <button onclick="closeModal()" class="btn btn-primary" style="margin-top:30px;width:100%;padding:16px;">Записаться на направление</button>
    `;
    document.getElementById('modal').style.display = 'flex';
}

function closeModal() {
    document.getElementById('modal').style.display = 'none';
}

// Клик по карточке
document.querySelectorAll('.direction-card').forEach(card => {
    card.addEventListener('click', () => {
        openModal(card.dataset.id);
    });
});
</script>

<?php include 'includes/footer.php'; ?>