<!--  BEGIN SIDEBAR  -->
<div class="sidebar-wrapper sidebar-theme">

    <nav id="sidebar">
        <div class="shadow-bottom"></div>

        <ul class="list-unstyled menu-categories ps" id="accordionExample">
            @if (Auth::user()->user_type == 'Admin')
                <li class="menu">
                    <a href="#customers" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-airplay">
                                <path d="M5 17H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h16a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-1">
                                </path>
                                <polygon points="12 15 17 21 7 21 12 15"></polygon>
                            </svg>
                            <span>System users</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="submenu list-unstyled collapse" id="customers" data-parent="#accordionExample"
                        style="">
                        <li>
                            <a href="{{ route('users.index') }}">View all</a>
                        </li>
                        <li>
                            <a href="{{ route('users.create') }}">Create system user</a>
                        </li>
                        <li>
                            <a href="{{ route('login-audit') }}">Login Audit</a>
                        </li>
                    </ul>
                    <a href="#submenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle collapsed">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round" class="feather feather-users">
                                <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                                <circle cx="9" cy="7" r="4"></circle>
                                <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                                <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                            </svg>

                            <span>App Users</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="submenu list-unstyled collapse" id="submenu" data-parent="#accordionExample"
                        style="">
                        <li>
                            <a href="{{ route('customers.index') }}">View Customers</a>
                        </li>
                        <li>
                            <a href="{{ route('customers.showSalesRep') }}">View Sales Rep</a>
                        </li>
                    </ul>
                </li>
            @endif
            @if (Auth::user()->user_type == 'Credit Manager')
                <li class="menu">
                    <a href="#starter-kit" data-active="true" data-toggle="collapse" aria-expanded="true"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout">
                                <rect x="3" y="3" width="18" height="18" rx="2"
                                    ry="2"></rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="21" x2="9" y2="9"></line>
                            </svg>
                            <span>Orders</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="submenu list-unstyled collapse show" id="starter-kit" data-parent="#accordionExample"
                        style="">
                        <li>
                            <a href="{{ url('home') }}">Unapproved</a>
                        </li>
                        <li>
                            <a href="{{ route('approved') }}">Approved by you</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->user_type == 'Manager')
                <li class="menu">
                    <a href="#starter-kit" data-active="true" data-toggle="collapse" aria-expanded="true"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout">
                                <rect x="3" y="3" width="18" height="18" rx="2"
                                    ry="2"></rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="21" x2="9" y2="9"></line>
                            </svg>
                            <span>Reports</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="submenu list-unstyled collapse show" id="starter-kit" data-parent="#accordionExample"
                        style="">
                        <li>
                            <a href="{{ url('report/sales') }}">Sales</a>
                        </li>
                        <li>
                            <a href="{{ url('report/products') }}">Products</a>
                        </li>
                        <li>
                            <a href="{{ url('report/allocation') }}">Allocations</a>
                        </li>
                        <li>
                            <a href="{{ url('report/collections') }}">Collections</a>
                        </li>
                        <li>
                            <a href="{{ url('report/region') }}">Region</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->user_type == 'Operations Manager')
                <li class="menu">
                    <a href="#starter-kit" data-active="true" data-toggle="collapse" aria-expanded="true"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout">
                                <rect x="3" y="3" width="18" height="18" rx="2"
                                    ry="2"></rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="21" x2="9" y2="9"></line>
                            </svg>
                            <span>Orders</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="submenu list-unstyled collapse show" id="starter-kit" data-parent="#accordionExample"
                        style="">
                        <li>
                            <a href="{{ url('home') }}">Unapproved</a>
                        </li>
                        <li>
                            <a href="{{ url('approved_by_credit_manager') }}">Approved by you</a>
                        </li>
                    </ul>
                </li>
            @endif

            @if (Auth::user()->user_type == 'Procurement Officer')
                <li class="menu">
                    <a href="#starter-kit" data-active="true" data-toggle="collapse" aria-expanded="true"
                        class="dropdown-toggle">
                        <div class="">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-layout">
                                <rect x="3" y="3" width="18" height="18" rx="2"
                                    ry="2"></rect>
                                <line x1="3" y1="9" x2="21" y2="9"></line>
                                <line x1="9" y1="21" x2="9" y2="9"></line>
                            </svg>
                            <span>Materials</span>
                        </div>
                        <div>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="feather feather-chevron-right">
                                <polyline points="9 18 15 12 9 6"></polyline>
                            </svg>
                        </div>
                    </a>
                    <ul class="submenu list-unstyled collapse show" id="starter-kit" data-parent="#accordionExample"
                        style="">
                        <li>
                            <a href="{{ url('home') }}">Unallocated</a>
                        </li>
                        <li>
                            <a href="{{ url('allocated-materials') }}">Allocated</a>
                        </li>
                    </ul>
                </li>
            @endif

        </ul>

    </nav>

</div>
<!--  END SIDEBAR  -->
