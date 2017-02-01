<table class="table">
    <thead>
    <tr>
        <th>Deskripsi</th>
        <th>Price</th>
        <th><a href="javacript:void(0);" onclick="delallmade()">Clear</a></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($trmade as $row): ?>
    <tr>
        <td><?=$row->disc?></td>
        <td><?=rupiah($row->price)?></td>
        <td><a href="javacript:void(0);" onclick="delperidmade(<?=$row->id?>)"><i class="fa fa-remove"></i></a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>