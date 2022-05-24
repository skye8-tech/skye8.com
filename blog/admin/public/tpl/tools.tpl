<?php function showOption($data){?>
    <?php foreach($data as $t): ?>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon <?php echo $t['active'] ? 'bg-blue-active' : 'bg-aqua' ?>">
                    <a href="<?php echo $t['url'] ?>" class="<?php echo $t['active'] ? 'active' : ''.' '.$t['class'] ?>">
                        <i class="<?php echo $t['icon'] ?>" style="color: white"></i>
                    </a>
                </span>
                <div class="info-box-content">
                    <span class="info-box-text"><?php echo $t['name'] ?></span>
                    <span class="info-box-number"><?php echo isset($t['badge']) ? $t['badge'] : '' ?></span>
                </div>
            </div>
        </div>
    <?php endforeach ?>
<?php } ?>

<?php if(!empty($data['data'])): ?>
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                <div class="box-header with-border">
                    <h3 class="box-title">Action bar </h3>
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
                    <div class="box-group" id="accordion">
                        <?php if($data['data']): ?>
                            <div class="panel box box-info">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse-option">
                                            <?php echo $data['title'] ?>
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-option" class="panel-collapse collapse in">
                                    <div class="box-body">
                                        <div class="row">
                                            <?php showOption($data['data']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <?php if(!empty($data['tags'])): ?>
                            <div class="panel box box-danger">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse-tags">
                                            Tags
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-tags" class="panel-collapse collapse">
                                    <div class="box-body">
                                        <?php foreach ($data['tags'] as $t): ?>
                                            <a class="label label-margin label-<?php echo ($t['id'] == $data['active'] && $data['filter'] == 'tag') ? 'primary' : 'info' ?>" href="/admin/content/tag/<?php echo $t['id'] ?>"><?php echo $t['name'] ?></a>
                                        <?php endforeach ?>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <?php if($data['design-edit']): ?>
                            <div class="panel box box-info">
                                <div class="box-header with-border">
                                    <h4 class="box-title">
                                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse-edit">
                                            Editor
                                        </a>
                                    </h4>
                                </div>
                                <div id="collapse-edit" class="panel-collapse collapse in">
                                    <div class="box-body">
                                        <div class="editor-file-list"></div>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif ?>