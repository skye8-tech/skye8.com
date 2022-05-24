<div class="row">
    <div class="col-md-12">
        <div class="box box-<?php echo $data['bg'] ?> panel-content" data-root-nav="content">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $data['title'] ?></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" onclick="contentAdd()">
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
                            <li role="presentation" class="active"><a href="/admin/content" role="tab">Posts</a></li>
                            <li role="presentation"><a href="/admin/category" role="tab">Categories</a></li>
                            <li role="presentation"><a href="/admin/tags" role="tab">Tags</a></li>
                            <li role="presentation"><a href="/admin/comments" role="tab">Comments</a></li>
                        </ul>

                        <div class="well well-sm">
                            <form id="search-form" class="form-group" role="search" action="/admin/content/search/" method="get">
                                <div class="input-group">
                                    <label class="control-label"></label>
                                    <input type="text" value="<?php echo $data['search'] ? $data['search'] : '' ?>" class="form-control" placeholder="Search posts" name="search" id="search">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <?php if ($data['search'] && $data['count'] > 0): ?>
                            <div class="notice notice-success">Found <?php echo $data['count'] ?> records by request "<?php echo $data['search'] ?>"</div>
                        <?php elseif ($data['search']): ?>
                            <div class="notice notice-info">At your request "<?php echo $data['search'] ?>" nothing found</div>
                        <?php endif ?>

                        <?php if($data['count'] > 0): ?>

                            <form id="list-content-form" method="post">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="">
                                                <i class="glyphicon glyphicon-sort"></i>
                                            </th>
                                            <th class="">
                                                <i class="glyphicon glyphicon-check"></i>
                                            </th>
                                            <th class="">#</th>
                                            <th class="col-md-7">Header</th>
                                            <th class="col-md-2">Categories</th>
                                            <th class="col-md-1">Tags</th>
                                            <th class="col-md-1">Added by</th>
                                            <th class=""><span class="fa fa-eye"></span></th>
                                            <th class=""><span class="fa fa-comment"></span></th>
                                            <th class="col-md-7">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-content-body">
                                        <?php foreach($data['data'] as $t): ?>
                                            <tr id="content-<?php echo $t['id'] ?>-<?php echo $t['position'] ?>" class="content-list <?php echo $t['status'] ? 'active' : 'info' ?>">
                                                <td>
                                                    <i class="fa fa-bars cursor-move"></i>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="id[]" value="<?php echo $t['id'] ?>"/>
                                                </td>
                                                <td>
                                                    <a class="label label-info" href="/admin/content/one/<?php echo $t['id'] ?>"><?php echo $t['id'] ?></a>
                                                </td>
                                                <td><?php echo $t['header'] ?></td>
                                                <td>
                                                    <?php if(isset($t['category-data'])): ?>
                                                        <?php foreach ($t['category-data'] as $v): ?>
                                                            <a class="label label-success label-margin" href="/admin/content/category/<?php echo $v['id'] ?>"><?php echo $v['name'] ?></a>
                                                        <?php endforeach ?>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <?php if(isset($t['tags-data'])): ?>
                                                        <?php foreach ($t['tags-data'] as $v): ?>
                                                            <a class="label label-primary label-margin" href="/admin/tags/one/<?php echo $v['id'] ?>"><?php echo $v['name'] ?></a>
                                                        <?php endforeach ?>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($t['login'])): ?>
                                                        <a class="label bg-teal-gradient" href="/admin/users/one/<?php echo $t['user'] ?>"><?php echo $t['login'] ?></a>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <span class="label label-primary"><?php echo $t['views'] ?></span>
                                                </td>
                                                <td>
                                                    <a class="label label-primary" href="/admin/comments/content/<?php echo $t['id'] ?>"><?php echo $t['comments'] ?></a>
                                                </td>
                                                <td>
                                                    <div class="content-action action-btn pull-right">
                                                        <div class="content-edit" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-edit"></span></div>
                                                        <?php if($t['status'] == 1): ?>
                                                            <div class="content-update-status-on" data-toggle="tooltip" data-placement="top" title="Hide from site"><span class="fa fa-toggle-on"></span></div>
                                                        <?php else: ?>
                                                            <div class="content-update-status-off" data-toggle="tooltip" data-placement="top" title="Post to website"><span class="fa fa-toggle-off"></span></div>
                                                        <?php endif ?>
                                                        <div class="content-delete" data-toggle="tooltip" data-placement="top" title="Delete"><span class="fa fa-trash"></span></div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach ?>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        <input type="checkbox" class="select-all">
                                    </span>
                                    <select name="select-action" class="form-control selectpicker show-tick">
                                        <option value="enable" data-icon="fa-eye">Publish</option>
                                        <option value="disable" data-icon="fa-eye-slash">Hide</option>
                                        <option value="delete" data-icon="fa-trash">Delete</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-content-checkbox" type="button">To apply</button>
                                    </span>
                                </div>
                            </form>
                            <?php if ($data['count'] > $data['limit']): ?>
                                <ul class="pagination" data-page-count="<?php echo $data['page-count'] ?>">
                                    <?php echo buildPagination($data) ?>
                                </ul>
                            <?php endif ?>
                        <?php elseif(isset($data['count'])): ?>
                            <div class="notice notice-warning">No entries</div>
                        <?php else: ?>
                            <div class="notice notice-danger">Error getting data</div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>