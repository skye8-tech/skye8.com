<!DOCTYPE html>
<html lang="ru">
<head>
    <title>{title}</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" type="text/css" href="/admin/public/css/styles.min.css"/>
    <link rel="icon" type="image/x-icon" href="/admin/public/img/favicon.ico" >
    <script type="text/javascript" src="/admin/public/js/library.min.js"></script>
    <script type="text/javascript" src="/install/scripts/application.min.js"></script>
    <style>

    </style>
</head>
<body>
<nav class="navbar navbar-fixed-top navbar-inverse">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">Install HammerBlog CMS</a>
        </div>
    </div>
</nav>
<div class="container-fluid">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 main" id="content-outer">
            {content}
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
        init();
    });
</script>
</body>
</html>
