<main class="single">
    <div class="row">
        <div class="col-md-12">
            <div class="entry user-info">
                <h1 class="page-title">My profile</h1>
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#tab-info" aria-controls="tab-info" role="tab" data-toggle="tab">Information</a></li>
                    <li role="presentation"><a href="#tab-edit" aria-controls="tab-edit" role="tab" data-toggle="tab">Editing</a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="tab-info">
                        <table class="table table-responsive">
                            <tr>
                                <td>Login</td>
                                <td><?php echo $data['data']['login'] ?></td>
                            </tr>
                            <tr>
                                <td>Name</td>
                                <td><?php echo $data['data']['name'] ?></td>
                            </tr>
                            <tr>
                                <td>E-mail</td>
                                <td><?php echo $data['data']['email'] ?></td>
                            </tr>
                            <tr>
                                <td>Registered</td>
                                <td><?php echo $data['data']['time'] ?></td>
                            </tr>
                            <tr>
                                <td>Number of publications</td>
                                <td><span class="badge"><?php echo $data['data']['content'] ?></span> <a href="/user/entries">View all publications</a></td>
                            </tr>
                            <tr>
                                <td>Number of comments</td>
                                <td><span class="badge"><?php echo $data['data']['comments'] ?></span> <a href="/user/comments">View all comments</a></td>
                            </tr>
                        </table>

                        <h3 class="entry-title">
                            Publications on moderation
                        </h3>

                        <?php echo $this->compileBloc('entries/entries', $data) ?>


                        <h3 class="entry-title">
                            Comments on moderation
                        </h3>

                        <?php echo $this->compileBloc('comments/user', $data) ?>

                    </div>
                    <div role="tabpanel" class="tab-pane" id="tab-edit">
                        <div class="notice notice-success notice-flat hidden">Profile successfully updated!</div>
                        <div class="notice notice-warning notice-flat hidden">Вы ввели неверный текущий пароль!</div>
                        <div class="notice notice-danger notice-flat hidden">An error occurred while updating the profile. Please try again!</div>
                        <form id="user-edit-form" role="form" data-id="<?php echo $data['data']['id'] ?>">
                            <div class="row">
                                <div class="form-group col-md-12">
                                    <label for="login" class="control-label">Login</label>
                                    <input id="login" name="login" value="<?php echo $data['data']['login'] ?>" type="text"  placeholder="Login" class="form-control form-control-custom"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="name" class="control-label">Name</label>
                                    <input id="name" name="name" value="<?php echo $data['data']['name'] ?>" type="text"  placeholder="Name" class="form-control form-control-custom"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="email" class="control-label">Email</label>
                                    <input id="email" name="email" value="<?php echo $data['data']['email'] ?>" type="text" placeholder="Email" class="form-control form-control-custom"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="current-password" class="control-label">Current password</label>
                                    <input id="current-password" name="current-password" value="" type="password" placeholder="Current password" class="form-control form-control-custom"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="new-password" class="control-label">New password</label>
                                    <p class="help-block">Leave the fields blank if you do not want to change the current password</p>
                                    <input id="new-password" name="new-password" value="" type="password" placeholder="New password" class="form-control form-control-custom"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <label for="confirm-password" class="control-label">Repeat new password</label>
                                    <input id="confirm-password" name="confirm-password" value="" type="password" placeholder="Repeat new password" class="form-control form-control-custom"/>
                                </div>
                                <div class="form-group col-md-12">
                                    <input type="submit" class="btn btn-custom" value="Submit" style="width: 100%"/>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>