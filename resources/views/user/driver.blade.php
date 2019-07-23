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
			@if($user->businesses->count() > 0)
			<div class="col-md-6">
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
			</div>
				@endif
			<div class="col-md-6">
				<div class="card ">
					<div class="card-header white">
						<strong> Assigned Orders </strong>
					</div>
					<div class="card-body p-0 bg-light slimScroll" data-height="300">
						<div class="table-responsive">
							<table class="table table-hover">
								<!-- Table heading -->
								<tbody>
								<tr class="no-b">
									<th>Order</th>
									<th>Customer</th>
									<th>Order Amount (Ksh)</th>
									<th>Ordered On</th>
									<th>Assigned On</th>
									<th>Status</th>
								</tr>
								@forelse($assigned as $assign)
									<tr>
										<td>
											<a style="text-decoration: underline; font-weight: 600" href="{{url('admin/order/'.$assign->order->id)}}">{{$assign->order->id}}</a>
										</td>
										<!-- Page size -->
										<td>
											<a style="text-decoration: underline; font-weight: 600" href="{{url('admin/user/'.$assign->business->user->id)}}">{{$assign->business->user->name}}</a>
										
										</td>
										<!-- Status -->
										<td>
											Ksh {{$assign->order->amount}}
										</td>
										<!-- Sort -->
										<td>
											{{date('M d, Y H:m', strtotime($assign->order->created_at))}}
										</td>
										<!-- Actions -->
										<td>
											{{date('M, d Y H:m', strtotime($assign->order->updated_at))}}
										</td>
										<td>
											@if($assign->order->canceled)
												<span class="badge badge-danger">Cancelled</span>
												@elseif($assign->order->delivered)
												<span class="badge badge-success">Delivered</span>
											@elseif($assign->order->assigned)
												<span class="badge badge-secondary">Pending Delivery</span>
											@endif
										</td>
									</tr>
									@empty
									&nbsp;<p>&nbsp; &nbsp;&nbsp; No orders have been assigned to this driver</p>
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