@extends('admin.layouts.app')

@push('css')
  <style>
    .hide_column {
        display : none;
    }
  </style>
@endpush
@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
              <i class="fa fa-align-justify"></i> Tourism Table
              <a href="{{route('admin.tourism.create')}}" class="btn btn-primary ml-10 pull-right"><i class="nav-icon icon-plus"></i> Add Tourism</a>
            </div>
            
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="user-table">
                    <thead>
                        <tr>
                          <th style="text-align: center;">No</th>
                          <th style="text-align: center;">Tourism Name</th>
                          <th style="text-align: center;">Address</th>
                          <th style="text-align: center;">Latitude</th>
                          <th style="text-align: center;">Longitude</th>
                          <th style="text-align: center;width:10vw">Action</th>
                          <th style="text-align: center;">Location</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 1;
                      @endphp
                        @foreach($tourism as $data)
                        <tr id="{{ $data->id }}"> 
                            <td>{{ $no }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->address }}</td>
                            <td>{{$data->latitude}}</td>
                            <td>{{$data->longitude}}</td>
                            <td style="vertical-align:middle">                              
                                <button type="button" class="btn btn-info btnEdit" id="{{ $data->id }}" data-toggle="modal" data-target="#editModal"><i class="nav-icon icon-pencil"></i></button>
                                <button type="button" class="btn btn-danger btnDelete" id="{{ $data->id }}"><i class="nav-icon icon-trash"></i></button>
                                <a type="button" class="btn btn-success" href="{{route('admin.tourism.show', $data->id)}}" id="{{ $data->id }}" target="_blank"><i class="nav-icon icon-info"></i></a>
                            </td>
                            <td style="text-align: center;"> 
                              <a type="button" class="btn btn-warning btnLocation" target="_blank" style="color:#fff"><i class="nav-icon icon-location-pin"></i></a>
                            </td>
                        </tr>
                        @php
                          $no++
                        @endphp
                        @endforeach
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>
   
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Edit Tourism</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="frmData" method="POST" action="" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="modal-body">
          <input type="hidden" id="category_id" name="category_id" value="2">
          <div class="form-group">
            <label>Tourism Name</label>
            <input id="nameEdit" type="text" class="form-control" name="name" placeholder="Hotel Name" required>
          </div>
          <div class="form-group">
            <label>Address</label>
            <input id="addressEdit" type="text" class="form-control" name="address" placeholder="Address" required>
          </div>
          <div class="form-group">
            <label>Photo</label>
            <input id="photoEdit" type="file" class="form-control" name="photo" placeholder="Photo">
          </div>
          <div class="form-group">
            <label for="city">City</label>
            <div>
              <select name="city" id="cityEdit" class="form-control">
                <option value="" selected disabled>-- SELECT CITY --</option>
                @foreach ($city as $c)
                  <option value="{{$c->id}}">{{$c->name}}</option>
                @endforeach
              </select>
              <br>
             </div>
          <div class="form-group">
            <label>Latitude</label>
            <input id="latitudeEdit" type="text" class="form-control" name="latitude" placeholder="Latitude" required>
          </div>
          <div class="form-group">
            <label>Longitude</label>
            <input id="longitudeEdit" type="text" class="form-control" name="longitude" placeholder="Longitude" required>
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

@endsection

@push('scripts')

<script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>
    
<script type="text/javascript">

$('#user-table').DataTable({
    columnDefs: [
      {
        "searchable": false
      },
    ]
  });

  $(document).on('click', '.btnEdit', function(e) {
    e.preventDefault;
    var id = $(this).attr('id');
    var action = "{{route('admin.tourism.index')}}/"+id;
    $('#frmData').attr('action', action);
    var row=$(this).closest("tr"); 
         
    var name=row.find("td:eq(1)").text();
    var address=row.find("td:eq(2)").text();
    var lat=row.find("td:eq(3)").text();
    var long=row.find("td:eq(4)").text();
    var photo=row.find("td:eq(5)").text();
    var desc=row.find("td:eq(6)").text();

    $('#nameEdit').val(name);
    $('#addressEdit').val(address);
    $('#latitudeEdit').val(lat);
    $('#longitudeEdit').val(long);
    $('#descEdit').val(desc);

  });

  $(document).on('click', '.btnDetail', function(e) {
    e.preventDefault;
    var row=$(this).closest("tr"); 
         
    var name=row.find("td:eq(1)").text();
    var address=row.find("td:eq(2)").text();
    var desc=row.find("td:eq(6)").text();
    var photo=row.find("td:eq(5)").text();

    $('#detailName').text(name);
    $('#detailAddress').text(address);
    $('#detailDesc').text(desc);
    $('#detailPhoto').css("background-image", "url("+photo+")");
    // console.log("url("+photo+")");
  });

  $(document).on('click', '.btnLocation', function(e) {
    e.preventDefault;
    var row=$(this).closest("tr"); 
         
    var lat=row.find("td:eq(3)").text();
    var lng=row.find("td:eq(4)").text();

    window.open("https://www.google.com/maps/@"+lat+","+lng+",15z", '_blank');

  });

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $(document).on('click', '.btnDelete', function (e) {
    var id = $(this).attr('id');
    var sid = parseInt(id, 10);
    var url = "{{ route('admin.tourism.index') }}/"+sid;
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

  $(function() {
    $('.toggle-class').change(function() {
      var status = $(this).prop('checked') == true ? 1 : 0; 
      var user_id = $(this).data('id'); 
      // console.log(status);
      console.log($(this));
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{route('admin.guide.index')}}/set-status/"+user_id,
        data: {'status': status},
        success: function(data){
          alert('successfully change user status');
        }
      });
    })
  });

    $(document).on('click', '.btnAdd', function (e) {
    $(".collapse").collapse('toggle');
  });
  
</script>
<script>
  /**
  * An event listener is added to listen to tap events on the map.
  * Clicking on the map displays an alert box containing the latitude and longitude
  * of the location pressed.
  * @param  {H.Map} map      A HERE Map instance within the application
  */
  function setUpClickListener(map) {
    // Attach an event listener to map display
    // obtain the coordinates and display in an alert box.
    map.addEventListener('tap', function (evt) {
      var coord = map.screenToGeo(evt.currentPointer.viewportX,
              evt.currentPointer.viewportY);
      console.log("lat : "+coord.lat);
      console.log("lng : "+coord.lng);
      // logEvent('Clicked at ' + Math.abs(coord.lat.toFixed(4)) +
      //     ((coord.lat > 0) ? 'N' : 'S') +
      //     ' ' + Math.abs(coord.lng.toFixed(4)) +
      //     ((coord.lng > 0) ? 'E' : 'W'));
    });
  }

  /**
  * Boilerplate map initialization code starts below:
  */

  //Step 1: initialize communication with the platform
  // In your own code, replace variable window.apikey with your own apikey
  var platform = new H.service.Platform({
    apikey: window.api_key
  });
  var defaultLayers = platform.createDefaultLayers();

  //Step 2: initialize a map
  var map = new H.Map(document.getElementById('mapContainer'),
    defaultLayers.vector.normal.map,{
    center: {lat: -7.94625288456589, lng: 110.10861860580418},
    zoom: 10,
    pixelRatio: window.devicePixelRatio || 1
  });
  // add a resize listener to make sure that the map occupies the whole container
  window.addEventListener('resize', () => map.getViewPort().resize());

  //Step 3: make the map interactive
  // MapEvents enables the event system
  // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
  var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

  setUpClickListener(map);                  
</script>

@endpush