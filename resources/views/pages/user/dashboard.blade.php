@extends('app')

@section('head_title',trans('words.dashboard').' | '.getcong('site_name') )

@section('head_url', Request::url())

@section("content")

 
<!-- ================================
     Start Breadcrumb Area
================================= -->
<section class="breadcrumb-area" style="background-image:url({{URL::to('assets/images/bread-bg.jpg')}})">
    <div class="overlay"></div>
    <div class="container">
        <div class="breadcrumb-content">
            <h2 class="item_sec_title text-white">{{trans('words.dashboard')}}</h2>
            <ul class="bread-list">
                <li><a href="{{URL::to('/')}}">{{trans('words.home')}}</a></li>
                <li>{{trans('words.dashboard')}}</li>
            </ul>
        </div>
    </div>    
</section>
<!-- ================================
     End Breadcrumb Area Area
================================= --> 

<!-- ================================
    Start Dashboard Area
================================= -->
<section class="dashboard-area bg-gray section_item_padding">
    <div class="container">

            @if(Session::has('flash_message'))
                    <div class="alert alert-success">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                        {{ Session::get('flash_message') }}
                    </div>
            @endif

            @if(Session::has('error_flash_message'))
                    <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                      <span aria-hidden="true">&times;</span></button>
                        {{ Session::get('error_flash_message') }}
                    </div>
            @endif

        <div class="row">
 
            <div class="col-lg-4 col-md-5 col-sm-12 col-xs-12">               
               <div class="profile-block card card-body">
                 <div class="img-profile">
                        
                      @if(Auth::user()->image_icon)
                        <img alt="User Photo" src="{{URL::to('upload/members/'.Auth::user()->image_icon)}}" class="img-rounded" alt="profile_img" title="profile pic">
                      @else
                        <img src="{{URL::to('assets/images/avatar.jpg')}}" class="img-rounded" alt="profile_img" title="profile pic">
                      @endif

                        
                </div>
                   <div class="profile-title-item">
                      <h5>{{Auth::user()->first_name.' '.Auth::user()->last_name}}</h5>
                      <span>{{Auth::user()->email}}</span>
                      <a href="{{URL::to('profile')}}" class="primary_item_btn mb-2 mr-1">{{trans('words.edit_profile')}}</a>
                    </div>
               </div>
               <div class="card">
                   <div class="card-body">
                       <h4 class="card-title mb-3">{{trans('words.plan_info')}}</h4>
                       @if($user->plan_id!=0) 
                       <ul class="list-items mb-4">
                           <li>{{trans('words.plan_name')}}:  {{\App\Models\SubscriptionPlan::getSubscriptionPlanInfo($user->plan_id)->plan_name}} </li>
                           
                           <li>{{trans('words.purchase_date')}}:  <span style="background: #5cb85c;color: #ffffff;padding: 3px 6px;border-radius: 4px;">{{date('D, d M Y',$user->start_date)}}</span> </li>

                           <li>{{trans('words.expiry_date')}}: <span style="background: #ea5555;color: #ffffff;padding: 3px 6px;border-radius: 4px;">{{date('D, d M Y',$user->exp_date)}}</span>  </li>
                           
                           <li>{{trans('words.listings')}} {{trans('words.allowed')}}:  {{\App\Models\SubscriptionPlan::getSubscriptionPlanInfo($user->plan_id)->plan_listing_limit}} </li>
                        </ul>
                        <a href="{{URL::to('pricing')}}" class="primary_item_btn mb-2 mr-1">{{trans('words.upgrade_plan')}}</a>   
                        @else
                        <a href="{{URL::to('pricing')}}" class="primary_item_btn mb-2 mr-1">{{trans('words.select_plan')}}</a>    
                        @endif
                   </div>
               </div>
            </div>
            <div class="col-lg-8 col-md-7 col-sm-12 col-xs-12">
                <div class="row dashboard-list-item">
                    <div class="col-lg-4">
                        <div class="icon-card">
                            <div class="icon purple"><i class="fal fa-list"></i></div>
                            <div class="content">
                              <h6 class="mb-10">{{trans('words.all_listings')}}</h6>
                              <h3 class="text-bold mb-10">{{$total_listings}}</h3>                             
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="icon-card">
                            <div class="icon success"><i class="fal fa-check-circle"></i></div>
                            <div class="content">
                              <h6 class="mb-10">{{trans('words.published')}}</h6>
                              <h3 class="text-bold mb-10">{{$publish_listings}}</h3>                             
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="icon-card">
                            <div class="icon primary"><i class="fal fa-clock"></i></div>
                            <div class="content">
                              <h6 class="mb-10">{{trans('words.pending')}}</h6>
                              <h3 class="text-bold mb-10">{{$pending_listings}}</h3>                             
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                      <div class="table-wrapper">
                         <table class="fl-table">
                            <thead>
                                <tr>
                                    <th>#{{trans('words.id')}}</th>
                                    <th>{{trans('words.title')}}</th>
                                    <th>{{trans('words.status')}}</th>
                                    <th>{{trans('words.actions')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($my_listings as $listings_data)
                                <tr>
                                    <td>{{$listings_data->id}}</td>
                                    <td class="user-list-title"><span>{{$listings_data->title}}</span></td>
                                    <td>
                                    @if($listings_data->status==0)
                                        <span class="expires-plan-item">{{trans('words.pending')}}</span>     @else
                                        <span class="current-plan-item">{{trans('words.published')}}</span>
                                    @endif
                                    </td>
                                     
                                    <td>
                                        <a href="{{URL::to('edit_listing/'.$listings_data->id)}}" class="btn btn-sm edit-btn bg-success text-white mr-1">{{trans('words.edit')}}</a>
                                        <a href="{{URL::to('delete_listing/'.$listings_data->id)}}" class="btn btn-sm delete-btn bg-danger text-white" onclick="return confirm('{{trans('words.remove_cofirm_msg')}}')">{{trans('words.delete')}}</a>
                                    </td>
                                </tr>
                                @endforeach
                                 
                            </tbody>
                            <tbody></tbody>
                         </table>
                      </div>
                    </div>
                     
                     
                </div>
           </div>
        </div>
    </div>
</section>
<!-- ================================
     End Dashboard Area
================================= --> 

 
@endsection