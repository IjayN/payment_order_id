<!DOCTYPE html>
<html lang="zxx">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<meta name="description" content="">
	<meta name="author" content="">
	<link rel="shortcut icon" href="/favicon.png" type="image/x-icon">
	<link rel="icon" href="/favicon.png" type="image/x-icon">
	<title>Sembe | Login</title>
	<!-- CSS -->
	<link rel="stylesheet" href="{{asset('assets/css/app2.css')}}">

	<style>
		.loader {
			position: fixed;
			left: 0;
			top: 0;
			width: 100%;
			height: 100%;
			background-color: #F5F8FA;
			z-index: 9998;
			text-align: center;
			}
		
		.plane-container {
			position: absolute;
			top: 50%;
			left: 50%;
			}
	</style>
</head>
<body class="light">
<!-- Pre loader -->
<div id="loader" class="loader">
	<div class="plane-container">
		<div class="preloader-wrapper small active">

		</div>
	</div>
</div>
<div class="cover-background"></div>
<div id="app">
	<main>
		<div id="primary" class="blue4 p-t-b-100 height-full responsive-phone">
			<div class="container">
				<div class="row">
					<div class="col-lg-6">
						<img src="{{asset('assets/img/basic/sembe-kadogo.png')}}" alt="">
					</div>
					<div class="col-lg-6 p-t-100">
						<div class="text-white">
							<h1 style="font-weight: 600">Welcome Back</h1>
							<p class="text-white">@include('flash::message')</p>
						</div>
						<form action="{{url('admin/login')}}" method="post">
							@csrf
							<div class="row">
								<div class="col-lg-6">
									<div class="form-group has-icon"><i class="icon-phone2"></i>
										<input type="tel" name="phone" class="form-control form-control-lg no-b"
										       placeholder="Phone Number" required>
										@if($errors->has('phone'))
											<p class="text-white">{{$errors->first('phone')}}</p>
										@endif
									</div>
								</div>
								<div class="col-lg-6">
									<div class="form-group has-icon"><i class="icon-user-secret"></i>
										<input name="password" type="password" class="form-control form-control-lg no-b"
										       placeholder="Password" required>
										@if($errors->has('password'))
											<p class="text-white">{{$errors->first('password')}}</p>
										@endif
									</div>
								</div>
								<div class="col-lg-12">
									<input type="submit" class="btn btn-success btn-lg btn-block" value="LOG IN">
								
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
		<!-- #primary -->
	</main>
	<!-- Right Sidebar -->
	<aside class="control-sidebar fixed white ">
		<div class="slimScroll">
			<div class="sidebar-header">
				<h4>Activity List</h4>
				<a href="#" data-toggle="control-sidebar" class="paper-nav-toggle  active"><i></i></a>
			</div>
			<div class="p-3">
				<div>
					<div class="my-3">
						<small>25% Complete</small>
						<div class="progress" style="height: 3px;">
							<div class="progress-bar bg-success" role="progressbar" style="width: 25%;"
							     aria-valuenow="25"
							     aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<div class="my-3">
						<small>45% Complete</small>
						<div class="progress" style="height: 3px;">
							<div class="progress-bar bg-info" role="progressbar" style="width: 45%;" aria-valuenow="45"
							     aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<div class="my-3">
						<small>60% Complete</small>
						`
						<div class="progress" style="height: 3px;">
							<div class="progress-bar bg-warning" role="progressbar" style="width: 60%;"
							     aria-valuenow="60"
							     aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<div class="my-3">
						<small>75% Complete</small>
						<div class="progress" style="height: 3px;">
							<div class="progress-bar bg-danger" role="progressbar" style="width: 75%;"
							     aria-valuenow="75"
							     aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
					<div class="my-3">
						<small>100% Complete</small>
						<div class="progress" style="height: 3px;">
							<div class="progress-bar" role="progressbar" style="width: 100%;" aria-valuenow="100"
							     aria-valuemin="0" aria-valuemax="100"></div>
						</div>
					</div>
				</div>
			</div>
			<div class="p-3 bg-primary text-white">
				<div class="row">
					<div class="col-md-6">
						<h5 class="font-weight-normal s-14">Sodium</h5>
						<span class="font-weight-lighter text-primary">Spark Bar</span>
						<div> Oxygen
							<span class="text-primary">
                                                    <i class="icon icon-arrow_downward"></i> 67%</span>
						</div>
					</div>
					<div class="col-md-6">
						<canvas width="100" height="70" data-chart="spark" data-chart-type="bar"
						        data-dataset="[[28,68,41,43,96,45,100,28,68,41,43,96,45,100,28,68,41,43,96,45,100,28,68,41,43,96,45,100]]"
						        data-labels="['a','b','c','d','e','f','g','h','i','j','k','l','m','n','a','b','c','d','e','f','g','h','i','j','k','l','m','n']">
						</canvas>
					</div>
				</div>
			</div>
			<div class="table-responsive">
				<table id="recent-orders" class="table table-hover mb-0 ps-container ps-theme-default">
					<tbody>
					<tr>
						<td>
							<a href="#">INV-281281</a>
						</td>
						<td>
							<span class="badge badge-success">Paid</span>
						</td>
						<td>$ 1228.28</td>
					</tr>
					<tr>
						<td>
							<a href="#">INV-01112</a>
						</td>
						<td>
							<span class="badge badge-warning">Overdue</span>
						</td>
						<td>$ 5685.28</td>
					</tr>
					<tr>
						<td>
							<a href="#">INV-281012</a>
						</td>
						<td>
							<span class="badge badge-success">Paid</span>
						</td>
						<td>$ 152.28</td>
					</tr>
					<tr>
						<td>
							<a href="#">INV-01112</a>
						</td>
						<td>
							<span class="badge badge-warning">Overdue</span>
						</td>
						<td>$ 5685.28</td>
					</tr>
					<tr>
						<td>
							<a href="#">INV-281012</a>
						</td>
						<td>
							<span class="badge badge-success">Paid</span>
						</td>
						<td>$ 152.28</td>
					</tr>
					</tbody>
				</table>
			</div>
			<div class="sidebar-header">
				<h4>Activity</h4>
				<a href="#" data-toggle="control-sidebar" class="paper-nav-toggle  active"><i></i></a>
			</div>
			<div class="p-4">
				<div class="activity-item activity-primary">
					<div class="activity-content">
						<small class="text-muted">
							<i class="icon icon-user position-left"></i> 5 mins ago
						</small>
						<p>Lorem ipsum dolor sit amet conse ctetur which ascing elit users.</p>
					</div>
				</div>
				<div class="activity-item activity-danger">
					<div class="activity-content">
						<small class="text-muted">
							<i class="icon icon-user position-left"></i> 8 mins ago
						</small>
						<p>Lorem ipsum dolor sit ametcon the sectetur that ascing elit users.</p>
					</div>
				</div>
				<div class="activity-item activity-success">
					<div class="activity-content">
						<small class="text-muted">
							<i class="icon icon-user position-left"></i> 10 mins ago
						</small>
						<p>Lorem ipsum dolor sit amet cons the ecte tur and adip ascing elit users.</p>
					</div>
				</div>
				<div class="activity-item activity-warning">
					<div class="activity-content">
						<small class="text-muted">
							<i class="icon icon-user position-left"></i> 12 mins ago
						</small>
						<p>Lorem ipsum dolor sit amet consec tetur adip ascing elit users.</p>
					</div>
				</div>
			</div>
		</div>
	</aside>
	<!-- /.right-sidebar -->
	<!-- Add the sidebar's background. This div must be placed
			 immediately after the control sidebar -->
	<div class="control-sidebar-bg shadow white fixed"></div>
</div>
<!--/#app -->
<script src="assets/js/app.js"></script>
</body>
</html>