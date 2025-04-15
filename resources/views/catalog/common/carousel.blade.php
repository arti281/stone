<div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
  <div class="carousel-indicators">
   @if (count($banners) > 1)
    @foreach ($banners as $key => $banner)
      <button type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide-to="{{$key}}" @if($key == 0) class="active" aria-current="true"  @endif aria-label="Slide {{$key+1}}"></button>
    @endforeach
   @endif
  </div>
  <div class="carousel-inner">
    @foreach ($banners as $banner)    
      <div class="carousel-item active" data-bs-interval="3000">
        <img src="{{ URL::asset('image/banner/'.$banner->image) }}" class="d-block w-100 carousel-image" alt="{{$banner->title}}">
      </div>
    @endforeach
  </div>
  @if (count($banners) > 1 )     
    <button class="carousel-control-prev custom_prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
      <span><i class="fa-solid fa-chevron-left"></i></span>
      <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next custom_next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
      <span><i class="fa-solid fa-chevron-right"></i></span>
      <span class="visually-hidden">Next</span>
    </button>
  @endif
</div>