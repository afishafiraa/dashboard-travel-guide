@extends('admin.layouts.app')

@section('content')

<div class="container">
  <div class="row justify-content-center">
    <div class="col-sm-10">                 
      <div class="row">
        <div class="col-md-12">
          <div class="card">

            <div class="card-header">
              <h5 class="mb-0">Profile Detail</h5>
            </div>
            <div class="card-body row" style="font-size:16px;">
              <div class="col-sm-3 text-center">
                <img src="{{$user->detail->photo}}" onerror="this.onerror=null; this.src='{{asset('images/default.png')}}'" alt="Your Profile Image" class="avatar img-circle img-thumbnail" style="margin-bottom:10px; width:80%;">
                <form method="POST" enctype="multipart/form-data" action="{{route('admin.changeava',$user->id)}}">
                  @csrf
                  <div class="form-group">
                    <input type="file" class="form-control-file" id="photo" name="photo">
                  </div>
                  <button type="submit" class="btn btn-primary">Change image</button>
                </form>
              </div>
              <div class="col-sm-9">
                <h3> {{$user->name}}</h3>
                <hr>
                <form method="POST" action="{{route('admin.profile.update', $user->id)}}">
                  {{ csrf_field() }}
                  @method('PUT')

                  @foreach ($errors->all() as $error)
                    <p class="text-danger">{{ $error }}</p>
                  @endforeach 

                  <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-left">Name</label>

                    <div class="col-md-6">
                      <input id="name" type="text" class="form-control" name="name" value="{{$user->name}}">
                    </div>
                  </div>

                  <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-left">Email</label>

                    <div class="col-md-6">
                        <input id="email" type="email" class="form-control" name="email" value="{{$user->email}}">
                    </div>
                  </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-left">New Password</label>

                    <div class="col-md-6">
                        <input id="new_password" type="password" class="form-control" name="password" autocomplete="current-password">
                    </div>
                </div>

                <div class="form-group row">
                    <label for="password" class="col-md-4 col-form-label text-md-left">New Confirm Password</label>

                    <div class="col-md-6">
                      <input id="password-confirm" type="password" class="form-control" name="password_confirmation" autocomplete="current-password">
                    </div>
                </div>
                  <div class="form-group row mb-0">
                    <div class="col-md-8 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            Update Profile
                        </button>
                    </div>
                </div>
                </form>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>          
</div><!--/tab-pane-->

@endsection

@push('scripts')
    
<script type="text/javascript">

  $('#user-table').DataTable()

  $(document).on('click', '.btnEdit', function(e) {
    e.preventDefault;
    var id = $(this).attr('id');
    var action = "{{route('admin.profile.index')}}/"+id;
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
            }
        });
    } 
  });

</script>

@endpush