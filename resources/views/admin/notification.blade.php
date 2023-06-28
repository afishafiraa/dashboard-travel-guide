@extends('admin.layouts.app')
@push('css')
<style>
  .autocomplete-suggestions {
      border: 1px solid #999;
      background: #FFF;
      overflow: auto;
  }
  .autocomplete-suggestion {
      padding: 2px 5px;
      white-space: nowrap;
      overflow: hidden;
  }
  .autocomplete-selected {
      background: #F0F0F0;
  }
  .autocomplete-suggestions strong {
      font-weight: normal;
      color: #3399FF;
  }
  .autocomplete-group {
      padding: 2px 5px;
  }
  .autocomplete-group strong {
      display: block;
      border-bottom: 1px solid #000;
  }
</style>
@endpush
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
              <i class="fa fa-align-justify"></i> Notification
              <button type="button" class="btn btn-primary btnAdd ml-10 pull-right" data-toggle="collapse" data-target="#collapseExample"><i class="nav-icon icon-plus"></i> Add Notification</button>
            </div>
            
            <div class="collapse p-3" id="collapseExample">
                <div class="card card-body">
                    <form method="POST" action="{{ route('admin.notification.store') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">{{ __('Notification Title')}}</label>

                            <div class="col-md-9">
                                <input id="title" placeholder="Notification Title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>

                                @error('title')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="message" class="col-md-3 col-form-label">{{ __('Notification Message ') }}</label>

                            <div class="col-md-9">
                                <textarea id="message" placeholder="Notification Message" class="form-control @error('message') is-invalid @enderror" name="message" value="{{ old('message') }}" required autocomplete="message"></textarea>

                                @error('message')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="description" class="col-md-3 col-form-label">{{ __('Notification Type ') }}</label>

                            <div class="col-md-9">
                              <select class="form-control" id="type" name="type" required>
                                <option disabled selected>-- Select Receiver --</option>
                                <option value="topic">Multiple Devices</option>
                                <option value="device">Specific Device</option>
                              </select>

                                @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label">{{ __('Receiver')}}</label>

                            <div class="col-md-9">
                                <input id="receiverText" type="text" class="form-control" name="receiver" placeholder="User e-mail address" value="{{ old('receiver') }}" autofocus>

                                <select class="form-control" id="topics" name="topics">
                                  <option value="general">All Devices</option> 
                                  <option value="guide">Guide</option> 
                                  <option value="merchant">Merchant</option>
                                </select>
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
                            <th style="text-align: center;" >No</th>
                            <th style="text-align: center;" >Notification Title</th>
                            <th style="text-align: center; width:35%" >Messages</th>
                            <th style="text-align: center;" >Target</th>
                            <th style="text-align: center;" >Status</th>
                            <th style="text-align: center;" >Action</th>
                        </tr>
                    </thead>
                    <tbody>
                      @php
                        $no = 1;
                      @endphp
                      @foreach ($notif as $data)
                        <tr id="{{ $data->id }}">
                            <td style="text-align: center;">{{$no}}</td>
                            <td style="text-align: left;">{{$data->title}}</td>
                            <td style="text-align: left;">{{$data->message}}</td>
                            <td style="text-align: center;">{{$data->receiver}}</td>
                            <td style="text-align: center;color:#fff">{!! ($data->status == 1) ? '<span class="badge bg-success">Posted</span>' : '<span class="badge bg-warning">Draft</span>' !!}
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-success btnSend" id="{{$data->id}}"><i class="cil-send"></i></button>
                                <button type="button" class="btn btn-info btnEdit" id="{{$data->id}}" data-toggle="modal" data-target="#editModal"><i class="nav-icon icon-pencil"></i></button>
                                <button type="button" class="btn btn-danger btnDelete" id="{{$data->id}}"><i class="nav-icon icon-trash"></i></button>
                                <!--<a type="button" class="btn btn-success" href="{{route('admin.notification.show', $data->id)}}" id="{{ $data->id }}" target="_blank"><i class="nav-icon icon-info"></i></a> -->
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
        <h5 class="modal-title" id="exampleModalLabel">Edit Notification</h5>
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
            <label>Notification Title</label>
            <input id="nameEdit" type="text" class="form-control" name="title" placeholder="Notification Title" required>
          </div>
          <div class="form-group">
            <label>Message</label>
            <textarea id="descriptionEdit" type="text" class="form-control" name="message" placeholder="Description" required></textarea>
          </div>
          <div class="form-group">
            <label for="action">{{ __('Action') }}</label>
            <select name="action" id="action" class="form-control">
              <option value="" selected disabled>-- SELECT ACTION --</option>
                <option value="draft">DRAFT</option>
                <option value="post">POST</option>
            </select>
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

<script src="{{ asset('js') }}/jquery.autocomplete.min.js"></script>
    
<script type="text/javascript">
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $(document).ready(function() {
    var path = "{{ route('get-email') }}";
    $.ajax({
      type: "GET",
      url: path,
      dataType: "json",
      success: function(data) {
        $('#receiverText').autocomplete({
          lookup: data.suggestions,
          onSelect: function (suggestion) {
            console.log(suggestion);
            $( "#receiverText" ).val(suggestion.value);
          }
        });
      }
    });
  })

  $("#topics").hide();

  $('#user-table').DataTable()

  $(document).on('click', '.btnEdit', function(e) {
    e.preventDefault;
    var id = $(this).attr('id');
    var action = "{{route('admin.notification.index')}}/"+id;
    $('#frmData').attr('action', action);
    var row=$(this).closest("tr"); 
         
    var name=row.find("td:eq(1)").text();
    var description=row.find("td:eq(2)").text();

    $('#nameEdit').val(name);
    $('#descriptionEdit').val(description);

  });

  $(document).on('change', '#type', function(e) {
    e.preventDefault();
    var type = $(this).val();
    if (type == 'topic') {
      $("#topics").show();
      $("#receiverText").hide();
    }else {
      $("#receiverText").show();
      $("#topics").hide();
    }
  });

  $(document).on('click', '.btnSend', function (e) {
    var id = $(this).attr('id');
    var sid = parseInt(id, 10);
    var url = "{{ route('admin.notification.index') }}-send/"+sid;
    if(confirm("Are you sure you want to send this notification?")){ 
      window.location = url;
    } 

  });

  $(document).on('click', '.btnLocation', function(e) {
    e.preventDefault;
    var row=$(this).closest("tr"); 
         
    var lat=row.find("td:eq(3)").text();
    var lng=row.find("td:eq(4)").text();

    window.open("https://www.google.com/maps/@"+lat+","+lng+",15z", '_blank');

  });
  $(document).on('click', '.btnDelete', function (e) {
    var id = $(this).attr('id');
    var sid = parseInt(id, 10);
    var url = "{{ route('admin.notification.index') }}/"+sid;
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

  $(document).on('click', '#btnClose', function (e) {
       $("#collapseExample").collapse('hide');
   });

</script>

@endpush