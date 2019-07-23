@extends('layouts.admin')
@section('content')
	<div class="container-fluid  my-3">
		@include('flash::message')
		<div class="row">
			
			<div class="col-md-6">
				<div class="card">
					<div class="card-header white">
						<strong style="font-size: 16px"> Order Details &nbsp; @if(!$order->assigned && !$order->canceled)<span class="badge badge-warning">Pending Assignment</span>@endif</strong>
					</div>
					<div class="card-body pt-0 bg-light slimScroll" data-height="600">
						<br>
						<h6>Business Name: &nbsp; &nbsp; &nbsp; &nbsp; <a style="text-decoration: underline"
						                                                  href="{{url('/admin/user/'.$order->business->user->id)}}">{{$order->business->name}}</a>
						</h6>
						<br>
						<h6>Business Location: &nbsp; &nbsp; &nbsp; &nbsp; {{$order->business->location_name}}</h6>
						<br>
						<h6>Customer Name: &nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a
									style="text-decoration: underline"
									href="{{url('/admin/user/'.$order->business->user->id)}}">{{$order->business->user->name}}</a>
						</h6>
						<br>
						<h6>Customer Contact: &nbsp; &nbsp; {{$order->business->user->phone}} </h6>
						<br>
						<h6>Items Ordered:&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							( {{\App\OrderItem::where('order_id', $order->id)->get()->count()}}
							) </h6>
						<br>
						<h6>Items Dispatched: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							( {{\App\OrderItem::where('order_id', $order->id)->where('dispatched', TRUE)->get()->count()}}
							) </h6>
						<br>
						<h6>Order Amount: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Ksh {{$order->amount}} </h6>
						<br>
						<h6>Date Ordered: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
							&nbsp; {{date('M, d Y H:m', strtotime($order->created_at))}} </h6>
						<br>
						
						@if($order->assigned)
							<hr/>
							<h6>Assigned To: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								<a style="text-decoration: underline"
								   href="{{url('/admin/users/driver/'.$order->asssigned->driver->id)}}">
									{{$order->asssigned->driver->name}} </a></h6>
							<br>
							<h6>Order Status &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								@if($order->canceled)
									<span class="badge badge-danger">Canceled</span>
								@elseif($order->delivered && $order->assigned && $order->confirmed)
									<span class="badge badge-success">Delivered</span>
								@elseif($order->delivered && $order->assigned && $order->confirmed == FALSE)
									<span class="badge badge-primary">Delivered, Pending Confirmation</span>
								@elseif($order->assigned)
									<span class="badge badge-primary">Assigned</span>
								@endif
							</h6>
							<br>
							@if($order->delivered)
								<h6>Delivered On: &nbsp; &nbsp; &nbsp; &nbsp; {{date('M, d Y H:m', strtotime(\App\Confirmation::where('order_id',$order->id)->where('driver_id', $order->asssigned->driver->id)->first()->created_at))}} </h6>
								@endif
						@endif
						<br>
						@if($order->canceled)
							<hr/>
							<h6>Order Status &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;
								@if($order->canceled)
									<span class="badge badge-danger">Canceled</span>
								@elseif($order->delivered && $order->assigned && $order->confirmed)
									<span class="badge badge-success">Delivered</span>
								@elseif($order->delivered && $order->assigned && $order->confirmed == FALSE)
									<span class="badge badge-primary">Delivered, Pending Confirmation</span>
								@elseif($order->assigned)
									<span class="badge badge-primary">Assigned</span>
								@endif
							</h6>
							<br>
						<h6>Cancelled By: &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a
									style="text-decoration: underline"
									href="{{url('/admin/user/'.$order->remark->user->id)}}">{{$order->remark->user->name}}</a></h6>
						<br>
						<h6>Reason for Cancelling Order</h6>
							<p style="color: #8c8c8c">{{$order->remark->reason }}</p>
							@endif
					</div>
					<div class="card-footer white">
						@if(!$order->canceled && !$order->delivered)
						<button type="button" class="btn btn-sm btn-danger float-left" data-toggle="modal" data-target="#exampleModalC">
							Cancel Order
						</button>
						@elseif($order->canceled)
							<button type="button" class="btn btn-sm btn-secondary float-left" data-toggle="modal" data-target="#exampleModalR">
								Revert Cancelled Order
							</button>
							@endif
						@if(!$order->assigned)
						<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
							Assign Order
						</button>
							@elseif($order->assigned && $order->delivered == FALSE && $order->canceled == FALSE)
							<button type="button" class="btn btn-sm btn-primary float-right" data-toggle="modal" data-target="#exampleModal">
								Reassign Order
							</button>
						@endif
						
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card ">
					<div class="card-header white">
						
						<strong style="font-size: 16px"> Order Items ( {{$items->count() }} )</strong>
					</div>
					<div class="card-body p-0 bg-light slimScroll" data-height="300">
						<div class="table-responsive">
							<table class="table table-hover">
								<!-- Table heading -->
								<tbody>
								<tr class="no-b">
									
									<th>Product Title</th>
									<th>Quantity</th>
									<th>Sub Total</th>
									<th>Action</th>
								</tr>
								@forelse($items as $item)
									<tr>
										<td>
											<a style="text-decoration: underline; font-weight: 600"
											   href="{{url('admin/product/'.$item->product->id)}}">{{$item->product->title}}</a>
										</td>
										<!-- Page size -->
										<td>{{$item->quantity}}</td>
										<!-- Status -->
										<td>
											Ksh {{$item->total}}
										</td>
										<!-- Sort -->
										<td>
											@if(!$item->dispatched)
												<a class="btn btn-secondary btn-xs"
												   href="{{url('/admin/dispatch/item/'.$item->id)}}">
													Dispatch
												</a>
											@else
												<a class="btn btn-danger btn-xs"
												   href="{{url('/admin/revert/item/'.$item->id)}}">
													Revert Dispatch
												</a>
											@endif
										</td>
									</tr>
								@empty
									<p>This order doesn't have any Items</p>
								@endforelse
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer white ">
						<button type="button" class="btn btn-sm btn-secondary float-right" data-toggle="modal" data-target="#exampleModalD">
							Dispatch All Products
						</button>
					</div>
				</div>
			</div>
			<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeld" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Select Driver </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="post" action="{{url('admin/assign/order/'.$order->id)}}">
							<div class="modal-body">
								@csrf
								<select class="select2" name="driver">
									@forelse($drivers as $driver)
										<option value="{{$driver->id}}">{{$driver->name}} => {{$driver->phone}}</option>
									@empty
										<option value="">No driver Available</option>
									@endforelse
								</select>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-primary">Save changes</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal fade" id="exampleModalR" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeldR" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Are you sure you want to revert this order ? </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						
						<div class="modal-body">
						
						
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<a href="{{url('admin/revert/order/'.$order->id)}}"  class="btn btn-danger">Yes</a>
						</div>
					
					</div>
				</div>
			</div>
			<div class="modal fade" id="exampleModalC" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeldC" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Are You sure you want to cancel this order ? </h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<form method="post" action="{{url('admin/cancel/order/'.$order->id)}}">
							<div class="modal-body">
								@csrf
								<div class="form-group">
									<label for="reason">Reason for canceling order</label>
									<textarea  rows="8" name="reason" class="form-control" required></textarea>
								</div>
								
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
								<button type="submit" class="btn btn-danger">Cancel Order</button>
							</div>
						</form>
					</div>
				</div>
			</div>
			<div class="modal fade" id="exampleModalD" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabeld" aria-hidden="true">
				<div class="modal-dialog modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							Are You sure you want to Dispatch All Items ?
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<a href="{{url('/admin/dispatch/items/'.$order->id)}}" class="btn btn-primary">Yes</a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection