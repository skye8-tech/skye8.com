<?php if(!empty($data)): ?>
    <table class="table table-responsive">
        <tr class="active">
            <th rowspan="6">
                <img src="http://maps.googleapis.com/maps/api/staticmap?key=AIzaSyDsTNE9SEJ8D8kMONWBwURSecuhyUvdXVY&center=<?php echo $data->lat ?>,<?php echo $data->lon ?>&zoom=7&format=jpg&size=200x200&language=ru&" alt="">
            </th>
            <th></th>
            <th></th>
        </tr>
        <tr class="active">
            <td>Country:</td>
            <td><?php echo $data['country'] ?></td>
        </tr>
        <tr class="active">
            <td>Locality:</td>
            <td><?php echo $data['regionName'] ?></td>
        </tr>
        <tr class="active">
            <td>Time zone:</td>
            <td><?php echo $data['timezone'] ?></td>
        </tr>
        <tr class="active">
            <td>Provider:</td>
            <td><?php echo $data['isp'] ?></td>
        </tr>
        <tr class="active">
            <td>ip:</td>
            <td><?php echo $data['query'] ?></td>
        </tr>
    </table>
<?php else: ?>
    <div class="notice notice-danger">Error getting data</div>
<?php endif ?>