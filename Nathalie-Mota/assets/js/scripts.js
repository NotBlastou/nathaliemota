document.addEventListener("DOMContentLoaded", function () {
  const contactBtns = document.querySelectorAll(".contact");
  const popupOverlay = document.querySelector(".popup-overlay");
  contactBtns.forEach((contactBtn) => {
    contactBtn.addEventListener("click", function() {
      popupOverlay.classList.remove("hidden");
      const referenceElement = document.querySelector(".reference");
      if (referenceElement) {
        let fullRefText = referenceElement.innerText;
        let ref = fullRefText.replace('RÉFÉRENCE : ', '').trim();
        const refPhotoField = document.querySelector("input[name='your-subject']");
        if (refPhotoField) {
          refPhotoField.value = ref;
        }
      }
    });
  });

  popupOverlay.addEventListener("click", function(e) {
    if (e.target === popupOverlay) {
      popupOverlay.classList.add("hidden");
    }
  });
});

(function($) {
  $(document).ready(function() {
      $('#categorie_id').select2({minimumResultsForSearch: Infinity});
    $('#format_id').select2({minimumResultsForSearch: Infinity});
    $('#date').select2({minimumResultsForSearch: Infinity});
  });
})(jQuery);

console.log('menuBurger.js');

jQuery(document).ready(function ($) { 
    const header = $('header');
    const menuBurger = $('.burgerMenu');
    const nav = $('.nav-links-container');
    const menuLinks = $('.header-menu li a');

    menuBurger.on('click', function () {
        const isOpen = header.hasClass('open');

        header.toggleClass('open', !isOpen);
        menuBurger.toggleClass('open', !isOpen);
        nav.toggleClass('open', !isOpen);
    });
});

