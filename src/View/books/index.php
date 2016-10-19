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
        <input type="text" id="search" name="q" placeholder="">
        <button>Cari</button>
    </form>


<!--<div id="resSearch" style="text-align: center; width: 685px; margin: 0 auto;"></div>-->
<div id="resSearch" style="text-align: center; width: 800px%; margin: 0 auto;"></div>

