<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
     <meta http-equiv="Pragma" content="no-cache">
     <meta http-equiv="Expires" content="0">

    <title>Admin Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}?v=compact-users-table-1">
    <link rel="stylesheet" href="{{ asset('css/dashboard-common.css') }}?v=drawer-expand-1">
    <script src="{{ asset('js/table-pagination.js') }}?v=10-per-page-1" defer></script>
    <script src="{{ asset('js/navigation-drawer.js') }}?v=1" defer></script>

</head>

<body class="admin-dashboard dashboard-layout">

@if(session('success'))
    <div class="dashboard-toast" role="status">{{ session('success') }}</div>
@endif

@php
    $profileUser = Auth::user();
    $profileInitials = strtoupper(substr($profileUser->first_name ?? '', 0, 1) . substr($profileUser->last_name ?? '', 0, 1));
    $profileImage = $profileUser->image ? asset('storage/' . $profileUser->image) : null;
@endphp

<header class="topbar">
    <div class="topbar-left">
        <button type="button" class="drawer-toggle" data-drawer-toggle aria-label="Toggle navigation menu" aria-expanded="true"><i class="fa-solid fa-bars"></i></button>
        <div class="page-title"><h1>Dashboard</h1></div>
    </div>
    <div class="header-right">
        <div class="profile-dropdown">
            <button type="button" class="profile-button" aria-expanded="false" aria-controls="adminProfileMenu">
                @if($profileImage)
                    <img src="{{ $profileImage }}" alt="{{ $profileUser->first_name }} {{ $profileUser->last_name }}" class="profile-photo">
                @else
                    <span class="profile-photo initials">{{ $profileInitials }}</span>
                @endif
                <span class="profile-details">
                    <span class="profile-name">{{ $profileUser->first_name }} {{ $profileUser->last_name }}</span>
                    <span class="profile-role">Administrator</span>
                </span>
                <i class="fa-solid fa-chevron-down profile-arrow"></i>
            </button>
            <div class="profile-menu" id="adminProfileMenu" role="menu" aria-label="Account menu">
                <div class="menu-header">
                    @if($profileImage)
                        <img src="{{ $profileImage }}" alt="{{ $profileUser->first_name }} {{ $profileUser->last_name }}" class="menu-photo">
                    @else
                        <span class="menu-photo initials">{{ $profileInitials }}</span>
                    @endif
                    <div>
                        <h4>{{ $profileUser->first_name }} {{ $profileUser->last_name }}</h4>
                        <p>{{ $profileUser->email }}</p>
                    </div>
                </div>
                <div class="menu-divider"></div>
                <a href="{{ route('profile.index') }}" role="menuitem"><i class="fa-solid fa-user"></i> My Profile</a>
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" role="menuitem"><i class="fa-solid fa-right-from-bracket"></i> Logout</button>
                </form>
            </div>
        </div>
    </div>
</header>

<div class="dashboard technician-dashboard">

    <!-- Sidebar -->
    <aside class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-computer"></i>
            <h2>MU-LABS</h2>
        </div>
        <ul class="menu">

    <li class="active" data-target="section-welcome">
        <a href="javascript:;">
            <i class="fa-solid fa-house"></i>
            Dashboard
        </a>
    </li>

    <li data-target="section-users">
        <a href="javascript:;">
            <i class="fa-solid fa-users"></i>
            User Management
        </a>
    </li>

    <li data-target="section-labs" onclick="showSection('section-labs')">
        <a href="javascript:;">
            <i class="fa-solid fa-computer"></i>
            Laboratories Management
        </a>
    </li>

    <li data-target="section-technicians">
        <a href="javascript:;">
            <i class="fa-solid fa-user-tie"></i>
            Technicians management
        </a>
    </li>

    <li data-target="section-faculties">
        <a href="javascript:;">
            <i class="fa-solid fa-building-columns"></i>
            Faculties Management
        </a>
    </li>

    <li data-target="section-programs">
        <a href="javascript:;">
            <i class="fa-solid fa-graduation-cap"></i>
            Programs Management
        </a>
    </li>

    <li data-target="section-departments">
        <a href="javascript:;">
            <i class="fa-solid fa-building"></i>
            Departments Management
        </a>
    </li>

        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content is-dashboard-home">

        <!-- Cards -->
        <div class="cards-row">

            <!-- Users -->
            <div class="card users" data-target="section-users">
                <div>
                    <h2>{{ $usersCount ?? 0 }}</h2>
                    <p>Users Management</p>
                </div>

                <div class="icon">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <!-- Laboratories -->
            <div class="card labs" data-target="section-labs">
                <div>
                    <h2>{{ $labsCount ?? 0 }}</h2>
                    <p>Laboratories Management</p>
                </div>

                <div class="icon">
                    <i class="fa-solid fa-computer"></i>
                </div>
            </div>
            <div class="card devices" data-target="section-devices">
                <div>
                    <h2>{{ $devicesCount ?? 0 }}</h2>
                    <p>Devices Management</p>
                </div>

                <div class="icon">
                    <i class="fa-solid fa-desktop"></i>
                </div>
            </div>
            <!-- Technicians -->
            <div class="card technician" data-target="section-technicians">
                <div>
                    <h2>{{ count($technicians ?? []) }}</h2>
                    <p>Technicians Management</p>
                </div>

                <div class="icon">
                    <i class="fa-solid fa-user-tie"></i>
                </div>
            </div>
            <!-- Faculties -->
            <div class="card faculty" data-target="section-faculties">
                <div>
                    <h2>{{ $facultiesCount ?? 0 }}</h2>
                    <p>Faculties Management</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-building-columns"></i>
                </div>
            </div>
            <div class="card devices" data-target="section-programs">
                <div>
                    <h2>{{ $programsCount ?? 0 }}</h2>
                    <p>Programs Management</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-graduation-cap"></i>
                </div>
            </div>
          
            <div class="card devices" data-target="section-departments">
                <div>
                    <h2>{{ $departmentsCount ?? 0 }}</h2>
                    <p>Departments Management</p>
                </div>
                <div class="icon">
                    <i class="fa-solid fa-building"></i>
                </div>
            
            </div>
        </div>

        
        <!-- Panel Content -->
        <section class="panel-content" style="display: none;">
            <div id="section-devices" class="panel-section" style="display: none;">
                <h2>All Devices</h2>
                <table>
                    <thead>
                        <tr>
                            <th>Reg Number</th>
                            <th>Device Name</th>
                            <th>Brand</th>
                            <th>Laboratory</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($devices as $device)
                            <tr>
                                <td>{{ $device->reg_no }}</td>
                                <td>{{ $device->device_name }}</td>
                                <td>{{ $device->brand }}</td>
                                <td>{{ $device->laboratory->block_name ?? 'N/A' }}</td>
                                <td data-device-status="{{ $device->reg_no }}">{{ $device->status }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5">No devices found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Users -->
            <div id="section-users" class="panel-section" style="display: none;">
                   <table>
                    <thead>
                        <tr>
                            <th>Registration No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Role</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($user as $item)
                        <tr>
                            <td>{{ $item->registration_no }}</td>
                            <td>{{ $item->first_name }} {{ $item->last_name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>{{ $item->role }}</td>
                            <td>
                                <a href="{{ route('admin.users.edit', $item->id) }}">Edit</a>
                                <form action="{{ route('admin.users.destroy', $item->id) }}" method="POST" style="display:inline; margin-left:8px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this user?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Laboratory Technicians -->
            <div id="section-technicians" class="panel-section" style="display: none;">

                <h2>Laboratory Technicians</h2>

                <div style="margin-bottom:30px;">
                    <a href="{{ route('technician.form') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add New Technician
                    </a>
                </div>

                <table>

                    <thead>
                        <tr>
                            <th>Registration No</th>
                            <th>Name</th>
                            <th>Email</th>
                           
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($technicians ?? [] as $tech)

                        <tr>

                            <td><strong>{{ $tech->registration_no ?? 'N/A' }}</strong></td>

                            <td>{{ $tech->first_name ?? '' }} {{ $tech->last_name ?? '' }}</td>

                            <td>{{ $tech->email ?? 'N/A' }}</td>

                           

                           

                            <td>

                                <a href="{{ route('admin.users.edit', $tech->id ?? '#') }}">
                                    <i class="fa-solid fa-edit"></i> Edit
                                </a>

                                <form action="{{ route('admin.users.destroy', $tech->id ?? '#') }}"
                                      method="POST"
                                      style="display:inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit" onclick="return confirm('Delete technician?')" style="padding:8px 12px; font-size:12px;">
                                        <i class="fa-solid fa-trash"></i> Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="6" style="text-align:center; padding:40px; color:#999;">

                                <i class="fa-solid fa-inbox" style="font-size:32px; margin-bottom:15px; display:block;"></i>

                                No technicians registered yet.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

<!-- Laboratories -->
<div id="section-labs" class="panel-section" style="display: none;">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; gap:14px; flex-wrap:wrap;">
        <h2>Laboratories</h2>
        <a href="{{ route('laboratoryreg') }}" class="btn btn-primary">
            <i class="fa-solid fa-plus"></i> Register Laboratory
        </a>
    </div>

    
    <!-- Laboratory Cards -->
    <div class="cards-row">
        @foreach($labs as $lab)
        <div class="card lab-card"
             onclick="showDevices('{{ $lab->block_code }}', this)">
            <div>
                <h3>{{ $lab->block_name }}</h3>
                <p>Code: {{ $lab->block_code }}</p>
                <p>Capacity: {{ $lab->capacity }}</p>
            </div>
            <div class="icon">
                <i class="fa-solid fa-computer"></i>
            </div>
        </div>
        @endforeach
    </div>
    <!-- Devices for each Laboratory -->
    @foreach($labs as $lab)
    <div id="lab-{{ $lab->block_code }}"
         class="lab-devices"
         style="display:none; margin-top:20px;">
        <div class="lab-detail-card">
            <h3>{{ $lab->block_name }}</h3>
            <div class="cards-row" style="margin-bottom:20px;">
                <div class="card devices" data-target="devices">
                    <div>
                        <h2>{{ $lab->device->count() }}</h2>
                        <p>Devices</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-computer"></i>
                    </div>
                </div>
                <div class="card reports" data-target="reports">
                    <div>
                       <h2>{{ $reports->filter(fn($report) => $report->device?->laboratory?->block_code === $lab->block_code)->count() }}</h2>
                        <p>Reports</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-file-lines"></i>
                    </div>
                </div>
                <div class="card report-form" data-target="report-form">
                    <div>
                        <h2>!</h2>
                        <p>Report Device</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </div>
                </div>
                <div class="card generate" data-target="registration">
                    <div>
                        <h2>+</h2>
                        <p>Register Device</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-plus"></i>
                    </div>
                </div>
            </div>
            <div class="lab-detail-content">
                <div class="lab-section" data-target="devices" style="display:block;">
                    <div class="section-block">
                        <h4>Devices in {{ $lab->block_name }}</h4>
                        <table>
                            <thead>
                                <tr>
                                    <th>Reg No</th>
                                    <th>Device Name</th>
                                    <th>Brand</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($lab->device as $dev)
                                <tr>
                                    <td>{{ $dev->reg_no }}</td>
                                    <td>{{ $dev->device_name }}</td>
                                    <td>{{ $dev->brand }}</td>
                                    <td data-device-status="{{ $dev->reg_no }}">{{ $dev->status }}</td>
                                    <td>
                                        <a href="{{ route('admin.devices.edit', $dev->id) }}">Edit</a>
                                        <form action="{{ route('admin.devices.destroy', $dev->id) }}"
                                              method="POST"
                                              style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Delete device?')">Delete</button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="lab-section" data-target="reports" style="display:none;">
                    <div class="section-block">
                        <h4>Reports for {{ $lab->block_name }}</h4>
                        @php
    $labReports = $reports->filter(function ($report) use ($lab) {
        return $report->device !== null
            && $report->device->laboratory !== null
            && $report->device->laboratory->block_code === $lab->block_code;
    });
@endphp
                        @if($labReports->isEmpty())
                            <p>No reports found for this laboratory.</p>
                        @else
                            <table>
                                <thead>
                                    <tr>
                                        <th>Device</th>
                                        <th>Laboratory</th>
                                        <th>Description</th>
                                        <th>Date</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($labReports as $report)
                                    <tr class="report-row" data-report-id="{{ $report->id }}">
                                        <td>{{ $report->device->device_name ?? $report->device_reg_no }}</td>
                                        <td>{{ $report->device->laboratory->block_name ?? 'N/A' }}</td>
                                        <td>{{ \Illuminate\Support\Str::limit($report->description, 90) }}</td>
                                        <td>{{ $report->created_at->format('Y-m-d') }}</td>
                                        <td><span class="status-badge report-status" data-report-status="{{ $report->id }}" style="background: {{ $report->status === 'Resolved' ? '#16a34a' : '#dc2626' }};">{{ $report->status === 'Resolved' ? 'Resolved' : 'Faulty' }}</span></td>
                                        <td>
                                            <form action="{{ route('admin.reports.toggleStatus', $report->id) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="action-btn {{ $report->status === 'Resolved' ? 'not-resolve' : 'resolve' }}">
                                                    {{ $report->status === 'Resolved' ? 'Mark Faulty' : 'Resolve' }}
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </div>
                </div>
                <div class="lab-section" data-target="report-form" style="display:none;">
                    <div class="section-block">
                        <h4>Report an Issue in {{ $lab->block_name }}</h4>
                        <form class="report-submit-form admin-report-form" action="{{ route('admin.reports.store') }}" method="POST">
                            @csrf
                            <div class="report-form-group">
                                <label for="device-{{ $lab->block_code }}">Select Device</label>
                                <input id="device-{{ $lab->block_code }}" name="device_reg_no" list="devices-{{ $lab->block_code }}" placeholder="Search or select a registration number" required>
                                <datalist id="devices-{{ $lab->block_code }}">
                                    @forelse($lab->device as $device)
                                        <option value="{{ $device->reg_no }}" label="{{ $device->device_name }}"></option>
                                    @empty
                                        <option value="" label="No devices available"></option>
                                    @endforelse
                                </datalist>
                            </div>
                            <div class="report-form-group">
                                <label for="description-{{ $lab->block_code }}">Description</label>
                                <textarea id="description-{{ $lab->block_code }}" name="description" rows="5" required></textarea>
                            </div>
                            <div class="report-error-message" style="display:none; margin-top:12px; background:#fee2e2; padding:12px; border-radius:10px; color:#991b1b;"></div>
                            <button type="submit" class="btn btn-report" {{ $lab->device->isEmpty() ? 'disabled' : '' }}>Submit Report</button>
                        </form>
                    </div>
                </div>
                <div class="lab-section" data-target="registration" style="display:none;">
                    <div class="section-block">
                        <h4>Register Device in {{ $lab->block_name }}</h4>
                        <form action="{{ route('devicereg') }}" method="POST">
                            @csrf
                            <input type="hidden" name="block_code" value="{{ $lab->block_code }}">
                            <div style="margin-bottom:15px;">
                                <input type="text" name="reg_no" placeholder="Registration Number" required style="width:100%;padding:12px;border:1px solid #cbd5e1;border-radius:8px;">
                            </div>
                            <div style="margin-bottom:15px;">
                                <input type="text" name="device_name" placeholder="Device Name" required style="width:100%;padding:12px;border:1px solid #cbd5e1;border-radius:8px;">
                            </div>
                            <div style="margin-bottom:15px;">
                                <input type="text" name="brand" placeholder="Brand" required style="width:100%;padding:12px;border:1px solid #cbd5e1;border-radius:8px;">
                            </div>
                            <button type="submit" class="btn btn-report">Register Device</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach

</div>

            <!-- Programs -->
            <div id="section-programs" class="panel-section" style="display: none;">

                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; gap:14px; flex-wrap:wrap;">
                    <h2>Programs</h2>
                    <a href="{{ route('programreg') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add New Program
                    </a>
                </div>

                <table>

                    <thead>
                        <tr>
                            <th>Program ID</th>
                            <th>Name</th>
                            <th>Faculty</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($programs as $program)
                        <tr>
                            <td>{{ $program->program_id }}</td>
                            <td>{{ $program->program_name }}</td>
                            <td>{{ $program->faculty->faculty_name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.programs.edit', $program->id) }}">Edit</a>
                                <form action="{{ route('admin.programs.destroy', $program->id) }}" method="POST" style="display:inline; margin-left:8px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this program?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>

            <!-- Departments -->
            <div id="section-departments" class="panel-section" style="display: none;">
                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; gap:14px; flex-wrap:wrap;">
                    <h2>Departments</h2>
                    <a href="{{ route('departmentreg') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add New Department
                    </a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <th>Department ID</th>
                            <th>Name</th>
                            <th>Faculty</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($departments as $department)
                        <tr>
                            <td>{{ $department->department_id }}</td>
                            <td>{{ $department->department_name }}</td>
                            <td>{{ $department->faculty->faculty_name ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('admin.departments.edit', $department->id) }}">Edit</a>
                                <form action="{{ route('admin.departments.destroy', $department->id) }}" method="POST" style="display:inline; margin-left:8px;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" onclick="return confirm('Delete this department?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="4" style="text-align:center;">No departments registered yet.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Faculties -->
            <div id="section-faculties" class="panel-section" style="display: none;">

                <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:24px; gap:14px; flex-wrap:wrap;">
                    <h2>Faculties</h2>
                    <a href="{{ route('facultyreg') }}" class="btn btn-primary">
                        <i class="fa-solid fa-plus"></i> Add New Faculty
                    </a>
                </div>

                <table>

                    <thead>
                        <tr>
                            <th>Faculty ID</th>
                            <th>Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($faculties as $faculty)

                        <tr>

                            <td>{{ $faculty->faculty_id }}</td>

                            <td>{{ $faculty->faculty_name }}</td>

                            <td>

                                <a href="{{ route('admin.faculties.edit', $faculty->id) }}">
                                    Edit
                                </a>

                                <form action="{{ route('admin.faculties.destroy', $faculty->id) }}"
                                      method="POST"
                                      style="display:inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                        onclick="return confirm('Delete faculty?')">
                                        Delete
                                    </button>

                                </form>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </section>

        <section class="embedded-page-panel" id="dashboardWorkspace" aria-live="polite">
            <div class="embedded-page-toolbar">
                <div>
                    <p class="workspace-eyebrow">Dashboard workspace</p>
                    <h2 id="workspaceTitle">Open page</h2>
                </div>
                <button type="button" class="workspace-close" aria-label="Return to dashboard"><i class="fa-solid fa-arrow-left"></i> Dashboard</button>
            </div>
            <iframe class="embedded-page-frame" title="Dashboard workspace"></iframe>
        </section>

    </main>

</div>
 
<script>

    const cards = document.querySelectorAll('.card[data-target]');
    const sidebarItems = document.querySelectorAll('.menu li[data-target]');
    const sections = document.querySelectorAll('.panel-section');

    function revealFromHeader(element) {
        requestAnimationFrame(() => element?.scrollIntoView({ behavior: 'smooth', block: 'start' }));
    }

    function showSection(target){

        sections.forEach(section => {
            const isSelected = section.id === target;
            section.classList.toggle('active', isSelected);
            section.style.display = isSelected ? 'block' : 'none';
        });

        sidebarItems.forEach(item => {
            item.classList.toggle('active', item.dataset.target === target);
        });

        const mainContent = document.querySelector('.main-content');
        const panelContent = document.querySelector('.panel-content');
        const hasSelectedPanel = target !== 'section-welcome';

        mainContent.classList.toggle('has-selected-panel', hasSelectedPanel);
        mainContent.classList.toggle('is-dashboard-home', !hasSelectedPanel);
        panelContent.style.display = hasSelectedPanel ? 'block' : 'none';
        revealFromHeader(hasSelectedPanel ? document.getElementById(target) : document.querySelector('.cards-row'));
    }

    function showLabSection(panel, target) {
        panel.querySelectorAll('.lab-section').forEach(section => {
            section.hidden = true;
            section.style.display = 'none';
        });
        const section = panel.querySelector(`.lab-section[data-target="${target}"]`);
        if (section) {
            section.hidden = false;
            section.style.display = 'block';
            revealFromHeader(section);
        }
    }

    cards.forEach(card => {
        card.addEventListener('click', () => {
            const labPanel = card.closest('.lab-devices');
            if (labPanel) {
                showLabSection(labPanel, card.dataset.target);
            } else {
                showSection(card.dataset.target);
            }
        });
    });

    sidebarItems.forEach(item => {
        item.addEventListener('click', () => {
            showSection(item.dataset.target);
        });
    });

    function showDevices(labCode, element)
    {
        document.querySelectorAll('.lab-devices')
            .forEach(section => section.style.display = 'none');

        const panel = document.getElementById('lab-' + labCode);
        panel.style.display = 'block';
        showLabSection(panel, 'devices');

        document.querySelectorAll('.lab-card')
            .forEach(card => card.classList.remove('active'));

        element.classList.add('active');
        revealFromHeader(panel);
    }

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('toggle-status-btn')) {
            e.preventDefault();
            e.stopPropagation();

            const btn = e.target;
            const row = btn.closest('.report-row');
            const statusBadge = row.querySelector('.status-badge');

            if (btn.textContent.trim() === 'Resolve') {
                statusBadge.textContent = 'Resolved';
                statusBadge.style.background = '#16a34a';
                btn.textContent = 'Not Resolve';
                btn.style.background = '#ea580c';
            } else {
                statusBadge.textContent = 'Faulty';
                statusBadge.style.background = '#dc2626';
                btn.textContent = 'Resolve';
                btn.style.background = '#2563eb';
            }
        }
    });

</script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // This legacy listener is intentionally disabled; the dashboard handler above
    // manages the selected panel and the centred workspace.
    return;
    const mainContent = document.querySelector('.admin-dashboard .main-content');
    const panels = document.querySelectorAll('.admin-dashboard .panel-section');
    const cards = document.querySelectorAll('.admin-dashboard .cards-row .card[data-target]');
    const navigationItems = document.querySelectorAll('.admin-dashboard .menu li[data-target]');

    function openPanel(targetId, selectedItem) {
        const selectedPanel = document.getElementById(targetId);
        if (!selectedPanel) return;

        panels.forEach(panel => panel.style.display = 'none');
        selectedPanel.style.display = 'block';
        mainContent.classList.add('has-selected-panel');

        navigationItems.forEach(item => item.classList.toggle('active', item === selectedItem));
    }

    panels.forEach(panel => panel.style.display = 'none');

    navigationItems.forEach(item => {
        item.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            openPanel(item.dataset.target, item);
        }, true);
    });

    cards.forEach(card => {
        card.addEventListener('click', function (event) {
            event.preventDefault();
            event.stopPropagation();
            openPanel(card.dataset.target, document.querySelector('.admin-dashboard .menu li[data-target="' + card.dataset.target + '"]'));
        }, true);
    });
});
</script>

<script>
    function showDashboardToast(message) {
        document.querySelector('.dashboard-toast')?.remove();

        const toast = document.createElement('div');
        toast.className = 'dashboard-toast';
        toast.setAttribute('role', 'status');
        toast.textContent = message;
        document.body.appendChild(toast);

        window.setTimeout(() => toast.classList.add('is-hiding'), 3000);
        window.setTimeout(() => toast.remove(), 3400);
    }

    document.querySelectorAll('form[action*="/admin/users/"]').forEach((form) => {
        if (!form.querySelector('input[name="_method"][value="DELETE"]')) return;

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const response = await fetch(form.action, {
                method: 'POST',
                body: new FormData(form),
                headers: { Accept: 'application/json' },
            });

            if (!response.ok) {
                showDashboardToast('Unable to delete the user. Please try again.');
                return;
            }

            document.querySelectorAll(`form[action="${form.action}"]`).forEach((matchingForm) => {
                matchingForm.closest('tr')?.remove();
            });
            showDashboardToast('User deleted successfully');
        });
    });

    document.querySelectorAll('.dashboard-toast').forEach((toast) => {
        window.setTimeout(() => toast.classList.add('is-hiding'), 3000);
        window.setTimeout(() => toast.remove(), 3400);
    });

    const deviceStatusesUrl = '{{ route('devices.statuses') }}';

    async function refreshSharedStatuses() {
        try {
            const response = await fetch(deviceStatusesUrl, {
                headers: { 'Accept': 'application/json' },
                cache: 'no-store',
            });
            if (!response.ok) return;

            const { devices, reports } = await response.json();
            document.querySelectorAll('[data-device-status]').forEach((element) => {
                element.textContent = devices[element.dataset.deviceStatus] ?? 'Resolved';
            });
            document.querySelectorAll('[data-report-status]').forEach((element) => {
                const status = reports[element.dataset.reportStatus];
                if (!status) return;
                element.textContent = status;
                element.style.background = status === 'Resolved' ? '#16a34a' : '#dc2626';
            });
        } catch (error) {
            // A temporary connection issue must not interrupt dashboard use.
        }
    }

    setInterval(refreshSharedStatuses, 5000);
</script>
<script>
    document.querySelectorAll('.profile-dropdown').forEach((dropdown) => {
        const button = dropdown.querySelector('.profile-button');
        const menu = dropdown.querySelector('.profile-menu');
        button.addEventListener('click', () => {
            const isOpen = menu.classList.toggle('show');
            button.setAttribute('aria-expanded', String(isOpen));
        });
        document.addEventListener('click', (event) => {
            if (!dropdown.contains(event.target)) {
                menu.classList.remove('show');
                button.setAttribute('aria-expanded', 'false');
            }
        });
        document.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                menu.classList.remove('show');
                button.setAttribute('aria-expanded', 'false');
            }
        });
    });
</script>
<script>
    function setupDashboardWorkspace() {
        const workspace = document.getElementById('dashboardWorkspace');
        const mainContent = document.querySelector('.main-content');
        const frame = workspace?.querySelector('.embedded-page-frame');
        const title = workspace?.querySelector('#workspaceTitle');
        const closeButton = workspace?.querySelector('.workspace-close');
        if (!workspace || !mainContent || !frame || !title || !closeButton) return;

        const openWorkspace = (link) => {
            const url = new URL(link.href, window.location.href);
            if (url.origin !== window.location.origin || url.pathname === window.location.pathname) return;
            const label = link.textContent.replace(/\s+/g, ' ').trim();
            title.textContent = label || 'Dashboard page';
            frame.src = url.href;
            mainContent.classList.remove('has-selected-panel', 'is-dashboard-home');
            mainContent.classList.add('has-embedded-page');
            requestAnimationFrame(() => workspace.scrollIntoView({ behavior: 'smooth', block: 'start' }));
        };

        document.addEventListener('click', (event) => {
            const link = event.target.closest('.profile-menu a[href], .main-content a[href]');
            if (!link || link.target || link.hasAttribute('download') || link.href.startsWith('javascript:')) return;
            event.preventDefault();
            openWorkspace(link);
        });

        closeButton.addEventListener('click', () => {
            frame.removeAttribute('src');
            mainContent.classList.remove('has-embedded-page');
            document.querySelector('.dashboard-heading, .cards-row')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
        });
    }

    setupDashboardWorkspace();
</script>
</body>
</html>

