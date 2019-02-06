@extends('layouts.master')
@section('title','Edit User')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Permissions
        <small>Create Permission</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Permissions</a></li>
        <li class="active">Create Permission</li>
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
            {{ Form::open(array('url' => 'admin/store-permission')) }}

              <div class="form-group">
                  {{ Form::label('name', 'Name') }}
                  {{ Form::text('name', '', array('class' => 'form-control')) }}
              </div>
              @if(!$roles->isEmpty())
                  <h4>Assign Permission to Roles</h4>

                  @foreach ($roles as $role) 
                      {{ Form::checkbox('roles[]',  $role->id ) }}
                      {{ Form::label($role->name, ucfirst($role->name)) }}<br>
                  @endforeach
              @endif
              <br>
              {{ Form::submit('Add', array('class' => 'btn btn-primary')) }}

            {{ Form::close() }}
              </div>
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
