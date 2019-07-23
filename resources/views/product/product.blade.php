@extends('layouts.admin')
@section('content')
	<style>
		.image-wrapper{
			padding: 10px;
			}
	</style>
	<div class="container-fluid  my-3">
		@include('flash::message')
		<div class="row">
			<div class="col-md-6">
				<div class="card ">
					<div class="card-header white">
						<strong style="font-size: 16px; font-weight: 600">Product {{$product->sku}} Details</strong>
					</div>
					<div class="card-body p-0 bg-light slimScroll" data-height="500">
						<div class="image-wrapper">
							<img class="img-border img-150" src="{{asset($src)}}">
						</div>
						<br>
						<h6>&nbsp; &nbsp; Title: &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<strong>{{$product->title}}</strong></h6>
						<br>
						<h6>&nbsp; &nbsp; Price: &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;<strong> Ksh {{$product->price}}</strong></h6>
						<br>
						<h6>&nbsp; &nbsp; Quantity Available: &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; <strong>{{$product->qty}}</strong></h6>
						<br>
						<h6>&nbsp; &nbsp; Product Weight : &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp;&nbsp; &nbsp; <strong>{{$product->weight}} Kgs</strong></h6>
						<br>
						<h6>&nbsp; &nbsp; Status :&nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;
							@if($product->available)
								<span class="badge badge-secondary">Available</span>
							@else
								<span class="badge badge-primary">Depleted</span>
							@endif
						</h6>
						<br>
						<h6>&nbsp; &nbsp;Product Description</h6>
						<br>
						<p style="color: #8c8c8c; line-height: 2">&nbsp; &nbsp;{{$product->description}}</p>
					</div>
					<div class="card-footer white">
						<button type="button" class="btn btn-outline-primary" data-toggle="modal" data-target="#editProduct{{$product->id}}">
							Edit Product &nbsp; &nbsp;<i class="icon icon-edit"></i>
						</button>
						<button type="button" class="btn btn-outline-danger float-right" data-toggle="modal" data-target="#deleteProduct{{$product->id}}">
							Delete Product &nbsp; &nbsp; <i class="icon icon-trash-can"></i>
						</button>
					</div>
				</div>
			</div>
			<div class="col-md-6">
				<div class="card">
					<div class="card-header white">
						<strong style="font-size: 16px; font-weight: 600">Product Stats</strong>
					</div>
					<div class="card-body pt-0 bg-light slimScroll" data-height="200">
						<div class="d-flex justify-content-between">
							<div>
								<p>
									<i class="icon-circle-o text-red mr-2"></i>Total Sales</p>
								<p>
									<i class="icon-circle-o text-green mr-2"></i>Total Delivered</p>
								<p>
									<i class="icon-circle-o text-blue mr-2"></i>Pending Delivery</p>
								<p>
									<i class="icon-circle-o text-black mr-2"></i>Currently on Cart</p>
							</div>
							<div>
								<p>
									Ksh {{$totalSales}}</p>
								<p>
									{{$quantityDelivered}}
								</p>
								<p>
									{{$quantityOnOrder}}
								</p>
								<p>
									{{$quantityOnCart}}
								</p>
							</div>
						</div>
					</div>
					<div class="card-footer white">
					
					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="editProduct{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="editProduct{{$product->id}}" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Edit Product</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="{{url('admin/product/edit/'.$product->id)}}" method="post" enctype="multipart/form-data">
						@csrf
						<div class="modal-body">
						<div class="form-group">
							<label for="validationCustom01">Product Name</label>
							<input type="text" value="{{$product->title}}" name="title" class="form-control" id="validationCustom01"
							       placeholder="Product Name" required>
						</div>
							<div class="form-group">
								<label for="validationCustom02">Product Category</label>
								<select id="category" name="category" class="select2"
								        required>
									<option value="{{$product->category->id}}">{{$product->category->name}}</option>
									@forelse($categories as $category)
										<option value="{{$category->id}}">{{$category->name}}</option>
									@empty
										<option value="">No Category Found</option>
									@endforelse
								</select>
							</div>
							<div class="form-group">
								<label for="validationCustom02">Product Weight (Kgs) </label>
								<input type="number" name="weight" value="{{$product->weight}}" class="form-control" id="validationCustom04"
								       placeholder="10 Kgs"
								       required>
							</div>
							<div class="form-group">
								<label for="validationCustom04">Price (Ksh )</label>
								<input type="text" name="price" value="{{$product->price}}" class="form-control" id="validationCustom04"
								       placeholder="Ksh 250"
								       required>
							</div>
							<div class="form-group">
								<label for="validationCustom04">Quantity</label>
								<input type="number" name="qty" value="{{$product->qty}}" class="form-control" id="validationCustom06"
								       placeholder="Quantity"
								       required>
							</div>
							<div class="form-group">
								<label for="sku">Product Image</label>
								<input type="file" class="form-control" id="sku" name="file" >
							</div>
							<div class="form-group">
								<label for="productDetails">Product Details</label>
								<textarea name="description"  class="form-control p-t-40" id="productDetails"
								          placeholder="Write Something..." rows="8" required>{{$product->description}}</textarea>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Save changes</button>
						</div>
					</form>
				</div>
			</div>
		</div>
		<div class="modal fade" id="deleteProduct{{$product->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteProduct{{$product->id}}" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">Delete Product</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<p>Are you sure you want to delete this product?</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						<a href="{{url('admin/product/delete/'.$product->id)}}" class="btn btn-danger">Sure</a>
					</div>
				</div>
			</div>
		</div>
	</div>
	@endsection