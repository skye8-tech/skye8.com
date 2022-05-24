<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{title}</title>
    <meta name="keywords" content="{keywords}">
    <meta name="description" content="{description}">
    <link rel="icon" href="{path}/img/favicon.ico">
    <link rel="alternate" type="application/rss+xml" title="RSS" href="/rss"/>
    <link rel='stylesheet' type='text/css' href='{path}/css/styles.min.css' />
</head>
<body>
<div id="page">
    <div id="main-wrap">
        <header id="masthead" class="site-header">
            <div class="site-bar group site-bar-fixed">

                <nav class="nav">
                    {links}
                    <a class="mobile-nav-trigger" href="#mobile-menu"><i class="fa fa-navicon"></i> Menu</a>
                </nav>

                <div id="mobile-menu"></div>

                <div class="site-tools">

                    <ul class="user-tools">
                        <?php if(!empty($data['user'])): ?>
                            <li class="dropdown">
                                <span class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    <span class="user-text">Hi, <?php echo $data['user']['login'] ?>!</span>
                                    <span class="user-icon user-icon-circle fa fa-user-circle-o"></span>
                                    <span class="caret"></span>
                                </span>
                                <ul class="dropdown-menu" role="menu">
                                    <?php if($data['user']['role'] == 0): ?>
                                        <li><a href="/admin">Administration</a></li>
                                    <?php endif ?>
                                    <li><a href="/user">My profile</a></li>
                                    <li><a href="/logout">Log off</a></li>
                                </ul>
                            </li>
                        <?php else: ?>
                            <li><a href="/login"><i class="user-icon fa fa-lock"></i> <span class="user-text">Sign in</span></a></li>
                            <li><a href="/register"><i class="user-icon fa fa-user-plus"></i> <span class="user-text">Sign up</span></a></li>
                        <?php endif ?>
                    </ul>

                    <form action="/search" class="search-form" method="post" role="search">
                        <div>
                            <label class="sr-only">Search</label>
                            <input class="search-box search-input" type="text" placeholder="Search" name="search" value="">
                            <button class="search-submit btn" type="submit">
                                <i class="fa fa-search"></i><span class="sr-only">Search</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <div class="site-logo">
                <a href="/">
                    <img src="{path}/img/logo.png" alt=""/>
                </a>
                <p class="tag-line">Description of the site</p>
            </div>

        </header>

        <div class="container">
            <div class="row">
                <div class="col-md-12">

                    <div id="site-content">

                        <div class="row">
                            <div class="col-md-8">
                                {content}
                            </div>

                            <div class="col-md-4">
                                {sidebar}
                            </div>

                        </div>

                    </div>


                </div>
            </div>
        </div>
        
    </div>

    <footer id="footer" class="footer-fixed">

        <div class="site-logo">
            <a href="/">
                <img src="{path}/img/logo-footer.png" alt=""/>
            </a>
            <p class="tag-line">Description of the site</p>
        </div>

        <div class="site-tools group">
            <form action="/search" class="search-form" method="post">
                <div>
                    <label class="sr-only">Search:</label>
                    <input class="search-box" type="text" placeholder="Search" name="search" value="">
                    <button class="search-submit btn" type="submit">
                        <i class="fa fa-search"></i><span class="sr-only">Search</span>
                    </button>
                </div>
            </form>
            <ul class="socials">
                <li>
                    <span class="social-share">
                        <i class="fa fa-vk" data-toggle="tooltip" data-placement="top" title="Share the link on VK"></i>
                    </span>
                </li>
                <li>
                    <span class="social-share">
                        <i class="fa fa-odnoklassniki" data-toggle="tooltip" data-placement="top" title="Share link in OK"></i>
                    </span>
                </li>
                <li>
                    <span class="social-share">
                        <i class="fa fa-facebook" data-toggle="tooltip" data-placement="top" title="Share Facebook Link"></i>
                    </span>
                </li>
                <li>
                    <span class="social-share">
                        <i class="fa fa-twitter" data-toggle="tooltip" data-placement="top" title="Share the link on Twitter"></i>
                    </span>
                </li>
                <li>
                    <span class="social-share">
                        <i class="fa fa-google-plus" data-toggle="tooltip" data-placement="top" title="Share the link in Google Plus"></i>
                    </span>
                </li>
                <li>
                    <a href="/rss">
                        <i class="fa fa-rss" data-toggle="tooltip" data-placement="top" title="Read RSS"></i>
                    </a>
                </li>
            </ul>
        </div>

        <p class="footer-text">
            The site is run by HammerBlog CMS.
        </p>

    </footer>

</div>

<script type='text/javascript' src='{path}/js/library.min.js'></script>
<script type='text/javascript' src='{path}/js/application.min.js'></script>
<script>
    $(document).ready(function () {
        init();
    });
</script>
</body>
</html>
<!--RT:{runtime} M:{memory}-->