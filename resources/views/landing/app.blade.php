<!DOCTYPE html>
<html>
<head>
	<title>landing | {{env('APP_NAME')}}</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logo.png')}}" type="image/gif" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="format-detection" content="telephone=no">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="author" content="">
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/css/normalize.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/icomoon/icomoon.css') }}">
    <link rel="stylesheet" type="text/css" media="all" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/css/vendor.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/landing/style.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
	<!-- Font Awesome -->
	<link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/bower_components/font-awesome-free-6/css/all.css') }}">
	<!-- script
    ================================================== -->
    <script src="{{ asset('assets/landing/js/modernizr.js') }}"></script>
    <style>
      .text-white{
        color: white !important;
      }
      .overlay-text{
        padding: 1rem;
        background-color:rgba(0, 0, 0, 0.5)
      }
    </style>
</head>
<body>

	<div class="preloader-wrapper">
      <div class="preloader">
      </div>
    </div>

    <div class="search-popup">
      <div class="search-popup-container">

        <form role="search" method="get" class="search-form" action="">
          <input type="search" id="search-form" class="search-field" placeholder="Type and press enter" value="" name="s" />
          <button type="submit" class="search-submit"><a href="#"><i class="icon icon-search"></i></a></button>
        </form>

        <h5 class="cat-list-title">Browse Categories</h5>
        
        <ul class="cat-list">
          <li class="cat-list-item">
            <a href="shop.html" title="Men Jackets">Men Jackets</a>
          </li>
          <li class="cat-list-item">
            <a href="shop.html" title="Fashion">Fashion</a>
          </li>
          <li class="cat-list-item">
            <a href="shop.html" title="Casual Wears">Casual Wears</a>
          </li>
          <li class="cat-list-item">
            <a href="shop.html" title="Women">Women</a>
          </li>
          <li class="cat-list-item">
            <a href="shop.html" title="Trending">Trending</a>
          </li>
          <li class="cat-list-item">
            <a href="shop.html" title="Hoodie">Hoodie</a>
          </li>
          <li class="cat-list-item">
            <a href="shop.html" title="Kids">Kids</a>
          </li>
        </ul>
      </div>
    </div>
    <header id="header">
      <div id="header-wrap">
        <nav class="primary-nav padding-small">
          <div class="container">
            <div class="row d-flex align-items-center">
              <div class="col-lg-2 col-md-2">
                <div class="main-logo">
                  <a href="index.html">
                    <img src="{{ asset('assets/img/nav-logo.png') }}" alt="logo">
                  </a>
                </div>
              </div>
              <div class="col-lg-10 col-md-10">
                <div class="navbar">

                  <div id="main-nav" class="stellarnav d-flex justify-content-end right">
                    <ul class="menu-list">

						          <li><a href="{{url('/')}}" class="item-anchor" data-effect="Home">Home</a></li>

                      <li><a href="#footer" class="item-anchor" data-effect="About">About</a></li>

                      <li><a href="{{route('login')}}" class="item-anchor" data-effect="Contact">Login</a></li>

                    </ul>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </nav>
      </div>
    </header>

    <section id="billboard" class="overflow-hidden">

      <button class="button-prev">
        <i class="icon icon-chevron-left"></i>
      </button>
      <button class="button-next">
        <i class="icon icon-chevron-right"></i>
      </button>
      <div class="swiper main-swiper">
        <div class="swiper-wrapper">
          <div class="swiper-slide" style="background-image: url('assets/img/banner-1.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;">
            <div class="banner-content">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <h2 class="banner-title text-white">New Arrival Produk</h2>
                    <p class="text-white overlay-text text-justify">Tunjukkan semangat anime Anda! Temukan koleksi kaos anime keren kami yang dirancang khusus untuk penggemar sejati. Desain unik dari karakter favorit Anda dengan kualitas sablon premium yang tahan lama !</p>
                    <div class="btn-wrap">
                      <a href="https://shopee.co.id/horizen.id" class="btn btn-light btn-medium d-flex align-items-center" tabindex="0">Shop it now <i class="icon icon-arrow-io"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide" style="background-image: url('assets/img/banner-2.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;">
            <div class="banner-content">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <h2 class="banner-title text-white">Wash Collection</h2>
                    <p class="text-white overlay-text text-justify">Ekspresikan diri Anda dengan koleksi wash unisex terbaru! Dirancang untuk semua gender, baju wash ini menghadirkan kenyamanan dan gaya dalam satu paket. Tersedia dalam berbagai ukuran dan warna. Jadikan penampilan Anda lebih keren dengan koleksi wash dari kami!</p>
                    <div class="btn-wrap">
                      <a href="https://shopee.co.id/horizen.id" class="btn btn-light btn-light-arrow btn-medium d-flex align-items-center" tabindex="0">Shop it now <i class="icon icon-arrow-io"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <div class="swiper-slide" style="background-image: url('assets/img/banner-3.jpg');background-repeat: no-repeat;background-size: cover;background-position: center;">
            <div class="banner-content">
              <div class="container">
                <div class="row">
                  <div class="col-md-6">
                    <h2 class="banner-title">Best Seller</h2>
                    <p class="text-white overlay-text text-justify">Kaos anime yang paling dicari telah tiba! Tunjukkan kecintaan Anda pada anime dengan kaos motif anime best seller kami. Dapatkan sekarang dan jadilah bagian dari komunitas penggemar anime yang stylish!</p>
                    <div class="btn-wrap">
                      <a href="https://shopee.co.id/horizen.id" class="btn btn-light btn-light-arrow btn-medium d-flex align-items-center" tabindex="0">Shop it now <i class="icon icon-arrow-io"></i>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
    
	
	@yield('content')
	<footer id="footer" class="d-none">
      <div class="container">
        <div class="footer-menu-list">
          <div class="row d-flex flex-wrap justify-content-between">
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="footer-menu">
                <h5 class="widget-title">Hubungi Kami</h5>
                <p class="text-justify">Hubungi Jika Ada Pertanyaan Lebih Lanjut Mengenai Perusahaan Kami, Kami Akan Sangat Senang Membantu Anda.<a href="#" class="email">horizenindonesia@gmail.com</a>
                </p>
                <p>Telepon<br>
                  <strong>+62 811-6215-555</strong>
                </p>
              </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
              <div class="footer-menu">
                <h5 class="widget-title">Tentang Kami</h5>
                <p class="text-justify">Horizen.id adalah brand fashion streetwear yang lahir dari hasrat untuk menghubungkan individu melalui gaya berpakaian yang autentik dan penuh ekspresi.</p>
                <div class="social-links">
                  <ul class="d-flex list-unstyled">
                    <li>
                      <a href="https://www.instagram.com/horizen.id">
                        <i class="icon icon-instagram"></i>
                      </a>
                    </li>
                    <li>
                      <a href="https://www.tiktok.com/@horizen.id">
                        <i class="fa-brands fa-tiktok"></i>
                      </a>
                    </li>
                    <li>
                      <a href="https://shopee.co.id/horizen.id">
                        <i class="fa-brands fa-shopify"></i>
                      </a>
                    </li>
                    <li>
                      <a href="https://www.tokopedia.com/horizenid">
                        <i><img style="max-height:17px;" src="{{asset('assets/icon/tokopedia.png')}}"></i>
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <hr>
    </footer>

    <div id="footer-bottom">
      <div class="container">
        <div class="d-flex align-items-center flex-wrap justify-content-between">
          <div class="copyright">
            <p>copyright by <a href="#">{{env('APP_NAME')}}</a> Distributed by <a href="#">Humaidi</a>
            </p>
          </div>
          <div class="payment-method">
            
          </div>
        </div>
      </div>
    </div>

    <script src="{{ asset('assets/landing/js/jquery-1.11.0.min.js') }}"></script>
    <script src="{{ asset('assets/landing/js/plugins.js') }}"></script>
    <script src="{{ asset('assets/landing/js/script.js') }}"></script>
	
	@livewireScripts
  </body>
</html>

    