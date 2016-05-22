@extends('base')

@push('head')
	<link rel="stylesheet" href="/bower_components/dragula.js/dist/dragula.min.css"></script>
@endpush

@section('content')
	<div class="container-fluid" style="background: linear-gradient(to top, rgb(169,3,41) 0%,rgb(143,2,34) 44%,rgb(109,0,25) 100%);">
		<div class="container m-y-lg">
			<h1 class="text-center" style="color:#fff; font-weight: 100; font-size:9vw;">Gift Exchange Builder</h1>
		</div>
	</div>
	<div class="container">
		<h3 class="text-center">Enter Participants Below <br>
			<small>if any people shouldn't get each other (spouses etc.), put them together in one box</small>
		</h3>
		<div class="groups row p-a-md">

		</div>
		<div class="actions text-center">
			<button class="btn btn-primary m-a add-group"><i class="icon icon-circle-with-plus"></i> add another box</button>
			<button class="btn btn-danger btn-lg m-a build"><i class="icon icon-price-tag"></i> Send Gift Tags</button>
		</div>
	</div>
@endsection


@push('body')
	<script src="/bower_components/dragula.js/dist/dragula.min.js"></script>

	<template id="group">
		<div class="col-md-3 form-group">
			<textarea class="form-control" placeholder="enter email addresses one per line"></textarea>
		</div>
	</template>

	<script>


		$(function() {
			for (var i = 0; i < 4; i++) {
				$('.groups').append($('#group').html());
			}

			$.ajaxSetup({
		        headers: {
		            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		        }
			});

			$('.add-group').click(function() {
				$('.groups').append($('#group').html());
			});

			$('.build').click(function() {
				var groups = [];
				$('.groups textarea').each(function() {
					let group = $(this),
						value = group.val().trim();
					if (value) {
						groups.push(value.split("\n"));
					}
				});

				console.log(groups);

				$.ajax({
					method: 'POST',
					url: '/build',
					data: { groups : groups },
				}).done(function(data) {
					console.log(data);
				});
			})
		});
	</script>
@endpush
