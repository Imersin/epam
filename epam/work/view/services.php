<html lang="en">
<? require_once WWW_PATH . '/system/view/headers.php'; ?>
<body>
<? require_once WWW_PATH . '/user/view/login.php'?>
<? require_once WWW_PATH . '/system/view/navbar.php'; ?>
<!-- Main Content -->
<div class="container my-5">
    <div style="text-align:center;">
        <h2>Мы предлагаем следующие услуги для утоматизации:</h2>
    </div>
    <div class="row">
        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <img src="/src/_790fc81c-4e3d-4649-a0d5-4a5156d5d434.jfif" class="card-img-top" alt="EcoBox">
                <div style="display: flex; flex-direction: column; justify-content: space-between; height: 100%;" class="card-body">
                    <h2 class="card-title">Монтаж и установка EcoBox</h2>
                    <p class="card-text">Мы производим и устанавливаем EcoBox - экологически чистые контейнеры для раздельного сбора мусора. Контейнеры оборудованы датчиками и GPS-модулями для автоматической отправки заявок на вывоз мусора, что позволяет сократить время и улучшить качество обслуживания.</p>
                    <div style="text-align:center;">
                        <a style="align-self: center; margin-top: auto;" onclick="$('#loginBtn').click()" class="btn btn-primary">Заказать услугу</a>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6 mb-4">
            <div class="card h-100">
                <img src="/src/_8027ce85-7287-476e-9cc2-35ed49710477.jfif" class="card-img-top" alt="Вывоз мусора">
                <div style="display: flex; flex-direction: column; justify-content: space-between; height: 100%;" class="card-body">
                    <h2 class="card-title">Вывоз мусора</h2>
                    <p class="card-text">Мы предлагаем услугу по вывозу мусора из ваших контейнеров. Вывоз осуществляется автоматически при помощи датчиков и GPS-модулей в контейнерах. Вы можете заказать вывоз мусора в любое время через нашу онлайн-форму.</p>
                    <div style="text-align:center;">
                        <a style="align-self: center; margin-top: auto;" onclick="$('#loginBtn').click()" class="btn btn-primary">Заказать услугу</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Тупо переход на страницу Contact US -->
    <div class="row">
        <div class="col-md-12">
            <p class="lead">Мы также предлагаем специальные условия и контракты для предприятий и крупных компаний. Если вы заинтересованы в наших услугах, пожалуйста, свяжитесь с нами для получения дополнительной информации.</p>
        </div>
    </div>
</div>


<?php require_once WWW_PATH . '/system/view/footer.php'; ?>
</body>
</html>
