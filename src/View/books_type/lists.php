<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 7:52 PM.
 */
$page_title = 'Tambah Koleksi Buku ...'
?>

<div id="list-form">
    <table>
        <tr>
            <th>Id Tipe</th>
            <th>Tipe Buku</th>
<!--            <th>Keterangan</th>-->
        </tr>
        <?php foreach ($this->type_data as $type): ?>
            <tr>
                <td><?= $type['code']?></td>
                <td><?= $type['type_name']?></td>
<!--                <td>--><?//= $type['description']?><!--</td>-->
            </tr>
        <?php endforeach; ?>
    </table>
</div>
