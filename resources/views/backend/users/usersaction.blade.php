@can('View User')
  <a href="javascript:void(0);" data-user_id="{{ encrypt($user->id) }}" class="btn btn-sm btn-default viewUser"><i class="fa fa-eye"></i></a>
@endcan

@can('Edit User')
  <a href="{!! url('admin/editUser/'.encrypt($user->id)) !!}" class="btn btn-sm btn-primary"><i class="fa fa-edit"></i></a>
@endcan

@can('Delete User')
  <a href="javascript:void(0);" data-user_id="{{ encrypt($user->id) }}" class="btn btn-sm btn-danger deleteUser"><i class="fa fa-trash"></i></a>
@endcan  