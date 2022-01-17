<div class="header-wrapper"> 
 <header>
			<div class="topbar d-flex align-items-center">
				<nav class="navbar navbar-expand">
					<div class="topbar-logo-header">
						<div class="">
                        <img src="{{ url('assets/images/logo-icon.png') }}" class="logo-icon" alt="logo icon">
						</div>
						<div class="">
							<h4 class="logo-text">VTC</h4>
						</div>
					</div>
					<div class="mobile-toggle-menu"><i class='bx bx-menu'></i></div>
					<div class="search-bar flex-grow-1">
						<div class="position-relative search-bar-box">
							<input type="text" class="form-control search-control" placeholder="Type to search..."> <span class="position-absolute top-50 search-show translate-middle-y"><i class='bx bx-search'></i></span>
							<span class="position-absolute top-50 search-close translate-middle-y"><i class='bx bx-x'></i></span>
						</div>
					</div>
					<div class="top-menu ms-auto">
						<ul class="navbar-nav align-items-center">
							<li class="nav-item mobile-search-icon">
								<a class="nav-link" href="#">	<i class='bx bx-search'></i>
								</a>
							</li>
                            <li>
                            <div id="google_translate_element"></div>
                            </li>
                            <li class="nav-item dropdown dropdown-large">

                            </li>
                            <li class="nav-item dropdown dropdown-large">
                                <div class="dropdown-menu dropdown-menu-end">

                                    <div class="header-notifications-list">

                                    </div>

                                </div>
                            </li>
                            <li class="nav-item dropdown dropdown-large">

                                <div class="dropdown-menu dropdown-menu-end">

                                    <div class="header-message-list">
                
                                    </div>

                                </div>
                            </li>
							
						</ul>
					</div>
					<div class="user-box dropdown">
                        <a class="d-flex align-items-center nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fadeIn animated bx bx-user-circle" class="user-img" style="font-size:32px;"></i>
                            <div class="user-info ps-3">
                                <p class="user-name mb-0">Eternity Solutions</p>
                                <p class="designattion mb-0">User Loggedin </p>
                            </div>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li><a class="dropdown-item" href="javascript:;"><i class="bx bx-user"></i><span>Profile</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class="bx bx-cog"></i><span>Settings</span></a>
                            </li>
                            <li><a class="dropdown-item" href="javascript:;"><i class='bx bx-home-circle'></i><span>Dashboard</span></a>
                            </li>
                            <li>
                                <div class="dropdown-divider mb-0"></div>
                            </li>
                            <li><a class="dropdown-item" href="{{ __('/logout')}}"><i class='bx bx-log-out-circle'></i><span>Logout</span></a>
                            </li>
                        </ul>
                    </div>
				</nav>
			</div>
</header>
<!--sidebar wrapper -->
<div class="nav-container">
			<div class="mobile-topbar-header">
				<div>
					<img src="assets/images/logo-icon.png" class="logo-icon" alt="logo icon">
				</div>
				<div>
					<h4 class="logo-text">VTC</h4>
				</div>
				<div class="toggle-icon ms-auto"><i class='bx bx-arrow-to-left'></i>
				</div>
			</div>
		<nav class="topbar-nav">
            <!--navigation-->
            @role('Security Guards') 
            <ul class="metismenu" id="menu">
                <li>
                <a class="" href="{{ __('/logout')}}">
                        <div class="parent-icon"><i class='bx bx-log-out-circle'></i>
                        </div>
                        <div class="menu-title">Logout</div>
                    </a>
                </li>
              </ul>
            @else 
            <ul class="metismenu" id="menu">
                <li class="mm-active">
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
                    <a href="{{ url('products') }}" class="has-arrow">
                        <div class="parent-icon text-info"><i class='bx bx-message-square-edit'></i>
                        </div>
                        <div class="menu-title">Product</div>
                    </a>
                </li>
                <li>
                <a href="{{ url('allImports') }}" class="has-arrow">
                        <div class="parent-icon text-warning"><i class="fadeIn animated bx bx-import"></i>
                        </div>
                        <div class="menu-title">Import</div>
                    </a>  
                </li>
                @can('manage_roles')
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

                @endcan
            </ul>
            @endrole
            <!--end navigation-->
		</nav>
    </div>
</div>

    