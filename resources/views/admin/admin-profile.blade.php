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
                    <form method="post" action="{{url('edit-user/'.$user->id)}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-9">
                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom01">Full Name</label>
                                        <input type="text" value="{{$user->name}}" name="name" class="form-control"
                                               placeholder="User Name" required>
                                        @if($errors->has('name'))
                                            <p class="text-danger">{{$errors->first('name')}}</p>
                                        @endif
                                    
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="validationCustom02">User Type</label>
                                        <select id="type" name="type" class="custom-select form-control"
                                                required>
                                            @if($user->admin)
                                                <option value="admin">Administrator</option>
                                            @elseif($user->user)
                                                <option value="user">Shop Owner</option>
                                            @elseif($user->marketer)
                                                <option value="marketer">Marketer</option>
                                            @elseif($user->driver)
                                                <option value="driver">Driver</option>
                                            @endif
                                            <option value="user">Shop Owner</option>
                                            <option value="marketer">Marketer</option>
                                            <option value="driver">Driver</option>
                                            <option value="admin">Administrator</option>
                                        </select>
                                        @if($errors->has('type'))
                                            <p class="text-danger">{{$errors->first('category')}}</p>
                                        @endif
                                    
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <label for="validationCustom04">Phone Number</label>
                                        <input type="tel" name="phone" value="{{$user->phone}}" class="form-control" id="validationCustom04"
                                               placeholder="0701234567"
                                               required>
                                        
                                        @if($errors->has('phone'))
                                            <p class="text-danger">{{$errors->first('phone')}}</p>
                                        @endif
                                    
                                    </div>
                                </div>
                                <div class="card-footer bg-transparent">
                                    <button class="btn btn-primary btn-block" type="submit">Edit User</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection