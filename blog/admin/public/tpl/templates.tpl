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
                            <li role="presentation" class="active"><a href="/admin/templates" role="tab">Templates</a></li>
                            <li role="presentation"><a href="/admin/templates/edit " role="tab">Template editing</a></li>
                        </ul>

                        <?php if(!empty($data['data'])): ?>

                            <form id="templates-form" action="" method="post">
                                <table class="table table-custom">
                                    <tr class="form-group">
                                        <td class="col-md-6">
                                            <label for="template">Template</label>
                                            <p class="help-block">Installs a site template</p>
                                        </td>
                                        <td class="col-md-6">
                                            <?php if(!empty($data['data']['templates'])): ?>
                                                <select id="template" name="template" class="form-control selectpicker show-tick">
                                                    <?php foreach ($data['data']['templates'] as $t): ?>
                                                        <option <?php echo $t == $data['data']['template'] ? 'selected ' : '' ?> value="<?php echo $t ?>" data-icon="fa-paint-brush"><?php echo $t ?></option>
                                                    <?php endforeach ?>
                                                </select>
                                            <?php else: ?>
                                                <div class="notice notice-danger">No templates</div>
                                            <?php endif ?>
                                        </td>
                                    </tr>
                                </table>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Save</button>
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