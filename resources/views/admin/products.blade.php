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
								<h4 style="font-weight: 600">{{$message}} ->  Products</h4>
								<a href="{{url('new-product')}}" class="btn btn-primary">Add Product &nbsp; &nbsp;<i class="icon icon-plus"></i> </a>
							</div>
							<div class="col-md-4">
								<br>
								<select onchange="if (this.value) window.location.href=this.value" class="select2">
									<option value="/products">Select Products to View</option>
									<option value="/products">All Products ( {{$admin_products}} )</option>
									@forelse($categories as $category)
									<option value="/admin/category/products/{{$category->id}}">{{$category->name}} Products ( {{$category->product->count()}} )</option>
										@empty
										<option value="">No categories found</option>
									@endforelse
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
											<th>Title</th>
											<th>SKU</th>
											<th>Price</th>
											<th>Quantity</th>
											<th>Weight</th>
											<th>Category</th>
											<th>Status</th>
										</tr>
										</thead>
										
										<tbody>
										@forelse($products as $product)
											<tr>
												<td>
													&nbsp; &nbsp;{{$product->title}}
												</td>
												
												<td>{{$product->sku}}</td>
												<td>
													Ksh {{$product->price}}
												</td>
												<td>{{$product->qty}}</td>
												<td>{{$product->weight}} Kgs</td>
												<td>{{$product->category->name}}</td>
												<td>
													<span class="r-3 ">
														@if($product->available)
															<span class="badge badge-secondary">Available</span>
														@else
															<span class="badge badge-primary">Depleted</span>
														@endif
													</span>
												</td>
												<td>
													<a href="{{url('admin/product/'.$product->id)}}"
													   class="btn btn-primary btn-xs">View Product</a>
												</td>
											</tr>
										@empty
											<br>
											<p class="text-center" style="font-weight: 600"> No Products Available</p>
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