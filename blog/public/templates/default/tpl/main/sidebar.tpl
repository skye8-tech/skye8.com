<?php function showCategoryList($data, $active, $prefix) { ?>
    <?php foreach($data as $t): ?>
        <li class="<?php echo $t['id'] == $active ? 'selected active' : '' ?>">
            <a href="<?php echo $prefix.urlencode($t['url']) ?>" data-toggle="tooltip" data-placement="top" title="<?php echo $t['name'] ?>"><?php echo $t['name'] ?>
                <sub class="badge pull-right"><?php echo $t['count'] ?></sub>
            </a>
            <?php if(isset($t['children'])): ?>
                <ul class="">
                    <?php showCategoryList($t['children'], $active, $prefix) ?>
                </ul>
            <?php endif ?>
        </li>
    <?php endforeach ?>
<?php } ?>

<div id="sidebar">

    <aside class="widget group">
        <h3 class="widget-title">About the site</h3>
        <div class="widget-about group">
            <p class="widget-about-img">
                <img src="{path}/img/logo-side.png" class="" alt=""/>
            </p>
            <p>HammerBlog CMS is a modern, fast and convenient content management system. This is a great choice for those who want a quality and reliable blog!</p>
        </div>
    </aside>

    <?php if(!empty($data['category'])): ?>
        <aside class="widget group widget-categories">
            <h3 class="widget-title">Categories</h3>
            <div class="category-list">
                <ul>
                    <?php showCategoryList($data['category'], $data['active'], $data['category-url-prefix']) ?>
                </ul>
            </div>
        </aside>
    <?php endif ?>

    <?php if(!empty($data['tags'])): ?>
        <aside class="widget group widget-tags">
            <h3 class="widget-title">Tags</h3>
            <div class="tags-links">
                <?php foreach ($data['tags'] as $t): ?>
                    <a href="<?php echo $data['tag-url-prefix'].urlencode($t['name']) ?>" rel="tag"><?php echo $t['name'] ?></a>
                <?php endforeach ?>
            </div>
        </aside>
    <?php endif ?>

    <aside class="widget group">
        <h3 class="widget-title">Subscribe to updates</h3>
        <div class="widget-newsletter">
            <form id="subscribe-form" action="#" method="post">
                <div class="form-group">
                    <label for="subscribe-email">
                        Messages will come no more than once or twice a month. Each of them will have a link to turn off the newsletter.
                    </label>
                    <input id="subscribe-email" type="email" name="subscribe-email" value="" class="form-control" placeholder="E-mail">
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-custom">Subscribe</button>
                </div>
            </form>
        </div>
    </aside>

    <?php if(!empty($data['news'])): ?>
        <aside class="widget group">
            <h3 class="widget-title">New posts</h3>
            <ul class="widget-posts-list">
                <?php foreach ($data['news'] as $t): ?>
                    <li>
                        <article class="entry post">
                            <div class="entry-meta">
                                <time class="entry-date" datetime="<?php echo $t['time'] ?>">
                                    <?php echo $t['time'] ?>
                                </time>
                            </div>
                            <?php if(!empty($t['images'])): ?>
                                <div class="entry-featured">
                                    <a href="<?php echo getEntryURL($data['urls'], $t) ?>">
                                        <img src="/files/images/thumbnail/<?php echo $t['images'][0] ?>" alt=""/>
                                    </a>
                                </div>
                            <?php endif ?>
                            <h2 class="entry-title">
                                <a href="<?php echo getEntryURL($data['urls'], $t) ?>" rel="bookmark"><?php echo $t['header'] ?></a>
                            </h2>
                        </article>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
    <?php endif ?>

    <?php if(!empty($data['news'])): ?>
        <aside class="widget group">
            <h3 class="widget-title">New posts</h3>
            <ul class="widget-posts-list widget-posts-list-alt">
                <?php foreach ($data['news'] as $t): ?>
                    <li>
                        <article class="entry post">
                            <div class="entry-meta">
                                <time class="entry-date" datetime="<?php echo $t['time'] ?>">
                                    <?php echo $t['time'] ?>
                                </time>
                            </div>
                            <?php if(!empty($t['images'])): ?>
                                <div class="entry-featured">
                                    <a href="<?php echo getEntryURL($data['urls'], $t) ?>">
                                        <img src="/files/images/thumbnail/<?php echo $t['images'][0] ?>" alt=""/>
                                    </a>
                                </div>
                            <?php endif ?>
                            <h2 class="entry-title">
                                <a href="<?php echo getEntryURL($data['urls'], $t) ?>" rel="bookmark"><?php echo $t['header'] ?></a>
                            </h2>
                        </article>
                    </li>
                <?php endforeach; ?>
            </ul>
        </aside>
    <?php endif ?>

    <aside class="widget group">
        <h3 class="widget-title">Share it</h3>
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
        </ul>
    </aside>

</div>