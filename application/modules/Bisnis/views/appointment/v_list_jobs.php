<table class="table">
    <thead>
    <tr>
        <th>Jobs</th>
        <th>Price</th>
        <th><a href="javacript:void(0);" onclick="delalljobs()">Clear</a></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($trjobs as $row): ?>
    <tr>
        <td><?=$row->job?></td>
        <td><?=rupiah($row->price)?></td>
        <td><a href="javacript:void(0);" onclick="delperidjobs(<?=$row->id?>)"><i class="fa fa-remove"></i></a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>