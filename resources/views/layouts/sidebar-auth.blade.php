<div class="container" id="sidebar" style="height: 1214px;">
    <div class="sidebar-header">
        <div class="sidebar-header-background" style="width: 600px;">
        </div>
        <div id="close-menu-btn">
            <img class="max_width" src="{{ asset('libs/baokim/images/cancel.svg') }}">
        </div>
        <div class="user-informations">
            <a href="#">
                <div class="user-avatar">
                    <img src="{{ asset('libs/baokim/images/user.svg') }}">
                </div>
            </a>
            <a href="{{ url('/dashboard') }}">
                <div class="user-contact">
                    <div class="username">
                        {{ Auth::user()->name }}
                    </div>
                    <div class="contact-small">
                        <img src="{{ asset('libs/baokim/images/menu-mail-icon.svg') }}">
                        {{ Auth::user()->email }}
                    </div>
                    <div class="contact-small">
                        <img src="{{ asset('libs/baokim/images/menu-phone-icon.svg') }}">
                        84{{ Auth::user()->phone }}
                    </div>
                </div>
            </a>
            <div class="clearfix"></div>
        </div>
    </div>
    <div class="sidebar-body">
        <div class="func-list">
            @if(Auth::user()->role === 1)
            <a href="{{ route('admin.home') }}">
                <div class="func-item  active">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/wallet.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Admin</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            @endif
            <a href="{{ route('dashboard') }}">
                <div class="func-item  active">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/wallet.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Ví của tôi</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            <a href="{{ route('recharge.create') }}">
                <div class="func-item  ">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/deposit.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Nạp tiền</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            <a href="{{ route('withdraw.create') }}">
                <div class="func-item  ">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/deposit.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Rút tiền</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            <a href="{{ route('transfer.create') }}">
                <div class="func-item">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/transfer.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Chuyển tiền</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            <a href="{{ route('url.index') }}">
                <div class="func-item">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/transfer.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Danh sách link rút gọn</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            <a href="{{ route('shake.create') }}">
                <div class="func-item">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/transfer.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Lắc xì</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            @if(Auth::user()->manage_game)
                <a href="{{ route('staff.manage.bill.index') }}">
                    <div class="func-item">
                        <div class="col">
                            <img class="icon" src="{{ asset('libs/baokim/images/txn.svg') }}" alt="">
                        </div>
                        <div class="col">
                            <span class="func-name">Khách nạp game</span>
                        </div>
                        <div class="col">
                            <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                        </div>
                    </div>
                </a>
            @endif
            <a href="{{ route('histories') }}">
                <div class="func-item">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/txn.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Lịch sử giao dịch</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            {{-- <a href="#">
                <div class="func-item">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/withdrawal.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">BET</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a> --}}
            {{-- <a href="#">
                <div class="func-item">
                    <div class="col">
                        <img class="icon" src="{{ asset('libs/baokim/images/setting.svg') }}" alt="">
                    </div>
                    <div class="col">
                        <span class="func-name">Cài đặt</span>
                    </div>
                    <div class="col">
                        <span class="pull-right arrow"><i class="fa fa-angle-right"></i></span>
                    </div>
                </div>
            </a>
            <a href="#">
                <div class="func-item">
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
            </a> --}}
        </div>

        <div class="logout-block">
            <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><button class="btn btn-black">Đăng xuất</button></a>
            <form action="{{ route('logout') }}" method="post" id="logout-form" style="display: none;">
                @csrf
            </form>
            <p id="copy-right">@ShopGold  Team Member</p>
        </div>
    </div>
</div>