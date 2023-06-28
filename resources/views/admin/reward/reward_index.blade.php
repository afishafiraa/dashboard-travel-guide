@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
  
    @if ($errors->any())
      @foreach ($errors->all() as $error)
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ $error }}<br>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      @endforeach
    @endif
    
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
              <i class="fa fa-align-justify"></i> Reward List
              <button type="button" class="btn btn-primary btnAdd ml-10 pull-right" data-toggle="collapse" data-target="#collapseExample"><i class="nav-icon icon-plus"></i> Add Reward</button>
            </div>

            <div class="collapse p-3 {{ $errors->any() ? 'show' : '' }}" id="collapseExample">
                <div class="card card-body">
                    <form method="POST" action="{{ route('admin.reward.store') }}" enctype="multipart/form-data">
                       @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">{{ __('Name Reward') }}</label>

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
                            <label for="email" class="col-md-3 col-form-label">{{ __('Point') }}</label>

                            <div class="col-md-9">
                                <input id="point" type="number" class="form-control @error('point') is-invalid @enderror" name="point" value="{{ old('point') }}" required autocomplete="point">

                                @error('point')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="photo" class="col-md-3 col-form-label">{{ __('Photo') }}</label>

                            <div class="col-md-9">
                                <div class="custom-file">
                                  <input type="file" class="custom-file-input @error('photo') is-invalid @enderror" id="photo" name="photo" value="{{ old('photo') }}" required autocomplete="photo">
                                  <label class="custom-file-label" for="photo">Choose file</label>
                                  @error('photo')
                                      <span class="invalid-feedback" role="alert">
                                          <strong>{{ $message }}</strong>
                                      </span>
                                  @enderror
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="desc" class="col-md-3 col-form-label">{{ __('Description') }}</label>

                            <div class="col-md-9">
                                <textarea id="text" type="text" class="form-control @error('desc') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="description"></textarea>

                                @error('desc')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="button" class="btn btn-secondary" id="btnClose" data-dismiss="collapse">Close</button>
                    </form>
                </div>
            </div>
            
            <div class="card-body">
                <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="user-table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Reward Name</th>
                            <th>Point</th>
                            <th>Photo</th>
                            <th>Description</th>
                            <th style="text-align: center;width:10vw;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 1;
                      @endphp
                      @foreach ($data as $item)
                        <tr id="">
                            <td>{{$no}}</td>
                            <td>{{$item->name}}</td>
                            <td>{{$item->point}}</td>
                            <td><img src="{{$item->photo}}" style="width:100px;" onerror="this.onerror=null; this.src='{{asset('images/default.png')}}'" class="avatar img-circle img-thumbnail" alt="avatar" ></td>
                            {{-- <td><img src="{{$item->photo}}" style="width:100px;" class="avatar img-circle img-thumbnail" alt="avatar" ></td> --}}
                            <td>{{$item->description}}</td>
                            <td style="vertical-align:middle;text-align: center;">
                            <button type="button" class="btn btn-info btnEdit" id="{{$item->id}}" data-toggle="modal" data-target="#editModal"><i class="nav-icon icon-pencil"></i></button>
                                <button type="button" class="btn btn-danger btnDelete" id="{{$item->id}}"><i class="nav-icon icon-trash"></i></button>
                                <button type="button" class="btn btn-success btnDetail" data-toggle="modal" data-target="#rewardDetail" id="{{$item->id}}"><i class="nav-icon icon-info"></i></button>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Reward</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="frmData" method="POST" enctype="multipart/form-data">
        {{ csrf_field() }}
        {{ method_field('PUT') }}
        <div class="modal-body">
          <div class="form-group">
            <label>Name</label>
            <input id="nameEdit" type="text" class="form-control" name="name" placeholder="Name" required>
          </div>
          <div class="form-group">
            <label>Point</label>
            <input id="pointEdit" type="number" class="form-control" name="point" placeholder="Point" required>
          </div>
          <div class="form-group">
            <label>Photo</label>
            <input id="photoEdit" type="file" class="form-control" name="photo" placeholder="Photo">
          </div>
          <div class="form-group">
            <label>Description</label>
            <textarea id="descEdit" type="text" class="form-control" name="description" placeholder="Description"></textarea>
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

<!--Modal Detail -->
<div class="modal fade" id="rewardDetail" tabindex="-1" role="dialog" aria-labelledby="rewardDetailTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tourismDetailTitle">Detail Reward</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <div class="col-sm-12" style="margin-bottom:15px;">
          <div class="row justify-content-center">
            <div class="view d-flex"  id="detailPhoto" style="background-repeat: no-repeat; background-size: cover; background-position:center; width:50%; height:200px;">
            </div>
          </div>
        </div>
        <div class="col-sm-12" style="text-align:center;">
          <h3 id="detailName"></h3>
        </div>
        <div class="col-sm-12" style="text-align:center;">
          <h5 id="detailPoint"></h5>
        </div>
        <div class="col-sm-12" style="text-align:center;">
        <p class="lead" id="detailDesc"></p>
        </div>
    </div>
  </div>
</div> <!--END MODAL-->

@endsection

@push('scripts')
    
<script type="text/javascript">

  $('#user-table').DataTable()

  $(document).on('click', '.btnEdit', function(e) {
    e.preventDefault();
    var action = "{{route('admin.reward.index')}}/" + $(this).attr('id');
    $('#frmData').attr('action', action);
    var row=$(this).closest("tr"); 
    
    var name=row.find("td:eq(1)").text();
    var point=row.find("td:eq(2)").text();
    var description=row.find("td:eq(4)").text();

    $('#nameEdit').val(name);
    $('#pointEdit').val(point);
    $('#descEdit').val(description);
  });

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $(document).on('click', '.btnDelete', function (e) {
    var id = $(this).attr('id');
    var sid = parseInt(id, 10);
    var url = "{{ route('admin.reward.index') }}/"+sid;
    
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

  $(document).on('click', '.btnDetail', function(e) {
    e.preventDefault();
    var row=$(this).closest("tr"); 
    var name=row.find("td:eq(1)").text();
    var point=row.find("td:eq(2)").text();
    var photo=row.find("td:eq(3)");
    var desc=row.find("td:eq(4)").text();

    var img = photo.children().attr('src');

    $('#detailName').text(name);
    $('#detailPoint').text(point);
    $('#detailDesc').text(desc);
    $('#detailPhoto').css("background-image", "url("+img+")");
    // console.log("url("+photo+")");
  });

  $(document).on('click', '#btnClose', function (e) {
       $("#collapseExample").collapse('hide');
   });

  $( "#photo" ).change(function(e) {
    var file = e.target.files[0].name;
    $('.custom-file-label').text(file);
  });

</script>

@endpush