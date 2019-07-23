@extends('layouts.admin')
@section('content')
    <style>
        .image-wrapper {
            padding: 10px;
        }
    </style>
    <div class="container-fluid  my-3">
        @include('flash::message')
        <a href="{{route ('students')}}" class="btn btn-info btn-sm">Students</a>
        <br>
        <br>
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
                        <h6> &nbsp; &nbsp; Name: &nbsp; &nbsp; &nbsp; &nbsp; {{$user->name}}
                        </h6>
                        <br>
                        <h6> &nbsp; &nbsp; Contact: &nbsp; &nbsp; &nbsp; &nbsp; {{$user->phone}}</h6>
                        <br>
                        <h6> &nbsp; &nbsp; Date Registered: &nbsp; &nbsp; &nbsp;
                            &nbsp; {{date('M, d Y', strtotime($user->created_at))}}</h6>
                    
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header white">
                        <i class="icon-briefcase blue-text"></i>
                        <strong style="font-size: 16px; font-weight: 600"> &nbsp; Files
                            ( {{$data->count()}} )</strong>
                    </div>
                    <div class="card-body pt-0 bg-light slimScroll" data-height="400">
                        <table class="table table-striped table-hover r-0">
                            <thead>
                            <tr class="no-b">
                                <th>File</th>
                                <th>Action</th>
                                <th></th>
                            </tr>
                            </thead>
        
                            <tbody>
                        @foreach($data as $d)
                            <tr>
                                <td><i class="icon icon-file blue-text"></i> {{$d->fileName}}</td>
                                <td>
                                    <a href="{{url('admin/students/download/data', $d->id)}}"><i class="icon icon-download green-text"></i> Download</a>
                                </td>
                            </tr>
                        @endforeach
                            </tbody>
                        </table>
                        
                         <div class="actions">
                             @if(!$user->verified)
                                 <a href="{{url('admin/verify/student/'. $user->id)}}" class="btn btn-success btn-block">Activate Account</a>
                                 @else
                                 <a href="{{url('admin/unverify/student/'. $user->id)}}" class="btn btn-danger btn-block">Deactivate Account</a>
                             @endif
                         </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection