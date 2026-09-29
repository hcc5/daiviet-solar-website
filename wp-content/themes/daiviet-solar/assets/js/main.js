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

// ---------- Mobile dropdown submenu toggle ----------
(function () {
  'use strict';
  var items = document.querySelectorAll('.dvs-mobile-nav__list .menu-item-has-children');
  items.forEach(function (li) {
    var link = li.querySelector(':scope > a');
    if (!link) return;
    link.addEventListener('click', function (e) {
      e.preventDefault();
      var isOpen = li.classList.toggle('is-open');
      link.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });
  });
})();

// ---------- Hero image slider ----------
(function () {
  'use strict';
  var slider = document.querySelector('.dvs-slider');
  if (!slider) return;

  var slides = slider.querySelectorAll('.dvs-slider__slide');
  var dots = slider.querySelectorAll('.dvs-slider__dots button');
  var prevBtn = slider.querySelector('.dvs-slider__nav--prev');
  var nextBtn = slider.querySelector('.dvs-slider__nav--next');
  var current = 0;
  var timer = null;
  var AUTOPLAY_MS = 5500;

  function goTo(index) {
    if (!slides.length) return;
    current = (index + slides.length) % slides.length;
    slides.forEach(function (s, i) { s.classList.toggle('is-active', i === current); });
    dots.forEach(function (d, i) { d.classList.toggle('is-active', i === current); });
  }

  function next() { goTo(current + 1); }
  function prev() { goTo(current - 1); }

  function startAutoplay() {
    stopAutoplay();
    timer = window.setInterval(next, AUTOPLAY_MS);
  }
  function stopAutoplay() {
    if (timer) { window.clearInterval(timer); timer = null; }
  }

  if (nextBtn) nextBtn.addEventListener('click', function () { next(); startAutoplay(); });
  if (prevBtn) prevBtn.addEventListener('click', function () { prev(); startAutoplay(); });
  dots.forEach(function (dot, i) {
    dot.addEventListener('click', function () { goTo(i); startAutoplay(); });
  });

  slider.addEventListener('mouseenter', stopAutoplay);
  slider.addEventListener('mouseleave', startAutoplay);

  if (slides.length > 1) {
    startAutoplay();
  }
})();
