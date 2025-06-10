<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Members</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/admin/staff-list.css', 'resources/css/admin/admin-sidebar.css', 'resources/css/includes/header.css'])
</head>
<body>
    @include('includes.header')
    @include('includes.admin-sidebar')
    <div class="container staff-list-container">
        <h2 class="staff-list-title">Staff Members</h2>
        <div class="staff-list-table-wrapper">
            <table class="staff-list-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Province</th>
                        <th>City</th>
                        <th>Joined</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($staffMembers as $index => $staff)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $staff->username }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>{{ $staff->gender }}</td>
                            <td>{{ $staff->province->province}}</td>
                            <td>{{ $staff->city->city}}</td>
                            <td>{{ $staff->created_at ? $staff->created_at->format('M d, Y') : '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="no-staff">No staff members found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>
