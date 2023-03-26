@section('page-title', __tr('Home'))
@section('head-title', __tr('Home'))
@section('keywordName', strip_tags(__tr('Home')))
@section('keyword', strip_tags(__tr('Home')))
@section('description', strip_tags(__tr('Home')))
@section('keywordDescription', strip_tags(__tr('Home')))
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
    <!-- Banner Section -->
    <section class="banner-section">
      <div class="main-slider-carousel owl-carousel owl-theme">

        <div class="slide">
          <div class="image-layer" style="background-image:url(dist/blackfit/images/mask-group@1x.svg)"></div>
          <div class="auto-container">
            <!-- Content Boxed -->
            <div class="content-boxed">
              <div class="inner-boxed">
                <h1>BE A PART OF A <span>COMMUNITY</span></h1>
                <div class="text">STACKD - a fitness community building platform. Bringing people<br> together and building each other up to be stronger!</div>
                <div class="btns-box">
                  <div class="theme-btn purchase-box-btn btn-style-one"><span class="txt">LET’S TRAIN</span></div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="slide">
          <div class="image-layer" style="background-image:url(dist/blackfit/images/mask-group@1x.svg)"></div>
          <div class="auto-container">
            <!-- Content Boxed -->
            <div class="content-boxed">
              <div class="inner-boxed">
                <h1>BE A PART OF A <span>COMMUNITY</span></h1>
                <div class="text">STACKD - a fitness community building platform. Bringing people<br> together and building each other up to be stronger!</div>
                <div class="btns-box">
                  <div class="theme-btn purchase-box-btn btn-style-one"><span class="txt">LET’S TRAIN</span></div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="slide">
          <div class="image-layer" style="background-image:url(dist/blackfit/images/mask-group@1x.svg)"></div>
          <div class="auto-container">
            <!-- Content Boxed -->
            <div class="content-boxed">
              <div class="inner-boxed">
                <h1>BE A PART OF A <span>COMMUNITY</span></h1>
                <div class="text">STACKD - a fitness community building platform. Bringing people<br> together and building each other up to be stronger!</div>
                <div class="btns-box">
                  <div class="theme-btn purchase-box-btn btn-style-one"><span class="txt">LET’S TRAIN</span></div>
                </div>
              </div>
            </div>
          </div>

        </div>

        <div class="slide">
          <div class="image-layer" style="background-image:url(dist/blackfit/images/mask-group@1x.svg)"></div>
          <div class="auto-container">
            <!-- Content Boxed -->
            <div class="content-boxed">
              <div class="inner-boxed">
                <h1>BE A PART OF A <span>COMMUNITY</span></h1>
                <div class="text">STACKD - a fitness community building platform. Bringing people<br> together and building each other up to be stronger!</div>
                <div class="btns-box">
                  <div class="theme-btn purchase-box-btn btn-style-one"><span class="txt">LET’S TRAIN</span></div>
                </div>
              </div>
            </div>
          </div>

        </div>

      </div>

      <!--Scroll Dwwn Btn-->
      <div class="mouse-btn-down scroll-to-target" data-target=".testimonial-section">
        <span class="icon"><img src="dist/blackfit/images/icons/scroll.png" alt="" /></span>
      </div>

    </section>
    <!-- End Banner Section -->

    <!-- Testimonial Section -->
    <section class="testimonial-section">
      <div class="auto-container">
        <div class="inner-container">
          <!-- Testimonial Block -->
          <div class="testimonial-block">
            <div class="inner-box">
              <div class="text">Want to be healthy and have a perfect body? BLACKFIT is the right decision for you! It will create your personal training program and balance your diet so you could get the <br> shape of your dream shortly!</div>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- End Testimonial Section -->

    <!-- Services Section -->
    <section class="services-section">
      <div class="outer-container">
        <div class="clearfix">

          <!-- Service Block -->
          <div class="service-block col-lg-4 col-md-4 col-sm-12">
            <div class="inner-box">
              <div class="image">
                <a href="#" class="overlay-link"></a>
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <h4><a href="#">MATCH</a></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Service Block -->
          <div class="service-block col-lg-4 col-md-4 col-sm-12">
            <div class="inner-box">
              <div class="image">
                <a href="body-builder.html" class="overlay-link"></a>
                <img src="dist/blackfit/images/rectangle-5@1x.png" alt="" />
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <h4><a href="body-builder.html">CONNECT</a></h4>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Service Block -->
          <div class="service-block col-lg-4 col-md-4 col-sm-12">
            <div class="inner-box">
              <div class="image">
                <a href="body-builder.html" class="overlay-link"></a>
                <img src="dist/blackfit/images/rectangle-6@1x.png" alt="" />
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <h4><a href="body-builder.html">TRAIN</a></h4>
                    </div>
                  </div>
                </div>

              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- End Services Section -->

    <!-- We Are Section -->
    <section class="we-are-section">
      <div class="auto-container">
        <div class="sec-title centered">
          <h2><span>WHO</span> We Are</h2>
          <div class="text">
            We are a team of international people involved in the fitness industry. We came
            <br> together from a mutual love of keeping fit and getting stronger. However living in Japan
            <br> we have felt that it is extremely cold and distant to how our usual gym environment are
            <br> like in our home countries. Because of this we created a platform to help build
            <br>Japan’s fitness community
          </div>
        </div>

        <!--Video Box-->
        <div class="video-box">
          <figure class="video-image">
            <img src="dist/blackfit/images/rectangle-70@1x.png" alt="">
          </figure>
          <a href="https://www.youtube.com/watch?v=kxPCFljwJws" class="lightbox-image overlay-box"><span>
              <img src="dist/blackfit/images/icons/play-icon.png" alt="" /><i class="ripple"></i></span></a>
        </div>

        <!-- Button Box -->
        <div class="button-box text-center">
          <div class="heme-btn btn-style-one purchase-box-btn"><span class="txt">FREE CONSULTATION</span></div>
        </div>

      </div>
    </section>
    <!-- End We Are Section -->

    <!-- Gallery Section -->
    <section class="gallery-section">
      <div class="outer-container">
        <div class="row clearfix">

          <!-- Gallery Block -->
          <div class="gallery-block">
            <div class="inner-box">
              <div class="image">
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <a class="overlay-link" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="CONNECTION"></a>
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <a class="plus" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="TRAIN"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Gallery Block -->
          <div class="gallery-block">
            <div class="inner-box">
              <div class="image">
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <a class="overlay-link" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="CONNECTION"></a>
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <a class="plus" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="TRAIN"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Gallery Block -->
          <div class="gallery-block">
            <div class="inner-box">
              <div class="image">
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <a class="overlay-link" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="CONNECTION"></a>
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <a class="plus" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="TRAIN"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Gallery Block -->
          <div class="gallery-block">
            <div class="inner-box">
              <div class="image">
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <a class="overlay-link" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="CONNECTION"></a>
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <a class="plus" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="TRAIN"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Gallery Block -->
          <div class="gallery-block">
            <div class="inner-box">
              <div class="image">
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <a class="overlay-link" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="CONNECTION"></a>
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <a class="plus" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="TRAIN"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Gallery Block -->
          <div class="gallery-block">
            <div class="inner-box">
              <div class="image">
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <a class="overlay-link" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="CONNECTION"></a>
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <a class="plus" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="TRAIN"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Gallery Block -->
          <div class="gallery-block">
            <div class="inner-box">
              <div class="image">
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <a class="overlay-link" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="CONNECTION"></a>
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <a class="plus" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="TRAIN"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Gallery Block -->
          <div class="gallery-block">
            <div class="inner-box">
              <div class="image">
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <a class="overlay-link" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="CONNECTION"></a>
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <a class="plus" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="TRAIN"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Gallery Block -->
          <div class="gallery-block">
            <div class="inner-box">
              <div class="image">
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <a class="overlay-link" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="CONNECTION"></a>
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <a class="plus" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="TRAIN"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Gallery Block -->
          <div class="gallery-block">
            <div class="inner-box">
              <div class="image">
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <a class="overlay-link" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="CONNECTION"></a>
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <a class="plus" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="TRAIN"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- Gallery Block -->
          <div class="gallery-block">
            <div class="inner-box">
              <div class="image">
                <img src="dist/blackfit/images/rectangle-4@1x.png" alt="" />
                <a class="overlay-link" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="CONNECTION"></a>
                <!-- Overlay Box -->
                <div class="overlay-box">
                  <div class="overlay-inner">
                    <div class="content">
                      <a class="plus" href="dist/blackfit/images/rectangle-4@1x.png" data-fancybox="images" data-caption="TRAIN"></a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- End Gallery Section -->
    <!-- Pricing Section -->
    <section class="pricing-section" style="background-image: url(dist/blackfit/images/rectangle-6@1x.png)">
      <div class="auto-container">
        <div class="sec-title centered">
          <h2><span>HOW IT</span> WORKS</h2>
        </div>
        <div class="row clearfix">

          <!-- Pricing Block -->
          <div class="price-block col-lg-4 col-md-4 col-sm-12">
            <div class="side-text">STEP 1: FIND</div>
            <div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
              <div class="icon-box">
                <span class="icon"><img src="dist/blackfit/images/main-2-1@2x.png" alt="" /></span>
              </div>
              <ul class="price-list">
                <li>Look on the feed or search using
                  preferences you select on your profile.
                  These can include, general
                  location, availability, gender,
                  and categories.</li>
                <li>Once you have found someone you
                  wish to match with you can send
                  a request by clicking on the
                  heart icon.</li>
              </ul>
            </div>
          </div>

          <!-- Pricing Block -->
          <div class="price-block col-lg-4 col-md-4 col-sm-12">
            <div class="side-text">STEP 2: MATCH</div>
            <div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
              <div class="icon-box">
                <span class="icon"><img src="dist/blackfit/images/match-1@2x.png" alt="" /></span>
              </div>
              <ul class="price-list">
                <li>Once you have sent a request, the other personcan accept and match with you.</li>
                <li>When a person is matched with you
                  it will havea red outline around their
                  profile picture as wellas a match
                  tag added.</li>
                <li>This matching system is to ensure
                  safety for all users and stop from
                  anyone just messaging you.</li>
              </ul>
            </div>
          </div>

          <!-- Pricing Block -->
          <div class="price-block col-lg-4 col-md-4 col-sm-12">
            <div class="side-text">STEP 3: CONNECT</div>
            <div class="inner-box wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
              <div class="icon-box">
                <span class="icon"><img src="dist/blackfit/images/main-45-1@2x.png" alt="" /></span>
              </div>
              <ul class="price-list">
                <li>Once you have matched you can use
                  STACKD’s direcft messaging
                  and organize your next
                  workout together!</li>
              </ul>
            </div>
          </div>

        </div>
      </div>
    </section>
    <!-- End Pricing Section -->
    <!-- Coaches Section -->
    <section class="coaches-section">
      <div class="auto-container">
        <div class="sec-title centered">
          <h2><span>Our</span> PT'S</h2>
          <div class="text">Our PT’s are all trained and certified.Be able to train with the best
            <br> and find PT’s all over no matter where you go.
          </div>
        </div>
      </div>

      <div class="four-item-carousel owl-carousel owl-theme">

        <!-- Coach Block -->
        <div class="coach-block">
          <div class="inner-box">
            <div class="image">
              <img src="dist/blackfit/images/rectangle-90-1@1x.png" alt="" />
              <!-- Overlay Box -->
              <div class="overlay-box">
                <a href="trainer.html" class="overlay-link"></a>
                <div class="overlay-inner">
                  <div class="content">
                    <h4><a href="blog-detail.html">SHAWN </a></h4>
                  </div>
                </div>
              </div>
              <!-- Overlay Box Two -->
              <div class="overlay-box-two">
                <a href="#" class="overlay-link-two"></a>
                <div class="content">
                  <h5><a href="blog-detail.html">SHAWN <br> STONE</a></h5>
                  <div class="text">Shawn is a Pro body builder, with his
                    own line of supplements. He has been
                    involved within the industry since 1990.</div>
                  <!-- Social Box -->
                  <div class="social-box">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-instagram"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Coach Block -->
        <div class="coach-block">
          <div class="inner-box">
            <div class="image">
              <img src="dist/blackfit/images/rectangle-91@1x.png" alt="" />
              <!-- Overlay Box -->
              <div class="overlay-box">
                <a href="#" class="overlay-link"></a>
                <div class="overlay-inner">
                  <div class="content">
                    <h4><a href="blog-detail.html">JENNY</a></h4>
                  </div>
                </div>
              </div>
              <!-- Overlay Box Two -->
              <div class="overlay-box-two">
                <a href="trainer.html" class="overlay-link-two"></a>
                <div class="content">
                  <h5><a href="#">JENNY</a></h5>
                  <div class="text">JENNY is a Pro body builder, with his
                    own line of supplements. He has been
                    involved within the industry since 1990.</div>
                  <!-- Social Box -->
                  <div class="social-box">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-instagram"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Coach Block -->
        <div class="coach-block">
          <div class="inner-box">
            <div class="image">
              <img src="dist/blackfit/images/rectangle-92@1x.png" alt="" />
              <!-- Overlay Box -->
              <div class="overlay-box">
                <a href="trainer.html" class="overlay-link"></a>
                <div class="overlay-inner">
                  <div class="content">
                    <h4><a href="blog-detail.html">JORDAN</a></h4>
                  </div>
                </div>
              </div>
              <!-- Overlay Box Two -->
              <div class="overlay-box-two">
                <a href="trainer.html" class="overlay-link-two"></a>
                <div class="content">
                  <h5><a href="blog-detail.html">JORDAN</a></h5>
                  <div class="text">JENNY is a Pro body builder, with his
                    own line of supplements. He has been
                    involved within the industry since 1990.</div>
                  <!-- Social Box -->
                  <div class="social-box">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-instagram"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Coach Block -->
        <div class="coach-block">
          <div class="inner-box">
            <div class="image">
              <img src="dist/blackfit/images/rectangle-93@1x.png" alt="" />
              <!-- Overlay Box -->
              <div class="overlay-box">
                <a href="trainer.html" class="overlay-link"></a>
                <div class="overlay-inner">
                  <div class="content">
                    <h4><a href="blog-detail.html">JENNIFER</a></h4>
                  </div>
                </div>
              </div>
              <!-- Overlay Box Two -->
              <div class="overlay-box-two">
                <a href="trainer.html" class="overlay-link-two"></a>
                <div class="content">
                  <h5><a href="blog-detail.html">JENNIFER</a></h5>
                  <div class="text">JENNIFER is a Pro body builder, with his
                    own line of supplements. He has been
                    involved within the industry since 1990.</div>
                  <!-- Social Box -->
                  <div class="social-box">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-instagram"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Coach Block -->
        <div class="coach-block">
          <div class="inner-box">
            <div class="image">
              <img src="dist/blackfit/images/rectangle-91@1x.png" alt="" />
              <!-- Overlay Box -->
              <div class="overlay-box">
                <a href="#" class="overlay-link"></a>
                <div class="overlay-inner">
                  <div class="content">
                    <h4><a href="blog-detail.html">JENNY</a></h4>
                  </div>
                </div>
              </div>
              <!-- Overlay Box Two -->
              <div class="overlay-box-two">
                <a href="trainer.html" class="overlay-link-two"></a>
                <div class="content">
                  <h5><a href="#">JENNY</a></h5>
                  <div class="text">JENNY is a Pro body builder, with his
                    own line of supplements. He has been
                    involved within the industry since 1990.</div>
                  <!-- Social Box -->
                  <div class="social-box">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-instagram"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Coach Block -->
        <div class="coach-block">
          <div class="inner-box">
            <div class="image">
              <img src="dist/blackfit/images/rectangle-92@1x.png" alt="" />
              <!-- Overlay Box -->
              <div class="overlay-box">
                <a href="trainer.html" class="overlay-link"></a>
                <div class="overlay-inner">
                  <div class="content">
                    <h4><a href="blog-detail.html">JORDAN</a></h4>
                  </div>
                </div>
              </div>
              <!-- Overlay Box Two -->
              <div class="overlay-box-two">
                <a href="trainer.html" class="overlay-link-two"></a>
                <div class="content">
                  <h5><a href="blog-detail.html">JORDAN</a></h5>
                  <div class="text">JENNY is a Pro body builder, with his
                    own line of supplements. He has been
                    involved within the industry since 1990.</div>
                  <!-- Social Box -->
                  <div class="social-box">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-instagram"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- Coach Block -->
        <div class="coach-block">
          <div class="inner-box">
            <div class="image">
              <img src="dist/blackfit/images/rectangle-93@1x.png" alt="" />
              <!-- Overlay Box -->
              <div class="overlay-box">
                <a href="trainer.html" class="overlay-link"></a>
                <div class="overlay-inner">
                  <div class="content">
                    <h4><a href="blog-detail.html">JENNIFER</a></h4>
                  </div>
                </div>
              </div>
              <!-- Overlay Box Two -->
              <div class="overlay-box-two">
                <a href="trainer.html" class="overlay-link-two"></a>
                <div class="content">
                  <h5><a href="blog-detail.html">JENNIFER</a></h5>
                  <div class="text">JENNIFER is a Pro body builder, with his
                    own line of supplements. He has been
                    involved within the industry since 1990.</div>
                  <!-- Social Box -->
                  <div class="social-box">
                    <a href="#" class="fa fa-facebook"></a>
                    <a href="#" class="fa fa-twitter"></a>
                    <a href="#" class="fa fa-instagram"></a>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>

    </section>
    <!-- End Coaches Section -->

    <!-- Testimonial Section Two -->
    <section class="testimonial-section-two">
      <div class="auto-container">
        <div class="sec-title centered">
          <h2><span>WHAT OUR</span><br>MEMBERS SAY</h2>
          <div class="text">
            Have a look at what some of our awesome members have
            <br> said about our platform so far!
          </div>
        </div>

        <div class="testimonial-outer">


          <!--Product Thumbs Carousel-->
          <div class="client-thumb-outer">
            <div class="client-thumbs-carousel owl-carousel owl-theme">
              <div class="thumb-item">
                <figure class="thumb-box"><img src="dist/blackfit/images/rectangle-100@2x.png" alt=""></figure>
              </div>
              <div class="thumb-item">
                <figure class="thumb-box"><img src="dist/blackfit/images/rectangle-99@2x.png" alt=""></figure>
              </div>
              <div class="thumb-item">
                <figure class="thumb-box"><img src="dist/blackfit/images/rectangle-98@2x.png" alt=""></figure>
              </div>
              <div class="thumb-item">
                <figure class="thumb-box"><img src="dist/blackfit/images/rectangle-97@2x.png" alt=""></figure>
              </div>
              <div class="thumb-item">
                <figure class="thumb-box"><img src="dist/blackfit/images/rectangle-98@2x.png" alt=""></figure>
              </div>
              <div class="thumb-item">
                <figure class="thumb-box"><img src="dist/blackfit/images/rectangle-99@2x.png" alt=""></figure>
              </div>
            </div>
          </div>

          <!-- Client Testimonial Carousel -->
          <div class="client-testimonial-carousel owl-carousel owl-theme">

            <!--Testimonial Block -->
            <div class="testimonial-block-two">
              <div class="inner-box">
                <div class="text">“STACKD has help me meet so many friends
                  and has really helped me to keep motivated.
                  I am always excited to meet new people!”</div>
                <div class="author-info">
                  <div class="author-name">Samantha Green</div>
                  <div class="designation">CEO of Company</div>
                </div>
              </div>
            </div>

            <!--Testimonial Block -->
            <div class="testimonial-block-two">
              <div class="inner-box">
                <div class="text">“STACKD has help me meet so many friends
                  and has really helped me to keep motivated.
                  I am always excited to meet new people!”</div>
                <div class="author-info">
                  <div class="author-name">Samantha Green</div>
                  <div class="designation">CEO of Company</div>
                </div>
              </div>
            </div>

            <!--Testimonial Block -->
            <div class="testimonial-block-two">
              <div class="inner-box">
                <div class="text">“STACKD has help me meet so many friends
                  and has really helped me to keep motivated.
                  I am always excited to meet new people!”</div>
                <div class="author-info">
                  <div class="author-name">Samantha Green</div>
                  <div class="designation">CEO of Company</div>
                </div>
              </div>
            </div>

            <!--Testimonial Block -->
            <div class="testimonial-block-two">
              <div class="inner-box">
                <div class="text">“STACKD has help me meet so many friends
                  and has really helped me to keep motivated.
                  I am always excited to meet new people!”</div>
                <div class="author-info">
                  <div class="author-name">Samantha Green</div>
                  <div class="designation">CEO of Company</div>
                </div>
              </div>
            </div>

            <!--Testimonial Block -->
            <div class="testimonial-block-two">
              <div class="inner-box">
                <div class="text">“STACKD has help me meet so many friends
                  and has really helped me to keep motivated.
                  I am always excited to meet new people!”</div>
                <div class="author-info">
                  <div class="author-name">Samantha Green</div>
                  <div class="designation">CEO of Company</div>
                </div>
              </div>
            </div>

            <!--Testimonial Block -->
            <div class="testimonial-block-two">
              <div class="inner-box">
                <div class="text">“STACKD has help me meet so many friends
                  and has really helped me to keep motivated.
                  I am always excited to meet new people!”</div>
                <div class="author-info">
                  <div class="author-name">Samantha Green</div>
                  <div class="designation">CEO of Company</div>
                </div>
              </div>
            </div>

          </div>

        </div>

      </div>
    </section>
    <!-- End Testimonial Section -->

    <!-- News Section -->
    <section class="news-section">
      <div class="auto-container">
        <div class="sec-title centered">
          <h2><span>LATEST</span><br>BLOG POSTS</h2>
          <div class="text">Have a read at some of the latest info as well as detailed posts
            <br> made by our industry professionals.
          </div>
        </div>

        <div class="single-item-carousel owl-carousel owl-theme">

          <div class="row clearfix">

            <!-- Column -->
            <div class="column col-lg-6 col-md-12 col-sm-12">

              <!-- News Block -->
              <div class="news-block">
                <div class="inner-box">
                  <a href="blog-detail.html" class="overlay-link"></a>
                  <div class="image">
                    <img src="dist/blackfit/images/rectangle-117@2x.png" alt="" />
                    <div class="post-date">
                      <span>27</span>SEP
                    </div>
                    <div class="content">
                      <h4><a href="blog-detail.html">HOW TO MAXIMISE TIME SPENT AT THE GYM</a></h4>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- Column -->
            <div class="column col-lg-6 col-md-12 col-sm-12">

              <!-- News Block -->
              <div class="news-block">
                <div class="inner-box">
                  <a href="blog-detail.html" class="overlay-link"></a>
                  <div class="image">
                    <img src="dist/blackfit/images/rectangle-118@2x.png" alt="" />
                    <div class="post-date">
                      <span>7</span>SEP
                    </div>
                    <div class="content">
                      <h4><a href="blog-detail.html">SIMPLE CONDITION FOR ALL AROUND FITNESS</a></h4>
                    </div>
                  </div>
                </div>
              </div>

              <!-- News Block -->
              <div class="news-block">
                <div class="inner-box">
                  <a href="blog-detail.html" class="overlay-link"></a>
                  <div class="image">
                    <img src="dist/blackfit/images/rectangle-119@2x.png" alt="" />
                    <div class="post-date">
                      <span>18</span>SEP
                    </div>
                    <div class="content">
                      <h4><a href="blog-detail.html">10 TIPS HOW TO PREPARE MEALS FAST AND EASY</a></h4>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>
          <div class="row clearfix">

            <!-- Column -->
            <div class="column col-lg-6 col-md-12 col-sm-12">

              <!-- News Block -->
              <div class="news-block">
                <div class="inner-box">
                  <a href="blog-detail.html" class="overlay-link"></a>
                  <div class="image">
                    <img src="dist/blackfit/images/rectangle-117@2x.png" alt="" />
                    <div class="post-date">
                      <span>27</span>SEP
                    </div>
                    <div class="content">
                      <h4><a href="blog-detail.html">HOW TO MAXIMISE TIME SPENT AT THE GYM</a></h4>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- Column -->
            <div class="column col-lg-6 col-md-12 col-sm-12">

              <!-- News Block -->
              <div class="news-block">
                <div class="inner-box">
                  <a href="blog-detail.html" class="overlay-link"></a>
                  <div class="image">
                    <img src="dist/blackfit/images/rectangle-118@2x.png" alt="" />
                    <div class="post-date">
                      <span>7</span>SEP
                    </div>
                    <div class="content">
                      <h4><a href="blog-detail.html">SIMPLE CONDITION FOR ALL AROUND FITNESS</a></h4>
                    </div>
                  </div>
                </div>
              </div>

              <!-- News Block -->
              <div class="news-block">
                <div class="inner-box">
                  <a href="blog-detail.html" class="overlay-link"></a>
                  <div class="image">
                    <img src="dist/blackfit/images/rectangle-119@2x.png" alt="" />
                    <div class="post-date">
                      <span>18</span>SEP
                    </div>
                    <div class="content">
                      <h4><a href="blog-detail.html">10 TIPS HOW TO PREPARE MEALS FAST AND EASY</a></h4>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>
          <div class="row clearfix">

            <!-- Column -->
            <div class="column col-lg-6 col-md-12 col-sm-12">

              <!-- News Block -->
              <div class="news-block">
                <div class="inner-box">
                  <a href="blog-detail.html" class="overlay-link"></a>
                  <div class="image">
                    <img src="dist/blackfit/images/rectangle-117@2x.png" alt="" />
                    <div class="post-date">
                      <span>27</span>SEP
                    </div>
                    <div class="content">
                      <h4><a href="blog-detail.html">HOW TO MAXIMISE TIME SPENT AT THE GYM</a></h4>
                    </div>
                  </div>
                </div>
              </div>

            </div>

            <!-- Column -->
            <div class="column col-lg-6 col-md-12 col-sm-12">

              <!-- News Block -->
              <div class="news-block">
                <div class="inner-box">
                  <a href="blog-detail.html" class="overlay-link"></a>
                  <div class="image">
                    <img src="dist/blackfit/images/rectangle-118@2x.png" alt="" />
                    <div class="post-date">
                      <span>7</span>SEP
                    </div>
                    <div class="content">
                      <h4><a href="blog-detail.html">SIMPLE CONDITION FOR ALL AROUND FITNESS</a></h4>
                    </div>
                  </div>
                </div>
              </div>

              <!-- News Block -->
              <div class="news-block">
                <div class="inner-box">
                  <a href="blog-detail.html" class="overlay-link"></a>
                  <div class="image">
                    <img src="dist/blackfit/images/rectangle-119@2x.png" alt="" />
                    <div class="post-date">
                      <span>18</span>SEP
                    </div>
                    <div class="content">
                      <h4><a href="blog-detail.html">10 TIPS HOW TO PREPARE MEALS FAST AND EASY</a></h4>
                    </div>
                  </div>
                </div>
              </div>

            </div>

          </div>

        </div>

        <div class="lower-text text-center">
          <a href="blog-detail-two.html" class="view-all">View all</a>
        </div>

      </div>
    </section>
    <!-- End News Section -->

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