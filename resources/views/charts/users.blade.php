@extends('layouts.admin')
@section('content')
	<div class="container-fluid relative animatedParent animateOnce p-40 ">
		<div class="p-t-40">
			<div id="chart-div"></div>
			<?= $lava->render('DonutChart' , 'users' , 'chart-div') ?>
		</div>
	</div>
@endsection