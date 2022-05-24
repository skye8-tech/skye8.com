<?php if(!empty($data['entries'])): ?>

    <?php foreach ($data['entries'] as $t): ?>

        <article id="entry-item-<?php echo $t['id'] ?>" class="entry entry-item">

            <h2 class="entry-title">
                <a href="<?php echo getEntryURL($data['urls'], $t) ?>"><?php echo $t['header'] ?></a>
            </h2>

            <div class="entry-meta">

                <?php if(!empty($t['category-data'])): ?>

                    <p class="entry-categories">

                        <?php foreach ($t['category-data'] as $v): ?>
                            <a href="<?php echo $data['category-url-prefix'].urlencode($v['url']) ?>" rel="category tag"><?php echo $v['name'] ?></a>
                        <?php endforeach ?>

                    </p>

                <?php endif ?>

                <?php if(!empty($t['tags-data'])): ?>

                    <p class="entry-tags">

                        <?php foreach ($t['tags-data'] as $v): ?>
                            <a href="<?php echo $data['tag-url-prefix'].urlencode($v['name']) ?>" rel="tag"><?php echo $v['name'] ?></a>
                        <?php endforeach ?>

                    </p>

                <?php endif ?>

                <time class="entry-date" datetime="<?php echo $t['time'] ?>">
                    <?php echo $t['time'] ?>
                </time>

            </div>

            <?php if(!empty($t['elements']['previews'])): ?>

            <?php else: ?>

            <?php endif ?>

            <?php if ($t['elements']['previews'] == 'slider'): ?>

                <?php if($t['elements']['property']['slider-enable']): ?>

                    <?php if(!empty($t['slider'])): ?>

                        <div class="entry-featured">
                            <div class="feature-slider slick-slider">

                                <?php foreach ($t['slider'] as $i): ?>

                                    <div class="slide">
                                        <img src="/files/images/<?php echo $i['image'] ?>" alt=""/>
                                        <div class="slide-overlay">
                                            <div class="slide-content">
                                                <h2 class="slide-title">
                                                    <?php echo $i['title'] ?>
                                                </h2>
                                                <p class="slide-text">
                                                    <?php echo $i['text'] ?>
                                                </p>
                                            </div>
                                        </div>
                                    </div>

                                <?php endforeach ?>

                            </div>
                        </div>

                    <?php endif ?>

                <?php endif ?>

            <?php elseif($t['elements']['previews'] == 'images'): ?>

                <?php if($t['elements']['property']['images-enable']): ?>

                    <?php if(!empty($t['images'])): ?>

                        <?php if(count($t['images']) > 1): ?>

                            <div class="entry-featured">
                                <div class="entry-justified" data-height='150'>

                                    <?php foreach ($t['images'] as $i): ?>

                                        <a href="/files/images/<?php echo $i ?>" class="lightbox">
                                            <img src="/files/images/thumbnail/<?php echo $i ?>" alt=""/>
                                        </a>

                                    <?php endforeach ?>

                                </div>
                            </div>

                        <?php else: ?>

                            <div class="entry-featured">
                                <a href="/files/images/<?php echo $t['images'][0] ?>" class="lightbox">
                                    <img width="690" height="455" src="/files/images/<?php echo $t['images'][0] ?>" alt=""/>
                                </a>
                            </div>

                        <?php endif ?>

                    <?php endif ?>

                <?php endif ?>

            <?php elseif ($t['elements']['previews'] == 'video'): ?>

                <?php if($t['elements']['property']['video-enable']): ?>

                    <?php if(!empty($t['video'])): ?>

                        <?php foreach ($t['video'] as $v): ?>

                            <p><?php echo $v ?></p>

                        <?php endforeach ?>

                    <?php endif ?>

                <?php endif ?>

            <?php endif ?>

            <div class="entry-content">
                <?php echo htmlspecialchars_decode($t['shortentry']) ?>
            </div>

            <div class="entry-utils group">
                <a href="<?php echo getEntryURL($data['urls'], $t) ?>" class="read-more">More</a>
                <ul class="entry-actions">
                    <li>
                        <span class="entry-action entry-bookmark<?php echo in_array($t['id'], $data['bookmark']) ? ' entry-action-active' : '' ?>">
                            <i class="fa fa-bookmark-o" data-toggle="tooltip" data-placement="top" title="Add to bookmarks"></i>
                        </span>
                    </li>
                    <li>
                        <span class="entry-action entry-rating<?php echo in_array($t['id'], $data['updated-ratings']) ? ' entry-action-active' : '' ?>">
                            <i class="fa fa-thumbs-o-up" data-toggle="tooltip" data-placement="top" title="I like"></i>&nbsp;
                            <span class="rating"><?php echo $t['rating'] ?></span>
                        </span>
                    </li>
                    <li>
                        <span class="entry-action">
                            <i class="fa fa-comments-o" data-toggle="tooltip" data-placement="top" title="Comments"></i> <?php echo $t['comments'] ?>
                        </span>
                    </li>
                    <li>
                        <span class="entry-action">
                            <i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Watched"></i> <?php echo $t['views'] ?>
                        </span>
                    </li>
                    <li>
                        <span class="entry-action social-share hidden-xs">
                            <i class="fa fa-vk" data-toggle="tooltip" data-placement="top" title="Share the link on VK"></i>
                        </span>
                    </li>
                    <li>
                        <span class="entry-action social-share hidden-xs">
                            <i class="fa fa-odnoklassniki" data-toggle="tooltip" data-placement="top" title="Share link in OK"></i>
                        </span>
                    </li>
                    <li>
                        <span class="entry-action social-share hidden-xs">
                            <i class="fa fa-facebook" data-toggle="tooltip" data-placement="top" title="Share Facebook Link"></i>
                        </span>
                    </li>
                    <li>
                        <span class="entry-action social-share hidden-xs">
                            <i class="fa fa-twitter" data-toggle="tooltip" data-placement="top" title="Share the link on Twitter"></i>
                        </span>
                    </li>
                    <li>
                        <span class="entry-action social-share hidden-xs">
                            <i class="fa fa-google-plus" data-toggle="tooltip" data-placement="top" title="Share the link in Google Plus"></i>
                        </span>
                    </li>
                </ul>
            </div>
        </article>
    <?php endforeach ?>

<?php else: ?>
    <div class="notice notice-default notice-flat">No entries</div>
<?php endif ?>