<main class="single">
    <div class="row">
        <div class="col-md-12">
            <div class="entry">
                <h2 class="page-title" itemprop="headline">New user registration</h2>
                <div class="entry-content" itemprop="text">
                    <p>
                        Registration on the site will allow you to be a full member. You can add entries to the site, leave your comments, view hidden text and much more.
                    </p>
                </div>
                <div class="notice notice-default notice-flat hidden">An error occurred while registering the user. Please try again!</div>
                <form id="register-form" role="form">
                    <div class="row">
                        <div class="form-group col-md-12">
                            <label for="login" class="control-label">Login</label>
                            <input id="login" name="login" value="" type="text"  placeholder="Login" class="form-control form-control-custom"/>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="name" class="control-label">Name</label>
                            <input id="name" name="name" value="" type="text"  placeholder="Name" class="form-control form-control-custom"/>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="email" class="control-label">Email</label>
                            <input id="email" name="email" value="" type="text" placeholder="Email" class="form-control form-control-custom"/>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="password" class="control-label">Password</label>
                            <input id="password" name="password" value="" type="password" placeholder="Password" class="form-control form-control-custom"/>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="password" class="control-label">Confirm password</label>
                            <input id="password" name="password" value="" type="password" placeholder="Confirm password" class="form-control form-control-custom"/>
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