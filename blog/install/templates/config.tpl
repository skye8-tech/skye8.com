<div class="panel panel-primary">
    <div class="panel-heading"><strong>System configuration settings</strong></div>
    <div class="panel-body">
        <form id="config-form" action="" method="post">
            <div class="well well-lg">
                <h5>Data for access to MySQL server</h5>
                <table class="table table-custom">
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="db-host" class="control-label">MySQL Server:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="db-host" name="db-host" value="" type="text" placeholder="Example: localhost" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="db-name" class="control-label">Database Name:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="db-name" name="db-name" value="" type="text" placeholder="Example: db" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="db-user" class="control-label">Username:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="db-user" name="db-user" value="" type="text" placeholder="Example: root" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="db-pass" class="control-label">Password:</label>
                            <p class="help-block"></p>
                        </td>
                        <td class="col-md-6">
                            <input id="db-pass" name="db-pass" value="" type="password" placeholder="Example: password" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                        </td>
                        <td class="col-md-6">
                            <input type="button" value="Checking mysql connection" class="btn btn-primary btn-test-connect pull-right"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="well well-lg">
                <h5>Basic settings</h5>
                <table class="table table-custom">
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-title" class="control-label">Name of the site</label>
                            <p class="help-block">The name of the site will be used in the title of your site.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="site-title" name="site-title" value="" type="text" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-description" class="control-label">Description of the site</label>
                            <p class="help-block">The description will be used in the meta description of your site, no more than 160 characters.</p>
                        </td>
                        <td class="col-md-6">
                            <textarea id="site-description" name="site-description" rows="3" class="form-control form-control-custom" style="resize: vertical"></textarea>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="site-keywords" class="control-label">Keywords</label>
                            <p class="help-block">These words will be used in meta keywords.</p>
                        </td>
                        <td class="col-md-6">
                            <input id="site-keywords" name="site-keywords" value="" type="text" class="form-control form-control-custom token-field"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="notification-email" class="control-label">Email address for notifications</label>
                            <p class="help-block">Notifications will be sent to this address</p>
                        </td>
                        <td class="col-md-6">
                            <input id="notification-email" name="notification-email" value="" type="email" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="well well-lg">
                <h5>Creating a Chief Administrator</h5>
                <table class="table table-custom">
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="login" class="control-label">Login</label>
                            <p class="help-block">Admin login</p>
                        </td>
                        <td class="col-md-6">
                            <input id="login" name="login" value="" type="text"  placeholder="Login" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="name" class="control-label">Name</label>
                            <p class="help-block">Admin name</p>
                        </td>
                        <td class="col-md-6">
                            <input id="name" name="name" value="" type="text"  placeholder="Name" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="email" class="control-label">Email</label>
                            <p class="help-block">Admin email</p>
                        </td>
                        <td class="col-md-6">
                            <input id="email" name="email" value="" type="text" placeholder="Email" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="password" class="control-label">Password</label>
                            <p class="help-block">Admin password</p>
                        </td>
                        <td class="col-md-6">
                            <input id="password" name="password" value="" type="password" placeholder="Password" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="confirm-password" class="control-label">Confirm password</label>
                            <p class="help-block">Retype admin password</p>
                        </td>
                        <td class="col-md-6">
                            <input id="confirm-password" name="confirm-password" value="" type="password" placeholder="Confirm password" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Continue</button>
            </div>
        </form>
    </div>
</div>
