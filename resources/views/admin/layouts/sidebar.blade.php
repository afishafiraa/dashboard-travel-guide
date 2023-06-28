<div class="c-sidebar c-sidebar-dark c-sidebar-fixed c-sidebar-lg-show" id="sidebar">
  <div class="c-sidebar-brand"><img class="c-sidebar-brand-full" src="{{asset('images/logo.png')}}" width="100" height="46" alt="TravelGuide Logo"><img class="c-sidebar-brand-minimized" src="{{asset('images/logo-s.png')}}" width="40" height="40" alt="TravelGuide Logo"></div>
  <ul class="c-sidebar-nav">
    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link c-active" href="/admin">
        <svg class="c-sidebar-nav-icon">
          <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-home"></use>
        </svg> Home <span class="badge badge-info">NEW</span></a></li>
    <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
        <svg class="c-sidebar-nav-icon">
          <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-user"></use>
        </svg> User</a>
      <ul class="c-sidebar-nav-dropdown-items">
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.guide.index')}}"><span class="c-sidebar-nav-icon"></span> Guide</a></li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.merchant.index')}}"><span class="c-sidebar-nav-icon"></span>Merchant</a></li>
      </ul>
    </li>
    <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
        <svg class="c-sidebar-nav-icon">
          <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-location-pin"></use>
        </svg> Merchant</a>
      <ul class="c-sidebar-nav-dropdown-items">
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.places.storeindex')}}"><span class="c-sidebar-nav-icon"></span> Store </a></li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.places.hotelindex')}}"><span class="c-sidebar-nav-icon"></span>Hotel</a></li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.places.restaurantindex')}}"><span class="c-sidebar-nav-icon"></span>Restaurant</a></li>
      </ul>
    </li>
    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.tourism.index')}}">
      <svg class="c-sidebar-nav-icon">
        <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-map"></use>
      </svg> Tourism </a></li>
    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.city.index')}}">
      <svg class="c-sidebar-nav-icon">
        <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-bank"></use>
      </svg> City </a></li>
    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.promo.index')}}">
        <svg class="c-sidebar-nav-icon">
          <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-tags"></use>
        </svg> Promo </a>
    </li>
    <li class="c-sidebar-nav-dropdown"><a class="c-sidebar-nav-dropdown-toggle">
        <svg class="c-sidebar-nav-icon">
          <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-gift"></use>
        </svg> Reward </a>
      <ul class="c-sidebar-nav-dropdown-items">
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.reward.index')}}"> List Reward</a></li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.reward.reedem.index')}}"> Reward Reedems</a></li>
      </ul>
    </li>
    <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.transaction.index')}}">
      <svg class="c-sidebar-nav-icon">
        <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-loop-circular"></use>
      </svg> Transaction </a></li>
    <li class="c-sidebar-nav-item c-sidebar-nav-dropdown"><a class="c-sidebar-nav-link c-sidebar-nav-dropdown-toggle">
        <svg class="c-sidebar-nav-icon">
          <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-notes"></use>
        </svg> Report Usage </a>
        <ul class="c-sidebar-nav-dropdown-items">
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.report.indexU')}}"> User </a></li>
          <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.report.indexT')}}"> Transaction </span></a></li>
        </ul>
      <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="{{route('admin.notification.index')}}">
      <svg class="c-sidebar-nav-icon">
        <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-speech"></use>
      </svg> Notification </a></li>
   <!-- <ul class="c-sidebar-nav-dropdown-items">
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="login.html" target="_top">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-account-logout"></use>
            </svg> Login</a></li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="register.html" target="_top">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-account-logout"></use>
            </svg> Register</a></li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="404.html" target="_top">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-bug"></use>
            </svg> Error 404</a></li>
        <li class="c-sidebar-nav-item"><a class="c-sidebar-nav-link" href="500.html" target="_top">
            <svg class="c-sidebar-nav-icon">
              <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-bug"></use>
            </svg> Error 500</a></li>
      </ul> -->
    </li>
  </ul>
  <button class="c-sidebar-minimizer c-class-toggler" type="button" data-target="_parent" data-class="c-sidebar-minimized"></button>
</div>