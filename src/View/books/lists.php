<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 7:52 PM.
 */
$page_title = 'Tambah Koleksi Buku ...'
?>

<div id="book-form">
    <table class="table">
        <tr>
            <th>Kode</th>
            <th>Judul Buku</th>
            <th>Keterangan</th>
            <th>Gambar</th>
        </tr>
        <?php foreach ($this->bukus as $books): ?>
            <tr>
                <td><?= $books['kode_buku']?></td>
                <td><?= $books['judul_buku']?></td>
                <td><?= $books['keterangan']?></td>
                <td><img src="<?= $books['img_buku']?>"></td>
<!--                <td>--><?//= $type['description']?><!--</td>-->
            </tr>
        <?php endforeach; ?>
    </table>
</div>
