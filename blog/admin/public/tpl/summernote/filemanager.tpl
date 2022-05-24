<div class="row">
    <div class="col-md-12">
        <div class="img-zone text-center" id="editor-drag-zone">
            <div class="img-drop">
                <div class="inline-text"><img src="/admin/public/img/drag-and-drop.png" alt=""></span></div>
                <span class="btn btn-default editor-btn-images-upload btn-file">Open file manager<input type="file" multiple="" accept="image/*" class="input-file"></span>
            </div>
        </div>
        <div class="progress editor-progress-images hidden">
            <div class="progress-bar progress-bar-primary progress-bar-striped active" role="progressbar" aria-valuenow="45" aria-valuemin="0" aria-valuemax="100" style="width: 100%"></div>
        </div>
        <div class="row editor-images-preview">
            <?php if(!empty($data)): ?>
                <?php foreach($data as $t): ?>
                    <div class="col-sm-4">
                        <div id="<?php echo $t ?>" class="image-item thumbnail action-btn">
                            <img src="/files/uploads/<?php echo $t ?>" alt="" class="img-responsive">
                            <div class="editor-image-delete" data-toggle="tooltip" data-placement="top" title="Delete">
                                <span class="fa fa-trash"></span>
                            </div>
                            <div class="editor-image-insert pull-right" data-toggle="tooltip" data-placement="top" title="Paste">
                                <span class="fa fa-plus"></span>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
        <div class="editor-image-item-html hidden">
            <div class="col-sm-4">
                <div id="" class="image-item thumbnail action-btn">
                    <img src="" alt="" class="img-responsive">
                    <div class="editor-image-delete" data-toggle="tooltip" data-placement="top" title="Delete">
                        <span class="fa fa-trash"></span>
                    </div>
                    <div class="editor-image-insert pull-right" data-toggle="tooltip" data-placement="top" title="Paste">
                        <span class="fa fa-plus"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>