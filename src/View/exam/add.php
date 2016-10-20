<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 7:52 PM.
 */
$page_title = 'Tambah Koleksi Buku ...'
?>

<div id="book-form" class="clearfix">
    <h2>Uji Data Traine</h2>
    <!--    <h1>Tambah Data Buku</h1>-->
    <!--    <h2>Lengkapi formulir isian berikut dengan benar </h2>-->
    <ul id="errors" class="<?= ($sr && !$cf['ok']) ? 'visible' : ''; ?>">
        <li id="info">Terdapat kesalahan penambahan data:</li>
    </ul>
    <p id="success" class="<?=(isset($this->id)) ? 'visible' : ''; ?>">Uji Data Buku berhasil ditambahkan!</p>
    <form method="post" action="?url=books/add">
        <label for="q">Search: <span class="required">*</span></label>
        <input type="text" id="title" name="q" value="" placeholder="" required="required" autofocus="autofocus" />

<!--        <label for="author">Pengarang: <span class="required">*</span></label>-->
<!--        <input type="text" id="author" name="author" value="" placeholder="Author 1" required="required" autofocus="autofocus" />-->
<!---->
<!--        <!--        <label for="email">Email Address: <span class="required">*</span></label>-->-->
<!--        <!--        <input type="email" id="email" name="email" value="" placeholder="user1@example.com" required="required" />-->-->
<!---->
<!--        <label for="isbn">ISBN: </label>-->
<!--        <input type="isbn" id="isbn" name="isbn" value="" />-->
<!---->
<!--        <label for="type">Jenis Buku: </label>-->
<!--        <select id="type" name="type">-->
<!--            --><?php //foreach ($this->type_data as $type): ?>
<!--                <option value="--><?//= $type['code']?><!--">--><?//= $type['type_name'] ?><!--</option>-->
<!--            --><?php //endforeach; ?>
<!---->
<!--        </select>-->
<!---->
<!--        <label for="blurb">Ringkasan : <span class="required">*</span></label>-->
<!--        <textarea id="blurb" name="blurb" placeholder="Ringkasan Buku" required="required" data-minlength="20"></textarea>-->
<!---->
<!--        <label for="image_cover">Sampul Buku:</label>-->
<!--        <input type="file" id="image_cover" name="image_cover">-->

        <span id="loading"></span>
        <input type="submit" value="Tambahkan" id="submit-button" name="submit"/>
        <p id="req-field-desc"><span class="required">*</span> wajib diisi</p>
    </form>
</div>

<!--<form class="form-wrapper cf" action="lib/search.php" method="post" name="form" onsubmit="return false;">-->
<!--    <input type="text" name="search" id="search" placeholder="">-->
<!--    <button type="submit">Search</button>-->
<!--</form>-->
<!---->
<!--<div id="resSearch" style="text-align: center; width: 685px; margin: 0 auto;"></div>-->
