<html lang="en">
<? require_once WWW_PATH . '/system/view/headers.php'; ?>

<body>
<? require_once WWW_PATH . '/user/view/login.php'?>
<? require_once WWW_PATH . '/system/view/navbar.php'; ?>

<?
$aTrForRequest = [
    1 => 'Вывезти мусор',
    2 => 'Установить экобокс',
    3 => 'Демонтировать экобокс'
];
$aTrForStatus = [
    1 => 'Новая заявка',
    2 => 'На расмотрении',
    3 => 'В ходе выполнения',
    4 => 'Отказано (Бригада)',
    5 => 'Сдано (Бригада)',
    6 => 'Не принято (Клиент)',
    7 => 'Принято (Клиент)',
    8 => 'Закрыто (Оператор)',
];
?>

<div class="container my-5">
    <h1 class="mt-5 mb-3 text-center">Заявки</h1>
    <div class="container">
        <ul class="nav nav-tabs justify-content-center mb-3 text-light p-3 rounded">
            <li class="nav-item">
                <a class="nav-link active" id="my-tab" data-toggle="tab" href="#my-requests" color: #000000;">Мой заявки</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="closed-tab" data-toggle="tab" href="#closed-requests" color: #000000;">Закрытые заявки</a>
            </li>
        </ul>
    </div>

    <div class="tab-content container">
        <div class="tab-pane fade show active align-items-center mb-2" id="my-requests">
            <table class="table table-bordered">
                <thead>
                <tr>

                    <th>ID заявки</th>
                    <th>ФИО</th>
                    <th>Тип заявки</th>
                    <th>Описание заявки</th>
                    <th>Дата создания</th>
                    <th>Статус</th>
                    <th>Выбор действия</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody id="my-request-table-body">
                <? foreach ($aData['myActive']['data'] as $aVal) { ?>
                    <tr>
                        <td> <?= $aVal['request_id'] ?> </td>
                        <td> <?= $aVal['client_name'] ?> </td>
                        <td> <?= $aTrForRequest[$aVal['request_type_id']] ?> </td>
                        <td> <?= $aVal['description'] ?> </td>
                        <td> <?= $aVal['date'] ?> </td>
                        <td> <?= $aTrForStatus[$aVal['status_id']] ?> </td>
                        <td>
                            <? if ($aVal['status_id'] == 2) { ?>
                                <div class="form-group">
                                    <select class="form-control" id="assign-dropdown_<?=$aVal['request_id']?>">
                                        <option value="" selected="selected">Выбрать</option>
                                        <option value="accept">Принять</option>
                                        <option value="reject">Отклонить</option>
                                    </select>
                                </div>
                            <? } else if ($aVal['status_id'] == 3) {?>
                                <div class="form-group">
                                    <select class="form-control" id="assign-dropdown_<?=$aVal['request_id']?>">
                                        <option value="close" selected="selected">Завершить</option>
                                    </select>
                                </div>
                            <? } ?>
                        </td>
                        <td>
                            <div style="text-align:center;">
                                <button type="button" class="btn btn-primary ml-auto center br+2" onclick="takeAction(this)">Action</button>
                            </div>
                        </td>

                    </tr>
                <? } ?>
                </tbody>
            </table>
            <nav aria-label="page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <div class="page-link">
                            <span>Текущая страница: <span id="currentPageMy"><?=$aData['myActive']['page']?></span></span>
                        </div>
                    </li>
                    <li class="page-item">
                        <button id="prevMy" class="page-link"  href="#" aria-label="previous">
                            <span aria-hidden="true">&laquo;</span>
                        </button>
                    </li>
                    <li class="page-item">
                        <button id="nextMy" class="page-link" href="#" aria-label="next">
                            <span aria-hidden="true">&raquo;</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>

        <script>
            var currentPageMy = <?= $aData['myActive']['page']?>;
            function takeAction(o) {
                iRequestId = parseInt($(o).parent().parent().parent().children().eq(0).html().trim());
                sType = $('#assign-dropdown_' + iRequestId).val();
                $.ajax({
                    url: '/work/closeWorker',
                    type: 'get',
                    async: false,
                    data: {request_id:iRequestId, type:sType},
                    success:function(data){
                        if (data == '1') {
                            setTimeout(() => {
                                loadMyPage(currentPageMy);
                            }, 3000);
                        }
                        else {
                            alert(data);
                        }
                    }
                });
            }

            var aTrForRequest = {
                1 : 'Вывезти мусор',
                2 : 'Установить экобокс',
                3 : 'Демонтировать экобокс'
            };

            var aTrForStatus = {
                1 : 'Новая заявка',
                2 : 'На расмотрении',
                3 : 'В ходе выполнения',
                4 : 'Отказано (Бригада)',
                5 : 'Сдано (Бригада)',
                6 : 'Не принято (Клиент)',
                7 : 'Принято (Клиент)',
                8 : 'Закрыто (Оператор)',
            };

            var aTrForWorkers = {
                null : 'Свободен',
                1 : 'Занят'
            };


            function loadMyPage(iPage){
                $.ajax({
                    url: '/work/workerServices',
                    type: 'get',
                    data: {type:'myActive', part:1, page:iPage},
                    async: false,
                    success:function(data){
                        data = JSON.parse(data);
                        $('#my-request-table-body').empty();
                        for (let i = 0; i < data.myActive.data.length; i++) {

                            let aObj = data.myActive.data[i];
                            var x = '<tr>'
                                + '<td>' + aObj.request_id + '</td>'
                                + '<td>' + aObj.client_name + '</td>'
                                + '<td>' + aTrForRequest[aObj["request_type_id"]] + '</td>'
                                + '<td>' + aObj.description + '</td>'
                                + '<td>' + aObj.date + '</td>'
                                + '<td>' + aTrForStatus[aObj["status_id"]] + '</td>';
                            x += '<td>';
                            if (aObj["status_id"] == 2) {
                                x += '<div class="form-group">'
                                    + '<select class="form-control" id="assign-dropdown_"' + aObj.request_id + '>'
                                    + '<option value="" selected="selected">Выбрать</option>'
                                    + '<option value="accept">Принять</option>'
                                    + '<option value="reject">Отклонить</option>'
                                    + '</select>'
                                    +' </div>';
                            }
                            else if (aObj["status_id"] == 3) {
                                x+= '<div class="form-group">'
                                    + '<select class="form-control" id="assign-dropdown_"' + aObj.request_id + '>'
                                    + '<option value="close" selected="selected">Завершить</option>'
                                    + '</select>'
                                    + '</div>';
                            }
                            x += '</td>';
                            $('#my-request-table-body').append(x);
                        }
                    }
                });

            }

            function handleNextButtonClickMy() {
                currentPageMy = parseInt(currentPageMy) + 1;
                $('#currentPageMy').html(currentPageMy);
                loadMyPage(currentPageMy);
            }

            function handlePrevButtonClickMy() {
                var nextPage = parseInt(currentPageMy) - 1;
                if (nextPage < 1)
                    nextPage = 1;
                currentPageMy = nextPage;
                $('#currentPageMy').html(currentPageMy);
                loadMyPage(currentPageMy);
            }

            $('#nextMy').click(handleNextButtonClickMy);
            $('#prevMy').click(handlePrevButtonClickMy);

        </script>

        <div class="tab-pane fade align-items-center" id="closed-requests">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID заявки</th>
                    <th>ФИО</th>
                    <th>Тип заявки</th>
                    <th>Описание заявки</th>
                    <th>Дата создания</th>
                    <th>Дата завершения</th>
                    <th>Бригады</th>
                    <th>Статус заявки</th>
                </tr>
                </thead>
                <tbody id="close-request-table-body">
                <? foreach ($aData['myClosed']['data'] as $aVal) { ?>
                    <tr>
                        <td> <?= $aVal['request_id'] ?> </td>
                        <td> <?= $aVal['client_name'] ?> </td>
                        <td> <?= $aTrForRequest[$aVal['request_type_id']] ?> </td>
                        <td> <?= $aVal['description'] ?> </td>
                        <td> <?= $aVal['date'] ?> </td>
                        <td> <?= $aVal['close_date'] ?? '-' ?> </td>
                        <td> <?= $aVal['worker_name'] ?> </td>
                        <td> <?= $aTrForStatus[$aVal['status_id']] ?>  </td>

                    </tr>
                <? } ?>
                </tbody>
            </table>

            <nav aria-label="page navigation">
                <ul class="pagination justify-content-center">
                    <li class="page-item">
                        <div class="page-link">
                            <span>Текущая страница: <span id="currentPageClose"><?=$aData['myClosed']['page']?></span></span>
                        </div>
                    </li>
                    <li class="page-item">
                        <button id="prevClose" class="page-link"  href="#" aria-label="previous">
                            <span aria-hidden="true">&laquo;</span>
                        </button>
                    </li>
                    <li class="page-item">
                        <button id="nextClose" class="page-link" href="#" aria-label="next">
                            <span aria-hidden="true">&raquo;</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>
        <script>
            var currentPageClose = <?= $aData['myClosed']['page']?>;

            function loadClosePage(iPage){
                $.ajax({
                    url: '/work/workerServices',
                    type: 'get',
                    data: {type:'myClosed', part:1, page:iPage},
                    async: false,
                    success:function(data){
                        data = JSON.parse(data);
                        $('#close-request-table-body').empty();
                        for (let i = 0; i < data.myClosed.data.length; i++) {

                            let aObj = data.myClosed.data[i];
                            var x = '<tr>'
                                + '<td>' + aObj.request_id + '</td>'
                                + '<td>' + aObj.client_name + '</td>'
                                + '<td>' + aTrForRequest[aObj["request_type_id"]] + '</td>'
                                + '<td>' + aObj.description + '</td>'
                                + '<td>' + aObj.date + '</td>'
                                + '<td>' + (aObj.close_date != null ? aObj.close_date : '-') + '</td>'
                                + '<td>' + aObj.worker_name + '</td>'
                                + '<td>' + aTrForStatus[aObj["status_id"]] + '</td>'
                                +'</tr>';
                            $('#close-request-table-body').append(x);
                        }
                    }
                });

            }

            function handleNextButtonClickClose() {
                currentPageClose = parseInt(currentPageClose) + 1;
                $('#currentPageClose').html(currentPageClose);
                loadClosePage(currentPageClose);
            }

            function handlePrevButtonClickClose() {
                var nextPage = parseInt(currentPageClose) - 1;
                if (nextPage < 1)
                    nextPage = 1;
                currentPageClose = nextPage;
                $('#currentPageClose').html(currentPageClose);
                loadClosePage(currentPageClose);
            }

            $('#nextClose').click(handleNextButtonClickClose);
            $('#prevClose').click(handlePrevButtonClickClose);
        </script>
    </div>
</div>


<?php require_once WWW_PATH . '/system/view/footer.php'; ?>
</body>
</html>