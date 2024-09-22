@extends('template.onepage')

@section('content')
        <!-- start home -->
        <section id="feature1">
			<div class="container">
				<h2 class="text-uppercase">{{$title}}</h2>
						<!-- Content Row -->
                <div class="row">
                    <div class="card-body" id="pelacakan">
                        <form class="" action="{{url('lacak/cari')}}" method="POST" autocomplete="off" style="z-index:1000;">
                           @csrf
                           <div class="card-body mb-5">
                               <div class="mb-3">
                                   <label class="form-label">Kode Service</label>
                                   <input type="text" name="kode" value="{{$kode}}" class="form-control @error('email') is-invalid @enderror" placeholder="Masukan kode service" autocomplete="off">
                               </div>
                               <div class="form-footer text-center">
                                   <button type="submit" class="btn btn-primary w-100">Lacak Pesanan</button>
                               </div>
                           </div>
                        </form>
                        <div class="mt-5 stepper-wrapper step-lacak"> 
                            <div class="stepper-item">
                                <div class="step-counter "><i class="fa fa-envelope"></i> </div>
                                <div class="step-name">Pesanan Dibuat</div>
                            </div>
                            <div class="stepper-item ">
                                <div class="step-counter"><i class="fa fa-box"></i></div>
                                <div class="step-name">Persiapan Material</div>
                            </div>
                            <div class="stepper-item ">
                                <div class="step-counter"><i class="fa fa-wrench"></i></div>
                                <div class="step-name">Proses Perbaikan</div>
                            </div>
                            <div class="stepper-item ">
                                <div class="step-counter"><i class="fa fa-hand-holding-dollar"></i></div>
                                <div class="step-name">Pengambilan Service</div>
                            </div>
                            <div class="stepper-item ">
                                <div class="step-counter"><i class="fa fa-check"></i></div>
                                <div class="step-name">Pesanan Selesai</div>
                            </div>
                        </div>
                    </div>
                </div>    
			</div>
		</section>
		<!-- end home -->
		<!-- start footer -->
@endsection
@section('js')
<script src="{{asset('node_modules/axios/dist/axios.min.js')}}"></script>
<script>
    $(function(){
        var count = <?= $count ?? 1?>;
        var i = 0;
        $('div.step-lacak').children().each(function() {
            if(i == count){
                $(this).removeClass().addClass( "stepper-item active" ); 
            }else if(i <= count){
                $(this).removeClass().addClass( "stepper-item completed" );
            }else{
                $(this).removeClass().addClass( "stepper-item" );
            }
            i++;
        });
    })
</script>
@endsection