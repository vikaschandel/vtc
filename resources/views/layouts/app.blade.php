<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="{{ url('assets/images/favicon-32x32.png') }}" type="image/png" />
	<!--plugins-->
	@yield("style")
	<link href="{{ url('assets/plugins/simplebar/css/simplebar.css') }}" rel="stylesheet" />
	<link href="{{ url('assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css') }}" rel="stylesheet" />
	<link href="{{ url('assets/plugins/metismenu/css/metisMenu.min.css') }}" rel="stylesheet" />
	<!-- loader-->
	<link href="{{ url('assets/css/pace.min.css') }}" rel="stylesheet" />
	<script src="{{ url('assets/js/pace.min.js') }}"></script>
	<!-- Bootstrap CSS -->
	<link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="{{ url('assets/css/app.css') }}" rel="stylesheet">
	<link href="{{ url('assets/css/icons.css') }}" rel="stylesheet">

    <!-- Theme Style CSS -->
    <link rel="stylesheet" href="{{ url('assets/css/dark-theme.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/semi-dark.css') }}" />
    <link rel="stylesheet" href="{{ url('assets/css/header-colors.css') }}" />
    <title>VTC</title>
    @laravelPWA
    <style>
        #google_translate_element{float:right;text-align:right;display:block}
        .goog-te-banner-frame.skiptranslate { display: none !important;} 
        body { top: 0px !important; }
        #goog-gt-tt{display: none !important; top: 0px !important; } 
        .goog-tooltip skiptranslate{display: none !important; top: 0px !important; } 
        .activity-root { display: hide !important;} 
        .status-message { display: hide !important;}
        .started-activity-container { display: hide !important;}  
        .goog-te-gadget-simple {
        border: 1px solid #ccc !important;
        padding: 5px !important;
        border-radius: 10px !important;
    }     
    </style>   
  
</head>

<body>
	<!--wrapper-->
	@role('Security Guards') 
	<div class="wrapper">
	@else	
	<div class="wrapper toggled">
     @endrole
		<!--start header -->
		@include("layouts.header")
		<!--end header -->
		<!--navigation-->
		@include("layouts.nav")
		<!--end navigation-->
		<!--start page wrapper -->
		@yield("wrapper")
		<!--end page wrapper -->
		<!--start overlay-->
		<div class="overlay toggle-icon"></div>
		<!--end overlay-->
		<!--Start Back To Top Button--> <a href="javaScript:;" class="back-to-top"><i class='bx bxs-up-arrow-alt'></i></a>
		<!--End Back To Top Button-->
		<footer class="page-footer">
			<p class="mb-0">Copyright © 2021. All right reserved.</p>
		</footer>
	</div>
	<!--end wrapper-->
    <!--start switcher-->
    
    <!--end switcher-->
	<!-- Bootstrap JS -->
    <script type="text/javascript">
    function googleTranslateElementInit() {
    new google.translate.TranslateElement({pageLanguage: 'en',includedLanguages: 'hi,en,pa,te', layout: google.translate.TranslateElement.InlineLayout.SIMPLE}, 'google_translate_element');
    }
	function mouseOver() {
    $('.wrapper').addClass('sidebar-hovered');
	$('.wrapper').removeClass('toggled');
    }

	function mouseOut() {
    $('.wrapper').removeClass('sidebar-hovered');
	$('.wrapper').addClass('toggled');
    }

   </script>

<script type="text/javascript" src="//translate.google.com/translate_a/element.js?cb=googleTranslateElementInit"></script>
	<script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
	<!--plugins-->
	<script src="{{ url('assets/js/jquery.min.js') }}"></script>
	<script src="{{ url('assets/plugins/simplebar/js/simplebar.min.js') }}"></script>
	<script src="{{ url('assets/plugins/metismenu/js/metisMenu.min.js') }}"></script>
	<script src="{{ url('assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js') }}"></script>
	<!--app JS-->
	<script src="{{ url('assets/js/app.js') }}"></script>
	@yield("script")
</body>

</html>