import Isotope from 'isotope-layout';
import imagesLoaded from 'imagesloaded';
import imgGallery from './utils/gallery';

(function() {
  'use strict';

  var galleries = document.querySelectorAll('.asifa-gallery');

  imgGallery('.asifa-gallery-ui');

  for (var i = 0; i < galleries.length; i++) {
    let gallery = galleries[i];

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

      for (var j = 0; j < filters.length; j++) {
        var filter = filters[j];

        let value = filter.dataset.filter;

        filter.onclick = function(e) {
          isotope.arrange({filter: value});

          var current = document.querySelector('.current');
          current.classList.remove('current');
          this.classList.add('current');
          return false;
        };
      }

      preloader.classList.add('hidden');
      container.classList.remove('hidden');
    });
  }

})();
