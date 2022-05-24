<?php function showOption($data, $level, $use) { ?>
    <?php foreach ($data as $t): ?>
        <option value="<?php echo $t['id'] ?>" data-icon="<?php echo $t['icon'] ?>" <?php echo in_array($t['id'], $use) ? 'selected' : ''?>>
            <?php echo str_repeat('-', $level).$t['name'] ?>
        </option>
        <?php if(isset($t['children'])): ?>
            <?php showOption($t['children'], $level + 3, $use) ?>
        <?php endif ?>
    <?php endforeach ?>
<?php } ?>

<div class="row">
    <div class="col-md-12">

        <?php if(!empty($data)): ?>

            <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
                <li role="presentation" class="active"><a href="#main-tab" aria-controls="main-tab" role="tab" data-toggle="tab">Main</a></li>
                <li role="presentation"><a href="#meta-tab" aria-controls="meta-tab" role="tab" data-toggle="tab">Meta and description</a></li>
                <li role="presentation"><a href="#content-tab" aria-controls="content-tab" role="tab" data-toggle="tab">Content</a></li>
                <li role="presentation"><a href="#images-tab" aria-controls="images-tab" role="tab" data-toggle="tab">Images</a></li>
                <li role="presentation"><a href="#slider-tab" aria-controls="slider-tab" role="tab" data-toggle="tab">Slider</a></li>
                <li role="presentation"><a href="#video-tab" aria-controls="video-tab" role="tab" data-toggle="tab">Video</a></li>
                <li role="presentation"><a href="#form-tab" aria-controls="form-tab" role="tab" data-toggle="tab">Form</a></li>
                <li role="presentation"><a href="#views-tab" aria-controls="views-tab" role="tab" data-toggle="tab">Display</a></li>
            </ul>

            <form id="content-form-edit">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="main-tab">
                        <table class="table table-custom">
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="category">Categories</label>
                                    <p class="help-block">Categories in which the entry will be posted</p>
                                </td>
                                <td class="col-md-6">
                                    <?php if(!empty($data['category'])): ?>
                                        <select id="headings" name="category[]" data-live-search="true" multiple class="form-control form-control-custom selectpicker show-tick">
                                            <?php showOption($data['category'], 0, $data['use-category']) ?>
                                        </select>
                                    <?php else: ?>
                                        <div class="notice notice-warning notice-flat">No categories!</div>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="tags">Tags</label>
                                    <p class="help-block">Keywords for tag clouds</p>
                                </td>
                                <td class="col-md-6">
                                    <?php if(!empty($data['tags'])): ?>
                                        <select id="tags" name="tags[]" data-live-search="true" multiple class="form-control form-control-custom selectpicker show-tick">
                                            <?php foreach ($data['tags'] as $t): ?>
                                                <option value="<?php echo $t['id'] ?>" data-icon="fa-tag" <?php echo in_array($t['id'], $data['use-tags']) ? 'selected' : ''?>>
                                                    <?php echo $t['name'] ?>
                                                </option>
                                            <?php endforeach ?>
                                        </select>
                                    <?php else: ?>
                                        <div class="notice notice-warning notice-flat">No tags!</div>
                                    <?php endif ?>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="time">Publication date</label>
                                    <p class="help-block">If the set date has not yet arrived, the record will be published automatically at the indicated time.</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="time" name="time" value="<?php echo $data['data']['time'] ?>" type="text" placeholder="Publication date" class="form-control form-control-custom date-time-picker"/>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="status">Post to website</label>
                                    <p class="help-block">If unchecked, the entry will not be displayed on the site</p>
                                </td>
                                <td class="col-md-6">
                                    <input type='hidden' value='0' name='status'>
                                    <input id="status" type="checkbox" name="status" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker" <?php echo $data['data']['status'] ? 'checked' : ''?>>
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
                                    <input id="title" name="title" value="<?php echo $data['data']['title'] ?>" type="text" placeholder="Title" class="form-control form-control-custom translit-in input-in"/>
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
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="description" class="control-label">Description</label>
                                    <p class="help-block">Description meta tag, max 160 characters.</p>
                                </td>
                                <td class="col-md-6">
                                    <textarea id="description" name="description" rows="3" class="form-control form-control-custom" placeholder="Description" style="resize: vertical"><?php echo $data['data']['description'] ?></textarea>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="keywords" class="control-label">Keywords</label>
                                    <p class="help-block">Keywords meta tag</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="keywords" name="keywords" value="<?php echo $data['data']['keywords'] ?>" type="text" placeholder="Keywords" class="form-control form-control-custom token-field"/>
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="content-tab">
                        <div class="form-group">
                            <label for="header" class="control-label">Headline</label>
                            <p class="help-block">Post title</p>
                            <input id="header" type="text" name="header" value="<?php echo $data['data']['header'] ?>" placeholder="Headline" class="form-control form-control-custom content-title content-input input-out">
                        </div>
                        <div class="form-group">
                            <label for="shortentry" class="control-label">Short description</label>
                            <p class="help-block">Short description. Option «<span class="fa fa-code"></span>» allows editing HTML</p>
                            <textarea id="shortentry" name="shortentry" class="form-control form-control-custom editor-content"><?php echo $data['data']['shortentry'] ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="fullentry" class="control-label">Full description</label>
                            <p class="help-block">Full description. Option «<span class="fa fa-code"></span>» allows editing HTML</p>
                            <textarea id="fullentry" name="fullentry" class="form-control form-control-custom editor-content"><?php echo $data['data']['fullentry'] ?></textarea>
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
                        <div class="row images-preview">
                            <?php if(!empty($data['data']['images'])): ?>
                                <?php foreach($data['data']['images'] as $t): ?>
                                    <div class="col-sm-4">
                                        <div class="image-item thumbnail action-btn">
                                            <img src="/files/images/thumbnail/<?php echo $t ?>" alt="">
                                            <div class="image-delete" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <span class="fa fa-trash"></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
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
                        <div class="row slider-images-preview">
                            <?php if(!empty($data['data']['slider'])): ?>
                                <?php foreach($data['data']['slider'] as $t): ?>
                                    <div class="col-md-6">
                                        <div class="slider-image-item thumbnail action-btn">
                                            <img src="/files/images/thumbnail/<?php echo $t['image'] ?>" alt="" style="height: 300pt; width: 100%">
                                            <input value="<?php echo $t['title'] ?>" placeholder="Headline" class="form-control slid-title">
                                            <textarea placeholder="Text" class="form-control slid-text" style="resize:vertical"><?php echo $t['text'] ?></textarea>
                                            <input value="<?php echo $t['url'] ?>" placeholder="Button URL" class="form-control slid-url">
                                            <input value="<?php echo $t['button'] ?>" placeholder="Button text" class="form-control slid-button">
                                            <input type="file" accept="image/*" class="hidden slid-file">
                                            <div class="slider-image-replace" data-toggle="tooltip" data-placement="top" title="Replace image">
                                                <span class="fa fa-picture-o"></span>
                                            </div>
                                            <div class="slider-image-delete" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <span class="fa fa-trash"></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                        <div class="slider-image-item-html hidden">
                            <div class="col-md-6">
                                <div class="slider-image-item thumbnail action-btn">
                                    <img src="" alt="" style="height: 300pt; width: 100%">
                                    <input value="" placeholder="Headline" class="form-control slid-title">
                                    <textarea placeholder="Text" class="form-control slid-text" style="resize:vertical"></textarea>
                                    <input value="" placeholder="Button URL" class="form-control slid-url">
                                    <input value="" placeholder="Button text" class="form-control slid-button">
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
                    <div role="tabpanel" class="tab-pane" id="video-tab">
                        <div class="notice notice-info">
                            Supported by: YouTube, Vimeo, Vine, Instagram, DailyMotion, Youku
                        </div>
                        <div class="form-group well">
                            <label for="video-url-input"></label>
                            <input id="video-url-input" value="" type="text" placeholder="Paste the link to the video, click add" class="form-control form-control-custom video-url-input"/>
                            <div class="btn video-url-btn" style="padding-top: 5px; width: 100%">Add</div>
                        </div>
                        <div class="row video-preview">
                            <?php if(!empty($data['data']['video'])): ?>
                                <?php foreach($data['data']['video'] as $t): ?>
                                    <div class="col-md-6">
                                        <div class="video-item thumbnail action-btn">
                                            <div class="embed-responsive embed-responsive-4by3 embed-html" style="display: block">
                                                <?php echo $t ?>
                                            </div>
                                            <div class="video-delete" data-toggle="tooltip" data-placement="top" title="Delete">
                                                <span class="fa fa-trash"></span>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach ?>
                            <?php endif ?>
                        </div>
                        <div class="video-item-html hidden">
                            <div class="col-md-6">
                                <div class="video-item thumbnail action-btn">
                                    <div class="embed-responsive embed-responsive-4by3 embed-html" style="display: block"></div>
                                    <div class="video-delete" data-toggle="tooltip" data-placement="top" title="Delete">
                                        <span class="fa fa-trash"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="form-tab">

                        <ul class="list-group form-add-items">
                            <li class="list-group-item cursor-pointer" data-type="text">Add single line text</li>
                            <li class="list-group-item cursor-pointer" data-type="textarea">Add multiline text</li>
                            <li class="list-group-item cursor-pointer" data-type="select">Add select</li>
                            <li class="list-group-item cursor-pointer" data-type="radio">Add radio buttons</li>
                            <li class="list-group-item cursor-pointer" data-type="checkbox">Add checkbox</li>
                        </ul>

                        <div class="form-container well well-sm" data-json='<?php echo !empty($data['data']['form']) ? json_encode($data['data']['form']) : '' ?>'></div>
                        <div class="form-components hidden">
                            <input class="form-required-checkbox" type="checkbox" title="Required" data-toggle="tooltip" data-placement="top">
                            <span class="fa fa-close text-danger delete-component cursor-pointer" title="Delete item" data-toggle="tooltip" data-placement="top"></span>
                            <div class="form-component form-choices-container cursor-move">
                                <ul class="list-group"></ul>
                                <div class="add-choice">
                                    <span class="fa fa-plus text-success cursor-pointer" title="Add item" data-toggle="tooltip" data-placement="top"></span>
                                </div>
                            </div>
                            <div class="form-component form-panel panel panel-default field cursor-move" data-type="">
                                <div class="panel-heading">
                                    <small></small>
                                    <div class="input-group">
                                        <input type="text" class="form-control form-field-name field-label" placeholder="Block name">
                                        <span class="input-group-addon panel-action"></span>
                                    </div>
                                </div>
                                <div class="panel-body"></div>
                            </div>
                            <ul>
                                <li class="form-component form-choice-item list-group-item cursor-move">
                                    <div class="input-group">
                                        <input type="text" class="form-control toggle-selected choice-label" placeholder="Item name">
                                        <span class="input-group-addon">
                                        <input class="toggle-selected" type="checkbox" title="Selected by default" data-toggle="tooltip" data-placement="top">
                                        <span class="fa fa-close text-danger delete-component cursor-pointer" title="Delete элемент" data-toggle="tooltip" data-placement="top"></span>
                                    </span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <table class="table table-custom">
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label class="header-text">Form header text</label>
                                    <p class="help-block">Sets the title text of the form</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="header-text" name="header-text" type="text" class="form-control form-control-custom form-param" placeholder="Enter the title text for the form">
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="message-text" class="control-label">Text message form</label>
                                    <p class="help-block">Sets the text of the message form</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="message-text" name="message-text" type="text" class="form-control form-control-custom form-param" placeholder="Enter text message form">
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="button-text" class="control-label">Send button text</label>
                                    <p class="help-block">Sets the button text will send</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="button-text" name="button-text" type="text" class="form-control form-control-custom form-param" placeholder="Enter the send button text">
                                </td>
                            </tr>
                        </table>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="views-tab">
                        <div class="panel panel-default panel-custom">
                            <div class="panel-heading">Display in preview</div>
                            <div class="panel-body panel-body-custom" style="margin: 10px">
                                <div class="form-group">
                                    <label class="radio-inline">
                                        <input type="radio" name="preview-element" value="images" <?php echo $data['data']['elements']['previews'] == 'images' ? 'checked' : ''?>> Images
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="preview-element" value="slider" <?php echo $data['data']['elements']['previews'] == 'slider' ? 'checked' : ''?>> Slider
                                    </label>
                                    <label class="radio-inline">
                                        <input type="radio" name="preview-element" value="video" <?php echo $data['data']['elements']['previews'] == 'video' ? 'checked' : ''?>> Video
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="panel panel-default panel-custom">
                            <div class="panel-heading">The order in which items are displayed in full view</div>
                            <div class="panel-body panel-body-custom">
                                <div class="notice notice-info">Arrange the items in the desired order.</div>
                                <ul class="list-group elements-list">
                                    <?php if(!empty($data['data']['elements']['elements'])): ?>
                                        <?php foreach ($data['data']['elements']['elements'] as $t): ?>
                                            <?php if($t == 'slider'): ?>
                                                <li class="list-group-item element-item" data-element="slider">Slider</li>
                                            <?php endif ?>
                                            <?php if($t == 'images'): ?>
                                                <li class="list-group-item element-item" data-element="images">Images</li>
                                            <?php endif ?>
                                            <?php if($t == 'video'): ?>
                                                <li class="list-group-item element-item" data-element="video">Video</li>
                                            <?php endif ?>
                                            <?php if($t == 'content'): ?>
                                                <li class="list-group-item element-item" data-element="content">Content</li>
                                            <?php endif ?>
                                            <?php if($t == 'form'): ?>
                                                <li class="list-group-item element-item" data-element="form">Form</li>
                                            <?php endif ?>
                                        <?php endforeach ?>
                                    <?php else: ?>
                                        <li class="list-group-item element-item" data-element="slider">Slider</li>
                                        <li class="list-group-item element-item" data-element="images">Images</li>
                                        <li class="list-group-item element-item" data-element="video">Video</li>
                                        <li class="list-group-item element-item" data-element="content">Content</li>
                                        <li class="list-group-item element-item" data-element="form">Form</li>
                                    <?php endif ?>
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
                                    <input id="slider-enable" type="checkbox" name="slider-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" <?php echo $data['data']['elements']['property']['slider-enable'] ? 'checked' : ''?>>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="images-enable">Display images</label>
                                    <p class="help-block">If unchecked, images will not be displayed.</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="images-enable" type="checkbox" name="images-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" <?php echo $data['data']['elements']['property']['images-enable'] ? 'checked' : ''?>>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="video-enable">Display video</label>
                                    <p class="help-block">If unchecked, the video will not be displayed</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="video-enable" type="checkbox" name="video-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" <?php echo $data['data']['elements']['property']['video-enable'] ? 'checked' : ''?>>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="content-enable">Display content</label>
                                    <p class="help-block">If unchecked, the content will not be displayed.</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="content-enable" type="checkbox" name="content-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" <?php echo $data['data']['elements']['property']['content-enable'] ? 'checked' : ''?>>
                                </td>
                            </tr>
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="form-enable">Display form</label>
                                    <p class="help-block">If unchecked, the form will not be displayed.</p>
                                </td>
                                <td class="col-md-6">
                                    <input id="form-enable" type="checkbox" name="form-enable" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker element-property-item" <?php echo $data['data']['elements']['property']['form-enable'] ? 'checked' : ''?>>
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