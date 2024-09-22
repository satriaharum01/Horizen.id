    <div class="shopify-grid padding-large">
      <div class="container">
        <div class="row">

          <aside class="col-md-3 pull-right">
            <div class="sidebar">
              <div class="widgets widget-menu">
                <div class="widget-search-bar">
                  <form role="search" method="get" class="d-flex">
                    <input type="text" class="search-field" placeholder="Search" wire:model="searchTerm" >
                    <button class="btn btn-dark"><i class="icon icon-search"></i></button>
                  </form>
                </div> 
              </div>
            </div>
          </aside>

          <section id="selling-products" class="col-md-12 product-store">
            <div class="container">
              <div class="swiper-wrapper">
                  <div class="swiper-slide">
                <ul class="tabs list-unstyled">
                    <li wire:click="setCat(0)"  class="@if($selectcat == '') active @endif tab">All</li>
                    @foreach($kategori as $row)
                    <li wire:click="setCat({{$row->id}})" class="@if($selectcat == $row->id) active @endif tab">{{$row->nama}} </li>
                    @endforeach
                </ul>
                  </div>
              </div>
              <div class="tab-content">
                <div  class="active">
                  @if($produk->count() > 1)
                  <div class="row d-flex flex-wrap">
                    @foreach($produk as $row)
                    <div class="product-item col-lg-3 col-md-6 col-sm-6">
                      <div class="image-holder">
                        <img src="{{asset('images/product_images/'.$row->foto)}}" alt="Product Image" class="product-image">
                      </div>
                      <div class="cart-concern">
                        <a href="{{asset('images/product_images/'.$row->foto)}}" rel="gallery" title="" class="gallery cboxElement">
                            <div class="cart-button d-flex justify-content-between align-items-center">
                                 <span class="tooltip-text">Quick view</span>      
                            </div>
                        </a>
                      </div>
                      <div class="product-detail">
                        <h3 class="product-title">
                          <a href="#">{{$row->nama}}</a>
                        </h3>
                        <div class="item-price text-primary">Rp. {{number_format($row->harga)}}</div>
                      </div>
                    </div>
                    @endforeach
                  </div>
                  
                  @else
                    <h2 class="banner-title text-center">Tidak Ada Produk</h2>
                  @endif
                </div>
              </div>
              <nav class="navigation paging-navigation text-center" role="navigation">
                <div class="pagination loop-pagination d-flex justify-content-center">
                  
                    {{ $produk->links('livewire.pagination') }}
                   
                </div>
              </nav>
            </div>
          </section>

          
        </div>        
      </div>      
    </div>
