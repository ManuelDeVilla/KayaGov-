<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Members</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    @vite(['resources/css/admin/staff-list.css', 'resources/css/admin/admin-sidebar.css', 'resources/css/header.css'])
</head>
<body>
    @include('includes.header')
    @include('includes.admin-sidebar')
    <div class="container staff-list-container">
        <p class="staff-list-title">List of Users</p>

        <div class="staff-list-controls">
            <div class="search-bar">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" id="staff-search-input" placeholder="Search name or email...">
            </div>

            <div class="staff-list-filter">
                <label for="filter-usertype">User Type</label>
                <select id="filter-usertype">
                    <option value="">All Types</option>
                    <option value="citizen">Citizen</option>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>

                <label for="filter-province">Province</label>
                <select id="filter-province">
                    <option value="">All Provinces</option>
                    @foreach ($provinces as $province)
                        <option value="{{ $province->id }}">{{ $province->province }}</option>
                    @endforeach
                </select>

                <label for="filter-city">City</label>
                <select id="filter-city">
                    <option value="">All Cities</option>
                </select>
            </div>
        </div>

        <div class="staff-list-table-wrapper">
            <table class="staff-list-table">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Gender</th>
                        <th>Type</th>
                        <th>Province</th>
                        <th>City</th>
                        <th>Joined</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="staff-list-body">
                    @forelse($staffMembers as $index => $staff)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $staff->username }}</td>
                            <td>{{ $staff->email }}</td>
                            <td>{{ $staff->gender }}</td>
                            <td>{{ ucfirst($staff->usertype) }}</td>
                            <td>{{ $staff->province->province ?? '-' }}</td>
                            <td>{{ $staff->city->city ?? '-' }}</td>
                            <td>{{ $staff->created_at ? $staff->created_at->format('M d, Y') : '-' }}</td>
                            <td>
                                <button class="delete-user-btn" data-id="{{ $staff->id }}">Delete</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="no-staff">No users found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <script>
            const staff_list_url = "{{ route('staff-lists') }}"
            const list_city_by_province = "{{ route('show.create-concern') }}"
            const delete_user_url_base = "{{ url('admin/user/delete') }}" // e.g. /admin/user/delete/{id}
            const csrf_token = "{{ csrf_token() }}"
        </script>
    @vite('resources/js/admin/staff-list.js')
</body>
</html>