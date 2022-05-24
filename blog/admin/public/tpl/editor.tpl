<div class="row">
    <div class="col-md-12">
        <div class="box box-<?php echo $data['bg'] ?> panel-content" data-root-nav="templates">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $data['title'] ?></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" onclick="location.href = '/admin/templates/edit'">
                        <i class="fa fa-edit"></i>
                    </button>
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

                        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
                            <li role="presentation"><a href="/admin/templates" role="tab">Templates</a></li>
                            <li role="presentation" class="active"><a href="/admin/templates/edit " role="tab">Template editing</a></li>
                        </ul>

                        <?php if(!empty($data['data'])): ?>

                            <form id="templates-edit-form" action="" method="post">
                                <div class="table-responsive">
                                    <table class="table table-custom">
                                        <tr class="form-group">
                                            <td class="col-md-6">
                                                <label for="edit-template">Template</label>
                                                <p class="help-block">Choose a template for editing</p>
                                            </td>
                                            <td class="col-md-6">
                                                <?php if(!empty($data['data']['templates'])): ?>
                                                    <select id="edit-template" name="edit-template" class="form-control selectpicker show-tick">
                                                        <?php foreach ($data['data']['templates'] as $t): ?>
                                                            <option <?php echo $t == $data['data']['edit-template'] ? 'selected ' : '' ?> value="<?php echo $t ?>" data-icon="fa-paint-brush"><?php echo $t ?></option>
                                                        <?php endforeach ?>
                                                    </select>
                                                <?php else: ?>
                                                    <div class="notice notice-danger">No templates</div>
                                                <?php endif ?>
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <div class="notice notice-info editor-info">Template Editing: <?php echo $data['data']['edit-template'] ?> file:</div>
                                <div class="form-group">
                                    <label for="editor-area"></label>
                                    <textarea id="editor-area" class="editor-area"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="hidden" id="template" value="<?php echo $data['data']['edit-template'] ?>">
                                    <input type="hidden" id="patch" value="<?php echo $data['data']['patch'].$data['data']['edit-template'] ?>/">
                                    <input type="button" id="btn-save" value="Сохранить" class="btn btn-success btn-save"/>
                                </div>
                            </form>

                        <?php else: ?>
                            <div class="notice notice-danger">Error getting data</div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>