<div class="row">
    <div class="col-md-12">
        <div class="box box-info panel-content" data-root-nav="settings">
            <div class="box-header with-border">
                <h3 class="box-title">Script settings</h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" data-widget="collapse">
                        <i class="fa fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-box-tool" data-widget="remove">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php if(!empty($data['data'])): ?>

                            <ul class="nav nav-tabs" role="tablist">
                                <li role="presentation" class="active"><a href="#main-tab" aria-controls="main-tab" role="tab" data-toggle="tab">Main</a></li>
                                <li role="presentation"><a href="#entries-tab" aria-controls="entries-tab" role="tab" data-toggle="tab">Posts</a></li>
                                <li role="presentation"><a href="#category-tab" aria-controls="category-tab" role="tab" data-toggle="tab">Categories</a></li>
                                <li role="presentation"><a href="#api-tab" aria-controls="api-tab" role="tab" data-toggle="tab">API</a></li>
                                <li role="presentation"><a href="#admin-tab" aria-controls="admin-tab" role="tab" data-toggle="tab">Admin panel</a></li>
                                <li role="presentation"><a href="#robots-tab" aria-controls="robots-tab" role="tab" data-toggle="tab">File robots.txt</a></li>
                            </ul>

                            <form id="settings-form" action="" method="post">
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="main-tab">
                                        <table class="table table-custom">
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="site-title" class="control-label">Name of the site</label>
                                                    <p class="help-block">The name of the site will be used in the title of your site.</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input id="site-title" name="site-title" value="<?php echo $data['data']['site-title'] ?>" type="text" class="form-control form-control-custom"/>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="site-description" class="control-label">Description of the site</label>
                                                    <p class="help-block">The description will be used in the meta description of your site, no more than 160 characters.</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <textarea id="site-description" name="site-description" rows="3" class="form-control form-control-custom" style="resize: vertical"><?php echo $data['data']['site-description'] ?></textarea>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="site-keywords" class="control-label">Keywords</label>
                                                    <p class="help-block">These words will be used in meta keywords.</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input id="site-keywords" name="site-keywords" value="<?php echo $data['data']['site-keywords'] ?>" type="text" class="form-control form-control-custom token-field"/>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="notification-email" class="control-label">Email address for notifications</label>
                                                    <p class="help-block">Notifications will be sent to this address</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input id="notification-email" name="notification-email" value="<?php echo $data['data']['notification-email'] ?>" type="email" class="form-control form-control-custom"/>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="notifications-enable">Send email notification</label>
                                                    <p class="help-block">If unchecked, an email notification of events on the site will not be sent</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input type='hidden' value='0' name='notifications-enable'>
                                                    <input id="notifications-enable" type="checkbox" name="notifications-enable" value="1" class="check-box-picker" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" <?php echo $data['data']['notifications-enable'] ? 'checked' : '' ?>>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="sitemap-enable">Include sitemap.xml</label>
                                                    <p class="help-block">If unchecked, sitemap.xml will be unavailable</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input type='hidden' value='0' name='sitemap-enable'>
                                                    <input id="sitemap-enable" type="checkbox" name="sitemap-enable" value="1" class="check-box-picker" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" <?php echo $data['data']['sitemap-enable'] ? 'checked' : '' ?>>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="site-enable">Turn on site</label>
                                                    <p class="help-block">If not checked, the site will go offline, for technical work</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input type='hidden' value='0' name='site-enable'>
                                                    <input id="site-enable" type="checkbox" name="site-enable" value="1" class="check-box-picker" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" <?php echo $data['data']['site-enable'] ? 'checked' : '' ?>>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="entries-tab">
                                        <table class="table table-custom">
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="sort-site" class="control-label">The order of sorting entries on the site page</label>
                                                    <p class="help-block">The sort order by which entries are displayed on the site page, by default</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <select id="sort-site" name="sort-site" data-live-search="true" class="form-control form-control-custom selectpicker show-tick">
                                                        <option value="id" data-icon="fa-clock-o" <?php echo $data['data']['sort-site'] == 'id' ? 'selected' : ''?>>New</option>
                                                        <option value="time" data-icon="fa-clock-o" <?php echo $data['data']['sort-site'] == 'time' ? 'selected' : ''?>>Old</option>
                                                        <option value="rating" data-icon="fa-thumbs-o-up" <?php echo $data['data']['sort-site'] == 'rating' ? 'selected' : ''?>>Best</option>
                                                        <option value="views" data-icon="fa-eye" <?php echo $data['data']['sort-site'] == 'views' ? 'selected' : ''?>>Popular</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="page-rows" class="control-label">The number of entries on the site page</label>
                                                    <p class="help-block">The number of entries that will be displayed on the site page</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input id="page-rows" name="page-rows" value="<?php echo $data['data']['page-rows'] ?>" type="number" class="form-control form-control-custom"/>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="content-prefix-enable" class="control-label">Add category URL to post</label>
                                                    <p class="help-block">If checked, a prefix in the form of a category URL will be added to the post URL</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input type='hidden' value='0' name='content-prefix-enable'>
                                                    <input id="content-prefix-enable" type="checkbox" name="content-prefix-enable" value="1" class="check-box-picker" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" <?php echo $data['data']['content-prefix-enable'] ? 'checked' : '' ?>>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="comments-enable">Allow comments on posts</label>
                                                    <p class="help-block">If unchecked, commenting on entries will not be available</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input type='hidden' value='0' name='comments-enable'>
                                                    <input id="comments-enable" type="checkbox" name="comments-enable" value="1" class="check-box-picker" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" <?php echo $data['data']['comments-enable'] ? 'checked' : '' ?>>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="comment-moderation-enable">Use comment moderation</label>
                                                    <p class="help-block">If unchecked, comments will be published immediately after adding</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input type='hidden' value='0' name='comment-moderation-enable'>
                                                    <input id="comment-moderation-enable" type="checkbox" name="comment-moderation-enable" value="1" class="check-box-picker" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" <?php echo $data['data']['comment-moderation-enable'] ? 'checked' : '' ?>>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="rss-enable">Enable RSS feed export</label>
                                                    <p class="help-block">If unchecked, RSS feed export will not be available.</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input type='hidden' value='0' name='rss-enable'>
                                                    <input id="rss-enable" type="checkbox" name="rss-enable" value="1" class="check-box-picker" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" <?php echo $data['data']['rss-enable'] ? 'checked' : '' ?>>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="category-tab">
                                        <table class="table table-custom">
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="category-prefix-enable" class="control-label">Use URL prefix specified for category page</label>
                                                    <p class="help-block">If unchecked, categories will be accessible from the root of the site. </p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input type='hidden' value='0' name='category-prefix-enable'>
                                                    <input id="category-prefix-enable" type="checkbox" name="category-prefix-enable" value="1" class="check-box-picker" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" <?php echo $data['data']['category-prefix-enable'] ? 'checked' : '' ?>>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="category-page-last-enable">Display tooltip with last page viewed in category</label>
                                                    <p class="help-block">If unchecked, the tooltip with the last page viewed will not be displayed.</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input type='hidden' value='0' name='category-page-last-enable'>
                                                    <input id="category-page-last-enable" type="checkbox" name="category-page-last-enable" value="1" class="check-box-picker" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" <?php echo $data['data']['category-page-last-enable'] ? 'checked' : '' ?>>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="api-tab">
                                        <table class="table table-custom">
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="api-token" class="control-label">Embedded API Token</label>
                                                    <p class="help-block">Token for working with the built-in API</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input id="api-token" name="api-token" value="<?php echo $data['data']['api-token'] ?>" type="text" class="form-control form-control-custom"/>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="api-enable">Integrated API</label>
                                                    <p class="help-block">If unchecked, the embedded API will not be available.</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input type='hidden' value='0' name='api-enable'>
                                                    <input id="api-enable" type="checkbox" name="api-enable" value="1" class="check-box-picker" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" <?php echo $data['data']['api-enable'] ? 'checked' : '' ?>>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="admin-tab">
                                        <table class="table table-custom">
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="sort-admin" class="control-label">The order of sorting items on the admin panel page</label>
                                                    <p class="help-block">The sort order by which the items on the admin panel page will be displayed</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <select id="sort-admin" name="sort-admin" data-live-search="true" class="form-control form-control-custom selectpicker show-tick">
                                                        <option value="position" data-icon="fa-clock-o" <?php echo $data['data']['sort-admin'] == 'position' ? 'selected' : ''?>>According to the established procedure</option>
                                                        <option value="id" data-icon="fa-clock-o" <?php echo $data['data']['sort-admin'] == 'id' ? 'selected' : ''?>>New</option>
                                                        <option value="time" data-icon="fa-clock-o" <?php echo $data['data']['sort-admin'] == 'time' ? 'selected' : ''?>>Old</option>
                                                    </select>
                                                </td>
                                            </tr>
                                            <tr class="form-group">
                                                <td class="col-md-6">
                                                    <label for="page-rows-admin" class="control-label">The number of items on the admin panel page</label>
                                                    <p class="help-block">The number of items that will be displayed on the admin panel page</p>
                                                </td>
                                                <td class="col-md-6">
                                                    <input id="page-rows-admin" name="page-rows-admin" value="<?php echo $data['data']['page-rows-admin'] ?>" type="number" class="form-control form-control-custom"/>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="robots-tab">
                                        <table class="table table-custom">
                                            <tr class="form-group">
                                                <td class="col-md-4">
                                                    <label for="robots-content" class="robots-content">File robots.txt</label>
                                                    <p class="help-block">File contents robots.txt</p>
                                                </td>
                                                <td class="col-md-8">
                                                    <textarea id="robots-content" name="robots-content" rows="10" class="form-control form-control-custom"><?php echo $data['data']['robots-content'] ?></textarea>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-md-4">
                                                    <label for="robots-enable">Enable robots.txt</label>
                                                    <p class="help-block">Enabling or disabling robots.txt</p>
                                                </td>
                                                <td class="col-md-8">
                                                    <input type='hidden' value='0' name='robots-enable'>
                                                    <input id="robots-enable" type="checkbox" name="robots-enable" value="1" class="check-box-picker" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" <?php echo $data['data']['robots-enable'] ? 'checked' : '' ?>>
                                                </td>
                                            </tr>
                                        </table>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        <?php else: ?>
                            <div class="alert alert-danger">Error getting data</div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>