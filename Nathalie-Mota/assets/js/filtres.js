console.log("Script filtres en ajax lancé !!!");


document.addEventListener("DOMContentLoaded", function () {
  const body = document.querySelector("body");
  const allDashicons = document.querySelectorAll(".dashicons");
  const allSelect = document.querySelectorAll("select");
  const message = "<p>Désolé. Aucun article ne correspond à cette demande.<p>";
  let categorie_id = "";
  if (document.getElementById("categorie_id")) {
    document.getElementById("categorie_id").value = "";
  }
  let format_id = "";
  if (document.getElementById("format_id")) {
    document.getElementById("format_id").value = "";
  }
  let order = "";
  if (document.getElementById("date")) {
    document.getElementById("date").value = "";
  }

  let currentPage = 1;
  let max_pages = 1;
  let selectId = "";

  document.getElementById("currentPage").value = 1;


  (function ($) {
    $(document).ready(function () {
      $(".option-filter").change(function (e) {
        e.preventDefault();

        const nonce = $("#nonce").val();

        const ajaxurl = $("#ajaxurl").val();

        if (document.getElementById("max_pages") !== null) {
          max_pages = document.getElementById("max_pages").value;
        }

        let targetName = e.target.name;
        let targetValue = e.target.value;

        if (targetName === "categorie_id") {
          categorie_id = targetValue;
        }
        if (targetName === "format_id") {
          format_id = targetValue;
        }
        if (targetName === "date") {
          order = targetValue;
        }

        let orderby = "date";

        $.ajax({
          type: "POST",
          url: ajaxurl,
          dataType: "html", 
          data: {
            action: "nathalie_mota_load",
            nonce: nonce,
            paged: 1,
            categorie_id: categorie_id,
            format_id: format_id,
            orderby: orderby,
            order: order,
          },
          success: function (res) {
            $(".publication-list").empty().append(res);
            let max_pages = document.getElementById("max_pages").value;
            let nb_total_posts = 0;

            if (currentPage >= max_pages) {
              $("#load-more").addClass("hidden");
            } else {
              $("#load-more").removeClass("hidden");
            }

            if (document.getElementById("nb_total_posts") !== null) {
              nb_total_posts = document.getElementById("nb_total_posts").value;
            }

            if (nb_total_posts == 0) {
              $(".publication-list").append(message);
            }


            document.getElementById("currentPage").value = 1;
          },
        });
      });
    });
  })(jQuery);

  body.addEventListener("click", (e) => {
    if (e.target.tagName != "select" && e.target.tagName != "SELECT") {
      initArrow();
    }
  });

  function findWord(word, str) {
    return RegExp("\\b" + word + "\\b").test(str);
  }

  const initArrow = () => {
    console.log("Initialisation des fleches");
    allDashicons.forEach((dashicons) => {
      dashicons.classList.add("select-close");
      dashicons.classList.remove("select-open");
    });
  };

  const arrow = (arg) => {
    allDashicons.forEach((dashicons) => {
      if (findWord(arg, dashicons.className)) {
        if (
          findWord("select-close", dashicons.className) ||
          findWord("select-open", dashicons.className)
        ) {
          if (findWord("select-close", dashicons.className)) {
            dashicons.classList.remove("select-close");
            dashicons.classList.add("select-open");
          } else {
            dashicons.classList.add("select-close");
            dashicons.classList.remove("select-open");
          }
        }
      }
    });
  };

  allSelect.forEach((select) => {
    select.addEventListener("click", (e) => {
      e.preventDefault();

      if (select.id != selectId) {
        initArrow();
      }
      selectId = select.id;
      arrow(selectId);
    });
  });
});