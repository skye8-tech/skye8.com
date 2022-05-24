<div class="row">
    <div class="col-md-12">

        <?php if(!empty($data)): ?>

            <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
                <li role="presentation" class="active"><a href="#main-tab" aria-controls="main-tab" role="tab" data-toggle="tab">Main</a></li>
                <li role="presentation"><a href="#meta-tab" aria-controls="meta-tab" role="tab" data-toggle="tab">Meta and description</a></li>
                <li role="presentation"><a href="#content-tab" aria-controls="content-tab" role="tab" data-toggle="tab">Content</a></li>
                <li role="presentation"><a href="#views-tab" aria-controls="views-tab" role="tab" data-toggle="tab">Display</a></li>
            </ul>

            <form id="page-tag-form-edit">
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
                                    <label for="url" class="control-label">URL Prefix</label>
                                    <p class="help-block">URL prefix where records by tag will be available</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="url" name="url" value="<?php echo $data['data']['url'] ?>" type="text" placeholder="URL Prefix" class="form-control form-control-custom translit-out"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="meta-tab">
                        <table class="table table-custom">
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="title" class="control-label">Title</label>
                                    <p class="help-block">The meta tag title will be added to it the tag name if it is included in the display</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="title" name="title" value="<?php echo $data['data']['title'] ?>" type="text" placeholder="Title" class="form-control form-control-custom"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="content-tab">
                        <div class="form-group">
                            <label for="header" class="control-label">Headline</label>
                            <p class="help-block">The title of the page will be added to it the tag name if it is included in the display</p>
                            <input id="header" type="text" name="header" value="<?php echo $data['data']['header'] ?>" placeholder="Headline" class="form-control form-control-custom content-title content-input">
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="views-tab">
                        <ul class="list-group elements-list hidden">
                            <li class="list-group-item element-item" data-element="entries"></li>
                        </ul>
                        <table class="table table-custom">
                            <tr class="form-group hidden">
                                <td class="col-md-6">
                                    <label for="entries-enable">Display entries</label>
                                    <p class="help-block">If unchecked, entries will not be displayed.</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="entries-enable" type="checkbox" name="entries-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" checked>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="tag-name-enable">Add tag name to title</label>
                                    <p class="help-block">If unchecked, the tag name will not be added to the title.</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="tag-name-enable" type="checkbox" name="tag-name-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" <?php echo $data['data']['elements']['property']['tag-name-enable'] ? 'checked' : ''?>>
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