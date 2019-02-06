@extends('layouts.master')
@section('title','Edit Teacher')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Teachers
        <small>Ceate Teacher</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Teachers</a></li>
        <li class="active">Create Teacher</li>
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
            <!-- form start -->
            {{ Form::open(array('url'=>'admin/store-teacher')) }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputName">Name</label>
                  <input type="text" value="" name="name" class="form-control" id="exampleInputName" placeholder="Name">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" name="email" value="" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{url('admin/teachers')}}" class="btn btn-default">Cancel</a>
              </div>
            {{Form::close()}}
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
