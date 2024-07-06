<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<base href="{{url('')}}">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
		<meta name="csrf-token" content="{{csrf_token()}}">
		<meta name="base-url" content="{{url('')}}">

		<meta name="theme-color" content="" />
  		<meta name="apple-mobile-web-app-status-bar-style" content="" />
		<title>Ziga-Afrika Logistics</title>
		<link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/favicon.png')}}" />
		<link rel="stylesheet" href="{{asset('assets/libs/magnificpopup/magnific-popup.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/sweetalert2.css')}}" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
		<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/css/main.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/css/dashboard.css')}}" />
		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
		<?php date_default_timezone_set("Africa/Lagos"); ?>
		<script>
			var url = "{{url('/')}}";
		</script>
	</head>
	<body>
		<!--  Body Wrapper -->
		<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
			data-sidebar-position="fixed" data-header-position="fixed">
			<!-- Sidebar Start -->
			<aside class="left-sidebar">
				<!-- Sidebar scroll-->
				<div style="background-image: linear-gradient(to bottom, #4F659C, #233E83);">
					<div class="brand-logo d-flex align-items-center justify-content-between">
						<a href="{{url('/admin')}}" class="text-nowrap logo-img">
							<img src="{{asset('assets/images/logos/ziga-blue2.svg')}}" width="180" alt="" />
						</a>
						<div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
							<i class="ti ti-x fs-8"></i>
						</div>
					</div>
					<!-- Sidebar navigation-->
					<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
						<ul id="sidebarnav">
							
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/admin/')}}" aria-expanded="false">
									<span>
										<img class="" src="{{asset('assets/images/sidebar/dashboard.svg')}}" width="20" />
									</span>
									<span class="hide-menu">Dashboard</span>
								</a>
							</li>
							
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/admin/users')}}" aria-expanded="false">
									<span>
										<img width="20" style="" src="{{asset('assets/images/sidebar/users.png')}}" />
									</span>
									<span class="hide-menu">Customers</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/admin/transactions')}}" aria-expanded="false">
									<span>
										<img width="20" class="" src="{{asset('assets/images/sidebar/transactions.png')}}" />
									</span>
									<span class="hide-menu">Transactions</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/admin/shippings')}}" aria-expanded="false">
									<span>
										<img width="20" class="" src="{{asset('assets/images/sidebar/shipping.svg')}}" />
									</span>
									<span class="hide-menu">Shippings</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/admin/admins')}}" aria-expanded="false">
									<span>
										<img width="20" class="" src="{{asset('assets/images/sidebar/admins.png')}}" />
									</span>
									<span class="hide-menu">Subadmins</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/admin/accounts')}}" aria-expanded="false">
									<span>
										<img width="20" class="" src="{{asset('assets/images/sidebar/accounts.png')}}" />
									</span>
									<span class="hide-menu">Accounts</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/admin/logout')}}" aria-expanded="false">
									<span>
										<img width="20" class="" src="{{asset('assets/images/sidebar/logout.png')}}" />
									</span>
									<span class="hide-menu">Logout</span>
								</a>
							</li>
						</ul>
						<div class="unlimited-access hide-menu mb-7 mt-5">
							<div class="">
								<h6 class="fs-2 text-center text-white">Copyright &copy; <script>document.write(new Date().getFullYear());</script></h6>
								<h6 class="fs-2 text-center text-white">{{env('APP_NAME')}} All Rights Reserved</h6>
							</div>
						</div>
						
					</nav>
					<!-- End Sidebar navigation -->
				</div>
				<!-- End Sidebar scroll-->
			</aside>

			
			<!--  Sidebar End -->
			<!--  Main wrapper -->
			<div class="body-wrapper">
				<!--  Header Start -->
				<header class="app-header">
					<nav class="navbar navbar-expand-lg navbar-light">
						<ul class="navbar-nav">
							<li class="nav-item d-block d-xl-none">
								<a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
									<i class="ti ti-menu-2"></i>
								</a>
							</li>
							<li class="nav-item">
								<a class="nav-link nav-icon-hover" href="javascript:void(0)">
									<i class="ti ti-bell-ringing"></i>
									<div class="notification bg-primary rounded-circle"></div>
								</a>
							</li>
						</ul>
						<div class="d-flex align-items-center justify-content-between w-100">
							<h5 class="m-0 welcome-text">Welcome <?=$user->firstname?>!👋</h5>
							<div class="d-flex">
								<div class="d-flex align-items-center">
									<img src="{{asset('assets/images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle mr-2">
									<div class="d-flex flex-column justify-content-center p-0 user-details">
										<h6 class="m-0 p-0 mb-1"><?=$user->firstname." ".$user->lastname?></h6>
										<p class="m-0 p-0"><?=$user->email?></p>
									</div>
								</div>
							</div>
						
					</nav>
				</header>
			
		