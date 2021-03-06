<?php 
use App\Http\Controllers\Controller;
$mainnavservice = Controller::mainNav();

$continent = Controller::continents();
$country = Controller::countries();

?>

<style>
    .dropdown:hover>.dropdown-menu {
        display: block;
    }

    .dropdown>.dropdown-toggle:active {
        /*Without this, clicking will make it sticky*/
        pointer-events: none;
    }
</style>

<div id="page">
    <div class="header_top">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="user_contact">
                        <ul>
                            <li><a href="tel:<?php echo e(config('app.phone')); ?>"><i class="fas fa-phone"></i>
                                    <?php echo e(config('app.phone')); ?></a></li>
                            <li><a href="mailto:<?php echo e(config('app.email')); ?>"><i class="fas fa-envelope"></i>
                                    <?php echo e(config('app.email')); ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="header_topr">
                        <ul>
                            <li><?php $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']); echo $arr_ip->country; ?></li>
                            <li><a href="<?php echo e(url('/Apply-Home-Loan')); ?>">Home Loan</a></li>
                            <li><?php $arr_ip = geoip()->getLocation($_SERVER['REMOTE_ADDR']); echo $arr_ip->currency; ?></li>
                            <li>
                                <div class="social_link">
                                    <a href="https://www.facebook.com/indiapropertyclinic" target="_blank"><i class="fab fa-facebook"></i></a>
                                    <a href="#"><i class="fab fa-twitter"></i></a>
                                    <a href="#"><i class="fab fa-youtube"></i></a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu start -->
    <nav id="menu">
        <ul>
            <li><a href="<?php echo e(url('/')); ?>">Home</a></li>
            <li><span>About us</span>
            <?php $__currentLoopData = $mainnavservice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainnav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li>
                <a class="<?php echo e((request()->is('properties/'.$mainnav->id.'/'.$mainnav->url)) ? 'active':''); ?>"
                            href="<?php echo e(url('/properties/'.$mainnav->id.'/'.$mainnav->url)); ?>"><?php echo e($mainnav->service_name); ?>

                    <span class="sr-only">(current)</span></a>
            </li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <li><span>Home Services</span>
                <ul>
                <?php $__currentLoopData = \App\OtherServices::where('parent_id', 0)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rservice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a class="dropdown-item <?php echo e((request()->is('services/'.$rservice->url)) ? 'active':''); ?>" href="<?php echo e(url('/services/'.$rservice->url)); ?>"><?php echo e($rservice->service_name); ?></a></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </ul>
            </li>
            </li>
            <li><a href="#contact">Contact</a></li>
        </ul>
    </nav>

    <nav id="mobileHeader" class="navbar-expand-lg navbar-light mobile_nav followMeBar">
        <div class="container">
            <div class="col-lg-12">
                <div class="mobile_menu">
                    <div class="burger_menu"><a href="#menu"><i class="fas fa-bars barmenu"></i></a></div>
                    <div class="moblogo"><a href="#"><img src="<?php echo e(asset(config('app.logo'))); ?>"></a></li>
                    </div>
                    <div class="mobuser_profile">
                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?php if(auth()->guard()->guest()): ?>
                                <i class="fas fa-user fa-2x"></i>
                                <?php endif; ?>
                            </button>
                            <div class="dropdown-menu profilemenu" aria-labelledby="dropdownMenuButton">
                                <ul>
                                    <!-- Authentication Links -->
                                    <?php if(auth()->guard()->guest()): ?>
                                    <li><a href="<?php echo e(url('/login')); ?>"><i class="fas fa-sign-in-alt"></i>
                                            <?php echo e(__('Login')); ?></a></li>
                                    <?php else: ?>
                                    <li><a><i class="fas fa-sign-in-alt"></i> <?php echo e(Auth::user()->first_name); ?></a></li>
                                    <li><a href="#"><i class="fas fa-user"></i> My Profile</a></li>
                                    <li><a href="#"><i class="fas fa-home"></i> My Properties List</a></li>
                                    <li><a href="#"><i class="fas fa-heart"></i> Favorites</a></li>
                                    <li><a href="#"><i class="fas fa-sign-out-alt"></i> <?php echo e(__('Log Out')); ?></a></li>
                                    <?php endif; ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Mobile menu end -->

    <!-- Main Menu desktop menu start -->
    <nav id="myHeader" class="navbar navbar-expand-lg navbar-light custom_nav followMeBar">
        <div class="container">
            <a class="navbar-brand" href="/"><img src="<?php echo e(asset(config('app.logo'))); ?>"></a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <?php $__currentLoopData = $mainnavservice; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $mainnav): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item">
                        <a class="nav-link <?php echo e((request()->is('properties/'.$mainnav->id.'/'.$mainnav->url)) ? 'active':''); ?>"
                            href="<?php echo e(url('/properties/'.$mainnav->id.'/'.$mainnav->url)); ?>"><?php echo e($mainnav->service_name); ?>

                            <span class="sr-only">(current)</span></a>
                    </li>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    <li class="dropdown">
                        <a class="nav-link dropdown-toggle <?php echo e((request()->is('services/*')) ? 'active':''); ?>" id="dropdownMenuButton" data-toggle="dropdown"
                            aria-haspopup="true" aria-expanded="false">Home Services</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton" style="overflow:scroll;max-height: 30em;">
                            <?php $__currentLoopData = \App\OtherServices::where('parent_id', 0)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rservice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <a class="dropdown-item <?php echo e((request()->is('services/'.$rservice->url)) ? 'active':''); ?>" href="<?php echo e(url('/services/'.$rservice->url)); ?>"><?php echo e($rservice->service_name); ?></a>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" href="#">Packages</a>
                    </li> -->
                </ul>
                <div class="user_profile">
                    <div class="dropdown">

                        <?php if(auth()->guard()->guest()): ?>
                        <button class="btn btn-link"><a href="<?php echo e(url('/login')); ?>"><i class="fas fa-sign-in-alt"></i>
                                <?php echo e(__('Login')); ?></a></button>
                        <?php else: ?>
                        <button class="btn btn-link dropdown-toggle" type="button" id="dropdownMenuButton"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i
                                class="fas fa-user"></i></button>
                        <?php endif; ?>
                        <?php if(auth()->guard()->guest()): ?>

                        <?php else: ?>
                        <div class="dropdown-menu profilemenu" aria-labelledby="dropdownMenuButton">
                            <ul>
                                <!-- Authentication Links -->
                                
                                <li><a><?php echo e(Auth::user()->first_name); ?></a></li>
                                <li><a
                                        href="<?php if(Auth::user()->admin == 1): ?> <?php echo e(url('/admin/dashboard')); ?>  <?php else: ?> <?php echo e(url('/My-Account')); ?> <?php endif; ?>"><i
                                            class="fas fa-user"></i> My Profile</a></li>
                                <li><a href="#"><i class="fas fa-home"></i> My Properties List</a></li>
                                <li><a href="#"><i class="fas fa-heart"></i> Favorites</a></li>
                                <li><a href="<?php echo e(url('/user/logout')); ?>"><i class="fas fa-sign-out-alt"></i> Log Out</a></li>
                                
                            </ul>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="topcountries">
                    <button data-toggle="collapse" data-target="#topcon_toggle">
                        <span class="country_before">International</span>
                    </button>
                    <div id="topcon_toggle" class="collapse">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-3">
                                    <ul class="nav flex-column" id="myTab" role="tablist">
                                        <?php $counter = 0; ?>
                                        <?php $__currentLoopData = $continent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $counter++; ?>
                                        <li class="nav-item">
                                            <a class="nav-link show <?= ($counter == 1) ? 'active' : ''?>"
                                                id="cont<?php echo e($c->code); ?>-tab" data-toggle="tab" href="#<?php echo e($c->code); ?>"
                                                role="tab" aria-controls="cont<?php echo e($c->code); ?>tab"
                                                aria-selected="<?=($counter == 1) ? 'true' : ''?>"><span
                                                    class="mapicon">
                                                    <img
                                                        src="/images/frontend_images/images/<?php echo e($c->icon_image); ?>"></span><?php echo e($c->name); ?></a>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </div>
                                <div class="col-lg-9">
                                    <div class="tab-content" id="myTabContent">
                                        <?php $counter = 0; ?>
                                        <?php $__currentLoopData = $continent; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php $counter++; ?>
                                        <div class="tab-pane fade show <?= ($counter == 1) ? 'active' : ''?>"
                                            id="<?php echo e($c->code); ?>" role="tabpanel"
                                            aria-labelledby="cont<?php echo e($c->code); ?>-tab">
                                            <ul class="country_list">
                                                <?php $__currentLoopData = $country; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $coun): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <?php if($coun->continent == $c->code): ?>
                                                <li>
                                                    <a href="<?php echo e(url('country_property/properties-for-sale-in-'.str_replace(' ','_',$coun->name))); ?>"
                                                        style="margin: 0.2em 0em;"
                                                        class="btn btn-outline-dark"><?php echo e($coun->name); ?></a>
                                                </li>
                                                <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </ul>
                                        </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
    <!-- Main Menu desktop menu end --><?php /**PATH D:\GITHUB\IndiaPropertyClinic\resources\views/layouts/frontLayout/header_design.blade.php ENDPATH**/ ?>