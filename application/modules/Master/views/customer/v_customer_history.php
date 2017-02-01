<?php
/**
 * Created by PhpStorm.
 * User: deyelovi
 * Date: 17/11/2016
 * Time: 12:01
 */
?>
<ul class="list-group">
    <?php foreach($appointment as $row): ?>
    <li class="list-group-item"><?=tgl_indo_waktu($row->date)?> - <?=$row->note?></li>
    <?php endforeach; ?>
</ul>
