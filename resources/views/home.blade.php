@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between">
      <div class="col-md-6 col-sm-6">
        <div class="card shadow-sm border border-primary" >
             <label class="label-bold">Device Health</label>
                       
             <div>
               <canvas id="myChart" ></canvas>
             </div>
                 
          </div>
      </div>

      <div class="col-md-6 col-sm-6">
        <div class="card shadow-sm border border-primary" >
             <label class="label-bold">Installed Devices</label>
                       
             <div>
               <canvas id="mydeviceChart" ></canvas>
             </div>
                 
          </div>
      </div>

      
         
    </div>
</div>

<!-- PIE CHART -->
 <script>

Chart.defaults.global.defaultFontStyle = 'bold';
var barColors = [
  "#008000",
  "#FFA500",
  "#FF0000"
 
];

new Chart("myChart", {
  type: "pie",
  data: {
    labels: @json($pie_data['labels']),
    datasets: [{
      backgroundColor: barColors,
      borderWidth: 0, 
      data: @json($pie_data['data'])
    }]
  },
  options: {
     legend: {
        position: 'bottom',
        labels: {
              fontSize: 12
        },
      },
    title: {
      display: true
     
    }
  }
});

</script>

<!-- PIE CHART -->
 <script>

Chart.defaults.global.defaultFontStyle = 'bold';

new Chart("mydeviceChart", {
  type: "bar",
  data: {
    labels: @json($line_data['labels']),
    datasets: [{
      backgroundColor: getRandomColor(),
      borderWidth: 0, 
      data: @json($line_data['data'])
    }]
  },
  options: {
     
    title: {
      display: true
     
    },
    legend: {
      display: false,
        
      },
    
    scales: {
       xAxes: [{
            barPercentage: 0.2,
            gridLines: {
                display:false
            },

        }] ,
        yAxes: [{
            ticks: {
                beginAtZero: true,
                gridLines: {
                   display:false,
            },
             stepSize: 1,
             
            }
        }]
    }
  }
});

function getRandomColor() { //generates random colours and puts them in string
  var colors = [];
  var size = <?php echo sizeof($line_data['labels']); ?> ;
  for (var i = 0; i < size; i++) {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var x = 0; x < 6; x++) {
      color += letters[Math.floor(Math.random() * 16)];
    }
    colors.push(color);
  }
  return colors;
}

</script>
@endsection
