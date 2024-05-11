@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-between">
      @if(auth::user()->id == '3')
      <div class="col-md-6 col-sm-6">
        <div class="card shadow-sm border border-primary" >
             <label class="label-bold">Device Health</label>
                       
             <div>
               <canvas id="myChart" ></canvas>
             </div>
             
                 
          </div>
      </div>
      @endif
    
      <div class="col-md-6 col-sm-6">
     
        <div class="card shadow-sm border border-primary" >
             <label class="label-bold">Devices Count</label>
                       
             <div>
               <canvas id="mydeviceChart" ></canvas>
             </div>
                 
          </div>
      </div>
   
    </div>
  @if(auth::user()->id == '3')
    <div class="row justify-content-between">
      <div class="col-md-6 col-sm-6">
        <div class="card shadow-sm border" >
             <label class="label-bold">Overall Devices Running Duration</label>
                       
             <div>
               <canvas id="runningChart" ></canvas>
             </div>
             
                 
          </div>
      </div>

      <div class="col-md-6 col-sm-6">
        <div class="card shadow-sm border " >
             <label class="label-bold">Overall Devices Idle Duration</label>
                       
             <div>
               <canvas id="idleChart" ></canvas>
             </div>
                 
          </div>
      </div>
   
    </div>
@endif
    <div class="row justify-content-between">
      <div class="col-md-12">
        <div class="card shadow-sm border" >
             <label class="label-bold">Number of Notices Published and Draft</label>
                       
             <div>
               <canvas id="noticesChart" height="100px"></canvas>
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
     
    },
    tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          var label = data.labels[tooltipItem.index];
          var value = data.datasets[0].data[tooltipItem.index];
          var rule = '';
          if(label == 'Dead'){
            rule = 'Devices that have not sent data over 48 hours'

          }
          if(label == 'Online'){
            rule = 'Devices that are active and sending data to server every 15 minutes '

          }
          if(label == 'Offline'){
            rule = 'Devices that are active but not sending data every 15 minutes '

          }
          return label + ': ' + value + ' units ( '+rule+')' ; // Customize this line as needed
        }
      }
    }
  }
});

</script>

<!-- PIE CHART -->
<script>

Chart.defaults.global.defaultFontStyle = 'bold';
var lineColors = [
  "#52D3D8",
  "#3887BE",
  "#38419D",
  "#200E3A",
 
];

new Chart("mydeviceChart", {
  type: "bar",
  data: {
    labels: @json($line_data['labels']),
    datasets: [{
      backgroundColor: lineColors,
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
    },
    tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
          return 'In ' + tooltipItem.xLabel + ' Region totally '+tooltipItem.yLabel+' devices are installed' ; // Customize this line as needed
        }
      }
    },
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

Chart.defaults.global.defaultFontStyle = 'bold';
const month = ["January","February","March","April","May","June","July","August","September","October","November","December"];
const d = new Date();
let name = month[d.getMonth()];

new Chart("runningChart", {
  type: "line",
  data: {
    labels: @json($monthdata['date']),
    datasets: [{
      fill:true,
      lineTension: 0,
      backgroundColor: "#008000",
      borderColor: "rgba(0,0,255,0.1)",
      data: @json($monthdata['running'])
    }]
  },
  options: {
    legend: {display: false},
     scales: {
      yAxes: [
            { gridLines: {
                display:false
            },
            ticks: {min: 0}}],
      xAxes: [
            { gridLines: {
                display:false
            },
            ticks: {min: 0}}],      

    },
    tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
          return 'Running duration : ' + tooltipItem.yLabel + ' Hours on '+name + ' '+tooltipItem.xLabel; // Customize this line as needed
        }
      }
    },
  }
  
});


// idle chart
new Chart("idleChart", {
  type: "line",
  data: {
    labels: @json($monthdata['date']),
    datasets: [{
      fill: true,
      lineTension: 0,
      backgroundColor: "#FF0000",
      borderColor: "rgba(0,0,255,0.1)",
      data: @json($monthdata['idle'])
    }]
  },
  options: {
    legend: {display: false},
    scales: {
      yAxes: [
            { gridLines: {
                display:false
            },
            ticks: {min: 0}}],
      xAxes: [
            { gridLines: {
                display:false
            },
            ticks: {min: 0}}],      

    },
    tooltips: {
      callbacks: {
        label: function(tooltipItem, data) {
          var datasetLabel = data.datasets[tooltipItem.datasetIndex].label || '';
          return 'Idle duration : ' + tooltipItem.yLabel + ' Hours on '+name + ' '+tooltipItem.xLabel; // Customize this line as needed
        }
      }
    },

  }
});

//Notices Chart

new Chart("noticesChart", {
  type: "bar",
  data: {
    labels: @json($noticeArray['languages']),
    datasets: [{
      fill: true,
      lineTension: 0,
      backgroundColor: "#FEB834",
      borderColor: "rgba(0,0,255,0.1)",
      data: @json($noticeArray['published']),
      label: "Published" + "(" + @json($noticeArray['publish_count']) + ")"
    },
    {
      fill: true,
      lineTension: 0,
      backgroundColor: "#0496C7",
      borderColor: "rgba(0,0,255,0.1)",
      data: @json($noticeArray['unpublished']),
      label: "UnPublished" + "(" + @json($noticeArray['UnPublished_count']) + ")"
    },
    {
      fill: true,
      lineTension: 0,
      backgroundColor: "#696969",
      borderColor: "rgba(0,0,255,0.1)",
      data: @json($noticeArray['draft']),
      label: "Draft" + "(" + @json($noticeArray['draftdount']) + ")"
    },
    ]
  },
  options: {
      responsive: true,
      legend: {
        display: true,
         position: 'top' // place legend on the right side of chart
      },
      scales: {
         xAxes: [{
            stacked: true ,// this should be set to make the bars stacked
            gridLines: {
                display:false
            },
         }],
         yAxes: [{
            stacked: true ,// this also..

         }]
      }
   }
    ,
  
  
});

</script>
@endsection
