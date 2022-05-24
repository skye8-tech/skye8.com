<div class="row">
    <div class="col-md-12">
        <div class="box box-<?php echo $data['bg'] ?> panel-content" data-root-nav="search">
            <div class="box-body">
                <div class="row">
                    <div class="col-md-12">
                        <?php if($data['search']): ?>
                            <?php if($data['data']['content-count'] > 0): ?>
                                <div class="box-group" id="accordion">
                                    <div class="panel box box-info">
                                        <div class="box-header with-border">
                                            <h4 class="box-title">
                                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse-goods">
                                                    Found <?php echo $data['data']['content-count'] ?> records by request "<?php echo $data['search'] ?>"
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="collapse-goods" class="panel-collapse collapse">
                                            <div class="box-body">
                                                <div class="notice notice-success notice-flat">Found <?php echo $data['data']['content-count'] ?> records by request "<?php echo $data['search'] ?>"</div>

                                                <form id="list-content-form" method="post">
                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th class="">#</th>
                                                                <th class="col-md-9">Header</th>
                                                                <th class="col-md-2">Categories</th>
                                                                <th class="col-md-1">Tags</th>
                                                                <th class="">Added by</th>
                                                                <th class=""><span class="fa fa-eye"></span></th>
                                                                <th class=""><span class="fa fa-comment"></span></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody class="table-content-body">
                                                        <?php foreach($data['data']['content-data'] as $t): ?>
                                                            <tr id="content-<?php echo $t['id'] ?>-<?php echo $t['position'] ?>" class="content-list <?php echo $t['status'] ? 'active' : 'info' ?>">
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
                                                            </tr>
                                                        <?php endforeach ?>
                                                        </tbody>
                                                    </table>
                                                </form>

                                                <a class="btn btn-info col-xs-12 col-sm-12 col-md-12 col-lg-12" href="/admin/content/search/?search=<?php echo $data['search'] ?>">All records search results</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif ?>
                            <?php if($data['data']['content-count'] == 0): ?>
                                <div class="well well-sm">
                                    <form id="search-form" class="form-group" role="search" action="/admin/search/" method="get">
                                        <div class="input-group">
                                            <label class="control-label"></label>
                                            <input type="text" value="<?php echo $data['search'] ? $data['search'] : '' ?>" class="form-control" placeholder="Search" name="search" id="search">
                                            <div class="input-group-btn">
                                                <button class="btn btn-default btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="notice notice-info">At your request "<?php echo $data['search'] ?>" nothing found</div>
                            <?php endif ?>
                        <?php else: ?>
                            <div class="well well-sm">
                                <form id="search-form" class="form-group" role="search" action="/admin/search/" method="get">
                                    <div class="input-group">
                                        <label class="control-label"></label>
                                        <input type="text" value="<?php echo $data['search'] ? $data['search'] : '' ?>" class="form-control" placeholder="Search" name="search" id="search">
                                        <div class="input-group-btn">
                                            <button class="btn btn-default btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>