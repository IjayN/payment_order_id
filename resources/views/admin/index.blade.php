@extends('layouts.admin')
@section('content')
	<div class="container-fluid relative animatedParent animateOnce">
		<div class="tab-content pb-3" id="v-pills-tabContent">
			
			<!--Today Tab Start-->
			<div class="tab-pane animated fadeInUpShort show active" id="v-pills-1">
				<div class="row my-3">
					<div class="col-md-3">
						<div class="counter-box white r-5 p-3">
							<div class="p-4">
								<div class="float-right">
									<span class="icon icon-note-list text-light-blue s-48"></span>
								</div>
								<div class="counter-title">Total Orders</div>
								<h5 class="sc-counter mt-3">{{$orders->count()}}</h5>
							</div>
							<div class="progress progress-xs r-0">
								<div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="20"
								     aria-valuemin="0" aria-valuemax="12"></div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="counter-box white r-5 p-3">
							<div class="p-4">
								<div class="float-right">
									<span class="icon icon-mail-envelope-open s-48"></span>
								</div>
								<div class="counter-title ">Orders Delivered</div>
								<h5 class="sc-counter mt-3">{{$ordersDelivered->count()}}</h5>
							</div>
							<div class="progress progress-xs r-0">
								<div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="25"
								     aria-valuemin="0" aria-valuemax="128"></div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="counter-box white r-5 p-3">
							<div class="p-4">
								<div class="float-right">
									<span class="icon icon-stop-watch3 s-48"></span>
								</div>
								<div class="counter-title">Orders Pending Delivery</div>
								<h5 class="sc-counter mt-3">{{$ordersAssigned->count()}}</h5>
							</div>
							<div class="progress progress-xs r-0">
								<div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="25"
								     aria-valuemin="0" aria-valuemax="128"></div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="counter-box white r-5 p-3">
							<div class="p-4">
								<div class="float-right">
									<span class="icon icon-document-cancel s-48"></span>
								</div>
								<div class="counter-title">Canceled Orders</div>
								<h5 class="sc-counter mt-3">{{$ordersCanceled->count()}}</h5>
							</div>
							<div class="progress progress-xs r-0">
								<div class="progress-bar" role="progressbar" style="width: 25%;" aria-valuenow="25"
								     aria-valuemin="0" aria-valuemax="128"></div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Today Tab End-->
			<!--Yesterday Tab Start-->
			<div class="tab-pane animated fadeInUpShort" id="v-pills-2">
				<div class="row my-3">
					<div class="col-md-3">
						<div class="counter-box white r-5 p-3">
							<div class="p-4">
								<div class="float-right">
									<span class="icon icon-note-list text-light-blue s-48"></span>
								</div>
								<div class="counter-title">Web Projects</div>
								<h5 class="sc-counter mt-3">3000</h5>
							</div>
							<div class="progress progress-xs r-0">
								<div class="progress-bar bg-warning" role="progressbar" style="width: 25%;"
								     aria-valuenow="25" aria-valuemin="0" aria-valuemax="128"></div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="counter-box white r-5 p-3">
							<div class="p-4">
								<div class="float-right">
									<span class="icon icon-mail-envelope-open s-48"></span>
								</div>
								<div class="counter-title ">Premium Themes</div>
								<h5 class="sc-counter mt-3">1000</h5>
							</div>
							<div class="progress progress-xs r-0">
								<div class="progress-bar bg-success" role="progressbar" style="width: 50%;"
								     aria-valuenow="25" aria-valuemin="0" aria-valuemax="128"></div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="counter-box white r-5 p-3">
							<div class="p-4">
								<div class="float-right">
									<span class="icon icon-stop-watch3 s-48"></span>
								</div>
								<div class="counter-title">Support Requests</div>
								<h5 class="sc-counter mt-3">600</h5>
							</div>
							<div class="progress progress-xs r-0">
								<div class="progress-bar" role="progressbar" style="width: 75%;" aria-valuenow="25"
								     aria-valuemin="0" aria-valuemax="128"></div>
							</div>
						</div>
					</div>
					<div class="col-md-3">
						<div class="counter-box white r-5 p-3">
							<div class="p-4">
								<div class="float-right">
									<span class="icon icon-inbox-document-text s-48"></span>
								</div>
								<div class="counter-title">Support Requests</div>
								<h5 class="sc-counter mt-3">525</h5>
							</div>
							<div class="progress progress-xs r-0">
								<div class="progress-bar bg-danger" role="progressbar" style="width: 25%;"
								     aria-valuenow="25" aria-valuemin="0" aria-valuemax="128"></div>
							</div>
						</div>
					</div>
				</div>
				<div class="row my-3">
					<div class="col-md-12">
						<div class="white p-5 r-5">
							<div style="height: 528px">
								<canvas
										data-chart="line"
										data-dataset="[
                                                [0,528,228,728,528,1628,0],
                                                [0,628,228,1228,428,1828,0],
                                                ]"
										data-labels="['Blue','Yellow','Green','Purple','Orange','Red','Indigo']"
										data-dataset-options="[
                                            { label:'Sales', borderColor:  'rgba(54, 162, 235, 1)', backgroundColor: 'rgba(54, 162, 235,1)'},
                                            { label:'Orders', borderColor:  'rgba(255,99,132,1)', backgroundColor: 'rgba(255, 99, 132, 1)' }]"
										data-options="{
                                                maintainAspectRatio: false,
                                                legend: {
                                                    display: true
                                                },
                                    
                                                scales: {
                                                    xAxes: [{
                                                        display: true,
                                                        gridLines: {
                                                            zeroLineColor: '#eee',
                                                            color: '#eee',
                                                      
                                                            borderDash: [5, 5],
                                                        }
                                                    }],
                                                    yAxes: [{
                                                        display: true,
                                                        gridLines: {
                                                            zeroLineColor: '#eee',
                                                            color: '#eee',
                                                            borderDash: [5, 5],
                                                        }
                                                    }]
                                    
                                                },
                                                elements: {
                                                    line: {
                                                    
                                                        tension: 0.4,
                                                        borderWidth: 1
                                                    },
                                                    point: {
                                                        radius: 2,
                                                        hitRadius: 10,
                                                        hoverRadius: 6,
                                                        borderWidth: 4
                                                    }
                                                }
                                            }">
								</canvas>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Yesterday Tab Start-->
			<!--Yesterday Tab Start-->
			<div class="tab-pane animated fadeInUpShort" id="v-pills-3">
				<div class="row">
					<div class="col-md-4 mx-md-auto m-5">
						<div class="card no-b shadow">
							<div class="card-body p-4">
								<div>
									<i class="icon-calendar-check-o s-48 text-primary"></i>
									<p class="p-t-b-20">Hey Soldier welcome back signin now there is lot of new
										stuff
										waiting
										for you</p>
								</div>
								<form action="dashboard2.html">
									<div class="form-group has-icon"><i class="icon-calendar"></i>
										<input class="form-control form-control-lg datePicker"
										       placeholder="Date From"
										       type="text">
									</div>
									<div class="form-group has-icon"><i class="icon-calendar"></i>
										<input class="form-control form-control-lg datePicker" placeholder="Date TO"
										       type="text">
									</div>
									<input class="btn btn-success btn-lg btn-block" value="Get Data" type="submit">
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
			<!--Yesterday Tab Start-->
		</div>
		
	</div>
	@endsection