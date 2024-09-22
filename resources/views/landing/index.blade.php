@extends('landing.app')

@section('content')
    <section id="featured-products" class="product-store padding-large">
      <div class="container">
        <div class="section-header d-flex flex-wrap align-items-center justify-content-between">
          <h2 class="section-title">Featured Products</h2>            
          <div class="btn-wrap">
            <a href="{{route('product.page')}}" class="d-flex align-items-center">View all products <i class="icon icon icon-arrow-io"></i></a>
          </div>            
        </div>
        <div class="swiper product-swiper overflow-hidden">
          <div class="swiper-wrapper">
            
          @foreach($produk as $row)
            <div class="swiper-slide">
              <div class="product-item">
                <div class="image-holder">
                  <img src="{{asset('images/product_images/'.$row['foto'])}}" alt="Produk Image" style="aspect-ratio:0.7/0.95;" class="product-image">
                </div>
                <div class="cart-concern">
                  <div class="cart-button d-flex justify-content-between align-items-center">
                    <a href="{{asset('images/product_images/'.$row['foto'])}}" rel="gallery" title="" class="gallery cboxElement view-btn">
                            <div class="cart-button d-flex justify-content-between align-items-center">
                                 <span class="tooltip-text">Quick view</span>      
                            </div>
                      </a>
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-title">
                    <a href="single-product.html">{{$row['nama']}}</a>
                  </h3>
                  <span class="item-price text-primary">Rp. {{number_format($row['harga'])}}</span>
                </div>
                <!--
                <div class="cart-concern">
                  <div class="cart-button d-flex justify-content-between align-items-center">
                    <button type="button" class="btn-wrap cart-link d-flex align-items-center">add to cart <i class="icon icon-arrow-io"></i>
                    </button>
                    <button type="button" class="view-btn tooltip
                        d-flex">
                      <i class="icon icon-screen-full"></i>
                      <span class="tooltip-text">Quick view</span>
                    </button>
                    <div class="product-detail">
                      <h3 class="product-title">
                        <a href="#">{{$row['nama']}}</a>
                      </h3>
                      <div class="item-price text-primary">Rp. {{number_format($row['harga'])}}</div>
                    </div>
                  </div>
                </div>
                <div class="product-detail">
                  <h3 class="product-title">
                    <a href="single-product.html">Full sleeve cover shirt</a>
                  </h3>
                  <span class="item-price text-primary">$40.00</span>
                </div>
-->
              </div>
            </div>
          @endforeach
          </div>
        </div>
        <div class="swiper-pagination"></div>
      </div>
    </section>


@endsection