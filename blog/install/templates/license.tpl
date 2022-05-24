<div class="panel panel-primary">
    <div class="panel-heading"><strong>License agreement</strong></div>
    <div class="panel-body">
        <?php if(!isset($data['data'])): ?>
        <form id="license-form" action="" method="post">
            <div class="form-group">
                <textarea class="form-control" rows="40" style="font-size: 12px;"><?php echo $data['license-text'] ?></textarea>
            </div>
            <div class="form-group">
                <label for="license">I accept this agreement</label>
                <input id="license" type="checkbox" name="license" value="1">
                <input type="button" value="Продолжить" class="btn btn-success license-btn-next pull-right" disabled/>
            </div>
        </form>
        <?php else: ?>
        <div class="notice notice-danger notice-flat">Error getting data!</div>
        <?php endif ?>
    </div>
</div>