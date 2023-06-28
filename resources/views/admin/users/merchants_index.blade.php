@extends('admin.layouts.app')

@section('content')

<div class="container-fluid">
    <div class="animated fadeIn">
        <div class="card">
            <div class="card-header">
              <i class="fa fa-align-justify"></i> Merchants Table
              <button type="button" class="btn btn-primary btnAdd ml-10 pull-right" data-toggle="collapse" data-target="#collapseExample"><i class="nav-icon icon-plus"></i> Add Merchant</button>
            </div>
            
            <div class="collapse p-3" id="collapseExample">
                <div class="card card-body">
                    <form method="POST" action="{{ route('admin.merchant.store') }}">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">{{ __('Name') }}</label>
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
                            <label for="email" class="col-md-3 col-form-label">{{ __('E-Mail Address') }}</label>
                            <div class="col-md-9">
                                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password" class="col-md-3 col-form-label">{{ __('Password') }}</label>
                            <div class="col-md-9">
                                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="new-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="password-confirm" class="col-md-3 col-form-label">{{ __('Confirm Password') }}</label>
                            <div class="col-md-9">
                                <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required autocomplete="new-password">
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
                            <th style="text-align:center;">No</th>
                            <th style="text-align:center;">Name</th>
                            <th style="text-align:center;">Email</th>
                            <th style="text-align:center;">Merchant</th>
                            <th style="text-align:center;">Status</th>
                            <th style="text-align:center;">Date Registered</th>
                            <th style="width:12%; text-align:center;">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 1;
                      @endphp
                        @foreach($merchants as $data)
                        <tr id="{{ $data->id }}">
                            <td>{{ $no }}</td>
                            <td>{{ $data->name }}</td>
                            <td>{{ $data->email }}</td>
                            <td>{{ $data->merchant ? $data->merchant->name : 'Not set' }}</td>
                            <td>
                              <label data-id="{{$data->id}}" class="toggle-class c-switch c-switch-pill c-switch-label c-switch-success">
                                <input data-id="{{$data->id}}" class="c-switch-input" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $data->status ? 'checked' : '' }}>
                                <span data-id="{{$data->id}}" class="c-switch-slider" data-checked="On" data-unchecked="Off">
                              </label>
                            </td>
                            <td>{{ $data->created_at }}</td>
                            <td style="text-align:center;">
                                <button type="button" class="btn btn-danger btnDelete" id="{{ $data->id }}"><i class="nav-icon icon-trash"></i></button>
                                <a type="button" class="btn btn-success" href="{{route('admin.merchant.show', $data->id)}}" id="{{ $data->id }}" target="_blank"><i class="nav-icon icon-info"></i></a>
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Merchant</h5>
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
          <div class="form-group">
            <label for="promocategory" class="col-form-label">Merchant :</label>
            <select class="form-control form-control-sm" required name="merchant_id">
              <option selected disabled>Choose Merchant...</option>
              @foreach ($merchant_list as $merchant)
                <option value="{{$merchant->id}}">{{$merchant->name}}</option>
              @endforeach
            </select>
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
    var action = "{{route('admin.merchant.index')}}/"+id;
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
    var url = "{{ route('admin.merchant.index') }}/"+sid;
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
      console.log($(this).prop('checked'));
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

  
  $(document).on('click', '#btnClose', function (e) {
       $("#collapseExample").collapse('hide');
   });

</script>

@endpush