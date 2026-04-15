<?php include 'includes/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 md:py-12">
    <h1 class="section-title text-center md:text-left">О нас</h1>

    <div class="about-content mt-8">
        <div class="prose max-w-none text-gray-700 leading-relaxed">
            <p>Центр цифрового образования детей «IT-куб» на базе муниципального автономного общеобразовательного учреждения "Средняя общеобразовательная школа № 22" Находкинского городского округа создан в 2022 году в рамках федерального проекта «Цифровая образовательная среда» национального проекта «Образование».  Он призван обеспечить освоение детьми актуальных и востребованных знаний, навыков и компетенций в сфере информационно-телекоммуникационных технологий, а также создание условий для выявления, поддержки и развития у детей способностей и талантов, их профориентации, развития математической, информационной грамотности, формирования критического и креативного мышления.</p>
        </div>
    </div>

    <div class="mt-12">
        <h2 class="text-2xl font-semibold mb-6">Мы находимся здесь</h2>
        <div id="yandex-map" class="yandex-map rounded-3xl overflow-hidden shadow-sm" style="height: 420px;"></div>
    </div>
</div>

<!-- Yandex Карта -->
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
