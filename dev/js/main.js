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

      var filters = document.querySelectorAll('.asifa-gallery-filter');

      filters.forEach(function(filter) {
        let value = filter.dataset.filter;

        filter.onclick = function(e) {
          isotope.arrange({filter: value});

          var current = document.querySelector('.current');
          current.classList.remove('current');
          this.classList.add('current');
          return false;
        };
      });

      preloader.classList.add('hidden');
      container.classList.remove('hidden');

    });
  });
})();
