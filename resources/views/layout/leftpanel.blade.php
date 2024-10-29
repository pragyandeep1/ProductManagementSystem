<!-- Sidebar -->
<ul class="navbar-nav sidebar sidebar-dark accordion" id="accordionSidebar">

    <a class="sidebar-brand d-flex align-items-center justify-content-sm-start" href="{{ url('/') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <!-- <i class="fas fa-laugh-wink"></i> -->
            <img src="{{ asset('img/logo-icon.webp') }}" alt="img" class="img-fluid">
        </div>
        <div class="sidebar-brand-text mx-2">Sailorcom</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ request()->is('/') ? 'active' : '' }}">
        <a class="nav-link" href="{{ url('/') }}">
            <i class="fa-solid fa-house"></i>
            <span>Dashboard</span></a>
    </li>

    <li class="nav-item {{ request()->is(['projects', 'taskgroups', 'scheduled_maintenance', 'work_orders']) ? 'active' : '' }}">
        <a class="nav-link {{ request()->is(['projects', 'taskgroups', 'scheduled_maintenance', 'work_orders']) ? '' : 'collapsed' }}"
            href="#" data-bs-toggle="collapse" data-bs-target="#maintenance"
            aria-expanded="{{ request()->is(['projects', 'taskgroups', 'scheduled_maintenance', 'work_orders']) ? 'true' : 'false' }}"
            aria-controls="maintenance">
            <i class="fa-solid fa-tools"></i>
            <span>Maintenance</span>
        </a>
        <ul id="maintenance"
            class="collapse collapse-inner rounded {{ request()->is(['projects', 'taskgroups', 'scheduled_maintenance', 'work_orders']) ? '' : '' }}"
            aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
            <li class="collapse-item">
                <div class="subhead">Maintenance</div>
            </li>
            
            <li class="collapse-item {{ request()->is(['work_orders']) ? 'active-class' : '' }}">
                @canany(['read-order', 'create-order', 'edit-order', 'delete-order'])
                    <a href="{{ route('orders.index') }}"><i class="fa-solid fa-wrench"></i> Work Orders</a>
                @endcanany
            </li>
            <li class="collapse-item {{ request()->is(['scheduled_maintenance']) ? 'active-class' : '' }}">
                @canany(['read-maintenance', 'create-maintenance', 'edit-maintenance', 'delete-maintenance'])
                    <a href="{{ route('maintenance.index') }}"><i class="fa-solid fa-hotel"></i> Scheduled Maintenance</a>
                @endcanany
            </li>
            {{--<li class="collapse-item {{ request()->is(['tasks']) ? 'active-class' : '' }}">
                @canany(['read-task', 'create-task', 'edit-task', 'delete-task'])
                    <a href="{{ route('tasks.index') }}"><i class="fa-solid fa-screwdriver"></i> Task Groups</a>
                @endcanany
            </li>
            <li class="collapse-item {{ request()->is(['projects']) ? 'active-class' : '' }}">
                @canany(['read-project', 'create-project', 'edit-project', 'delete-project'])
                    <a href="{{ route('projects.index') }}"><i class="fa-solid fa-cogs"></i> Projects</a>
                @endcanany
            </li>--}}
        </ul>
    </li>

    <li class="nav-item {{ request()->is(['tools', 'equipments', 'facilities', 'assets']) ? 'active' : '' }}">
        <a class="nav-link {{ request()->is(['tools', 'equipments', 'facilities', 'assets']) ? '' : 'collapsed' }}"
            href="#" data-bs-toggle="collapse" data-bs-target="#assets"
            aria-expanded="{{ request()->is(['tools', 'equipments', 'facilities', 'assets']) ? 'true' : 'false' }}"
            aria-controls="assets">
            <i class="fa-solid fa-toolbox"></i>
            <span>Assets</span>
        </a>
        <ul id="assets"
            class="collapse collapse-inner rounded {{ request()->is(['tools', 'equipments', 'facilities', 'assets']) ? '' : '' }}"
            aria-labelledby="headingUtilities" data-bs-parent="#accordionSidebar">
            <li class="collapse-item">
                <div class="subhead">Assets</div>
            </li>
            <li class="collapse-item {{ request()->is(['assets']) ? 'active-class' : '' }}">
                @canany(['read-asset', 'create-asset', 'edit-asset', 'delete-asset'])
                    <a href="{{ route('assets.index') }}"><i class="fa-solid fa-truck-ramp-box"></i> All
                        Assets</a>
                @endcanany
            </li>
            <li class="collapse-item {{ request()->is(['facilities']) ? 'active-class' : '' }}">
                @canany(['read-facility', 'create-facility', 'edit-facility', 'delete-facility'])
                    <a href="{{ route('facilities.index') }}"><i class="fa-solid fa-warehouse"></i> Manage Facilities</a>
                @endcanany
            </li>
            <li class="collapse-item {{ request()->is(['equipments']) ? 'active-class' : '' }}">
                @canany(['read-equipment', 'create-equipment', 'edit-equipment', 'delete-equipment'])
                    <a href="{{ route('equipments.index') }}"><i class="fa-solid fa-people-carry-box"></i> Manage Equipments</a>
                @endcanany
            </li>
            <li class="collapse-item {{ request()->is(['tools']) ? 'active-class' : '' }}">
                @canany(['read-tools', 'create-tools', 'edit-tools', 'delete-tools'])
                    <a href="{{ route('tools.index') }}"><i class="fa-solid fa-screwdriver-wrench"></i> Manage Tools</a>
                @endcanany
            </li>
        </ul>
    </li>
    <li class="nav-item {{ request()->is(['supplies', 'stocks', 'businesses']) ? 'active' : '' }}">
        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#supplies" aria-expanded="false"
            aria-controls="supplies">
            <i class="fa-solid fa-truck-moving"></i>
            <span>Supplies</span>
        </a>
        <ul id="supplies" class="collapse collapse-inner rounded" aria-labelledby="headingUtilities"
            data-bs-parent="#accordionSidebar">
            <li class="collapse-item">
                <div class="subhead">Supplies</div>
            </li>
            <li class="collapse-item {{ request()->is(['supplies']) ? 'active-class' : '' }}">
                @canany(['read-supply', 'create-supply', 'edit-supply', 'delete-supply'])
                    <a href="{{ route('supplies.index') }}"><i class="fa-solid fa-truck-ramp-box"></i> Parts And Supplies</a>
                @endcanany
            </li>

            <li class="collapse-item {{ request()->is(['stocks']) ? 'active-class' : '' }}">
                @canany(['read-stock', 'create-stock', 'edit-stock', 'delete-stock'])
                    <a href="{{ route('stocks.index') }}"><i class="fa-solid fa-layer-group"></i> Current Stock</a>
                @endcanany
            </li>
            {{-- <li class="collapse-item"> --}}
            {{-- @canany(['read-product', 'create-product', 'edit-product', 'delete-product']) --}}
            {{-- <a href=""><i class="fa-solid fa-sliders"></i> Batch Stock Adjustment</a> --}}
            {{-- @endcanany --}}
            {{-- </li> --}}
            {{-- <li class="collapse-item"> --}}
            {{-- @canany(['read-position', 'create-position', 'edit-position', 'delete-position']) --}}
            {{-- <a href=""><i class="fa-solid fa-file-lines"></i> Bill Of Materials Groups</a> --}}
            {{-- @endcanany --}}
            {{-- </li> --}}
            <li class="collapse-item {{ request()->is(['businesses']) ? 'active-class' : '' }}">
                @canany(['read-business', 'create-business', 'edit-business', 'delete-business'])
                    <a href="{{ route('businesses.index') }}"><i class="fa-solid fa-building"></i> Businessess</a>
                @endcanany
            </li>
        </ul>
    </li>
    <li class="nav-item {{ request()->is(['users', 'roles', 'positions']) ? 'active' : '' }}">
        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#settings" aria-expanded="false"
            aria-controls="settings">
            <i class="fa-solid fa-gear"></i>
            <span>Settings</span>
        </a>
        <ul id="settings" class="collapse collapse-inner rounded" aria-labelledby="headingUtilities"
            data-bs-parent="#accordionSidebar">
            <li class="collapse-item">
                <div class="subhead">Settings</div>
            </li>
            <li class="collapse-item {{ request()->is(['users']) ? 'active-class' : '' }}">
                @canany(['read-user', 'create-user', 'edit-user', 'delete-user'])
                    <a href="{{ route('users.index') }}"><i class="bi bi-people"></i> Manage
                        Users</a>
                @endcanany
            </li>

            <li class="collapse-item {{ request()->is(['roles']) ? 'active-class' : '' }}">
                @canany(['read-role', 'create-role', 'edit-role', 'delete-role'])
                    <a href="{{ route('roles.index') }}"><i class="fa-solid fa-user-tie"></i> Manage
                        Roles</a>
                @endcanany
            </li>
            <li class="collapse-item {{ request()->is(['positions']) ? 'active-class' : '' }}">
                @canany(['read-position', 'create-position', 'edit-position', 'delete-position'])
                    <a href="{{ route('positions.index') }}"><i class="fa-solid fa-user-plus"></i> Manage
                        Positions</a>
                @endcanany
            </li>
            {{-- <li class="collapse-item {{ request()->is(['positions']) ? 'active-class' : '' }}">
                @canany(['read-position', 'create-position', 'edit-position', 'delete-position'])
                    <a href="{{ route('positions.index') }}"><i class="fa-solid fa-user-plus"></i> Manage
                        All Lists</a>
                @endcanany
            </li> --}}
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="#" data-bs-toggle="collapse" data-bs-target="#managelists" aria-expanded="false"
            aria-controls="managelists">
            <i class="fa-solid fa-rectangle-list"></i>
            <span>Manage Lists</span>
        </a>
        <ul id="managelists" class="collapse collapse-inner rounded" aria-labelledby="headingUtilities"
            data-bs-parent="#accordionSidebar">
            <li class="collapse-item">
                <div class="subhead">Manage Lists</div>
            </li>
            <li class="collapse-item">
                <a href="{{ route('category.index') }}"><i class="fa-solid fa-layer-group"></i>
                    Asset Category</a>
            </li>
            <li class="collapse-item">
                <a href="{{ route('account.index') }}"><i class="fa-solid fa-file-invoice"></i>
                    Asset Account
                </a>
            </li>
            <li class="collapse-item">
                <a href="{{ route('charge.index') }}"><i class="fa-solid fa-file-invoice-dollar"></i>
                    Asset Charge
                    Department
                </a>
            </li>
            <li class="collapse-item">
                <a href="{{ route('meter.index') }}"><i class="fa-solid fa-chart-line"></i>
                    Meter Reading
                    Units
                </a>
            </li>
            <li class="collapse-item">
                <a href="{{ route('currency.index') }}"><i class="fa-solid fa-wallet"></i></i>
                    Currency Units
                </a>
            </li>
            <li class="collapse-item">
                <a href="{{ route('businessclassification.index') }}"><i class="fa-solid fa-briefcase"></i>
                    Business
                    Classification
                </a>
            </li>
        </ul>
    </li>
    <hr class="sidebar-divider my-0">

    <li class="nav-item">
        <a class="nav-link dropdown-item" href="{{ route('logout') }}"
            onclick="event.preventDefault();
    document.getElementById('logout-form').submit();">
            <i class="fa-solid fa-power-off" style="color: #53b6f0;"></i>
            <span class=""> {{ __('Log Off') }}</span> </a>
    </li>
    <div class="text-center d-none d-md-inline mt-4">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">
