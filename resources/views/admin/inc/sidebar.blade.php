<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center py-5" href="{{ route('dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Stock Management <sup>System</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Interface
    </div>

    <!-- Stock Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#stock" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-store-alt"></i>
            <span>Stock</span>
        </a>
        <div id="stock" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Stock:</h6>
                <a class="collapse-item" href="{{ route('stock.add') }}">Add Stock</a>
                <a class="collapse-item" href="{{ route('stock.manage') }}">Manage stock</a>
            </div>
        </div>
    </li>

    <!-- Suppliers Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#suppliers" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-luggage-cart"></i>
            <span>Suppliers</span>
        </a>
        <div id="suppliers" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Suppliers:</h6>
                <a class="collapse-item" href="{{ route('supplier') }}">Manage Suppliers</a>
            </div>
        </div>
    </li>

    <!-- Brand Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brand" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-tags"></i>
            <span>Brands</span>
        </a>
        <div id="brand" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Brands:</h6>
                <a class="collapse-item" href="{{ route('brand') }}">Manage Brands</a>
            </div>
        </div>
    </li>

    <!-- Category Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#category" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-box"></i>
            <span>Category</span>
        </a>
        <div id="category" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Category:</h6>
                <a class="collapse-item" href="{{ route('category') }}">Manage Categories</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Payment
    </div>

    <!--Payment-->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#payment" aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-hand-holding-usd"></i>
            <span>Payment</span>
        </a>
        <div id="payment" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Payment:</h6>
                <a class="collapse-item" href="{{ route('payment') }}">Make Payment</a>
                <a class="collapse-item" href="{{ route('payment-method') }}">Payment Method</a>
            </div>
        </div>
    </li>


    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>