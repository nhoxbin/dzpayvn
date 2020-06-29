@extends('layouts.app')
@section('title', 'Đăng ký tài khoản')
@section('payment-body')
<div class="payment-body main_df_bt">
    <div id="loading-icon" style="display: none;">
        <img src="{{ asset('libs/baokim/images/loading.gif') }}">
    </div>
    <div class="row">
        <div class="col-xs-12">
            <form method="POST" autocomplete="off" id="reg-form" novalidate="novalidate">
                @csrf
                <input type="hidden" name="ref" value="{{ request()->ref }}">
                <div class="col-xs-12 input-block">
                    <input class="" type="text" value="" required="" name="name">
                    <label for="" alt="Họ và tên" placeholder="Họ và tên"></label>
                    
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-12 input-block">
                    <input class="" type="text" value="" required="" name="email" autocomplete="off">
                    <label for="" alt="Email của bạn" placeholder="Email của bạn"></label>
                    <center><img class="small-loading-icon hide" src="{{ asset('libs/baokim/images/loading.gif') }}"></center>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-12 input-block">
                    <input class="" type="text" value="" required name="phone">
                    <label for="" alt="Số điện thoại di động của bạn" placeholder="Số điện thoại di động của bạn"></label>
                    <center><img class="small-loading-icon hide" src="{{ asset('libs/baokim/images/loading.gif') }}"></center>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-12 input-block">
                    <input autocomplete="off" type="password" required name="password">
                    <label for="" alt="Mật khẩu" placeholder="Mật khẩu"></label>
                    
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-12 input-block">
                    <input autocomplete="off" type="password" required name="password_confirmation">
                    <label for="" alt="Xác nhận mật khẩu" placeholder="Xác nhận mật khẩu"></label>
                    
                    <div class="clearfix"></div>
                </div>
            </form>
            <div class="col-xs-12">
                <div class="checkbox checkbox-primary">
                    <input id="term" name="term" type="checkbox">
                    <label for="term">
                        Tôi đồng ý với chấp thuận các <a href="#" target="_blank">cam kết và điều khoản</a>  của DZpayVN
                    </label>
                </div>
            </div>
            <center>
                <span id="policy-term-error" class="hide error">Vui lòng tích "Đồng ý" hợp đồng dịch vụ DZpayVN và điều khoản sử dụng</span>
            </center>
            <div class="col-xs-12 input-block">
                <button type="button" class="register-btn btn btn-green">Đăng ký</button>
            </div>
            
        </div>
    </div>
</div>
@endsection
@push('style')
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/baokim/css/register.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('libs/baokim/css/bootstrap-checkbox.css') }}">
@endpush
@push('script')
    <script type="text/javascript" src="{{ asset('libs/baokim/js/jquery.validate.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/baokim/js/additional-methods.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('libs/baokim/js/register.js') }}"></script>
    <script type="text/javascript">
        jQuery.validator.addMethod("confirmed", function(value, element) {
            let name = $(element).attr('name');
            name = name.substring(0, name.indexOf('_confirmation'));
            let password = $(element).parents('form').find('input[name="' + name + '"]').val();

            return this.optional(element) || value.toUpperCase() == password.toUpperCase();
        });
        jQuery.validator.addMethod("vietnamphone", function(value, element) {
            let validFirstNumber = ['09','03','05','07','08'];

            return this.optional(element) || validFirstNumber.indexOf(value[0] + value[1]) >= 0;
        });
        jQuery.validator.addMethod("exists", function(value, element, params) {
            var exists = false;
            $.ajax({
                type: 'GET',
                url : route('register.checkExists', [params, value]),
                async: false,
                beforeSend: function(){
                    $(element).siblings('center').find('.small-loading-icon').removeClass('hide');
                },
                success: function(res){
                    if (! res.error)
                        exists = res.exists;
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    var confirm = confirm('Xảy ra lỗi hệ thống, bạn có muốn tải lại trang không?');
                    if (confirm) {
                        location.reload();
                    }
                },
                complete: function() {
                    $(element).siblings('center').find('.small-loading-icon').addClass('hide');
                }
            });  

            return this.optional(element) || exists == false;
        });

        $("#reg-form").validate({
            onkeyup: false,
            ignore: ".ignore",
            errorElement: 'span',
            errorPlacement: function(error, element) {
                var placement = $(element).next();
                if (placement.length > 0) {
                    $(error).insertAfter(placement);
                } else {
                    $(error).insertAfter(element);
                }
            },
            rules: {
                name: {
                    required: true,
                    maxlength: 255,
                },
                email: {
                    required: true,
                    email: true,
                    maxlength: 50,
                    exists: 'email',
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 255,
                },
                password_confirmation: {
                    required: true,
                    confirmed: true,
                },
                phone: {
                    required: true,
                    minlength: 10,
                    maxlength: 20,
                    number: true,
                    vietnamphone: true,
                    exists: 'phone',
                },
                /*'g-recaptcha-response': {
                    required: true,
                },*/
            },
            messages: {
                name: {
                    required: 'Họ và tên không được bỏ trống',
                    maxlength: 'Họ và tên chỉ được tối đa' + ' {0} ' + 'ký tự'
                },
                email: {
                    required: 'Địa chỉ email không được bỏ trống',
                    email: 'Địa chỉ email không đúng định dạng (example@gmail.com)',
                    exists: 'Địa chỉ email đã tồn tại, vui lòng chọn địa chỉ email khác',
                    maxlength: 'Địa chỉ email chỉ được tối đa' + ' {0} ' + 'ký tự'
                },
                password: {
                    required: 'Mật khẩu không được bỏ trống',
                    minlength: jQuery.validator.format('Mật khẩu phải lớn hơn' + ' {0} ' + 'ký tự'),
                    maxlength: 'Mật khẩu chỉ được tối đa' + ' {0} ' + 'ký tự'
                },
                password_confirmation: {
                    required: 'Mật khẩu xác nhận không được bỏ trống',
                    confirmed: 'Mật khẩu xác nhận phải giống với mật khẩu',
                },
                phone: {
                    required: 'Số điện thoại không được bỏ trống',
                    number: 'Số điện thoại không được nhập chữ, ký tự',
                    minlength: jQuery.validator.format('Số điện thoại phải có ít nhất' + ' {0} ' + 'ký tự'),
                    vietnamphone: 'Số điện thoại không chính xác. Vui lòng nhập theo dạng 09... hoặc 03... hoặc 05... hoặc 07... hoặc 08...',
                    exists: 'Số điện thoại đã tồn tại, vui lòng sử dụng SĐT khác',
                    maxlength: 'Mật khẩu chỉ được tối đa' + ' {0} ' + 'ký tự'
                },
                /*'g-recaptcha-response': {
                    required: 'Bạn cần xác nhận &quot;Tôi không phải là người máy&quot;',
                },*/
            }
        });
    </script>
@endpush