document.addEventListener("DOMContentLoaded", function () {

  (function ($) {
    $(document).ready(function () {
      let currentPage = 1;

      $("#load-more").click(function (e) {
        e.preventDefault();

        const nonce = $("#nonce").val();

        const ajaxurl = $("#ajaxurl").val();

        if (document.getElementById("currentPage") !== null) {
          currentPage = document.getElementById("currentPage").value;
        }
        const categorie_id = document.getElementById("categorie_id").value;
        const format_id = document.getElementById("format_id").value;
        let order = document.getElementById("date").value;
        let orderby = "date";

        let max_pages = document.getElementById("max_pages").value;

        currentPage++;
        document.getElementById("currentPage").value = currentPage;

        if (currentPage >= max_pages) {
          $("#load-more").addClass("hidden");
        } else {
          $("#load-more").removeClass("hidden");
        }

        $.ajax({
          type: "POST",
          url: ajaxurl,
          dataType: "html", 
          data: {
            action: "nathalie_mota_load",
            nonce: nonce,
            paged: currentPage,
            categorie_id: categorie_id,
            format_id: format_id,
            orderby: orderby,
            order: order,
          },

          success: function (res) {
            $(".publication-list").append(res);

            document.getElementById("currentPage").value = currentPage;
          },
        });
      });
    });
  })(jQuery);
});