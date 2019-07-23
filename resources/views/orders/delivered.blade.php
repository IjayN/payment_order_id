@extends('layouts.admin')
@section('content')
	<div class="container-fluid animatedParent animateOnce">
		<div class="tab-content my-3" id="v-pills-tabContent">
			<div class="tab-pane animated fadeInUpShort show active" id="v-pills-all" role="tabpanel"
			     aria-labelledby="v-pills-all-tab">
				<div class="row my-3">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-8">
								<br>
								<h4 style="font-weight: 600">Delivered Orders</h4>
							</div>
							<div class="col-md-4">
								<br>
								<select onchange="if (this.value) window.location.href=this.value" class="select2">
									<option value="/admin/orders/delivered">Delivered Orders
										( {{$admin_orders_delivered}} )
									</option>
									<option value="/admin/orders">All Orders ( {{$admin_orders}} )</option>
									<option value="/admin/orders/pending">Pending Deliveries
										( {{$admin_orders_pending_delivery}} )
									</option>
									
									<option value="/admin/orders/canceled">Canceled Orders ( {{$admin_orders_canceled}}
										)
									</option>
								</select>
							</div>
						</div>
						
						@include('flash::message')
						<br>
						<br>
						<div class="card r-0 shadow">
							<div class="table-responsive">
								<form>
									<table class="table table-striped table-hover r-0">
										<thead>
										<tr class="no-b">
											<th>Customer</th>
											<th>Contact</th>
											<th>Business</th>
											<th>Order Items</th>
											<th>Amount</th>
											<th>Status</th>
										</tr>
										</thead>
										
										<tbody>
										@forelse($orders as $order)
											<tr>
												<td>
													<a style="text-decoration: underline; font-weight: 600"
													   href="{{url('admin/user/'.$order->business->user->id)}}">{{$order->business->user->name}}</a>
												</td>
												
												<td>{{$order->business->user->phone}}</td>
												<td>
													<a style="text-decoration: underline; font-weight: 600"
													   href="{{url('admin/user/'.$order->business->user->id)}}">{{$order->business->name}}</a>
												</td>
												<td><a style="text-decoration: underline; font-weight: 600"
												       href="{{url('admin/order/'. $order->id)}}">
														( {{\App\OrderItem::where('order_id', $order->id)->get()->count()}}
														)</a></td>
												<td>Ksh  {{$order->amount}}</td>
												<td>
													<span class="r-3 ">
														@if($order->canceled)
															<span class="badge badge-danger">Canceled</span>
														@elseif($order->delivered && $order->assigned && $order->confirmed)
															<span class="badge badge-success">Delivered</span>
														@elseif($order->delivered && $order->assigned && $order->confirmed == FALSE)
															<span class="badge badge-primary">Delivered, Pending Confirmation</span>
														@elseif($order->assigned)
															<span class="badge badge-primary">Assigned</span>
														@endif
													</span>
												</td>
												<td>
													<a href="{{url('admin/order/'.$order->id)}}"
													   class="btn btn-primary btn-xs">View Order</a>
												</td>
											</tr>
										@empty
											<p>No orders Available</p>
										@endforelse
										</tbody>
									</table>
								</form>
							</div>
						</div>
					
					</div>
				</div>
			
			</div>
		
		</div>
	</div>
@endsection