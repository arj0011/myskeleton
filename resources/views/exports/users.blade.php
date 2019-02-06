<table>
    <tr>
        <th colspan="4">Users Report</th>
    </tr>
    <thead>
        <tr>
        <th><b>Name</b></th>
        <th>Email</th>
        <th>Status</th>
        <th>Created At</th>
        </tr>
    </thead>
    <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{ $user->name }}</td>
                <td>{{ $user->email }}</td>
                <td>{{ ($user->status == '1') ? 'Active' : 'Deactive' }}</td>
                <td>{{ date('d-m-Y',strtotime($user->created_at)) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>