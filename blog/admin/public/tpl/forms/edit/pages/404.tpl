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

            <form id="page-not-found-form-edit">
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="main-tab">
                        <table class="table table-custom">
                            <tr class="form-group">
                                <td class="col-md-6">
                                    <label for="icon" class="control-label">Page Icon</label>
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
                                            <input value="<?php echo $t['title'] ?>" placeholder="Заголовок" class="form-control slid-title">
                                            <textarea placeholder="Text" class="form-control slid-text" style="resize:vertical"><?php echo $t['text'] ?></textarea>
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
                            <label for="editor-area"></label>
                            <input value="" type="text" placeholder="Paste the link to the video, click add" class="form-control form-control-custom video-url-input"/>
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
                            <div class="panel-heading">The order of output elements</div>
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