<?php include 'includes/header.php'; ?>
<div class="about-container">
  <div class="about-content">
    <h2 class="about-title">О нас</h2>
    <div class="about-text">
      <p>Центр цифрового образования детей «IT-куб» на базе муниципального автономного общеобразовательного учреждения "Средняя общеобразовательная школа № 22" Находкинского городского округа создан в 2022 году в рамках федерального проекта «Цифровая образовательная среда» национального проекта «Образование». Он призван обеспечить освоение детьми актуальных и востребованных знаний, навыков и компетенций в сфере информационно-телекоммуникационных технологий, а также создание условий для выявления, поддержки и развития у детей способностей и талантов, их профориентации, развития математической, информационной грамотности, формирования критического и креативного мышления.</p>
    </div>
  </div>

  <div class="about-map">
    <h3 class="map-title">Мы находимся здесь</h3>
    <div id="yandex-map" class="yandex-map"></div>
  </div>
</div>
<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=ваш_API_ключ_если_есть" type="text/javascript"></script>
<script>
  ymaps.ready(init);
  function init() {
    var myMap = new ymaps.Map("yandex-map", {
      center: [42.7818, 132.8463], // координаты ул. Юбилейная, 12, Находка
      zoom: 17,
      controls: ["zoomControl", "fullscreenControl", "routeButtonControl"]
    });
    var placemark = new ymaps.Placemark([42.7818, 132.8463], {
      hintContent: 'IT-КУБ • НАХОДКА',
      balloonContent: '<strong>IT-КУБ • НАХОДКА</strong><br>ул. Юбилейная, 12, 3 этаж<br>Тел.: +7 (924) 240-22-87'
    });
    myMap.geoObjects.add(placemark);
  }
</script>
<?php include 'includes/footer.php'; ?>