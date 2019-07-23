@extends('layouts.admin')
@section('content')
	<div class="container-fluid animatedParent animateOnce my-3">
		<div class="animated fadeInUpShort">
			<div class="row">
				
				<br>
				<br>
				<div class="col-md-10 offset-2">
					<p class="text-success">@include('flash::message')</p>
					<br>
					<form method="post" action="{{url('new-user')}}" enctype="multipart/form-data">
						@csrf
						<div class="row">
							<div class="col-md-9">
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="validationCustom01">Full Name</label>
										<input type="text" name="name" class="form-control"
										       placeholder="User Name" required>
										@if($errors->has('title'))
											<p class="text-danger">{{$errors->first('title')}}</p>
										@endif
									
									</div>
									<div class="col-md-6 mb-3">
										<label for="validationCustom02">User Type</label>
										<select id="type" name="type" class="custom-select form-control"
										        required>
											<option value="marketer">Marketer</option>
											<option value="driver">Driver</option>
											<option value="admin">Administrator</option>
											<option value="accountant">Accountant</option>
											<option value="production">Production Manager</option>
										</select>
										@if($errors->has('type'))
											<p class="text-danger">{{$errors->first('category')}}</p>
										@endif
									
									</div>
								</div>
								<div class="row">
									<div class="col-md-6 mb-3">
										<label for="validationCustom04">Phone Number</label>
										<input type="tel" name="phone" class="form-control" id="validationCustom04"
										       placeholder="0701234567"
										       required>
										
										@if($errors->has('phone'))
											<p class="text-danger">{{$errors->first('phone')}}</p>
										@endif
									
									</div>
									<div class="col-md-6 mb-3">
										<label for="validationCustom04">Password</label>
										<input type="password" name="password" class="form-control"
										       id="validationCustom06"
										       placeholder="******"
										       required>
										@if($errors->has('password'))
											<p class="text-white">{{$errors->first('password')}}</p>
										@endif
									
									</div>
								</div>
								<div class="card-footer bg-transparent">
									<button class="btn btn-primary btn-block" type="submit">Create User</button>
								</div>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
@endsection