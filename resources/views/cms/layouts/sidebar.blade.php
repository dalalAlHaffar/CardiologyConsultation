<ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
        <a class="nav-link collapsed"  onclick="toggleSide(event)"  href="{{url('/cms/dashBoard')}}">
            <i class="bi bi-grid"></i>
            <span>Dashboard</span>
        </a>
    </li><!-- End Dashboard Nav -->
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('/cms/user')}}">
            <i class="bi bi-person"></i>
            <span>Users</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('/cms/category')}}">
            <i class="bi bi-menu-button-wide"></i>
            <span>Categories</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('/cms/blog')}}">
            <i class="ri-health-book-line"></i>
            <span>Blogs</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="{{url('/cms/consolute')}}">
            <i class="ri-heart-pulse-line"></i>
            <span>Consolation</span>
        </a>
    </li>
</ul>