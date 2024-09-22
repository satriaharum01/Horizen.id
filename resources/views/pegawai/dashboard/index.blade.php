@extends('template.master')


@section('content')
<div class="row">
  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-package-variant-closed text-info icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Data Barang</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{$barang}}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted d-none mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Product-wise sales </p>
      </div>
    </div>
  </div>
  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-sale text-danger icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Total Penjualan</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">Rp. {{$penjualan}}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted d-none mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> 65% lower growth </p>
      </div>
    </div>
  </div>
  <div class="col-xl-4 col-lg-4 col-md-4 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-plus-box text-info icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Barang Masuk Bulan ini</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">{{$barang_masuk}}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted d-none mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Product-wise sales </p>
      </div>
    </div>
  </div>
  <div class="col-xl-8 col-lg-8 col-md-8 col-sm-6 grid-margin stretch-card">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-poll-box text-success icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Penjualan Bulan ini</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">Rp. {{$penjualan_bulan}}</h3>
            </div>
          </div>
        </div>
        <p class="text-muted d-none mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Weekly Sales </p>
      </div>
    </div>
  </div>
</div>
<div class="row">
  <div class="col-md-12 grid-margin">
    <div class="card">
      <div class="card-body">
        <div class="d-sm-flex justify-content-between align-items-center mb-4">
          <h2 class="card-title mb-0">Grafik Penjualan</h2>
          <div class="d-none wrapper ">
            <div class="d-flex align-items-center mr-3">
              <span class="dot-indicator bg-success"></span>
              <p class="mb-0 ml-2 text-muted">Barang</p>
            </div>
            <div class="d-flex align-items-center mr-3">
              <span class="dot-indicator bg-primary"></span>
              <p class="mb-0 ml-2 text-muted">Barang</p>
            </div>
            <div class="d-flex align-items-center">
              <span class="dot-indicator bg-warning"></span>
              <p class="mb-0 ml-2 text-muted">Barang</p>
            </div>
          </div>
        </div>
        <div class="chart-container">
          <canvas id="dashboard-area-chart" height="250"></canvas>
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
@section('custom_script')
<script type="text/javascript" src="{{asset('assets/plugins/chartjs/chart.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>

@section('custom_script')
<script type="text/javascript" src="{{asset('assets/plugins/chartjs/chart.min.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/plugins/jquery-sparkline/jquery.sparkline.min.js')}}"></script>
<script>
  
$(function() {
    var ctx = document.getElementById("dashboard-area-chart");
    var myLineChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Januari", "Febuari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"],
        datasets: [{
          label: "Penjualan",
          lineTension: 0.3,
          backgroundColor: "rgba(78, 115, 223, 0.05)",
          borderColor: "rgba(78, 115, 223, 1)",
          pointRadius: 3,
          pointBackgroundColor: "rgba(78, 115, 223, 1)",
          pointBorderColor: "rgba(78, 115, 223, 1)",
          pointHoverRadius: 3,
          pointHoverBackgroundColor: "rgba(78, 115, 223, 1)",
          pointHoverBorderColor: "rgba(78, 115, 223, 1)",
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: <?=$chart;?>,
          }],
      },
    options: {
        maintainAspectRatio: false,
        layout: {
        padding: {
            left: 10,
            right: 25,
            top: 25,
            bottom: 0
        }
        },
        scales: {
        xAxes: [{
            time: {
            unit: 'date'
            },
            gridLines: {
            display: false,
            drawBorder: false
            },
            ticks: {
            maxTicksLimit: 12
            }
        }],
        yAxes: [{
            ticks: {
            maxTicksLimit: 10,
            padding: 10,
            // Include a dollar sign in the ticks
            callback: function(value, index, values) {
                return 'Rp. '+ number_format(value);
            }
            },
            gridLines: {
            color: "rgb(234, 236, 244)",
            zeroLineColor: "rgb(234, 236, 244)",
            drawBorder: false,
            borderDash: [2],
            zeroLineBorderDash: [2]
            }
        }],
        },
        legend: {
        display: false
        },
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          titleMarginBottom: 10,
          titleFontColor: '#6e707e',
          titleFontSize: 14,
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          intersect: false,
          mode: 'index',
          caretPadding: 10,
          callbacks: {
              label: function(tooltipItem, chart) {
              var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
              return datasetLabel + ': Rp. ' + number_format(tooltipItem.yLabel) + '';
              }
          }
        }
    }
    });
})
</script>
@endsection