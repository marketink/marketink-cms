@extends('layouts.app')

@section('beforeHead')

@endsection

@section('content')

<!-- =======================
Trending START -->
<section class="py-2">
	<div class="container">
		<div class="row g-0">
			<div class="col-12 bg-primary bg-opacity-10 p-2 rounded">
				<div class="d-sm-flex align-items-center text-center text-sm-start">
					<!-- Title -->
					<div class="me-3">
						<span class="badge bg-primary p-2 px-3">آخرین مطالب:</span>
					</div>
					<!-- Slider -->
					<div class="tiny-slider arrow-end arrow-xs arrow-white arrow-round arrow-md-none">
						<div class="tiny-slider-inner"
							data-autoplay="true"
							data-hoverpause="true"
							data-gutter="0"
							data-arrow="true"
							data-dots="false"
							data-items="1">
							<!-- Slider items -->
							 @foreach ($blog_populars as $blog_popular)
							 	<div> <a href="/{{ $blog_popular['type'] }}/{{ $blog_popular['id'] }}" class="text-reset btn-link">{{ $blog_popular['info']['title'] }}</a></div>
							 @endforeach
						</div>
					</div>
				</div>
			</div>
		</div> <!-- Row END -->
	</div>
</section>
<!-- =======================
Trending END -->

<!-- =======================
Main hero START -->
<section class="pt-4 pb-0 card-grid">
	<div class="container">
		<div class="row g-4">
			<!-- Left big card -->
			 @foreach ([collect($blog_news)->first()] as $news)
			 <div class="col-lg-6">
				<div class="card card-overlay-bottom card-grid-lg card-bg-scale" style="background-image:url({{ $news['info']['banner'] }}); background-position: center left; background-size: cover;">
					<!-- Card featured -->
					<span class="card-featured" title="Featured post"><i class="fas fa-star"></i></span>
					<!-- Card Image overlay -->
					<div class="card-img-overlay d-flex align-items-center p-3 p-sm-4"> 
						<div class="w-100 mt-auto">
							<!-- Card category -->
							<a href="#" class="badge text-bg-danger mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>{{ $news['info']['label'] }}</a>
							<!-- Card title -->
							<h2 class="text-white h1"><a href="/{{ $news['type'] }}/{{ $news['id'] }}" class="btn-link stretched-link text-reset">{{ $news['info']['title'] }}</a></h2>
							<p class="text-white">{{ $news['info']['embed'] }}</p>
							<!-- Card info -->
							<ul class="nav nav-divider text-white-force align-items-center d-none d-sm-inline-block">
								<li class="nav-item">{{ $news['info']['created_at']['date'] }}</li>
								<li class="nav-item">{{ $news['info']['read'] }}</li>
							</ul>
						</div>
					</div>
				</div>
			</div>			 
			 @endforeach

			<!-- Right small cards -->
			<div class="col-lg-6">
				<div class="row g-4">
				@foreach (collect($blog_news)->skip(1) as $news)

					<!-- Card item START -->
					<div class="col-md-6">
						<div class="card card-overlay-bottom card-grid-sm card-bg-scale" style="background-image:url({{ $news['info']['banner'] }}); background-position: center left; background-size: cover;">
							<!-- Card Image overlay -->
							<div class="card-img-overlay d-flex align-items-center p-3 p-sm-4"> 
								<div class="w-100 mt-auto">
									<!-- Card category -->
									<a href="#" class="badge text-bg-success mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>{{ $news['info']['label'] }}</a>
									<!-- Card title -->
									<h4 class="text-white"><a href="/{{ $news['type'] }}/{{ $news['id'] }}" class="btn-link stretched-link text-reset">{{ $news['info']['title'] }}</a></h4>
									<!-- Card info -->
									<ul class="nav nav-divider text-white-force align-items-center d-none d-sm-inline-block">
										<li class="nav-item">{{ $news['info']['created_at']['date'] }}</li>
									</ul>
								</div>
							</div>
						</div>
					</div>
					<!-- Card item END -->
					 @endforeach
				</div>
			</div>
		</div>
	</div>
</section>
<!-- =======================
Main hero END -->

<!-- =======================
Main content START -->
<section class="position-relative">
	<div class="container" data-sticky-container>
		<div class="row">
			<!-- Main Post START -->
			<div class="col-lg-9">
				<!-- Title -->
				<div class="mb-4">
					<h2 class="m-0"><i class="bi bi-hourglass-top me-2"></i>جدیدترین مطالب</h2>
					<p>آخرین پادکست ها، ویدیو ها، اخبار و مقالات</p>
				</div>
				<div class="row gy-4">
					@foreach (collect($blogs) as $blog)
										<!-- Card item START -->
										<div class="col-sm-6">
						<div class="card">
							<!-- Card img -->
							<div class="position-relative">
								<img class="card-img" src="{{ $blog['info']['banner'] }}" alt="Card image">
								<div class="card-img-overlay d-flex align-items-start flex-column p-3">
									<!-- Card overlay bottom -->
									<div class="w-100 mt-auto">
										<!-- Card category -->
										<a href="#" class="badge text-bg-warning mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>{{ $blog['info']['label'] }}</a>
									</div>
								</div>
							</div>
							<div class="card-body px-0 pt-3">
								<!-- Sponsored Post -->
								<h4 class="card-title mt-2"><a href="/{{ $blog['type'] }}/{{ $blog['id'] }}" class="btn-link text-reset fw-bold">{{ $blog['info']['title'] }}</a></h4>
								<p class="card-text">{{ $blog['info']['embed'] }}</p>
								<!-- Card info -->
								<ul class="nav nav-divider align-items-center d-none d-sm-inline-block">

									<li class="nav-item">{{ $blog['info']['created_at']['date'] }}</li>
								</ul>
							</div>
						</div>
					</div>
					<!-- Card item END -->
					@endforeach

					 
					<!-- Card item END -->
					<!-- Load more START -->
					<div class="col-12 text-center mt-5">
						<a href="/blogs" type="button" class="btn btn-primary-soft">آخرین مطالب <i class="bi bi-arrow-down-circle ms-2 align-middle"></i></a>
					</div>
					<!-- Load more END -->
				</div>
			</div>
			<!-- Main Post END -->
			<!-- Sidebar START -->
			<div class="col-lg-3 mt-5 mt-lg-0">
				<div data-sticky data-margin-top="80" data-sticky-for="767">

					<!-- Social widget START -->
					<div class="row g-2">
						@foreach ($socials as $social)
						<div class="col-4">
							<a href="{{ $social['info']['link'] }}" class="bg-{{ $social['info']['icon'] }} rounded text-center text-white-force p-3 d-block">
								<i class="fab fa-{{ $social['info']['icon'] }} fs-5 mb-2"></i>
								<h6 class="m-0">{{ $social['info']['followers'] }}</h6>
								<span class="small">دنبال کننده</span>
							</a>
						</div>
						@endforeach
					</div>
					<!-- Social widget END -->

					<!-- Trending topics widget START -->
					<div>
						<h4 class="mt-4 mb-3">دسته بندی ها</h4>
						@foreach ($categories as $category)
							<!-- Category item -->
							<div class="text-center mb-3 card-bg-scale position-relative overflow-hidden rounded bg-dark-overlay-4 " style="background-image:url({{ $category['info']['logo'] ?? "" }}); background-position: center left; background-size: cover;">
								<div class="p-5">
									<a href="/blogs/{{ $category['id'] }}" class="stretched-link btn-link fw-bold text-white h5">{{ $category['info']['title'] }}</a>
								</div>
							</div>
						@endforeach

					</div>
					<!-- Trending topics widget END -->

					<div class="row">
						<!-- Recent post widget START -->
						<div class="col-12 col-sm-6 col-lg-12">
							<h4 class="mt-4 mb-3">آخرین محتوا ها</h4>
							@foreach ($blogs_data['latest'] as $blog)
							<!-- Recent post item -->
							<div class="card mb-3">
								<div class="row g-3">
									<div class="col-4">
										<img class="rounded" src="{{ $blog['info']['banner'] }}" alt="{{ $blog['info']['title'] }}">
									</div>
									<div class="col-8">
										<h6><a href="/{{ $blog['type'] }}/{{ $blog['id'] }}" class="btn-link stretched-link text-reset fw-bold">{{ $blog['info']['title'] }}</a></h6>
										<div class="small mt-1">{{ $blog['info']['created_at']['date'] }}</div>
									</div>
								</div>
							</div>							
							@endforeach

						</div>
						<!-- Recent post widget END -->
					</div>
				</div>
			</div>
			<!-- Sidebar END -->
		</div> <!-- Row end -->
	</div>
</section>
<!-- =======================
Main content END -->

<!-- Divider -->
<div class="container"><div class="border-bottom border-primary border-2 opacity-1"></div></div>

<!-- =======================
Section START -->
<section class="pt-4">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<!-- Title -->
				<div class="mb-4 d-md-flex justify-content-between align-items-center">
					<h2 class="m-0"><i class="bi bi-megaphone"></i> پرطرفدار ترین ها</h2>
				</div>
				<div class="tiny-slider arrow-hover arrow-blur arrow-dark arrow-round">
					<div class="tiny-slider-inner"
						data-autoplay="true"
						data-hoverpause="true"
						data-gutter="24"
						data-arrow="true"
						data-dots="false"
						data-items-xl="4" 
						data-items-md="3" 
						data-items-sm="2" 
						data-items-xs="1">

						@foreach ($blog_rands as $blog)
						<!-- Card item START -->
						<div class="card">
							<!-- Card img -->
							<div class="position-relative">
								<img class="card-img" src="{{ $blog['info']['banner'] }}" alt="{{ $blog['info']['title'] }}">
								<div class="card-img-overlay d-flex align-items-start flex-column p-3">
									<!-- Card overlay bottom -->
									<div class="w-100 mt-auto">
										<a href="/{{ $blog['type'] }}/{{ $blog['id'] }}" class="badge text-bg-info mb-2"><i class="fas fa-circle me-2 small fw-bold"></i>{{ $blog['info']['label'] }}</a>
									</div>
								</div>
							</div>
							<div class="card-body px-0 pt-3">
								<h5 class="card-title"><a href="/{{ $blog['type'] }}/{{ $blog['id'] }}" class="btn-link text-reset fw-bold">{{ $blog['info']['title'] }}</a></h5>
								<!-- Card info -->
								<ul class="nav nav-divider align-items-center d-none d-sm-inline-block">
								<li class="nav-item">{{ $blog['info']['created_at']['date'] }}</li>
								<li class="nav-item">{{ $blog['info']['read'] }}</li>
								</ul>
							</div>
						</div>
						<!-- Card item END -->
						@endforeach

					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- =======================
Section END -->

@endsection