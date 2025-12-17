<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>{{ $title ?? 'Users Report' }}</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; }
        h1 { color: #333; text-align: center; margin-bottom: 10px; }
        .report-info { text-align: center; color: #666; margin-bottom: 10px; }
        .filter-info { 
            text-align: center; 
            color: #28a745; 
            margin-bottom: 15px;
            font-weight: bold;
            padding: 5px;
            background-color: #f8f9fa;
            border-radius: 4px;
        }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f4f4f4; font-weight: bold; }
        .badge { padding: 2px 6px; border-radius: 10px; font-size: 12px; }
        .badge-success { background-color: #28a745; color: white; }
        .badge-danger { background-color: #dc3545; color: white; }
        .badge-primary { background-color: #007bff; color: white; }
        .summary { margin-bottom: 20px; padding: 10px; background-color: #f8f9fa; border-radius: 4px; }
    </style>
</head>
<body>
    <h1>{{ $title ?? 'Users Report' }}</h1>
    <div class="report-info">
        Generated on: {{ now()->format('F d, Y h:i A') }}
    </div>
    
    @if(!empty($filter_text))
    <div class="filter-info">
        {{ $filter_text }}
    </div>
    @endif
    
    <div class="summary">
        <strong>Total Records:</strong> {{ $users->count() }}
    </div>
    
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Last Login</th>
                <th>Status</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->type) }}</td>
                    <td>{{ !empty($user->last_login_at) ? $user->last_login_at : 'Never' }}</td>
                    <td>
                        @if($user->delete_status==0)
                            <span class="badge badge-danger">Inactive</span>
                        @else
                            <span class="badge badge-success">Active</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('Y-m-d H:i:s') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>