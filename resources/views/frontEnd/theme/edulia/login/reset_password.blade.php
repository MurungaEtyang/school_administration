<!doctype html>
<html class="no-js" lang="">

<head>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<title>Reset Change | Request</title>
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
	<!-- Google Web Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet">
	<!-- Custom CSS -->
	<link rel="stylesheet" href="{{ asset('public/new_login/css/style.css') }}">
</head>
       <style>
           .btn-hover-outline {
               padding: 12px 24px;
               background-color: #008fd4;
               color: #fff;
               border-radius: 5px;
               text-decoration: none;
               border: 2px solid #008fd4;
               transition: all 0.3s ease;
               display: inline-block;
               text-align: center;
           }

           .btn-hover-outline:hover {
               background-color: transparent;
               color: #008fd4;
           }

           .btn-container {
               display: flex;
               justify-content: space-between;
               gap: 10px;
               flex-wrap: wrap;
           }

           @media (max-width: 768px) {
               .btn-container {
                   flex-direction: column;
                   align-items: stretch;
               }

               .btn-hover-outline {
                   width: 100%;
               }
           }
</style>
<body>
	<!--[if lt IE 8]>
        <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
    <![endif]-->
    <div id="preloader" class="preloader">
        <div class='inner'>
            <div class='line1'></div>
            <div class='line2'></div>
            <div class='line3'></div>
        </div>
    </div>
	<section class="fxt-template-animation fxt-template-layout26">
		<!-- Animation Start Here -->
		<div class="starfield"></div>
		<!-- Animation End Here -->
		<div class="fxt-content">
			<div class="fxt-header">
				<a href="{{url('/')}}" class="fxt-logo"><img src="{{ asset('public/new_login/img/logo.png') }}" width="200"  alt="Logo"></a>
			</div>
			<div class="fxt-form">
				<div class="fxt-transformY-50 fxt-transition-delay-1">
					<p>Request Support Team To Reset Your Password</p>
				</div>
                <div class="form-group">
                    <div class="fxt-transformY-50 fxt-transition-delay-3 btn-container">
                        <a href="mailto:support@spectrumfilmschool.com" class="fxt-btn-fill btn-hover-outline">Email Support Team</a>
                        <a href="{{url('/dashboard')}}" class="fxt-btn-fill btn-hover-outline">Back To Login</a>
                    </div>
                </div>
			</div>
			<div class="fxt-style-line">
				<div class="fxt-transformY-50 fxt-transition-delay-4">
					<h3>Spectrum Film School</h3>
				</div>
			</div>

			<div class="fxt-footer">
				<div class="fxt-transformY-50 fxt-transition-delay-10">
					<p>Call Support Team Immediately?<a href="tel:+254798486790" class="switcher-text2 inline-text">Call Now</a></p>
				</div>
			</div>
		</div>
	</section>
	<!-- jquery-->
	<script src="{{ asset('public/new_login/js/jquery-3.5.0.min.js') }}"></script>
	<!-- Bootstrap js -->
	<script src="{{ asset('public/new_login/js/bootstrap.min.js') }}"></script>
	<!-- Imagesloaded js -->
	<script src="{{ asset('public/new_login/js/imagesloaded.pkgd.min.js') }}"></script>
	<!-- Starfield js -->
	<script src="{{ asset('public/new_login/js/starfield.js') }}"></script>
	<!-- Validator js -->
	<script src="{{ asset('public/new_login/js/validator.min.js') }}"></script>
	<!-- Custom Js -->
	<script src="{{ asset('public/new_login/js/main.js') }}"></script>

</body>

</html>