@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
      
        @if (!$highlight->isEmpty())
        <div class="card">
          <div class="card-header">
            <i class="cil-highligt"></i> Highlighted Merchant
          </div>
          <div class="card-body">
            <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="highlight-table">
              <thead>
                  <tr>
                    <th style="text-align: center;">No</th>
                    <th style="text-align: center;width:25%">Store Name</th>
                    <th style="text-align: center;width:30%;">Address</th>
                    <th style="text-align: center;">Latitude</th>
                    <th style="text-align: center;">Longitude</th>
                    <th style="text-align: center;width:15%">Action</th>
                    <th style="text-align: center;">Location</th>
                  </tr>
              </thead>
              <tbody>
                @php
                  $no = 1;
                @endphp
                @foreach ($highlight as $data)
                <tr id="{{ $data->id }}">
                  <td>{{$no}}</td>
                  <td><a href="{{route('admin.places.show', $data->id)}}" id="{{ $data->id }}" target="_blank">{{$data->name}}</a></td>
                  <td>{{$data->address}}</td>
                  <td>{{$data->latitude}}</td>
                  <td>{{$data->longitude}}</td>
                  <td style="text-align: center;">
                    <button type="button" class="btn btn-info btnEdit" id="{{$data->id}}" data-toggle="modal" data-target="#editModal"><i class="nav-icon icon-pencil"></i></button>
                    <button type="button" class="btn btn-danger btnDelete" id="{{$data->id}}"><i class="nav-icon icon-trash"></i></button>
                    <button type="button" class="btn btn-success btnHighlight" id="{{$data->id}}"><i class="nav-icon cil-highligt"></i></button>
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
        @endif
        <div class="card" id="accordionExample">
            <div class="card-header">
              <i class="fa fa-align-justify"></i> Hotel Places
              <a type="button" href="{{route('admin.places.create')}}" class="btn btn-primary btnAdd ml-10 pull-right"><i class="nav-icon icon-plus"></i> Add Hotel</a>
            </div>
            
            <div class="collapse p-3" id="collapseExample" data-parent="#accordionExample">
                <div class="card card-body">
                    <form method="POST" action="{{ route('admin.places.store') }}" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" id="c_id" name="category_id" value="2">
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">{{ __('Hotel Name')}}</label>

                            <div class="col-md-9">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label">{{ __('Description ') }}</label>

                            <div class="col-md-9">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" required autocomplete="description"></textarea>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo" class="col-md-3 col-form-label">{{ __('Add Photo') }}</label>

                            <div class="col-md-9">
                                <input id="photo" type="file" class="form-control @error('photo') is-invalid @enderror" name="photo" value="{{ old('photo') }}" required autocomplete="photo">

                                @error('photo')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="address" class="col-md-3 col-form-label">{{ __('Address') }}</label>

                            <div class="col-md-9">
                                <input id="address" type="text" class="form-control @error('address') is-invalid @enderror" name="address" value="{{ old('address') }}" required autocomplete="address">

                                @error('address')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="latitude" class="col-md-3 col-form-label">{{ __('Latitude') }}</label>

                            <div class="col-md-9">
                                <input id="latitude" type="text" class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{ old('latitude') }}" required autocomplete="latitude">

                                @error('latitude')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="longitude" class="col-md-3 col-form-label">{{ __('Longitude') }}</label>

                            <div class="col-md-9">
                                <input id="longitude" type="text" class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{ old('longitude') }}" required autocomplete="longitude">

                                @error('longitude')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>
            </div>
            
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="user-table">
                    <thead>
                        <tr>
                          <th style="text-align: center;">No</th>
                          <th style="text-align: center;width:25%">Store Name</th>
                          <th style="text-align: center;width:30%;">Address</th>
                          <th style="text-align: center;">Latitude</th>
                          <th style="text-align: center;">Longitude</th>
                          <th style="text-align: center;width:15%">Action</th>
                          <th style="text-align: center;">Location</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 1;
                      @endphp
                      @foreach ($hotel as $data)
                        <tr id="{{ $data->id }}">
                            <td>{{$no}}</td>
                            <td><a href="{{route('admin.places.show', $data->id)}}" id="{{ $data->id }}" target="_blank">{{$data->name}}</a></td>
                            <td>{{$data->address}}</td>
                            <td>{{$data->latitude}}</td>
                            <td>{{$data->longitude}}</td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-info btnEdit" id="{{$data->id}}" data-toggle="modal" data-target="#editModal"><i class="nav-icon icon-pencil"></i></button>
                                <button type="button" class="btn btn-danger btnDelete" id="{{$data->id}}"><i class="nav-icon icon-trash"></i></button>
                                <button type="button" class="btn btn-success btnHighlight" id="{{$data->id}}"><i class="nav-icon cil-highligt"></i></button>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit hotel</h5>
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
            <label>Hotel Name</label>
            <input id="nameEdit" type="text" class="form-control" name="name" placeholder="Hotel Name" required>
          </div>
          <div class="form-group">
            <label>Address</label>
            <input id="addressEdit" type="text" class="form-control" name="address" placeholder="Address" required>
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
    
<script type="text/javascript">
  $('#highlight-table').DataTable({
    "pageLength": 5
  });

  $('#user-table').DataTable()

  $(document).on('click', '.btnEdit', function(e) {
    e.preventDefault;
    var id = $(this).attr('id');
    var action = "{{route('admin.places.index')}}/"+id;
    $('#frmData').attr('action', action);
    var row=$(this).closest("tr"); 
         
    var name=row.find("td:eq(1)").text();
    var address=row.find("td:eq(2)").text();
    var latitude=row.find("td:eq(3)").text();
    var longitude=row.find("td:eq(4)").text();

    $('#nameEdit').val(name);
    $('#addressEdit').val(address);
    $('#latitudeEdit').val(latitude);
    $('#longitudeEdit').val(longitude);

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

  $('.btnHighlight').click(function() {
    var user_id = $(this).attr('id'); 
    
    if(confirm("Are you sure you want to highlight/remove highlight?")){
      $.ajax({
        type: "POST",
        dataType: "json",
        url: "{{route('admin.places.index')}}/highlight/"+user_id,
        data: {'id': user_id},
        success: function(data){
          alert('successfully change user status');
          location.reload();
        }
      });
    } 
  });

  $(document).on('click', '.btnDelete', function (e) {
    var id = $(this).attr('id');
    var sid = parseInt(id, 10);
    var url = "{{ route('admin.places.index') }}/"+sid;
    console.log(url)
    if(confirm("Are you sure you want to delete this?")){ 
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