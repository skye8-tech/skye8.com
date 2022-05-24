<?php if(!empty($data['comments'])): ?>
    <ul class="comments">
        <?php foreach ($data['comments'] as $t): ?>
            <li class="comment-item" id="comment-<?php echo $t['id'] ?>">
                <img src="{path}/img/user.jpg">
                <div class="comment-content">
                    <span class="meta">
                        <span class="comment-author"><?php echo $t['name'] ?></span>&nbsp;
                        <time class="comment-time" datetime="<?php echo $t['time'] ?>"><?php echo $t['time'] ?></time>&nbsp;
                        <span class="comment-entry pull-right"><a href="<?php echo $data['entry-url-prefix']?><?php echo $t['content'] ?>">View posts</a></span>&nbsp;
                    </span>
                    <p class="comment-message"><?php echo $t['comment'] ?></p>
                </div>
            </li>
        <?php endforeach ?>
    </ul>
<?php else: ?>
    <div class="notice notice-default notice-flat">No comments</div>
<?php endif ?>