<?php
function resetTheResults(){
if (isset($_SESSION['results'])) {
    foreach ($_SESSION['results'] as $result) { ?>
        <tr>
            <td><?php echo $result[0] ?></td>
            <td><?php echo $result[1] ?></td>
            <td><?php echo $result[2] ?></td>
            <td><?php echo $result[3] ?></td>
            <td><?php echo $result[4] ?></td>
        </tr>
    <?php }}
}