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
            <h2 class="fs-5 mb-3">About Us</h2>
            <img src="{{ URL::asset('pstone-logo.PNG'); }}" height="90" width="100" class="img-fluid" alt="Pstone">
                <p class="fs-6">"@PStone Arts is a doorstep for all white stone statues and many decorations items."</p>
            </div>
            <div class="col-md-4 py-3">
               <div class="row">
                    <div class="col-sm-4"></div>
                    <div class="col-sm-8">
                        <h2 class="fs-5 mb-3">QUICK LINKS</h2>
                        <ul class="list-unstyled mb-0">
                            @foreach ($service_categories as $category)
                                @if($category->menu_top == 1)
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
                        <a class="text-dark" href="{{ route('catalog.shipping-policy') }}">Shipping Policy</a><br/>
                        <a class="text-dark" href="{{ route('catalog.refund-return-policy') }}">Refund & Return Policy</a><br/>
                        <a class="text-dark" href="{{ route('catalog.terms-condition') }}">Term & Condition</a><br/>
                        <a class="text-dark" href="{{ route('catalog.privacy-policy') }}">Privacy Policy</a><br/>
                        <a class="text-dark" href="{{ route('catalog.aboutus') }}">About Us</a><br/>
                        <a class="text-dark" href="{{ route('catalog.contactus') }}">Contact Us</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4 py-3">
                <h2 class="fs-5 mb-4">CONTACT US</h2>
                
        <p class="fs-6">Pstone Arts, Govindgarh Road, Behind the Jagannath Temple, Sikri, Deeg<br/> Pin Code - 321024</p>
           <a href="https://www.facebook.com/Pstonestatues" class="btn btn-primary"><i class="fab fa-facebook-f"></i></a>
        <a href="https://x.com/ArtsPstone" class="btn btn-info"><i class="fab fa-twitter"></i></a>
        <a href="https://www.instagram.com/official_pstonearts/" class="btn btn-danger"><i class="fab fa-instagram"></i></a>
        <a href="https://www.linkedin.com/in/offical-pstone-arts/" class="btn btn-primary"><i class="fab fa-linkedin-in"></i></a>
            </div>
        </div>
    </div>
    <hr style="border-color:#000">
    <div class="text-center pb-3 text-dark">
        &copy; Copyright {{ date('Y') }}, Designed and Developed by <a target="blank" href="http://www.pstonearts.com/"><span style="color:#ff6666;">Pstone Arts</span></a>
    </div>
</footer>