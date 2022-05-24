<div class="row">
    <div class="col-md-12">
        <div class="box box-<?php echo $data['bg'] ?> panel-content" data-root-nav="pages">
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
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">

                        <div class="well well-sm">
                            <div class="input-group">
                                <label class="control-label"></label>
                                <input type="text" value="" placeholder="Page search" class="form-control pages-search"/>
                                <div class="input-group-btn">
                                    <button class="btn btn-default btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group btn-group-justified pages-action">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm pages-descendant" data-toggle="dropdown" data-placement="top" title="Создать потомка" id="page-add-dropdown" aria-haspopup="true" aria-expanded="true" disabled ><i class="glyphicon glyphicon glyphicon-plus"></i></button>
                                <ul class="pages-descendant-action dropdown-menu" aria-labelledby="page-add-dropdown">
                                    <li><a class="pages-descendant-page" href="#">Page</a></li>
                                    <li><a class="pages-descendant-gallery" href="#">Gallery</a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm pages-enable" data-toggle="tooltip" data-placement="top" title="Activate" disabled><i class="glyphicon glyphicon-eye-open"></i></button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm pages-disable" data-toggle="tooltip" data-placement="top" title="Deactivate" disabled><i class="glyphicon glyphicon-eye-close"></i></button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm pages-edit" data-toggle="tooltip" data-placement="top" title="Edit"  disabled><i class="glyphicon glyphicon-pencil"></i></button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm pages-delete" data-toggle="tooltip" data-placement="top" title="Delete" disabled><i class="glyphicon glyphicon-trash"></i></button>
                            </div>
                        </div>
                        <div class="notice notice-warning pages-not-found hidden">No pages!</div>
                        <div class="pages-tree-list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>