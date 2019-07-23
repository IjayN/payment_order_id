@extends('layouts.admin')
@section('content')
	<div class="container-fluid animatedParent animateOnce my-3">
		<div class="animated fadeInUpShort">
			<div class="row">
				<div class="col-md-12">
					<form method="post" action="{{url('post-product')}}" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-4 mb-3">
										<label for="validationCustom01">Product Name</label>
										<input type="text" name="title" class="form-control" id="validationCustom01"
										       placeholder="Product Name" required>
										<div class="invalid-feedback">
											@if($errors->has('title'))
												{{$errors->first('title')}}
											@endif
										</div>
									</div>
									<div class="col-md-4 mb-3">
										<label for="validationCustom02">Product Category</label>
										<select id="category" name="category" class="select2"
										        required>
											@forelse($categories as $category)
												<option value="{{$category->id}}">{{$category->name}}</option>
											@empty
												<option value="">No Category Found</option>
											@endforelse
										</select>
										<div class="invalid-feedback">
											@if($errors->has('category'))
												{{$errors->first('category')}}
											@endif
										</div>
									</div>
									<div class="col-md-4 mb-3">
										<label for="validationCustom02">Product Weight (Kgs)</label>
										<input type="number" name="weight" class="form-control" id="validationCustom04"
										       placeholder="10 Kgs"
										       required>
										<div class="invalid-feedback">
											@if($errors->has('weight'))
												{{$errors->first('weight')}}
											@endif
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-md-4 mb-3">
										<label for="validationCustom04">Price (Ksh )</label>
										<input type="text" name="price" class="form-control" id="validationCustom04"
										       placeholder="Ksh 250"
										       required>
										<div class="invalid-feedback">
											@if($errors->has('price'))
												{{$errors->first('price')}}
											@endif
										</div>
									</div>
									<div class="col-md-4 mb-3">
										<label for="validationCustom04">Quantity</label>
										<input type="number" name="qty" class="form-control" id="validationCustom06"
										       placeholder="Quantity"
										       required>
										<div class="invalid-feedback">
											@if($errors->has('qty'))
												{{$errors->first('qty')}}
											@endif
										</div>
									</div>
									<div class="col-md-4 mb-3">
										<label for="sku">Product Image</label>
										<input type="file" class="form-control" id="sku" name="file" required>
										<div class="invalid-feedback">
											@if($errors->has('file'))
												{{$errors->first('file')}}
											@endif
										</div>
									</div>
								</div>
								<div class="form-group">
									<label for="productDetails">Product Details</label>
									<textarea name="description" class="form-control p-t-40" id="productDetails"
									          placeholder="Write Something..." rows="8" required></textarea>
									<div class="invalid-feedback">
										@if($errors->has('details'))
											{{$errors->first('details')}}
										@endif
									</div>
								</div>
								<div class="card-footer bg-transparent">
									<button class="btn btn-primary btn-block" type="submit">Publish</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection