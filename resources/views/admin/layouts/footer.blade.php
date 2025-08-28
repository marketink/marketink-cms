<footer class="footer py-4  ">
    <div class="container-fluid">
        <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
                <div class="copyright text-center text-sm text-muted text-lg-end">
                    {{trans("message.panel_with_marketink_v1")}} <i style="color:red" class="fa fa-heart"></i>{{trans("message.panel_with_marketink_v2")}}
                    <a href="https://marketink.ir" class="font-weight-bold" target="_blank">{{trans("message.marketinik")}}</a>
                    {{trans("message.panel_with_marketink_v3")}}
                </div>
            </div>
            <div class="col-lg-6">
                <ul class="nav nav-footer justify-content-center justify-content-lg-end p-0">
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link text-muted" target="_blank">{{trans("message.first_page")}}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ url('/') }}" class="nav-link text-muted" target="_blank">{{trans("message.store_page")}}</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</footer>
