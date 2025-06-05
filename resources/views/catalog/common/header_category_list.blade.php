@foreach ($categories as $child)
    <li>
        <a class="text-decoration-none" href="{{ route('catalog.category', [$child->id, $child->slug]) }}">
            {{ $child->category_name }}
        </a>
        @if ($child->children->isNotEmpty())
            <ul class="navbar_items-link">
                @include('catalog.common.header_category_list', ['categories' => $child->children])
            </ul>
        @endif
    </li>
@endforeach