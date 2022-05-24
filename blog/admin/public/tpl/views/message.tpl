<table class="table table-bordered">
    <tr>
        <td>Message from <?php echo $data['user-data']['login'] ?> sent <?php echo $data['time'] ?></td>
    </tr>
    <tr>
        <td>
            <?php echo $data['subject'] ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $data['message'] ?>
        </td>
    </tr>
</table>