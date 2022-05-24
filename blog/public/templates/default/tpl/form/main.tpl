<?php if(!empty($data)): ?>

    <h4 class="widget-title">
        <?php echo $data['params']['header-text'] ?>
    </h4>

    <div class="entry-content text-center">
        <?php echo $data['params']['message-text'] ?>
    </div>

    <div class="notice notice-success notice-flat hidden">Data sent successfully!</div>
    <div class="notice notice-danger notice-flat hidden">An error occurred while sending the data. Please try again!</div>

    <form id="form-<?php echo $data['id'] ?>" class="page-form">

        <?php $i = 0; foreach($data['fields'] as $t): $i++ ?>
            <?php if($t['type'] == 'text'): ?>

                <div class="form-group form-component" data-type="<?php echo $t['type'] ?>">
                    <label for="form-component-<?php echo $i ?>"><?php echo $t['label'] ?></label>
                    <input id="form-component-<?php echo $i ?>" type="text" class="form-control" name="input-<?php echo $i ?>" <?php echo $t['required'] ? 'required data-bv-notempty-message="Cannot be empty"' : '' ?>>
                </div>

            <?php elseif($t['type'] == 'textarea'): ?>

                <div class="form-group form-component" data-type="<?php echo $t['type'] ?>">
                    <label for="form-component-<?php echo $i ?>"><?php echo $t['label'] ?></label>
                    <textarea id="form-component-<?php echo $i ?>" class="form-control" rows="3" name="input-<?php echo $i ?>" <?php echo $t['required'] ? 'required data-bv-notempty-message="Cannot be empty"' : '' ?> style="resize: vertical"></textarea>
                </div>

            <?php elseif($t['type'] == 'select'): ?>

                <?php if(is_array($t['choices']) && count($t['choices'])): ?>

                    <div class="form-group form-component" data-type="<?php echo $t['type'] ?>">
                        <label for="form-component-<?php echo $i ?>"><?php echo $t['label'] ?></label>
                        <select id="form-component-<?php echo $i ?>" name="input-<?php echo $i ?>[]" multiple class="form-control selectpicker show-tick">
                            <?php foreach($t['choices'] as $o): ?>
                                <option value="<?php echo $o['label'] ?>" <?php echo $o['selected'] == 1 ? 'selected' : '' ?>><?php echo $o['label'] ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>

                <?php endif ?>

            <?php elseif($t['type'] == 'radio'): ?>

                <?php if(is_array($t['choices']) && count($t['choices'])): ?>

                    <div class="form-group form-component" data-type="<?php echo $t['type'] ?>">
                        <label class="control-label"><?php echo $t['label'] ?></label>
                        <?php $iterator = 0 ?>
                        <?php foreach($t['choices'] as $o): ?>
                            <div class="radio">
                                <label for="form-component-<?php echo $i ?>-<?php echo $iterator ?>">
                                    <input id="form-component-<?php echo $i ?>-<?php echo $iterator ?>" type="radio" name="input-<?php echo $i ?>-<?php echo $o ?>" value="<?php echo $o['label'] ?>" <?php echo $o['selected'] == 1 ? 'checked' : '' ?> <?php echo $t['required'] ? 'required data-bv-notempty-message="Choose at least one value"' : '' ?>> <?php echo $o['label'] ?>
                                </label>
                            </div>
                            <?php $iterator++ ?>
                        <?php endforeach ?>
                    </div>

                <?php endif ?>

            <?php elseif($t['type'] == 'checkbox'): ?>

                <div class="checkbox form-component" data-type="<?php echo $t['type'] ?>">
                    <label for="form-component-<?php echo $i ?>">
                        <input id="form-component-<?php echo $i ?>" type="checkbox" name="input-<?php echo $i ?>" value="<?php echo $t['label'] ?>" <?php echo $t['selected'] == 1 ? 'checked' : '' ?>> <?php echo $t['label'] ?>
                    </label>
                </div>

            <?php endif ?>
        <?php endforeach; $i = null ?>

        <div class="form-group">
            <label for="captcha" class="control-label"></label>
            <div class="input-group">
                <div class="input-group-addon">
                    <img src="/captcha" alt="" style="max-width: inherit;">
                </div>
                <input class="form-control input-lg" placeholder="Security code" name="captcha" id="captcha">
            </div>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-custom btn-form-submit" style="width: 100%"><?php echo $data['params']['button-text'] ?></button>
        </div>

    </form>

<?php endif ?>