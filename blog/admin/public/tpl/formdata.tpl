<div class="row">
    <div class="col-md-12">
        <div class="box box-<?php echo $data['bg'] ?> panel-content" data-root-nav="formdata">
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
                            <form id="search-form" class="form-group" role="search" action="/admin/formdata/search/" method="get">
                                <div class="input-group">
                                    <label class="control-label"></label>
                                    <input type="text" value="<?php echo $data['search'] ? $data['search'] : '' ?>" class="form-control" placeholder="Data search" name="search" id="search">
                                    <div class="input-group-btn">
                                        <button class="btn btn-default btn-search" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <?php if ($data['search'] && $data['count'] > 0): ?>
                            <div class="notice notice-success">Found <?php echo $data['count'] ?> data on request "<?php echo $data['search'] ?>"</div>
                        <?php elseif ($data['search']): ?>
                            <div class="notice notice-info">At your request "<?php echo $data['search'] ?>" nothing found</div>
                        <?php endif ?>

                        <?php if($data['count'] > 0): ?>

                            <form id="list-formdata-form" method="post">
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
                                            <th class="col-md-9">Page</th>
                                            <th class="col-md-2">Date</th>
                                            <th class="">Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody class="table-formdata-body">
                                        <?php foreach($data['data'] as $t): ?>
                                            <tr id="formdata-<?php echo $t['id'] ?>-<?php echo $t['position'] ?>" class="formdata-list <?php echo $t['status'] ? 'active' : 'success' ?>">
                                                <td>
                                                    <i class="fa fa-bars cursor-move"></i>
                                                </td>
                                                <td>
                                                    <input type="checkbox" name="id[]" value="<?php echo $t['id'] ?>"/>
                                                </td>
                                                <td>
                                                    <a class="label label-info" href="/admin/formdata/one/<?php echo $t['id'] ?>"><?php echo $t['id'] ?></a>
                                                </td>
                                                <td>
                                                    <?php echo $t['page'] ?>
                                                </td>
                                                <td>
                                                    <?php echo $t['time'] ?>
                                                </td>
                                                <td>
                                                    <div class="formdata-action action-btn pull-right">
                                                        <div class="formdata-view" data-toggle="tooltip" data-placement="top" title="View"><span class="fa fa-eye"></span></div>
                                                        <div class="formdata-delete" data-toggle="tooltip" data-placement="top" title="Delete"><span class="fa fa-trash"></span></div>
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
                                        <option value="delete" data-icon="fa-trash">Delete</option>
                                    </select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-formdata-checkbox" type="button">To apply</button>
                                    </span>
                                </div>
                            </form>
                            <?php if ($data['count'] > $data['limit']): ?>
                                <ul class="pagination" data-page-count="<?php echo $data['page-count'] ?>">
                                    <?php echo buildPagination($data) ?>
                                </ul>
                            <?php endif ?>
                        <?php elseif(isset($data['count'])): ?>
                            <div class="notice notice-warning">No data</div>
                        <?php else: ?>
                            <div class="notice notice-danger">Error getting data</div>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>