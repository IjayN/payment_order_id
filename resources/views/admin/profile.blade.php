@extends('layouts.admin')
@section('content')
    <div class="container-fluid animatedParent animateOnce my-3">
        <div class="animated fadeInUpShort">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="card ">
                                
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item"><i class="icon icon-mobile text-primary"></i><strong class="s-12">Phone</strong> <span class="float-right s-12">{{$user->phone}}</span></li>
                                    <li class="list-group-item"><i class="icon icon-mail text-success"></i><strong class="s-12">Name</strong> <span class="float-right s-12">{{$user->name}}</span></li>
                                    <li class="list-group-item"><i class="icon icon-address-card-o text-warning"></i><strong class="s-12">Address</strong> <span class="float-right s-12">Nairobi, Kenya</span></li>
                                    <br>
                                    
                                </ul>
                                <a href="{{url('user-edit/'.$user->id)}}" class=" btn btn-success shadow">Edit {{$user->name}} 's Details</a>
                            </div>
                            
                        
                        </div>
                        <div class="col-md-9">
                            
                            <div class="row">
                                <div class="col-lg-4">
                                    <div class="card r-3">
                                        <div class="p-4">
                                            <div class="float-right">
                                                <span class="icon-award text-light-blue s-48"></span>
                                            </div>
                                            <div class="counter-title">Number of Orders</div>
                                            <h5 class="sc-counter mt-3">5th</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card r-3">
                                        <div class="p-4">
                                            <div class="float-right"><span class="icon-stop-watch3 s-48"></span>
                                            </div>
                                            <div class="counter-title ">Shops</div>
                                            <h5 class="sc-counter mt-3">12</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="white card">
                                        <div class="p-4">
                                            <div class="float-right"><span class="icon-orders s-48"></span>
                                            </div>
                                            <div class="counter-title">Roll Number</div>
                                            <h5 class="sc-counter mt-3">26</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row my-3">
                                <!-- bar charts group -->
                                <div class="col-md-12">
                                    <div class="card">
                                        <div class="card-header white">
                                            <h6>Order <small>Summary</small></h6>
                                        </div>
                                        <div class="card-body">
                                            <div id="graphx" style="width:100%; height:300px;" ></div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /bar charts group -->
                            
                            
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-payments" role="tabpanel" aria-labelledby="v-pills-payments-tab">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card no-b">
                                <div class="card-header white b-0 p-3">
                                    <h4 class="card-title">Invoices</h4>
                                    <small class="card-subtitle mb-2 text-muted">Items purchase by users.</small>
                                </div>
                                <div class="collapse show" id="invoiceCard">
                                    <div class="card-body p-0">
                                        <div class="table-responsive">
                                            <table id="recent-orders"
                                                   class="table table-hover mb-0 ps-container ps-theme-default">
                                                <thead class="bg-light">
                                                <tr>
                                                    <th>SKU</th>
                                                    <th>Invoice#</th>
                                                    <th>Customer Name</th>
                                                    <th>Status</th>
                                                    <th>Amount</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>PAP-10521</td>
                                                    <td><a href="#">INV-281281</a></td>
                                                    <td>Baja Khan</td>
                                                    <td><span class="badge badge-success">Paid</span></td>
                                                    <td>$ 1228.28</td>
                                                </tr>
                                                <tr>
                                                    <td>PAP-532521</td>
                                                    <td><a href="#">INV-01112</a></td>
                                                    <td>Khan Sab</td>
                                                    <td><span class="badge badge-warning">Overdue</span>
                                                    </td>
                                                    <td>$ 5685.28</td>
                                                </tr>
                                                <tr>
                                                    <td>PAP-05521</td>
                                                    <td><a href="#">INV-281012</a></td>
                                                    <td>Bin Ladin</td>
                                                    <td><span class="badge badge-success">Paid</span></td>
                                                    <td>$ 152.28</td>
                                                </tr>
                                                <tr>
                                                    <td>PAP-15521</td>
                                                    <td><a href="#">INV-281401</a></td>
                                                    <td>Zoor Shoor</td>
                                                    <td><span class="badge badge-success">Paid</span></td>
                                                    <td>$ 1450.28</td>
                                                </tr>
                                                <tr>
                                                    <td>PAP-532521</td>
                                                    <td><a href="#">INV-01112</a></td>
                                                    <td>Khan Sab</td>
                                                    <td><span class="badge badge-warning">Overdue</span>
                                                    </td>
                                                    <td>$ 5685.28</td>
                                                </tr>
                                                <tr>
                                                    <td>PAP-05521</td>
                                                    <td><a href="#">INV-281012</a></td>
                                                    <td>Bin Ladin</td>
                                                    <td><span class="badge badge-success">Paid</span></td>
                                                    <td>$ 152.28</td>
                                                </tr>
                                                <tr>
                                                    <td>PAP-15521</td>
                                                    <td><a href="#">INV-281401</a></td>
                                                    <td>Zoor Shoor</td>
                                                    <td><span class="badge badge-success">Paid</span></td>
                                                    <td>$ 1450.28</td>
                                                </tr>
                                                <tr>
                                                    <td>PAP-32521</td>
                                                    <td><a href="#">INV-288101</a></td>
                                                    <td>Walter R.</td>
                                                    <td><span class="badge badge-warning">Overdue</span>
                                                    </td>
                                                    <td>$ 685.28</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                
                </div>
                <div class="tab-pane fade" id="v-pills-timeline" role="tabpanel" aria-labelledby="v-pills-timeline-tab">
                    
                    <div class="row">
                        <div class="col-md-12">
                            <!-- The time line -->
                            <ul class="timeline">
                                <!-- timeline time label -->
                                <li class="time-label">
                  <span class="badge badge-danger r-3">
                    10 Feb. 2014
                  </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class="ion icon-envelope bg-primary"></i>
                                    <div class="timeline-item card">
                                        <div class="card-header white"><a href="#">Support Team</a> sent you an email    <span class="time float-right"><i class="ion icon-clock-o"></i> 12:05</span></div>
                                        <div class="card-body">
                                            Etsy doostang zoodles disqus groupon greplin oooj voxy zoodles,
                                            weebly ning heekya handango imeem plugg dopplr jibjab, movity
                                            jajah plickers sifteo edmodo ifttt zimbra. Babblely odeo kaboodle
                                            quora plaxo ideeli hulu weebly balihoo...
                                        </div>
                                        <div class="card-footer">
                                            <a class="btn btn-primary btn-xs">Read more</a>
                                            <a class="btn btn-danger btn-xs">Delete</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i class="ion icon-user yellow"></i>
                                    
                                    <div class="timeline-item  card">
                                        
                                        <div class="card-header white"><h6><a href="#">Sarah Young</a> accepted your friend request<span class="float-right"><i class="ion icon-clock-o"></i> 5 mins ago</span></h6></div>
                                    
                                    
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i class="ion icon-comments bg-danger"></i>
                                    
                                    <div class="timeline-item  card">
                                        
                                        
                                        <div class="card-header white"><h6><a href="#">Jay White</a> commented on your post   <span class="float-right"><i class="ion icon-clock-o"></i> 27 mins ago</span></h6></div>
                                        
                                        <div class="card-body">
                                            Take me to your leader!
                                            Switzerland is small and neutral!
                                            We are more like Germany, ambitious and misunderstood!
                                        </div>
                                        <div class="card-footer">
                                            <a class="btn btn-warning btn-flat btn-xs">View comment</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline time label -->
                                <li class="time-label">
                  <span class="badge badge-success r-3">
                    3 Jan. 2014
                  </span>
                                </li>
                                <!-- /.timeline-label -->
                                <!-- timeline item -->
                                <li>
                                    <i class="ion icon-camera indigo"></i>
                                    
                                    <div class="timeline-item  card">
                                        
                                        <div class="card-header white"><a href="#">Mina Lee</a> uploaded new photos<span class="time float-right"><i class="ion icon-clock-o"></i> 2 days ago</span></div>
                                        
                                        
                                        <div class="card-body">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                            <img src="http://placehold.it/150x100" alt="..." class="margin">
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <!-- timeline item -->
                                <li>
                                    <i class="ion icon-video-camera bg-maroon"></i>
                                    
                                    <div class="timeline-item  card">
                                        <div class="card-header white"><a href="#">Mr. Doe</a> shared a video<span class="time float-right"><i class="ion icon-clock-o"></i> 5 days ago</span></div>
                                        
                                        
                                        <div class="card-body">
                                            <div class="embed-responsive embed-responsive-16by9">
                                                <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/tMWkeBIohBs" allowfullscreen="" frameborder="0"></iframe>
                                            </div>
                                        </div>
                                        <div class="card-footer">
                                            <a href="#" class="btn btn-xs bg-maroon">See comments</a>
                                        </div>
                                    </div>
                                </li>
                                <!-- END timeline item -->
                                <li>
                                    <i class="ion icon-clock-o bg-gray"></i>
                                </li>
                            </ul>
                        </div>
                        <!-- /.col -->
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab">
                    <form class="form-horizontal">
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Name</label>
                            
                            <div class="col-sm-10">
                                <input class="form-control" id="inputName" placeholder="Name" type="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-sm-2 control-label">Email</label>
                            
                            <div class="col-sm-10">
                                <input class="form-control" id="inputEmail" placeholder="Email" type="email">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputName" class="col-sm-2 control-label">Name</label>
                            
                            <div class="col-sm-10">
                                <input class="form-control" id="inputName" placeholder="Name" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputExperience" class="col-sm-2 control-label">Experience</label>
                            
                            <div class="col-sm-10">
                                <textarea class="form-control" id="inputExperience" placeholder="Experience"></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputSkills" class="col-sm-2 control-label">Skills</label>
                            
                            <div class="col-sm-10">
                                <input class="form-control" id="inputSkills" placeholder="Skills" type="text">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox"> I agree to the <a href="#">terms and conditions</a>
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-danger">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endsection