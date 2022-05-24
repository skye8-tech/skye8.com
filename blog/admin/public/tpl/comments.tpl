<div class="row">
    <div class="col-md-12">
        <div class="box box-<?php echo $data['bg'] ?> panel-content" data-root-nav="news">
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

                        <ul class="nav nav-tabs" role="tablist" style="margin-bottom: 10px;">
                            <li role="presentation"><a href="/admin/content" role="tab">Posts</a></li>
                            <li role="presentation"><a href="/admin/category" role="tab">Categories</a></li>
                            <li role="presentation"><a href="/admin/tags" role="tab">Tags</a></li>
                            <li role="presentation" class="active"><a href="/admin/comments" role="tab">Comments</a></li>
                        </ul>

                        <div class="well well-sm">
                            <form id="search-form" class="form-group" role="search" action="/admin/comments/search/" method="get">
                                <div class="input-group">
                                    <label class="control-label"></label>
                                    <input type="text" class="form-control" placeholder="Search for comments" name="search" id="search">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <?php if ($data['search'] && $data['count'] > 0): ?>
                            <div class="notice notice-success">Found <?php echo $data['count'] ?> comments on request "<?php echo $data['search'] ?>"</div>
                        <?php elseif ($data['search']): ?>
                            <div class="notice notice-info">At your request "<?php echo $data['search'] ?>" nothing found</div>
                        <?php endif ?>

                        <?php if($data['count'] > 0): ?>

                            <form id="list-comments-form" method="post">
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
                                                <th class="col-md-4">Comment</th>
                                                <th class="col-md-2">Name</th>
                                                <th class="col-md-2">Email</th>
                                                <th class="col-md-2">Date</th>
                                                <th class="col-md-2">User</th>
                                                <th class="">Answer</th>
                                                <th class="">Post</th>
                                                <th class=""><span class="fa fa-map-marker"></span></th>
                                                <th class="">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-comments-body">
                                        <?php foreach($data['data'] as $t): ?>
                                            <tr id="comments-<?php echo $t['id'] ?>-<?php echo $t['position'] ?>" class="comments-list <?php echo $t['status'] ? 'success' : 'warning' ?>">
                                                <td>
                                                    <i class="fa fa-bars cursor-move"></i>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="id[]" value="<?php echo $t['id'] ?>"/>
                                                </td>
                                                <td>
                                                    <a class="label label-info" href="/admin/comments/one/<?php echo $t['id'] ?>"><?php echo $t['id'] ?></a>
                                                </td>
                                                <td>
                                                    <?php echo $t['comment'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $t['name'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $t['email'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $t['time'] ?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($t['login'])): ?>
                                                        <a class="label label-info" href="/admin/users/one/<?php echo $t['user'] ?>"><?php echo $t['login'] ?></a>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($t['reply'])): ?>
                                                        <a class="label label-info" href="/admin/comments/one/<?php echo $t['reply'] ?>"><?php echo $t['reply'] ?></a>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <a class="label label-info" href="/admin/content/one/<?php echo $t['content'] ?>"><?php echo $t['content'] ?></a>
                                                </td>
                                                <td>
                                                    <span class="view-location fa fa-eye cursor-pointer" data-ip="<?php echo $t['ip'] ?>"></span>
                                                </td>
                                                <td>
                                                    <div class="comment-action action-btn pull-right">
                                                        <div class="comment-edit" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-edit"></span></div>
                                                        <?php if($t['status'] == 1): ?>
                                                            <div class="comment-update-status-on" data-toggle="tooltip" data-placement="top" title="Hide from site"><span class="fa fa-toggle-on"></span></div>
                                                        <?php else: ?>
                                                            <div class="comment-update-status-off" data-toggle="tooltip" data-placement="top" title="Post to website"><span class="fa fa-toggle-off"></span></div>
                                                        <?php endif ?>
                                                        <div class="comment-delete" data-toggle="tooltip" data-placement="top" title="Delete"><span class="fa fa-trash"></span></div>
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
                                        <button class="btn btn-default btn-comments-checkbox" type="button">To apply</button>
                                    </span>
                                </div>
                            </form>
                            <?php if ($data['count'] > $data['limit']): ?>
                                <ul class="pagination" data-page-count="<?php echo $data['page-count'] ?>">
                                    <?php echo buildPagination($data) ?>
                                </ul>
                            <?php endif ?>
                        <?php elseif(isset($data['count'])): ?>
                            <div class="notice notice-warning">No comments</div>
                        <?php else: ?>
                            <div class="notice notice-danger">Error getting data</div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>