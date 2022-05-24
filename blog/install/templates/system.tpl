<div class="panel panel-default">
    <div class="panel-heading"><strong>Minimum Script Requirements</strong></div>
    <div class="panel-body">
        <?php if(!isset($data['data'])): ?>
        <div class="notice notice-warning notice-flat">If any of these items is highlighted in red, then please follow the steps to correct the situation. In case of non-compliance with the minimum requirements of the script, its incorrect operation in the system is possible.</div>
        <ul class="list-group">
            <li class="list-group-item list-group-item-<?php echo $data['php-5-4'] ? 'success' : 'danger' ?>">PHP version 5.4 and higher (<?php echo $data['php-version'] ?>)</li>
            <li class="list-group-item list-group-item-<?php echo $data['curl'] ? 'success' : 'danger' ?>">PHP cURL extensions installed</li>
            <li class="list-group-item list-group-item-<?php echo $data['is-mysql'] ? 'success' : 'danger' ?>">MySQL support</li>
        </ul>
        <table class="table table-responsive">
            <tr>
                <th>Recommended settings</th>
                <th>Recommended value</th>
                <th>Present value</th>
            </tr>
            <tr class="<?php echo !$data['output-buffering'] ? 'success' : 'danger' ?>">
                <td>Output buffering</td>
                <td>Disable</td>
                <td><?php echo !$data['output-buffering'] ? 'Disable' : 'Enabled' ?></td>
            </tr>
            <tr class="<?php echo !$data['magic-quotes-runtime'] ? 'success' : 'danger' ?>">
                <td>Magic Quotes Runtime</td>
                <td>Disable</td>
                <td><?php echo !$data['magic-quotes-runtime'] ? 'Disable' : 'Enabled' ?></td>
            </tr>
            <tr class="<?php echo !$data['magic-quotes-gpc'] ? 'success' : 'danger' ?>">
                <td>Magic Quotes GPC</td>
                <td>Disable</td>
                <td><?php echo !$data['magic-quotes-gpc'] ? 'Disable' : 'Enabled' ?></td>
            </tr>
            <tr class="<?php echo !$data['register-globals'] ? 'success' : 'danger' ?>">
                <td>Register Globals</td>
                <td>Disable</td>
                <td><?php echo !$data['register-globals'] ? 'Disable' : 'Enabled' ?></td>
            </tr>
            <tr class="<?php echo !$data['session-auto-start'] ? 'success' : 'danger' ?>">
                <td>Session auto start</td>
                <td>Disable</td>
                <td><?php echo !$data['session-auto-start'] ? 'Disable' : 'Enabled' ?></td>
            </tr>
        </table>
            <?php if($data['php-5-4'] && $data['curl'] && $data['is-mysql']): ?>
                <div class="notice notice-success notice-flat">Verification completed successfully! You can continue the installation!</div>
                <div class="input-group-btn">
                    <input type="button" value="Продолжить" class="btn btn-success system-btn-next pull-right">
                </div>
            <?php else: ?>
                <?php if(!$data['php-5-4']): ?>
                    <div class="notice notice-danger notice-flat">
                        The script requires PHP 5.4 and higher.
                    </div>
                <?php endif ?>
                <?php if(!$data['curl']): ?>
                    <div class="notice notice-danger notice-flat">
                        Installed PHP cURL extensions
                    </div>
                <?php endif ?>
                <?php if(!$data['is-mysql']): ?>
                    <div class="notice notice-danger notice-flat">
                        The script requires MySQL support
                    </div>
                <?php endif ?>
            <?php endif ?>
        <?php else: ?>
        <div class="notice notice-danger notice-flat">Error getting data!</div>
        <?php endif ?>
    </div>
</div>