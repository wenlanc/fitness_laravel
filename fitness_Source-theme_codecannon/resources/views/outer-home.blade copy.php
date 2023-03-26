<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="<?= config('CURRENT_LOCALE_DIRECTION') ?>" class="lw-light-theme">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title><?= getStoreSettings('name') ?></title>

  <?= __yesset([
    'dist/css/public-assets-app*.css',
    'dist/fa/css/all.min.css',
    'dist/css/dev.css',
    'dist/css/home*.css'
  ], true) ?>
  <?= __yesset([
    'dist/blackfit/css/bootstrap.css',
    'dist/blackfit/css/style.css',
    'dist/blackfit/css/responsive.css',
  ], true) ?>
  <link href="https://fonts.googleapis.com/css?family=Varela+Round" rel="stylesheet">

  <link rel="shortcut icon" href="<?= getStoreSettings('favicon_image_url') ?>" type="image/x-icon">
  <link rel="icon" href="<?= getStoreSettings('favicon_image_url') ?>" type="image/x-icon">
  <style>
    .masthead {
      background: linear-gradient(to bottom, rgba(22, 22, 22, 0.3) 0%, rgba(22, 22, 22, 0.7) 75%, #161616 100%), url(<?= __yesset("imgs/home/random/*.jpg", false, [
                                                                                                                        'random' => true
                                                                                                                      ]) ?>);
      background-position: top left;
      background-repeat: no-repeat;
      background-attachment: scroll;
      background-size: cover;
    }
  </style>
</head>

<body id="page-top">

  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
    <div class="container">
      <a class="navbar-brand js-scroll-trigger" href="#page-top">
        <img class="lw-logo-img" src="<?= getStoreSettings('logo_image_url') ?>" alt="<?= getStoreSettings('name') ?>">
      </a>
      <button class="navbar-toggler navbar-toggler-right" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
        Menu
        <i class="fas fa-bars"></i>
      </button>
      <?php $translationLanguages = getActiveTranslationLanguages(); ?>
      <div class="collapse navbar-collapse" id="navbarResponsive">
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#premium"><?= __tr('Premium') ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#features"><?= __tr('Features') ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link js-scroll-trigger" href="#contact"><?= __tr('Contact') ?></a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="<?= route('user.login') ?>"><?= __tr('Login') ?></a>
          </li>
          <!-- Language Menu -->
          @if(!__isEmpty($translationLanguages) and (count($translationLanguages) > 1))
          <?php $translationLanguages['en_US'] = configItem('default_translation_language');  ?>
          <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <span class="d-none d-md-inline-block"><?= (isset($translationLanguages[config('CURRENT_LOCALE')])) ? $translationLanguages[config('CURRENT_LOCALE')]['name'] : '' ?></span>
              &nbsp; <i class="fas fa-language"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
              <h6 class="dropdown-header">
                <?= __tr('Choose your language') ?>
              </h6>
              <div class="dropdown-divider"></div>
              <?php foreach ($translationLanguages as $languageId => $language) {
                if ($languageId == config('CURRENT_LOCALE') or (isset($language['status']) and $language['status'] == false)) continue;
              ?>
                <a class="dropdown-item" href="<?= route('locale.change', ['localeID' => $languageId]) . '?redirectTo=' . base64_encode(Request::fullUrl());  ?>">
                  <?= $language['name'] ?>
                </a>
              <?php } ?>
            </div>
          </li>
          @endif
          <!-- Language Menu -->
        </ul>
      </div>
    </div>
  </nav>

  <!-- Header -->
  <header class="masthead">
    <div class="container d-flex h-100 align-items-center pt-5">
      <div class="mx-auto text-center lw-main-text-block">
        <h1 class="mx-auto my-0 text-uppercase"><?= __tr('Find Your Love') ?></h1>
        <h2 class="text-white-50 mx-auto mt-2 mb-5"><?= __tr('One stop destination for finding your love', [
                                                      '__siteName__' =>  getStoreSettings('name')
                                                    ]) ?></strong></h2>
        <a href="#search" class="btn btn-primary js-scroll-trigger"><?= __tr('Get Started') ?></a>
        <p class="mt-5 pt-5 text-white-50"><?= __tr('You can modify the content on this page by editing outer home page view.') ?></p>
      </div>
    </div>
  </header>
  </div>

  <!-- contact Section -->
  <section id="search" class="lw-search-section">
    <div class="container">
      <div class="row">
        <div class="col-md-10 col-lg-8 mx-auto text-center">

          <i class="fa fa-search fa-4x mb-2 text-white"></i>
          <h2 class="text-white mb-5"><?= __tr('Find perfect match') ?></h2>
          <form class="d-flex" method="post" action="<?= route('search_matches') ?>">
            <div class="input-group">
              <input type="hidden" name="_token" id="csrf-token" value="<?= csrf_token() ?>" />
              <select name="looking_for" class="custom-select form-control">
                <option disabled><?= __tr('Looking for') ?></option>
                <option value="all" selected><?= __tr('All') ?></option>
                @foreach(configItem('user_settings.gender') as $genderKey => $gender)
                <option value="<?= $genderKey ?>"><?= $gender ?></option>
                @endforeach
              </select>
              <select name="min_age" class="custom-select form-control">
                <option disabled><?= __tr('Age from') ?></option>
                @foreach(configItem('user_settings.age_range') as $age)
                <option value="<?= $age ?>" <?= $age == configItem('user_settings.default_min_age') ? 'selected' : '' ?>><?= __tr('__translatedAge__', [
                                                                                                                            '__translatedAge__' => $age
                                                                                                                          ]) ?></option>
                @endforeach
              </select>
              <select name="max_age" class="custom-select form-control">
                <option disabled><?= __tr('Age till') ?></option>
                @foreach(configItem('user_settings.age_range') as $age)
                <option value="<?= $age ?>" <?= $age == configItem('user_settings.default_max_age') ? 'selected' : '' ?>><?= __tr('__translatedAge__', [
                                                                                                                            '__translatedAge__' => $age
                                                                                                                          ]) ?></option>
                @endforeach
              </select>
              <div class="input-group-append">
                <button class="btn btn-primary" type="submit"><?= __tr('Search') ?></button>
              </div>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>

  <!-- premium Section -->
  <section id="premium" class="premium-section text-center parallax-window" data-parallax="scroll" data-image-src="<?= asset('imgs/home/hands-1150073_1920.jpg') ?>">
    <div class="container">
      <div class="row card lw-transparent-card">
        <div class="col-lg-8 mx-auto pb-4">
          <h2>
            <i class="fas fa-heart text-white"></i>
          </h2>
          <h2 class="text-white mb-4"><?= __tr('Premium Features') ?></h2>
          <div class="text-white-50">
            <h5 class="lw-feature-items"> <?= __tr('No Ads, Browse in Incognito mode, See Who Likes you, View likes Notifications, Priority In Search Result, Priority In Random User, Audio Call Via Messenger, Video Call Via Messenger, Unlimited User Encounters, Discounts in Stickers & Gifts and Many more ...') ?></h5>
          </div>
        </div>
      </div>
  </section>

  <!-- features Section -->
  <section id="features" class="features-section bg-dark">
    <div class="container">

      <!-- Featured features Row -->
      <div class="row align-items-center no-gutters mb-4 mb-lg-5">
        <div class="col-xl-8 col-lg-7">
          <img class="img-fluid mb-3 mb-lg-0" src="imgs/home/grass-2563424_1920.jpg" alt="">
        </div>
        <div class="col-xl-4 col-lg-5 text-white pl-3">
          <div class="featured-text text-center text-lg-left">
            <h4><i class="fas fa-user"></i> <?= __tr('Register') ?></h4>
            <p class="text-white-50 mb-0"><?= __tr('Registrations are free & quick') ?></p>
          </div>
          <div class="featured-text text-center text-lg-left mt-4">
            <h4><i class="fas fa-id-card"></i> <?= __tr('Profile') ?></h4>
            <p class="text-white-50 mb-0"><?= __tr('Complete your profile information') ?></p>
          </div>
          <div class="featured-text text-center text-lg-left mt-4">
            <h4><i class="fas fa-search"></i> <?= __tr('Find') ?></h4>
            <p class="text-white-50 mb-0"><?= __tr('Search for person you are looking for') ?></p>
          </div>
        </div>
      </div>

      <!-- features Two Row -->
      <div class="row justify-content-center no-gutters">
        <div class="col-lg-6">
          <img class="img-fluid" src="imgs/home/demo-image-02.jpg" alt="">
        </div>
        <div class="col-lg-6 order-lg-first pr-3">
          <div class="bg-dark text-center h-100 features">
            <div class="d-flex h-100">
              <div class="features-text w-100 my-auto text-center text-lg-right">
                <h4 class="text-white"><?= __tr('Encounter') ?></h4>
                <p class="mb-0 text-white-50"><?= __tr('Get encounter with the person, you may interested in') ?></p>
                <hr class="d-none d-lg-block mb-0 mr-0">
              </div>
            </div>
          </div>
        </div>
      </div>

      <!-- features One Row -->
      <div class="row justify-content-center no-gutters mb-5 mb-lg-0">
        <div class="col-lg-6">
          <img class="img-fluid" src="imgs/home/demo-image-01.jpg" alt="">
        </div>
        <div class="col-lg-6 pl-3">
          <div class="bg-dark text-center h-100 features">
            <div class="d-flex h-100">
              <div class="features-text w-100 my-auto text-center text-lg-left">
                <h4 class="text-white"><?= __tr('Complete your profile') ?></h4>
                <p class="mb-0 text-white-50"><?= __tr('An example of where you can put an image of a features, or anything else, along with a description.') ?></p>
                <hr class="d-none d-lg-block mb-0 ml-0">
              </div>
            </div>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="contact-section bg-dark">
    <div class="container">

      <div class="row">

        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card py-4 h-100">
            <div class="card-body text-center">
              <i class="fas fa-map-marked-alt text-primary mb-2"></i>
              <h4 class="text-uppercase m-0"><?= __tr('Address') ?></h4>
              <hr class="my-4">
              <div class="small">4923 Market Street, Orlando FL</div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card py-4 h-100">
            <div class="card-body text-center">
              <i class="fas fa-envelope text-primary mb-2"></i>
              <h4 class="text-uppercase m-0"><?= __tr('Email') ?></h4>
              <hr class="my-4">
              <div class="small">
                <a href="#">hello@yourdomain.com</a>
              </div>
            </div>
          </div>
        </div>

        <div class="col-md-4 mb-3 mb-md-0">
          <div class="card py-4 h-100">
            <div class="card-body text-center">
              <i class="fas fa-mobile-alt text-primary mb-2"></i>
              <h4 class="text-uppercase m-0"><?= __tr('Phone') ?></h4>
              <hr class="my-4">
              <div class="small">+1 (555) 902-8832</div>
            </div>
          </div>
        </div>
      </div>

      <div class="social d-flex justify-content-center">
        <a href="#" class="mx-2">
          <i class="fab fa-twitter"></i>
        </a>
        <a href="#" class="mx-2">
          <i class="fab fa-facebook-f"></i>
        </a>
      </div>

    </div>
  </section>

  <!-- Footer -->
  <footer class="bg-dark small text-center text-white-50">
    <div class="container">
      <?= __tr('Copyright © __siteName__ __year__', [
        '__year__' => date('Y'),
        '__siteName__' => getStoreSettings('name')
      ]) ?>
    </div>
  </footer>
  <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
  <?= __yesset([
    'dist/js/vendorlibs-public.js',
    // 'dist/js/vendorlibs-datatable.js',
    // 'dist/js/vendorlibs-photoswipe.js',
    // 'dist/js/common-app.*.js',
    // 'dist/js/vendor-second.js',
    // 'dist/js/vendorlibs-smartwizard.js'
  ], true) ?>

  <script>
    (function($) {
      "use strict"; // Start of use strict

      // Smooth scrolling using jQuery easing
      $('a.js-scroll-trigger[href*="#"]:not([href="#"])').click(function() {
        if (location.pathname.replace(/^\//, '') == this.pathname.replace(/^\//, '') && location.hostname == this.hostname) {
          var target = $(this.hash);
          target = target.length ? target : $('[name=' + this.hash.slice(1) + ']');
          if (target.length) {
            $('html, body').animate({
              scrollTop: (target.offset().top - 70)
            }, 1000, "easeInOutExpo");
            return false;
          }
        }
      });

      // Closes responsive menu when a scroll trigger link is clicked
      $('.js-scroll-trigger').click(function() {
        $('.navbar-collapse').collapse('hide');
      });

      // Activate scrollspy to add active class to navbar items on scroll
      $('body').scrollspy({
        target: '#mainNav',
        offset: 100
      });

      // Collapse Navbar
      var navbarCollapse = function() {
        if ($("#mainNav").offset().top > 100) {
          $("#mainNav").addClass("navbar-shrink");
        } else {
          $("#mainNav").removeClass("navbar-shrink");
        }
      };
      // Collapse now if page is not at top
      navbarCollapse();
      // Collapse the navbar when page is scrolled
      $(window).scroll(navbarCollapse);

    })(jQuery); // End of use strict
  </script>

</body>

</html>