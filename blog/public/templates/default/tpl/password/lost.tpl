<main class="single">
    <div class="row">
        <div class="col-md-12">
            <div class="entry">
                <h1 class="page-title">Password recovery</h1>
                <div class="entry-content">
                    <p>
                        Please indicate the username or E-mail that you used to enter the site. A link to reset your password will be sent to your email address!
                    </p>
                </div>
                <div class="notice notice-success notice-flat hidden">An email with a link to reset your password has been sent to your E-mail!</div>
                <div class="notice notice-danger notice-flat hidden">A user with such data is not registered. Please try again!</div>
                <form id="lost-password-form" role="form">
                    <div id="form-controls" class="row">
                        <div class="form-group col-md-12">
                            <label for="lostname" class="control-label">Login or Email</label>
                            <input id="lostname" name="lostname" class="form-control" placeholder="Login or Email">
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