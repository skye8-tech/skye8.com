<main class="single">
    <div class="row">
        <div class="col-md-12">

            <?php if(!empty($data)): ?>

                <article id="entry-item-<?php echo $data['data']['id'] ?>" class="entry entry-item">

                    <h1 class="page-title"><?php echo $data['data']['header'] ?></h1>

                    <div class="entry-meta">

                        <?php if(!empty($data['data']['category-data'])): ?>

                            <p class="entry-categories">
                                <?php foreach ($data['data']['category-data'] as $t): ?>
                                    <a href="<?php echo $data['category-url-prefix'].urlencode($t['url']) ?>" rel="category tag"><?php echo $t['name'] ?></a>
                                <?php endforeach ?>
                            </p>

                        <?php endif ?>

                        <?php if(!empty($data['data']['tags-data'])): ?>

                            <p class="entry-tags">
                                <?php foreach ($data['data']['tags-data'] as $t): ?>
                                    <a href="<?php echo $data['tag-url-prefix'].urlencode($t['name']) ?>" rel="tag"><?php echo $t['name'] ?></a>
                                <?php endforeach ?>
                            </p>

                        <?php endif ?>

                        <time class="entry-date" datetime="<?php echo $data['data']['time'] ?>">
                            <?php echo $data['data']['time'] ?>
                        </time>

                    </div>

                    <?php if(!empty($data['data']['elements']['elements'])): ?>

                        <?php foreach ($data['data']['elements']['elements'] as $e): ?>

                            <?php if ($e == 'slider'): ?>

                                <?php if($data['data']['elements']['property']['slider-enable']): ?>

                                    <?php if(!empty($data['data']['slider'])): ?>

                                        <div class="entry-featured">
                                            <div class="feature-slider slick-slider">

                                                <?php foreach ($data['data']['slider'] as $i): ?>

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

                            <?php elseif($e == 'images'): ?>

                                <?php if($data['data']['elements']['property']['images-enable']): ?>

                                    <?php if(!empty($data['data']['images'])): ?>

                                        <?php if(count($data['data']['images']) > 1): ?>

                                            <div class="entry-featured">
                                                <div class="entry-justified" data-height='150'>
                                                    <?php foreach ($data['data']['images'] as $i): ?>
                                                        <a href="/files/images/<?php echo $i ?>" class="lightbox">
                                                            <img src="/files/images/thumbnail/<?php echo $i ?>" alt=""/>
                                                        </a>
                                                    <?php endforeach ?>
                                                </div>
                                            </div>

                                        <?php else: ?>

                                            <div class="entry-featured">
                                                <a href="/">
                                                    <img width="690" height="455" src="/files/images/<?php echo $data['data']['images'][0] ?>" alt=""/>
                                                </a>
                                            </div>

                                        <?php endif ?>

                                    <?php endif ?>

                                <?php endif ?>

                            <?php elseif ($e == 'video'): ?>

                                <?php if($data['data']['elements']['property']['video-enable']): ?>

                                    <?php if(!empty($data['data']['video'])): ?>

                                        <?php foreach ($data['data']['video'] as $v): ?>
                                            <p><?php echo $v ?></p>
                                        <?php endforeach ?>

                                    <?php endif ?>

                                <?php endif ?>

                            <?php elseif ($e == 'content'): ?>

                                <?php if($data['data']['elements']['property']['content-enable']): ?>

                                    <div class="entry-content">
                                        <?php echo htmlspecialchars_decode($data['data']['fullentry']) ?>
                                    </div>

                                <?php endif ?>

                            <?php elseif ($e == 'form'): ?>

                                <?php if($data['data']['elements']['property']['form-enable']): ?>

                                    <?php if(!empty($data['data']['form']['fields'])): ?>
                                        <?php echo $this->compileBloc('form/main', $data['data']['form']) ?>
                                    <?php endif ?>

                                <?php endif ?>

                            <?php endif ?>

                        <?php endforeach ?>

                    <?php else: ?>
                        <div class="notice notice-default notice-flat">Error getting item sort data</div>
                    <?php endif ?>

                    <div class="entry-utils group">
                        <ul class="entry-actions">
                            <li>
                                <span class="entry-action entry-bookmark<?php echo in_array($data['data']['id'], $data['bookmark']) ? ' entry-action-active' : '' ?>">
                                    <i class="fa fa-bookmark-o" data-toggle="tooltip" data-placement="top" title="Add to bookmarks"></i>
                                </span>
                            </li>
                            <li>
                                <span class="entry-action entry-rating<?php echo in_array($data['data']['id'], $data['updated-ratings']) ? ' entry-action-active' : '' ?>">
                                    <i class="fa fa-thumbs-o-up" data-toggle="tooltip" data-placement="top" title="I like"></i>&nbsp;
                                    <span class="rating"><?php echo $data['data']['rating'] ?></span>
                                </span>
                            </li>
                            <li>
                                <span class="entry-action">
                                    <i class="fa fa-comments-o" data-toggle="tooltip" data-placement="top" title="Comments"></i> <?php echo $data['data']['comments'] ?>
                                </span>
                            </li>
                            <li>
                                <span class="entry-action">
                                    <i class="fa fa-eye" data-toggle="tooltip" data-placement="top" title="Watched"></i> <?php echo $data['data']['views'] ?>
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

                    <div id="paging" class="group">
                        <a href="<?php echo empty($data['neighbor']['prev']) ? '#' : $data['neighbor']['prev']?>" class="paging-standard paging-older<?php echo empty($data['neighbor']['prev']) ? ' disabled' : '' ?>">Previous post</a>
                        <a href="<?php echo empty($data['neighbor']['next']) ? '#' : $data['neighbor']['next']?>" class="paging-standard paging-newer<?php echo empty($data['neighbor']['next']) ? ' disabled' : '' ?>">Next post</a>
                    </div>

                    <?php if(!empty($data['news'])): ?>
                        <div class="entry-related">
                            <h4 class="widget-title">New posts</h4>
                            <div class="row">
                                <?php foreach ($data['news'] as $t): ?>
                                    <div class="col-md-4">
                                        <article class="entry post">
                                            <div class="entry-meta">
                                                <time class="entry-date" datetime="<?php echo $t['time'] ?>"><?php echo $t['time'] ?></time>
                                            </div>
                                            <?php if(!empty($t['images'])): ?>
                                                <div class="entry-featured">
                                                    <a href="<?php echo getEntryURL($data['urls'], $t) ?>">
                                                        <img src="/files/images/thumbnail/<?php echo $t['images'][0] ?>" alt=""/>
                                                    </a>
                                                </div>
                                            <?php endif ?>
                                            <h4 class="entry-title">
                                                <a href="<?php echo getEntryURL($data['urls'], $t) ?>" rel="bookmark"><?php echo $t['header'] ?></a>
                                            </h4>
                                        </article>
                                    </div>
                                <?php endforeach ?>
                            </div>
                        </div>
                    <?php endif ?>

                    <div id="comments">
                        <section id="comments-section">
                            <h3 class="comment-title">
                                Comments
                            </h3>

                            <?php if($data['settings']['comments-enable']): ?>

                                <?php echo $this->compileBloc('comments/entry', $data) ?>

                                <div class="notice notice-default notice-flat notice-add-comment hidden">
                                    <span class="close">&times;</span>
                                    <strong class="reply-info">
                                        Comment added!
                                    </strong>
                                    The comment will appear on the pages after moderation.
                                </div>

                                <div class="notice notice-default notice-flat notice-reply-comment hidden">
                                    <span class="close">&times;</span>
                                    <strong>
                                        <span class="comment-reply-author"></span>
                                        <span class="fa fa-angle-up to-quote"></span>
                                    </strong>
                                    <div class="comment-reply-message"></div>
                                </div>

                                <div class="notice notice-danger notice-flat hidden">An error occurred while adding a comment. Please try again!</div>

                                <form id="comment-form-add" role="form">
                                    <div class="row">
                                        <div class="form-group form-group-sm col-md-6<?php echo empty($data['user']) ? '' : ' hidden' ?>">
                                            <label for="name" class="control-label">Name</label>
                                            <input class="form-control input-lg" placeholder="Name" name="name" value="">
                                        </div>
                                        <div class="form-group form-group-sm col-md-6<?php echo empty($data['user']) ? '' : ' hidden' ?>">
                                            <label for="email" class="control-label">E-mail</label>
                                            <input class="form-control input-lg" placeholder="E-mail" name="email" value="">
                                        </div>
                                        <div class="form-group form-group-sm col-md-12">
                                            <label for="message" class="control-label">Comment</label>
                                            <textarea class="form-control" rows="5" placeholder="Comment" name="comment"></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="captcha" class="control-label">Security code</label>
                                            <div class="input-group">
                                                <div class="input-group-addon"><img src="/captcha" alt="" style="max-width: inherit;"></div>
                                                <input class="form-control input-lg" placeholder="Security code" name="captcha">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <input type="hidden" name="reply" value=""/>
                                            <input type="hidden" name="content" value="<?php echo $data['data']['id'] ?>"/>
                                            <button type="submit" class="btn btn-lg btn-custom" style="width: 100%">Submit</button>
                                        </div>
                                    </div>
                                </form>

                            <?php else: ?>
                                <div class="notice notice-default notice-flat">Commenting is disabled!</div>
                            <?php endif ?>

                        </section>
                    </div>

                </article>

            <?php else: ?>
                <div class="notice notice-default notice-flat">An error occurred while getting the data!</div>
            <?php endif ?>

        </div>
    </div>
</main>