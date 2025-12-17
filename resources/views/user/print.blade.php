<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Users Report - Print</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; text-align: center; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; font-weight: bold; }
        .badge { padding: 2px 6px; border-radius: 10px; font-size: 12px; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-primary { background-color: #007bff; color: white; }
    </style>
</head>
<body>
    <h1>Users Report</h1>
    <p style="text-align: center; color: #666;">
        Generated on: {{ now()->format('F d, Y h:i A') }}
    </p>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Last Login</th>
                <th>Status</th>
                @if(\Auth::user()->type == 'super admin')
                    <th>Plan</th>
                    <th>Plan Expired</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->type) }}</td>
                    <td>{{ $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : 'Never' }}</td>
                    <td>
                        @if($user->delete_status==0)
                            <span class="badge badge-danger">Inactive</span>
                        @else
                            <span class="badge badge-success">Active</span>
                        @endif
                    </td>
                    @if(\Auth::user()->type == 'super admin')
                        <td>{{ !empty($user->currentPlan) ? $user->currentPlan->name : '' }}</td>
                        <td>{{ !empty($user->plan_expire_date) ? \Auth::user()->dateFormat($user->plan_expire_date) : 'Lifetime' }}</td>
                    @endif
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>