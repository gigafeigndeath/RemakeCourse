<?php include 'includes/header.php'; ?>
<div class="max-w-7xl mx-auto px-6 py-12">
  <h1 class="section-title">Контакты</h1>

  <div class="contact-container">
    <!-- Левая колонка: информация + форма -->
    <div class="contact-info">
      <div class="info-card">
        <h3 class="block-title">Свяжитесь с нами</h3>
        <p class="contact-item"><strong>Телефон:</strong> <a href="tel:+79242402287">+7 (924) 240-22-87</a></p>
        <p class="contact-item"><strong>Email:</strong> <a href="mailto:itcube25@yandex.ru">itcube25@yandex.ru</a></p>
        <p class="contact-item"><strong>Адрес:</strong> ул. Юбилейная, 12, 3 этаж, г. Находка, Приморский край</p>
        <p class="contact-item"><strong>Часы работы:</strong> Пн–Пт с 14:00 до 18:00</p>
      </div>
    </div>
    <!-- Правая колонка: карта -->
    <div class="contact-map">
      <h3 class="map-title">Мы здесь</h3>
      <div id="yandex-map" class="yandex-map"></div>
    </div>
  </div>
</div>

<!-- Yandex карта -->
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU" type="text/javascript"></script>
<script>
  ymaps.ready(init);
  function init() {
    var myMap = new ymaps.Map("yandex-map", {
      center: [42.7818, 132.8463],
      zoom: 17
    });
    var placemark = new ymaps.Placemark([42.7818, 132.8463], {
      hintContent: 'IT-КУБ • НАХОДКА',
      balloonContent: '<strong>IT-КУБ • НАХОДКА</strong><br>ул. Юбилейная, 12, 3 этаж'
    });
    myMap.geoObjects.add(placemark);
  }
</script>

<?php include 'includes/footer.php'; ?>