@extends('admin.layouts.app')

@push('css')
<style>
.hide_column {
    display : none;
}
</style>
@endpush

@section('content')
<hr>
<div class="container bootstrap snippet">
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
  <div class="row align-items-end">
    <div class="col-sm-6" style="padding-bottom:10px;"><h2>{{$data->name}}</h2></div>
    <div class="col-sm-6" style="">
      <a class="btn btn-primary btnAdd ml-2 pull-right" style="color:#fff;" data-toggle="modal" data-target="#addItem">Add Item</a>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="addItem" tabindex="-1" role="dialog" aria-labelledby="addItemTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <form method="POST" enctype="multipart/form-data" action="{{route('admin.item.store')}}">
          @csrf
          <input type="hidden" name="merchant_id" value="{{$data->id}}">
          <div class="modal-header">
            <h5 class="modal-title" id="addPromoTitle">Add Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="promotitle" class="col-form-label">Name :</label>
              <input required type="text" name="name" class="form-control" id="promo-name" placeholder="Item Name">
            </div>
            <div class="form-group">
              <label for="promovalue" class="col-form-label">Price :</label>
              <input required type="number" name="price" class="form-control" id="value-promo" placeholder="Item Price">
            </div>
            <label class="col-form-label">Photo :</label>
            <div class="custom-file">
              <input required type="file" name="photo" class="custom-file-input" id="photo">
              <label class="custom-file-label" for="photo" id="photo-label">Choose photo</label>
            </div>
            <div class="form-group">
              <label for="descpromo" class="col-form-label">Description:</label>
              <textarea name="description" class="form-control" id="desc-promo"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div> <!--END MODAL-->

  <!-- Modal -->
  <div class="modal fade" id="editItem" tabindex="-1" role="dialog" aria-labelledby="editItemTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <form method="POST" id="editItemForm" enctype="multipart/form-data" action="">
          @csrf
          {{ method_field('PUT') }}
          <div class="modal-header">
            <h5 class="modal-title" id="addPromoTitle">Edit Item</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="promotitle" class="col-form-label">Name :</label>
              <input required type="text" name="name" class="form-control" id="edit_itemName" placeholder="Item Name">
            </div>
            <div class="form-group">
              <label for="promovalue" class="col-form-label">Price :</label>
              <input required type="number" name="price" class="form-control" id="edit_itemValue" placeholder="Item Price">
            </div>
            <label class="col-form-label">Photo :</label>
            <div class="custom-file">
              <input type="file" name="photo" class="custom-file-input" id="photo">
              <label required class="custom-file-label" for="photo" id="photo-label">Choose photo</label>
            </div>
            <div class="form-group">
              <label for="descpromo" class="col-form-label">Description:</label>
              <textarea name="description" class="form-control" id="edit_itemDesc"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div> <!--END MODAL-->

  <!-- Modal -->
  <div class="modal fade" id="addPromo" tabindex="-1" role="dialog" aria-labelledby="addPromoTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <form action="{{route('admin.promo.store')}}" method="post">
          @csrf
          <input type="hidden" name="item_id" class="form-control" id="item_id" value="">
          <div class="modal-header">
            <h5 class="modal-title" id="addPromoTitle">Add Promo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="promocategory" class="col-form-label">Category Promo:</label>
              <select required name="category" class="form-control form-control-sm">
                <option selected>Choose Category...</option>
                <option value="discount">Discount</option>
                <option value="price-cut">Price Cut</option>
              </select>
            </div>
            <div class="form-group">
              <label for="promovalue" class="col-form-label">Value:</label>
              <input required name="value" type="number" class="form-control" id="value-promo">
            </div>
            <div class="form-group">
              <label for="promovalue" class="col-form-label">Maximal Price Cut:</label>
              <input name="max_cut" type="number" class="form-control" id="value-promo">
            </div>
            <div class="form-group">
              <label for="promostart" class="col-form-label">Start Date:</label>
              <input required name="start_time" type="date" class="form-control" id="start-promo">
            </div>
            <div class="form-group">
              <label for="promoend" class="col-form-label">Expired Date:</label>
              <input required name="end_time" type="date" class="form-control" id="expired-promo">
            </div>
            <div class="form-group">
              <label for="descpromo" class="col-form-label">Description:</label>
              <textarea name="description" class="form-control" id="desc-promo"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        
        </form>
      </div>
    </div>
  </div> <!--END MODAL-->

  <!-- Edit Modal -->
  <div class="modal fade" id="editPromo" tabindex="-1" role="dialog" aria-labelledby="editPromoTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable" role="document">
      <div class="modal-content">
        <form id="formPromo" action="" method="post">
          @csrf
          {{ method_field('PUT') }}
          <div class="modal-header">
            <h5 class="modal-title" id="addPromoTitle">Edit Promo</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <div class="form-group">
              <label for="promocategory" class="col-form-label">Category Promo:</label>
              <select name="category" id="edit_category" class="form-control form-control-sm">
                <option selected>Choose Category...</option>
                <option value="discount">Discount</option>
                <option value="price-cut">Price Cut</option>
              </select>
            </div>
            <div class="form-group">
              <label for="promovalue" class="col-form-label">Value:</label>
              <input required name="value" type="number" class="form-control" id="edit_value">
            </div>
            <div class="form-group">
              <label for="promovalue" class="col-form-label">Maximal Price Cut:</label>
              <input name="max_cut" type="number" class="form-control" id="edit_max_cut">
            </div>
            <div class="form-group">
              <label for="promostart" class="col-form-label">Start Date:</label>
              <input required name="start_time" type="date" class="form-control" id="edit_start">
            </div>
            <div class="form-group">
              <label for="promoend" class="col-form-label">Expired Date:</label>
              <input required name="end_time" type="date" class="form-control" id="edit_expired">
            </div>
            <div class="form-group">
              <label for="descpromo" class="col-form-label">Description:</label>
              <textarea name="description" class="form-control" id="edit_desc"></textarea>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">Save changes</button>
          </div>
        </form>
      </div>
    </div>
  </div> <!--END MODAL-->

  <div class="row my-3">
    <div class="col-sm-3"><!--left col-->
      <div class="text-center">
        <img src="{{$data->photo}}" onerror="this.onerror=null; this.src='{{asset('images/default.png')}}'"  class="avatar img-circle img-thumbnail w-100" alt="avatar" >
        <!--<input type="file" class="text-center center-block file-upload">-->
      </div>
        
    </div><!--/col-3-->

    <div class="col-sm-9">
      <div class="tab-pane" id="settings">
        <!-- body card profile detail -->                 
        <div class="row">
          <div class="col-md-12">
            <div class="card">
              <div class="card-header" style="padding-bottom: 0.2rem; padding-top: 0.2rem;">
                <h5>Places Detail</h5>
              </div>
              <div class="card-body" style="font-size:16px;">
                <div class="row" style="padding-bottom:0.75rem;">
                  <div class="col-sm-4">Place Name </div>
                  <div class="col-sm"> {{$data->name}} </div>
                </div>
                <div class="row" style="padding-bottom:0.75rem;">
                  <div class="col-sm-4">Address </div>
                  <div class="col-sm"> {{$data->address}} </div>
                </div>
                @if ($data->description)
                <div class="row" style="padding-bottom:0.75rem;">
                  <div class="col-sm-4">
                    Description </div>
                  <div class="col-sm"> {{$data->description}} </div>
                </div>
                @endif
                @if ($data->latitude)
                <div class="row" style="padding-bottom:0.75rem;">
                  <div class="col-sm-4">Latitude </div>
                  <div class="col-sm"> {{$data->latitude}} </div>
                </div>
                @endif
                @if ($data->longitude)
                <div class="row" style="padding-bottom:0.75rem;">
                  <div class="col-sm-4">Longitude </div>
                  <div class="col-sm"> {{$data->longitude}} </div>
                </div>
                @endif
              </div>
            </div>
          </div>
        </div>
        <!-- sampe sini -->

      </div>
    </div><!-- sampe sini -->
  </div><!--/tab-pane-->

  
    <!-- Modal Detail Item -->
<div class="modal fade" id="itemDetail" tabindex="-1" role="dialog" aria-labelledby="itemDetailTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="tourismDetailTitle">Detail Item</h5>
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
          <h3 id="itemName"></h3>
        </div>
        <div class="col-sm-12" style="text-align:center;">
          <h5 id="itemPrice">{{$data->price}}</h5>
        </div>
        <div class="col-sm-12" style="text-align:center;">
          <p class="lead" id="itemDesc">{{$data->description}}</p>
        </div>
        <!-- <div class="col-sm-12" style="text-align:center;margin-bottom:20px;">
          <a type="button" class="btn btn-success btnLocation" target="_blank" style="color:#fff"><i class="nav-icon icon-location-pin"></i></a>
        </div>  -->
    </div>
    </div>
  </div>
</div> <!--END MODAL-->

  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" style="padding-bottom: 0.2rem; padding-top: 0.2rem;">
          <h5>List Item</h5>
        </div>
        <div class="card-body" style="">
          <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="user-table">
            <thead>
              <tr>
                <th style="text-align: center;">No</th>
                <th style="text-align: center;">Item Name</th>
                <th style="text-align: center; width:30%">Description</th>
                <th style="text-align: center; width:10%;">Price (Rp)</th>
                <th style="text-align: center;">Photo</th>
                <th style="text-align: center;">Action</th>
              </tr>
            </thead>
            <tbody>
              @php
                $no = 1;
              @endphp
              @foreach ($data->item as $item)
                <tr id="">
                    <td>{{$no}}</td>
                    <td style="text-align: left;">{{$item->name}}</td>
                    <td style="text-align: left;">{{$item->description}}</td>
                    <td style="text-align: center;">Rp. {{number_format($item->price,0,",",".")}}</td>
                    <td><img src="{{$item->photo}}" style="width:100px;" onerror="this.onerror=null; this.src='{{asset('images/default.png')}}'" class="avatar img-circle img-thumbnail" alt="avatar" ></td>
                    <td style="text-align: center;">
                      <a type="button" id="{{$item->id}}" class="btn btn-success btnPromo" style="color:#fff" data-toggle="modal" data-target="#addPromo"><i class="nav-icon icon-plus"></i> <span style="vertical-align: text-bottom"> Promo</span></a>
                        <a type="button" class="btn btn-info btnShow" style="color:#fff" data-toggle="modal" data-target="#itemDetail"><i class="nav-icon icon-info"></i></a>
                        <button type="button" class="btn btn-info btnEdit" id="{{$item->id}}" data-toggle="modal" data-target="#editItem"><i class="nav-icon icon-pencil"></i></button>
                        <a type="button" id="{{$item->id}}delete" class="btn btn-danger btnDelete" style="color:#fff" ><i class="nav-icon icon-trash"></i></a>
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
  
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header" style="padding-bottom: 0.2rem; padding-top: 0.2rem;">
          <h5>History Promo</h5>
        </div>
        <div class="card-body">

          <table class="table table-responsive-sm table-bordered table-striped table-sm data-table" id="promo-table">
              <thead>
                <tr>
                  <th style="text-align: center;">No</th>
                  <th style="text-align: center;">Item</th>
                  <th style="text-align: center;">Value</th>
                  <th style="text-align: center;">Max Cut</th>
                  <th style="text-align: center;">Category</th>
                  <th style="text-align: center; width:25%">Description</th>
                  <th style="text-align: center;">Start Date</th>
                  <th style="text-align: center;">End Date</th>
                  <th style="text-align: center;">Action</th>
                </tr>
              </thead>
              <tbody>
                @php
                  $no = 1;
                @endphp
                @foreach ($promos as $promo)
                  <tr id="">
                      <td>{{$no}}</td>
                      <td style="text-align: left;">{{$promo->item->name}}</td>
                      <td style="text-align: center;">{{$promo->value}}{{ $promo->category == 'discount' ? '%' : '' }}</td>
                      <td style="text-align: left;">Rp. {{number_format($promo->max_cut,0,",",".")}}</td>
                      <td style="text-align: left;">{{$promo->category}}</td>
                      <td style="text-align: left;">{{$promo->description}}</td>
                      <td style="text-align: center;">{{date('Y-m-d', strtotime($promo->start_time))}}</td>
                      <td style="text-align: center;">{{date('Y-m-d', strtotime($promo->end_time))}}</td>
                      <td style="text-align: center;">
                        <button type="button" class="btn btn-info btnEditPromo" id="{{$promo->id}}" data-toggle="modal" data-target="#editPromo"><i class="nav-icon icon-pencil"></i></button>
                        <a type="button" id="{{$promo->id}}promodelete" class="btn btn-danger promoDelete" style="color:#fff" ><i class="nav-icon icon-trash"></i></a>
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
</div>


@endsection

@push('scripts')
    
<script type="text/javascript">

  $('#user-table').DataTable();

  $('#promo-table').DataTable();

  $(document).on('click', '.btnShow', function(e) {
    e.preventDefault();
    var row=$(this).closest("tr"); 
         
    var name=row.find("td:eq(1)").text();
    var desc=row.find("td:eq(2)").text();
    var price=row.find("td:eq(3)").text();
    var photo=row.find("td:eq(4)");
    var img = photo.children().attr('src');

    $('#itemName').text(name);
    $('#itemDesc').text(desc);
    $('#itemPrice').text(price);
    $('#detailPhoto').css("background-image", "url("+img+")");
    console.log("url("+img+")");
  });

  $(document).on('click', '.btnPromo', function(e) {
    e.preventDefault();
    var id = $(this).attr('id');
    $('#item_id').val(id);
  });

  $(document).on('click', '.btnEditPromo', function(e) {
    e.preventDefault();
    // Ambil id item dan set url untuk form edit
    var id = $(this).attr('id');
    var action = "{{route('admin.promo.index')}}/"+id;
    $('#formPromo').attr('action', action);
    //Ambil isian untuk dimasukkan form
    var row=$(this).closest("tr"); 
    var value=row.find("td:eq(2)").text();
    var max=row.find("td:eq(3)").text();
    var category=row.find("td:eq(4)").text();
    var description=row.find("td:eq(5)").text();
    var start=row.find("td:eq(6)").text();
    var end=row.find("td:eq(7)").text();
    //set value dari form yang ada
    $('#edit_category').val(category);
    $('#edit_value').val(value.replace(/\D/g,''));
    $('#edit_max_cut').val(max.replace(/\D/g,''));
    $('#edit_start').val(start);
    $('#edit_expired').val(end);
    $('#edit_desc').val(description);
  });

  $(document).on('click', '.btnEdit', function(e) {
    e.preventDefault();
    // Ambil id item dan set url untuk form edit
    var id = $(this).attr('id');
    var action = "{{route('admin.item.index')}}/"+id;
    $('#editItemForm').attr('action', action);
    //Ambil isian untuk dimasukkan form
    var row=$(this).closest("tr"); 
    var name=row.find("td:eq(1)").text();
    var description=row.find("td:eq(2)").text();
    var value=row.find("td:eq(3)").text();
    //set value dari form yang ada
    $('#edit_itemName').val(name);
    $('#edit_itemValue').val(value.replace(/\D/g,''));
    $('#edit_itemDesc').val(description);
  });
  $.ajaxSetup({
      headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
  });
  $(document).on('click', '.btnDelete', function (e) {
    var id = $(this).attr('id');
    var sid = parseInt(id, 10);
    var url = "{{ route('admin.item.index') }}/"+sid;
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
  $(document).on('click', '.promoDelete', function (e) {
    var id = $(this).attr('id');
    var sid = parseInt(id, 10);
    var url = "{{ route('admin.promo.index') }}/"+id;
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

  $( ".custom-file-input" ).change(function(e) {
    var file = e.target.files[0].name;
    $('.custom-file-label').text(file);
  });

</script>

@endpush