<div class="dashboard-header">
    <div class="d-flex justify-content-between align-items-center p-3">
        <h2>Admin Panel</h2>
        <div class="d-flex">
            <a target="blank" href="/" class="text-decoration-none text-dark fs-4 me-3">View Storefront </a>
            <div class="dropdown pe-3">
                <a class="btn btn-secondary dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                  Profile
                </a>
              
                <ul class="dropdown-menu">
                  <li><a class="dropdown-item" href="{{ route('edit-profile') }}">Edit Profile</a></li>
                  <li><a class="dropdown-item" href="{{ route('change-password') }}">Change Password</a></li>
                  <li><a class="dropdown-item fs-6 text-danger" href="{{ route('admin-logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();"><i class="fa-solid fa-power-off"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>
    <form id="frm-logout" action="{{ route('admin-logout') }}" method="POST" style="display: none;">
        @csrf
    </form>
</div>   