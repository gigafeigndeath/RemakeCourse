<?php include 'includes/header.php'; ?>

<div class="max-w-7xl mx-auto px-4 sm:px-6 py-8 md:py-12">
    <h1 class="section-title text-center md:text-left">Контакты</h1>

    <div class="contact-container grid grid-cols-1 lg:grid-cols-2 gap-8 mt-8">
        
        <!-- Левая колонка: информация -->
        <div class="contact-info">
            <div class="info-card bg-white rounded-2xl shadow-sm p-6 md:p-8">
                <h3 class="block-title text-xl mb-6">Свяжитесь с нами</h3>
                <div class="space-y-5">
                    <p class="contact-item"><strong>Телефон:</strong> <a href="tel:+79242402287" class="hover:text-green-600">+7 (924) 240-22-87</a></p>
                    <p class="contact-item"><strong>Email:</strong> <a href="mailto:itcube25@yandex.ru" class="hover:text-green-600">itcube25@yandex.ru</a></p>
                    <p class="contact-item"><strong>Адрес:</strong> ул. Юбилейная, 12, 3 этаж, г. Находка, Приморский край</p>
                    <p class="contact-item"><strong>Часы работы:</strong> Пн–Пт с 14:00 до 18:00</p>
                </div>
            </div>
        </div>

        <!-- Правая колонка: карта -->
        <div class="contact-map">
            <h3 class="map-title text-xl mb-4">Мы здесь</h3>
            <div id="yandex-map" class="yandex-map rounded-2xl overflow-hidden shadow-sm" style="height: 420px;"></div>
        </div>
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
