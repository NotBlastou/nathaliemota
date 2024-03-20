document.addEventListener("DOMContentLoaded", function () {
  let total_posts = "";
  let nb_total_posts = 1;
  let posts_per_page = 1;


  const regex1 = /[(]/g;
  const regex2 = /[)]/g;
  let arrayIntial;

  recupData();

  let idPhoto = null;
  let idValue = 10;
  let arrow = "true";

  function recupData() {
    if (document.getElementById("total_posts") !== null) {
      total_posts = document.getElementById("total_posts").value;

      total_posts = total_posts.slice(8, total_posts.length - 3);
    }

    if (document.getElementById("nb_total_posts") !== null) {
      nb_total_posts = document.getElementById("nb_total_posts").value;
    }

    if (document.getElementById("posts_per_page") !== null) {
      posts_per_page = document.getElementById("posts_per_page").value;
    }

    arrayIntial = total_posts;
    arrayFinish = new Array();
    data = new Array();

    recupArrayPhp();
  }

  function recupArrayPhp() {

    for (let pas = 0; pas < nb_total_posts; pas++) {
      start = arrayIntial.search(regex1) + 2;
      end = arrayIntial.search(regex2);
      next = end + 1;


      arrayFinish.push(arrayIntial.slice(`${start}`, `${end}`));


      arrayIntial = arrayIntial.slice(`${next}`, -1);
    }
  }


  function recupIdData(arg) {

    for (let i = 0; i < nb_total_posts; i++) {
      data = arrayFinish[i].split("\n");
      let position = data[0].search("ID") + 7;
      if (data[0].slice(`${position}`) == arg) {
        idValue = i;
      }
    }
  }


  function recupIdPhoto(arg) {
    data = arrayFinish[arg].split("\n");
    let position = data[0].search("ID") + 7;
    idPhoto = data[0].slice(`${position}`);
  }

  (function ($) {
    $(document).ready(function () {

      $(".publication-list").click(function (e) {
        e.preventDefault();


        recupData();

        if (e.target.className === "detail-photo") {

          window.location.href = e.target.parentElement.getAttribute("href");
        }

        if (e.target.className === "openLightbox") {

          if (!$(e.target).data("arrow")) {
            arrow = $(e.target).data("arrow");
          }
          if (!$(e.target).data("postid")) {
            console.log(
              "Identifiant manquant. Récupération du premier de la liste"
            );
            recupIdPhoto(0);
          } else {
            idPhoto = $(e.target).data("postid");
          }
          recupIdData(idPhoto);

          $(".lightbox").removeClass("hidden");

          $("#lightbox__container_content").empty();
          $.changePhoto();
        }
      });


      $(".lightbox__prev").click(function (e) {
        e.preventDefault();
        idPhotoNext = idPhoto;
        console.log("Photo précédente");
        if (idValue > 0) {
          idValue--;
        } else {
          idValue = nb_total_posts - 1;
        }
        recupIdPhoto(idValue);
        console.log("id: " + idValue + " - id Photo: " + idPhoto);
        $.changePhoto();
      });

      $(".lightbox__next").click(function (e) {
        e.preventDefault();
        idPhotoNext = idPhoto;
        console.log("Photo suivante");
        if (idValue < nb_total_posts - 1) {
          idValue++;
        } else {
          idValue = 0;
        }
        recupIdPhoto(idValue);
        console.log("id: " + idValue + " - id Photo: " + idPhoto);
        $.changePhoto();
      });

      $(".lightbox__close").click(function (e) {
        e.preventDefault();
        $.close();
      });

      /**
       * Récupération des évenments au clavier
       * @param {KeyboardEvent} e     */

      $("body").keyup(function (e) {
        e.preventDefault();

        if (e.key === "Escape") {
          $.close();
        }
      });


      $.changePhoto = function () {

        const nonce = $("#nonce").val();


        const ajaxurl = $("#ajaxurl").val();


        $(".lightbox__loader").removeClass("hidden");

        $("#lightbox__container_content").addClass("hidden");
        $(".lightbox__next").addClass("hidden");
        $(".lightbox__prev").addClass("hidden");

        $.ajax({
          type: "POST",
          url: ajaxurl,
          dataType: "html", 
          data: {
            action: "nathalie_mota_lightbox",
            nonce: nonce,
            photo_id: idPhoto,
            categorie_id: 49,
          },
          success: function (res) {

            $("#lightbox__container_content").empty().append(res);
            $(".lightbox__loader").addClass("hidden");
            $("#lightbox__container_content").removeClass("hidden");
            if (arrow && nb_total_posts > 1) {
              $(".lightbox__next").removeClass("hidden");
              $(".lightbox__prev").removeClass("hidden");
            }
          },
        });
      };
      $.close = function () {
        $(".lightbox").addClass("hidden");
      };
    });
  })(jQuery);
});