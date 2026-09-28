(function () {
  'use strict';

  var toggle = document.getElementById('dvs-nav-toggle');
  var mobileNav = document.getElementById('dvs-mobile-nav');
  var header = document.getElementById('site-header');

  if (toggle && mobileNav) {
    toggle.addEventListener('click', function () {
      var isOpen = mobileNav.classList.toggle('is-open');
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      document.body.style.overflow = isOpen ? 'hidden' : '';
    });

    // Close mobile nav when a link inside it is clicked.
    mobileNav.addEventListener('click', function (e) {
      if (e.target.tagName === 'A') {
        mobileNav.classList.remove('is-open');
        toggle.setAttribute('aria-expanded', 'false');
        document.body.style.overflow = '';
      }
    });
  }

  // Slight shadow on header after scrolling.
  if (header) {
    var onScroll = function () {
      if (window.scrollY > 8) {
        header.style.boxShadow = '0 4px 16px rgba(11,31,58,0.08)';
      } else {
        header.style.boxShadow = 'none';
      }
    };
    document.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }
})();
