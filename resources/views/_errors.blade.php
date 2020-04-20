@if($errors->any())
    <div class="alert alert-danger">
        <button class="close" data-dismiss="alert">
            <i class="ace-icon fa fa-times"></i>
        </button>
        @foreach($errors->all() as $message)
            <ul>
                <li>{{ $message }}</li>
            </ul>
        @endforeach
    </div>
@endif