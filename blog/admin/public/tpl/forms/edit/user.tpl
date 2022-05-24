<div class="row">
    <div class="col-md-12">

        <?php if(!empty($data)): ?>

            <form id="user-form-edit" action="" method="post">
                <table class="table table-custom">
                    <?php if($data['data']['id'] != 1): ?>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="role">Role</label>
                            <p class="help-block">User role</p>
                        </td>
                        <td class="col-md-6">
                            <select id="role" name="role" data-live-search="true" class="form-control form-control-custom selectpicker show-tick">
                                <option value="0" data-icon="fa-user-secret" <?php echo $data['data']['role'] == 0 ?  'selected' : ''?>>Administrator</option>
                                <option value="1" data-icon="fa-user" <?php echo $data['data']['role'] == 1 ?  'selected' : ''?>>Users</option>
                            </select>
                        </td>
                    </tr>
                    <?php endif ?>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="login" class="control-label">Login</label>
                            <p class="help-block">User login</p>
                        </td>
                        <td class="col-md-6">
                            <input id="login" name="login" value="<?php echo $data['data']['login'] ?>" type="text"  placeholder="Login" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="name" class="control-label">Name</label>
                            <p class="help-block">User name</p>
                        </td>
                        <td class="col-md-6">
                            <input id="name" name="name" value="<?php echo $data['data']['name'] ?>" type="text"  placeholder="Name" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="email" class="control-label">Email</label>
                            <p class="help-block">User email</p>
                        </td>
                        <td class="col-md-6">
                            <input id="email" name="email" value="<?php echo $data['data']['email'] ?>" type="text" placeholder="Email" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="password" class="control-label">New password</label>
                            <p class="help-block">Leave the fields blank if you do not want to change the current password</p>
                        </td>
                        <td class="col-md-6">
                            <input id="password" name="password" value="" type="password" placeholder="Password" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="password" class="control-label">Repeat new password</label>
                            <p class="help-block">Retype new user password</p>
                        </td>
                        <td class="col-md-6">
                            <input id="password" name="password" value="" type="password" placeholder="Repeat new password" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <?php if($data['data']['id'] == 1): ?>
                        <tr class="form-group">
                            <td class="col-md-6">
                                <label for="super-password" class="control-label">Primary administrator password</label>
                                <p class="help-block">To edit the main administrator, you must enter his current password</p>
                            </td>
                            <td class="col-md-6">
                                <input id="super-password" name="super-password" value="" type="password" placeholder="Primary administrator password" class="form-control form-control-custom"/>
                            </td>
                        </tr>
                    <?php endif ?>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="status">Active</label>
                            <p class="help-block">If unchecked, the account will be inactive.</p>
                        </td>
                        <td class="col-md-6">
                            <input type='hidden' value='0' name='status'>
                            <input id="status" type="checkbox" name="status" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker" <?php echo $data['data']['status'] ? 'checked' : ''?>>
                        </td>
                    </tr>
                </table>
            </form>

        <?php else: ?>
            <div class="notice notice-danger">Error getting data</div>
        <?php endif ?>
    </div>
</div>