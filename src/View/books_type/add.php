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
    <h2>Tambah Data Tipe Buku</h2>
<!--    <h1>Tambah Data Buku</h1>-->
<!--    <h2>Lengkapi formulir isian berikut dengan benar </h2>-->
    <ul id="errors" class="">
        <li id="info">Terdapat kesalahan penambahan data:</li>
    </ul>
    <p id="success" class="<?=(isset($this->id)) ? 'visible' : ''; ?>">Data Type Buku berhasil ditambahkan!</p>
    <form method="post" action="?url=books_type/add">
        <label for="type_name">Tipe Buku: <span class="required">*</span></label>
        <input type="text" id="type_name" name="type_name" value="" placeholder="Komputer" required="required" autofocus="autofocus" />

        <label for="code">Kode: <span class="required">*</span></label>
        <input type="text" id="code" name="code" value="" placeholder="101" required="required" autofocus="autofocus" />

<!--        <label for="blurb">Ringkasan : <span class="required">*</span></label>-->
<!--        <textarea id="blurb" name="blurb" placeholder="Ringkasan Buku" required="required" data-minlength="20"></textarea>-->

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
