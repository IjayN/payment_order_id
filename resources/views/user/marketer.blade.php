@extends('layouts.admin')
@section('content')
	<style>
		.image-wrapper {
			padding: 10px;
			}
	</style>
	<div class="container-fluid  my-3">
		@include('flash::message')
		<div class="row">
			<div class="col-md-6">
				<div class="card ">
					<div class="card-header white">
						<i class="icon-user blue-text"></i>
						<strong style="font-size: 16px; font-weight: 600"> &nbsp; {{$user->name}} Details </strong>
					</div>
					<div class="card-body p-0 bg-light slimScroll" data-height="300">
						<div class="image-wrapper">
							<img class="img-border img-100" src="{{asset($user->avatar)}}">
						</div>
						<br>
						<h6> &nbsp; &nbsp; Name: &nbsp; &nbsp; &nbsp; &nbsp; <a style="text-decoration: underline"
						                                                        href="{{url('/admin/user/'.$user->id)}}">{{$user->name}}</a>
						</h6>
						<br>
						<h6> &nbsp; &nbsp; Contact: &nbsp; &nbsp; &nbsp; &nbsp; {{$user->phone}}</h6>
						<br>
						<h6> &nbsp; &nbsp; Date Registered: &nbsp; &nbsp; &nbsp;
							&nbsp; {{date('M, d Y', strtotime($user->created_at))}}</h6>
						
						<p style=" font-weight: 600; padding: 10px; margin-top: 10px">
							<a style="text-decoration: underline;" href="{{url('admin/profile/'.$user->id)}}">Edit Details</a>
						</p>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				@if($user->businesses->count() > 1)
				<div class="card">
					<div class="card-header white">
						<i class="icon-briefcase blue-text"></i>
						<strong style="font-size: 16px; font-weight: 600"> &nbsp; Businesses
							( {{$user->businesses->count()}} )</strong>
					</div>
					<div class="card-body pt-0 bg-light slimScroll" data-height="400">
						@foreach($user->businesses as $business)
							<ul class="list-unstyled">
								<li class="pt-3 pb-3 bg-light sticky">
									<strong style="font-weight: 600; font-size: 15px">{{$business->name}}</strong>
								</li>
								<li class="my-1">
									<div class="card no-b p-3">
										<div class="">
											<div>
												<div>
													<strong><i class="icon icon-map-marker"></i> Location: &nbsp;&nbsp;&nbsp;
														&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <span
																style="font-weight: 600">{{$business->location_name}}</span>
													</strong>
												</div>
											</div>
										</div>
									</div>
								</li>
								<li class="my-1">
									<div class="card no-b p-3">
										<div class="">
											<div>
												<div>
													<strong><i class="icon icon-phone"></i> Contact: &nbsp;&nbsp;&nbsp;&nbsp;
														&nbsp;&nbsp; &nbsp;&nbsp; <span
																style="font-weight: 600">{{$business->contact}} </span></strong>
												</div>
											</div>
										</div>
									</div>
								</li>
								<li class="my-1">
									<div class="card no-b p-3">
										<div class="">
											<div>
												<div>
													<strong><i class="icon icon-cart-plus"></i> Total Orders: &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
														<span style="font-weight: 600">{{$business->order->count()}}</span>
														@if($business->order->count() > 0)
															&nbsp; &nbsp; <a style="text-decoration: underline"
															                 href="{{url('admin/business/orders/'.$business->id)}}">Show
																Orders</a> </strong>
													@endif
												</div>
											</div>
										</div>
									</div>
								</li>
							</ul>
						@endforeach
					</div>
				</div>
				@endif
					<div class="card ">
						<div class="card-header white">
							<strong> Accounts Created </strong>
						</div>
						<div class="card-body p-0 bg-light slimScroll" data-height="300">
							<div class="table-responsive">
								<table class="table table-hover">
									<!-- Table heading -->
									<tbody>
									<tr class="no-b">
										<th>Customer</th>
										<th>Contact</th>
										<th>Created On</th>
										
									</tr>
									@forelse($accounts as $account)
									<tr>
										
										<td>
											<a href="{{url('admin/user/'.$account->id)}}">{{$account->name}}</a>
										</td>
										<td>{{$account->phone}}</td>
										<!-- Status -->
										
										<!-- Sort -->
										<td>
											{{date('M d, Y H:i', strtotime($account->created_at))}}
										</td>
										<!-- Actions -->
										
									</tr>
									@empty
										@endforelse
									</tbody>
								</table>
							</div>
						</div>
					</div>
			</div>
		</div>
	</div>
@endsection