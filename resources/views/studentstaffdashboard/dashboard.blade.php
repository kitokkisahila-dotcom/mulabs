<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate">
    <meta http-equiv="Pragma" content="no-cache">
    <meta http-equiv="Expires" content="0">

    <title>Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/student-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/dashboard-common.css') }}?v=drawer-expand-1">
    <script src="{{ asset('js/table-pagination.js') }}?v=10-per-page-1" defer></script>
    <script src="{{ asset('js/navigation-drawer.js') }}?v=1" defer></script>
</head>
<body class="student-dashboard dashboard-layout">

@php
    $profileUser = Auth::user();
    $profileInitials = strtoupper(substr($profileUser->first_name ?? '', 0, 1) . substr($profileUser->last_name ?? '', 0, 1));
    $profileImage = $profileUser->image ? asset('storage/' . $profileUser->image) : null;
@endphp

<header class="topbar">
    <div class="topbar-left">
        <button type="button" class="drawer-toggle" data-drawer-toggle aria-label="Toggle navigation menu" aria-expanded="true"><i class="fa-solid fa-bars"></i></button>
        <div class="page-title"><h1> Dashboard</h1></div>
    </div>
    <div class="header-right">
        <div class="profile-dropdown">
            <button type="button" class="profile-button" aria-expanded="false" aria-controls="studentProfileMenu">
                @if($profileImage)
                    <img src="{{ $profileImage }}" alt="{{ $profileUser->first_name }} {{ $profileUser->last_name }}" class="profile-photo">
                @else
                    <span class="profile-photo initials">{{ $profileInitials }}</span>
                @endif
                <span class="profile-details">
                    <span class="profile-name">{{ $profileUser->first_name }} {{ $profileUser->last_name }}</span>
                    <span class="profile-role">{{ ucfirst($profileUser->role ?? 'User') }}</span>
                </span>
                <i class="fa-solid fa-chevron-down profile-arrow"></i>
            </button>
            <div class="profile-menu" id="studentProfileMenu" role="menu" aria-label="Account menu">
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
    <aside class="sidebar">
        <div class="logo">
            <i class="fa-solid fa-computer"></i>
            <h2>MU-LABS</h2>
        </div>
        <ul class="menu">
            <li class="active" data-target="overview"><a href="javascript:;"><i class="fa-solid fa-house"></i>Dashboard</a></li>
            <li data-target="computer-labs"><a href="javascript:;"><i class="fa-solid fa-computer"></i> Computer Labs</a></li>
            <li data-target="devices"><a href="javascript:;"><i class="fa-solid fa-computer"></i> Devices</a></li>
            <li data-target="reports"><a href="javascript:;"><i class="fa-solid fa-file-lines"></i> My Reports</a></li>
            <li data-target="report-form"><a href="javascript:;"><i class="fa-solid fa-pen-to-square"></i> Report Device</a></li>
        </ul>
    </aside>
    <main class="main-content">
        

        @if(session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif
         <div class="cards-row">
            <div class="card labs" data-target="computer-labs">
                <div>
                    <h2>{{ $computerLabs->count() }}</h2>
                    <p>Computer Labs</p>
                </div>
                <div class="icon"><i class="fa-solid fa-building-columns"></i></div>
            </div>

            <div class="card devices" data-target="devices">
                <h2>{{ $devices->count() }}</h2>
                  <p>Devices</p>
                <div class="icon"><i class="fa-solid fa-computer"></i>
               
            </div>
           
            </div>

            <div class="card reports" data-target="reports">
                <div>
                    <h2>{{ $reports->count() }}</h2>
                    <p>My Reports</p>
                </div>
                <div class="icon"><i class="fa-solid fa-file-chart-column"></i></div>
            </div>
        </div>

        <section class="section panel" id="computer-labs" style="display:none;">
            <h2>Computer Laboratory Devices</h2>
            <div class="cards-row">
                @foreach($computerLabs as $lab)
                <div class="card lab-card" onclick="showDevices('{{ $lab->block_code }}', this)">
                    <div>
                        <h3>{{ $lab->block_name }}</h3>
                        <p>Code: {{ $lab->block_code }}</p>
                        <p>Capacity: {{ $lab->capacity ?? 'N/A' }}</p>
                    </div>
                    <div class="icon">
                        <i class="fa-solid fa-computer"></i>
                    </div>
                </div>
                @endforeach
            </div>
            @foreach($computerLabs as $lab)
            <div id="lab-{{ $lab->block_code }}" class="lab-devices" style="display:none; margin-top:20px;">
                <div class="lab-detail-card">
                    <h3>{{ $lab->block_name }}</h3>
                    <div class="cards-row" style="margin-bottom:20px;">
                        <div class="card devices" data-target="devices">
                            <div>
                                <h2>{{ $lab->device->count() }}</h2>
                                <p>Devices</p>
                            </div>
                            <div class="icon"><i class="fa-solid fa-computer"></i></div>
                        </div>
                        <div class="card reports" data-target="reports">
                            <div>
                                <h2>{{ $reports->filter(fn($report) => $report->device?->laboratory?->block_code === $lab->block_code)->count() }}</h2>
                                <p>Reports</p>
                            </div>
                            <div class="icon"><i class="fa-solid fa-file-lines"></i></div>
                        </div>
                        <div class="card generate" data-target="report-form">
                            <div>
                                <h2>+</h2>
                                <p>Generate Report</p>
                            </div>
                            <div class="icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
                        </div>
                    </div>
                    <div class="lab-detail-content">
                        <div class="lab-section" data-target="devices" style="display:block;">
                            <div class="section-block">
                                <h4>Devices in {{ $lab->block_name }}</h4>
                                <table>
                                    <thead>
                                        <tr><th>Reg Number</th><th>Device Name</th><th>Brand</th><th>Status</th></tr>
                                    </thead>
                                    <tbody>
                                        @foreach($lab->device as $device)
                                        <tr>
                                            <td>{{ $device->reg_no }}</td>
                                            <td>{{ $device->device_name }}</td>
                                            <td>{{ $device->brand }}</td>
                                            <td data-device-status="{{ $device->reg_no }}">{{ $device->status }}</td>
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
                                    $labReports = $laboratoryReports->filter(fn($report) => $report->device?->laboratory?->block_code === $lab->block_code);
                                @endphp
                                @if($labReports->isEmpty())
                                    <p>No reports found for this laboratory.</p>
                                @else
                                    <table>
                                        <thead>
                                            <tr><th>Device</th><th>Laboratory</th><th>Description</th><th>Date</th><th>Status</th></tr>
                                        </thead>
                                        <tbody>
                                            @foreach($labReports as $report)
                                            <tr class="report-row" data-report-id="{{ $report->id }}">
                                                <td>{{ $report->device?->device_name ?? $report->device_reg_no }}</td>
                                                <td>{{ $report->device?->laboratory?->block_name ?? 'N/A' }}</td>
                                                <td>{{ \Illuminate\Support\Str::limit($report->description, 90) }}</td>
                                                <td>{{ $report->created_at->format('Y-m-d') }}</td>
                                                <td><span class="status-badge report-status" data-report-status="{{ $report->id }}" style="background: {{ $report->status === 'Resolved' ? '#16a34a' : '#dc2626' }};">{{ $report->status === 'Resolved' ? 'Resolved' : 'Faulty' }}</span></td>
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
                                <form class="report-submit-form admin-report-form" action="{{ route('student.reports.store') }}" method="POST">
                                    @csrf
                                    <div class="report-form-group">
                                        <label for="device_reg_no_{{ $lab->block_code }}">Select Device</label>
                                        <input name="device_reg_no" id="device_reg_no_{{ $lab->block_code }}" list="devices-{{ $lab->block_code }}" placeholder="Search or select a registration number" required>
                                        <datalist id="devices-{{ $lab->block_code }}">
                                            @foreach($lab->device as $device)
                                                <option value="{{ $device->reg_no }}" label="{{ $device->device_name }}"></option>
                                            @endforeach
                                        </datalist>
                                    </div>
                                    <div class="report-form-group">
                                        <label for="description_{{ $lab->block_code }}">Description</label>
                                        <textarea name="description" id="description_{{ $lab->block_code }}" rows="5" required></textarea>
                                    </div>
                                    <div class="report-error-message" style="display:none; margin-top:12px; background:#fee2e2; padding:12px; border-radius:10px; color:#991b1b;"></div>
                                    <button type="submit" class="btn btn-report" {{ $lab->device->isEmpty() ? 'disabled' : '' }}>Submit Report</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </section>
        <section class="section panel" id="devices" style="display:none;">
            <h2>All Devices</h2>
            <table>
                <thead>
                    <tr><th>Reg Number</th><th>Device Name</th><th>Brand</th><th>Lab</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @foreach($devices as $device)
                        <tr>
                            <td>{{ $device->reg_no }}</td>
                            <td>{{ $device->device_name }}</td>
                            <td>{{ $device->brand }}</td>
                            <td>{{ $device->laboratory->block_name ?? 'N/A' }}</td>
                            <td data-device-status="{{ $device->reg_no }}">{{ $device->status }}</td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
        <section class="section panel" id="reports" style="display:none;">
            <h2>My Reports</h2>
            <table>
                <thead>
                    <tr><th>Device</th><th>Laboratory</th><th>Description</th><th>Date</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse($reports as $report)
                        <tr class="report-row" data-report-id="{{ $report->id }}">
                            <td>{{ $report->device?->device_name ?? $report->device_reg_no }}</td>
                            <td>{{ $report->device?->laboratory?->block_name ?? 'N/A' }}</td>
                            <td>{{ \Illuminate\Support\Str::limit($report->description, 90) }}</td>
                            <td>{{ $report->created_at->format('Y-m-d') }}</td>
                            <td><span class="status-badge report-status" data-report-status="{{ $report->id }}" style="background: {{ $report->status === 'Resolved' ? '#16a34a' : '#dc2626' }};">{{ $report->status === 'Resolved' ? 'Resolved' : 'Faulty' }}</span></td>
                        </tr>
                    @empty
                        <tr><td colspan="5">No reports yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </section>
        <section class="section panel" id="report-form" style="display:none;">
            <h2>Report a Device</h2>
            <form class="report-submit-form admin-report-form" action="{{ route('student.reports.store') }}" method="POST">
                @csrf
                <div class="report-form-group">
                    <label for="device_reg_no">Select Device</label>
                    <input name="device_reg_no" id="device_reg_no" list="all-devices" placeholder="Search or select a registration number" required>
                    <datalist id="all-devices">
                        @foreach($deviceOptions as $device)
                        <option value="{{ $device->reg_no }}" label="{{ $device->device_name }} - {{ $device->laboratory?->block_name ?? 'No Lab' }}"></option>
                        @endforeach
                    </datalist>
                </div>
                <div class="report-form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="5" required></textarea>
                </div>
                <div class="report-error-message" style="display:none; margin-top:12px; background:#fee2e2; padding:12px; border-radius:10px; color:#991b1b;"></div>
                <button type="submit" class="btn btn-report" {{ $deviceOptions->isEmpty() ? 'disabled' : '' }}>Submit Report</button>
            </form>
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
    const reportsData = @json($reports->map(fn($r) => ['id' => $r->id, 'device_reg_no' => $r->device_reg_no, 'status' => $r->status]));
    const cards = document.querySelectorAll('.card[data-target]');
    const targets = document.querySelectorAll('.menu li[data-target]');
    const sections = document.querySelectorAll('.section.panel');
    function revealFromHeader(element) {
        requestAnimationFrame(() => element?.scrollIntoView({ behavior: 'smooth', block: 'start' }));
    }
    function show(target) {
        sections.forEach(section => {
            section.style.display = section.id === target ? 'block' : 'none';
            section.classList.toggle('is-selected', section.id === target);
        });
        targets.forEach(item => {
            item.classList.toggle('active', item.dataset.target === target);
        });
        document.querySelector('.main-content').classList.toggle('has-selected-panel', target !== 'overview');
        revealFromHeader(target === 'overview' ? document.querySelector('.dashboard-heading') : document.getElementById(target));
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
                show(card.dataset.target);
            }
        });
    });
    targets.forEach(item => {
        item.addEventListener('click', () => show(item.dataset.target));
    });
    function showDevices(labCode, element){
        document.querySelectorAll('.lab-devices').forEach(section => section.style.display = 'none');
        const panel = document.getElementById('lab-' + labCode);
        panel.style.display = 'block';
        showLabSection(panel, 'devices');
        document.querySelectorAll('.lab-card').forEach(card => card.classList.remove('active'));
        element.classList.add('active');
        revealFromHeader(panel);
    }

    const reportForms = document.querySelectorAll('.report-submit-form');
    reportForms.forEach(form => {
        form.addEventListener('submit', function(e) {
            const select = form.querySelector('[name="device_reg_no"]');
            const errorContainer = form.querySelector('.report-error-message');
            if (!select || !errorContainer) return;

            const selectedDevice = select.value.trim();
            const active = reportsData.find(r => r.device_reg_no === selectedDevice && r.status !== 'Resolved');
            if (active) {
                e.preventDefault();
                errorContainer.textContent = 'This device already has an active (unresolved) report. Please wait until it is resolved before creating another report';
                errorContainer.style.display = 'block';
                return;
            }
            if (errorContainer) {
                errorContainer.style.display = 'none';
            }
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

