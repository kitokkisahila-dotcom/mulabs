<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">
    <title>Technician Dashboard</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
    href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/labtechnician-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-common.css') }}?v=drawer-expand-1">
    <script src="{{ asset('js/table-pagination.js') }}?v=10-per-page-1" defer></script>
    <script src="{{ asset('js/navigation-drawer.js') }}?v=1" defer></script>

</head>

<body class="dashboard-layout technician-dashboard-page">




@php
    use Illuminate\Support\Facades\Auth;

    $profileUser = Auth::user();

    $profileImage = ($profileUser && !empty($profileUser->image))
        ? asset('storage/'.$profileUser->image)
        : null;

    $profileInitials = strtoupper(
        substr($profileUser->first_name ?? '',0,1).
        substr($profileUser->last_name ?? '',0,1)
    );
@endphp

<!-- TOP HEADER--->

<header class="topbar">

    <div class="topbar-left">
        <button type="button" class="drawer-toggle" data-drawer-toggle aria-label="Toggle navigation menu" aria-expanded="true"><i class="fa-solid fa-bars"></i></button>
        <div class="page-title">
            <h1>Dashboard</h1>
        </div>
    </div>

    <div class="header-right">

        <div class="profile-dropdown">

            <button type="button"
                    class="profile-button"
                    aria-expanded="false"
                    aria-controls="profileMenu"
                    onclick="toggleProfileDropdown()">

                @if($profileImage)

                    <img src="{{ $profileImage }}" class="profile-photo">

                @else

                    <div class="profile-photo initials">
                        {{ $profileInitials }}
                    </div>

                @endif

                <div class="profile-details">

                    <span class="profile-name">
                        {{ $profileUser->first_name }}
                        {{ $profileUser->last_name }}
                    </span>

                    <small class="profile-role">
                        {{ ucfirst($profileUser->role ?? 'User') }}
                    </small>

                </div>

                <i class="fa-solid fa-chevron-down profile-arrow"></i>

            </button>

            <!-- Dropdown -->

            <div class="profile-menu" id="profileMenu" role="menu" aria-label="Account menu">

                <div class="menu-header">

                    @if($profileImage)

                        <img src="{{ $profileImage }}" class="menu-photo">

                    @else

                        <div class="menu-photo initials">
                            {{ $profileInitials }}
                        </div>

                    @endif

                    <div>

                        <h4>
                            {{ $profileUser->first_name }}
                            {{ $profileUser->last_name }}
                        </h4>

                        <p>{{ $profileUser->email }}</p>

                    </div>

                </div>

                <div class="menu-divider"></div>

                <a href="{{ route('profile.index') }}" role="menuitem">

                    <i class="fa-solid fa-user"></i>

                    <span>My Profile</span>

                </a>

                <form action="{{ route('logout') }}" method="POST">

                    @csrf

                    <button type="submit" role="menuitem">

                        <i class="fa-solid fa-right-from-bracket"></i>

                        <span>Logout</span>

                    </button>

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

            <li class="active" data-target="section-dashboard">
                <a href="javascript:;">
                    <i class="fa-solid fa-house"></i>
                    Dashboard
                </a>
            </li>

            <li data-target="section-laboratories">
                <a href="javascript:;">
                    <i class="fa-solid fa-computer"></i>
                    Laboratories
                </a>
            </li>
            <li data-target="section-devices">
                <a href="javascript:;">
                    <i class="fa-solid fa-computer"></i>
                    Devices
                </a>
            </li>
            <li data-target="section-reports">
                <a href="javascript:;">
                    <i class="fa-solid fa-file"></i>
                    Reports
                </a>
            </li>

            <li data-target="section-generate">
                <a href="javascript:;">
                    <i class="fa-solid fa-pen-to-square"></i>
                    Generate Reports
                </a>
            </li>

        </ul>

    </aside>

    <!-- Main Content -->
    <main class="main-content">

       

        <!-- Cards -->
        <div class="cards-row">

            <div class="card labs" data-target="section-laboratories">
                <div>
                    <h2>{{ $labsCount ?? 0 }}</h2>
                    <p>Laboratories</p>
                </div>

                <div class="icon">
                    <i class="fa-solid fa-computer"></i>
                </div>
            </div>
            <div class="card devices" data-target="section-devices">
                <div>
                    <h2>{{ $devicesCount ?? 0 }}</h2>
                    <p>Devices</p>
                </div>

                <div class="icon">
                    <i class="fa-solid fa-desktop"></i>
                </div>
            </div>
            <div class="card reports" data-target="section-reports">
                <div>
                    <h2>{{ $reportsCount ?? 0 }}</h2>
                    <p>Reports</p>
                </div>

                <div class="icon">
                    <i class="fa-solid fa-file"></i>
                </div>
            </div>

            <div class="card generate" data-target="section-generate">
                <div>
                    <h2>+</h2>
                    <p>Generate Report</p>
                </div>

                <div class="icon">
                    <i class="fa-solid fa-pen-to-square"></i>
                </div>
            </div>

        </div>

        <!-- Panel Content -->
        <section class="panel-content">
            <div id="section-devices" class="panel-section">
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

            <!-- Laboratories -->
            <div id="section-laboratories" class="panel-section">

                <h2>All Laboratories</h2>

                <p style="text-align:center; margin-bottom:20px; color:#475569;">Click a laboratory card to view its devices, reports, and quick registration form in the centered detail panel below.</p>
                <div class="cards-row">
                    @foreach($labs as $lab)
                    <div class="card lab-card" onclick="showDevices('{{ $lab->block_code }}', this)">
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

                @foreach($labs as $lab)
                <div id="lab-{{ $lab->block_code }}" class="lab-devices lab-detail-panel" style="display:none; margin-top:20px;">
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
                                    <h2>{{ $reports->filter(fn($report) => optional($report->device->laboratory)->block_code === $lab->block_code)->count() }}</h2>
                                    <p>Reports</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-file-lines"></i>
                                </div>
                            </div>
                            <div class="card report-form" data-target="report-form">
                                <div>
                                    <h2></h2>
                                    <p>Report Device</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </div>
                            </div>
                            <div class="card generate" data-target="registration">
                                <div>
                                    <h2></h2>
                                    <p>Register Device</p>
                                </div>
                                <div class="icon">
                                    <i class="fa-solid fa-plus"></i>
                                </div>
                            </div>
                        </div>
                        <div class="lab-detail-content">
                            <div class="lab-section" data-target="devices">
                                <div class="section-block">
                                    <h4>Devices Found in {{ $lab->block_name }}</h4>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Reg No</th>
                                                <th>Device</th>
                                                <th>Brand</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                               
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($lab->device as $device)
                                            <tr>
                                                <td>{{ $device->reg_no }}</td>
                                                <td>{{ $device->device_name }}</td>
                                                <td>{{ $device->brand }}</td>
                                                <td data-device-status="{{ $device->reg_no }}">{{ $device->status }}</td>
                                                <td>
                                                    <a href="{{ route('technician.devices.edit', $device->id) }}">Edit</a>
                                                    <form action="{{ route('technician.devices.destroy', $device->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" onclick="return confirm('Delete device?')">Delete</button>
                                                    </form>
                                                </td>
                                               
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5">No Devices Found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="lab-section" data-target="reports" style="display:none;">
                                <div class="section-block">
                                    <h4>Reports For {{ $lab->block_name }}</h4>
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
                                            @forelse($reports->filter(fn($report) => optional($report->device->laboratory)->block_code === $lab->block_code) as $report)
                                            <tr class="report-row" data-report-id="{{ $report->id }}">
                                                <td>{{ $report->device->device_name ?? $report->device_reg_no }}</td>
                                                <td>{{ $report->device->laboratory->block_name ?? 'N/A' }}</td>
                                                <td>{{ $report->description }}</td>
                                                <td>{{ $report->created_at->format('Y-m-d') }}</td>
                                                <td><span class="status-badge report-status" data-report-status="{{ $report->id }}" style="background: {{ $report->status === 'Resolved' ? '#16a34a' : '#dc2626' }};">{{ $report->status === 'Resolved' ? 'Resolved' : 'Faulty' }}</span></td>
                                                <td>
                                                    <form action="{{ route('technician.reports.toggleStatus', $report->id) }}" method="POST">
                                                        @csrf
                                                        <button type="submit" class="action-btn {{ $report->status === 'Resolved' ? 'not-resolve' : 'resolve' }}">
                                                            {{ $report->status === 'Resolved' ? 'Mark Faulty' : 'Resolve' }}
                                                        </button>
                                                    </form>
                                                </td>
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5">No Reports Found</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="lab-section" data-target="report-form" style="display:none;">
                                <div class="section-block">
                                    <h4>Report an Issue In {{ $lab->block_name }}</h4>
                                    <form class="report-submit-form admin-report-form" action="{{ route('technician.reports.store') }}" method="POST">
                                        @csrf
                                        <div class="report-form-group">
                                            <label for="device-{{ $lab->block_code }}">Select Device</label>
                                            <input id="device-{{ $lab->block_code }}" name="device_reg_no" list="devices-{{ $lab->block_code }}" placeholder="Search or select a registration number" required>
                                            <datalist id="devices-{{ $lab->block_code }}">
                                                @foreach($lab->device as $device)
                                                    <option value="{{ $device->reg_no }}" label="{{ $device->device_name }}"></option>
                                                @endforeach
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
                                    <h4>Register Device In {{ $lab->block_name }}</h4>
                                    <form action="{{ route('devicereg') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="block_code" value="{{ $lab->block_code }}">
                                        <div style="margin-bottom:15px;">
                                            <input type="text" name="reg_no" placeholder="Registration Number" required style="width:100%;padding:12px;">
                                        </div>
                                        <div style="margin-bottom:15px;">
                                            <input type="text" name="device_name" placeholder="Device Name" required style="width:100%;padding:12px;">
                                        </div>
                                        <div style="margin-bottom:15px;">
                                            <input type="text" name="brand" placeholder="Brand" required style="width:100%;padding:12px;">
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

            <!-- Reports -->
            <div id="section-reports" class="panel-section">

                <h2>View Reports</h2>

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
                        @forelse($reports as $report)
                            <tr class="report-row" data-report-id="{{ $report->id }}">
                                <td>{{ $report->device->device_reg_no ?? $report->device_reg_no }}</td>
                                <td>{{ $report->device->laboratory->block_name ?? 'N/A' }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($report->description, 75) }}</td>
                                <td>{{ $report->created_at->format('Y-m-d') }}</td>
                                <td>
                                    <span class="status-badge" data-report-status="{{ $report->id }}" style="background: {{ $report->status === 'Resolved' ? '#16a34a' : '#dc2626' }};">
                                        {{ $report->status === 'Resolved' ? 'Resolved' : 'Faulty' }}
                                    </span>
                                </td>
                                <td>
                                    <form action="{{ route('technician.reports.toggleStatus', $report->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="action-btn {{ $report->status === 'Resolved' ? 'not-resolve' : 'resolve' }}">
                                            {{ $report->status === 'Resolved' ? 'Mark Faulty' : 'Resolve' }}
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="5">No reports found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Generate Reports -->
            <div id="section-generate" class="panel-section">

                <h2>Generate Report</h2>

                    <form id="generate-report-form" class="report-submit-form" action="{{ route('technician.reports.store') }}"
                        method="POST">

                    @csrf

                    <div style="margin-bottom:15px;">

                        <label>Device</label><br><br>

                        <input name="device_reg_no" list="all-devices"
                                required
                                placeholder="Search or select a registration number"
                                style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px;">
                        <datalist id="all-devices">
                            @foreach($devices as $device)
                                <option value="{{ $device->reg_no }}" label="{{ $device->device_name }}"></option>
                            @endforeach
                        </datalist>

                    </div>

                    <div style="margin-bottom:15px;">

                        <label>Description</label><br><br>

                        <textarea name="description"
                                  rows="6"
                                  style="width:100%; padding:12px; border:1px solid #cbd5e1; border-radius:8px;"
                                  required></textarea>

                    </div>

                    <button type="submit" class="btn btn-report">
                        Generate Report
                    </button>


                </form>

            </div>
        </section>

        <section class="embedded-page-panel" id="dashboardWorkspace" aria-live="polite">
            <div class="embedded-page-toolbar">
                <div>
                    <p class="workspace-eyebrow">Dashboard workspace</p>
                    <h2 id="workspaceTitle">Open page</h2>
                </div>
                <button type="button" class="workspace-close" aria-label="Return to dashboard">
                    <i class="fa-solid fa-arrow-left"></i>
                    Dashboard
                </button>
            </div>
            <iframe class="embedded-page-frame" title="Dashboard workspace"></iframe>
        </section>

    </main>
</div>

<script>

    // Embed reports data for client-side checks (no DB calls)
    const reportsData = @json($reports->map(fn($r) => ['id' => $r->id, 'device_reg_no' => $r->device_reg_no, 'status' => $r->status]));

    const cards = document.querySelectorAll('.card[data-target]');
    const sidebarItems = document.querySelectorAll('.menu li[data-target]');
    const sections = document.querySelectorAll('.panel-section');
    function revealFromHeader(element) {
        requestAnimationFrame(() => element?.scrollIntoView({ behavior: 'smooth', block: 'start' }));
    }

    function showSection(target){

        if (target === 'section-dashboard') {
            sections.forEach(section => section.classList.remove('active'));
            sidebarItems.forEach(item => {
                item.classList.toggle('active', item.dataset.target === target);
            });
            document.querySelector('.main-content').classList.remove('has-selected-panel');
            revealFromHeader(document.querySelector('.dashboard-heading'));
            return;
        }

        sections.forEach(section => {
            section.classList.toggle('active', section.id === target);
        });

        sidebarItems.forEach(item => {
            item.classList.toggle('active', item.dataset.target === target);
        });

        document.querySelector('.main-content').classList.add('has-selected-panel');
        revealFromHeader(document.getElementById(target));
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

    const reportForms = document.querySelectorAll('.report-submit-form');
    reportForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const select = form.querySelector('[name="device_reg_no"]');
            const errorContainer = form.querySelector('.report-error-message');
            if (!select || !errorContainer) return;

            const selected = select.value.trim();
            const existing = reportsData.find(r => r.device_reg_no === selected && r.status !== 'Resolved');
            if (existing) {
                e.preventDefault();
                errorContainer.textContent = 'This device already has an active (unresolved) report. Please wait until it is resolved before creating another report.';
                errorContainer.style.display = 'block';
                form.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                errorContainer.style.display = 'none';
            }
        });
    });

</script>
   

<script>
document.addEventListener('DOMContentLoaded', function () {
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
function toggleProfileDropdown(){
    const menu = document.getElementById('profileMenu');
    const button = document.querySelector('.profile-button');
    const isOpen = menu.classList.toggle('show');
    button.setAttribute('aria-expanded', String(isOpen));

}

document.addEventListener("click",function(e){

    const dropdown=document.querySelector(".profile-dropdown");

    if(!dropdown.contains(e.target)){
        const menu = document.getElementById('profileMenu');
        menu.classList.remove('show');
        document.querySelector('.profile-button').setAttribute('aria-expanded', 'false');

    }

});

document.addEventListener('keydown', function (event) {
    if (event.key === 'Escape') {
        document.getElementById('profileMenu').classList.remove('show');
        document.querySelector('.profile-button').setAttribute('aria-expanded', 'false');
    }
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
            mainContent.classList.remove('has-selected-panel');
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

