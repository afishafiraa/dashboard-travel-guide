<header class="c-header c-header-light c-header-fixed">
  <button class="c-header-toggler c-class-toggler d-lg-none mr-auto" type="button" data-target="#sidebar" data-class="c-sidebar-show"><span class="c-header-toggler-icon"></span></button><a class="c-header-brand d-sm-none" href="#"><img class="c-header-brand" src="{{asset('images/logo-s.png')}}" width="97" height="46" alt="CoreUI Logo"></a>
  <button class="c-header-toggler c-class-toggler ml-3 d-md-down-none" type="button" data-target="#sidebar" data-class="c-sidebar-lg-show" responsive="true"><span class="c-header-toggler-icon"></span></button>
  <ul class="c-header-nav ml-auto mr-4">
    <li class="c-header-nav-item dropdown"><a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
        <div class="c-avatar"><img class="c-avatar-img" src="{{ Auth::user()->detail->photo}}" onerror="this.onerror=null; this.src='{{asset('images/default.png')}}'" alt="avatar admin"></div>
      </a>
      <div class="dropdown-menu dropdown-menu-right pt-0">
        <div class="dropdown-divider"></div>
        <a class="dropdown-item" href="{{ route('admin.profile.index')}}">Profile</a> 
        <a class="dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
                          document.getElementById('logout-form').submit();">
            <svg class="c-icon mr-2">
              <use xlink:href="{{url('')}}/node_modules/@coreui/icons/sprites/free.svg#cil-account-logout"></use>
            </svg>
            {{ __('Logout') }}
        </a>

        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </div>
    </li>
  </ul>
</header>