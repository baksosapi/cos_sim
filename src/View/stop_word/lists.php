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
    <table class="table">
        <tr>
            <th>Id Tipe</th>
            <th>Tipe Buku</th>
<!--            <th>Keterangan</th>-->
        </tr>
        <?php foreach ($this->type_data as $type): ?>
            <tr>
                <td><?= $type['id']?></td>
                <td><?= $type['stop_word']?></td>
<!--                <td>--><?//= $type['description']?><!--</td>-->
            </tr>
        <?php endforeach; ?>
    </table>
</div>
