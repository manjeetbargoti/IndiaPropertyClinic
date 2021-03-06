<?php

namespace App\Http\Controllers;

Use DB;
use Auth;
use Image;
use Session;
use App\User;
use App\State;
use App\Cities;
use App\Country;
use App\Property;
use App\Services;
use App\PhoneQuery;
use App\PropertyTypes;
Use App\OtherServices;
Use App\PropertyImages;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Input;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    // public function index()
    // {
    //     return view('home');
    // }

    protected $posts_per_page = 18;

    public function index()
    {

        $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);

        $ip_rproperty = Property::where('service_id', 3)->where('country', $arr_ip->iso_code)->count();
        $ip_sproperty = Property::where('service_id', 4)->where('country', $arr_ip->iso_code)->count();
        $ip_fproperty = Property::where(['featured' => 1])->where('country', $arr_ip->iso_code)->count();
        $ip_cproperty = Property::where(['commercial' => 1])->where('country', $arr_ip->iso_code)->count();
        // echo "<pre>"; print_r($arr_ip); die;

        if($ip_fproperty > 0){
            $featureProperty = Property::where(['featured' => 1])->where('country', $arr_ip->iso_code)->orderBy('created_at', 'desc')->take(4)->get();
        }else{
            $featureProperty = Property::where(['featured' => 1])->orderBy('created_at', 'desc')->take(4)->get();
        }

        if($ip_cproperty > 0){
            $commercialProperty = Property::where(['commercial' => 1])->where('country', $arr_ip->iso_code)->orderBy('created_at', 'desc')->take(4)->get();
        }else{
            $commercialProperty = Property::where(['commercial' => 1])->orderBy('created_at', 'desc')->take(4)->get();
        }

        if($ip_rproperty > 0){
            $properties2 = Property::where('service_id', 3)->where('country', $arr_ip->iso_code)->orderBy('id', 'desc')->take(4)->get();
            $properties2 = json_decode(json_encode($properties2));
        }else{
            $properties2 = Property::where('service_id', 3)->orderBy('id', 'desc')->take(4)->get();
            $properties2 = json_decode(json_encode($properties2));
            
        }
        
        if($ip_sproperty > 0){
            $properties3 = Property::where('service_id', 4)->where('country', $arr_ip->iso_code)->orderBy('id', 'desc')->take(4)->get();
            $properties3 = json_decode(json_encode($properties3));
        }else{
            $properties3 = Property::where('service_id', 4)->orderBy('id', 'desc')->take(4)->get();
            $properties3 = json_decode(json_encode($properties3));
            
        }
            $properties = array_merge($properties2, $properties3);
            $propertyType = PropertyTypes::get();
            $otherServices = OtherServices::get();

            foreach ($properties as $key => $val) {
                $service_name = Services::where(['id' => $val->service_id])->first();
                $properties[$key]->service_name = $service_name->service_name;
                $propertyimage_count = PropertyImages::where(['property_id' => $val->id])->count();
                if ($propertyimage_count > 0) {
                    $propertyimage_name = PropertyImages::where(['property_id' => $val->id])->first();
                    $properties[$key]->image_name = $propertyimage_name->image_name;
                }
                $country_count = DB::table('countries')->where(['iso2' => $val->country])->count();
                if ($country_count > 0) {
                    $country = DB::table('countries')->where(['iso2' => $val->country])->first();
                    $properties[$key]->country_name = $country->name;
                    $properties[$key]->currency = $country->currency;
                }
                $state_count = DB::table('states')->where(['id' => $val->state])->count();
                if ($state_count > 0) {
                    $state = DB::table('states')->where(['id' => $val->state])->first();
                    $properties[$key]->state_name = $state->name;
                }
                $city_count = DB::table('cities')->where(['id' => $val->city])->count();
                if ($city_count) {
                    $city = DB::table('cities')->where(['id' => $val->city])->first();
                    $properties[$key]->city_name = $city->name;
                }
            }

            // Get Featured Property Data
            foreach ($featureProperty as $key => $val) {
                $service_name = Services::where(['id' => $val->service_id])->first();
                $featureProperty[$key]->service_name = $service_name->service_name;
                $country_countf = DB::table('countries')->where(['iso2' => $val->country])->count();
                if ($country_countf > 0) {
                    $country = DB::table('countries')->where(['iso2' => $val->country])->first();
                    $featureProperty[$key]->country_name = $country->name;
                    $featureProperty[$key]->currency = $country->currency;
                }
                $state_countf = DB::table('states')->where(['id' => $val->state])->count();
                if ($state_countf > 0) {
                    $state = DB::table('states')->where(['id' => $val->state])->first();
                    $featureProperty[$key]->state_name = $state->name;
                }
                $city_countf = DB::table('cities')->where(['id' => $val->city])->count();
                if ($city_countf) {
                    $city = DB::table('cities')->where(['id' => $val->city])->first();
                    $featureProperty[$key]->city_name = $city->name;
                }
            }
    
        
        // echo "<pre>"; print_r($properties); die;

        // Get Commercial Properties Data
        $ip_commercial_property = Property::where('commercial', 1)->where('country', $arr_ip->iso_code)->count();

        if($ip_commercial_property > 0){
            $commercial_property = Property::where('commercial', 1)->where('country', $arr_ip->iso_code)->orderBy('created_at', 'desc')->take(4)->get();
        }else{
            $commercial_property = Property::where('commercial', 1)->orderBy('created_at', 'desc')->take(4)->get();
        }

        foreach ($commercial_property as $key => $val) {
            $service_name = Services::where(['id' => $val->service_id])->first();
            $commercial_property[$key]->service_name = $service_name->service_name;
            $propertyimage_count = PropertyImages::where(['property_id' => $val->id])->count();
            if ($propertyimage_count > 0) {
                $propertyimage_name = PropertyImages::where(['property_id' => $val->id])->first();
                $commercial_property[$key]->image_name = $propertyimage_name->image_name;
            }
            $country_count = DB::table('countries')->where(['iso2' => $val->country])->count();
            if ($country_count > 0) {
                $country = DB::table('countries')->where(['iso2' => $val->country])->first();
                $commercial_property[$key]->country_name = $country->name;
                $commercial_property[$key]->currency = $country->currency;
            }
            $state_count = DB::table('states')->where(['id' => $val->state])->count();
            if ($state_count > 0) {
                $state = DB::table('states')->where(['id' => $val->state])->first();
                $commercial_property[$key]->state_name = $state->name;
            }
            $city_count = DB::table('cities')->where(['id' => $val->city])->count();
            if ($city_count) {
                $city = DB::table('cities')->where(['id' => $val->city])->first();
                $commercial_property[$key]->city_name = $city->name;
            }
        }


        if ($country_count > 0) {
            $countrycount = $country_count;
        } else {
            $countrycount = 0;
        }
        // echo "<pre>"; print_r($properties); die;
        if (!empty($state_count)) {
            $statecount = $state_count;
        } else {
            $statecount = 0;
        }
        if (!empty($city_count)) {
            $citycount = $city_count;
        } else {
            $citycount = 0;
        }

        $dealer = User::whereIn('usertype', array('A','B'))->where('country', $arr_ip->iso_code)->orderBy('created_at', 'desc')->get();
        $dealer = json_decode(json_encode($dealer));

        $services = Services::where(['status' => 1])->get();
        $continents = DB::table('continents')->get();
        $countries = DB::table('countries')->get();
        // echo "<pre>"; print_r($dealer); die;

        // Meta tags
        $meta_title = "Real Estate Agency, Real Estate Listing, Home Repair - IPC";
        $meta_description = "India Property Clinic | Property Listing and Repairing Services";
        $meta_keywords = "Sale or Rent Property in $arr_ip->country, Sale or Rent Property in $arr_ip->state_name, Sale or Rent Property in $arr_ip->city, Home Services in $arr_ip->city, Home Services in $arr_ip->state_name, Repair Services in $arr_ip->city, Repair Services in $arr_ip->state_name";

        return view('home')->with(compact('properties', 'dealer', 'featureProperty', 'commercialProperty', 'otherServices', 'services', 'propertyType', 'continents', 'countries', 'countrycount', 'meta_title', 'meta_description', 'meta_keywords', 'commercial_property'));
    }

    // View All Properties
    public function viewAll()
    {
        $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
        $ip_properties = Property::where('country',$arr_ip->iso_code)->count();
        
        if($ip_properties > 0){
            $properties = Property::where('country',$arr_ip->iso_code)->orderBy('created_at', 'desc')->get();
        }else{
            $properties = Property::orderBy('created_at', 'desc')->get();
        }
        
        $ip_posts = Property::where('country',$arr_ip->iso_code)->count();
        if($ip_posts > 0){
            $posts = Property::where('country',$arr_ip->iso_code)->orderBy('created_at', 'desc')->paginate(24)->onEachSide(1);
        }else{
            $posts = Property::orderBy('created_at', 'desc')->paginate(24)->onEachSide(1);
        }
        // $propertyImages = PropertyImages::get();
        $otherServices = OtherServices::get();

        foreach($posts as $key => $val) {
            $service_name = Services::where(['id'=>$val->service_id])->first();
            $posts[$key]->service_name = $service_name->service_name;
            $propertyimage_count = PropertyImages::where(['property_id'=>$val->id])->count();
            if($propertyimage_count > 0){
                $propertyimage_name = PropertyImages::where(['property_id'=>$val->id])->first();
                $posts[$key]->image_name = $propertyimage_name->image_name;
            }
            $country_count = DB::table('countries')->where(['iso2'=>$val->country])->count();
            if($country_count > 0)
            {
                $country = DB::table('countries')->where(['iso2'=>$val->country])->first();
                $posts[$key]->country_name = $country->name;
                $posts[$key]->currency = $country->currency;
            }
            $state_count = DB::table('states')->where(['id'=>$val->state])->count();
            if($state_count > 0)
            {
                $state = DB::table('states')->where(['id'=>$val->state])->first();
                $posts[$key]->state_name = $state->name;
            }
            $city_count = DB::table('cities')->where(['id'=>$val->city])->count();
            if($city_count > 0)
            {
                $city = DB::table('cities')->where(['id'=>$val->city])->first();
                $posts[$key]->city_name = $city->name;
            }
        }
        if(!empty($country_count)){
            $countrycount = $country_count;
        } else {
            $countrycount = 0;
        }
        if(!empty($state_count)){
            $statecount = $state_count;
        } else {
            $statecount = 0;
        }
        if(!empty($city_count)){
            $citycount = $city_count;
        } else {
            $citycount = 0;
        }
        
        if(!empty($properties)){
            $contRow = count($properties);
            // echo "<pre>"; print_r($contRow); die;
        }
        
        // Meta tags
        $meta_title = "India Property Clinic | Property Listing and Home Repairing Services";
        $meta_description = "India Property Clinic | Property Listing and Repairing Services";
        $meta_keywords = "India Property Clinic, Property Listing, Repair Services";
        
        return view('frontend.viewall_properties', compact('properties', 'otherServices', 'contRow', 'posts', 'countrycount', 'statecount', 'citycount', 'meta_title', 'meta_description', 'meta_keywords'));
        // return response()->json($posts);
    }

    // Home Page Search Function Start
    public function search(Request $request)
    {
        if ($request->get('query')) {
            $query = $request->get('query');
            $data = DB::table('cities')->where('name', 'LIKE', "%{$query}%")->get();
            $output = '<ul class="jiodropdown">';
            foreach ($data as $row) {
                $flag = '<span class="flag_name">' . $row->id . '</span>';
                $output .= '<li id="type_search">' . $row->name . '</li>';
            }
            $output .= '</ul>';
            echo $output;
        }
    }

    // Home Page Search-Result Function Start
    public function searchresult(Request $request)
    {
        $perPage = 24;
        $requestData = $request->all();

        // dd($requestData);

        $city = Cities::where(['name' => rtrim($requestData['search_text'])])->first();

        if($city)
        {
            $cityID = $city->id;
            $scityname = $city->name;
        }else{
            $cityID = '';
            $scityname = '';
        }
        
        // dd($cityID);

        $propertyService = $requestData['property_cat'];

        if(!empty($requestData['property_type']))
        {
            $propertyType = $requestData['property_type'];
        }else{
            $propertyType = '';
        }
        


        $properties = new Property;

        // dd($properties);

        if (!empty($cityID) && empty($propertyType)) {
            $properties = $properties->where(['city' => $cityID, 'service_id' => $propertyService]);
        } elseif (empty($cityID) && !empty($propertyType)) {
            $properties = $properties->where(['property_type_id' => $propertyType, 'service_id' => $propertyService]);
        } elseif (empty($cityID) && empty($propertyType)) {
            $properties = $properties->where(['service_id' => $propertyService]);
        } elseif (!empty($cityID) && !empty($propertyType)) {
            $properties = $properties->where(['city' => $cityID, 'property_type_id' => $propertyType, 'service_id' => $propertyService]);
        }

        $properties = $properties->latest()->paginate($perPage);

        // dd($properties);

        $properties_count = $properties->count();

        // $propertyImages = PropertyImages::get();
        // if (!empty($properties)) {
            // $properties = json_decode(json_encode($properties));
        // }
        foreach ($properties as $key => $val) {
            $service_name = Services::where(['id' => $val->service_id])->first();
            $properties[$key]->service_name = $service_name->service_name;
            $propertyimage_count = PropertyImages::where(['property_id' => $val->id])->count();
            if ($propertyimage_count > 0) {
                $propertyimage_name = PropertyImages::where(['property_id' => $val->id])->first();
                $properties[$key]->image_name = $propertyimage_name->image_name;
            }
            $country_count = DB::table('countries')->where(['iso2' => $val->country])->count();
            if ($country_count > 0) {
                $country = DB::table('countries')->where(['iso2' => $val->country])->first();
                $properties[$key]->country_name = $country->name;
                $properties[$key]->currency = $country->currency;
            }
            $state_count = DB::table('states')->where(['id' => $val->state])->count();
            if ($state_count > 0) {
                $state = DB::table('states')->where(['id' => $val->state])->first();
                $properties[$key]->state_name = $state->name;
            }
            $city_count = DB::table('cities')->where(['id' => $val->city])->count();
            if ($city_count > 0) {
                $cityname = DB::table('cities')->where(['id' => $val->city])->first();
                $properties[$key]->city_name = $cityname->name;
            }
        }

        dd($properties);

        if (!empty($country_count)) {
            $countrycount = $country_count;
        } else {
            $countrycount = 0;
        }
        if (!empty($state_count)) {
            $statecount = $state_count;
        } else {
            $statecount = 0;
        }
        if (!empty($city_count)) {
            $citycount = $city_count;
        } else {
            $citycount = 0;
        }

        if (!empty($properties)) {
            $contRow = $properties->count();
            // echo "<pre>"; print_r($contRow); die;
        } else {
            $contRow = 0;
        }
        
        // echo "<pre>"; print_r($data); die;
       
        $service_name = Services::where('id', $requestData['property_cat'])->first();
        $property_type = PropertyTypes::where('property_type_code', $propertyType)->first();

        if(!empty($requestData['search_text']) && !empty($requestData['property_type']))
        {
            $meta_title = $property_type['property_type']." in ".$requestData['search_text']." for ".$service_name['service_name']." | India Property Clinic | IPC";
        }elseif(!empty($requestData['search_text']) && empty($requestData['property_type'])){
            $meta_title = "Properties in ".$requestData['search_text']." for ".$service_name['service_name']." | India Property Clinic | IPC";
        }elseif(empty($requestData['search_text']) && !empty($requestData['property_type'])){
            $meta_title = $property_type['property_type']." for ".$service_name['service_name']." | India Property Clinic | IPC";
        }elseif(empty($requestData['search_text']) && empty($requestData['property_type'])){
            $meta_title = "Properties for ".$service_name['service_name']." | India Property Clinic | IPC";
        }

        $meta_description = "India Property Clinic | Property Listing and Repairing Services";
        $meta_keywords = "India Property Clinic, Property Listing, Repair Services";

        return view('frontend.filter_templates.search_result')->with(compact('properties', 'properties_count', 'countrycount', 'statecount', 'citycount', 'scityname', 'meta_title', 'meta_description', 'meta_keywords'));
    }


    //Sidebar filter
    public function filter(Request $request)
    {
        // $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']);
        
        if (isset($request->id)) {
            if ($request->id == 1) {
                $id = 'desc';
                $type = 'created_at';
            } else {
                $id = $request->id;
                $type = 'property_price';
            }
        } else {
            $id = 'desc';
            $type = 'created_at';
        }
        $service    =   $request->service;
        $room       =   $request->room;
        $bedroom    =   $request->bed;
        $bathroom   =   $request->bathroom;
        $country    =   $arr_ip->iso_code;

        $posts = DB::table('properties')->where(function ($query) use ($service) {
            if (isset($service)) {
                $query->whereIn('service_id', $service);
            }
        })->where(function ($query) use ($room) {
            if (isset($room)) {
                $query->whereIn('rooms', $room);
            }
        })->where(function ($query) use ($bedroom) {
            if (isset($bedroom)) {
                $query->whereIn('bedrooms', $bedroom);
            }
        })->where(function ($query) use ($bathroom) {
            if (isset($bathroom)) {
                $query->whereIN('bathrooms', $bathroom);
            }
        })->orderBy($type, $id);

        $breadcrumb = $posts->get();
        $posts = $posts->paginate($this->posts_per_page);


        // $propertyImages = PropertyImages::get();

        foreach ($posts as $key => $val) {
            $service_name = Services::where(['id' => $val->service_id])->first();
            $posts[$key]->service_name = $service_name->service_name;
            $propertyimage_count = PropertyImages::where(['property_id' => $val->id])->count();
            if ($propertyimage_count > 0) {
                $propertyimage_name = PropertyImages::where(['property_id' => $val->id])->first();
                $posts[$key]->image_name = $propertyimage_name->image_name;
            }
            $country_count = DB::table('countries')->where(['iso2' => $val->country])->count();
            if ($country_count > 0) {
                $country = DB::table('countries')->where(['iso2' => $val->country])->first();
                $posts[$key]->country_name = $country->name;
                $posts[$key]->currency = $country->currency;
            }
            $state_count = DB::table('states')->where(['id' => $val->state])->count();
            if ($state_count > 0) {
                $state = DB::table('states')->where(['id' => $val->state])->first();
                $posts[$key]->state_name = $state->name;
            }
            $city_count = DB::table('cities')->where(['id' => $val->city])->count();
            if ($city_count > 0) {
                $city = DB::table('cities')->where(['id' => $val->city])->first();
                $posts[$key]->city_name = $city->name;
            }
        }


        if (!empty($breadcrumb)) {
            $contRow = $breadcrumb->count();
        }

        $output = '';

        echo '<div class="header_breadcrumb">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="' . url('/') . '">Home</a></li>
                        <li class="breadcrumb-item">All Properties</li>
                    </ol>
                </nav>
                <p><span>' . $contRow . ' Properties </span> </p>
            </div>';
        // echo '';
        if (!$posts->isEmpty()) {
            echo '<div class="row posts endless-pagination" data-next-page="' . $posts->nextPageUrl() . '" >';
            foreach ($posts as $property) {
                echo '<div class="col-12 col-sm-6 col-md-6 col-lg-6 col-xl-4">
                    <div class="product_box">
                        <div class="product_img">
                            <div class="owl-carousel product-slide owl-theme">';
                foreach (\App\PropertyImages::where('property_id', $property->id)->get() as $pimage) {
                    echo '<div class="item"><img src="' . asset('/images/backend_images/property_images/large/' . $pimage->image_name) . '"></div>';
                }
                echo '</div>
                            <div class="bottom_strip">
                                <h6><i class="fas fa-map-marker-alt"></i> ';
                if (!empty($property->city_name)) {
                    echo '<span>' . $property->city_name . ', </span>';
                } {
                    if (!empty($property->country_name))
                        echo '<span>' . $property->country_name . '</span>';
                }
                echo '</h6>';
                                if($property->parea){
                                echo '<p>' . $property->parea . 'Square Ft</p>';
                                }
                                echo '<span class="tagbtn rent">' . $property->service_name . '</span>
                            </div> 
                        </div>
                        <div class="product_text">
                            <div class="protxt_top">
                                <ul>
                                    <li><i><img src="/images/frontend_images/images/room.svg"></i><p><span>' . $property->rooms . '</span>Rooms</p></li>
                                    <li><i><img src="/images/frontend_images/images/bedroom.svg"></i><p><span>' . $property->bedrooms . '</span>Bedrooms</p></li>
                                    <li><i><img src="/images/frontend_images/images/bathroom.svg"></i><p><span>' . $property->bathrooms . '</span>Bathroom</p></li>
                                </ul>
                            </div>
                            <div class="protxt_inn">
                                <h6>' . $property->property_name . '</h6>
                                <p>' . strip_tags($property->description) . '</p>
                                <div class="price_sec">
                                    <ul>
                                        <li>';
                if (!empty($property->property_price)) {
                    echo '<h5><span>' . $property->currency . '</span> ' . $property->property_price . '</h5>';
                } else {
                    echo '<a href="/properties/' . $property->property_url . '" class="btn_fullinfo">Get Price</a>';
                }
                echo '</li>
                                        <li><a href="/properties/' . $property->property_url . '" class="btn_fullinfo">Full Info</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
                ';
            }
            echo '</div>';
            $output .= '<div class="product_loadding">
        ' . $posts->render() . '
         </div>';
        } else {
            $output .= '
        <div class="container">
            <div class="globleheadding">
                <img src="' . asset('/images/backend_images/user_images/error-no-search-results.png') . '">
                <h4>Sorry, no results found!</h4>
                <p>Oh Snap! Zero Results found for your search.</p>
            </div>
        </div>

        ';
        }
        return $output;
    }
    
    // Business List by Vendor
    public function listBusiness(Request $request)
    {

        if($request->isMethod('Post'))
        {
            $data = $request->all();
            // echo"<pre>"; print_r($data);die;

            // $rservice = implode(',', $data['offered_service']);
            $rservice = $data['offered_service'];
            // echo"<pre>"; print_r($rservice);die;

            DB::beginTransaction();

            try{

                User::create([
                    'first_name'            => $data['first_name'],
                    'last_name'             => $data['last_name'],
                    'email'                 => $data['email'],
                    'phone'                 => $data['phone'],
                    'business_name'         => $data['business_name'],
                    'experience'            => $data['experience'],
                    'about_business'        => $data['business_description'],
                    'country'               => $data['business_country'],
                    'state'                 => $data['business_state'],
                    'city'                  => $data['business_city'],
                    'servicetypeid'         => $rservice,
                    'usertype'              => 'V'
                ]);

            }catch(ValidationException $e){
                DB::rollback();
                return Redirect()->back()->withErrors($e->getErrors())->withInput();
            }catch(\Exception $e){
                DB::rollback();
                throw $e;
            }

            DB::commit();

            // Send Confirmation Email
            $email = $data['email'];
            $messageData = ['email' => $data['email'], 'name' => $data['first_name'], 'code' => base64_encode($data['email'])];
            Mail::send('emails.generate_user_password', $messageData, function ($message) use ($email) {
                $message->to($email)->subject('Generate account password and Confirm account with India Property Clinic');
            });

            return redirect()->back()->with('flash_message_success','Business Submitted Successfully! Please Check your email and generate password.');

        }

        $repair_services = OtherServices::where('parent_id', 0)->orderBy('service_name', 'asc')->get();
        $countries = Country::orderBy('name', 'asc')->get();

        return view('frontend.list_business', compact('countries', 'repair_services'));
    }

    // Add New Phone Queries
    public function addPhoneQuery(Request $request)
    {
        if($request->isMethod('post'))
        {
            $data = $request->all();
            // echo "<pre>"; print_r($data); die;

            PhoneQuery::create([
                'name'          => $data['name'],
                'usertype'      => $data['usertype'],
                'phone'         => $data['phone'],
                'email'         => $data['email'],
                'property_for'  => $data['property_for'],
                'property_type' => $data['property_type'],
                'description'   => $data['description'],
                'address'       => $data['address'],
                'country'       => $data['country_prop'],
                'state'         => $data['state_prop'],
                'city'          => $data['city_prop'],
                'zipcode'       => $data['zipcode']
            ]);

            return redirect('/admin/queries/phone-queries')->with('flash_message_success', 'Phone Property added Successfully!');
        }

        return view('admin.queries.add_phone_queries');
    }

    // View All Phone Queries
    public function phoneQueryData(Request $request)
    {
        $propertyquery = PhoneQuery::orderBy('created_at', 'desc')->get();
        // echo "<pre>"; print_r($phoneQueries); die;

        // return view('admin.queries.user_phone_query_tmp', compact('userPhoneQueryData'));
        return view('admin.queries.property_phone_query', compact('propertyquery'));
    }
    
    // Get Homepage Content
    public function getHomeContent()
    {
        $data['home_page_content'] = file_get_contents(resource_path('views/admin/homepage/partials/home_page_content.blade.php'));

        return view('admin.homepage.home_page_show', $data);
    }

    // Update Homepage Content
    public function postHomeContent(Request $request)
    {
        file_put_contents(resource_path('views/admin/homepage/partials/home_page_content.blade.php'), $request->home_page_content);

        return back();
    }

    // Builders based on country
    public function countryBuilders(Request $request, $country=null)
    {
        $perpage = 24;

        $country_name = $country;
        // dd($country_name);

        $country_name_count = Country::where('name', $country)->count();
        if($country_name_count > 0)
        {
            $country_name = $country;
        }else{
            $country_name = str_replace(array('_','-'),' ', $country);
        }
        // dd($country_name);

        $country_iso = Country::where('name',$country_name)->first();
        // dd($country_iso);

        $data = User::where(['users.country'=>$country_iso->iso2, 'usertype'=>'B'])
                ->leftJoin('user_types','users.usertype','=','user_types.usercode')
                ->leftJoin('cities','users.city','=','cities.id')
                ->leftJoin('states','users.state','=','states.id')
                ->leftJoin('countries','users.country','=','countries.iso2')
                ->select('users.id','users.first_name','users.last_name','user_types.usertype_name as usertype','cities.name as city','states.name as state','countries.name as country')
                ->latest('users.created_at')->paginate($perpage);

        // dd($data);

        $location = $country_name;

        $country = Country::orderBy('name','asc')->get();

        return view('frontend.users.all_builders', compact('data','country', 'location'));
    }

    // Builders based on State
    public function stateBuilders(Request $request, $state=null)
    {
        $perpage = 24;

        $state_name = $state;
        // dd($state_name);

        $state_name_count = State::where('name', $state)->count();
        if($state_name_count > 0)
        {
            $state_name = $state;
        }else{
            $state_name = str_replace(array('_', '-'),' ', $state);
        }
        // dd($state_name);

        $state_id = State::where('name',$state_name)->first();
        // dd($state_id);

        $data = User::where(['users.state'=>$state_id->id, 'usertype'=>'B'])
                ->leftJoin('user_types','users.usertype','=','user_types.usercode')
                ->leftJoin('cities','users.city','=','cities.id')
                ->leftJoin('states','users.state','=','states.id')
                ->leftJoin('countries','users.country','=','countries.iso2')
                ->select('users.id','users.first_name','users.last_name','user_types.usertype_name as usertype','cities.name as city','states.name as state','countries.name as country')
                ->latest('users.created_at')->paginate($perpage);

        $count = User::where(['state'=>$state_id->id, 'usertype'=>'B'])->count();

        // dd($data);

        $location = $state_name;

        $country = Country::orderBy('name','asc')->get();

        return view('frontend.users.all_builders', compact('data','country','location','count'));
    }

    // Builders based on City
    public function cityBuilders(Request $request, $city=null)
    {
        $perpage = 24;

        $city_name = $city;
        // dd($city_name);

        $city_name_count = Cities::where('name', $city)->count();
        if($city_name_count > 0)
        {
            $city_name = $city;
        }else{
            $city_name = str_replace(array('_'),' ', $city);
        }
        // dd($city_name);

        $city_id = Cities::where('name', 'LIKE',$city_name)->first();
        // dd($city_id);

        $data = User::where(['users.city'=>$city_id->id, 'usertype'=>'B'])
                ->leftJoin('user_types','users.usertype','=','user_types.usercode')
                ->leftJoin('cities','users.city','=','cities.id')
                ->leftJoin('states','users.state','=','states.id')
                ->leftJoin('countries','users.country','=','countries.iso2')
                ->select('users.id','users.first_name','users.last_name','user_types.usertype_name as usertype','cities.name as city','states.name as state','countries.name as country')
                ->latest('users.created_at')->paginate($perpage);

        $count = User::where(['city'=>$city_id->id, 'usertype'=>'B'])->count();

        // dd($data);

        $location = $city_name;

        $country = Country::orderBy('name','asc')->get();

        return view('frontend.users.all_builders', compact('data','country','location','count'));
    }

    // Search Builders
    public function searchBuilders(Request $request)
    {
        $perPage    = 24;
        $country    = $request['country'];
        $state      = $request['state'];
        $city       = $request['city'];

        // dd($request->all());

        $data = new User;

        if ($country) {
            $data = $data->where(['users.country' => $country, 'usertype'=>'B']);
        }
        if ($state) {
            $data = $data->whereBetween('users.state', $state);
        }
        if ($city) {
            $data = $data->where('users.city', $city);
        }

        $data = $data->leftJoin('user_types','users.usertype','=','user_types.usercode')
                ->leftJoin('cities','users.city','=','cities.id')
                ->leftJoin('states','users.state','=','states.id')
                ->leftJoin('countries','users.country','=','countries.iso2')
                ->select('users.id','users.first_name','users.last_name','user_types.usertype_name as usertype','cities.name as city','states.name as state','countries.name as country')
                ->latest('users.created_at')->paginate($perPage);

        // dd($data);

        $country = Country::orderBy('name','asc')->get();

        return view('frontend.users.all_builders', compact('data','country'));
    }

}
