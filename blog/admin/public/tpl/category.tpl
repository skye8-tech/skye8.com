<div class="row">
    <div class="col-md-12">
        <div class="box box-<?php echo $data['bg'] ?> panel-content" data-root-nav="content">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $data['title'] ?></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" onclick="categoryAdd()">
                        <i class="fa fa-plus-circle"></i>
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
                            <li role="presentation"><a href="/admin/content" role="tab">Posts</a></li>
                            <li role="presentation" class="active"><a href="/admin/category" role="tab">Categories</a></li>
                            <li role="presentation"><a href="/admin/tags" role="tab">Tags</a></li>
                            <li role="presentation"><a href="/admin/comments" role="tab">Comments</a></li>
                        </ul>

                        <div class="well well-sm">
                            <div class="input-group">
                                <label class="control-label"></label>
                                <input type="text" value="" placeholder="Category search" class="form-control category-search"/>
                                <div class="input-group-btn">
                                    <button class="btn btn-default btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                </div>
                            </div>
                        </div>

                        <div class="btn-group btn-group-justified category-action">
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm category-descendant" data-toggle="tooltip" data-placement="top" title="Create descendant" disabled><i class="glyphicon glyphicon glyphicon-plus"></i></button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm category-enable" data-toggle="tooltip" data-placement="top" title="Activate" disabled><i class="glyphicon glyphicon-eye-open"></i></button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm category-disable" data-toggle="tooltip" data-placement="top" title="Deactivate" disabled><i class="glyphicon glyphicon-eye-close"></i></button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm category-edit" data-toggle="tooltip" data-placement="top" title="Edit"  disabled><i class="glyphicon glyphicon-pencil"></i></button>
                            </div>
                            <div class="btn-group">
                                <button type="button" class="btn btn-sm category-delete" data-toggle="tooltip" data-placement="top" title="Delete" disabled><i class="glyphicon glyphicon-trash"></i></button>
                            </div>
                        </div>
                        <div class="notice notice-warning category-not-found hidden">No categories!</div>
                        <div class="category-tree-list"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>