<div class="row">
    <div class="col-md-12">

        <?php if(!empty($data)): ?>
            
            <form id="comment-form-edit">
                <table class="table table-custom">
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="name" class="control-label">Name</label>
                            <p class="help-block">Display name</p>
                        </td>
                        <td class="col-md-6">
                            <input id="name" name="name" value="<?php echo $data['data']['name'] ?>" type="text" placeholder="Name" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="comment" class="control-label">Comment</label>
                            <p class="help-block">Comment text</p>
                        </td>
                        <td class="col-md-6">
                            <textarea id="comment" name="comment" rows="10" placeholder="Comment" class="form-control form-control-custom"><?php echo $data['data']['comment'] ?></textarea>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="status">Post to website</label>
                            <p class="help-block">If not checked, the comment will not be displayed on the site</p>
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