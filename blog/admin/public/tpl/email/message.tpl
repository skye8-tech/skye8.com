<h1 style="margin: 0 0 10px 0; font-size: 16px;padding: 0;"><?php echo $data['header'] ?></h1>
<div style="margin: 0;padding: 10px;">
    <table cellpadding="6" cellspacing="0" style="border-collapse: collapse;">
        <thead>
        <tr>
            <th style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">Headline</th>
            <th style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0;font-family:arial;">Message</th>
        </tr>
        </thead>
        <tbody>
            <tr>
                <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0; font-family:arial;"><?php echo $data['data']['header'] ?></td>
                <td style="padding:6px; background-color:#f0f0f0; border:1px solid #e0e0e0; font-family:arial;"><?php echo $data['data']['message'] ?></td>
            </tr>
        </tbody>
    </table>
</div>
<div style="padding: 0;margin: 10px 0;font-size: 12px;">
    <a href="<?php echo $data['link']['url'] ?>"><?php echo $data['link']['name'] ?></a>
</div>