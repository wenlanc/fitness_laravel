@section('page-title', __tr('About'))
@section('head-title', __tr('About'))
@section('keywordName', strip_tags(__tr('About')))
@section('keyword', strip_tags(__tr('About')))
@section('description', strip_tags(__tr('About')))
@section('keywordDescription', strip_tags(__tr('About')))
@section('page-image', getStoreSettings('logo_image_url'))
@section('twitter-card-image', getStoreSettings('logo_image_url'))
@section('page-url', url()->current())

@include('front-include.header')

<body class="hidden-bar-wrapper">

  <div class="page-wrapper">

    <!-- Preloder -->
    <div id="preloder" class="preloader">
      <div class="loader"></div>
    </div>
    <!-- Εnd Preloader -->

    @include('front-include.menu')

    <!--Page Title-->
    <section class="page-title" style="background-image:url(dist/blackfit/images/newgym4-1@1x.png)">
      <div class="auto-container">
        <h2>ABOUT US</h2>
        <ul class="page-breadcrumb">
          <li><a href="index.html">home</a></li>
          <li>About Us</li>
        </ul>
      </div>
    </section>
    <!--End Page Title-->
    <!-- Testimonial Section -->
    <section class="testimonial-section">
      <div class="auto-container">
        <div class="inner-container">
          <div class="single-item-carousel owl-carousel owl-theme">

            <!-- Testimonial Block -->
            <div class="testimonial-block">
              <div class="inner-box">
                <div class="text">The number one place to build a community. We bridge the people
                  and the world to gyming. With our extensive research and optimum
                  tracking we have created a platofrm to help the Japanese
                  gyming community grow.</div>
              </div>
            </div>

            <!-- Testimonial Block -->
            <div class="testimonial-block">
              <div class="inner-box">
                <div class="text">Want to be healthy and have a perfect body? BLACKFIT is the right decision for you! It will create your personal training program and balance your diet so you could get the <br> shape of your dream shortly!</div>
              </div>
            </div>

            <!-- Testimonial Block -->
            <div class="testimonial-block">
              <div class="inner-box">
                <div class="text">The number one place to build a community. We bridge the people
                  and the world to gyming. With our extensive research and optimum
                  tracking we have created a platofrm to help the Japanese
                  gyming community grow.</div>
              </div>
            </div>

          </div>

        </div>

        <div class="about-text">
          <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt.</p>
          <p>Odipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit.</p>
        </div>

      </div>
    </section>
    <!-- End Testimonial Section -->

    @include('front-include.footer')
  </div>
  <!--End pagewrapper-->

  <!--Scroll to top-->
  <div class="scroll-to-top scroll-to-target" data-target="html"><span class="fa fa-angle-up"></span></div>

  <!-- Purchase Popup -->
  <div id="purchase-popup" class="purchase-popup">
    <div class="close-search theme-btn"><span>Close</span></div>
    <div class="popup-inner">
      <div class="overlay-layer"></div>

      <div class="purchase-form">
        <div class="sec-title centered">
          <h2><span>GET FREE</span> CONSULTATION</h2>
          <div class="text">If you need of a Personal Trainer, Fitness Instructor advice, or a healthy <br> living product review, please feel free to contact us</div>
        </div>

        <!-- Default Form -->
        <form method="post" action="contact.html">
          <div class="row clearfix">

            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
              <input type="text" name="name" placeholder="Name" required>
            </div>

            <div class="col-lg-6 col-md-6 col-sm-12 form-group">
              <input type="email" name="email" placeholder="Email" required>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
              <input type="text" name="subject" placeholder="Subject" required>
            </div>

            <div class="col-lg-12 col-md-12 col-sm-12 form-group">
              <textarea class="darma" name="message" placeholder="Your Message"></textarea>
            </div>

            <div class="form-group text-center col-lg-12 col-md-12 col-sm-12">
              <span class="data">* Personal data will be encrypted</span>
              <button class="theme-btn btn-style-one" type="submit" name="submit-form"><span class="txt">SEND MESSAGE</span></button>
            </div>

          </div>
        </form>


      </div>

    </div>
  </div>

  @include('front-include.js')
</body>

</html>