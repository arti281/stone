<aside class="left-sidebar">
    <div style="max-height: 300vh; min-height:100vh">
        <ul class="list-unstyled">
            <li class="py-2"><strong class="text-white"><i class="fa-solid fa-bars"></i> Navigation</strong></li>
            <li><a class="text-decoration-none text-white d-block" href="{{ route('admin-dashboard') }}"><i class="fa-solid fa-house"></i> Dashboard</a></li>
            <li>
                <button class="dropdown-btn left-side-btn" data-dropdown="column_left-1"><span><i class="fa-solid fa-store"></i> Storefront</span> <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-container" id="dropdown-column_left-1">
                    <a class="text-decoration-none text-white d-block" style="padding-left:3rem !important" href="{{ route('category') }}"><i class="fa-solid fa-angles-right"></i> Categories</a>
                    <a class="text-decoration-none text-white d-block" style="padding-left:3rem !important" href="{{ route('admin-storefront-product') }}"><i class="fa-solid fa-angles-right"></i> Products</a>
                    <a class="text-decoration-none text-white d-block" style="padding-left:3rem !important" href="{{ route('colors') }}"><i class="fa-solid fa-angles-right"></i> Colors</a>
                    <a class="text-decoration-none text-white d-block" style="padding-left:3rem !important" href="{{ route('size') }}"><i class="fa-solid fa-angles-right"></i> Size</a>
                </div>
            </li>
            <li>
                <button class="dropdown-btn left-side-btn" data-dropdown="column_left-2"><span><i class="fas fa-user"></i> Users</span> <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-container" id="dropdown-column_left-2">
                    <a class="text-decoration-none text-white d-block" style="padding-left:3rem !important" href="{{ route('user') }}"><i class="fa-solid fa-angles-right"></i> User</a>
                </div>
            </li>
            <li>
                <button class="dropdown-btn left-side-btn" data-dropdown="column_left-4"><span><i class="fa-solid fa-cart-shopping"></i> Sales</span> <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-container" id="dropdown-column_left-4">
                    <a class="text-decoration-none text-white d-block" style="padding-left:3rem !important" href="{{ route('admin.order') }}"><i class="fa-solid fa-angles-right"></i> Orders</a>
                </div>
            </li>
            <li>
                <button class="dropdown-btn left-side-btn" data-dropdown="column_left-3"><span><i class="fas fa-desktop"></i> Design</span> <i class="fa fa-caret-down"></i></button>
                <div class="dropdown-container" id="dropdown-column_left-3">
                    <a class="text-decoration-none text-white d-block" style="padding-left:3rem !important" href="{{ route('admin-banner') }}"><i class="fa-solid fa-angles-right"></i> Banner</a>
                    <a class="text-decoration-none text-white d-block" style="padding-left:3rem !important" href="{{ route('admin-media') }}"><i class="fa-solid fa-angles-right"></i> Media</a>
                </div>
            </li>
            <li><a class="text-decoration-none text-white d-block" href="{{ route('admin-setting') }}"><i class="fa-solid fa-gear"></i> Setting</a></li>
        </ul>
    </div>
</aside>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        var dropdowns = document.querySelectorAll('.dropdown-btn');

        dropdowns.forEach(function (dropdown) {
            var dropdownId = dropdown.dataset.dropdown;
            var dropdownContent = document.getElementById('dropdown-' + dropdownId);

            if (localStorage.getItem('dropdown-' + dropdownId) === 'true') {
                dropdown.classList.add('active');
                dropdownContent.style.display = 'block';
                dropdownContent.style.maxHeight = dropdownContent.scrollHeight + "px";
            }

            dropdown.addEventListener('click', function () {
                var isOpen = dropdownContent.style.maxHeight;
                if (isOpen) {
                    dropdownContent.style.maxHeight = null;
                    dropdownContent.style.display = 'none';
                    dropdown.classList.remove('active');
                    localStorage.setItem('dropdown-' + dropdownId, 'false');
                } else {
                    dropdownContent.style.display = 'block';
                    dropdownContent.style.maxHeight = dropdownContent.scrollHeight + "px";
                    dropdown.classList.add('active');
                    localStorage.setItem('dropdown-' + dropdownId, 'true');
                }
            });
        });
    });
</script>