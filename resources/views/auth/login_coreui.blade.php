@extends('auth.auth')

@section('content')
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
        <form class="login100-form validate-form" action="{{ route('login') }}" method="POST">
          @csrf
					<span class="login100-form-title p-b-43">
						Login Travel Guide and Reward
          </span>
          @if($errors->any())
            <span class="invalid-feedback d-block mb-2" role="alert">
              @foreach ($errors->all() as $error)
                  <strong> {{$error}}</strong>
              @endforeach
            </span>
          @endif
					<div class="wrap-input100 validate-input" data-validate = "Valid email is required: ex@abc.xyz">
						<input class="input100 @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus type="email">
            <span class="focus-input100"></span>
            <span class="label-input100">Email</span>    
					</div>
				
					<div class="wrap-input100 validate-input" data-validate="Password is required">
            <input class="input100 @error('password') is-invalid @enderror" value="{{ old('password') }}" name="password" required autocomplete="current-password" type="password">  
						<span class="focus-input100"></span>
						<span class="label-input100">Password</span>
					</div>

					<div class="flex-sb-m w-full p-t-3 p-b-32">
						<div class="contact100-form-checkbox">
              <input class="input-checkbox100" type="checkbox" name="remember-me" id="ckb1" {{ old('remember') ? 'checked' : '' }}>
							<label class="label-checkbox100" for="ckb1">
								Remember me
							</label>
						</div>

            @if (Route::has('password.request'))
						<div>
							<a href="{{route('password.request')}}" class="txt1">
								Forgot Password?
							</a>
            </div>
            @endif
					</div>
					<div class="container-login100-form-btn">
						<button class="login100-form-btn">
							Login
						</button>
					</div>
				</form>

				<div class="login100-more" style="background-image: url('images/bg-02.png'); background-color: #2db3d0;">
				</div>
			</div>
		</div>
	</div>
  @endsection