<div class="row">
    <div class="col-md-12">
        <form id="user-form-add" action="" method="post">
            <table class="table table-custom">
                <tr class="form-group">
                    <td class="col-md-6">
                        <label for="role">Role</label>
                        <p class="help-block">User role</p>
                    </td>
                    <td class="col-md-6">
                        <select id="role" name="role" data-live-search="true" class="form-control form-control-custom selectpicker show-tick">
                            <option value="0" data-icon="fa-user-secret">Administrator</option>
                            <option value="1" data-icon="fa-user" selected>Users</option>
                        </select>
                    </td>
                </tr>
                <tr class="form-group">
                    <td class="col-md-6">
                        <label for="login" class="control-label">Login</label>
                        <p class="help-block">User login</p>
                    </td>
                    <td class="col-md-6">
                        <input id="login" name="login" value="" type="text"  placeholder="Login" class="form-control form-control-custom"/>
                    </td>
                </tr>
                <tr class="form-group">
                    <td class="col-md-6">
                        <label for="name" class="control-label">Name</label>
                        <p class="help-block">User name</p>
                    </td>
                    <td class="col-md-6">
                        <input id="name" name="name" value="" type="text"  placeholder="Name" class="form-control form-control-custom"/>
                    </td>
                </tr>
                <tr class="form-group">
                    <td class="col-md-6">
                        <label for="email" class="control-label">Email</label>
                        <p class="help-block">User email</p>
                    </td>
                    <td class="col-md-6">
                        <input id="email" name="email" value="" type="text" placeholder="Email" class="form-control form-control-custom"/>
                    </td>
                </tr>
                <tr class="form-group">
                    <td class="col-md-6">
                        <label for="password" class="control-label">Password</label>
                        <p class="help-block">User password</p>
                    </td>
                    <td class="col-md-6">
                        <input id="password" name="password" value="" type="password" placeholder="Password" class="form-control form-control-custom"/>
                    </td>
                </tr>
                <tr class="form-group">
                    <td class="col-md-6">
                        <label for="password" class="control-label">Confirm password</label>
                        <p class="help-block">Retype user password</p>
                    </td>
                    <td class="col-md-6">
                        <input id="password" name="password" value="" type="password" placeholder="Confirm password" class="form-control form-control-custom"/>
                    </td>
                </tr>
                <tr class="form-group">
                    <td class="col-md-6">
                        <label for="status">Active</label>
                        <p class="help-block">If unchecked, the account will be inactive.</p>
                    </td>
                    <td class="col-md-6">
                        <input type='hidden' value='0' name='status'>
                        <input id="status" type="checkbox" name="status" value="1" data-off-label="false" data-on-label="false" data-off-icon-class="glyphicon glyphicon-remove" data-on-icon-class="glyphicon glyphicon-ok" class="check-box-picker" checked>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>