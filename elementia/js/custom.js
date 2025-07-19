
$(document).ready(function() {

  	/*-------------------------------------
  		progressBar  
  	-------------------------------------*/
    function animateProgressBar(pb) {
      if ($.fn.visible && $(pb).visible() && !$(pb).hasClass('animated')) {
        $(pb).css('width', $(pb).attr('aria-valuenow') + '%');
        $(pb).addClass('animated');
      }
    }

    function initProgressBar() {
      var progressBar = $('.progress-bar');
      progressBar.each(function () {
        animateProgressBar(this);
      });
    }

    initProgressBar();

    /*-------------------------------------------
      Modal Velocity Js
    -------------------------------------------*/

    $(".cpe-modal").each(function() {
      $(this).on('show.bs.modal', function(e) {
        var open = $(this).attr('data-easein');
        if (open == 'shake') {
          $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'pulse') {
          $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'tada') {
          $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'flash') {
          $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'bounce') {
          $('.modal-dialog').velocity('callout.' + open);
        } else if (open == 'swing') {
          $('.modal-dialog').velocity('callout.' + open);
        } else {
          $('.modal-dialog').velocity('transition.' + open);
        }

      });
    });

    /*-------------------------------------------
    Magnific PopUp
    -------------------------------------------*/

    $('.cpe-gallery').each(function () { // the containers for all your galleries
      $(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
            enabled: true,
            // arrowMarkup: '<button title="%title%" type="button" class="mfp-arrow mfp-arrow-%dir%"><i class="fa fa-angle-%dir%"></i></button>'
        },
      });
    });

    $('.cpe-flickr-gallery').each(function () { // the containers for all your galleries
      $(this).magnificPopup({
        delegate: 'a', // the selector for gallery item
        type: 'image',
        gallery: {
            enabled: true
        },
      });
    });


    /*-------------------------------------
    Flickr Gallery
    -------------------------------------*/

    $("#cpe-flickr-gallery").jsFlickrGallery({
      pagination: {
        generate: false
      },
      modal: {
        generate: false
      }
    });

    $("#cpe-flickr-gallery-small").jsFlickrGallery({
      pagination: {
        generate: false
      },
      modal: {
        generate: false
      }
    });


    $("#cpe-flickr-gallery-half1").jsFlickrGallery({
      pagination: {
        generate: false
      },
      modal: {
        generate: false
      }
    });

    $("#cpe-flickr-gallery-half2").jsFlickrGallery({
      pagination: {
        generate: false
      },
      modal: {
        generate: false
      }
    });

    $("#cpe-flickr-gallery-center").jsFlickrGallery({
      pagination: {
        generate: false
      },
      modal: {
        generate: false
      }
    });


    /*-------------------------------------
      CountTo
      -------------------------------------*/
    function animateNumberProgress(npv) {
      if ($.fn.visible && $(npv).visible() && !$(npv).hasClass('animated')) {
        $(npv).countTo({
          time: 2000,
          refreshInterval: 1
        });
        $(npv).addClass('animated');
      } 
    }

    function initNumberProgress() {
      var numberProgress = $('.counter');
      numberProgress.each(function () {
        animateNumberProgress(this);
      });
    }

    initNumberProgress();

    /*-------------------------------------
      Rounded Progressbar
    -------------------------------------*/
    function animateRoundedProgress(rpb) {
      if ($.fn.visible && $(rpb).visible() && !$(rpb).hasClass('animated') && $(rpb).hasClass('circle-sm')) {
        $(rpb).css('stroke-dashoffset', 314.159265 - (314.159265 / 100) * $(rpb).attr('aria-valuenow'));
      } else if ($.fn.visible && $(rpb).visible() && !$(rpb).hasClass('animated') && $(rpb).hasClass('progress-chart')) {
        $(rpb).css('stroke-dashoffset', 471.2389 - (471.2389 / 100) * $(rpb).attr('aria-valuenow'));
      } else if ($.fn.visible && $(rpb).visible() && !$(rpb).hasClass('animated')) {
        $(rpb).css('stroke-dashoffset', 521.504380 - (521.504380 / 100) * $(rpb).attr('aria-valuenow'));
      }
    }

    function initRoundedProgress() {
      var roundedProgress = $('.progress-circle');
      roundedProgress.each(function () {
        animateRoundedProgress(this);
      });
    }

    initRoundedProgress();


    /*-------------------------------------------
      CountDown
      -------------------------------------------*/
    $('.cpe-countdown-time').each(function () {
      var endTime = $(this).data('time');
      $(this).countdown(endTime, function (tm) {
        $(this).html(tm.strftime('<span class="section_count"><span class="tcount days">%D </span><span class="text">Days</span></span><span class="section_count"><span class="tcount hours">%H</span><span class="text">Hours</span></span><span class="section_count"><span class="tcount minutes">%M</span><span class="text">Minutes</span></span><span class="section_count"><span class="tcount seconds">%S</span><span class="text">Seconds</span></span>'));
      });
    });

    //Countdown style 3
    $('.cpe-countdown-3').each(function () {
      var endTime = $(this).data('time');
      $(this).countdown(endTime, function (tm) {
        var countTxt = '';
        var countDay = 521.504380 - (521.504380 / 365) * (tm.strftime('%D'));
        var countHour = 521.504380 - (521.504380 / 24) * (tm.strftime('%H'));
        var countMin = 521.504380 - (521.504380 / 60) * (tm.strftime('%M'));
        var countSec = 521.504380 - (521.504380 / 60) * (tm.strftime('%S'));
        countTxt += '<div class="cp-column-4"><span class="section_count"><span class="section_count_data"><span class="count-data"><span class="tcount days">%D </span><span class="text">Days</span></span><svg height="170" width="170"><circle cx="85" cy="85" r="83" stroke-width="4" fill="none" style="stroke-dashoffset:' + countDay + '"/></svg></span></span></div>';
        countTxt += '<div class="cp-column-4"><span class="section_count"><span class="section_count_data"><span class="count-data"><span class="tcount hours">%H</span><span class="text">Hours</span></span><svg height="170" width="170"><circle cx="85" cy="85" r="83" stroke-width="4" fill="none" style="stroke-dashoffset:' + countHour + '"/></svg></span></span></div>';
        countTxt += '<div class="cp-column-4"><span class="section_count"><span class="section_count_data"><span class="count-data"><span class="tcount minutes">%M</span><span class="text">Minutes</span></span><svg height="170" width="170"><circle cx="85" cy="85" r="83" stroke-width="4" fill="none" style="stroke-dashoffset:' + countMin + '"/></svg></span></span></div>';
        countTxt += '<div class="cp-column-4"><span class="section_count"><span class="section_count_data"><span class="count-data"><span class="tcount seconds">%S</span><span class="text">Seconds</span></span><svg height="170" width="170"><circle cx="85" cy="85" r="83" stroke-width="4" fill="none" style="stroke-dashoffset:' + countSec + '"/></svg></span></span></div>';

        $(this).html(tm.strftime(countTxt));
      });
    });


    /*-------------------------------------
      Isotope
    -------------------------------------*/

    var $grid = $('.grid').isotope({
      // options...
      itemSelector: '.grid-item',
      masonry: {
        columnWidth: 0
      }
    });
    // layout Isotope after each image loads
    $grid.imagesLoaded().progress(function () {
        $grid.isotope('layout');
    });

    $('#cpe-nav .btn').on('click', function () {
      $('#cpe-nav .btn-filter').removeClass('active');
      $(this).addClass('active');

      var selector = $(this).attr('data-filter');
      $('.grid.filter-grid').isotope({
          filter: selector
      });
      return false;
    });

    $('#cpe-nav-right .btn').on('click', function () {
      $('#cpe-nav-right .btn-filter').removeClass('active');
      $(this).addClass('active');

      var selector = $(this).attr('data-filter');
      $('.grid.filter-grid').isotope({
          filter: selector
      });
      return false;
    });

    $('#cpe-nav2 .btn').on('click', function () {
      $('#cpe-nav2 .btn-filter').removeClass('active');
      $(this).addClass('active');

      var selector = $(this).attr('data-filter');
      $('.grid.filter-grid2').isotope({
          filter: selector
      });
      return false;
    });


    /*-------------------------------------------
    Owl Carousel
    -------------------------------------------*/

    if ($("#cpe-testimonial-italic").length > 0) {
      $("#cpe-testimonial-italic").owlCarousel({
        singleItem: true,
        slideSpeed: 200,
        autoPlay: 3000,
        stopOnHover: true,
        navigation: false,
        pagination: false
      });
    }

    if ($("#cpe-testimonial-classic").length > 0) {
      $("#cpe-testimonial-classic").owlCarousel({
        singleItem: true,
        slideSpeed: 200,
        autoPlay: 3000,
        stopOnHover: true,
        navigation: true,
        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        pagination: false
      });
    }

    if ($("#cpe-testimonial-standard").length > 0) {
      $("#cpe-testimonial-standard").owlCarousel({
        singleItem: true,
        slideSpeed: 200,
        autoPlay: 3000,
        stopOnHover: true,
        navigation: true,
        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        pagination: false
      });
    }

    if ($("#cpe-full-grid").length > 0) {
      $("#cpe-full-grid").owlCarousel({
        singleItem: true,
        slideSpeed: 200,
        autoPlay: 3000,
        stopOnHover: true,
        navigation: true,
        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        pagination: false
      });
    }

    if ($("#cpe-half-grid").length > 0) {
      $("#cpe-half-grid").owlCarousel({
        singleItem: true,
        slideSpeed: 200,
        autoPlay: 3000,
        stopOnHover: true,
        navigation: true,
        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        pagination: false
      });
    }

    if ($("#cpe-half-classic").length > 0) {
      $("#cpe-half-classic").owlCarousel({
        singleItem: true,
        slideSpeed: 200,
        autoPlay: 3000,
        stopOnHover: true,
        navigation: false,
        pagination: true,
        paginationNumbers: false
      });
    }

    if ($("#cpe-full-width").length > 0) {
      $("#cpe-full-width").owlCarousel({
        singleItem: true,
        slideSpeed: 200,
        autoPlay: 3000,
        stopOnHover: true,
        navigation: true,
        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        pagination: false
      });
    }

    if ($("#cpe-client").length > 0) {
      $("#cpe-client").owlCarousel({
        singleItem: false,
        items: 6,
        slideSpeed: 200,
        autoPlay: 3000,
        stopOnHover: true,
        navigation: true,
        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        pagination: false
      });
    }

    if ($("#cpe-product-calousel").length > 0) {
      $("#cpe-product-calousel").owlCarousel({
        singleItem: false,
        items: 4,
        slideSpeed: 200,
        autoPlay: 3000,
        stopOnHover: true,
        navigation: true,
        navigationText: ['<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>'],
        pagination: false
      });
    }

    $(window).on('scroll', function () {
      initProgressBar();
      initRoundedProgress();
      initNumberProgress();
    });


    
});