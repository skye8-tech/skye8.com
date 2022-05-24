<div class="row">
    <div class="col-md-12">

        <?php if(!empty($data)): ?>

            <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
                <li role="presentation" class="active"><a href="#main-tab" aria-controls="main-tab" role="tab" data-toggle="tab">Main</a></li>
                <li role="presentation"><a href="#meta-tab" aria-controls="meta-tab" role="tab" data-toggle="tab">Meta and description</a></li>
                <li role="presentation"><a href="#content-tab" aria-controls="content-tab" role="tab" data-toggle="tab">Content</a></li>
                <li role="presentation"><a href="#views-tab" aria-controls="views-tab" role="tab" data-toggle="tab">Display</a></li>
            </ul>

            <form id="page-bookmark-form-edit">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="main-tab">
                        <table class="table table-custom">
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="icon" class="control-label">Page icon</label>
                                    <p class="help-block">Displayed in the menu before the name</p>
                                </td>
                                <td class="col-md-6">
                                    <div class="input-group">
                                        <input id="icon" name="icon" type="text" value="<?php echo $data['data']['icon'] ?>" data-placement="bottomRight" class="form-control form-control-custom icp icp-auto"/>
                                        <span class="input-group-addon"></span>
                                    </div>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="name" class="control-label">Page name</label>
                                    <p class="help-block">Displayed in the menu</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="name" name="name" value="<?php echo $data['data']['name'] ?>" type="text" placeholder="Page name" class="form-control form-control-custom translit-in"/>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="url" class="control-label">Page URL</label>
                                    <p class="help-block">URL to which the page will be available</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="url" name="url" value="<?php echo $data['data']['url'] ?>" type="text" placeholder="Page URL" class="form-control form-control-custom translit-out"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="meta-tab">
                        <table class="table table-custom">
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="title" class="control-label">Title</label>
                                    <p class="help-block">Title tag meta</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="title" name="title" value="<?php echo $data['data']['title'] ?>" type="text" placeholder="Title" class="form-control form-control-custom"/>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="description" class="control-label">Description</label>
                                    <p class="help-block">Description meta tag, max 160 characters.</p>
                                </td>
                                <td class="col-md-6">
                                    <textarea id="description" name="description" rows="3" class="form-control form-control-custom" placeholder="Description" style="resize: vertical"><?php echo $data['data']['description'] ?></textarea>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="content-tab">
                        <div class="form-group">
                            <label for="header" class="control-label">Headline</label>
                            <p class="help-block">Page title</p>
                            <input id="header" type="text" name="header" value="<?php echo $data['data']['header'] ?>" placeholder="Headline" class="form-control form-control-custom content-title content-input">
                        </div>
                        <div class="form-group">
                            <label for="content" class="control-label">Content</label>
                            <p class="help-block">Page content. Option «<span class="fa fa-code"></span>» allows editing HTML</p>
                            <textarea id="content" name="content" class="form-control form-control-custom editor-content"><?php echo htmlspecialchars_decode($data['data']['content']) ?></textarea>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="views-tab">
                        <div class="panel panel-default panel-custom">
                            <div class="panel-heading">The order of output elements</div>
                            <div class="panel-body panel-body-custom">
                                <div class="notice notice-info">Arrange the items in the desired order.</div>
                                <ul class="list-group elements-list">
                                    <?php if(!empty($data['data']['elements']['elements'])): ?>
                                        <?php foreach ($data['data']['elements']['elements'] as $t): ?>
                                            <?php if($t == 'content'): ?>
                                                <li class="list-group-item element-item" data-element="content">Content</li>
                                            <?php endif ?>
                                            <?php if($t == 'entries'): ?>
                                                <li class="list-group-item element-item" data-element="entries">Posts</li>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <li class="list-group-item element-item" data-element="content">Content</li>
                                        <li class="list-group-item element-item" data-element="entries">Posts</li>
                                    <?php endif ?>
                                </ul>
                            </div>
                        </div>
                        <table class="table table-custom">
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="content-enable">Display content</label>
                                    <p class="help-block">If unchecked, the content will not be displayed.</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="content-enable" type="checkbox" name="content-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" <?php echo $data['data']['elements']['property']['content-enable'] ? 'checked' : ''?>>
                                </td>
                            </tr>
                            <tr class="form-group hidden">
                                <td class="col-md-6">
                                    <label for="entries-enable">Display posts</label>
                                    <p class="help-block">If unchecked, the posts will not be displayed.</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="entries-enable" type="checkbox" name="entries-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" checked>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </form>
        <?php else: ?>
            <div class="notice notice-danger">Error getting data</div>
        <?php endif ?>
    </div>
</div>