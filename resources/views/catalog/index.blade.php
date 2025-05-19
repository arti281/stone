@extends('catalog.common.base')

<!-- meta tags -->
@push('setTitle')@if (app('settings') && isset(app('settings')['site_title'])){{ app('settings')['site_title'] }}@endif @endpush
@push('setDescription')@if (app('settings') && isset(app('settings')['site_description'])){{ strip_tags(app('settings')['site_description']) }}@endif @endpush
@push('setKeyword')Noida best sports wear clothing manufacturer, Herculeen Activewear online brands, Herculeen Activewear @endpush
@push('setCanonicalURL')https://herculeen.com/@endpush


@section('content')

    <!-- Carousel -->
    @include('catalog.common.carousel')

    <!-- products -->
    <section class="bg-dark">
        <div class="container-fluid px-4">
            <!-- <div class="py-4">
                <div class="section-header d-flex flex-wrap align-items-center justify-content-between">
                    <h2 class="section-title fs-3">Featured Products</h2>            
                    <div class="btn-wrap">
                        <a href="{{$product_route}}" class="d-flex align-items-center text-dark">View all products <i class="fa-solid fa-arrow-right ms-2"></i></a>
                    </div>            
                </div>
                All products
                {!! $product_thumb !!}
            </div> -->

            <!-- categories -->
            <div class="pb-4 cate">
                <div class="section-header d-flex flex-wrap align-items-center justify-content-between">
                    <h2 class="section-title fs-3">Best Selling Categories</h2>            
                    <div class="btn-wrap">
                        <a href="{{ $category_route }}" class="d-flex align-items-center text-light ">View all categories <i class="fa-solid fa-arrow-right ms-2"></i></a>
                    </div>            
                </div>
                <!-- All category  -->
                <!-- <div class="row">
                    @foreach ($categories as $category)
                    @if ($category->parent_id !== null)
                        <div class="col-6 col-sm-3 col-md-2">
                            <a href="{{ route('catalog.product-all', [$category->id, $category->slug]) . '?sort=latest' }}">
                                <div class="p-1 category_image">
                                    <img class="category-img" src="{{ isset($category->image) ? asset('image/category/' . $category->image) : asset('not-image-available.png') }}" alt="{{ $category->category_name }}">
                                </div>
                                <p class="text-center mt-2 text-dark">{{ $category->category_name }}</p>
                            </a>
                        </div>
                    @endif
                    @endforeach
                    
                </div> -->
                <div class="row cate">
                    @foreach ($categories as $category)
                        <div class="col-6 col-sm-3 col-md-2">
                            <a href="{{ route('catalog.product-all', [$category->id, $category->slug]) . '?sort=latest' }}">
                                <div class="p-1 category_image">
                                    <img class="category-img" src="{{ isset($category->image) ? asset('image/category/' . $category->image) : asset('not-image-available.png') }}" alt="{{ $category->category_name }}">
                                </div>
                                <p class="text-center mt-2 text-light">{{ $category->category_name }}</p>
                            </a>
                        </div>
                  
                    @endforeach
                    
                </div>
            </div>
        </div>
    </section>

    <section id="promo">
  <div class="container py-4">
    <div class="row">
      <!-- Left promo -->
      <div class="col-md-5 p-0 abc">
        <div class="position-relative">
          <img src="{{ URL::asset('image/products/4.jpg'); }}" alt="img" class="img-fluid w-100 image">
          <div class="position-absolute top-50 start-50 translate-middle text-white text-center middle">
            <h4><a href="http://127.0.0.1:8000/products/8/radha-krishan" class="text-white text-decoration-none text">Radha Krishna</a></h4>
          </div>
        </div>
      </div>

      <!-- Right promo -->
      <div class="col-md-7 p-0 ">
        <div class="row g-0">
          <div class="col-6 abc">
            <div class="position-relative">
              <img src="{{ URL::asset('image/products/3.jpg'); }}" alt="img" class="img-fluid w-100 image">
              <div class="position-absolute top-50 start-50 translate-middle text-white text-center middle">
                <h4><a href="http://127.0.0.1:8000/products/8/radha-krishan" class="text-white text-decoration-none text">Radha Krishna</a></h4>
              </div>
            </div>
          </div>
          <div class="col-6 abc">
            <div class="position-relative">
              <img src="{{ URL::asset('image/products/5.jpg'); }}" alt="img" class="img-fluid w-100 image">
              <div class="position-absolute top-50 start-50 translate-middle text-white text-center middle">
                <h4><a href="http://127.0.0.1:8000/products/8/radha-krishan" class="text-white text-decoration-none text">Radha Krishna</a></h4>
              </div>
            </div>
          </div>
          <div class="col-6 abc">
            <div class="position-relative">
              <img src="{{ URL::asset('image/products/hanumanji.jpg'); }}" alt="img" class="img-fluid w-100 image">
              <div class="position-absolute top-50 start-50 translate-middle text-white text-center middle">
                <h4><a href="http://127.0.0.1:8000/products/9/hanumanji" class="text-white text-decoration-none text">Hanumanji</a></h4>
              </div>
            </div>
          </div>
          <div class="col-6 abc">
            <div class="position-relative">
              <img src="{{ URL::asset('image/products/8.JPG'); }}" alt="img" class="img-fluid w-100 image">
              <div class="position-absolute top-50 start-50 translate-middle text-white text-center middle">
                <h4><a href="http://127.0.0.1:8000/products/26/shiva" class="text-white text-decoration-none text">Shivji</a></h4>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section id="popular-section" class="py-5 bg-dark">
  <div class="container">
    <!-- Nav tabs -->
    <ul class="nav nav-tabs mb-4" id="productTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="popular-tab" data-bs-toggle="tab" data-bs-target="#popular" type="button" role="tab">Marble Stone Statues</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="featured-tab" data-bs-toggle="tab" data-bs-target="#featured" type="button" role="tab">Custom Portrait</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="latest-tab" data-bs-toggle="tab" data-bs-target="#latest" type="button" role="tab">Architectural Stone Carvings</button>
      </li>
    </ul>

    <!-- Tab panes -->
    <div class="tab-content" id="productTabContent">
      <!-- Popular Products -->
      <div class="tab-pane fade show active" id="popular" role="tabpanel">
        <div class="row g-4">
          <!-- Single Product -->
          <div class="col-md-3 abc">
            <div class="card h-100">
              <img src="{{ URL::asset('image/products/1.JPG'); }}" class="card-img-top image" alt="Polo Shirt">
              <div class="position-absolute top-50 start-50 translate-middle text-white text-center middle">
                <h4><a href="#" class="text-white text-decoration-none text">Ram Drabar</a></h4>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card h-100">
              <img src="{{ URL::asset('image/products/3.jpg'); }}" class="card-img-top" alt="Polo Shirt">
              <div class="card-body text-center">
                <h5 class="card-title"><a href="#">Polo T-Shirt</a></h5>
                <p class="card-text text-muted mb-1">$45.50 <del>$65.50</del></p>
                <a href="#" class="btn btn-dark btn-sm"><i class="fa fa-shopping-cart me-1"></i>Add To Cart</a>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card h-100">
              <img src="{{ URL::asset('image/products/4.jpg'); }}" class="card-img-top" alt="Polo Shirt">
              <div class="card-body text-center">
                <h5 class="card-title"><a href="#">Polo T-Shirt</a></h5>
                <p class="card-text text-muted mb-1">$45.50 <del>$65.50</del></p>
                <a href="#" class="btn btn-dark btn-sm"><i class="fa fa-shopping-cart me-1"></i>Add To Cart</a>
              </div>
            </div>
          </div>

          <div class="col-md-3">
            <div class="card h-100">
              <img src="{{ URL::asset('image/products/radha krishna.jpg'); }}" class="card-img-top" alt="Polo Shirt">
              <div class="card-body text-center">
                <h5 class="card-title"><a href="#">Polo T-Shirt</a></h5>
                <p class="card-text text-muted mb-1">$45.50 <del>$65.50</del></p>
                <a href="#" class="btn btn-dark btn-sm"><i class="fa fa-shopping-cart me-1"></i>Add To Cart</a>
              </div>
            </div>
          </div>
          
          <!-- Repeat similar .col-md-3 blocks for each product -->
        </div>
        <div class="text-center mt-4">
          <a href="#" class="btn btn-outline-dark">Browse all Products <i class="fa fa-long-arrow-right ms-2"></i></a>
        </div>
      </div>

      <!-- Featured and Latest can be copied similarly with product rows -->
      <div class="tab-pane fade" id="featured" role="tabpanel">
        <!-- Similar product cards go here -->
        <div class="row g-4">
          <!-- Single Product -->
          <div class="col-md-3">
            <div class="card h-100">
              <img src="{{ URL::asset('7.jpg'); }}" class="card-img-top" alt="Polo Shirt">
              <div class="card-body text-center">
                <h5 class="card-title"><a href="#">Polo T-Shirt</a></h5>
                <p class="card-text text-muted mb-1">$45.50 <del>$65.50</del></p>
                <a href="#" class="btn btn-dark btn-sm"><i class="fa fa-shopping-cart me-1"></i>Add To Cart</a>
              </div>
            </div>
          </div>
          <div class="text-center mt-4">
          <a href="#" class="btn btn-outline-dark">Browse all Products <i class="fa fa-long-arrow-right ms-2"></i></a>
        </div>
          <!-- Repeat similar .col-md-3 blocks for each product -->
        </div>
      </div>
      <div class="tab-pane fade" id="latest" role="tabpanel">
        <!-- Similar product cards go here -->
        <div class="row g-4">
          <!-- Single Product -->
          <div class="col-md-3">
            <div class="card h-100">
              <img src="{{ URL::asset('7.jpg'); }}" class="card-img-top" alt="Polo Shirt">
              <div class="card-body text-center">
                <h5 class="card-title"><a href="#">Polo T-Shirt</a></h5>
                <p class="card-text text-muted mb-1">$45.50 <del>$65.50</del></p>
                <a href="#" class="btn btn-primary btn-sm"><i class="fa fa-shopping-cart me-1"></i>Add To Cart</a>
              </div>
            </div>
          </div>
          <div class="text-center mt-4">
          <a href="#" class="btn btn-outline-dark">Browse all Products <i class="fa fa-long-arrow-right ms-2"></i></a>
        </div>
          <!-- Repeat similar .col-md-3 blocks for each product -->
        </div>
      </div>
    </div>
  </div>
  </section>
  <!-- Support Section -->
<section id="aa-support" class="py-5 bg-dark">
  <div class="container">
    <div class="row text-center">
      <!-- Single Support -->
      <div class="col-md-4 mb-4">
        <div class="p-4 border rounded h-100">
        <img src="{{ URL::asset('worldwide-delivery.png'); }}" alt="testimonial img" width="100" height="100">
          <h4 class="fw-bold text">Worldwide Delivery</h4>
          <p class="fw-bold">“We partner with trusted global carriers like DHL, FedEx, and UPS to ensure safe and timely delivery of our idols, statues, temples, and handicraft items to customers worldwide.”</p>
        </div>
      </div>
      <!-- Single Support -->
      <div class="col-md-4 mb-4">
        <div class="p-4 border rounded h-100">
        <img src="{{ URL::asset('customization.png'); }}" alt="testimonial img" width="100" height="100">
          <h4 class="fw-bold text">Customization</h4>
          <p>"We craft custom marble figurines tailored to your vision—be it a specific design, color, or concept."</p>
        </div>
      </div>
      <!-- Single Support -->
      <div class="col-md-4 mb-4">
        <div class="p-4 border rounded h-100">
        <img src="{{ URL::asset('satisfaction-guaranteed.png'); }}" alt="testimonial img" width="100" height="100">
          <h4 class="fw-bold text">Satisfaction Guaranteed</h4>
          <p>"Your satisfaction is our priority. We stand behind the quality of our products and are committed to ensuring you're completely happy with your purchase."</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Testimonial Section -->
<section id="aa-testimonial" class="py-5">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <div id="testimonialCarousel" class="carousel slide" data-bs-ride="carousel">
          <div class="carousel-inner">

            <!-- Slide 1 -->
            <div class="carousel-item active text-center">
              <img src="{{ URL::asset('Onwer.jpg'); }}" class="rounded-circle mb-3" alt="testimonial img" width="200" height="200">
              <i class="fa fa-quote-left fa-2x text-secondary mb-3 d-block"></i>
              <p class="px-3">Owner</p>
              <!-- <div>
                <p class="fw-bold mb-0">Allison</p>
                <span class="text-muted">Designer</span><br>
                <a href="#">Dribble.com</a>
              </div> -->
            </div>

            <!-- Slide 2 -->
            <div class="carousel-item text-center">
            <img src="{{ URL::asset('co-onwer.jpg'); }}" class="rounded-circle mb-3" alt="testimonial img" width="200" height="200">
              <i class="fa fa-quote-left fa-2x text-secondary mb-3 d-block"></i>
              <p class="px-3">Co-Owner</p>
            </div>

            <!-- Slide 3 -->
            <div class="carousel-item text-center">
            <img src="{{ URL::asset('manufecture.jpg'); }}" class="rounded-circle mb-3" alt="testimonial img" width="200" height="200">
              <i class="fa fa-quote-left fa-2x text-secondary mb-3 d-block"></i>
              <p class="px-3">Manufacturer</p>
            
            </div>

          </div>

          <!-- Carousel Controls -->
          <button class="carousel-control-prev" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
          </button>
          <button class="carousel-control-next" type="button" data-bs-target="#testimonialCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
          </button>

        </div>
      </div>
    </div>
  </div>
</section>

<!-- Latest Blog -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-bold made">How to made Marble Staone Statues</h2>
    </div>
    <div class="row">
      <!-- Single Blog Post -->
      <div class="col-md-4 mb-4">
        <div class="card h-100">
          <figure class="mb-0">
          <iframe width="355" height="250" src="https://www.youtube.com/embed/9wi_2bOAPno?si=tgZs5eiZvHYL01kj" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </figure>
          <div class="card-body">
          <p class="card-title"><span style="color:#ff6666;">Marble Staone Statues</span></p>
          </div>
        </div>
      </div>

      <!-- Repeat for 2nd blog post -->
      <div class="col-md-4 mb-4">
        <div class="card h-100">
        <figure class="mb-0">
          <iframe width="355" height="250" src="https://www.youtube.com/embed/9wi_2bOAPno?si=tgZs5eiZvHYL01kj" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </figure>
          <div class="card-body">
          <p class="card-title"><span style="color:#ff6666;">Marble Staone Statues</span></p>
          </div>
        </div>
      </div>

      <!-- Repeat for 3rd blog post -->
      <div class="col-md-4 mb-4">
        <div class="card h-100">
        <figure class="mb-0">
          <iframe width="355" height="250" src="https://www.youtube.com/embed/9wi_2bOAPno?si=tgZs5eiZvHYL01kj" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
          </figure>
          <div class="card-body">
            <p class="card-title"><span style="color:#ff6666;">Marble Staone Statues</span></p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>


@endsection