

document.addEventListener("DOMContentLoaded", function () {

  let total_posts = "";
  if (document.getElementById("total_posts") !== null) {
    total_posts = document.getElementById("total_posts").value;

    total_posts = total_posts.slice(8, total_posts.length - 3);
  }

  let nb_total_posts = 1;
  if (document.getElementById("nb_total_posts") !== null) {
    nb_total_posts = document.getElementById("nb_total_posts").value;
  }


  let regex1 = /[(]/g;
  let regex2 = /[)]/g;

  let arrayIntial = total_posts;
  let arrayFinish = new Array();
  let data = new Array();

  recupArrayPhp();

  let idPhoto = null;
  let idValue = 10;
  let arrow = "";

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
      $(".openLightbox").click(function (e) {
        e.preventDefault();

        const ajaxurl = $(this).data("ajaxurl");

        arrow = "true";
        if (!$(this).data("arrow")) {
          arrow = $(this).data("arrow");
        }

        if (!$(this).data("postid")) {
          console.log(
            "Identifiant manquant. Récupération du premier de la liste"
          );
          recupIdPhoto(0);
        } else {
          idPhoto = $(this).data("postid");
        }
        recupIdData(idPhoto);

        $(".lightbox").removeClass("hidden");

        $("#lightbox__container_content").empty();
        $.changePhoto();
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
        console.log("id: " + idValue + " - id Photo: " + idPhoto);
        recupIdPhoto(idValue);
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
          },
          success: function (res) {
            $("#lightbox__container_content").empty().append(res);
            $(".lightbox__loader").addClass("hidden");
            $("#lightbox__container_content").removeClass("hidden");
            if (arrow) {
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