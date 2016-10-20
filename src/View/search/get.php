<?php
/**
 * Created by PhpStorm.
 * User: wildan
 * Date: 10/7/16
 * Time: 5:37 PM.
 */

//echo $this->cs;
?>

    <script>
        $(function () {
            $("#search").keyup(function () {
                var search = $("#search").val();
                $.ajax({
                    type: "GET",
//                    url: "?url=search",
//                    url: "?url=search&mod=api",
                    url: "src/api.php",
//                    url: "?",
                    data: {"q":search},
                    cache: false,
                    success: function (response) {
                        $("html").removeClass();
                        $("#resSearch").html(response);
                        $('#resSearch').find("#navbar").hide();

                    }
                });
                return false;
            })
        });
    </script>

    <form class="form-wrapper" action="?url=search" method="get">
        <input type="text" id="search" name="q" placeholder="" value="<?php if(isset($_GET['q'])) echo $_GET['q'];?>">
        <button>Cari</button>
    </form>


<?php
if (!empty($this->res)) {
//    echo '<pre>';
//    print_r($this->res);
//     $this->res_table;
}
//print_r($_GET['q']);



