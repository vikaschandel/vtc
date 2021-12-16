<!--sidebar wrapper -->
<div class="sidebar-wrapper" data-simplebar="true">
            <div class="sidebar-header">
                <div>
                    <img src="{{ url('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
                </div>
                <div>
                    <h4 class="logo-text">VTM</h4>
                </div>
                <div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
                </div>
            </div>
            <!--navigation-->
            <ul class="metismenu" id="menu">
                <li>
                    <a href="{{ url('dashboard') }}" class="has-arrow">
                        <div class="parent-icon"><i class='bx bx-home-circle'></i>
                        </div>
                        <div class="menu-title">Dashboard</div>
                    </a>
                </li>
                @can('create_transaction')
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon"><i class="bx bx-category"></i>
                        </div>
                        <div class="menu-title">Transaction</div>
                    </a>
                    <ul>
                        <li> <a href="{{ url('create-transaction') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                        </li>
                        <li> <a href="{{ url('transactions/outgoing') }}"><i class="bx bx-right-arrow-alt"></i>Outgoing</a>
                        </li>
                        <li> <a href="{{ url('transactions/incoming') }}"><i class="bx bx-right-arrow-alt"></i>Incoming</a>
                        </li>
                    </ul>
                </li>
                @endcan
                <li class="menu-label">Masters</li>
                @can('manage_roles')
                <li>
                    <a href="javascript:;" class="has-arrow">
                        <div class="parent-icon text-success"><i class='bx bx-store'></i>
                        </div>
                        <div class="menu-title">Warehouse</div>
                    </a>
                    <ul>
                        <li> <a href="{{ url('warehouses') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                        </li>
                        <li> <a href="{{ url('warehouseList') }}"><i class="bx bx-right-arrow-alt"></i>All</a>
                        </li>
                    </ul>
                </li>
                @endcan
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon text-primary"><i class='bx bx-bus'></i>
                        </div>
                        <div class="menu-title">Vehicle</div>
                    </a>
                    <ul>
                        <li> <a href="{{ url('create-vehicle') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                        </li>
                        <li> <a href="{{ url('vehiclesList') }}"><i class="bx bx-right-arrow-alt"></i>All</a>
                        </li>
                    </ul>
                </li>
                @can('manage_role')
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon text-danger"><i class="bx bx-repeat"></i>
                        </div>
                        <div class="menu-title">Transporter</div>
                    </a>
                    <ul>
                        <li> <a href="{{ url('create-transporter') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                        </li>
                        <li> <a href="{{ url('transportList') }}"><i class="bx bx-right-arrow-alt"></i>All</a>
                        <li> <a href="{{ url('transporter/tagging') }}"><i class="bx bx-right-arrow-alt"></i>Tagging</a>
                        </li>
                    </ul>
                </li>
                @endcan
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon text-warning"> <i class="bx bx-map"></i>
                        </div>
                        <div class="menu-title">Lane</div>
                    </a>
                    <ul>
                        <li> <a href="{{ url('create-lanes') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                        </li>
                        <li> <a href="{{ url('lanesList') }}"><i class="bx bx-right-arrow-alt"></i>All</a>
                        </li>
                    </ul>
                </li>
                <li>
                    <a class="" href="{{ url('products') }}">
                        <div class="parent-icon text-info"><i class='bx bx-message-square-edit'></i>
                        </div>
                        <div class="menu-title">Product</div>
                    </a>
                </li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon text-dark"><i class="bx bx-grid-alt"></i>
                        </div>
                        <div class="menu-title">Contacts</div>
                    </a>
                    <ul>
                        <li> <a href="{{ url('table-basic-table') }}"><i class="bx bx-right-arrow-alt"></i>Add New</a>
                        </li>
                        <li> <a href="{{ url('table-datatable') }}"><i class="bx bx-right-arrow-alt"></i>All</a>
                        </li>
                    </ul>
                </li>
                @can('manage_roles')
                <li class="menu-label">Settings</li>
                <li>
                    <a class="has-arrow" href="javascript:;">
                        <div class="parent-icon"><i class="bx bx-lock"></i>
                        </div>
                        <div class="menu-title">User</div>
                    </a>
                    <ul>
                        <li> <a href="{{ url('user/create') }}"><i class="bx bx-right-arrow-alt"></i>Add New User</a>
                        </li>
                        <li> <a href="{{ url('users') }}" ><i class="bx bx-right-arrow-alt"></i>All User</a>
                        </li>
                        <li> <a href="{{ url('roles') }}" ><i class="bx bx-right-arrow-alt"></i>Role</a>
                        </li>
                        <li> <a href="{{ url('permission') }}" ><i class="bx bx-right-arrow-alt"></i>Permissions</a>
                        </li>
                    </ul>
                </li>
                <li>
                <a href="{{ url('allImports') }}" >
                        <div class="parent-icon text-warning"><i class="fadeIn animated bx bx-import"></i>
                        </div>
                        <div class="menu-title">Import</div>
                    </a>  
                </li>
                @endcan
            </ul>
            <!--end navigation-->
        </div>
        <!--end sidebar wrapper -->