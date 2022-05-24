<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="utf-8">
    <title>Login</title>
    <link rel="icon" href="/admin/public/img/favicon.ico" type="image/x-icon">
    <style>
        html {
            height: 100%;
            background: url(/admin/public/img/tactile.png) repeat center center fixed
        }

        .form-container {
            max-width: 350px;
            background-color: #F7F7F7;
            padding: 20px 25px 30px;
            margin: 50px auto 25px;
            -moz-border-radius: 2px;
            -webkit-border-radius: 2px;
            border-radius: 2px;
            -moz-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
            -webkit-box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3);
            box-shadow: 0 2px 2px rgba(0, 0, 0, 0.3)
        }

        .btn-submit {
            color: #FFF;
            font-weight: 700;
            height: 36px;
            -moz-user-select: none;
            -webkit-user-select: none;
            user-select: none;
            cursor: default;
            background-color: #6891a2;
            font-size: 14px;
            -moz-border-radius: 3px;
            -webkit-border-radius: 3px;
            border-radius: 3px;
            border: none;
            -o-transition: all .218s;
            -moz-transition: all .218s;
            -webkit-transition: all .218s;
            transition: all .218s
        }

        .logo {
            width: 96px;
            height: 96px;
            margin: 0 auto 20px;
            display: block
        }

        .info {
            font-size: 16px;
            font-weight: 700;
            text-align: center;
            margin: 10px;
            color: #e74c3c
        }

        .login-form #login, .login-form #password {
            direction: ltr;
            height: 44px;
            font-size: 16px
        }

        .login-form input[type=password], .login-form input[type=text], .login-form button {
            width: 100%;
            display: block;
            margin-bottom: 10px;
            z-index: 1;
            position: relative;
            -moz-box-sizing: border-box;
            -webkit-box-sizing: border-box;
            box-sizing: border-box
        }

        .form-control {
            display: block;
            width: 100%;
            height: 34px;
            padding: 6px 12px;
            font-size: 14px;
            line-height: 1.42857143;
            color: #555;
            background: #fff none;
            border: 1px solid #ccc;
            border-radius: 4px;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075);
            -webkit-transition: border-color ease-in-out .15s, -webkit-box-shadow ease-in-out .15s;
            -o-transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s;
            transition: border-color ease-in-out .15s, box-shadow ease-in-out .15s
        }

        .login-form .form-control:focus {
            border-color: #6891a2;
            outline: 0;
            -webkit-box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(104, 145, 162, .6);
            box-shadow: inset 0 1px 1px rgba(0, 0, 0, .075), 0 0 8px rgba(104, 145, 162, .6)
        }
    </style>
</head>
<body>
<div class="form-container">
    <img class="logo" src="/admin/public/img/hammer.png"/>
    <p class="info"><?php echo $_GET['fail'] == 'yes' ? 'You entered incorrect data' : '' ?></p>
    <form class="login-form" method="post" action="/admin/">
        <input type="text" id="login" name="login" class="form-control" placeholder="Login" required autofocus>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <button class="btn-submit" type="submit">Login</button>
    </form>
</div>
</body>
</html>