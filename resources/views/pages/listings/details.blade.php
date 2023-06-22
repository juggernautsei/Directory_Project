@extends('app')

@section('head_title', $listing->title.' | '.getcong('site_name') )

@section('head_image', URL::asset('upload/listings/'.$listing->featured_image.'-b.jpg'))

@section('head_url', Request::url())

@section("content")

<style>
.video-box {
    float: none;
    clear: both;
    width: 100%;
    position: relative;
    padding-bottom: 56.25%;
    padding-top: 25px;
    height: 0;
}
.video-box iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

iframe { height: 400px; }
</style>
 
<!-- ================================
     Start Breadcrumb Area
================================= -->
<section class="breadcrumb-area" style="background-image:url({{ URL::asset('upload/listings/'.$listing->featured_image.'-b.jpg') }})">
    <div class="overlay opacity-8"></div>
    <div class="container">
        <div class="breadcrumb-content">
            <h2 class="item_sec_title text-white text-left mb-2">{{$listing->title}}</h2>
            <p class="item_sec_desc text-white"><i class="fal fa-map-marker-alt mr-1"></i> {{$listing->address}}</p>
            <ul class="listing-info my-3">
                <li>
                    <span class="primary_item_btn primary_item_btn-sm listing-tag"><i class="fal {{\App\Models\Categories::getCategoryInfo($listing->cat_id)->category_icon}} mr-1 font-size-13"></i> {{\App\Models\Categories::getCategoryInfo($listing->cat_id)->category_name}}</span>
                </li>
                <li>
                    <div class="primary_item_btn primary_item_btn-sm average-ratings bg-success mr-1">{{$listing->review_avg}} <i class="fas fa-star ml-1 font-size-12"></i></div> <span class="text-white">{{\App\Models\Reviews::getTotalReview($listing->id)}} {{trans('words.reviews')}}</span>
                </li>
            </ul>
            <div class="d-flex flex-wrap align-items-center justify-content-between">
                <div class="bread-btns my-1">
                     
                    <a title="share" href="#" class="primary_item_btn primary_item_btn-sm mb-2 mr-1" data-toggle="modal" data-target="#shareModal"><i class="far fa-share mr-1 font-size-13"></i> {{trans('words.share')}}</a>                    
                     
                </div>                
            </div>
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

        @if(Session::has('flash_message'))

          <div class="alert alert-success">
              
             {{ Session::get('flash_message') }}
           </div>
             
        @endif

        @if(Session::has('error_flash_message'))

          <div class="alert alert-danger">
              
             {{ Session::get('error_flash_message') }}
           </div>
             
        @endif

        @if (count($errors) > 0)
            <div class="alert alert-danger">
            
                <ul style="list-style: none;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
 

        <div class="row">
            <div class="col-lg-8 mb-4">
                <div class="listing-wrapper">
                    <div class="detail-listing-item mb-5">
                        <h4 class="title_item">{{trans('words.description')}}</h4>
                        <p>{!!$listing->description!!}</p>
                    </div>

                    @if(checkUserPlanFeatures($listing->user_id,'plan_gallery_images_option')==1 AND count($listing_gallery_images) > 0)
                    <div class="detail-listing-item mb-5">
                        <h4 class="title_item">{{trans('words.photos_gallery')}}</h4>
                        <div class="gallery-carousel owl-carousel owl-theme">
                            
                            @foreach($listing_gallery_images as $i => $gallery_img)
                            <div class="gallery-item"><img src="{{ URL::asset('upload/gallery/'.$gallery_img->image_name) }}" alt="gallery-image" title="gallery"></div>
                            @endforeach
                             
                        </div>                      
                    </div>
                    @endif

                    @if(checkUserPlanFeatures($listing->user_id,'plan_amenities_option')==1 AND $listing->amenities)
                    <div class="detail-listing-item mb-5">
                        <h4 class="title_item">Amenities</h4>
                        <div class="row">
                            <div class="col-lg-4">
                                <ul class="list-items">
                                    @foreach(explode(',', $listing->amenities) as $amenities_info)     
                                    <li><i class="fal fa-check-circle mr-1 text-success"></i> {{$amenities_info}}</li>
                                    @endforeach
                                </ul>
                            </div>
                             
                        </div>
                    </div>
                    @endif

                    @if(checkUserPlanFeatures($listing->user_id,'plan_video_option')==1 AND $listing->video)
                    <div class="detail-listing-item mb-5">
                        <h4 class="title_item">{{trans('words.video')}}</h4>
                        <div class="video-box text-center position-relative">
                           
                            {!!$listing->video!!}                                
                            
                        </div>
                    </div>
                    @endif

                    @if($listing->google_map_code)
                    <div class="detail-listing-item mb-5">
                        <h4 class="title_item">{{trans('words.location')}}</h4>
                        <div id="map-single" class="w-100" style="position: relative;overflow: hidden;">
                            {!!$listing->google_map_code!!}                            
                        </div>                        
                    </div>
                    @endif

                    <div class="detail-listing-item mb-5">
                          
                        <div class="reviews">
                            <h4 class="title_item">{{trans('words.reviews')}}<span class="badge badge-light">({{\App\Models\Reviews::getTotalReview($listing->id)}})</span></h4>
                            <div class="comments-wrapper">
                                @foreach($listing_reviews as $i => $reviews)
                                <div class="comment media mb-5">
                                    <a href="{{URL::to('user_listings/'.$reviews->user_id)}}" class="user-avatar flex-shrink-0 d-block mr-3" title="user">
                                    @if(\App\Models\User::getUserInfo($reviews->user_id)->image_icon)
                                    <img src="{{ URL::asset('upload/members/'.\App\Models\User::getUserInfo($reviews->user_id)->image_icon) }}" alt="author-img" title="user photo">
                                @else
                                     <img src="{{URL::to('assets/images/avatar.jpg')}}" alt="avatar" title="user photo">
                                @endif

                                        
                                    </a>
                                    <div class="comment-body media-body">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="user-comment-title">
                                                <h4 class="comment-title"><a href="{{URL::to('user_listings/'.$reviews->user_id)}}" title="user">{{\App\Models\User::getUserInfo($reviews->user_id)->first_name.' '.\App\Models\User::getUserInfo($reviews->user_id)->last_name}}</a></h4>
                                                 
                                            </div>
                                            <div class="star-rating" data-rating="{{$reviews->rating}}"></div>
                                        </div>
                                        <p class="comment-desc mt-2">{{$reviews->review}}</p>
                                          
                                    </div>
                                </div>
                                @endforeach
                                 
                                 
                            </div>
                            <hr class="border-top-gray mt-0">
                             
                        </div>
                    </div>
                    <div class="detail-listing-item">
                        <h4 class="font-size-20 font-weight-semi-bold mb-1">{{trans('words.add_review')}}</h4>
                         
                        <hr class="border-top-gray mt-2 mb-4">
                        <div class="add-review-wrap" id="review">
                             {!! Form::open(array('url' => array('submit_review'),'class'=>'row mt-4','name'=>'review_form','id'=>'review_form','role'=>'form','enctype' => 'multipart/form-data')) !!}    
                                <input type="hidden" name="listing_id" value="{{$listing->id}}">
                                <div class="col-lg-12">
									<div class="leave-rating mb-3">
										<input type="radio" name="rating" id="rating-1" value="5">
										<label for="rating-1" class="fas fa-star"></label>
										<input type="radio" name="rating" id="rating-2" value="4">
										<label for="rating-2" class="fas fa-star"></label>
										<input type="radio" name="rating" id="rating-3" value="3">
										<label for="rating-3" class="fas fa-star"></label>
										<input type="radio" name="rating" id="rating-4" value="2">
										<label for="rating-4" class="fas fa-star"></label>
										<input type="radio" name="rating" id="rating-5" value="1">
										<label for="rating-5" class="fas fa-star"></label>
									</div>
								</div>
                                <div class="col-lg-12">
                                    <label class="label-text">{{trans('words.review')}}</label>
                                    <div class="form-group">
                                        <textarea class="form-control form--control pl-3" rows="5" name="review" placeholder="{{trans('words.write_review')}}"></textarea>
                                    </div>
                                </div>
                                 
                                <div class="col-lg-12">
                                    <button class="primary_item_btn border-0" type="submit">{{trans('words.submit_review')}}</button>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="sidebar">
                     
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">{{trans('words.posted_by')}}</h4>
                            <div class="media mt-4">
                                @if(\App\Models\User::getUserInfo($listing->user_id)->image_icon)
                                <img src="{{ URL::asset('upload/members/'.\App\Models\User::getUserInfo($listing->user_id)->image_icon) }}" alt="avatar" class="user-avatar flex-shrink-0 mr-3" title="user photo">
                                @else
                                <img src="{{URL::to('assets/images/avatar.jpg')}}" alt="avatar" class="user-avatar flex-shrink-0 mr-3" title="user photo">
                                @endif
                                

                                <div class="media-body align-self-center">
                                    <h4 class="font-size-18 font-weight-semi-bold mb-1"><a href="{{URL::to('user_listings/'.$listing->user_id)}}" class="text-black" title="user">{{ \App\Models\User::getUserFullname($listing->user_id) }}</a></h4>
                                 </div>
                            </div>
                            <ul class="list-items mt-4">
                                <li><span class="fal fa-envelope icon-element icon-element-sm shadow-sm mr-2 font-size-14"></span> <a href="mailto:{{ \App\Models\User::getUserInfo($listing->user_id)->contact_email }}" title="email">{{ \App\Models\User::getUserInfo($listing->user_id)->contact_email }}</a></li>
                                <li><span class="fal fa-phone icon-element icon-element-sm shadow-sm mr-2 font-size-14"></span> <a href="tel:{{ \App\Models\User::getUserInfo($listing->user_id)->mobile }}" title="phone">{{ \App\Models\User::getUserInfo($listing->user_id)->mobile }}</a></li>
                                <li><span class="fal fa-globe icon-element icon-element-sm shadow-sm mr-2 font-size-14"></span> <a href="{{ \App\Models\User::getUserInfo($listing->user_id)->website }}" target="_blank" title="website">{{ \App\Models\User::getUserInfo($listing->user_id)->website }}</a></li>
                            </ul>
                            
                        </div>
                    </div>
                    
                    @if(checkUserPlanFeatures($listing->user_id,'plan_business_hours_option')==1)
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">{{trans('words.business_hours')}}</h4>
                            <ul class="list-items">
                                <li class="d-flex align-items-center justify-content-between"><span class="text-black">{{trans('words.monday')}}</span> {!!$listing->working_hours_mon!!}</li>
                                <li class="d-flex align-items-center justify-content-between"><span class="text-black">{{trans('words.tuesday')}}</span> {!!$listing->working_hours_tue!!}</li>
                                <li class="d-flex align-items-center justify-content-between"><span class="text-black">{{trans('words.wednesday')}}</span> {!!$listing->working_hours_wed!!}</li>
                                <li class="d-flex align-items-center justify-content-between"><span class="text-black">{{trans('words.thursday')}}</span> {!!$listing->working_hours_thurs!!}</li>
                                <li class="d-flex align-items-center justify-content-between"><span class="text-black">{{trans('words.friday')}}</span> {!!$listing->working_hours_fri!!}</li>
                                <li class="d-flex align-items-center justify-content-between"><span class="text-black">{{trans('words.saturday')}}</span> {!!$listing->working_hours_sat!!}</li>
                                <li class="d-flex align-items-center justify-content-between"><span class="text-black">{{trans('words.sunday')}}</span> <span class="text-danger">{!!$listing->working_hours_sun!!}</span></li>
                            </ul>
                        </div>
                    </div>
                    @endif
                    
                    @if(checkUserPlanFeatures($listing->user_id,'plan_enquiry_form')==1)
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title mb-3">{{trans('words.send_enquiry')}}</h4>
                            {!! Form::open(array('url' => 'inquiry_send','class'=>'','id'=>'inquiry_form','role'=>'form')) !!}
                            
                            <input name="listing_id" type="hidden" value="{{$listing->id}}" >
 

                            <div class="form-group">
                                <input id="name" class="form-control form--control pl-3" type="text" name="name" value="" placeholder="{{trans('words.enter_name')}}" required>
                            </div>
                            <div class="form-group">
                                <input id="phone" class="form-control form--control pl-3" type="text" name="phone" placeholder="{{trans('words.phone_number')}}">
                            </div>
                            <div class="form-group">
                                <input id="email" class="form-control form--control pl-3" type="email" name="email" placeholder="{{trans('words.enter_email')}}" required>
                            </div>
                            <div class="form-group">
                                <textarea id="message" class="form-control form--control pl-3" rows="4" name="message" placeholder="{{trans('words.message')}}" required></textarea>
                            </div>
                            <button id="send-message-btn" class="primary_item_btn border-0" type="submit">{{trans('words.send_message')}}</button>
                            {!! Form::close() !!}
                        </div>
                    </div>  
                    @endif

                </div>
            </div>
        </div>
    </div>
</section>
<!-- ================================
    End Card Area
================================= -->

  
<!-- Share modal -->
<div class="modal fade modal-container" id="shareModal" tabindex="-1" role="dialog" aria-labelledby="shareModalTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header align-items-center">
                <h5 class="modal-title" id="shareModalTitle">{{trans('words.share_on_social')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true" class="fal fa-times"></span>
                </button>
            </div>
            <div class="modal-body">
                <div class="social-icons align-items-center mt-3 mb-3 text-center">
                    <a href="https://www.facebook.com/sharer/sharer.php?u={{URL::to('listings/'.$listing->listing_slug.'/'.$listing->id)}}" title="facebook"><i class="fab fa-facebook-f"></i></a>
                    <a href="https://twitter.com/intent/tweet?text={{$listing->title}}&amp;url={{URL::to('listings/'.$listing->listing_slug.'/'.$listing->id)}}" title="twitter"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.instagram.com/?url={{URL::to('listings/'.$listing->listing_slug.'/'.$listing->id)}}" title="instagram"><i class="fab fa-instagram"></i></a>
                    <a href="https://wa.me?text={{URL::to('listings/'.$listing->listing_slug.'/'.$listing->id)}}" title="whatsapp"><i class="fab fa-whatsapp"></i></a>
                </div>  
            </div>
        </div>
    </div>
</div>

 
@endsection