@extends('admin.layouts.app')
@push('css')
<link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
<style>
.H_ib_content{
  margin:0.5em;
  margin-right:2em;
  min-width: 4em;
}
.cil-location-pin {
  font-size: 2em;
}
.btn-map {
   white-space: nowrap;
   text-align: center;
}
</style>
@endpush
@section('content')
<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
              <i class="nav-icon icon-plus"></i> Create New Tourism
            </div>

            <div class="card-body">
                <form method="POST" action="{{ route('admin.tourism.store') }}" enctype="multipart/form-data">
                  @csrf
                  <div class="form-row">
                    <div class="col-md-12 mb-3">
                      <label>Tourism Name</label>
                      <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                      @error('name')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                      <label>Description</label>
                      <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description"></textarea>

                      @error('description')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="col-md-12 mb-3">
                      <label>Photo</label>
                      <div class="custom-file">
                        <input id="photo" type="file" class="custom-file-input @error('photo') is-invalid @enderror" name="photo" required autocomplete="photo">
                        <label class="custom-file-label" id="photo-label" for="photo">Choose file</label>
                      </div>
                        
                      @error('photo')
                          <span class="invalid-feedback" role="alert">
                              <strong>{{ $message }}</strong>
                          </span>
                      @enderror
                    </div>
                    <div class="col-md-12 mb-2">
                      <div class="form-group">
                        <label>Address</label>
                        <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

                        @error('address')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    <div class="col-md-12 mb-1">
                      <div class="form-group">
                        <label for="mytextarea">City</label>
                        <select name="city" id="city" class="custom-select" required>
                          <option value="" selected disabled>-- SELECT CITY --</option>
                          @foreach ($city as $c)
                            <option value="{{$c->id}}">{{$c->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>

                    <div class="alert alert-info w-100" role="alert">
                      Click on the map to get the Latitude and Longitude
                    </div>
                      
                    <div class="col-md-12 mb-3">
                      <div style="width: 100%; height: 300px;" id="mapContainer"></div>
                    </div>
                    
                    <div class="col-md-12">
                      <div class="form-group">
                        <label>Latitude</label>
                        <input id="latitude" type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{ old('latitude') }}" required autocomplete="latitude">

                        @error('latitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>
                    
                    <div class="col-md-12 mb-3">
                      <div class="form-group">
                        <label>Longitude</label>
                        <input id="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{ old('longitude') }}" required autocomplete="longitude">

                        @error('longitude')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                      </div>
                    </div>

                  </div>
                  <button class="btn btn-primary" type="submit">Submit form</button>
                </form>                  
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')

<script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript"></script>
<script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>
    
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
      window.cord = coord;
      console.log("lat : "+coord.lat);
      console.log("lng : "+coord.lng);
      var bubble =  new H.ui.InfoBubble({ lng: coord.lng, lat: coord.lat}, {
        // read custom data
        content: '<button type="button" class="btn-map">Set Location</button>'
      });
      // show info bubble
      ui.addBubble(bubble);
      // logEvent('Clicked at ' + Math.abs(coord.lat.toFixed(4)) +
      //     ((coord.lat > 0) ? 'N' : 'S') +
      //     ' ' + Math.abs(coord.lng.toFixed(4)) +
      //     ((coord.lng > 0) ? 'E' : 'W'));
    });
  }

  $(document).on('click', '.btn-map', function(e) {
    e.preventDefault();

    $('#latitude').val(window.cord.lat.toFixed(6));
    $('#longitude').val(window.cord.lng.toFixed(6));

  });

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
    center: {lat: -7.8, lng: 110.5},
    zoom: 10,
    pixelRatio: window.devicePixelRatio || 1
  });
  var ui = H.ui.UI.createDefault(map, defaultLayers);
  // add a resize listener to make sure that the map occupies the whole container
  window.addEventListener('resize', () => map.getViewPort().resize());

  //Step 3: make the map interactive
  // MapEvents enables the event system
  // Behavior implements default interactions for pan/zoom (also on mobile touch environments)
  var behavior = new H.mapevents.Behavior(new H.mapevents.MapEvents(map));

  setUpClickListener(map);

  $( "#photo" ).change(function(e) {
    var file = e.target.files[0].name;
    $('#photo-label').text(file);
  });

</script>

@endpush