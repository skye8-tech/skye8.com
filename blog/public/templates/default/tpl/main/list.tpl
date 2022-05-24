<main id="content" class="entries-classic">
    <div class="row">
        <div class="col-md-12">

            <?php if(!empty($data['data'])): ?>
                
                <h1 class="page-title"><?php echo $data['data']['header'] ?></h1>

                <?php if(!empty($data['data']['elements']['elements'])): ?>

                    <?php foreach ($data['data']['elements']['elements'] as $e): ?>

                        <?php if($e == 'search'): ?>

                            <form action="/search/" method="post">
                                <div class="form-group">
                                    <div class="input-group ">
                                        <input type="text" name="search" value="<?php echo $data['data']['search-string'] ?>" placeholder="Search" class="form-control search-input search-input-list"/>
                                        <span class="input-group-btn">
                                            <button type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
                                        </span>
                                    </div>
                                </div>
                            </form>

                            <?php if($data['data']['search-error']): ?>

                                <div class="notice notice-default notice-flat">An empty search query was entered, or its length is less than 3 characters, so the search was suspended.</div>

                            <?php endif ?>

                            <?php if($data['data']['search-success']): ?>

                                <div class="notice notice-default notice-flat">At your request «<?php echo $data['data']['search-string'] ?>» found <?php echo $data['data']['search-count'] ?> publications.</div>

                            <?php endif ?>

                            <?php if($data['data']['search-empty']): ?>

                                <div class="notice notice-default notice-flat">Sorry, search by query «<?php echo $data['data']['search-string'] ?>» did not give any results. Try changing or shortening your request.</div>

                            <?php endif ?>

                        <?php elseif ($e == 'slider'): ?>

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
                                    <?php echo $data['data']['content'] ?>
                                </div>

                            <?php endif ?>

                        <?php elseif ($e == 'entries'): ?>

                            <?php if($data['data']['elements']['property']['entries-enable']): ?>
                                <?php echo $this->compileBloc('entries/entries', $data) ?>
                            <?php endif ?>

                        <?php elseif ($e == 'comments'): ?>

                            <?php if($data['data']['elements']['property']['comments-enable']): ?>
                                <?php echo $this->compileBloc('comments/user', $data) ?>
                            <?php endif ?>

                        <?php endif ?>

                    <?php endforeach ?>

                    <?php if ($data['page-count'] > 1): ?>

                        <?php if($data['page-last-show']): ?>
                            <div class="notice notice-default notice-flat notice-page-last">
                                <span class="close">&times;</span>
                                Last time you settled on <a href="<?php echo $data['url'].$data['page-last'] ?>"><b><?php echo $data['page-last'] ?></b></a> pages
                            </div>
                        <?php endif ?>

                        <div id="paging" class="group" data-ajax-navigation-enable="1" data-page-count="<?php echo $data['page-count'] ?>">
                            <ul>
                                <?php echo buildPagination($data) ?>
                                <li class="dropdown sort-select">
                                    <span class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                        <i class="fa fa-sort-amount-desc"></i> <span class="caret"></span>
                                    </span>
                                    <ul class="dropdown-menu" role="menu">
                                        <li data-sort="id" class="<?php echo $data['sort'] == 'id' ? 'active' : ''?>"><i class="fa fa-clock-o"></i> New</li>
                                        <li data-sort="time" class="<?php echo $data['sort'] == 'time' ? 'active' : ''?>"><i class="fa fa-clock-o"></i> Old</li>
                                        <li data-sort="rating" class="<?php echo $data['sort'] == 'rating' ? 'active' : ''?>"><i class="fa fa-thumbs-o-up"></i> Best</li>
                                        <li data-sort="views" class="<?php echo $data['sort'] == 'views' ? 'active' : ''?>"><i class="fa fa-eye"></i> Popular</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>

                    <?php endif ?>

                <?php else: ?>
                    <div class="notice notice-default notice-flat">Error getting item sort data</div>
                <?php endif ?>

            <?php else: ?>
                <div class="notice notice-default notice-flat">Error getting data</div>
            <?php endif ?>

        </div>
    </div>
</main>