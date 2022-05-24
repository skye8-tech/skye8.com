<table class="table table-bordered">
    <thead>
    <tr>
        <th>Field names</th>
        <th>Value left by visitor</th>
    </tr>
    </thead>
    <tbody>
    <?php if(!empty($data['json'])): ?>
        <?php foreach($data['json'] as $t): ?>
            <tr>
                <td><?php echo $t['name'] ?></td>
                <?php if($t['type'] == 'select'): ?>
                    <?php $values = '' ?>
                    <?php if(is_array($t['value'])): ?>
                        <?php foreach($t['value'] as $v): ?>
                            <?php $values .= $v.', ' ?>
                        <?php endforeach ?>
                    <?php else: ?>
                        <?php $values = $t['value'] ?>
                    <?php endif ?>
                    <td><?php echo rtrim($values, ', ') ?></td>
                <?php else: ?>
                    <td><?php echo $t['value'] ?></td>
                <?php endif ?>
            </tr>
        <?php endforeach ?>
    <?php endif ?>
    </tbody>
</table>