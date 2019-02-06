@extends('layouts.master')
@section('title','Edit User')
@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        Users
        <small>Edit User</small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
        <li><a href="#">Users</a></li>
        <li class="active">Edit User</li>
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
            {{ Form::open(array('url'=>'admin/updateUser')) }}
              <div class="box-body">
                <div class="form-group">
                  <label for="exampleInputName">Name</label>
                  <input type="text" value="{{$user->name}}" name="name" class="form-control" id="exampleInputName" placeholder="Name">
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email address</label>
                  <input type="email" name="email" value="{{$user->email}}" class="form-control" id="exampleInputEmail1" placeholder="Enter email">
                </div>
                <div class="form-group">
                  <label for="exampleInputStatus">Status</label>
                  <select class="form-control" name="status" id="exampleInputStatus" placeholder="Select Status">
                    <option value="1" {{ ($user->status == 1) ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ ($user->status == 0) ? 'selected' : '' }}>Deactive</option>
                  </select>
                </div>
                @role('superadmin')
                <div class='form-group'>
                  @foreach ($roles as $role)
                      {{-- {{ Form::radio('roles',  $role->id,$user->role ) }} --}}
                      <input type="radio" name="roles" value="{{ $role->id }}" {{ ($role->id == $user->role) ? 'checked' : '' }} data-check="{{ $user->role }}" >
                      {{ Form::label($role->name, ucfirst($role->name)) }}<br>
                  @endforeach
                </div>
                @endrole
                {{-- <div class="form-group">
                  <label for="exampleInputPassword1">Password</label>
                  <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">File input</label>
                  <input type="file" id="exampleInputFile">

                  <p class="help-block">Example block-level help text here.</p>
                </div>
                <div class="checkbox">
                  <label>
                    <input type="checkbox"> Check me out
                  </label>
                </div> --}}
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="hidden" name="user_id" value="{{encrypt($user->id)}}">
                <button type="submit" class="btn btn-primary">Submit</button>
                <a href="{{url('admin/users')}}" class="btn btn-default">Cancel</a>
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
