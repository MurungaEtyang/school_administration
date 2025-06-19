<!doctype html>
<html class="no-js" lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Portal | Login</title>
	<meta name="description" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Favicon -->
	<link rel="shortcut icon" type="image/x-icon" href="{{ asset('public/new_login/img/favicon.png') }}">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="{{ asset('public/new_login/css/bootstrap.min.css') }}">
	<!-- Fontawesome CSS -->
	<link rel="stylesheet" href="{{ asset('public/new_login/css/fontawesome-all.min.css') }}">
	<!-- Flaticon CSS -->
	<link rel="stylesheet" href="{{ asset('public/new_login/font/flaticon.css') }}">
	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{ asset('public/new_login/css/style.css') }}">
</head>

<body>
	<div id="preloader" class="preloader">
		<div class='inner'>
			<div class='line1'></div>
			<div class='line2'></div>
			<div class='line3'></div>
		</div>
	</div>

	<section class="fxt-template-animation fxt-template-layout26">
		<div class="starfield"></div>
		<div class="fxt-content">
			<div class="fxt-header">
				<a href="{{url('/')}}" class="fxt-logo"><img src="{{ asset('public/new_login/img/logo.png') }}" width="200" alt="Logo"></a>
			</div>

			<div class="fxt-form">
				<div class="fxt-transformY-50 fxt-transition-delay-1">
					<p>Login Details</p>
				</div>

				<form method="POST" action="{{ route('login') }}">
					@csrf

					<div class="form-group">
						<div class="fxt-transformY-50 fxt-transition-delay-2">
							<input type="email" id="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Enter Admission Number" required autofocus>
							@error('email')
								<small class="text-danger d-block mt-1">{{ $message }}</small>
							@enderror
						</div>
					</div>

					<div class="form-group">
						<div class="fxt-transformY-50 fxt-transition-delay-3">
							<input id="password" type="password" class="form-control" name="password" placeholder="Enter Password" required>
							<i toggle="#password" class="fa fa-fw fa-eye toggle-password field-icon"></i>
							@error('password')
								<small class="text-danger d-block mt-1">{{ $message }}</small>
							@enderror
						</div>
					</div>

					<div class="form-group">
						<div class="fxt-transformY-50 fxt-transition-delay-4">
							<div class="fxt-checkbox-area">
								<div class="checkbox">
									<input id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
									<label for="remember">Keep me logged in</label>
								</div>
									<a href="{{ route('recoveryPassord') }}" id='forget'>Forgot Password</a>
							</div>
						</div>
					</div>

					<div class="form-group text-center">
						<div class="fxt-transformY-50 fxt-transition-delay-5">
							<button type="submit" class="fxt-btn-fill">Log in</button>
						</div>
					</div>
				</form>
			</div>

			<div class="fxt-style-line">
				<div class="fxt-transformY-50 fxt-transition-delay-6">
					<h3>Spectrum Film School</h3>
				</div>
			</div>
		</div>
	</section>

	<!-- Scripts -->
	<script src="{{ asset('public/new_login/js/jquery-3.5.0.min.js') }}"></script>
	<script src="{{ asset('public/new_login/js/bootstrap.min.js') }}"></script>
	<script src="{{ asset('public/new_login/js/imagesloaded.pkgd.min.js') }}"></script>
	<script src="{{ asset('public/new_login/js/starfield.js') }}"></script>
	<script src="{{ asset('public/new_login/js/validator.min.js') }}"></script>
	<script src="{{ asset('public/new_login/js/main.js') }}"></script>

</body>

</html>