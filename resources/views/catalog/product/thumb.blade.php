<style>
  .category_heading {
    box-shadow: 0px -1px 10px 2px #ddd;
}
</style>
@if ($products && $categories)
  @foreach ($categories as $category)
      <div class="row bg-white p-1 mt-3 border">
        <h4 class="mb-2 py-3 text-dark text-uppercase">{{ $category['category_name'] }}</h4>
        @foreach ($products as $product)
          @if ($category['category_id'] === $product->category_id)
            <div class="col-6 col-sm-4 col-md-4 col-lg-3">
              <a href="{{ route('catalog.product-detail', ['product_id' => $product->product_id, 'slug' => $product->slug]) }}">
                <div class="product-item">
                    <div class="image-holder">
                      <img src="{{ ($product->image) ? asset("image/cache/products").'/'.($product->product_id .'/'. str_replace(".jpg",'',$product->image) .'_700x700.jpg') : asset('not-image-available.png')}}" alt="{{$product->product_name}}" class="product-image" style="max-height:450px;object-fit:contain;">
                    </div>
                    {{-- <div class="cart-concern">
                      <div class="cart-button d-flex justify-content-center align-items-center p-1" style="background-color: #eceef1;">
                        <div class="col-6 border-end">
                          <a href="#" class="text-decoration-none text-dark pe-3">
                            <i class="fa-regular fa-heart p-2 fs-4 rounded-circle" style="color:#ff006f"></i>
                          </a>
                        </div>
                        <div class="col-6">
                          <a href="#" class="text-decoration-none text-dark">
                              <i class="fa-solid fa-cart-plus p-2 fs-4 rounded-circle" style="color:#ff006f"></i>
                          </a>
                        </div>
                      </div>
                    </div> --}}
                    <div class="product-detail">
                      <h3 class="product-title fs-6 truncate-lines mb-0"><small>{{$product->product_name}}</small></h3>
                      <p class="mb-0 text-muted truncate-lines" style="color:teal;font-size:13px">{{ $product->tag }}</p>
                      <span class="text-dark fs-6"><strong>Rs.{{ number_format($product->mrp, 0) }}</strong></span>
                    </div>
                </div>
              </a>
            </div>    
          @endif
        @endforeach
      </div>
  @endforeach
@endif