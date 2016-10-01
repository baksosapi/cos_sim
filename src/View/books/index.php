<?php
?>
<script>
  $(function () {
      $("#search").keyup(function () {
          var search = $("#search").val();
          $.ajax({
              type: "POST",
              url: "?url=search",
              data: {"search":search},
              cache: false,
              success: function (response) {
                  $("#resSearch").html(response)
              }
          });
          return false;
      })
  });
</script>

<form class="form-wrapper" action="?url=search">
    <input type="text" id="search" name="search" placeholder="">
    <button>Cari</button>
</form>

<div id="resSearch" style="text-align: center; width: 685px; margin: 0 auto;"></div>
