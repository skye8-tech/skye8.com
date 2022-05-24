<?php function menu($pages, $category, $prefix) { ?>
    <?php $first = true ?>
    <?php foreach ($pages as $t): ?>
        <li>
            <a href="<?php echo $t['type'] == 3 ? '#' : '/' . $t['url'] ?>" class="<?php echo $t['class'] ?>">
                <span class="fa <?php echo $t['icon'] ?>"></span>&nbsp;
                <?php echo $t['name'] ?>
            </a>
            <?php if(isset($t['children'])): ?>
                <ul>
                    <?php menu($t['children'], $category, $prefix) ?>
                </ul>
            <?php endif ?>
            <?php if($t['type'] == 3): ?>
                <?php if(!empty($category)): ?>
                    <ul>
                        <?php category($category, $prefix) ?>
                    </ul>
                <?php endif ?>
            <?php endif ?>
        </li>
    <?php endforeach ?>
<?php } ?>

<?php function category($category,  $prefix) { ?>
    <?php $first = true ?>
    <?php foreach ($category as $t): ?>
        <li>
            <a href="<?php echo $prefix ?><?php echo $t['url'] ?>">
                <span class="fa <?php echo $t['icon'] ?>"></span>&nbsp;
                <?php echo $t['name'] ?> (<?php echo $t['count'] ?>)
            </a>
            <?php if(isset($t['children'])): ?>
                <ul>
                    <?php category($t['children'], $prefix) ?>
                </ul>
            <?php endif ?>
            <?php if($t['type'] == 2): ?>
                <?php if(!empty($category)): ?>
                    <ul>
                        <?php category($category, $prefix) ?>
                    </ul>
                <?php endif ?>
            <?php endif ?>
        </li>
    <?php endforeach ?>
<?php } ?>

<ul id="menu-main" class="navigation">
    <?php menu($data['pages'], $data['category'], $data['category-url-prefix']) ?>
</ul>