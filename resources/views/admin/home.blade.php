@extends('admin.layouts.app')

{{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script> --}}

@section('content')
<div class="container-fluid">
  <div class="fade-in">
    <div class="row">
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-primary">
          <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
            <div>
            <div class="text-value-lg">{{$guide}}</div>
              <div>User Guide</div>
              <br>
            </div>
            <div class="btn-group">
              <a type="button" class="btn btn-lg" href="{{ route('admin.guide.index') }}" style="color:#fff;"><i class="cil-arrow-thick-right"></i></a>
            </div>
          </div>
        </div>
      </div>
      <!-- /.col-->
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-info">
          <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
            <div>
              <div class="text-value-lg">{{$merchant}}</div>
              <div>User Merchant</div>
              <br>
            </div>
            <div class="btn-group">
              <a type="button" class="btn btn-lg" href="{{ route('admin.merchant.index') }}" style="color:#fff;"><i class="cil-arrow-thick-right"></i></a>
            </div>
          </div>
        </div>
      </div>
      <!-- /.col-->
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-warning">
          <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
            <div>
              <div class="text-value-lg">{{$tourism}}</div>
              <div>Tourism</div>
              <br>
            </div>
            <div class="btn-group">
              <a type="button" class="btn btn-lg" href="{{ route('admin.tourism.index') }}" style="color:#fff;"><i class="cil-arrow-thick-right"></i></a>
            </div>
          </div>
        </div>
      </div>
      <!-- /.col-->
      <div class="col-sm-6 col-lg-3">
        <div class="card text-white bg-danger">
          <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
            <div>
              <div class="text-value-lg">{{$trans}}</div>
              <div>Transaction</div>
              <br>
            </div>
            <div class="btn-group">
              <a type="button" class="btn btn-lg" href="{{ route('admin.transaction.index') }}" style="color:#fff;"><i class="cil-arrow-thick-right"></i></a>
            </div>
          </div>
        </div>
      </div>
      <!-- /.col-->
    </div>
    <!-- /.row-->
    <div class="card">
      <div class="card-header">
        <i class="fa fa-align-justify"></i> All Menu
      </div>
      <div class="card-body">
        <nav>
          <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
            <a class="nav-item nav-link active" id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">Home</a>
            <a class="nav-item nav-link" id="nav-user-tab" data-toggle="tab" href="#nav-user" role="tab" aria-controls="nav-user" aria-selected="false">User</a>
            <a class="nav-item nav-link" id="nav-places-tab" data-toggle="tab" href="#nav-places" role="tab" aria-controls="nav-places" aria-selected="false">Places</a>
            <a class="nav-item nav-link" id="nav-tourism-tab" data-toggle="tab" href="#nav-tourism" role="tab" aria-controls="nav-tourism" aria-selected="false">Tourism</a>
            <a class="nav-item nav-link" id="nav-city-tab" data-toggle="tab" href="#nav-city" role="tab" aria-controls="nav-city" aria-selected="false">City</a>
            <a class="nav-item nav-link" id="nav-promo-tab" data-toggle="tab" href="#nav-promo" role="tab" aria-controls="nav-promo" aria-selected="false">Promo</a>
            <a class="nav-item nav-link" id="nav-reward-tab" data-toggle="tab" href="#nav-reward" role="tab" aria-controls="nav-reward" aria-selected="false">Reward</a>
            <a class="nav-item nav-link" id="nav-transaction-tab" data-toggle="tab" href="#nav-transaction" role="tab" aria-controls="nav-transaction" aria-selected="false">Transaction</a>
            <a class="nav-item nav-link" id="nav-report-tab" data-toggle="tab" href="#nav-report" role="tab" aria-controls="nav-report" aria-selected="false">Report</a>
          </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
          <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
            <br>
            <h4>Home Page</h4>
            <hr>
            <p>
              Menyediakan ringkasan informasi dari keseluruhan isi dari sistem. Informasi ini meliputi sebagai berikut :
              <br>
            </p>
            <ul>
              <li>Jumlah pengguna yang terdaftar</li>
              <li>Jumlah pariwisata yang terdaftar</li>
              <li>Jumlah transaksi yang telah dilakukan</li>
              <li>Top rank guide</li>
            </ul>
            <!--<a type="button" class="btn btn-outline-info btn-md float-right" href="/home">Go to Page <i class="cil-caret-right"></i> </a>-->
          </div>

          <div class="tab-pane fade" id="nav-user" role="tabpanel" aria-labelledby="nav-user-tab">
            <br>
            <h4>User Page</h4>
            <hr>
            <p>
              Menyediakan ringkasan informasi tantang pengguna yang telah terdaftar pada sistem. Pengguna ini terbagi menjadi dua kategori yaitu Guide dan Merchant.
              Hal yang dapat dilakukan pada menu tab User adalah sebagai berikut :
              <br>
            </p>
            <ul>
              <li>Admin dalam menambah akun baru sebagai merchant atau guide.</li>
              <li>Admin dapat mengubah data pada akun guide/merchant jika diperlukan ada perubahan.</li>
              <li>Admin dapat mengapus akun pengguna jika tidak diperlukan lagi atau ada kebijakan lain.</li>
              <li>Admin dapat melihat info profile detail dari pengguna yang terdaftar</li>
              <li>Admin dapat menon-aktifkan pengguna atas kebijakan tertentu.</li>
            </ul>
            <a type="button" class="btn btn-outline-info btn-md float-right" href="{{route('admin.guide.index')}}">Go to Page Guide<i class="cil-caret-right"></i> </a>
            <a type="button" class="btn btn-outline-info btn-md float-right" href="{{route('admin.merchant.index')}}" style="margin-right:10px;">Go to Page Merchant<i class="cil-caret-right"></i> </a>
          </div>

          <div class="tab-pane fade" id="nav-places" role="tabpanel" aria-labelledby="nav-places-tab">
            <br>
            <h4>Places Page</h4>
            <hr>
            <p>
              Menyediakan ringkasan informasi tentang tempat merchant yang ada disekitar pariwisata yang terdaftar di sistem. Tempat merchant ini dibedakan berdasarkan
              kategori merchant yaitu toko, hotel, dan restoran. Hal yang dapat dilakukan pada menu tab Places adalah sebagai berikut :
              <br>
            </p>
            <ul>
              <li>Admin dapat menambahkan data merchant berdasarkan masing - masing kategori disekitar pariwisata yang ada.</li>
              <li>Admin dapat mengubah data informasi merchant sesuai dengan kebutuhan</li>
              <li>Admin dapat menambahkan item yang tersedia pada setiap merchant</li>
              <li>Admin dapat menambahkan promo pada merchant yang diinginkan</li>
              <li>Admin dapat menghapus data merchant yang tidak diperlukan</li>
              <li>Admin dapat mengetahui lokasi merchant melalui location melalui Google Maps</li>
            </ul>
            <a type="button" class="btn btn-outline-info btn-md float-right" href="{{route('admin.places.storeindex')}}">Go to Page <i class="cil-caret-right"></i> </a>
          </div>

          <div class="tab-pane fade" id="nav-tourism" role="tabpanel" aria-labelledby="nav-tourism-tab">
            <br>
            <h4>Tourism Page</h4>
            <hr>
            <p>
              Menyediakan ringkasan informasi tentang tempat pariwisata yang terdapat pada kota tertentu. Pada sistem ini pariwisata yang terdaftar
              hanyalah pariwisata yang berada di daerah Yogyakarta, Bali, dan Jakarta. Hal yang dapat dilakukan pada menu tab Tourism adalah sebagai berikut :
              <br>
            </p>
            <ul>
              <li>Admin dapat menambahkan data pariwisata berdasarkan masing - masing kota disekitar kota tersebut</li>
              <li>Admin dapat mengubah data informasi pariwisata sesuai dengan kebutuhan</li>
              <li>Admin dapat menghapus data pariwisata yang tidak diperlukan</li>
              <li>Admin dapat mengetahui lokasi pariwisata melalui location melalui Google Maps</li>
            </ul>
            <a type="button" class="btn btn-outline-info btn-md float-right" href="{{route('admin.tourism.index')}}">Go to Page <i class="cil-caret-right"></i> </a>
          </div>

          <div class="tab-pane fade" id="nav-city" role="tabpanel" aria-labelledby="nav-city-tab">
            <br>
            <h4>City Page</h4>
            <hr>
            <p>
              Menyediakan ringkasan informasi singkat tentang nama kota. Pada sistem ini kota yang terdaftar hanyalah kota Yogyakarta, Bali, dan Jakarta. 
              Tujuan nama kota ini adalah agar lebih mudah mencari nama pariwisata berdasarkan nama kota.
              Hal yang dapat dilakukan pada menu tab Tourism adalah sebagai berikut :
              <br>
            </p>
            <ul>
              <li>Admin dapat menambahkan data nama kota yang diinginkan</li>
              <li>Admin dapat mengubah data informasi kota sesuai dengan kebutuhan</li>
              <li>Admin dapat menghapus data kota yang tidak diperlukan</li>
              <li>Admin dapat mengetahui lokasi kota melalui location melalui Google Maps</li>
            </ul>
            <a type="button" class="btn btn-outline-info btn-md float-right" href="{{route('admin.city.index')}}">Go to Page <i class="cil-caret-right"></i> </a>
          </div>

          <div class="tab-pane fade" id="nav-promo" role="tabpanel" aria-labelledby="promo-tab">
            <br>
            <h4>Promo Page</h4>
            <hr>
            <p>
              Menyediakan ringkasan informasi tentang list promo yang ada pada merchant. Hal yang dapat dilakukan pada menu tab Promo yaitu hanya dapat melihat list
              promo yang tersedia.
            </p>
            <a type="button" class="btn btn-outline-info btn-md float-right" href="{{route('admin.promo.index')}}">Go to Page <i class="cil-caret-right"></i> </a>
          </div>
          <div class="tab-pane fade" id="nav-reward" role="tabpanel" aria-labelledby="reward-tab">
            <br>
            <h4>Reward Page</h4>
            <hr>
            <p>
              Menyediakan ringkasan informasi tentang list reward yang bisa didapatkan oleh guide. Reward ini dapat di tukarkan melalui point yang telah dikumpulkan oleh
              guide. Hal yang dapat dilakukan pada menu tab Reward adalah sebagai berikut :
            </p>
            <ul>
              <li>Admin dapat melihat list reward yang ada</li>
              <li>Admin dapat menambahkan reward yang diinginkan</li>
              <li>Admin dapat melihat detail reward yang tersedia</li>
              <li>Admin dapat menghapus reward jika tidak dibutuhkan</li>
              <li>Admin dapat mengubah data reward jika diperlukan</li>
              <li>Admin dapat melihat riwayat reward yang telah di reedem oleh guide</li>
            </ul>
            <a type="button" class="btn btn-outline-info btn-md float-right" href="{{route('admin.reward.index')}}">Go to Page <i class="cil-caret-right"></i> </a>
          </div>

          <div class="tab-pane fade" id="nav-transaction" role="tabpanel" aria-labelledby="transaction-tab">
            <br>
            <h4>Transaction Page</h4>
            <hr>
            <p>
              Menyediakan ringkasan informasi tentang perkembangan transaksi yang telah dilakukan perbulannya. Perkembangan transaksi ini ditunjukkan dengan sebuah
              grafik perbulannya. Selain itu disajikan data guide dan merchant yang melakukan transaksi dan menggunakan promo apa serta detail waktu saat melakukan transaksi
              tersebut.
            </p>
            <a type="button" class="btn btn-outline-info btn-md float-right" href="{{route('admin.transaction.index')}}">Go to Page <i class="cil-caret-right"></i> </a>
          </div>
          <div class="tab-pane fade" id="nav-report" role="tabpanel" aria-labelledby="report-tab">
            <br>
            <h4>Report Page</h4>
            <hr>
            <p>
              Menyediakan ringkasan informasi tentang perkembangan jumlah user yang telah terdaftar pada sistem perbulannya. Perkembangan jumlah user ini ditunjukkan dengan sebuah
              grafik perbulannya. Selain itu perkembangan transaksi juga tersedia pada halaman ini. Data perkembangan ini dapat di eksport menjadi sebuah file excel jika diperlukan. 
              Pada file tersebut, berisi lengkap tentang detail data yang dibutuhkan dan diringkas berdasarkan bulannya.
            </p>
            <a type="button" class="btn btn-outline-info btn-md float-right" href="{{route('admin.report.indexU')}}">Go to Page <i class="cil-caret-right"></i> </a>
          </div>
        </div>
      </div>
      <div class="card-footer">
      </div>
    </div>
    <!-- /.card-->
    <!-- /.row-->
    <div class="row">
      <div class="col-md-12">
        <div class="card">
          <div class="card-header">
            <h5> <strong> 5 Top Rank Guide User  </strong></h5>
          </div>
          <table class="table table-responsive-sm table-hover table-outline mb-0">
            <thead class="thead-light">
              <tr>
                <th class="text-center">
                  <svg class="c-icon">
                    <use xlink:href="node_modules/@coreui/icons/sprites/free.svg#cil-people"></use>
                  </svg>
                </th>
                <th class="col-md-2" style="width:40%;">Name Guide</th>
                <th style="text-align:center;width:20%;">Point</th>
                <th class="col-md-2" style="width:30%;">Transaction</th>
                <th class="text-center">Profile</th>
              </tr>
            </thead>
            <tbody>
              @php
                $no = 1;
              @endphp
              @foreach($rank as $data)
              <tr>
                <td class="text-center">
                  <div class="c-avatar"><img src="{{$data->detail->photo}}" onerror="this.onerror=null; this.src='{{asset('images/default.png')}}'"  class="avatar img-circle img-thumbnail" alt="avatar" ><span class="c-avatar-status bg-success"></span></div>
                </td>
                <td>
                  <div>{{$data->name}}</div>
                  <div class="small text-muted">Registered: {{$data->created_at}}</div>
                </td>
                <td class="text-center">
                  {{$data->points}}
                </td>
                <td>
                  <div class="clearfix">
                    <div class="float-left"><strong>{{$data->transactions_count}}</strong></div>
                  </div>
                  <div class="progress progress-xs">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100"></div>
                  </div>
                </td>
                <td class="text-center">
                  <a type="button" class="btn btn-success" href="{{route('admin.guide.show', $data->id)}}" id="{{ $data->id }}" target="_blank"><i class="nav-icon icon-info"></i></a>
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
              <!-- /.col-->
            </div>
          </div>
        </div>

@endsection
@push('scripts')
    
@endpush