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

    <div class="pull-right">
        <a href="#" class="btn btn-danger btn-lg ">
            <span class="glyphicon glyphicon-remove "></span> Remove
        </a>
        <a href="#" class="btn btn-info btn-lg">
            <span class="glyphicon glyphicon-plus-sign "></span> Add
        </a>
    </div>

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
                <td><img src="./img/books/<?= $books['img_buku']?>"></td>
                <td><a href=""> Edit </a></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>
