@extends('layouts.app')

@section('content')

<div class="container-body">
 
	<div class="container-header">
		
		<div id="div2">
			<a href="{{ route('devices')}}"><button class="btn btn-outline-primary">Device List</button></a>
		</div> 

    <div id="div2" style="margin-right: 30px">
      <div class="mb-3 d">
        <input type="hidden" name="device_id" id="device_id" value="{{$data->id}}">
        
          <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
              <i class="glyphicon glyphicon-calendar fa fa-calendar" max="<?php echo date('Y-m-d');  ?>"></i>&nbsp;
              <span></span> <b class="caret"></b>
          </div>

      </div>
    </div>

		<div id="div1">
      <label class="label-bold">Devices Analytics</label>
    </div>

	</div>

  <div class="container-body">
    <div class="card bg-primary text-white">
      <div class="row">
        <div class="col-md-4">
          <label class="label-bold">Branch Name : </label> <label>{{$data->branch->name}} , {{$data->branch->branch_code}},{{$data->branch->ifsc}}</label>
        </div>
        <div class="col-md-4">
          <label class="label-bold">Device Serial Number : </label> <label>{{$data->deviceID}} </label>
        </div>
        <div class="col-md-4">
          <label class="label-bold" id="running">Total Running time : </label> 
        </div>
       
        
      </div>

      <div class="row">
        
         <div class="col-md-4">
          <label  class="label-bold">Area : </label> <label>{{$data->branch->area}}, {{$data->branch->city}},
          {{$data->branch->state}}, {{$data->branch->pincode}}</label>
        </div>
        <div class="col-md-4">
          <label  class="label-bold">last updated date: </label> <label>{{$data->last_updated_date}}</label>
        </div>
        <div class="col-md-4">
          <label  class="label-bold" id="idle">Total Idle Time : </label> 
        </div>
         
        
      </div>
      
    </div>

     <div class="row">
        <div class="card border-white">

            <table class="table">
                <thead>
                <tr>
                    <th scope="col">Date</th>
                    <th scope="col">Device Boot On Time</th>
                    <th scope="col">Device Boot Off Time</th>
                    <th scope="col">Total running hours</th>
                    <th scope="col">Total idle hours</th>
                    <th scope="col">View details</th>
                </tr>
                </thead>
                <tbody>
                   
                </tbody>
            </table>

        </div>
    </div>
    
  </div>

  <!-- Modal -->

           <div class="modal" id="myModal" tabindex="-1" role="dialog">
              <div class="modal-dialog" role="document">
                  <div class="modal-content">
                      <div class="modal-header">
                          <h5 class="modal-title">Device Health Response</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                              
                          </button>
                      </div>
                      <div class="modal-body">
                          <!-- Table content will be inserted here -->
                      </div>
                      <div class="modal-footer">
                          <button type="button" class="btn btn-secondary" class="btn-close" data-bs-dismiss="modal" aria-label="Close">Close</button>
                      </div>
                  </div>
              </div>
          </div>

<!--  end Modal -->
		
	</div>

  <script type="text/javascript">
  $( function() {
      $( "#date" ).datepicker({
        maxDate:0,
        dateFormat: 'yy-mm-dd',
        onSelect: function(dateText, $el) {
         // alert(dateText);
            $('#search_date').click();
           $('.date').hide();
   
        }
      });
    });

  
</script>

<script>
$(function() {
  $('input[name="daterange"]').daterangepicker({
    opens: 'left'
  }, function(start, end, label) {
    alert(start);
    console.log("A new date selection was made: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
  });
});
</script>

<script type="text/javascript">
$(function() {
    
    var today = <?php echo date('d');  ?>;
    var dd= today-1;
    var start = moment().subtract(dd, 'days');
    var end = moment();

 /**/

    function cb(start, end) {
        $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
        
        var from_date = start.format('YYYY-MM-DD');
        var to_date = end.format('YYYY-MM-DD');
        var device_id = document.getElementById('device_id').value;

        var _token = $('input[name="_token"]').val();
        
        fetch_data(from_date, to_date);

        function fetch_data(from_date = '', to_date = '')
         {

          $.ajax({
           url:"{{ route('fetch_analytics_data') }}",
           method:"POST",
           data:{from_date:from_date, to_date:to_date ,_token:_token , device_id:device_id },
           dataType:"json",
           success:function(data)
           {
            //alert(data.length);
            console.log(data);

            var output = '';
            var minutes_running = 0;
            var minutes_idle = 0;

           
            for(var count = 0; count < data.length; count++){
             // alert( data.length);
              var api_data = data[count].sync_data;
              minutes_running = parseInt(minutes_running) + parseInt(data[count].minutes_running);
              minutes_idle = parseInt(minutes_idle) + parseInt(data[count].minutes_idle);
              
               output += '<tr>';
               output += '<td>' + data[count].date + '</td>';
               output += '<td>' + data[count].boot_on_time + '</td>';
               output += '<td>' + data[count].boot_off_time + '</td>';
               output += '<td>' + data[count].total_running_hours + '</td>';
               output += '<td>' + data[count].total_idle_hours + '</td>';

               output += '<td>' + '<button type="button" value='+ api_data +' id="editdate'+count+'" data-date="'+api_data+'" class="btn btn-sm btn-light btn-outline-secondary" onclick="displayArrayInModal('+ count +')" >View Details</button>'+'</td></tr>';
              
            }
           // alert(minutes_running);

           
           document.getElementById('running').innerHTML ='Total Running Time : '+ Math.floor(minutes_running / 60) + 'Hr : ' + minutes_running % 60 + 'Min';
           document.getElementById('idle').innerHTML ='Total Idle Time : '+ Math.floor(minutes_idle / 60) + 'Hr : ' + minutes_idle % 60 +'Min ' ;

            $('tbody').html(output);
           
           }

          })
         }

   
 }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
           'Today': [moment(), moment()],
           'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
           'Last 7 Days': [moment().subtract(6, 'days'), moment()],
           'Last 30 Days': [moment().subtract(29, 'days'), moment()],
           'This Month': [moment().startOf('month'), moment().endOf('month')],
           'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    cb(start, end);
    
});

// function edit(cnt){
//   var data = document.getElementById('editdate'+cnt).value;
//  // alert(data);
 
//     $(".modal-body #edidate").text(data);
//     $('#modal').modal('show');
  
// }

function displayArrayInModal(cnt) {
var data = document.getElementById('editdate'+cnt).value;
//alert(data);

var sync =JSON.parse(data);

var table = '<table class="table">';
    table += '<thead><tr><th>Date</th><th>Updated Time</th></tr></thead>';
    table += '<tbody>';



    // Iterate through the array and add rows to the table
    for (var i = 0; i < sync.length; i++) {
        table += '<tr>';
        table += '<td>' + sync[i].last_updated_date + '</td>';
        table += '<td>' + sync[i].last_updated_time + '</td>';
        // Add more columns as needed
        table += '</tr>';
    }

    table += '</tbody></table>';

     $('#myModal').find('.modal-body').html(table);
    $('#myModal').modal('show');
  }

</script>
	

@endsection