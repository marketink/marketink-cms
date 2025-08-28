
<footer class="footer p-0">
    <div class="container">
        <div class="row g-4 py-4">
            <div class="col-sm-6">
                <h6 class="mb-4">{{ env('APP_NAME') }}</h6>
                <div class="row">
                    <div class="col-12">
                        <p>
                            لورم ایپسوم متن ساختگی با تولید سادگی نامفهوم از صنعت چاپ و با استفاده از طراحان گرافیک است
                            چاپگرها و متون بلکه روزنامه و مجله در ستون و سطرآنچنان که لازم است و برای شرایط فعلی
                            تکنولوژی مورد نیاز و کاربردهای متنوع با هدف بهبود ابزارهای کاربردی می باشد
                        </p>
                    </div>
                </div>

            </div>
            <div class="col-6 col-sm-3">
                <h6 class="mb-4">{{trans("message.categories")}}</h6>
                <div class="row">
                    <div class="col-12">
                        <!-- list -->
                        <ul class="nav flex-column">
                            @foreach (categories() as $category)
                                <li class="nav-item mb-2"><a href="{{route("products.category",["category" => $category["id"]])}}"
                                        class="nav-link">{{ $category['info']['title'] ?? "" }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-6 col-sm-3">
                <div class="row g-4">
                    <div class="col-12">
                        <h6 class="mb-4">{{trans("message.know_us_more")}}</h6>
                        <!-- list -->
                        <ul class="nav flex-column">
                            <li class="nav-item mb-2"><a href="{{route("products")}}" class="nav-link">{{trans("message.products")}}</a></li>
                            <li class="nav-item mb-2"><a href="{{route("aboutUs")}}" class="nav-link">{{trans("message.about_us")}}</a></li>
                            <li class="nav-item mb-2"><a href="{{route("faq")}}" class="nav-link">{{trans("message.faq")}}</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-top py-4">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <span class="small text-muted">©
                        <span id="copyright">
                            <script>document.getElementById('copyright').appendChild(document.createTextNode(new Date().getFullYear()))</script>
                        </span>
                        {{trans("message.site_belongs_to"). " "}} <a href="{{ url('/') }}">{{ env('APP_NAME') }}</a>
                        {{trans("message.complete_register_means_v4")}}
                    </span>
                </div>
                <div class="col-md-6">
                    <ul class="list-inline text-md-end mb-0 small mt-3 mt-md-0">
                        <li class="list-inline-item text-muted">{{trans("message.follow_us_in_social_media")}}</li>
                        @foreach (socials() as $social)
                            <li class="list-inline-item me-1">
                                <a href="{{ $social['info']['link'] ?? "#!" }}" target="_blank" class="btn btn-xs btn-social btn-icon">
                                    <i class="flex bi bi-{{ $social['info']['icon'] ?? "instagram" }}"></i>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

        </div>
    </div>
</footer>
