@extends('layouts.frontLayout.frontend_design')
@section('content')

<div class="smart_container">
    <div class="banner_secouter">
        <div class="banner_sec">
            <div class="banner_inn">
                <div class="container">
                <div class="row align-items-center">          
                        <div class="col-lg-8 m-auto">
                            <h4 class="bannerhead">India's Largest Real Estate Marketplace</h4>
                            @if (Session::has('searcherr'))
                                <div class="alert alert-success">
                                    {!! Session::get('searcherr') !!}
                                </div>
                            @endif
                            <div class="search_sec">
                                <div class="search_secinn">
                                    <ul class="nav nav-pills" id="searchTab" role="tablist">
                                    <?php $counter = 0; ?>
                                    @foreach($services as $service)
                                    @if($service->parent_id != 0)
                                    <?php $counter ++; ?>
                                        <li class="nav-item">
                                            <a class="nav-link <?=($counter == 1) ? 'active' : ''?>" id="search{{ $service->service_name }}-tab" data-toggle="tab" href="#search{{ $service->service_name }}" role="tab" aria-controls="search{{ $service->service_name }}" aria-selected="<?=($counter == 1) ? 'true' : ''?>">{{ $service->service_name }}</a>
                                        </li>
                                    @endif
                                    @endforeach
                                    </ul>
                                </div>
                                <div class="tab-content tab_conarea" id="myTabContent">
                                    <h5>Property search for rent and sales <a href="javascript:void(0)" data-toggle="modal" data-target="#exampleModalCenter">Advanced Search</a></h5>
                                    <?php $counter = 0; ?>
                                    @foreach($services as $service)
                                    @if($service->parent_id != 0)
                                    <?php $counter ++; ?>
                                    <div class="tab-pane fade show <?=($counter == 1) ? 'active' : ''?>" id="search{{ $service->service_name }}" role="tabpanel" aria-labelledby="search{{ $service->service_name }}-tab">
                                        <form action="{{ url('/search-result') }}" method="post">
                                            <div class="row search_field">
                                                <div class="col-12 col-sm-12 col-md-7 p-0">
                                                    <div class="jiosearch_outer">
                                                            <input type="text" name="search_text" id="search_name" class="search_location"  placeholder="Type Location or Project/Society or Keyword">
                                                        <div id="searchlist">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-3 padding_none">
                                                    <select name="property_type">
                                                        <option value="">Property Type</option>
                                                        @foreach( $propertyType as $type )
                                                        <option value="{{ $type->id}}">{{ $type->property_type}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-12 col-sm-12 col-md-2 p-0">
                                                    <button type="submit">Search</button>
                                                </div>
                                            </div>
                                            {{ csrf_field() }}
                                        </form>
                                    </div>
                                    @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 mt-3 text-center">
                            <img src="/images/frontend_images/images/18.gif">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="othersertop_sec">
            <div class="container">        
                <div class="owl-carousel services owl-theme">
                @foreach($otherServices as $othservice)
                @if($othservice->parent_id==0)
                    <div class="item">
                    <a target="_blank" href="{{ url('/services/'.$othservice->url) }}">
                            <div class="service_box oter_serbox">
                                <div class="serbox_img"><img src="{{ asset('/images/backend_images/repair_service_images/large/'.$othservice->service_image)}}"></div>
                                <div class="serbox_txt">
                                    <h4>{{ $othservice->service_name }}</h4>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif
                @endforeach
                </div>
            </div>
        </div>

</div>


<div class="featured_property">
    <div class="container">
        <div class="globleheadding text-left">
            <h1>Featured Property</h1>
            <p>Find the latest homes for sale, property news & real estate market data </p>
        </div>

        <div class="row">
            @foreach($featureProperty as $property)
            @if($loop->index < 2)                
                <div class="col-12 col-sm-6 col-md-12 col-lg-6 col-xl-6">
                    <div class="product_box featurepro_box">
                        <div class="product_img">
                            <div class="owl-carousel feauture-slide owl-theme">
                                @foreach($propertyImages as $carousal)
                                @if($property->id==$carousal->property_id)
                                <div class="item"><img src="{{ asset('/images/backend_images/property_images/large/'.$carousal->image_name)}}"></div>
                                @endif
                                @endforeach
                            </div>
                            <div class="rateing">
                                <i class="staricon">Featured</i>
                            </div>
                            <div class="bottom_strip">
                                <h6><i class="fas fa-map-marker-alt"></i>
                                @if(!empty($property->city_name))
                                    <span>{{ $property->city_name }},</span>
                                @endif 
                                @if(!empty($property->country_name))
                                    <span>{{ $property->country_name }}</span>
                                @endif
                                </h6>
                                <p>{{ $property->parea }} Square Ft</p>
                                <span class="tagbtn rent">{{ $property->service_name }}</span>
                            </div>  
                        </div>
                        <div class="product_text">
                            <div class="protxt_top">
                                <ul>
                                    <li><i><img src="/images/frontend_images/images/room.svg"></i><p><span>{{ $property->rooms }}</span>Rooms</p></li>
                                    <li><i><img src="/images/frontend_images/images/bedroom.svg"></i><p><span>{{ $property->bedrooms }}</span>Bedrooms</p></li>
                                    <li><i><img src="/images/frontend_images/images/bathroom.svg"></i><p><span>{{ $property->bathrooms }}</span>Bathroom</p></li>
                                </ul>
                            </div>
                            <div class="protxt_inn">
                                <h6>{{ $property->property_name }}</h6>
                                <p>{{ strip_tags(str_limit($property->description, $limit=120)) }}</p>
                                <div class="price_sec">
                                    <ul>
                                        <li><h5><span>INR</span> {{ $property->property_price }}</h5></li>
                                        <li><a target="_blank" href="{{ url('/properties/'.$property->property_url) }}" class="btn_fullinfo">Full Info</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
    
            </div>
    </div>
</div>



<div class="latest_product">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-12 col-xl-12">
                <div class="row">
                    <div class="col-12 col-xl-12">
                            <div class="globleheadding text-left">
                                <h1>Latest Property</h1>
                                <p>Find the latest homes for sale, property news & real estate market data </p>
                            </div>
                            <div class="latest_producttab mb-3">
                                <ul class="nav nav-pills" id="productTab" role="tablist">
                                    <?php $counter = 0; ?>
                                    @foreach($services as $service)
                                    @if($service->parent_id != 0)
                                    <?php $counter ++; ?>
                                        <li class="nav-item">
                                            <a class="nav-link show <?=($counter == 1) ? 'active' : ''?>" id="{{ $service->service_name }}-tab" data-toggle="tab" href="#{{ $service->service_name }}" role="tab" aria-controls="{{ $service->service_name }}" aria-selected="<?=($counter == 1) ? 'true' : ''?>">{{ $service->service_name }}</a>
                                        </li>
                                    @endif
                                    @endforeach
                                    <li class="nav-item">
                                        <a class="nav-link" id="propdealers-tab" data-toggle="tab" href="#propdealers" role="tab" aria-controls="propdealers" aria-selected="false">Dealers</a>
                                    </li>
                                </ul>
                            </div>
                    </div>
                </div>

                <div class="tab-content" id="myTabContent">
                    <?php $counter = 0; ?>
                    @foreach($services as $service)
                    @if($service->parent_id != 0)
                        <?php $counter ++; ?>
                        <div class="tab-pane fade show <?=($counter == 1) ? 'active' : ''?>" id="{{ $service->service_name }}" role="tabpanel" aria-labelledby="{{ $service->service_name }}-tab">
                            <div class="row">
                                <?php $counter = 0 ; ?>
                                @foreach($properties as $property)
                                @if($property->service_id == $service->id )
                                <?php $counter++ ; ?>
                                @if( $counter <= 4)
                                    <div class="col-12 col-sm-6 col-md-6 col-lg-4 col-xl-3">
                                        <div class="product_box">
                                            <div class="product_img">
                                                <div class="owl-carousel product-slide owl-theme">
                                                    @foreach($propertyImages as $carousal)
                                                    @if($property->id==$carousal->property_id)
                                                    <div class="item"><img src="{{ asset('/images/backend_images/property_images/large/'.$carousal->image_name)}}"></div>
                                                    @endif
                                                    @endforeach
                                                </div>
                                                <div class="bottom_strip">
                                                    <h6><i class="fas fa-map-marker-alt"></i> 
                                                    @if(!empty($property->city_name))
                                                        <span>{{ $property->city_name }},</span>
                                                    @endif 
                                                    @if(!empty($property->country_name))
                                                        <span>{{ $property->country_name }}</span>
                                                    @endif
                                                    </h6>
                                                    <p>{{ $property->parea }} Square Ft</p>
                                                    <span class="tagbtn rent">{{ $property->service_name }}</span>
                                                </div>  
                                            </div>
                                            <div class="product_text">
                                                <div class="protxt_top">
                                                    <ul>
                                                        <li><i><img src="/images/frontend_images/images/room.svg"></i><p><span>{{ $property->rooms }}</span>Rooms</p></li>
                                                        <li><i><img src="/images/frontend_images/images/bedroom.svg"></i><p><span>{{ $property->bedrooms }}</span>Bedrooms</p></li>
                                                        <li><i><img src="/images/frontend_images/images/bathroom.svg"></i><p><span>{{ $property->bathrooms }}</span>Bathroom</p></li>
                                                    </ul>
                                                </div>
                                                <div class="protxt_inn">
                                                    <h6>{{ $property->property_name }}</h6>
                                                    <p>{!! str_limit($property->description, $limit=80) !!}</p>
                                                    <div class="price_sec">
                                                        <ul>
                                                            <li><h5><span>INR</span> {{ $property->property_price }}</h5></li>
                                                            <li><a href="{{ url('/properties/'.$property->property_url) }}" class="btn_fullinfo">Full Info</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                @endif
                                @endforeach
                            </div>
                            <div class="view_sec text-center"><a class="btnview_all" href="{{ url('/properties') }}">View All</a></div>
                        </div>
                    @endif
                    @endforeach

                    <div class="tab-pane fade" id="propdealers" role="tabpanel" aria-labelledby="propdealers-tab">
                        <div class="dealers_sec">
                            <div class="owl-carousel dealerscarousel owl-theme">
                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer1.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer2.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer3.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer4.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer1.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer2.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer3.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer4.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer1.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer2.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer3.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer4.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer1.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer2.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer3.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                                <div class="item">
                                    <a href="#">
                                        <div class="dealers_box">
                                            <div class="dealers_img"><img src="/images/frontend_images/images/dealer4.png"></div>
                                            <div class="dealers_txt">
                                                <h4>Dealer Name</h4>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                
                            </div>
                        </div>
                    </div>
                  </div>
            </div>
            <div class="col-12 col-md-3 col-xl-3" style="display:none;">
                    <div class="globleheadding text-left">
                        <h1>Free Ads</h1>
                        <p>Find the latest homes for sale</p>
                    </div>
                <div class="free_ads">                   
                    <div class="owl-carousel feature-slide owl-theme">
                        <div class="item">
                            <img src="/images/frontend_images/images/ads.jpg">
                        </div>
                        <div class="item">
                            <img src="/images/frontend_images/images/ads.jpg">
                        </div>
                        <div class="item">
                            <img src="/images/frontend_images/images/ads.jpg">
                        </div>
                        <div class="item">
                            <img src="/images/frontend_images/images/ads.jpg">
                        </div>
                    </div>
                </div>
            </div>
        </div> 
    </div>
</div>

<!-- // Commercial Properties -->

            <div class="latest_product">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-md-12 col-xl-12">
                            <div class="row">
                                <div class="col-12 col-md-12 col-xl-12">
                                    <div class="globleheadding text-left">
                                        <h1>Commercial Property</h1>
                                        <p>Find the latest homes for sale, property news & real estate market data </p>
                                    </div>
                                </div>
                            </div>
                                <div class="row">
                                    <?php $counter = 0 ; ?>
                                    @foreach($properties as $property)
                                    @if($property->property_type_id==7 || $property->property_type_id==8 || $property->property_type_id==9 || $property->property_type_id==10 || $property->property_type_id==11)
                                    <?php $counter++ ; ?>
                                    @if($counter <= 4)
                                    <div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-xl-4">
                                        <div class="product_box">
                                            <div class="product_img">
                                                <div class="owl-carousel product-slide owl-theme">
                                                    @foreach($propertyImages as $carousal)
                                                    @if($property->id==$carousal->property_id)
                                                    <div class="item"><img src="{{ asset('/images/backend_images/property_images/large/'.$carousal->image_name)}}"></div>
                                                    @endif
                                                    @endforeach
                                                </div>
                                                <div class="bottom_strip">
                                                <h6><i class="fas fa-map-marker-alt"></i>
                                                @if(!empty($property->city_name))
                                                    <span>{{ $property->city_name }},</span>
                                                @endif 
                                                @if(!empty($property->country_name))
                                                    <span>{{ $property->country_name }}</span>
                                                @endif
                                                </h6>
                                                <p>{{ $property->parea }} Square Ft</p>
                                                <span class="tagbtn rent">{{ $property->service_name }}</span>
                                                </div>  
                                            </div>
                                            <div class="product_text">
                                                <div class="protxt_top">
                                                    <ul>
                                                        <li><i><img src="/images/frontend_images/images/room.svg"></i><p><span>{{ $property->rooms }}</span>Rooms</p></li>
                                                        <li><i><img src="/images/frontend_images/images/bedroom.svg"></i><p><span>{{ $property->bedrooms }}</span>Bedrooms</p></li>
                                                        <li><i><img src="/images/frontend_images/images/bathroom.svg"></i><p><span>{{ $property->bathrooms }}</span>Bathroom</p></li>
                                                    </ul>
                                                </div>
                                                <div class="protxt_inn">
                                                    <h6>{{ $property->property_name }}</h6>
                                                    <p>{!! str_limit($property->description, $limit=100) !!}</p>
                                                    <div class="price_sec">
                                                        <ul>
                                                            <li><h5><span>INR</span> {{ $property->property_price }}</h5></li>
                                                            <li><a href="{{ url('/properties/'.$property->property_url) }}" class="btn_fullinfo">Full Info</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    @endif
                                    @endif
                                    @endforeach
                                </div>
                                <div class="view_sec text-center"><a class="btnview_all" href="{{ url('/properties') }}">View All</a></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

<div class="oter_services">
    <div class="container">
        <div class="globleheadding white">
            <h1>Repair Services</h1>
            <p>Find the latest homes for sale, property news & real estate market data </p>
        </div>
        <div class="other_sercarousel">
            <div class="owl-carousel services owl-theme">
                @foreach($otherServices as $othservice)
                @if($othservice->parent_id==0)
                    <div class="item">                          
                        <div class="service_box">
                            <div class="serbox_img"><img src="{{ asset('/images/backend_images/repair_service_images/large/'.$othservice->service_image)}}"></div>
                            <div class="serbox_txt">
                                <h4>{{ $othservice->service_name }}</h4>
                                <a href="{{ url('/services/'.$othservice->url) }}">View All</a>
                            </div>
                        </div>
                    </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
</div>


<div class="global_estate">
    <div class="container">
        <div class="global_estatein">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-4 mt-4">
                    <div class="viewsource">
                        <img src="/images/frontend_images/images/icon-01.png">
                    </div>
                    <div class="viewsourcetxt">
                        <h1>3,17,077+</h1>
                        <p>Properties & Counting...</p>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-4 mt-4">
                    <div class="viewsource">
                        <img src="/images/frontend_images/images/icon-02.png">
                    </div>
                    <div class="viewsourcetxt">
                        <h1>3,000+</h1>
                        <p>Properties Listed</p>
                    </div>
                </div>

                <div class="col-12 col-sm-12 col-md-4 mt-4">
                    <div class="viewsource">
                        <img src="/images/frontend_images/images/icon-03.png">
                    </div>
                    <div class="viewsourcetxt">
                        <h1>5,175+</h1>
                        <p>Sellers Contacted</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="top_countries">
    <div class="container">
        <div class="globleheadding">
            <h1>Properties By Continents</h1>
            <p>You can use the theme places short-code to list specific cities or areas<br> 
                    where you have properties ready to sale/rent.</p>
        </div>
        <div class="top_countries_sec">
            <ul class="continents">
                @foreach($continents as $continent)
                <li data-toggle="tooltip" data-placement="top" title="{{ $continent->name }}">
                    <a href="#{{ $continent->code }}_{{ $continent->continent_id }}" data-toggle="modal">
                        <img src="/images/frontend_images/images/{{ $continent->icon_image }}">
                        <p>{{ $continent->name }}</p>
                    </a>
                </li>

                <div class="modal fade bd-example-modal-lg" id="{{ $continent->code }}_{{ $continent->continent_id }}" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="">{{ $continent->name }}</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <ul class="country_list">
                                    @foreach($countries as $country)
                                    @if($country->continent_id == $continent->continent_id)
                                    <li>
                                        <a href="{{ url('/view-properties/country_id='.$country->id) }}" style="margin: 0.2em 0em;" class="btn btn-outline-dark">{{ $country->name }}</a>
                                    </li>
                                    @endif
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
            </ul>
        </div>
    </div>
</div>
</div>



@endsection