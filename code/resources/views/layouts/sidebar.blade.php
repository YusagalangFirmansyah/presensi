<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="index.html">SchoolTech</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="index.html">St</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Dashboard</li>
        <li class="active"><a class="nav-link" href="{{ route('dashboard') }}"><i class="fas fa-home"></i>
                <span>Dashboard</span></a></li>
        @if (Auth::user()->role->id == '1')
            <li class="menu-header">Master Data</li>
            <li class="nav-item dropdown">
                <a href="#" class="nav-link has-dropdown" data-toggle="dropdown"><i class="fas fa-users-cog"></i>
                    <span>User</span></a>
                <ul class="dropdown-menu">
                    <li><a class="nav-link" href="{{ route('users') }}">User Management</a></li>
                    <li><a class="nav-link" href="{{ route('roles') }}">Role Management</a></li>
                </ul>
            </li>
            <li class=""><a class="nav-link" href="{{ route('categories') }}"><i class="fas fa-tag"></i>
                    <span>Category</span></a></li>
            <li class=""><a class="nav-link" href="{{ route('divisions') }}"><i class="fas fa-boxes"></i>
                    <span>Division</span></a></li>
            <li class="menu-header">Admin Menu</li>
            {{-- <li class=""><a class="nav-link" href="{{route('monitoring-absences')}}"><i class="fas fa-users"></i> <span>Monitoring Absence</span></a></li> --}}
            <li class=""><a class="nav-link" href="{{ route('admin-absences') }}"><i
                        class="fas fa-user-check"></i> <span>Absence</span></a></li>
            <li class=""><a class="nav-link" href="{{ route('admin-logbooks') }}"><i
                        class="fas fa-file-signature"></i> <span>Log Book</span></a></li>
            <li class=""><a class="nav-link" href="{{ route('admin-pengajuan') }}"><i
                        class="fas fa-file-alt"></i> <span>Request</span></a></li>
        @endif
        <li class="menu-header">Main Menu</li>
        <li class=""><a class="nav-link" href="{{ route('absences') }}"><i class="fas fa-user-check"></i>
                <span>Absence</span></a></li>
        <li class=""><a class="nav-link" href="{{ route('logbooks') }}"><i class="fas fa-file-signature"></i>
                <span>Log Book</span></a></li>
        <li class=""><a class="nav-link" href="{{ route('pengajuan') }}"><i class="fas fa-file-alt"></i>
                <span>Request</span></a></li>
        @if (Auth::user()->role->id == '1')
            <li class="menu-header">Reporting</li>
            <li class=""><a class="nav-link" href="{{ route('reportings') }}"><i class="fas fa-fire"></i>
                    <span>Reporting</span></a></li>
        @endif
    </ul>
</aside>
