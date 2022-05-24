<main class="single">
    <div class="row">
        <div class="col-md-12">
            <div class="entry">
                <h1 class="page-title">Enter new password</h1>
                <div class="entry-content">
                    <p>
                        Enter your new password to enter the site. If you remembered your current password and do not want to change it, just close this page.
                    </p>
                </div>
                <div class="notice notice-danger notice-flat hidden">An error occurred while changing the password. Please try again!</div>
                <form id="new-password-form" role="form">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="password" class="control-label">Password</label>
                            <input id="password" name="password" value="" type="password" placeholder="Password" class="form-control form-control-custom"/>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="confirm" class="control-label">Confirm password</label>
                            <input id="confirm" name="confirm" value="" type="password" placeholder="Confirm password" class="form-control form-control-custom"/>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="captcha" class="control-label">Security code</label>
                            <div class="input-group">
                                <div class="input-group-addon"><img src="/captcha" alt="" style="max-width: inherit;"></div>
                                <input class="form-control input-lg" placeholder="Security code" name="captcha">
                            </div>
                        </div>
                        <div class="form-group col-md-12">
                            <input type="submit" class="btn btn-custom" value="Submit" style="width: 100%"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>