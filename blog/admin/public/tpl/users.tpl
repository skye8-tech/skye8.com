<div class="row">
    <div class="col-md-12">
        <div class="box box-<?php echo $data['bg'] ?> panel-content" data-root-nav="user">
            <div class="box-header with-border">
                <h3 class="box-title"><?php echo $data['title'] ?></h3>

                <div class="box-tools pull-right">
                    <button type="button" class="btn btn-box-tool" onclick="userAdd()">
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
                            <li role="presentation" class="<?php echo $data['role'] == 1 ? 'active' : '' ?>"><a href="/admin/users/" role="tab">Users</a></li>
                            <li role="presentation" class="<?php echo $data['role'] == 0 ? 'active' : '' ?>"><a href="/admin/users/admin/" role="tab">Administrators</a></li>
                            <li role="presentation"><a href="/admin/users/logs" role="tab">User actions</a></li>
                        </ul>

                        <div class="well well-sm">
                            <form id="search-form" class="form-group" role="search" action="/admin/users/search/" method="get">
                                <div class="input-group">
                                    <label class="control-label"></label>
                                    <input type="text" value="<?php echo $data['search'] ? $data['search'] : '' ?>" class="form-control" placeholder="User search" name="search" id="search">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <?php if ($data['search'] && $data['count'] > 0): ?>
                            <div class="notice notice-success">Found <?php echo $data['count'] ?> users on request "<?php echo $data['search'] ?>"</div>
                        <?php elseif ($data['search']): ?>
                            <div class="notice notice-info">At your request "<?php echo $data['search'] ?>" nothing found</div>
                        <?php endif ?>

                        <?php if($data['count'] > 0): ?>

                            <form id="list-users-form" method="post">
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                        <tr>
                                            <th class="">
                                                <i class="glyphicon glyphicon-check"></i>
                                            </th>
                                            <th class="">#</th>
                                            <th class="col-md-2">Login</th>
                                            <th class="col-md-2">Name</th>
                                            <th class="col-md-2">Email</th>
                                            <th class="col-md-2">Status</th>
                                            <th class="col-md-2">Registration date</th>
                                            <th class="">Posts</th>
                                            <th class="">Comments</th>
                                            <th class="col-md-2">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-users-body">
                                        <?php foreach($data['data'] as $t): ?>
                                            <tr id="users-<?php echo $t['id'] ?>" class="users-list <?php echo $t['status'] == 1 ? 'success' : 'warning' ?>">
                                                <td>
                                                    <?php if($t['id'] != 1): ?>
                                                        <input type="checkbox" name="id[]" value="<?php echo $t['id'] ?>"/>
                                                    <?php else: ?>
                                                        <span class="fa fa-ban"
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <a class="label label-info" href="/admin/users/one/<?php echo $t['id'] ?>"><?php echo $t['id'] ?></a>
                                                </td>
                                                <td>
                                                    <?php echo $t['login'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $t['name'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $t['email'] ? $t['email'] : '-' ?>
                                                </td>
                                                <td>
                                                    <a class="label label-primary" href="/admin/users/<?php echo $t['role'] ? '' : 'admin' ?>">
                                                        <?php if($t['id'] == 1): ?>
                                                            Chief administrator
                                                        <?php else: ?>
                                                            <?php if($t['role'] == 0): ?>
                                                                Administrator
                                                            <?php elseif($t['role'] == 1): ?>
                                                                User
                                                            <?php endif ?>
                                                        <?php endif ?>
                                                    </a>
                                                </td>
                                                <td>
                                                    <?php echo $t['time'] ? $t['time'] : '-' ?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($t['content'])): ?>
                                                        <a class="label label-info" href="/admin/content/user/<?php echo $t['id'] ?>"><?php echo $t['content'] ?></a>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <?php if(!empty($t['comments'])): ?>
                                                        <a class="label label-info" href="/admin/comments/user/<?php echo $t['id'] ?>"><?php echo $t['comments'] ?></a>
                                                    <?php else: ?>
                                                        -
                                                    <?php endif ?>
                                                </td>
                                                <td>
                                                    <div class="user-action action-btn pull-right">
                                                        <div class="user-edit" data-toggle="tooltip" data-placement="top" title="Edit"><span class="fa fa-edit"></span></div>
                                                        <?php if($t['id'] != 1): ?>
                                                            <div class="user-update-role-admin" data-toggle="tooltip" data-placement="top" title="To administrators"><span class="fa fa-user-secret"></span></div>
                                                            <div class="user-update-role-user" data-toggle="tooltip" data-placement="top" title="To users"><span class="fa fa-user"></span></div>
                                                            <?php if($t['status'] == 1): ?>
                                                                <div class="user-update-status-on" data-toggle="tooltip" data-placement="top" title="Disconnect user"><span class="fa fa-toggle-on"></span></div>
                                                            <?php else: ?>
                                                                <div class="user-update-status-off" data-toggle="tooltip" data-placement="top" title="Enable user"><span class="fa fa-toggle-off"></span></div>
                                                            <?php endif ?>
                                                            <div class="user-delete" data-toggle="tooltip" data-placement="top" title="Delete"><span class="fa fa-trash"></span></div>
                                                        <?php endif ?>
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
                                        <option value="admin" data-icon="fa-user-secret">Make administrator</option>
                                        <option value="user" data-icon="fa-user">Make users</option>
                                        <option value="delete" data-icon="fa-trash">Delete</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-users-checkbox" type="button">To apply</button>
                                    </span>
                                </div>
                            </form>
                            <?php if ($data['count'] > $data['limit']): ?>
                                <ul class="pagination" data-page-count="<?php echo $data['page-count'] ?>">
                                    <?php echo buildPagination($data) ?>
                                </ul>
                            <?php endif ?>
                        <?php elseif(isset($data['count'])): ?>
                            <div class="notice notice-warning">No users</div>
                        <?php else: ?>
                            <div class="notice notice-danger">Error getting data</div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>