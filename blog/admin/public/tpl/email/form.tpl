<h1 style="margin: 0 0 10px 0; font-size: 16px;padding: 0;"><?php echo $data['header'] ?></h1>
<div style="margin: 0;padding: 10px;">
    <?php $object = json_decode($data['form-data']) ?>
    <table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
        <thead>
        <tr>
            <th style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">Field names</th>
            <th style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;">Value left by visitor</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($object as $t): ?>
            <tr>
                <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0; font-family:arial;"><?php echo $t->name ?></td>
                <?php if($t->type == 'select'): ?>
                    <?php $values = '' ?>
                    <?php if(is_array($t->value)): ?>
                        <?php foreach($t->value as $v): ?>
                            <?php $values .= $v.', ' ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <?php $values = $t->value ?>
                    <?php endif ?>
                    <td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;"><?php echo rtrim($values, ', ') ?></td>
                <?php else: ?>
                    <td style="padding:6px; background-color:#ffffff; border:1px solid #e0e0e0;font-family:arial;"><?php echo $t->value ?></td>
                <?php endif ?>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>
<div style="padding: 0;margin: 10px 0;font-size: 12px;">
    <a href="<?php echo $data['link']['url'] ?>"><?php echo $data['link']['name'] ?></a>
</div>