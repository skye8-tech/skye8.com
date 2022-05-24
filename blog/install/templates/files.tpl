<div class="panel panel-primary">
    <div class="panel-heading"><strong>Checking important system files</strong></div>
    <div class="panel-body">
        <?php if(!isset($data['data'])): ?>
            <div class="notice notice-warning notice-flat">If any of these items is highlighted in red, then please follow the steps to correct the situation.</div>

            <table class="table table-responsive">
                <tr>
                    <th>File</th>
                    <th>Write</th>
                    <th>CHMOD</th>
                </tr>

                <?php foreach($data['files'] as $t): ?>
                    <tr class="<?php echo $t['error'] ? 'danger' : 'success' ?>">
                        <td><?php echo $t['file'] ?></td>
                        <td><?php echo $t['text'] ?></td>
                        <td><?php echo $t['chmod'] ?></td>
                    </tr>
                <?php endforeach ?>
            </table>

            <?php if(!$data['not-found-error'] && !$data['chmod-error']): ?>
                <div class="notice notice-success notice-flat">Verification completed successfully! You can continue the installation!</div>
                <div class="input-group-btn">
                    <input type="button" value="Продолжить" class="btn btn-success files-btn-next pull-right">
                </div>
            <?php else: ?>
                <?php if($data['chmod-error']): ?>
                    <div class="notice notice-danger notice-flat">
                        <strong>Attention!!!</strong> Errors detected during verification! Writing to a file is forbidden. <br /> You must set it for the CHMOD 777 directories, for the CHMOD 666 files using the FTP client. <br /> Installation will be unavailable until changes are made.
                    </div>
                <?php endif ?>
                <?php if($data['not-found-error']): ?>
                    <div class="notice notice-danger notice-flat">
                        <strong>Attention !!! </strong> Errors were detected during the verification! No files or directories found !. <br /> Download missing files and directories using FTP client. <br /> Installation will not be available until changes are made.
                    </div>
                <?php endif ?>
            <?php endif ?>
        <?php else: ?>
            <div class="notice notice-danger notice-flat">Error getting data!</div>
        <?php endif ?>
        </div>
</div>
