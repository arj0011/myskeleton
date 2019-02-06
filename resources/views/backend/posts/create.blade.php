@extends('layouts.master')
@section('title','Create Post')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Posts
        <small>Create Post</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Posts</a></li>
        <li class="active">Create Post</li>
      </ol>
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
        <!-- left column -->
        <div class="col-md-6">
          <!-- general form elements -->
          <div class="box box-primary">
            <div class="box-header with-border">
              <h3 class="box-title"></h3>
              @component('alert')
              @endcomponent
            </div>
            <!-- /.box-header -->
            <div class="box-body">
            <!-- form start -->
            {{ Form::open(array('route' => array('posts.store'),'files'=>true)) }}

              <div class="form-group">
                  {{ Form::label('title', 'Title') }}
                  {{ Form::text('title', null, array('class' => 'form-control')) }}
                  @if($errors->has('title'))
                    <span class="text-danger">{{ $errors->first('title') }}</span>
                  @endif
              </div>
              <div class="form-group">
                  {{ Form::label('content', 'Content') }}
                  {{ Form::textarea('content', null, array('class' => 'form-control')) }}
                  @if($errors->has('content'))
                    <span class="text-danger">{{ $errors->first('content') }}</span>
                  @endif
              </div>
              <div class="form-group">
                  {{ Form::label('banner_image', 'Banner Image') }}
                  {{ Form::file('banner_image', null, array('class' => 'form-control')) }}
                  @if($errors->has('banner_image'))
                    <span class="text-danger">{{ $errors->first('banner_image') }}</span>
                  @endif
              </div>
              {{ Form::submit('Submit', array('class' => 'btn btn-primary')) }}
              <a href="{{ route('posts.index') }}" class="btn btn-default">Cancel</a>
              </div>
              {{ Form::close() }}

              <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!--/.col (left) -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
@endsection
@push('scripts')
<script src="{{ asset('public/bower_components/ckeditor/ckeditor.js') }}"></script>
<script type="text/javascript">
  $(function(){
    CKEDITOR.replace('content');
  });
</script>
@endpush