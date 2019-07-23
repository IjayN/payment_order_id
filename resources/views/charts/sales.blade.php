@extends('layouts.admin')
@section('content')
	<div class="container-fluid relative animatedParent animateOnce p-40 ">
		<div class="card p-t-40">
			<h6>&nbsp; &nbsp; &nbsp;Last 6 months Sales ( Ksh  {{$totalSales}})</h6>
			<div id="poll_div"></div>
			<?= $salesLava->render('BarChart' , 'sales' , 'poll_div') ?>
		</div>
	</div>
@endsection