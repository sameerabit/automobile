<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="/" class="brand-link">
    <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-normal">AMITH AUTOMOBILES</span>
  </a>

  <!-- Sidebar -->
  <div class="sidebar">
    <!-- Sidebar user panel (optional) -->
    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
      <div class="image">
        <img src="{{ asset('dist/img/user2-160x160.jpg') }}" class="img-circle elevation-2" alt="User Image">
      </div>
      <div class="info">
        <a href="#" class="d-block">{{ auth()->user()->name }}</a>
      </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <!-- Add icons to the links using the .nav-icon class
                                 with font-awesome or any other icon font library -->

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-warehouse"></i>
            <p>
              Inventory
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right"></span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('suppliers.index') }}" class="nav-link">
                <i class="fas fa-parachute-box nav-icon"></i>
                <p>Suppliers</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('brands.index') }}" class="nav-link">
                <i class="fas fa-copyright nav-icon"></i>
                <p>Brands</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('categories.index') }}" class="nav-link">
                <i class="fa fa-list-alt nav-icon"></i>
                <p>Categories</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('products.index') }}" class="nav-link">
                <i class="fab fa-product-hunt nav-icon"></i>
                <p>Products</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('units.index') }}" class="nav-link">
                <i class="fas fa-ruler-vertical nav-icon"></i>
                <p>Units</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('supplier-bill.create') }}" class="nav-link">
                <i class="fas fa-file-invoice  nav-icon"></i>
                <p>Add Stock</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('supplier-bill.index') }}" class="nav-link">
                <i class="fas fa-clipboard-list nav-icon"></i>
                <p>Stock List</p>
              </a>
            </li>
            <!-- <li class="nav-item">
                                    <a href="{{ route('supplier-returns.create') }}" class="nav-link">
                                      <i class="far fa-circle nav-icon"></i>
                                      <p>Supplier Returns</p>
                                    </a>
                                  </li> -->
            <li class="nav-item">
              <a href="{{ route('supplier-returns.index') }}" class="nav-link">
                <i class="fas fa-undo nav-icon"></i>
                <p>Stock Return Details</p>
              </a>
            </li>
          </ul>
        </li>
        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-car-side"></i>
            <p>
              Vehicle Management
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right"></span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('vehicles.index') }}" class="nav-link">
                <i class="fas fa-car-alt nav-icon"></i>
                <p>Vehicles</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('job-cards.create') }}" class="nav-link">
                <i class="fas fa-credit-card nav-icon"></i>
                <p>New Job Card</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('job_cards.index') }}" class="nav-link">
                <i class="fas fa-clipboard-list nav-icon"></i>
                <p>Job Cards List</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-briefcase"></i>
            <p>
              Employee Management
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right"></span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('employees.index') }}" class="nav-link">
                <i class="fas fa-user-circle nav-icon"></i>
                <p>Employees</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('hourly-rates.create') }}" class="nav-link">
                <i class="fas fa-user-clock  nav-icon"></i>
                <p>Hourly Rate</p>
              </a>
            </li>
          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-calendar-check"></i>
            <p>
              Booking Management
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right"></span>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="{{ route('booking.index') }}" class="nav-link">
                <i class="fas fa-calendar nav-icon"></i>
                <p>Calendar Booking</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('booking.all') }}" class="nav-link">
                <i class="fas fa-calendar nav-icon"></i>
                <p>Booking List</p>
              </a>
            </li>

          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-car-crash"></i>
            <p>
              Insurance Claims
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right"></span>
            </p>
          </a>
          <ul class="nav nav-treeview">

            <li class="nav-item">
              <a href="{{ route('insurance_companies.index') }}" class="nav-link">
                <i class="far fa-circle nav-icon"></i>
                <p>Companies</p>
              </a>
              <a href="{{ route('insurance_claim.index') }}" class="nav-link">
                <i class="fas fa-list nav-icon"></i>
                <p>Claims List</p>
              </a>
              <a href="{{ route('insurance_claim.create') }}" class="nav-link">
                <!-- <i class="fas fa-truck-pickup nav-icon"></i> -->
                <i class="fas fa-edit nav-icon"></i>
                <p>New Claim</p>
              </a>
            </li>

          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-user"></i>
            <p>
              User Management
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right"></span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('users.index') }}" class="nav-link">
                <i class="fas fa-users nav-icon"></i>
                <p>Users</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('register') }}" class="nav-link">
                <i class="fas fa-user-plus nav-icon"></i>
                <p>Add User</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('roles.index') }}" class="nav-link">
                <i class="fas fa-user-tag  nav-icon"></i>
                <p>Roles</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('permissions.index') }}" class="nav-link">
                <i class="fas fa-parking  nav-icon"></i>
                <p>Permissions</p>
              </a>
            </li>

          </ul>
        </li>

        <li class="nav-item has-treeview">
          <a href="#" class="nav-link">
            <i class="fas fa-chart-bar"></i>
            <p>
              Reports
              <i class="fas fa-angle-left right"></i>
              <span class="badge badge-info right"></span>
            </p>
          </a>
          <ul class="nav nav-treeview">
            <li class="nav-item">
              <a href="{{ route('report.products') }}" class="nav-link">
                <i class="far fa-sticky-note nav-icon"></i>
                <p>Products Report</p>
              </a>
            </li>

            <li class="nav-item">
              <a href="{{ route('report.daily-business') }}" class="nav-link">
                <i class="far fa-sticky-note nav-icon"></i>
                <p>Daily Business</p>
              </a>
            </li>
            <li class="nav-item">
              <a href="{{ route('report.employee-working-time') }}" class="nav-link">
                <i class="far fa-sticky-note nav-icon"></i>
                <p>Employee Hours</p>
              </a>

            </li>

          </ul>
        </li>


      </ul>
    </nav>
    <!-- /.sidebar-menu -->
  </div>
  <!-- /.sidebar -->
</aside>