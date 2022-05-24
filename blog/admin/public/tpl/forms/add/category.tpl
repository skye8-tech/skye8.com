<?php function showOption($data, $parent, $level) { ?>
    <?php foreach ($data as $t): ?>
        <option <?php echo $t['id'] == $parent ? 'selected' : '' ?> value="<?php echo $t['id'] ?>" data-icon="<?php echo $t['icon'] ?>"><?php echo str_repeat('-', $level).$t['name'] ?></option>
        <?php if(isset($t['children'])): ?>
            <?php showOption($t['children'], $parent, $level + 3) ?>
        <?php endif ?>
    <?php endforeach ?>
<?php } ?>

<div class="row">
    <div class="col-md-12">

        <?php if(!empty($data)): ?>

        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
            <li role="presentation" class="active"><a href="#main-tab" aria-controls="main-tab" role="tab" data-toggle="tab">Main</a></li>
            <li role="presentation"><a href="#meta-tab" aria-controls="main-tab" role="tab" data-toggle="tab">Meta and description</a></li>
            <li role="presentation"><a href="#content-tab" aria-controls="content-tab" role="tab" data-toggle="tab">Content</a></li>
            <li role="presentation"><a href="#images-tab" aria-controls="images-tab" role="tab" data-toggle="tab">Images</a></li>
            <li role="presentation"><a href="#slider-tab" aria-controls="slider-tab" role="tab" data-toggle="tab">Slider</a></li>
            <li role="presentation"><a href="#views-tab" aria-controls="views-tab" role="tab" data-toggle="tab">Display</a></li>
        </ul>

        <form id="category-form-add">
            <div class="tab-content">
                <div role="tabpanel" class="tab-pane active" id="main-tab">
                    <table class="table table-custom">
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="parent">Parent</label>
                                <p class="help-block">Parent category</p>
                            </td>
                            <td class="col-md-6">
                                <select id="parent" name="parent" data-live-search="true" class="form-control form-control-custom selectpicker show-tick">
                                    <option selected value="0" data-icon="fa-folder-open-o">Root category</option>
                                    <?php if(!empty($data['category'])): ?>
                                        <?php showOption($data['category'], $data['parent'], 0) ?>
                                    <?php endif ?>
                                </select>
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="icon" class="control-label">Category icon</label>
                                <p class="help-block">Displayed in the menu before the name</p>
                            </td>
                            <td class="col-md-6">
                                <div class="input-group">
                                    <input id="icon" name="icon" type="text" value="fa-folder-open-o" data-placement="bottomRight" class="form-control form-control-custom icp icp-auto"/>
                                    <span class="input-group-addon"></span>
                                </div>
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="name" class="control-label">Name of category</label>
                                <p class="help-block">Displayed in lists</p>
                            </td>
                            <td class="col-md-6">
                                <input id="name" name="name" value="" type="text" placeholder="Name of category" class="form-control form-control-custom translit-in input-in"/>
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="url" class="control-label">Category URL</label>
                                <p class="help-block">URL to which the category will be available</p>
                            </td>
                            <td class="col-md-6">
                                <input id="url" name="url" value="" type="text" placeholder="Category URL" class="form-control form-control-custom translit-out"/>
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="status">Post to website</label>
                                <p class="help-block">If not checked, the category and its descendants will not be displayed on the site</p>
                            </td>
                            <td class="col-md-6">
                                <input type='hidden' value='0' name='status'>
                                <input id="status" type="checkbox" name="status" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker" checked>
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
                                <input id="title" name="title" value="" type="text" placeholder="Title" class="form-control form-control-custom input-out"/>
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="description" class="control-label">Description</label>
                                <p class="help-block">Description meta tag, max 160 characters.</p>
                            </td>
                            <td class="col-md-6">
                                <textarea id="description" name="description" rows="3" class="form-control form-control-custom" placeholder="Description" style="resize: vertical"></textarea>
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="keywords" class="control-label">Keywords</label>
                                <p class="help-block">Keywords meta tag</p>
                            </td>
                            <td class="col-md-6">
                                <input id="keywords" name="keywords" value="" type="text" placeholder="Keywords" class="form-control form-control-custom token-field"/>
                            </td>
                        </tr>
                    </table>
                </div>
                <div role="tabpanel" class="tab-pane" id="content-tab">
                    <div class="form-group">
                        <label for="header" class="control-label">Headline</label>
                        <p class="help-block">Category headline</p>
                        <input id="header" type="text" name="header" value="" placeholder="Headline" class="form-control form-control-custom content-title content-input input-out">
                    </div>
                    <div class="form-group">
                        <label for="content" class="control-label">Description</label>
                        <p class="help-block">Description of the category. Option <span class="fa fa-code"></span> allows you to disable the visual editor</p>
                        <textarea id="content" name="content" class="form-control form-control-custom editor-content"></textarea>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="images-tab">
                    <div class="img-zone text-center" id="images-drag-zone">
                        <div class="img-drop">
                            <div class="inline-text"><img src="/admin/public/img/drag-and-drop.png" alt=""></span></div>
                            <span class="btn btn-default btn-images-upload btn-file">Open file manager<input type="file" multiple="" accept="image/*" class="input-file"></span>
                        </div>
                    </div>
                    <div class="progress progress-images hidden">
                        <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>
                    <div class="row images-preview"></div>
                    <div class="image-item-html hidden">
                        <div class="col-sm-4">
                            <div class="image-item thumbnail action-btn">
                                <img src="" alt="">
                                <div class="image-delete" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <span class="fa fa-trash"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="slider-tab">
                    <div class="img-zone text-center" id="slider-drag-zone">
                        <div class="img-drop">
                            <div class="inline-text"><img src="/admin/public/img/drag-and-drop.png" alt=""></span></div>
                            <span class="btn btn-default slider-btn-images-upload btn-file">Open file manager<input type="file" multiple="" accept="image/*" class="input-file"></span>
                        </div>
                    </div>
                    <div class="progress slider-progress-images hidden">
                        <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
                    </div>
                    <div class="row slider-images-preview"></div>
                    <div class="slider-image-item-html hidden">
                        <div class="col-md-6">
                            <div class="slider-image-item thumbnail action-btn">
                                <img src="" alt="" style="height: 300pt; width: 100%">
                                <input value="" placeholder="Headline" class="form-control slid-title">
                                <textarea placeholder="Text" class="form-control slid-text" style="resize:vertical"></textarea>
                                <input type="file" accept="image/*" class="hidden slid-file">
                                <div class="slider-image-replace" data-toggle="tooltip" data-placement="top" title="Replace image">
                                    <span class="fa fa-picture-o"></span>
                                </div>
                                <div class="slider-image-delete" data-toggle="tooltip" data-placement="top" title="Delete">
                                    <span class="fa fa-trash"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div role="tabpanel" class="tab-pane" id="views-tab">
                    <div class="panel panel-default panel-custom">
                        <div class="panel-heading">The order in which items are displayed in full view</div>
                        <div class="panel-body panel-body-custom">
                            <div class="notice notice-info">Arrange the items in the desired order.</div>
                            <ul class="list-group elements-list">
                                <li class="list-group-item element-item" data-element="slider">Slider</li>
                                <li class="list-group-item element-item" data-element="images">Images</li>
                                <li class="list-group-item element-item" data-element="content">Content</li>
                                <li class="list-group-item element-item" data-element="entries">Posts</li>
                            </ul>
                        </div>
                    </div>
                    <table class="table table-custom">
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="slider-enable">Display slider</label>
                                <p class="help-block">If not checked, the slider will not be displayed.</p>
                            </td>
                            <td class="col-md-6">
                                <input id="slider-enable" type="checkbox" name="slider-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" checked>
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="images-enable">Display images</label>
                                <p class="help-block">If unchecked, images will not be displayed.</p>
                            </td>
                            <td class="col-md-6">
                                <input id="images-enable" type="checkbox" name="images-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" checked>
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="content-enable">Display content</label>
                                <p class="help-block">If unchecked, the content will not be displayed.</p>
                            </td>
                            <td class="col-md-6">
                                <input id="content-enable" type="checkbox" name="content-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" checked>
                            </td>
                        </tr>
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="entries-enable">Display entries</label>
                                <p class="help-block">If not checked, entries will not be displayed.</p>
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