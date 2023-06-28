@extends('admin.layouts.app')

@section('content')
<hr>
<div class="container bootstrap snippet">
    
  
  <div class="row align-items-end mb-3">
    <div class="col-sm-10"><h2 class="m-0">{{$data->name}}</h2></div>
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
      <form id="frmData" method="POST" action="{{route('admin.merchant.update',$id)}}" enctype="multipart/form-data">
          {{ csrf_field() }}
          {{ method_field('PUT') }}
          <div class="modal-body">
            <div class="form-group">
              <label>Name</label>
              <input id="nameEdit" type="text" class="form-control" name="name" placeholder="Name" value="{{$data->name}}">
            </div>
            <div class="form-group">
              <label>Email</label>
              <input id="emailEdit" type="email" class="form-control" name="email" placeholder="Email Address" value="{{$data->email}}">
            </div>
            <div class="form-group">
              <label>Address</label>
              <input id="addressEdit" type="text" class="form-control" name="address" placeholder="Address" value="{{$data->detail->address}}">
            </div>
            <div class="form-group">
              <label>Phone Number</label>
              <input id="phoneEdit" type="number" class="form-control" name="phone_number" placeholder="Phone Number" value="{{$data->detail->phone_number}}">
            </div>
            <div class="form-group">
              <label>Occupation</label>
              <input id="occupEdit" type="text" class="form-control" name="ocupation" placeholder="Occupation" value="{{$data->detail->ocupation}}">
            </div>
            <div class="form-group">
              <label>Photo</label>
              <div class="custom-file">
                <input type="file" name="photo" class="custom-file-input" id="photo">
                <label class="custom-file-label" for="customFile" id="photo-label" >Choose photo</label>
              </div>
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

    <div class="row">
  		<div class="col-sm-3"><!--left col-->      
      <div class="text-center">
        <img src="{{$data->detail->photo}}" onerror="this.onerror=null; this.src='{{asset('images/default.png')}}'"  class="avatar img-circle img-thumbnail" alt="avatar" >
        <h5 style="padding-top:10px;"><span class="badge badge-success">Point : {{$data->points}} </span></h5>
        <!--<input type="file" class="text-center center-block file-upload">-->
      </div><br>

          <!--     
          <div class="panel panel-default">
            <div class="panel-heading">Website <i class="fa fa-link fa-1x"></i></div>
            <div class="panel-body"><a href="http://bootnipets.com">bootnipets.com</a></div>
          </div>-->

          <ul class="list-group">
            <li class="list-group-item text-muted">Activity <i class="fa fa-dashboard fa-1x"></i></li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>QR Generated : </strong></span>{{$data->qr->count()}}</li>
            <li class="list-group-item text-right"><span class="pull-left"><strong>QR Used : </strong></span>{{$data->transactions->count()}}</li>
          </ul> 
          
        </div><!--/col-3-->
    	<div class="col-sm-9">
             <div class="tab-pane" id="settings">
                  <!-- body card profile detail -->                 
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-header">
                          <div class="row align-items-end mb-3">
                            <div class="col-sm-10"><h5 class="m-0">Profile Detail</h5></div>
                            <div class="col-sm-2" style="">
                                <a class="btn btn-primary btnEdit ml-10 pull-right" style="color:#fff;" data-toggle="modal" data-target="#editModal"><i class="nav-icon icon-pencil"></i> Edit</a>
                            </div>
                          </div>
                        </div>
                        <div class="card-body" style="font-size:16px;">
                          <div class="row" style="padding-bottom:0.75rem;">
                            <div class="col-sm-4">Full Name </div>
                            <div class="col-sm"> {{$data->name}} </div>
                          </div>
                          <div class="row" style="padding-bottom:0.75rem;">
                            <div class="col-sm-4">Email </div>
                            <div class="col-sm"> {{$data->email}} </div>
                          </div>
                          <div class="row" style="padding-bottom:0.75rem;">
                            <div class="col-sm-4">Address </div>
                            <div class="col-sm"> {{$data->detail->address}} </div>
                          </div>
                          <div class="row" style="padding-bottom:0.75rem;">
                            <div class="col-sm-4">Phone Number </div>
                            <div class="col-sm"> {{$data->detail->phone_number}} </div>
                          </div>
                          <div class="row" style="padding-bottom:0.75rem;">
                            <div class="col-sm-4">Occupation</div>
                            <div class="col-sm"> {{$data->detail->ocupation}} </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- sampe sini -->
                  <div class="row">
                    <div class="col-md-12">
                      <div class="card">
                        <div class="card-header" style="padding-bottom: 0.2rem; padding-top: 0.2rem;">
                          <h5>Transaction History</h5>
                        </div>
                          <div class="card-body" style="font-size:16px;">
                              <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="user-table">
                                  <thead>
                                      <tr>
                                          <th>No</th>
                                          <th>Promo</th>
                                          <th>Merchant Name</th>
                                          <th>Transaction Date</th>
                                      </tr>
                                  </thead>
                                  <tbody>
                                    @php
                                      $no = 1;
                                    @endphp
                                      @foreach($trans as $d)
                                     <tr id="{{$d->id}}"> 
                                          <td>{{ $no }}</td>
                                          <td>{{$d->qrcode->promo->item->name ." ".$d->qrcode->promo->category." " .$d->qrcode->promo->value}}</td>
                                          <td>{{$d->qrcode->promo->item->merchant->name}}</td>
                                          <td>{{$d->trx_time}}</td>
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
                  </div>
                </div>
              </div>
               
</div><!--/tab-pane-->

@endsection

@push('scripts')
    
<script type="text/javascript">

  $('#user-table').DataTable()

  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });

  $( "#photo" ).change(function(e) {
    var file = e.target.files[0].name;
    $('#photo-label').text(file);
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