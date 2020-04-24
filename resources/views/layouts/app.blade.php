<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta id="viewport" name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <meta name="theme-color" content="#00b7f1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Ví Điện Tử DzPayVn - Đổi thẻ cào sang tiền mặt, đổi thẻ điện thoại thành tiền</title>
    <meta content="Ví DZpayVN Hỗ Trợ Nạp tiền vào tài khoản qua Momo, Thẻ Cào, Tài khoản chính của sim ! Hỗ Trợ rút về Momo Và Tất cả Các Ngân Hàng Trong Nước" name="keywords">
    <meta content="Đổi thẻ cào thành tiền mặt, đổi thẻ điện thoại thành tiền, Thanh toán trực tuyến, Mua hàng an toàn, Tích hợp bán hàng, Mua sắm trực tuyến, Chuyển tiền trực tuyến, Thanh toán, Nạp tiền, Tích hợp thanh toán, Nhận tiền siêu tốc, Gửi yêu cầu chuyển tiền" name="description">
    
    <link rel="stylesheet" href="{{ asset('libs/baokim/css/roboto.css') }}">
    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('libs/baokim/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/baokim/css/font-awesome.min.css') }}">

    <link rel="stylesheet" href="{{ asset('libs/baokim/css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/baokim/css/setting.css') }}">
    <link rel="stylesheet" href="{{ asset('libs/baokim/css/reponsive.css') }}">

    @stack('style')
    @routes
</head>
<body class="dislable_scorll _conten_">
<div id="app">
    <div class="container m_body m_main_mb no-padding">
        @guest
            @include('layouts.sidebar-guest')
        @else
            @include('layouts.sidebar-auth')
        @endguest
    
        <div class="payment-container container no-padding">
            <div class="payment-header sticky">
                <div class="pull-left">
                    <a href="{{ env('APP_URL', null) }}">
                        <img src="https://i.imgur.com/xJmFg7T.png" alt="logo">
                    </a>
                </div>
                <div class="pull-right">
                    <div class="pull-left">
                        <a href="javascript:void(0);" class="slide-toggle">
                            <i class="fa fa-bars btn_menu" aria-hidden="true"></i>
                        </a>
                    </div>
                </div>
                <div class="clearfix"></div>
                <section class="bg_title">
                    <center id="center-tag"><span>@yield('title')</span></center>
                </section>
            </div>

            @yield('payment-body')
        </div>
            
        @include('layouts.footer')
    </div>
</div>

<!-- development version, includes helpful console warnings -->
<script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>

<!-- production version, optimized for size and speed -->
{{-- <script src="https://cdn.jsdelivr.net/npm/vue"></script> --}}

<script src="{{ asset('libs/baokim/js/jquery-3.4.1.min.js') }}"></script>
<script src="{{ asset('libs/baokim/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('libs/baokim/js/jquery-ui.js') }}"></script>
<script src="{{ asset('libs/baokim/js/main.js') }}"></script>
<script src="{{ asset('libs/baokim/js/sidebar.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.7.2/dist/sweetalert2.all.min.js"></script>
<style>
    .none_active{
        overflow-x: hidden;
    }
</style>

<script>
    @if(session('success') || session('error'))
        alert('{{ session('success') ?? session('error') }}');
    @endif
</script>

@stack('script')

<!-- Facebook Pixel Code -->
<script>
  !function(f,b,e,v,n,t,s)
  {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
  n.callMethod.apply(n,arguments):n.queue.push(arguments)};
  if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
  n.queue=[];t=b.createElement(e);t.async=!0;
  t.src=v;s=b.getElementsByTagName(e)[0];
  s.parentNode.insertBefore(t,s)}(window, document,'script',
  'https://connect.facebook.net/en_US/fbevents.js');
  fbq('init', '615615385862949');
  fbq('track', 'PageView');
</script>
<noscript><img height="1" width="1" style="display:none"
  src="https://www.facebook.com/tr?id=615615385862949&ev=PageView&noscript=1"
/></noscript>
<!-- End Facebook Pixel Code -->
</body>
</html>
