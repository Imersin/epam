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
                <a class="nav-link active" id="open-tab" data-toggle="tab" href="#open-requests"  color: #000000;">Создать заявку</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="my-tab" data-toggle="tab" href="#my-requests" color: #000000;">Мои заявки</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="closed-tab" data-toggle="tab" href="#closed-requests" color: #000000;">Закрытые заявки</a>
            </li>
        </ul>
    </div>

    <div class="tab-content container">
        <div class="tab-pane fade show active" id="open-requests">
            <form id="Request">
                <div class="form-group">
                    <label for="type">Тип:</label>
                    <select id="type" class="form-control" required>
                        <option value="" selected="selected">Выбрать тип</option>
                        <option value="2">Установить экобокс</option>
                        <option value="3">Демонтировать экобокс</option>
                        <option value="1">Вывезти мусор</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="comment">Комментарий:</label>
                    <textarea id="comment" class="form-control"></textarea>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Создать заявку</button>
                </div>
                <div id="errorCl" style="text-align:center;color:red; display: none"></div>
                <div id="successCl" style="text-align:center;color:green; display: none"></div>
            </form>
        </div>

        <script>
            $('#Request').submit(function(e){
                e.preventDefault();
                $.ajax({
                    url: '/work/createRequest',
                    type: 'get',
                    data:{data: JSON.stringify({request_type_id: $('#type').val(), description: $('#comment').val()})},
                    async: false,
                    success:function(data){
                        if (data == '1') {
                            $('#errorCl').hide();
                            $('#successCl').html('Заявка успешно создана!')
                            $('#successCl').show();
                        } else {
                            $('#successCl').hide();
                            $('#errorCl').html(data);
                            $('#errorCl').show();
                        }
                        $('#type').val('');
                        $('#comment').val('');
                    }
                });
            });
        </script>
        <div class="tab-pane fade" id="my-requests">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Тип</th>
                    <th>Комментарий</th>
                    <th>Дата создания</th>
                    <th>Дата завершения</th>
                    <th>Статус</th>
                    <th>Оператор</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody id="open">
                    <? foreach ($aData['myActive']['data'] as $aVal) { ?>
                        <tr>
                            <td style="display: none"> <?= $aVal['request_id'] ?> </td>
                            <td> <?= $aTrForRequest[$aVal['request_type_id']] ?> </td>
                            <td> <?= $aVal['description'] ?> </td>
                            <td> <?= $aVal['date'] ?> </td>
                            <td> <?= $aVal['close_date'] ?? '-' ?> </td>
                            <td> <?= $aTrForStatus[$aVal['status_id']] ?> </td>
                            <td> <?= $aVal['operator'] ?> </td>
                            <td>
                                <? if ($aVal['status_id'] == 5){ ?>
                                    <div style="text-align:center;">
                                        <button type="button" class="btn btn-primary ml-auto center br+2" onclick="closeClient(this)">Accept</button>
                                        <button type="button" class="btn btn-primary ml-auto center br+2" onclick="closeClient(this, 'deny')">Deny</button>
                                    </div>
                                <? } ?>
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

            function closeClient(o, action = 'accept') {
                $.ajax({
                    url: '/work/closeClient',
                    type: 'get',
                    async: false,
                    data: {request_id:$(o).parent().parent().parent().children().eq(0).html(), type:action},
                    success:function(data){
                        if (data == '1') {
                            setTimeout(() => {
                                loadClosePage(currentPageClose);
                                $('#closed-tab').click();
                            }, 3000);
                        }
                        else {
                            alert(data);
                        }
                    }
                });
            }

            function loadMyPage(iPage){
                $.ajax({
                    url: '/work/clientServices',
                    type: 'get',
                    data: {type:'myActive', part:1, page:iPage},
                    async: false,
                    success:function(data){
                        data = JSON.parse(data);
                        $('#open').empty();
                        for (let i = 0; i < data.myActive.data.length; i++) {

                            let aObj = data.myActive.data[i];
                            var x = '<tr>'
                                + '<td>' + aTrForRequest[aObj["request_type_id"]] + '</td>'
                                + '<td>' + aObj.description + '</td>'
                                + '<td>' + aObj.date + '</td>'
                                + '<td>' + (aObj.close_date != null ? aObj.close_date : '-') + '</td>'
                                + '<td>' + aTrForStatus[aObj["status_id"]] + '</td>'
                                + '<td>' + aObj.operator + '</td>'
                                +'</tr>';
                            $('#open').append(x);
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
        <div class="tab-pane fade" id="closed-requests">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>Тип</th>
                    <th>Комментарий</th>
                    <th>Дата создания</th>
                    <th>Дата завершения</th>
                    <th>Статус</th>
                    <th>Оператор</th>
                </tr>
                </thead>
                <tbody id="closed">
                    <? foreach ($aData['myClosed']['data'] as $aVal) { ?>
                        <tr>
                            <td> <?= $aTrForRequest[$aVal['request_type_id']] ?> </td>
                            <td> <?= $aVal['description'] ?> </td>
                            <td> <?= $aVal['date'] ?> </td>
                            <td> <?= $aVal['close_date'] ?? '-' ?> </td>
                            <td> <?= $aTrForStatus[$aVal['status_id']] ?> </td>
                            <td> <?= $aVal['operator'] ?> </td>
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
    </div>
    <script>
        var currentPageClose = <?= $aData['myClosed']['page']?>;

        function loadClosePage(iPage){
            $.ajax({
                url: '/work/clientServices',
                type: 'get',
                data: {type:'myClosed', part:1, page:iPage},
                async: false,
                success:function(data){
                    data = JSON.parse(data);
                    $('#closed').empty();
                    for (let i = 0; i < data.myClosed.data.length; i++) {

                        let aObj = data.myClosed.data[i];
                        var x = '<tr>'
                            + '<td>' + aTrForRequest[aObj["request_type_id"]] + '</td>'
                            + '<td>' + aObj.description + '</td>'
                            + '<td>' + aObj.date + '</td>'
                            + '<td>' + (aObj.close_date != null ? aObj.close_date : '-') + '</td>'
                            + '<td>' + aTrForStatus[aObj["status_id"]] + '</td>'
                            + '<td>' + aObj.operator + '</td>'
                            +'</tr>';
                        $('#closed').append(x);
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

<?php require_once WWW_PATH . '/system/view/footer.php'; ?>
</body>
</html>
