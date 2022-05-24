<h1 style="margin: 0 0 10px 0; font-size: 16px;padding: 0;">
    <?php echo $data['header'] ?>
</h1>
<div style="margin: 0;padding: 10px;">
    <h3>Hi, <?php echo $data['login'] ?>!</h3>
    <p>
        Site <?php echo $data['host'] ?> received a request to reset the password to your account. If you have not sent a request to reset your password, please ignore this email.
    </p>
</div>
<div style="padding: 0;margin: 10px 0;font-size: 12px;">
    <a href="<?php echo $data['link']['url'] ?>"><?php echo $data['link']['name'] ?></a>
</div>