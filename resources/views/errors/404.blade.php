@extends('layouts.app')

@section('content')
	<section role="main" class="main">
		<section class="body-container">
			<div class="content-max-width">
				<h2>Whoops!</h2>
				<p>The page you are looking for doesn't exist...</p>
				<p>Go back to the <a href="{{ route('home') }}">homepage.</a></p>
			</div>
		</section>
	</section>
@endsection