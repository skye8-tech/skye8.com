<?php function showCategoryOption($data, $level){ ?>
    <?php foreach ($data as $t): ?>
        <option value="<?php echo $t['id'] ?>" data-icon="<?php echo $t['icon'] ?>"><?php echo str_repeat('-', $level).$t['name'] ?></option>
        <?php if (isset($t['children'])): ?>
            <?php showCategoryOption($t['children'], $level + 3) ?>
        <?php  endif ?>
    <?php endforeach ?>
<?php } ?>

<?php function showTagsOption($data, $level){ ?>

<?php } ?>

<main class="single">
    <div class="row">
        <div class="col-md-12">

            <?php if(!empty($data)): ?>

                <article class="entry">
                    <h1 class="page-title"><?php echo $data['data']['header'] ?></h1>

                    <?php if(!empty($data['data']['elements']['elements'])): ?>

                        <?php foreach ($data['data']['elements']['elements'] as $e): ?>

                            <?php if ($e == 'content'): ?>

                                <?php if($data['data']['elements']['property']['content-enable']): ?>

                                    <div class="entry-content">
                                        <?php echo $data['data']['content'] ?>
                                    </div>

                                <?php endif ?>

                            <?php elseif ($e == 'form'): ?>

                                <div class="notice notice-success notice-flat hidden">Data sent successfully!</div>
                                <div class="notice notice-danger notice-flat hidden">An error occurred while sending the data. Please try again!</div>

                                <form id="content-add-form" role="form">
                                    <div class="row">
                                        <?php if(!empty($data['category'])): ?>
                                            <div class="form-group col-md-12">
                                                <label for="category">Categories</label>
                                                <p class="help-block">Categories in which the entry will be posted</p>
                                                <select id="category" name="category[]" multiple data-live-search="true" class="form-control selectpicker show-tick">
                                                    <?php showCategoryOption($data['category'], 0) ?>
                                                </select>
                                            </div>
                                        <?php endif ?>
                                        <?php if(!empty($data['tags'])): ?>
                                            <div class="form-group col-md-12">
                                                <label for="tags">Tags</label>
                                                <p class="help-block">Keywords for tag clouds</p>
                                                <select id="tags" name="tags[]" multiple data-live-search="true" class="form-control selectpicker show-tick">
                                                    <?php foreach ($data['tags'] as $t): ?>
                                                        <option value="<?php echo $t['id'] ?>" data-icon="fa fa-tag"><?php echo $t['name'] ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            </div>
                                        <?php endif ?>
                                        <div class="form-group col-md-12">
                                            <label for="title" class="control-label">Title</label>
                                            <p class="help-block">Title tag meta</p>
                                            <input id="title" name="title" value="" type="text" placeholder="Title" class="form-control translit-in input-in"/>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="url" class="control-label">Page URL</label>
                                            <p class="help-block">URL to which the page will be available</p>
                                            <input id="url" name="url" value="" type="text" placeholder="Page URL" class="form-control translit-out"/>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="description" class="control-label">Description</label>
                                            <p class="help-block">Description meta tag, max 160 characters.</p>
                                            <textarea id="description" name="description" rows="3" class="form-control" placeholder="Description" style="resize: vertical"></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="keywords" class="control-label">Keywords</label>
                                            <p class="help-block">Keywords meta tag</p>
                                            <input id="keywords" name="keywords" value="" type="text" placeholder="Keywords" class="form-control token-field"/>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="header" class="control-label">Headline</label>
                                            <p class="help-block">Post title</p>
                                            <input id="header" type="text" name="header" value="" placeholder="Headline" class="form-control content-title content-input input-out">
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="shortentry" class="control-label">Short description</label>
                                            <p class="help-block">Short description. Option «<span class="fa fa-code"></span>» allows editing HTML</p>
                                            <textarea id="shortentry" name="shortentry" class="form-control editor-content"></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="fullentry" class="control-label">Full description</label>
                                            <p class="help-block">Full description. Option «<span class="fa fa-code"></span>» allows editing HTML</p>
                                            <textarea id="fullentry" name="fullentry" class="form-control editor-content"></textarea>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <label for="captcha" class="control-label"></label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <img src="/captcha" alt="" style="max-width: inherit;">
                                                </div>
                                                <input class="form-control input-lg" placeholder="Security code" name="captcha" id="captcha">
                                            </div>
                                        </div>
                                        <div class="form-group col-md-12">
                                            <button type="submit" class="btn btn-custom" style="width: 100%">Submit</button>
                                        </div>
                                    </div>
                                </form>

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
                <div class="notice notice-default notice-flat">There was an error retrieving data</div>
            <?php endif ?>

        </div>
    </div>
</main>
