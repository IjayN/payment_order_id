@extends('layouts.admin')
@section('content')
    <div class="container-fluid animatedParent animateOnce">
        <div class="tab-content my-3" id="v-pills-tabContent">
            <div class="tab-pane animated fadeInUpShort show active" id="v-pills-all" role="tabpanel"
                 aria-labelledby="v-pills-all-tab">
                <div class="row my-3">
                    <div class="col-md-6">
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
                    <div class="col-md-6">
                        <br>
                        <br>

                           <div class="card">
                               <div class="container">
                               <form method="post" action="{{url('daily-production')}}">
                                   {{csrf_field()}}
                                   <div class="form-group">
                                       <br>
                                       <h3>Add Product Quantity</h3>
                                       <br>
                                       <label for="product">Select Product</label>
                                       <select class="form-control" name="product" required>
                                           @foreach($products as $product)
                                               <option value="{{$product->id}}">{{$product->title}}</option>
                                           @endforeach
                                       </select>
                                   </div>
                                   <div class="form-group">
                                       <label for="qty">Quantity produced on {{\Carbon\Carbon::now()}}</label>
                                       <input type="number" name="qty" placeholder="Enter quantity" required class="form-control">
                                   </div>
                                   <div class="form-group">
                                       <br>
                                       <button type="submit" class="btn btn-success btn-block">Add Quantity</button>
                                   </div>
                               </form>
                           </div>
                       </div>

            </div>

        </div>
    </div>
    @endsection