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
$aTrForWorkers = [
    null => 'Свободен',
    1 => 'Занят'
];
?>
<div class="container my-5">
    <h1 class="mt-5 mb-3 text-center">Заявки</h1>
    <div class="container">
        <ul class="nav nav-tabs justify-content-center mb-3 text-light p-3 rounded">
            <li class="nav-item">
                <a class="nav-link active" id="open-tab" data-toggle="tab" href="#open-requests"  color: #000000;">Открытые заявки</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="my-tab" data-toggle="tab" href="#my-requests" color: #000000;">Мой заявки</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="closed-tab" data-toggle="tab" href="#closed-requests" color: #000000;">Закрытые заявки</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="users-tab" data-toggle="tab" href="#users" color: #000000;">Создать Пользователя</a>
            </li>
        </ul>
    </div>

    <div class="tab-content container">
        <div class="tab-pane fade show active align-items-center" id="open-requests">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID заявки</th>
                    <th>Дата создания</th>
                    <th>ФИО</th>
                    <th>Тип заявки</th>
                    <th>Описание заявки</th>
                    <th>Статус заявки</th>
                    <th>Назначить бригаду</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody id="all-request-table-body">
                <? foreach ($aData['all']['data'] as $aVal) {?>
                    <tr>
                        <td> <?= $aVal['request_id']?> </td>
                        <td> <?= $aVal['date']?> </td>
                        <td> <?= $aVal['client_name']?> </td>
                        <td> <?= $aTrForRequest[$aVal['request_type_id']]?> </td>
                        <td> <?= $aVal['description']?> </td>
                        <td> <?= $aTrForStatus[$aVal['status_id']]?> </td>
                        <td>
                            <div class="form-group">
                                <select id="workers_<?=$aVal['request_id']?>" class="form-control" id="assign-dropdown-1">
                                    <option value="" selected="selected">Выбрать бригаду</option>
                                    <? foreach ($aData['workers'] as $aVal) {?>
                                        <option value="<?=$aVal['id']?>"><?= $aVal['fullname'] . ' (' . $aTrForWorkers[$aVal['worker_status']] . ')' ?></option>
                                    <? } ?>
                                </select>
                            </div>
                        </td>
                        <td>
                            <div style="text-align:center;">
                                <button type="button" class="btn btn-primary ml-auto center br+2" onclick="assignWorker(this);">Назначить</button>
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
                            <span>Текущая страница: <span id="currentPageAll"><?=$aData['all']['page']?></span></span>
                        </div>
                    </li>
                    <li class="page-item">
                        <button id="prevAll" class="page-link"  href="#" aria-label="previous">
                            <span aria-hidden="true">&laquo;</span>
                        </button>
                    </li>
                    <li class="page-item">
                        <button id="nextAll" class="page-link" href="#" aria-label="next">
                            <span aria-hidden="true">&raquo;</span>
                        </button>
                    </li>
                </ul>
            </nav>
        </div>

        <div class="tab-pane fade align-items-center" id="my-requests">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID заявки</th>
                    <th>Дата создания</th>
                    <th>ФИО</th>
                    <th>Тип заявки</th>
                    <th>Описание заявки</th>
                    <th>Статус заявки</th>
                    <th>Бригада</th>
                    <th>Действие</th>
                </tr>
                </thead>
                <tbody id="my-request-table-body">
                <? foreach ($aData['myActive']['data'] as $aVal) {?>
                    <tr>
                        <td> <?= $aVal['request_id']?> </td>
                        <td> <?= $aVal['date']?> </td>
                        <td> <?= $aVal['client_name']?> </td>
                        <td> <?= $aTrForRequest[$aVal['request_type_id']]?> </td>
                        <td> <?= $aVal['description']?> </td>
                        <td> <?= $aTrForStatus[$aVal['status_id']]?> </td>
                        <td> <?= $aVal['worker_name']?></td>
                        <td>
                            <div style="text-align:center;">
                                <button type="button" class="btn btn-primary ml-auto center br+2" onclick="closeOperator(this)">Закрыть</button>
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

        <div class="tab-pane fade align-items-center" id="closed-requests">
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID заявки</th>
                    <th>Дата завершения</th>
                    <th>ФИО</th>
                    <th>Тип заявки</th>
                    <th>Описание заявки</th>
                    <th>Статус заявки</th>
                    <th>Бригада</th>
                </tr>
                </thead>
                <tbody id="close-request-table-body">
                <? foreach ($aData['myClosed']['data'] as $aVal) {?>
                    <tr>
                        <td> <?= $aVal['request_id']?> </td>
                        <td> <?= $aVal['close_date']?> </td>
                        <td> <?= $aVal['client_name']?> </td>
                        <td> <?= $aTrForRequest[$aVal['request_type_id']]?> </td>
                        <td> <?= $aVal['description']?> </td>
                        <td> <?= $aTrForStatus[$aVal['status_id']]?> </td>
                        <td> <?= $aVal['worker_name']?></td>
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
        <div class="tab-pane fade align-items-center" id="users">
            <form id="Request" action="/user/createUser" method="post">
                <div class="form-group">
                    <label for="fullname">ФИО</label>
                    <input type="text" id="fullname" name="fullname" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="password">Пароль</label>
                    <input type="password" id="password" name="password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="type">Роль пользователь</label>
                    <select id="type" class="form-control" required>
                        <option value="3" selected="selected">Роль Пользователя</option>
                        <option value="1">Оператор</option>
                        <option value="2">Бригадир</option>
                    </select>
                </div>
                <div class="form-group">

                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary">Создать пользователя</button>
                </div>
                <div id="errorReg" style="text-align:center;color:red; display: none"></div>
                <div id="successReg" style="text-align:center;color:green; display: none"></div>
            </form>
        </div>
    </div>
</div>

<script>

    $('#Request').submit(function(e){
        e.preventDefault();
        $.ajax({
            url: '/user/createUser',
            type: 'post',
            data:{fullname:$('#fullname').val(), email:$('#email').val(), pwd:$('#password').val(), role_id:$('#type').val()},
            async: false,
            success:function(data){
                if (data == '1') {
                    $('#errorReg').hide();
                    $('#successReg').html('Пользователь успешно зарегистрирован!')
                    $('#successReg').show();
                }
                else {
                    $('#successReg').hide();
                    $('#errorReg').html(data);
                    $('#errorReg').show();
                }
            }
        });
    });

    function assignWorker(o){
        var requestId = parseInt($(o).parent().parent().parent().children().eq(0).html().trim());
        if ($('#workers_' + requestId).val().length) {
            $.ajax({
                url: '/work/assignWorker',
                type: 'get',
                async: false,
                data: {worker_id:$('#workers_' + requestId).val(), request_id:requestId},
                success:function(){
                    setTimeout(() => {
                        loadMyPage(currentPageMy);
                        $('#my-tab').click();
                    }, 3000);
                }
            });
        }
        else {
            alert('Выберите бригаду!');
        }
    }

    function closeOperator(o){
        $.ajax({
            url: '/work/closeOperator',
            type: 'get',
            async: false,
            data: {request_id:$(o).parent().parent().parent().children().eq(0).html()},
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
    var currentPageAll = <?= $aData['all']['page']?>;
    var currentPageMy = <?= $aData['myActive']['page']?>;
    var currentPageClose = <?= $aData['myClosed']['page']?>;

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

    function handleNextButtonClickAll() {
        currentPageAll = parseInt(currentPageAll) + 1;
        $('#currentPageAll').html(currentPageAll);
        loadAllPage(currentPageAll);
    }

    function handlePrevButtonClickAll() {
        var nextPage = parseInt(currentPageAll) - 1;
        if (nextPage < 1)
            nextPage = 1;
        currentPageAll = nextPage;
        $('#currentPageAll').html(currentPageAll);
        loadAllPage(currentPageAll);
    }

    function loadClosePage(iPage){
        $.ajax({
            url: '/work/adminServices',
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
                        + '<td>' + aObj.date + '</td>'
                        + '<td>' + aObj.client_name + '</td>'
                        + '<td>' + aTrForRequest[aObj["request_type_id"]] + '</td>'
                        + '<td>' + aObj.description + '</td>'
                        + '<td>' + aTrForStatus[aObj["status_id"]] + '</td>'
                        + '<td>' + aObj.worker_name + '</td>'
                        +'</tr>';
                    $('#close-request-table-body').append(x);
                }
            }
        });

    }

    function loadMyPage(iPage){
        $.ajax({
            url: '/work/adminServices',
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
                        + '<td>' + aObj.date + '</td>'
                        + '<td>' + aObj.client_name + '</td>'
                        + '<td>' + aTrForRequest[aObj["request_type_id"]] + '</td>'
                        + '<td>' + aObj.description + '</td>'
                        + '<td>' + aTrForStatus[aObj["status_id"]] + '</td>'
                        + '<td>' + aObj.worker_name + '</td>';
                    x += '<td>'
                        +'<div style="text-align:center;">'
                        + '<button type="button" class="btn btn-primary ml-auto center br+2" onclick="closeOperator(this)">Close</button>'
                        +' </div>'
                        + '</td>'
                        +'</tr>';
                    $('#my-request-table-body').append(x);
                }
            }
        });

    }

    function loadAllPage(iPage){
        $.ajax({
            url: '/work/adminServices',
            type: 'get',
            data: {type:'all', part:1, page:iPage},
            async: false,
            success:function(data){
                data = JSON.parse(data);
                $('#all-request-table-body').empty();
                for (let i = 0; i < data.all.data.length; i++) {

                    let aObj = data.all.data[i];
                    var x = '<tr>'
                        + '<td>' + aObj.request_id + '</td>'
                        + '<td>' + aObj.date + '</td>'
                        + '<td>' + aObj.client_name + '</td>'
                        + '<td>' + aTrForRequest[aObj["request_type_id"]] + '</td>'
                        + '<td>' + aObj.description + '</td>'
                        + '<td>' + aTrForStatus[aObj["status_id"]] + '</td>'
                        + '<td>'
                        + '<div class="form-group">'
                        + '<select id="workers_' + aObj.request_id + '" class="form-control" id="assign-dropdown-1">'
                        + '<option value="" selected="selected">Select a worker</option>';
                    for (let j = 0; j < data.workers.length; j++) {
                        x += '<option value="' + data["workers"][j]["id"] + '">' +  data["workers"][j]["fullname"] + ' (' + aTrForWorkers[data["workers"][j]["worker_status"]] + ')</option>';
                    }
                    x += '</select>'
                        + '</div>'
                        + '</td>';
                    x += '<td>'
                        +'<div style="text-align:center;">'
                        + '<button type="button" class="btn btn-primary ml-auto center br+2" onclick="assignWorker(this)">Assign</button>'
                        +' </div>'
                        + '</td>'
                        +'</tr>';
                    $('#all-request-table-body').append(x);
                }
            }
        });
    }

    $('#nextAll').click(handleNextButtonClickAll);
    $('#prevAll').click(handlePrevButtonClickAll);

    $('#nextMy').click(handleNextButtonClickMy);
    $('#prevMy').click(handlePrevButtonClickMy);

    $('#nextClose').click(handleNextButtonClickClose);
    $('#prevClose').click(handlePrevButtonClickClose);
</script>

<?php require_once WWW_PATH . '/system/view/footer.php'; ?>
</body>
</html>