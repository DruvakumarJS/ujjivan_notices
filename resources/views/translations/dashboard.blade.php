@extends('layouts.app')

@section('content')

<div class="container">
	<div class="d-flex">
		<div class="ms-auto">
			<a href="{{ route('translate.form')}}"><button class="btn btn-danger text-white">Transalate</button></a>
		</div>
	</div>
	

	<div class="container">

  <div class="row">
    <div class="col-md-4 col-lg-4 pb-2">
      <div class="card border border-dark ">
        <div class="card-header bg-primary text-white fw-bold text-center">OverAll Translations</div>
        <div class="card-body text-center">
          <span class="transalte-text ">{{ $overall_translation }}</span>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-4 pb-2">
      <div class="card border border-dark ">
        <div class="card-header bg-primary text-white fw-bold text-center">OverAll Instnces</div>
        <div class="card-body text-center">
          <span class="transalte-text ">{{ $overall_instance }}</span>
        </div>
      </div>
    </div>

    <div class="col-md-4 col-lg-4 pb-2">
      <div class="card border border-dark ">
        <div class="card-header bg-primary text-white fw-bold text-center">OverAll Translated Languages</div>
        <div class="card-body text-center">
          <span class="transalte-text ">{{ $overall_langs }}</span>
        </div>
      </div>
    </div>
  </div>

    <div class="row pt-2 m-auto">
      <div class="col-md-6 col-lg-3 pb-2">

        <!-- Copy the content below until next comment -->
        <div class="card card-custom bg-white border-white border-0 justify-content-center">
          <div class="card-custom-img" style="background-image: url(http://res.cloudinary.com/d3/image/upload/c_scale,q_auto:good,w_1110/trianglify-v1-cs85g_cc5d2i.jpg);">
          	
          </div>
          <div class="card-custom-avatar">
            <img class="img-fluid" src="images/gt.png" alt="Avatar" />
            <h1 class="text-center text-success transalte-text">{{ $total_translation }}</h1>
          </div>
          <div class="card-body" style="overflow-y: auto">
            <h4 class="card-title fw-bold">Total Transalation</h4>
            <p class="card-text">Number of Characters transalated this month </p>
          </div>
          
        </div>
      
      </div>

      @php
        $rem = 500000 - intval($total_translation);
      @endphp

      <div class="col-md-6 col-lg-3 pb-2">

        <!-- Copy the content below until next comment -->
        <div class="card card-custom bg-white border-white border-0 justify-content-center">
          <div class="card-custom-img" style="background-image: url(http://res.cloudinary.com/d3/image/upload/c_scale,q_auto:good,w_1110/trianglify-v1-cs85g_cc5d2i.jpg);">
          	
          </div>
          <div class="card-custom-avatar">
            <img class="img-fluid" src="images/gt.png" alt="Avatar" />
            <h1 class="text-center text-warning transalte-text">{{ $rem }}</h1>
          </div>
          <div class="card-body" style="overflow-y: auto">
            <h4 class="card-title fw-bold">Remaining Quota</h4>
            <p class="card-text">Number of Characters remaining for transalation for this month</p>
          </div>
          
        </div>
      
      </div>

      <div class="col-md-6 col-lg-3 pb-2">

        <!-- Add a style="height: XYZpx" to div.card to limit the card height and display scrollbar instead -->
        <div class="card card-custom bg-white border-white border-0" >
          <div class="card-custom-img" style="background-image: url(http://res.cloudinary.com/d3/image/upload/c_scale,q_auto:good,w_1110/trianglify-v1-cs85g_cc5d2i.jpg);"></div>
          <div class="card-custom-avatar">
            <img class="img-fluid" src="images/gt.png" alt="Avatar" />
             <h1 class="text-center transalte-text">{{ $total_instance }}</h1>
          </div>
          <div class="card-body" style="overflow-y: auto">
            <h4 class="card-titl fw-bold">Total Instances</h4>
            <p class="card-text">Number attempted to transalte content</p>
            
          </div>
         
        </div>

      </div>
     
     <div class="col-md-6 col-lg-3 pb-2">

        <!-- Add a style="height: XYZpx" to div.card to limit the card height and display scrollbar instead -->
        <div class="card card-custom bg-white border-white border-0" >
          <div class="card-custom-img" style="background-image: url(http://res.cloudinary.com/d3/image/upload/c_scale,q_auto:good,w_1110/trianglify-v1-cs85g_cc5d2i.jpg);"></div>
          <div class="card-custom-avatar">
            <img class="img-fluid" src="images/gt.png" alt="Avatar" />
             <h1 class="text-center text-warning transalte-text">{{ $total_langs }}</h1>
          </div>
          <div class="card-body" style="overflow-y: auto">
            <h4 class="card-title fw-bold">Total Languages</h4>
            <p class="card-text">Total number of languages translated </p>
          </div>
         
        </div>

      </div>
    </div>

    <div class="card" >

    	<div id="chart"></div>
    </div>
  </div>
</div>

<script type="text/javascript">
	var colors =[
    "Red",
    "Orange",
    "Yellow",
    "Green",
    "Cyan",
    "Blue",
    "Indigo",
    "Violet",
    "Pink",
    "Brown",
    "Gray",
    "Black",
    "White",
    "Magenta"
];

	var options = {
          series: [{
          name: 'Transalation Count',
          data: @json($chartData['count']),
        }],
          annotations: {
          points: [{
            x: 'Bananas',
            seriesIndex: 0,
            label: {
              borderColor: '#775DD0',
              offsetY: 0,
              style: {
                color: '#fff',
                background: '#775DD0',
              },
              text: 'Bananas are good',
            }
          }]
        },
        chart: {
          height: 350,
          type: 'bar',
           zoom: {
              enabled: false // 🔹 disables zooming
            },
            toolbar: {
              show: false // optional: hides zoom/reset buttons
            }
         
        },
        plotOptions: {
          bar: {
            borderRadius: 5,
            columnWidth: '50%',
          }
        },
        dataLabels: {
          enabled: false
        },
        stroke: {
          width: 0
        },
        grid: {
          row: {
            colors: ['#fff', '#f2f2f2']
          }
        },
        xaxis: {
          labels: {
            rotate: -45
          },
          categories: @json($chartData['name']),
          tickPlacement: 'on'
        },
        yaxis: {
          title: {
            text: 'translated Characters',
          },
        },
        fill: {
          type: 'gradient',
          gradient: {
            shade: 'light',
            type: "horizontal",
            shadeIntensity: 0.25,
            gradientToColors: undefined,
            inverseColors: true,
            opacityFrom: 0.85,
            opacityTo: 0.85,
            stops: [50, 0, 100]
          },
        }
        };

        var chart = new ApexCharts(document.querySelector("#chart"), options);
        chart.render();

</script>
@endsection