<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{title}</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="icon" type="image/x-icon" href="/admin/public/img/favicon.ico" >
    <link rel="stylesheet" href="/admin/public/css/styles.min.css?v=0018">
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        <header class="main-header">
            <a href="/admin" class="logo">
                <span class="logo-mini"><b>H</b>B</span>
                <span class="logo-lg"><b>HAMMER</b>BLOG</span>
            </a>
            <nav class="navbar navbar-static-top">
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only"></span>
                </a>
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown notifications-menu">
                            <a href="/admin/formdata/not-viewed">
                                <i class="fa fa-database"></i>
                                <span class="formdata-count-label label label-info hidden"></span>
                            </a>
                        </li>
                        <li class="dropdown messages-menu message-navbar-container">

                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-envelope-o"></i>
                                <span class="messages-count-label label label-warning"></span>
                            </a>

                            <ul class="dropdown-menu">
                                <li class="header">
                                    Private messages
                                </li>

                                <li class="messages-navbar-template hidden">
                                    <a href="#">
                                        <div class="pull-left">
                                            <img src="/admin/public/img/user.png" class="img-circle" alt="">
                                        </div>
                                        <h4>
                                            <span class="messages-navbar-login"></span>
                                            <small>
                                                <i class="fa fa-clock-o" style="font-size: 8px"></i>
                                                <span class="messages-navbar-time"></span>
                                            </small>
                                        </h4>
                                        <p class="messages-navbar-header"></p>
                                    </a>
                                </li>
                                <li>
                                    <ul class="menu messages-navbar-container">

                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="/admin/messages">Read all</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown notifications-menu hidden-xs">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <i class="fa fa-bolt"></i>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="header">Recent activity</li>
                                <li class="actions-navbar-template hidden">
                                    <a href="/admin/users/logs">
                                        <i class="fa fa-bolt text-aqua"></i>
                                        <b class="actions-navbar-login"></b>
                                        <p class="actions-navbar-message"></p>
                                    </a>
                                </li>
                                <li>
                                    <ul class="menu actions-navbar-container hidden">

                                    </ul>
                                </li>
                                <li class="footer">
                                    <a href="/admin/users/logs">Show all</a>
                                </li>
                            </ul>
                        </li>

                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="/admin/public/img/user.png" class="user-image" alt="User Image">
                                <span class="hidden-xs"><?php echo $data['side']['user']['login'] ?></span>
                            </a>
                            <ul class="dropdown-menu">
                                <li class="user-header">
                                    <img src="/admin/public/img/user.png" class="img-circle" alt="User Image">
                                    <p>
                                        <?php echo $data['side']['user']['login'] ?> - Administrator
                                        <small>Registered <?php echo $data['side']['user']['time'] ?></small>
                                    </p>
                                </li>

                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="/admin/users/one/<?php echo $data['side']['user']['id'] ?>" class="btn btn-default btn-flat">Edit</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="/admin/logout" class="btn btn-default btn-flat">Logout</a>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <li>
                            <a href="#" data-toggle="control-sidebar"><i class="fa fa-gears"></i></a>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>

        {sidebar-left}


        <div id="content-wrapper" class="content-wrapper">

            <section class="content-header">
                <h1>
                    {title}
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Panel</a></li>
                    <li class="active">{path}</li>
                </ol>
            </section>

            <section id="content-row" class="content">

                {tools}

                {content}

                <div class="row">
                    <div class="col-md-12">
                        <div class="box box-info direct-chat direct-chat-info">
                            <div class="box-header with-border">
                                <h3 class="box-title">Internal chat</h3>
                                <div class="box-tools pull-right">
                                    <span data-toggle="tooltip" title="Сообщений" class="badge chat-count-badge bg-aqua-gradient"><?php echo $data['chat']['count']?></span>
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                                        <i class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-toggle="tooltip" title="" data-widget="chat-pane-toggle">
                                        <i class="fa fa-comments"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                                        <i class="fa fa-times"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="box-body">

                                <div class="direct-chat-messages chat-message-container" data-user="<?php echo getCookie('user-id') ?>" data-last="<?php echo $data['chat']['last-id']?>">
                                    <?php if(!empty($data['chat']['message'])): ?>
                                        <?php foreach ($data['chat']['message'] as $t): ?>
                                            <div class="direct-chat-msg <?php echo $t['user'] == getCookie('user-id') ? 'right' : '' ?>">
                                                <div class="direct-chat-info clearfix">
                                                    <span class="direct-chat-name pull-left"><?php echo $t['name']?></span>
                                                    <span class="direct-chat-timestamp pull-right"><?php echo $t['time']?></span>
                                                </div>
                                                <img class="direct-chat-img" src="/admin/public/img/user.png" alt="">
                                                <div class="direct-chat-text">
                                                    <?php echo $t['message']?>
                                                </div>
                                            </div>
                                        <?php endforeach ?>
                                    <?php endif ?>
                                    <div class="direct-chat-msg chat-message-template hidden">
                                        <div class="direct-chat-info clearfix">
                                            <span class="direct-chat-name pull-left"></span>
                                            <span class="direct-chat-timestamp pull-right"></span>
                                        </div>
                                        <img class="direct-chat-img" src="/admin/public/img/user.png" alt="">
                                        <div class="direct-chat-text">

                                        </div>
                                    </div>
                                </div>

                                <div class="direct-chat-contacts">
                                    <ul class="contacts-list">
                                        <?php if(!empty($data['side']['users'])): ?>
                                            <?php foreach ($data['side']['users'] as $t): ?>
                                                <li>
                                                    <a href="#">
                                                        <img class="contacts-list-img" src="/admin/public/img/user.png" alt="">
                                                        <div class="contacts-list-info">
                                                            <span class="contacts-list-name">
                                                                <?php echo $t['login']?>
                                                                <small class="contacts-list-date pull-right"><?php echo $t['time']?></small>
                                                            </span>
                                                            <span class="contacts-list-msg"><?php echo $t['name']?></span>
                                                        </div>
                                                    </a>
                                                </li>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </ul>
                                </div>
                            </div>

                            <div class="box-footer">
                                <form id="chat-send-form" class="chat-send-form" action="#" method="post">
                                    <div class="input-group">
                                        <input type="text" name="message" placeholder="Message ..." class="form-control chat-send-input">
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-info btn-flat">Submit</button>
                                        </span>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
        </div>

        <audio id="notify-audio" class="hidden">
            <source src="/admin/public/ogg/notify.ogg" type="audio/ogg">
        </audio>

        <audio id="chat-audio" class="hidden">
            <source src="/admin/public/ogg/chat.ogg" type="audio/ogg">
        </audio>

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>Version</b> 0018
            </div>
            <strong>&copy; <?php echo date('Y') ?> HammerBlog CMS</strong> All rights reserved.
        </footer>

        {sidebar-right}

    </div>
    <script type="text/javascript" src="/admin/public/js/library.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/ace/ace.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/ace/ext-language-tools.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/tools.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/chat.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/report.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/tags.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/users.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/pages.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/content.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/settings.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/formdata.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/messages.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/comments.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/templates.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/category.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/statistics.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/subscriptions.min.js?v=0018"></script>
    <script type="text/javascript" src="/admin/public/js/application.min.js?v=0018"></script>

    <script type="text/javascript">
        $(document).ready(function () {
            init();
        });
    </script>
</body>
</html>