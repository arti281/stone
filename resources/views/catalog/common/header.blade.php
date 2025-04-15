
<nav class="p-1 sticky-top" style="background:#000;margin-top: -1px;">
    <div class="container">
        <div class="row">
            <div class="col-6">
                @if (app('settings') && isset(app('settings')['mobile_logo']))
                <a href="/"><img height="80" width="150" src="{{ URL::asset('image/setting/site') .'/'. app('settings')['mobile_logo'] }}" alt="ez lifestyle" class="d-block d-md-none"></a>
                @endif
            </div>
            <div class="col-6 col-md-12">
                <div class="nav_desktop nav_mobile_view">
                    <ul class="list-unstyled text-white d-flex justify-content-center mb-0">
                        @foreach ($service_categories as $category)
                            @if ($category->menu_top === 1)
                                <li class="px-3 fs-5 navbar_items active-link">
                                    <a class="text-decoration-none text-white text-uppercase" href="{{ route('catalog.product-all', [$category->id, $category->slug]) . '?sort=latest' }}">
                                        {{ $category->category_name }}
                                    </a>
                                    @if ($category->children->isNotEmpty())
                                        <ul class="navbar_items-link">
                                            @foreach ($category->children as $child)
                                                <li class="p-0 mb-0">
                                                    <a class="text-decoration-none d-block ps-2 text-uppercase" href="{{ route('catalog.product-all', [$child->id, $child->slug]) }}">
                                                        {{ $child->category_name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endif
                        @endforeach
                        <!-- Children menu -->
                        @foreach ($service_categories as $category)
                            @if ($category->children->isNotEmpty())
                                @foreach ($category->children as $child)
                                @if ($child->menu_top === 1)
                                    <li class="px-3 fs-5 navbar_items active-link">
                                        <a class="text-decoration-none text-white text-uppercase" href="{{ route('catalog.product-all', [$child->id, $child->slug]) . '?sort=latest' }}">
                                            {{ $child->category_name }}
                                        </a>
                                    </li>
                                @endif
                                    @endforeach
                                @endif
                        @endforeach   
                    </ul>      
                </div>
                <div class="nav_mobile text-end column-left-mobile">
                    <button class="btn text-white border" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasScrolling" aria-controls="offcanvasScrolling"><i class="fa-solid fa-bars fs-3 mt-1"></i></button>
                </div>
            </div>
        </div>

        <!-- For mobile -->
        <div class="offcanvas offcanvas-start" data-bs-scroll="true" data-bs-backdrop="true" tabindex="-1" id="offcanvasScrolling" aria-labelledby="offcanvasScrollingLabel">
          <div class="offcanvas-header">
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
          </div>
          <div class="offcanvas-body px-0">
            <ul class="list-unstyled mb-0">                
                @foreach ($service_categories as $category)
                    @if ($category->menu_top === 1 || $category->menu_top === 0)
                        <li class="fs-5 mb-0" style="border-bottom: 1px solid #fff">
                            <a class="text-decoration-none sidebar_link_menu text-dark d-block d-flex justify-content-between px-3" data-category-id="{{ $category->id }}" style="background-color:#ddd" href="javascript:void(0)">
                                <span>{{ $category->category_name }}</span>
                                <span><i class="fa-solid fa-plus"></i></span>
                            </a>
                            @if ($category->children->isNotEmpty())
                            <ul class="list-unstyled sidebar_link_item" id="sidebar_link_item_{{ $category->id }}" style="display: none">
                                    <li class="ps-4 mb-0 border-bottom">
                                        <a class="text-decoration-none text-primary d-block d-block ps-2" href="{{ route('catalog.product-all', [$category->id, $category->slug]) }}">
                                            {{ $category->category_name }}
                                        </a>
                                    </li>
                                    @foreach ($category->children as $child)
                                        <li class="ps-4 mb-0 border-bottom">
                                            <a class="text-decoration-none d-block text-dark d-block ps-2" href="{{ route('catalog.product-all', [$child->id, $child->slug]) }}">
                                                <i class="fa-solid fa-angle-right fs-6"></i> {{ $child->category_name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                            {{-- @if ($category->children->isNotEmpty())
                                <ul class="navbar_items-link">
                                    @include('partials.category_list', ['categories' => $category->children])
                                </ul>
                            @endif --}}
                        </li>
                    @endif
                @endforeach
            </ul>
          </div>
        </div>
    </div>
</nav>

<script>
    // for mobile device
    const sidebar_link_menu = document.querySelectorAll('.sidebar_link_menu');
    sidebar_link_menu.forEach(element => {
        element.addEventListener('click', () => {
            let category_id = element.getAttribute('data-category-id');
            let sidebar_link_item = document.getElementById('sidebar_link_item_'+category_id);

            if (sidebar_link_item) { 
                if (sidebar_link_item.style.display === 'block') {
                    sidebar_link_item.style.display = 'none';
                } else {
                    sidebar_link_item.style.display = 'block';
                    sidebar_link_item.style.transition = 'all 2s'

                }
            } 
        })
    });
</script>

<script>
    // Select all active links
    let active_links = document.querySelectorAll('.navbar_items.active-link');

    // Loop through each active link and add event listeners
    active_links.forEach(active_link => {
        const navbar_items_link = active_link.querySelector('.navbar_items-link');

        active_link.addEventListener('mouseenter', () => {
            if (navbar_items_link) {
                navbar_items_link.style.display = 'block';
            }
        });

        active_link.addEventListener('mouseleave', () => {
            hideDropdown(navbar_items_link);
        });

        // Hide dropdown when mouse leaves the ul
        if (navbar_items_link) {
            navbar_items_link.addEventListener('mouseleave', () => {
                hideDropdown(navbar_items_link);
            });
        }
    });

    // Function to hide the dropdown
    function hideDropdown(dropdown) {
        setTimeout(() => {
            if (!isHover(dropdown) && !isHover(dropdown.parentElement)) {
                if (dropdown) {
                    dropdown.style.display = 'none';
                }
            }
        }, 50);
    }

    // Helper function to check if a single element is being hovered
    function isHover(element) {
        return element.matches(':hover');
    }
</script>