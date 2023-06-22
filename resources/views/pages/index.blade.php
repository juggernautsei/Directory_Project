@extends('app')

@section('content')

 <!-- ================================
     Start Hero Wrapper Area
================================= -->
<section class="hero-wrapper-area hero-bg" style="background-image: url({{URL::to('upload/'.getcong('home_bg_image'))}});">
    <div class="overlay"></div>
    <div class="container">
        <div class="hero-heading text-center">
            <h2 class="item_sec_title text-white cd-headline zoom">
                {{getcong('home_title')}}
                <span class="cd-words-wrapper">
                    <?php $n=1?>
                    @foreach(explode(',',getcong('home_categories_ids')) as $categories_ids)
                    
                    @if($n==1)
                        <b class="is-visible">{{App\Models\Categories::getCategoryInfo($categories_ids)->category_name}}</b>
                    @else
                        <b>{{App\Models\Categories::getCategoryInfo($categories_ids)->category_name}}</b>
                    @endif
                    
                     <?php $n++;?>
                    @endforeach
 
                </span>
            </h2>
            <p class="item_sec_desc text-white">{{getcong('home_sub_title')}}</p>
        </div>
        <div class="card">
             
                {!! Form::open(array('url' => 'listings/','method'=>'get','class'=>'card-body row pb-1','id'=>'search','role'=>'form')) !!}
                <div class="col-lg-4 pr-lg-0">
                    <div class="form-group">
                        <input class="form-control form--control" type="text" name="search_text" placeholder="{{trans('words.search_anything')}}">
                        <span class="fal fa-search form-icon"></span>
                    </div>
                </div>
                <div class="col-lg-3 pr-lg-0">
                    <div class="form-group">
                        <select class="select-picker" name="location_id" data-width="100%" data-size="5" data-live-search="true">
                            <option value="">{{trans('words.select_location')}}</option>                             
                            @foreach(\App\Models\Location::orderBy('location_name')->get() as $location) 
                            <option value="{{$location->id}}">{{$location->location_name}}</option> 
                            @endforeach                                                     
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 pr-lg-0">
                    <div class="form-group">
                        <select class="select-picker" name="cat_id" data-width="100%" data-size="5" data-live-search="true">
                            <option value="">{{trans('words.select_category')}}</option>                             
                            @foreach(\App\Models\Categories::get() as $i => $category) 
                                <option value="{{$category->id}}">{{$category->category_name}}</option> 
                            @endforeach                                                     
                        </select>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <button class="primary_item_btn border-0 w-100" type="submit">{{trans('words.search')}}</button>
                    </div>
                </div>
                {!! Form::close() !!} 
             
        </div>        
         
    </div>
</section>
<!-- ================================
     End Hero Wrapper Area
================================= -->

<!-- ================================
     Start Category Area
================================= -->
<section class="category_area bg-gray section_item_padding">
    <div class="container">
        <div class="text-center">
            <h2 class="item_sec_title mb-3">{{trans('words.popular_cat')}}</h2>             
        </div>
        <div class="row mt-5">
            @foreach(explode(',',getcong('home_categories_ids')) as $categories_ids)
            <div class="col-lg-3 col-md-4 col-sm-6 col-xs-6">
                <a href="{{URL::to('categories/'.App\Models\Categories::getCategoryInfo($categories_ids)->category_slug.'/'.$categories_ids)}}" class="sec_category_item d-block hover-y" title="category">
                    <div class="overlay"></div>
                    
                    @if(App\Models\Categories::getCategoryInfo($categories_ids)->category_image)
                        <img src="{{URL::to('assets/images/img-loading.jpg')}}" data-src="{{URL::to('upload/category/'.App\Models\Categories::getCategoryInfo($categories_ids)->category_image)}}" alt="category-image" class="category-img lazy" title="category">

                    @else
                        <img src="{{URL::to('assets/images/img-loading.jpg')}}" data-src="{{URL::to('upload/category/default.jpg')}}" alt="category-image" class="category-img lazy" title="category">
                    @endif

                    <div class="category-content d-flex align-items-center justify-content-center">
                        <span class="fal {{App\Models\Categories::getCategoryInfo($categories_ids)->category_icon}} icon-element d-block mx-auto animate-rotate-me"></span>
                        <div class="cat_text_item">
                            <h4 class="cat-title mb-1">{{App\Models\Categories::getCategoryInfo($categories_ids)->category_name}}</h4>
                            <span class="badge">{{ \App\Models\Categories::countCategoryListings($categories_ids) }}  {{trans('words.listings')}}</span>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach             
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 d-block justify-content-center text-center mt-3">
				<a href="{{URL::to('categories/')}}" class="primary_item_btn mx-auto" title="Categories">{{trans('words.view_all_cat')}}</a>
			</div>
        </div>
    </div>
</section>
<!-- ================================
     End Category Area
================================= -->

@if(count($featured_listings) > 0)

<!-- ================================
     Start Card Area
================================= -->
<section class="listing_card_area section_item_padding">
    <div class="container">
        <div class="text-center">
            <h2 class="item_sec_title mb-3">{{trans('words.featured_listings')}}</h2>
             
        </div>
        <div class="card-carousel owl-carousel owl-theme mt-5">
            @foreach($featured_listings as $listing) 

            <div class="card mb-0 hover-y">
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
 
            @endforeach
              
             
        </div>
    </div>
</section>
<!-- ================================
     End Card Area
================================= -->
@endif
 

 
@endsection