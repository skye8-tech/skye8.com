<div class="row">
    <div class="col-md-12">
        <div class="box box-<?php echo $data['bg'] ?> panel-content" data-root-nav="statistics">
            <div class="box-header with-border hidden-xs hidden-sm">
                <h3 class="box-title"><?php echo $data['title'] ?></h3>

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
                        <canvas id="canvas" style="max-width: 100%" class="hidden-xs hidden-sm"></canvas>
                        <div class="notice notice-warning notice-flat hidden-md hidden-lg">
                            Chart display not available on mobile device
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>