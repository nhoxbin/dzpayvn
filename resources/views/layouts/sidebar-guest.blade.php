<div class="container unauthorize" id="sidebar" style="height: 1688px;">
    <div class="sidebar-header unauthorize">
        <div class="sidebar-header-background" style="width: 600px;">
            <div class="pull-left">
                <a href="/">
                    <img src="{{ asset('images/logo.png') }}">
                </a>
            </div>
        </div>
        <div id="close-menu-btn">
            <img class="max_width" src="{{ asset('libs/baokim/images/cancel.svg') }}">
        </div>
        <div class="clearfix"></div>
    </div>
    <div class="sidebar-body">
        <div class="login-banner">
            <img src="{{ asset('libs/baokim/images/top-login-banner.svg') }}" alt="">
        </div>
        <div class="func-list">
            <a href="{{ route('login') }}">
                <div class="func-item ">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/login.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Đăng nhập</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            <a href="{{ route('register') }}">
                <div class="func-item  ">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/register.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Đăng ký</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="func-item ">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/policy.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Chính sách bảo mật</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="func-item ">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/term.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Điều khoản sử dụng</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            <p id="copy-right">@ShopGold Team Member</p>
        </div>
    </div>
</div>