<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 9/29/16
 * Time: 7:52 PM
 */
?>
<script>
    $(function () {
        $("#search").keyup(function () {
            var search = $("#search").val();
            $.ajax({
                type: "POST",
                url: "lib/search.php",
                data: {"search": search},
                cache: false,
                success: function (response) {
                    $("#resSearch").html(response);
                }
            });
            return false;
        });

        $("#book_desc").keyup(function () {
            var book_desc = $("#book_desc").val();
            $.ajax({
                type: "POST",
                url: "lib/books.php",
                data: {"books_desc", book_desc},
                cache: false,
                success: function (response) {
                    $("#resBook").html(response);
                }
            })
        });
    });
</script>

<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>-->
<script>
    $(document).ready(function()
    {
//                $('.switch').click(function()
//                {
//                    $(this).toggleClass("switchOn");
//                });
        $.ajax({
            url: 'lib/api.php',
            data: "",
            success: function (data) {
                var id = data[0];
                if(id == 1){
                    $('.switch').attr("class","switch switchOn");
                }
            }

        });

    });
</script>
<!--[if lt IE 8]>
<p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a
    href="http://#/">upgrade your browser</a> to improve your experience.</p>
<![endif]-->


<form class="form-wrapper cf" action="lib/search.php" method="post" name="form" onsubmit="return false;">
    <input type="text" name="search" id="search" placeholder="">
    <button type="submit">Search</button>
</form>

<div id="resSearch" style="text-align: center; width: 685px; margin: 0 auto;"></div>
