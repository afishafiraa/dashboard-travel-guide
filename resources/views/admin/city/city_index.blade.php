@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
              <i class="fa fa-align-justify"></i> City List 
              <a type="button" href="{{route('admin.city.create')}}" class="btn btn-primary btnAdd ml-10 pull-right"><i class="nav-icon icon-plus"></i> Add City</a>
            </div>
            
            <div class="collapse p-3" id="collapseExample">
                <div class="card card-body">
                    <form method="POST" action="{{ route('admin.city.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">{{ __('Name City') }}</label>

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
                            <label for="latitude" class="col-md-3 col-form-label">{{ __('Latitude') }}</label>

                            <div class="col-md-9">
                                <input id="latitude" type="latitude" class="form-control @error('latitude') is-invalid @enderror" name="latitude" value="{{ old('latitude') }}" required autocomplete="new-latitude">

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
                                <input id="longitude" type="longitude" class="form-control @error('longitude') is-invalid @enderror" name="longitude" value="{{ old('longitude') }}"  required autocomplete="new-longitude">
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary btnClose" data-dismiss="collapse">Close</button>
                    </form>
                </div>
            </div>
            
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="user-table">
                    <thead>
                        <tr>
                            <th style="text-align: center;">No</th>
                            <th style="text-align: center;">City Name</th>
                            <th style="text-align: center;">Latitude</th>
                            <th style="text-align: center;">Longitude</th>
                            <th style="text-align: center;">Action</th>
                            <th style="text-align: center;">Location</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 1;
                      @endphp
                      @foreach ($city as $data)
                        <tr id="{{ $data->id }}">
                            <td>{{$no}}</td>
                            <td>{{$data->name}}</td>
                            <td style="text-align: center;">{{$data->latitude}}</td>
                            <td style="text-align: center;">{{$data->longitude}}</td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-info btnEdit" id="{{$data->id}}" data-toggle="modal" data-target="#editModal"><i class="nav-icon icon-pencil"></i></button>
                                <button type="button" class="btn btn-danger btnDelete" id="{{$data->id}}"><i class="nav-icon icon-trash"></i></button>
                             <!--   <button type="button" class="btn btn-success btnDetail" id="{{$data->id}}"><i class="nav-icon icon-info"></i></button> -->
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
        <h5 class="modal-title" id="exampleModalLabel">Edit City</h5>
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
            <label>Latitude</label>
            <input id="latEdit" type="text" class="form-control" name="latitude" placeholder="Latitude" required>
          </div>
          <div class="form-group">
            <label>Longitude</label>
            <input id="longEdit" type="text" class="form-control" name="longitude" placeholder="Longitude" required>
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

  $('#user-table').DataTable()

  $(document).on('click', '.btnEdit', function(e) {
    e.preventDefault;
    var id = $(this).attr('id');
    var action = "{{route('admin.city.index')}}/"+id;
    $('#frmData').attr('action', action);
    var row=$(this).closest("tr"); 
         
    var name=row.find("td:eq(1)").text();
    var latitude=row.find("td:eq(2)").text();
    var longitude=row.find("td:eq(3)").text();

    $('#nameEdit').val(name);
    $('#latEdit').val(latitude);
    $('#longEdit').val(longitude);

  });
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  
  $(document).on('click', '.btnLocation', function(e) {
    e.preventDefault;
    var row=$(this).closest("tr"); 
         
    var lat=row.find("td:eq(2)").text();
    var lng=row.find("td:eq(3)").text();

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
    var url = "{{ route('admin.city.index') }}/"+sid;
    console.log(url)
    if(confirm("Are you sure you want to delete this?")){ 
        console.log('teet')
        $.ajax({
            type: "delete",
            url: url,
            dataType: "json",
            success: (response) => {
              $(this).closest('tr').remove();
            }
        });
    } 
  });

  $(document).on('click', '.btnClose', function (e) {
       $("#collapseExample").collapse('hide');
   });
  
</script>

@endpush