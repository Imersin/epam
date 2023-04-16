<!-- Login Modal -->
<div class="modal fade" id="loginModal">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Log In</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div id="for_form" class="modal-body">
                <form id="loginForm" action="/user/login" method="post">
                    <div class="form-group">
                        <label for="email">Email address:</label>
                        <input type="email" class="form-control" name="email">
                    </div>
                    <div class="form-group">
                        <label for="pwd">Password:</label>
                        <input type="password" class="form-control" name="pwd">
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Войти</button>
                    </div>
                </form>
                <script id="scr">
                    $('#loginForm').submit(function(e){
                        e.preventDefault();
                        $.ajax({
                            url: '/user/login',
                            type: 'post',
                            data:$('#loginForm').serialize(),
                            async: false,
                            success:function(data){
                                if (data === '1') {
                                    window.location.href = "/work/services";
                                }
                                else {
                                    $('#error').html('Неверный логин или пароль');
                                    $('#error').show();
                                }
                            }
                        });
                    });
                </script>
                <hr>
                <div id="error" style="text-align:center;color:red; display: none"></div>
                <div class="text-center">
                    <a id="register" onclick="openRegistration()" class="btn btn-link">Register an Account</a>
                    <a id="login" onclick="openLogin()" style="display: none" class="btn btn-link">Войти</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openLogin(){
        $('form').remove();
        $('#scr').remove();
        var s ='<form id="loginForm" action="/user/login" method="post">'
            +'<div class="form-group">'
            + '<label for="email">Email address:</label>'
            + '<input type="email" class="form-control" name="email">'
            + '</div>'
            + '<div class="form-group">'
            + ' <label for="pwd">Password:</label>'
            + ' <input type="password" class="form-control" name="pwd">'
            + '</div>'
            + ' <div class="text-center">'
            + '    <button type="submit" class="btn btn-primary">Войти</button>'
            + '</div>'
            +'</form>'

        s = s +  "<script id='\scr\'>"
            + "$('#loginForm').submit(function(e){"
            +  "e.preventDefault();"
            + "$.ajax({"
            +    "url: '/user/login',"
            +   "type: 'post',"
            +  "data:$('#loginForm').serialize(),"
            +  "async: false,"
            + "success:function(data){"
            +    "if (data === '1') {"
            +       "window.location.href = '/work/services';"
            +  "}"
            + "else {"
            +    "$('#error').html('Неверный логин или пароль');"
            +    "$('#error').show();"
            + "}"
            + "}"
            + "});"
            + "});"
            + "<\/script>"


        $('#for_form').prepend(s);
        $('#login').hide();
        $('#register').show();


    }
    function openRegistration(){
        $('form').remove();
        $('#scr').remove();
        var s = '<form id="RegistrationForm">'
                + '<div class="form-group">'
                    + '<label for="email">Email address:</label>'
                    + '<input type="email" class="form-control" name="email">'
                + '</div>'
                + '<div class="form-group">'
                    + '<label for="pwd">Password:</label>'
                    + '<input type="password" class="form-control" name="pwd">'
                + '</div>'
                + '<div class="form-group">'
                    + '<label for="pwd">Название компании:</label>'
                    + '<input type="text" class="form-control" name="name">'
                + '</div>'
                + '<div class="form-group">'
                    + '<label for="pwd">Адрес компании:</label>'
                    + '<input type="text" class="form-control" name="address">'
                + '</div>'
                + '<div class="form-group">'
                    + '<label for="pwd">Телефон:</label>'
                    + '<input type="text" class="form-control" name="telephone">'
                + '</div>'
                + '<div class="form-group">'
                    + '<label for="pwd">Логин:</label>'
                    + '<input type="text" class="form-control" name="login">'
                + '</div>'
                + '<div class="text-center">'
                    + '<button type="submit" class="btn btn-primary">Зарегистрироваться</button>'
                + '</div>'
            + '</form>';
        s = s + "<script id=\"scr\">$('#RegistrationForm').submit(function(e){"
                + "e.preventDefault();"
                + "$.ajax({"
                + "url: '/user/registration',"
                + "type: 'post',"
                + "data:$('#RegistrationForm').serialize(),"
                + "async: false,"
                + "success:function(data){"
                +    "if (data === '1') {"
                +       "window.location.href = '/work/services';"
                +    "}"
                +    "else {"
                +    "    $('#error').html(data); $('#error').show();"
                +    "}"
                + "}"
            + "});"
        + "}); <\/script>";

        $('#for_form').prepend(s);
        $('#login').show();
        $('#register').hide();
    }
</script>