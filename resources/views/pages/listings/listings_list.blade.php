@extends('app')

@section('head_title', trans('words.listings').' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")

 
<!-- ================================
     Start Breadcrumb Area
================================= -->
<section class="breadcrumb-area" style="background-image:url({{URL::to('assets/images/bread-bg.jpg')}})">
    <div class="overlay"></div>
    <div class="container">
        <div class="breadcrumb-content">
            <h2 class="item_sec_title text-white">{{trans('words.listings')}}</h2>
            <ul class="bread-list">
                <li><a href="{{URL::to('/')}}" title="Home">{{trans('words.home')}}</a></li>
                <li>{{trans('words.listings')}}</li>
            </ul>
        </div>
    </div>    
</section>
<!-- ================================
     End Breadcrumb Area Area
================================= --> 

<!-- ================================
    Start Card Area
================================= -->
<section class="listing_card_area bg-gray section_item_padding">
    <div class="container">
        <div class="row">
            <div class="col-lg-4">
                
                @include("pages.listings.sidebar")

            </div>
            
            <div class="col-lg-8">
                 
                <div class="row">
                    @foreach($listings as $listing) 
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="card hover-y">
                            <a href="{{URL::to('listings/'.$listing->listing_slug.'/'.$listing->id)}}" class="card-image" title="{{$listing->title}}">
                                <img src="{{URL::to('assets/images/img-loading.jpg')}}" data-src="{{ URL::asset('upload/listings/'.$listing->featured_image.'-s.jpg') }}" class="card-img-top lazy" alt="card image" title="{{$listing->title}}">                                 
                                <div class="list-tag-badge"><span class="fal {{\App\Models\Categories::getCategoryInfo($listing->cat_id)->category_icon}} icon-element icon-element-sm"></span> {{\App\Models\Categories::getCategoryInfo($listing->cat_id)->category_name}}</div>
                            </a>
                            <div class="card-body position-relative">
                                <div class="d-flex align-items-center mb-1">
                                    <h4 class="card-title mb-0"><a href="{{URL::to('listings/'.$listing->listing_slug.'/'.$listing->id)}}" title="{{$listing->title}}">{{$listing->title}}</a></h4>
                                     
                                </div>
                                <p class="card-text"><i class="fal fa-map-marker-alt icon"></i>{{Str::limit($listing->address,50)}}</p>
                                 
                            </div>
                            <div class="card-footer bg-transparent border-top-gray d-flex align-items-center justify-content-between">
                                <div class="star-rating" @if($listing->review_avg) data-rating="{{$listing->review_avg}}"@endif>
                                    <div class="rating-counter">{{\App\Models\Reviews::getTotalReview($listing->id)}} {{trans('words.reviews')}}</div>
                                </div>                                 
                            </div>
                        </div>
                    </div>
                    @endforeach

                     
                     
                </div>
                <nav aria-label="navigation">
                    @include('common.pagination', ['paginator' => $listings])
                </nav>
            </div>
        </div>        
    </div>
</section>
<!-- ================================
     End Card Area
================================= -->
<script src="{{ URL::asset('assets/js/jquery-3.4.1.min.js') }}"></script>
<script>
   $(function(){

    $('#fiveStarRadio,#fourStarRadio,#threeStarRadio,#twoStarRadio,#oneStarRadio').on('click', function () {
          var rate_val = $(this).val(); // get selected value
          
          var url = '{{URL::to('listings/')}}?rate='+rate_val;
 
          if (url) { // require a URL
              window.location = url; // redirect
          }
          return false;
      });

    
    });

</script>
 
@endsection