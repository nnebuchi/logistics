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
		<title>Dinma - Health Care App</title>
		<link rel="shortcut icon" type="image/png" href="{{asset('assets/images/logos/favicon.png')}}" />
		<link rel="stylesheet" href="{{asset('assets/libs/magnificpopup/magnific-popup.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/libs/sweetalert2/sweetalert2.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/css/admin/main.css')}}" />
		<link rel="stylesheet" href="{{asset('assets/css/admin/dashboard.css')}}" />
		<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
		<?php date_default_timezone_set("Africa/Lagos"); ?>
	</head>
	<body>
		<!--  Body Wrapper -->
		<div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
			data-sidebar-position="fixed" data-header-position="fixed">
			<!-- Sidebar Start -->
			<aside class="left-sidebar">
				<!-- Sidebar scroll-->
				<div>
					<div class="brand-logo d-flex align-items-center justify-content-between">
						<a href="{{url('/')}}" class="text-nowrap logo-img">
							<img src="{{asset('assets/images/logos/ziga-blue.png')}}" width="180" alt="" />
						</a>
						<div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
							<i class="ti ti-x fs-8"></i>
						</div>
					</div>
					<!-- Sidebar navigation-->
					<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
						<ul id="sidebarnav">
							<li class="nav-small-cap">
								<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
								<span class="hide-menu">Home</span>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/')}}" aria-expanded="false">
									<span>
										<img class="" src="{{asset('assets/images/icons/dashboard.svg')}}" />
									</span>
									<span class="hide-menu">Dashboard</span>
								</a>
							</li>
							<li class="nav-small-cap">
								<i class="ti ti-dots nav-small-cap-icon fs-4"></i>
								<span class="hide-menu">UI COMPONENTS</span>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/users')}}" aria-expanded="false">
									<span>
										<img class="" src="{{asset('assets/images/icons/user.svg')}}" />
									</span>
									<span class="hide-menu">Customers</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/doctors')}}" aria-expanded="false">
									<span>
										<img class="" src="{{asset('assets/images/icons/cross.svg')}}" />
									</span>
									<span class="hide-menu">Shipping</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/bookings')}}" aria-expanded="false">
									<span>
										<img class="" src="{{asset('assets/images/icons/calendar-clock.svg')}}" />
									</span>
									<span class="hide-menu">Rates</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/admin/transactions')}}" aria-expanded="false">
									<span>
										<img class="" src="{{asset('assets/images/icons/wallet.svg')}}" />
									</span>
									<span class="hide-menu">Transactions</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/plans')}}" aria-expanded="false">
									<span>
										<img class="" src="{{asset('assets/images/icons/orders.svg')}}" />
									</span>
									<span class="hide-menu">Users</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/subadmins')}}" aria-expanded="false">
									<span>
										<img class="" src="{{asset('assets/images/icons/settings.svg')}}" />
									</span>
									<span class="hide-menu">Subadmins</span>
								</a>
							</li>
							<li class="sidebar-item">
								<a class="sidebar-link" href="{{url('/logout')}}" aria-expanded="false">
									<span>
										<img class="" src="{{asset('assets/images/icons/logout.svg')}}" />
									</span>
									<span class="hide-menu">Logout</span>
								</a>
							</li>
						</ul>
						<!--<div class="unlimited-access hide-menu bg-light-primary position-relative mb-7 mt-5 rounded">-->
						<!--	<div class="d-flex">-->
						<!--		<div class="unlimited-access-title me-3">-->
						<!--			<h6 class="fw-semibold fs-4 mb-6 text-dark w-85">Upgrade to pro</h6>-->
						<!--			<a href="https://adminmart.com/product/modernize-bootstrap-5-admin-template/" target="_blank" class="btn btn-primary fs-2 fw-semibold lh-sm">Buy Pro</a>-->
						<!--		</div>-->
						<!--		<div class="unlimited-access-img">-->
						<!--			<img src="{{asset('assets/images/backgrounds/rocket.png')}}" alt="" class="img-fluid">-->
						<!--		</div>-->
						<!--	</div>-->
						<!--</div>-->
						
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
							<!--<li class="nav-item dropdown">-->
							<!--	<a class="nav-link nav-icon-hover dropdown-toggle" href="javascript:void(0)"   id="drop-notify" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
							<!--		<i class="ti ti-bell-ringing"></i>-->
							<!--		<div class="notification bg-primary rounded-circle"></div>-->
							<!--	</a>-->
							<!--	<div class="dropdown-menu" aria-labelledby="drop-notify">-->
							<!--		<button class="dropdown-item" type="button">Action</button>-->
							<!--		<button class="dropdown-item" type="button">Another action</button>-->
							<!--		<button class="dropdown-item" type="button">Osemeilu Itua just subscribed for a plan</button>-->
							<!--	</div>-->
							<!--</li>-->
						</ul>
						<div class="navbar-collapse justify-content-end px-0" id="navbarNav">
							<ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
								<li class="nav-item dropdown">
									<a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
										aria-expanded="false">
										<img src="{{asset('assets/images/profile/user-1.jpg')}}" alt="" width="35" height="35" class="rounded-circle">
									</a>
									<div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
										<div class="message-body">
											<a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
												<i class="ti ti-user fs-6"></i>
												<p class="mb-0 fs-3">My Profile</p>
											</a>
											<a href="javascript:void(0)" class="d-flex align-items-center gap-2 dropdown-item">
												<i class="ti ti-mail fs-6"></i>
												<p class="mb-0 fs-3">My Account</p>
											</a>
											<a href="{{url('/subadmin')}}" class="d-flex align-items-center gap-2 dropdown-item">
												<i class="ti ti-mail fs-6"></i>
												<p class="mb-0 fs-3">Add Subadmin</p>
											</a>
											<button 
											class="d-flex align-items-center gap-2 dropdown-item"
											type="button" data-toggle="modal" data-target="#changePasswordModal">
												<i class="ti ti-list-check fs-6"></i>
												<p class="mb-0 fs-3">Change Password</p>
											</button>
											<a href="{{url('/logout')}}" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</nav>
				</header>
				<!--  Header End -->
			
		