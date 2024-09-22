    <section class="about-area about-five bg-white">
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <div>
                        <div class="card mb-3 src-nav-card src-nav-colsed" style="overflow:scroll;">
                            <ul class="w-100">
                                <li wire:click="setCat(0)" @if($selectcat == '') class="active" @endif>Semua Kategori</li>
                                @foreach($kategori as $row)
                                <li wire:click="setCat({{$row->id}})" @if($selectcat == $row->id) class="active" @endif>
                                    <span><i class="fas fa-atom"></i></span>
                                    <div class="text-filter">{{$row->nama}} 
                                        <div class="chip-count">{{$row->count}}</div>
                                    </div>
                                </li>
                                @endforeach
                            </ul>  
                        </div>
                    </div>
                    <!-- Livewire Component wire-end:IoZ6yflsFsiLGP3TnpIh -->
                </div>
                <div class="col-md-9 aos-init aos-animate" data-aos="fade-up">
                    <div>
                        <div class="mb-5">
                            <div class="col-md-12 d-flex align-items-center justify-content-between">
                                <h5>{{$counter}} Produk</h5>
                                <div class="col-md-4">
                                    <div class="input-group flex-nowrap">
                                        <input type="text" class="form-control" wire:model="searchTerm" placeholder="Cari..." maxlength="30">
                                        <span class="input-group-text"><i class="bi bi-search"></i></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        @foreach($produk as $row)
                            <div class="product-slide-item col-sm-3">
                              <a href="/product/515-life-is-beautiful-pendakian-penuh-rasa-syukur" style="text-decoration: none;">
                                <div class="product-card-wrapper" title="Life is Beautiful Pendakian Penuh Rasa Syukur">
                                  <div class="product-card-inner">
                                    <div class="product-card-display contain-pict zoom-umsupress" style="background: url('<?= asset('assets/upload/image/buku/'.$row->sampul)?>');"></div>
                                    <div class="product-title-card">
                                      <div class="title-product-card">
                                        <span>{{$row->judul}}</span>
                                      </div>
                                      <div class="product-price-card">
                                        <span><span>Rp {{number_format($row->harga,0)}}</span></span>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </a>
                            </div>
                        @endforeach
                        </div>
                        <div class="row mt-5">
                            <!--<div class="d-flex justify-content-center justify-content-lg-end"> -->
                            <div class="d-flex justify-content-center">
                                <div>
                                    {{ $produk->links('livewire.pagination') }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Livewire Component wire-end:VLs7wAQleVdiMKud3YN3 -->
                </div>
            </div>
        </div>
    </section>