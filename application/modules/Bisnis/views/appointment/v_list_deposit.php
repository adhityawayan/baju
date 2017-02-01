<table class="table">
    <thead>
    <tr>
        <th>Deposit</th>
        <th>Tanggal</th>
        <th><a href="javacript:void(0);" onclick="delalldeposit()">Clear</a></th>
    </tr>
    </thead>
    <tbody>
    <?php foreach($trdeposit as $row): ?>
    <tr>
        <td><?=rupiah($row->deposit)?></td>
        <td><?=tgl_indo($row->date)?></td>
        <td><a href="javacript:void(0);" onclick="delperiddeposit(<?=$row->id?>)"><i class="fa fa-remove"></i></a></td>
    </tr>
    <?php endforeach; ?>
    </tbody>
</table>