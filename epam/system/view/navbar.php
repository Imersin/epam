<!-- Navigation Bar -->
<?
    $isLogged = a($_SESSION, 'user_id', false);
?>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
    <a class="navbar-brand" href="#">ECO BOX</a>

    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" href="/work/home">Домашняя страница</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/work/services">Сервисы</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="/work/about">О нас</a>
            </li>
            <? if (!$isLogged) { ?>
                <li class="nav-item">
                    <a id="loginBtn" class="nav-link" href="#" data-toggle="modal" data-target="#loginModal">Войти</a>
                </li>
            <? } else { ?>
                <li class="nav-item">
                    <a class="nav-link">Здраствуй, <?= $_SESSION['fullname'] ?></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="#" onclick="logout()">Выйти</a>
                </li>
            <? } ?>
        </ul>
    </div>
</nav>

<script>
    function logout(){
        $.ajax({
            url: '/user/logout',
            type: 'post',
            async: false,
            success:function(data){
                window.location.href = "/work/home";
            }
        });
    }
</script>