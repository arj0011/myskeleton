@if($errors->any())
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
        @foreach ($errors->all() as $error)
            <ul><li>{{ $error }}</li></ul>
        @endforeach
    </div>
@endif

@if(Session::has('success'))
    <div class="alert alert-success alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
            {{Session::get('success')}}
    </div> 
@endif

@if(Session::has('failed'))
    <div class="alert alert-danger alert-dismissible">
        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">x</a>
        {{Session::get('failed')}}
    </div> 
@endif