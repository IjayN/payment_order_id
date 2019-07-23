@extends('layouts.admin')
@section('content')
	<br>
	<div class="container-fluid  my-3">
		@include('flash::message')
		<div class="row">
			<div class="col-md-12">
				<div class="card ">
					<div class="card-header white">
						<i class="icon-clipboard-edit blue-text"></i>
						<strong style="font-size: 16px; font-weight: 600">Product Categories </strong>
					</div>
					<div class="card-body p-0 bg-light slimScroll" data-height="500">
						<div class="table-responsive">
							<table class="table table-hover">
								<!-- Table heading -->
								<tbody>
								<tr class="no-b">
									<th>Name</th>
									<th>Product Count</th>
									<th>Products</th>
								</tr>
								@forelse($categories as $category)
								<tr>
									<td>
										{{$category->name}}
									</td>
									<td> ( {{$category->product->count()}} )</td>
									<td>
										<a style="text-decoration: underline" href="{{url('admin/category/products/'.$category->id)}}">View Products</a>
									</td>
									<td>
										<button type="button" class="btn btn-secondary btn-xs" data-toggle="modal" data-target="#editCategory{{$category->id}}">
											EDIT &nbsp; <i class="icon icon-edit"></i>
										</button>
										<!-- Modal -->
										<div class="modal fade" id="editCategory{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="editCategory{{$category->id}}" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLongTitle">Edit Category</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<form action="{{url('admin/edit/category/'.$category->id)}}" method="post">
														@csrf
														<div class="modal-body">
															<div class="form-group">
																<label for="name">Category Name</label>
																<input type="text" value="{{$category->name}}" name="name" class="form-control" required>
															</div>
														</div>
														<div class="modal-footer">
															<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
															<button type="submit" class="btn btn-secondary">Save</button>
														</div>
													</form>
												</div>
											</div>
										</div>
										&nbsp;&nbsp;
										<button type="button" class="btn btn-danger btn-xs" data-toggle="modal" data-target="#deleteCategory{{$category->id}}">
											Delete &nbsp; <i class="icon icon-trash-can"></i>
										</button>
										<div class="modal fade" id="deleteCategory{{$category->id}}" tabindex="-1" role="dialog" aria-labelledby="deleteCategory{{$category->id}}" aria-hidden="true">
											<div class="modal-dialog modal-dialog-centered" role="document">
												<div class="modal-content">
													<div class="modal-header">
														<h5 class="modal-title" id="exampleModalLongTitle">Delete Category {{$category->name}}</h5>
														<button type="button" class="close" data-dismiss="modal" aria-label="Close">
															<span aria-hidden="true">&times;</span>
														</button>
													</div>
													<div class="modal-body">
														Are you sure you want to delete this category ? All products  will be deleted.
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
														<a href="{{url('admin/category/delete/'.$category->id)}}"  class="btn btn-danger">Yes</a>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>
								@empty
									&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp;&nbsp; &nbsp; No categories Found
									@endforelse
								</tbody>
							</table>
						</div>
					</div>
					<div class="card-footer white">
						<button type="button" class="btn btn-primary  float-right" data-toggle="modal" data-target="#addCategory">
							Add New Category
						</button>
						
					</div>
				</div>
			</div>
		</div>
		<!-- Modal -->
		<div class="modal fade" id="addCategory" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="exampleModalLongTitle">New Product Category</h5>
						<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<form action="{{url('admin/category')}}" method="post">
						@csrf
						<div class="modal-body">
							<div class="form-group">
								<label for="name">Category Name</label>
								<input type="text" name="name" class="form-control" required>
							</div>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							<button type="submit" class="btn btn-primary">Add Category</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	@endsection