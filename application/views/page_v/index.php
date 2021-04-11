<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php $item->title = json_decode($item->title, true)[$lang] ?>
<?php $item->img_url = json_decode($item->img_url, true)[$lang] ?>
<?php $item->content = json_decode($item->content, true)[$lang] ?>

<!-- Breadcrumbs Start -->
<div class="rs-breadcrumbs">
    <img src="<?= base_url("public/images/bg/contact-bg.webp") ?>" alt="<?= strto("lower|upper", $item->title) ?>">
    <div class="breadcrumbs-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="page-title"><?= strto("lower|upper", $item->title) ?></h1>
                    <ul>
                        <li>
                            <a class="active" rel="dofollow" href="<?= base_url(); ?>" title="<?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?>"><?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?></a>
                        </li>
                        <li><?= strto("lower|upper", $item->title) ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumbs End -->

<!-- About Us Start -->
<div id="rs-about" class="rs-about-inner section-padding">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="about-left-image">
                    <picture>
                        <img src="<?= get_picture("pages_v", $item->img_url) ?>" data-src="<?= get_picture("pages_v", $item->img_url) ?>" alt="<?= $item->title ?>" class="img-fluid lazyload" style="min-height:200px;object-fit:cover">
                    </picture>
                </div>
            </div>
            <div class="col-12">
                <div class="about-details mmt-40">
                    <h2><?= $item->title ?></h2>
                    <?= $item->content ?>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- About Us End -->

<?php if (!empty($testimonials)) : ?>
    <!-- Testimonial Start -->
    <div id="rs-testimonial" class="rs-testimonial section-padding dark-bg">
        <div class="container">
            <div class="section-title text-center sec-arrow-dark">
                <h4><?= $settings->company_name ?></h4>
                <h2><?= $languageJSON["homepage"]["testimonials"]["value"] ?></h2>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="rs-carousel owl-carousel" data-loop="<?= (count($testimonials) > 2 ? "true" : "false") ?>" data-items="3" data-margin="30" data-autoplay="true" data-autoplay-timeout="5000" data-smart-speed="2000" data-dots="true" data-nav="false" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="false" data-mobile-device-dots="true" data-ipad-device="2" data-ipad-device-nav="false" data-ipad-device-dots="true" data-ipad-device2="2" data-ipad-device-nav2="false" data-ipad-device-dots2="true" data-md-device="3" data-md-device-nav="false" data-md-device-dots="true">
                        <?php foreach ($testimonials as $key => $value) : ?>
                            <?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
                                <div class="testimonial-item text-center">
                                    <div class="testi-img">
                                        <picture>
                                            <img src="<?= get_picture("testimonials_v", $value->img_url->$lang) ?>" data-src="<?= get_picture("testimonials_v", $value->img_url->$lang) ?>" alt="<?= $value->title->$lang ?>" width="90" height="90" class="rounded-circle lazyload swiper-lazy">
                                        </picture>
                                    </div>
                                    <div class="testi-desc">
                                        <p><?= stripslashes($value->content->$lang) ?>
                                        </p>
                                        <h3 class="testi-name"><?= $value->full_name->$lang ?></h3>
                                        <span class="position"><?= $value->company->$lang ?></span>
                                    </div>
                                </div><!-- .testimonial-item end -->
                            <?php endif ?>
                        <?php endforeach ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Testimonial End -->
<?php endif ?>

<?php if (!empty($brands)) : ?>
    <!-- Client Logo Section Start Here-->
    <div class="clicent-logo-section sec-spacer">
        <div class="container">
            <div class="rs-carousel owl-carousel" data-loop="<?= (count($brands) > 4 ? "true" : "false") ?>" data-items="5" data-margin="30" data-autoplay="true" data-autoplay-timeout="5000" data-smart-speed="2000" data-dots="false" data-nav="false" data-nav-speed="false" data-mobile-device="2" data-mobile-device-nav="true" data-mobile-device-dots="false" data-ipad-device="3" data-ipad-device-nav="false" data-ipad-device-dots="false" data-ipad-device2="3" data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="5" data-md-device-nav="false" data-md-device-dots="false">
                <?php foreach ($brands as $key => $value) : ?>
                    <?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
                        <!-- Single Brand Logo Start -->
                        <div class="single-logo">
                            <picture>
                                <img src="<?= get_picture("brands_v", $value->img_url->$lang) ?>" data-src="<?= get_picture("brands_v", $value->img_url->$lang) ?>" alt="<?= $value->title->$lang ?>" width="150" height="70" class="lazyload swiper-lazy">
                            </picture>
                        </div>
                        <!-- Single Brand Logo End -->
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <!-- Client Logo Section End Here-->
<?php endif ?>