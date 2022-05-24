<div class="row">
    <div class="col-md-12">
        <div class="box box-primary panel-content" data-root-nav="report">

            <div class="box-header with-border">
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

            <div class="box-body box-cash">
                <div class="row">
                    <div class="col-md-12">

                        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
                            <li role="presentation" class="<?php echo $data['filter'] == '' ? 'active' : '' ?>">
                                <a href="/admin/report" role="tab">Indicators</a>
                            </li>
                        </ul>

                        <?php if($data['filter'] == ''): ?>
                            <div class="row">
                                <div class="col-md-12 report-storage-load">
                                    <div class="box box-danger">
                                        <div class="box-header">
                                            <h3 class="box-title">Count storage sizes</h3>
                                        </div>
                                        <div class="overlay">
                                            <i class="fa fa-refresh fa-spin" style="color: #dd4b39"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-12 report-chart-load">
                                    <div class="box box-info">
                                        <div class="box-header">
                                            <h3 class="box-title">Load charts</h3>
                                        </div>
                                        <div class="overlay">
                                            <i class="fa fa-refresh fa-spin" style="color: #00c0ef"></i>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 report-storage-info hidden">
                                    <div class="small-box bg-danger">
                                        <div class="inner">
                                            <h3 class="report-mysql-size" style="color: white"></h3>
                                            <p>Database size (mysql)</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-database"></i>
                                        </div>
                                        <div class="small-box-footer"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 report-storage-info hidden">
                                    <div class="small-box bg-warning">
                                        <div class="inner">
                                            <h3 class="report-images-size" style="color: white"></h3>

                                            <p>Image size</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-image"></i>
                                        </div>
                                        <div class="small-box-footer"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 report-storage-info hidden">
                                    <div class="small-box bg-yellow">
                                        <div class="inner">
                                            <h3 class="report-thumbnails-size" style="color: white"></h3>

                                            <p>Thumbnail size</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-file-image-o"></i>
                                        </div>
                                        <div class="small-box-footer"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 report-storage-info hidden">
                                    <div class="small-box bg-aqua">
                                        <div class="inner">
                                            <h3 class="report-uploads-size" style="color: white"></h3>

                                            <p>Size of uploaded files</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-download"></i>
                                        </div>
                                        <div class="small-box-footer"></div>
                                    </div>
                                </div>
                                <div class="col-lg-3 col-md-3 col-sm-12 col-xs-12 report-storage-info hidden">
                                    <div class="small-box bg-info">
                                        <div class="inner">
                                            <h3 class="report-cache-size" style="color: white"></h3>

                                            <p>Cache size</p>
                                        </div>
                                        <div class="icon">
                                            <i class="fa fa-hdd-o"></i>
                                        </div>
                                        <div class="small-box-footer"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 hidden-xs hidden-sm">
                                <canvas id="chart-visits" style="max-width: 100%"></canvas>
                            </div>
                            <div class="col-md-6 hidden-xs hidden-sm">
                                <canvas id="chart-actions-all" style="max-width: 100%"></canvas>
                            </div>
                            <div class="col-md-6 hidden-xs hidden-sm">
                                <canvas id="chart-actions-user" style="max-width: 100%"></canvas>
                            </div>
                            <div class="col-md-12">
                                <div class="notice notice-warning notice-flat hidden-md hidden-lg">
                                    Chart display not available on mobile device
                                </div>
                            </div>
                        <?php endif ?>

                    </div>
                </div>
            </div>

        </div>
    </div>
</div>