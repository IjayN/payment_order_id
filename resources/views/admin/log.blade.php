@extends('layouts.admin')
@section('content')
	<div class="container-fluid animatedParent animateOnce">
		<div class="tab-content my-3" id="v-pills-tabContent">
			<div class="tab-pane animated fadeInUpShort show active" id="v-pills-all" role="tabpanel"
			     aria-labelledby="v-pills-all-tab">
				<div class="row my-3">
					<div class="col-md-12">
						<br>
						
						@include('flash::message')
						
						<br>
						<div class="card r-0 shadow">
							<div class="table-responsive">
								<form>
									<table class="table table-striped table-hover r-0">
										<thead>
										<tr class="no-b">
											<th>Date</th>
											<th>Type</th>
											<th>Info</th>
											<th></th>
										</tr>
										</thead>
										
										<tbody>
										@forelse($logs as $log)
											<tr>
												<td>
													{{date('M D, Y H:i:s', strtotime($log->created_at))}}
												</td>
												
												<td>{{$log->type}}</td>
												<td>{{$log->info}}</td>
												
											</tr>
										@empty
											<tr>
												<td>System Log empty</td>
											</tr>
										@endforelse
										</tbody>
									</table>
								</form>
							</div>
						</div>
					
					</div>
				</div>
			
			</div>
			<div class="tab-pane animated fadeInUpShort" id="v-pills-buyers" role="tabpanel"
			     aria-labelledby="v-pills-buyers-tab">
				<div class="row">
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u1.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u2.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u4.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u5.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u6.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u7.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u8.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u9.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u9.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u10.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u11.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
					<div class="col-md-3 my-3">
						<div class="card no-b">
							<div class="card-body text-center p-5">
								<div class="avatar avatar-xl mb-3">
									<img src="assets/img/dummy/u12.png" alt="User Image">
								</div>
								<div>
									<h6 class="p-t-10">Alexander Pierce</h6>
									alexander@paper.com
								</div>
								<a href="#" class="btn btn-success btn-sm mt-3">View Profile</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="tab-pane animated fadeInUpShort" id="v-pills-sellers" role="tabpanel"
			     aria-labelledby="v-pills-sellers-tab">
				<div class="row">
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-a avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Alexander Pierce</strong>
									</div>
									<small> alexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-c avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u1.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u4.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u1.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u4.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-a avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Alexander Pierce</strong>
									</div>
									<small> alexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-c avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-a avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Alexander Pierce</strong>
									</div>
									<small> alexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-c avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u1.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u4.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u1.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u4.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-a avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Alexander Pierce</strong>
									</div>
									<small> alexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-c avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-a avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Alexander Pierce</strong>
									</div>
									<small> alexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-c avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u1.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u4.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u1.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u4.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-a avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Alexander Pierce</strong>
									</div>
									<small> alexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-c avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-a avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Alexander Pierce</strong>
									</div>
									<small> alexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-c avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u1.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u4.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u1.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<img src="assets/img/dummy/u4.png" alt="User Image">
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-a avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Alexander Pierce</strong>
									</div>
									<small> alexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-3 mb-3">
						<div class="card no-b p-3">
							<div>
								<div class="image mr-3 avatar-lg float-left">
									<span class="avatar-letter avatar-letter-c avatar-lg  circle"></span>
								</div>
								<div class="mt-1">
									<div>
										<strong>Clexander Pierce</strong>
									</div>
									<small>clexander@paper.com</small>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection