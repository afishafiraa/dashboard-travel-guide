@extends('admin.layouts.app')
@push('css')
    <style>
      .c-chartjs-tooltip{position:absolute;z-index:1021;display:-ms-flexbox;display:flex;-ms-flex-direction:column;flex-direction:column;padding:.25rem .5rem;color:#fff;pointer-events:none;background:rgba(0,0,0,.7);opacity:0;transition:all .25s ease;-webkit-transform:translate(-50%,0);transform:translate(-50%,0);border-radius:.25rem}.c-chartjs-tooltip .c-tooltip-header{margin-bottom:.5rem}.c-chartjs-tooltip .c-tooltip-header-item{font-size:.765625rem;font-weight:700}.c-chartjs-tooltip .c-tooltip-body-item{display:-ms-flexbox;display:flex;-ms-flex-align:center;align-items:center;font-size:.765625rem;white-space:nowrap}.c-chartjs-tooltip .c-tooltip-body-item-color{display:inline-block;width:.875rem;height:.875rem;margin-right:.875rem}.c-chartjs-tooltip .c-tooltip-body-item-value{padding-left:1rem;margin-left:auto;font-weight:700}
    </style>
@endpush
@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
      
      <!-- /.row-->
      <div class="card">
        <div class="card-body">
          <div class="d-flex justify-content-between">
            <div>
                @php
                      $month = date('m');
                      $year = date('Y');
                  @endphp
              <h4 class="card-title mb-0">Traffic</h4>
            <div class="small text-muted">{{$month}} {{$year}}</div>
            </div>
            <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
              <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                <label class="btn btn-outline-secondary p-0">
                  
                  <select name="filter" id="monthFilter" class="form-control" style="border: none; background-color:transparent;">
                    <option value="" selected disabled>-- MONTH --</option>
                    <option value="01" {{ $month == '01' ? 'selected' : '' }}>Januari</option>
                    <option value="02" {{ $month == '02' ? 'selected' : '' }}>Februari</option>
                    <option value="03" {{ $month == '03' ? 'selected' : '' }}>Maret</option>
                    <option value="04" {{ $month == '04' ? 'selected' : '' }}>April</option>
                    <option value="05" {{ $month == '05' ? 'selected' : '' }}>Mei</option>
                    <option value="06" {{ $month == '06' ? 'selected' : '' }}>Juni</option>
                    <option value="07" {{ $month == '07' ? 'selected' : '' }}>Juli</option>
                    <option value="08" {{ $month == '08' ? 'selected' : '' }}>Agustus</option>
                    <option value="09" {{ $month == '09' ? 'selected' : '' }}>September</option>
                    <option value="10" {{ $month == '10' ? 'selected' : '' }}>Oktober</option>
                    <option value="11" {{ $month == '11' ? 'selected' : '' }}>November</option>
                    <option value="12" {{ $month == '12' ? 'selected' : '' }}>Desember</option>
                  </select>
                </label>
                <label class="btn btn-outline-secondary p-0">
                  <select name="" id="yearFilter" class="form-control" style="border: none; background-color:transparent;">
                    <option value="" selected disabled>-- YEAR --</option>
                    @foreach ($years as $y)
                      <option value="{{$y->year}}" {{ $year == $y->year ? 'selected' : '' }}>{{$y->year}}</option>
                    @endforeach
                  </select>
                </label>
              </div>
              <button class="btn btn-primary btnFilter" type="button">
                <svg class="c-icon">
                  <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-filter"></use>
                </svg>
              </button>
              <a class="btn btn-primary btnExport" type="button"  href="{{route('admin.report.exportT')}}" target="_blank">
                <svg class="c-icon">
                  <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-cloud-download"></use>
                </svg>
              </a>
            </div>
          </div>
          <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
            <canvas class="chart chart chartjs-render-monitor" id="myChart" height="300"></canvas>
          </div>
        </div>
        <div class="card-footer">
        </div>
      </div>
    </div>
</div>
   
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Guide</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="frmData" method="POST" action="">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="modal-body">
          <div class="form-group">
            <label>Name</label>
            <input id="nameEdit" type="text" class="form-control" name="name" placeholder="Name" required>
          </div>
          <div class="form-group">
            <label>Email</label>
            <input id="emailEdit" type="email" class="form-control" name="email" placeholder="Email Address" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button type="submit" class="btn btn-primary">Save changes</button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- Modal -->
<div class="modal fade" id="mdlData" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      
    </div>
  </div>
</div>

@endsection

@push('scripts')

<script>




</script>

<script type="text/javascript">


  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $.ajax({
    type: "GET",
    url: "{{ route('monthly-trans') }}",
    dataType: "json",
    success: function(data) {
      console.log(data.day);
      window.myChart = new Chart(document.getElementById('myChart'),
      {
        type:'line',
        data:{
        labels:data.day,
        datasets:[{
            label:'My First dataset',
            backgroundColor:'rgba(3, 9, 15, 0.1)',
            borderColor:'#39f',
            pointHoverBackgroundColor:'#fff',
            borderWidth:2,
            data:data.value
          }
        ]},
        options:{
          maintainAspectRatio:false,
          legend:{
            display:false
          },
          scales:{
            xAxes:[
              {gridLines:{drawOnChartArea:false}}
            ],
            yAxes:[{
              ticks:{
                beginAtZero:true,
                stepSize:1
              }
            }]
          },
          elements:{
            point:{
              radius:0,
              hitRadius:10,
              hoverRadius:4,
              hoverBorderWidth:3
            }
          }
        }
      });
    }
  });

  $(document).on('click', '.btnExport', function(e) {
    var month = $('#monthFilter').val();
    var year = $('#yearFilter').val();
    path = "{{ route('date-trans') }}/"+year+"-"+month;
     
    window.location.href=path;
    
  });

  $(document).on('click', '.btnFilter', function(e) {
    e.preventDefault();
    window.myChart.destroy();

    var month = $('#monthFilter').val();
    var year = $('#yearFilter').val();
    var path = "{{ route('monthly-trans') }}/"+year+"-"+month;
  
    console.log(path);
    $.ajax({
      type: "GET",
      url: path,
      dataType: "json",
      success: function(data) {
        console.log(data.day);
        window.myChart = new Chart(document.getElementById('myChart'),
        {
          type:'line',
          data:{
          labels:data.day,
          datasets:[{
              label:'My First dataset',
              backgroundColor:'rgba(3, 9, 15, 0.1)',
              borderColor:'#39f',
              pointHoverBackgroundColor:'#fff',
              borderWidth:2,
              data:data.value
            }
          ]},
          options:{
            maintainAspectRatio:false,
            legend:{
              display:false
            },
            scales:{
              xAxes:[
                {gridLines:{drawOnChartArea:false}}
              ],
              yAxes:[{
                ticks:{
                  beginAtZero:true,
                  stepSize:1
                }
              }]
            },
            elements:{
              point:{
                radius:0,
                hitRadius:10,
                hoverRadius:4,
                hoverBorderWidth:3
              }
            }
          }
        });
      }
    });
  });

  $(document).on('click', '.btnEdit', function(e) {
    e.preventDefault;
    var id = $(this).attr('id');
    var action = "{{route('admin.guide.index')}}/"+id;
    $('#frmData').attr('action', action);
    var row=$(this).closest("tr"); 
         
    var name=row.find("td:eq(1)").text();
    var email=row.find("td:eq(2)").text();

    $('#nameEdit').val(name);
    $('#emailEdit').val(email);

  });
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $(document).on('click', '.btnDelete', function (e) {
    var id = $(this).attr('id');  
    var sid = parseInt(id, 10);
    var url = "{{ route('admin.guide.index') }}/"+sid;
    console.log(url)
    if(confirm("Are you sure you want to delete this?")){ 
        console.log('teet')
        $.ajax({
            type: "delete",
            url: url,
            dataType: "json",
            success: (response) => {
              $(this).closest('tr').remove();
              location.reload();
            }
        });
    } 
  });

</script>

@endpush