<table class="table">
    <thead>
    <tr>
        <th>Baju</th>
        <th>Qty</th>
        <th>Price</th>
        <th>Sub</th>
        <th><a href="javacript:void(0);" onclick="delallacc()">Clear</a></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($traccessories as $row): ?>
    <tr>
        <td><?=$row->maccessories->name?></td>
        <td><?=$row->qty?></td>
        <td><?=rupiah($row->price)?></td>
        <td><?=rupiah($row->total)?></td>
        <td><a href="javacript:void(0);" onclick="delperidacc(<?=$row->id?>)"><i class="fa fa-remove"></i></a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>