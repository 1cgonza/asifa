import Isotope from 'isotope-layout';
import imagesLoaded from 'imagesloaded';

(function() {
  'use strict';

  var galleries = document.querySelectorAll('.asifa-gallery');

  galleries.forEach(function(gallery) {
    imagesLoaded(gallery, function() {
      var preloader = gallery.querySelector('.preloader');
      var container = gallery.querySelector('.gallery-wrapper');

      var isotope = new Isotope(container, {
        itemSelector: '.gallery-item',
        percentPosition: true,
        masonry: {
          columnWidth: '.gallery-item'
        }
      });

      preloader.classList.add('hidden');
      container.classList.remove('hidden');

    });
  });
})();
