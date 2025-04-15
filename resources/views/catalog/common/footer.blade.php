<style>
    .list-unstyled{
        line-height: 34px
    }
    a{
        text-decoration: none;
    }
    @media(min-width: 768px){
        footer{
            padding-top: 50px
        }
    }
    @media(max-width: 768px){
        footer{
            padding-top: 50px;
            padding-bottom: 50px;
        }
    }
</style>
<footer style="background: #ddddddb5">
    <div class="container">
        <div class="row text-dark">
            <div class="col-md-4 py-2">
                <p class="fs-6">Fitness and Strength have power to transform you and make you different from others. Driven by our passion for fitness and our instinct for innovation, we want to bring the best out of you. We want to stand on the same place where you are trying to strengthen yourself, and to achieve that Herculeen brand runs by <strong>[company name]</strong> is based on very true values that promises a premium range of activewear, footwear and accessories.</p>
            </div>
            <div class="col-md-4 py-3">
               <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <h2 class="fs-5 mb-3">QUICK LINKS</h2>
                        <ul class="list-unstyled mb-0">
                            @foreach ($service_categories as $category)
                                @if($category->menu_top === 1)
                                    <li><a class="text-dark" href="{{ route('catalog.product-all', [$category->id, $category->slug]) }}">{{ $category->category_name }}</a></li>
                                @endif
                            @endforeach
                            <!-- Children menu -->
                            @foreach ($service_categories as $category)
                            @if ($category->children->isNotEmpty())
                                @foreach ($category->children as $child)
                                @if ($child->menu_top === 1)
                                    <li>
                                        <a class="text-dark" href="{{ route('catalog.product-all', [$child->id, $child->slug]) . '?sort=latest' }}">
                                            {{ $child->category_name }}
                                        </a>
                                    </li>
                                @endif
                                    @endforeach
                                @endif
                            @endforeach  
                        </ul>
                        <a class="text-dark" href="{{ route('catalog.privacyPolicy') }}">Return/Replacement Policy</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <h2 class="fs-5 mb-4">CONTACT US</h2>
                
            </div>
        </div>
    </div>
    <hr style="border-color:#000">
    <div class="text-center pb-3 text-dark">
        &copy; Copyright {{ date('Y') }} <a target="blank" href="#">XYZ</a>
    </div>
</footer>