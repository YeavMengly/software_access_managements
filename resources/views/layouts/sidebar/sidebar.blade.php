<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion bg-warning " id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{url('/')}}">
        <div class="logo-mlvt">
            <img src="/img/MLVT.jpg" alt="" style="width: 48px; height: 48px;">
        </div>
        <div class="sidebar-brand-text mx-8" style="font-size: 12px;">Software Access Management</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item active">
        <a class="nav-link" href="{{route('result')}}">
            <span>របាយការណ៍សរុបប្រតិបត្តិការណ៍</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    {{-- <div class="sidebar-heading">
        Interface
    </div> --}}

    <!-- Nav Item - Utilities Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUtilities"
            aria-expanded="true" aria-controls="collapseUtilities">
            <i class="fas fa-fw fa-wrench"></i>
            <span>គ្រប់គ្រងរបាយការណ៍</span>
        </a>
        <div id="collapseUtilities" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">គ្រប់គ្រងរបាយការណ៍</h6>
                <a class="collapse-item" href="{{route('result-total-table')}}">របាយការណ៍ចំណាយថវិកា</a>
                <a class="collapse-item" href="{{route('result-total-general-table')}}">របាយការណ៍សកម្មភាព</a>
                <a class="collapse-item" href="">របាយការណ៍អនុវត្ត</a>
                <a class="collapse-item" href="">របាយការណ៍សង្ខេប</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>តួលេខ</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">តួលេខ</h6>
                <a class="collapse-item" href="{{ route('keys.index')}}">ជំពូក</a>
                <a class="collapse-item" href="{{ route('accounts.index')}}">គណនី</a>
                <a class="collapse-item" href="{{route('sub-account.index')}}">អនុគណនី</a>
                <a class="collapse-item" href="{{ route('codes.index')}}">កូដសម្គាល់</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - New Components Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwoCopy"
            aria-expanded="true" aria-controls="collapseTwoCopy">
            <i class="fas fa-fw fa-cog"></i>
            <span>លទ្ធផលសម្រេចបាន</span>
        </a>
        <div id="collapseTwoCopy" class="collapse" aria-labelledby="headingTwoCopy" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">លទ្ធផលសម្រេចបាន</h6>
                <a class="collapse-item" href="">ប្រៀបធៀបធានាចំណាយ</a>
                <a class="collapse-item" href="">ផែនការថវិការដ្ឋ</a>
                <a class="collapse-item" href="">អនុវត្តចំណាយ</a>
            </div>
        </div>
    </li>

    <!-- Nav Item - Additional Components Collapse Menu -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThreeCopy"
            aria-expanded="true" aria-controls="collapseThreeCopy">
            <i class="fas fa-fw fa-folder"></i>
            <span>ឥណទានសរុប</span>
        </a>
        <div id="collapseThreeCopy" class="collapse" aria-labelledby="headingThreeCopy" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">ឥណទានសរុប</h6>
                <a class="collapse-item" href=" ">ឥណទានថ្មី</a>
                <a class="collapse-item" href=" ">បូកយោងអនុវត្ត</a>
                <a class="collapse-item" href=" ">នៅសល់</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseFour"
            aria-expanded="true" aria-controls="collapseFour">
            <i class="fas fa-fw fa-folder"></i>
            <span>ចំណាយបេសកកម្ម</span>
        </a>
        <div id="collapseFour" class="collapse" aria-labelledby="headingFour" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">ចំណាយបេសកកម្ម</h6>
                <a class="collapse-item" href="{{url('/mission-cam')}}">បេសកម្មក្នុងប្រទេស</a>
                <a class="collapse-item" href="{{url('/mission-abroad')}}">បេសកម្មក្រៅប្រទេស</a>
            </div>
        </div>
    </li>
    
    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
