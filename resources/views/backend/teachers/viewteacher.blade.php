<div class="row">
  <div class="col-sm-6">
    <label>Name</label>
    <p>{{ $userData['name'] }}</p>
  </div>
  <div class="col-sm-6">    
    <label>Email</label>
    <p>{{ $userData['email'] }}</p>
  </div>
  <div class="col-sm-6">
    <label>Status</label>
    <p><label class="{{($userData['status'] == 1) ? 'label label-success' : 'label label-danger'}}">{{ ($userData['status'] == 1) ? 'Active' : 'Deactive' }}</label></p>
  </div>
  <div class="col-sm-6">    
    <label>Created At</label>
    <p>{{ date('d-m-Y H:i:s',strtotime($userData['created_at'])) }}</p>
  </div>
</div>