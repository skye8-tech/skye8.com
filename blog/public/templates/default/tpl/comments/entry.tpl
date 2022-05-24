<?php function comments($data){ ?>
    <?php foreach ($data as $t): ?>
        <li class="comment-item" id="comment-<?php echo $t['id'] ?>">
            <img src="{path}/img/user.jpg">
            <div class="comment-content">
                    <span class="meta">
                        <span class="comment-author"><?php echo $t['name'] ?></span>&nbsp;
                        <time class="comment-time" datetime="<?php echo $t['time'] ?>"><?php echo $t['time'] ?></time>&nbsp;
                        <span class="comment-reply pull-right">Reply</span>&nbsp;
                    </span>
                <p class="comment-message"><?php echo $t['comment'] ?></p>
            </div>
            <?php if(!empty($t['children'])): ?>
                <ul>
                    <?php comments($t['children']) ?>
                </ul>
            <?php endif ?>
        </li>
    <?php endforeach ?>
<?php } ?>

<?php if(!empty($data['comments'])): ?>
    <ul class="comments">
        <?php comments($data['comments']) ?>
    </ul>
<?php else: ?>
    <div class="notice notice-default notice-flat">No comments</div>
<?php endif ?>
