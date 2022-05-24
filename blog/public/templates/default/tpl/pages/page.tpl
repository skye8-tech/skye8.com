<main class="single">
    <div class="row">
        <div class="col-md-12">

            <?php if(!empty($data)): ?>

                <article class="entry">
                    <h1 class="page-title"><?php echo $data['data']['header'] ?></h1>

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
                                        <?php echo $data['data']['content'] ?>
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

            <?php else: ?>
                <div class="notice notice-default notice-flat">Возникла ошибка при получении данных</div>
            <?php endif ?>

        </div>
    </div>
</main>