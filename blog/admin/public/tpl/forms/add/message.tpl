<div class="row">
    <div class="col-md-12">
        <?php if(!empty($data)): ?>
            <form id="message-form-add" class="message-form">
                <table class="table table-custom">
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="recipient" class="control-label">Recipient</label>
                            <p class="help-block">Message recipient</p>
                        </td>
                        <td class="col-md-6">
                            <?php if(!empty($data['users'])): ?>
                                <select id="recipient" name="recipient" data-live-search="true" class="form-control form-control-custom selectpicker show-tick">
                                    <?php foreach ($data['users'] as $t): ?>
                                        <option value="<?php echo $t['id'] ?>" data-icon="fa-user" data-subtext="<?php echo $t['name'] ?>">
                                            <?php echo $t['name'] ?>
                                        </option>
                                    <?php endforeach ?>
                                </select>
                            <?php else: ?>
                                <div class="notice notice-info notice-flat">There are no users!</div>
                            <?php endif ?>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="subject">Headline</label>
                            <p class="help-block">The headline of the message</p>
                        </td>
                        <td class="col-md-6">
                            <input id="subject" name="subject" value="" type="text" placeholder="Headline" class="form-control form-control-custom"/>
                        </td>
                    </tr>
                    <tr class="form-group">
                        <td class="col-md-6">
                            <label for="message" class="control-label">Message</label>
                            <p class="help-block">Text message</p>
                        </td>
                        <td class="col-md-6">
                            <textarea id="message" rows="3" name="message" placeholder="Text message" class="form-control form-control-custom"></textarea>
                        </td>
                    </tr>
                </table>
            </form>
        <?php else: ?>
            <div class="notice notice-danger">Error getting data</div>
        <?php endif ?>
    </div>
</div>