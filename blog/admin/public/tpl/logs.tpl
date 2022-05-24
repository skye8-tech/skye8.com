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
                            <li role="presentation" class="active"><a href="/admin/users/logs" role="tab">User actions</a></li>
                        </ul>

                        <div class="well well-sm">
                            <form id="search-form" class="form-group" role="search" action="/admin/users/search-event/" method="get">
                                <div class="input-group">
                                    <label class="control-label"></label>
                                    <input type="text" value="<?php echo $data['search'] ? $data['search'] : '' ?>" class="form-control" placeholder="Action search" name="search" id="search">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <?php if ($data['search'] && $data['count'] > 0): ?>
                            <div class="notice notice-success">Found <?php echo $data['count'] ?> action on request "<?php echo $data['search'] ?>"</div>
                        <?php elseif ($data['search']): ?>
                            <div class="notice notice-info">At your request "<?php echo $data['search'] ?>" nothing found</div>
                        <?php endif ?>

                        <?php if($data['count'] > 0): ?>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th class="">#</th>
                                        <th class="col-md-2">Login</th>
                                        <th class="col-md-2">Date</th>
                                        <th class="col-md-8">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="table-logs-body">
                                    <?php foreach($data['data'] as $t): ?>
                                        <tr id="logs-<?php echo $t['id'] ?>" class="logs-list active">
                                            <td>
                                                <?php echo $t['id'] ?>
                                            </td>
                                            <td>
                                                <?php if(!empty($t['login'])): ?>
                                                    <a class="label label-info" href="/admin/users/one/<?php echo $t['user'] ?>"><?php echo $t['login'] ?></a>
                                                <?php else: ?>
                                                    <span class="label label-warning">User deleted</span>
                                                <?php endif ?>
                                            </td>
                                            <td>
                                                <?php echo $t['time'] ?>
                                            </td>
                                            <td>
                                                <?php echo $t['event'] ?>
                                            </td>
                                        </tr>
                                    <?php endforeach ?>
                                    </tbody>
                                </table>
                            </div>

                            <?php if ($data['count'] > $data['limit']): ?>
                                <ul class="pagination" data-page-count="<?php echo $data['page-count'] ?>">
                                    <?php echo buildPagination($data) ?>
                                </ul>
                            <?php endif ?>
                        <?php elseif(isset($data['count'])): ?>
                            <div class="notice notice-warning">No action</div>
                        <?php else: ?>
                            <div class="notice notice-danger">Error getting data</div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>