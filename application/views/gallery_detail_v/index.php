<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Breadcrumbs Start -->
<div class="rs-breadcrumbs">
    <img src="<?= base_url("public/images/bg/contact-bg.webp") ?>" alt="<?= strto("lower|upper", $gallery->title->$lang) ?>">
    <div class="breadcrumbs-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="page-title"><?= strto("lower|upper", $gallery->title->$lang) ?></h1>
                    <ul>
                        <li><a class="active" rel="dofollow" href="<?= base_url(); ?>" title="<?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?>"><?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?></a></li>
                        <li><a class="active" rel="dofollow" href="<?= base_url($languageJSON["routes"]["galeriler"]); ?>" title="<?= strto("lower|upper", $languageJSON["routes"]["galeriler"]); ?>"><?= strto("lower|upper", $languageJSON["routes"]["galeriler"]); ?></a></li>
                        <li><?= strto("lower|upper", $gallery->title->$lang) ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumbs End -->

<!-- Gallery Section Start -->
<div id="rs-gallery-sction" class="rs-gallery-sction3 gallery-page pt-100 pb-100">
    <div class="container">
        <div class="row pagination-gallery gallery-slider" itemscope>
            <div class="col-12">
                <?php if (!empty($gallery->title->$lang)) : ?>
                    <h4><?= $gallery->title->$lang ?></h4>
                <?php endif ?>
                <?= !empty($gallery->content->$lang) ? $gallery->content->$lang : null ?>
            </div>
            <?php foreach ($gallery_items as $key => $value) : ?>
                <figure class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3" itemprop="associatedMedia" itemscope>
                    <?php if ($gallery->gallery_type == "files") : ?>
                        <a rel="dofollow" href="<?= get_picture("galleries_v/$gallery->gallery_type/$gallery->folder_name->$lang", $value->url) ?>" alt="<?= $value->title ?>" download><i class="fa fa-download fa-2x"></i></a>
                    <?php elseif ($gallery->gallery_type == "videos") : ?>
                        <video id="my-video<?= $key ?>" controls preload="auto" width="100%">
                            <source src="<?= get_picture("galleries_v/$gallery->gallery_type/$gallery->folder_name->$lang", $value->url) ?>" />
                        </video>
                    <?php elseif ($gallery->gallery_type == "video_urls") : ?>
                        <?= htmlspecialchars_decode($value->url) ?>
                    <?php else : ?>
                        <a rel="dofollow" href="<?= get_picture("galleries_v/{$gallery->gallery_type}/{$gallery->folder_name->$lang}", $value->url) ?>" title="<?= $languageJSON["detailPages"]["viewItem"] ?>" itemprop="contentUrl" data-size="964x1024">
                            <picture>
                                <img class="img-fluid" src="<?= get_picture("galleries_v/{$gallery->gallery_type}/{$gallery->folder_name->$lang}", $value->url) ?>" data-src="<?= get_picture("galleries_v/{$gallery->gallery_type}/{$gallery->folder_name->$lang}", $value->url) ?>" alt="<?= $value->title ?>" itemprop="thumbnail" style="min-height:200px;object-fit:cover">
                            </picture>
                            <figcaption itemprop="caption description">
                                <small><?= $value->title ?></small>
                                <?= $value->description ?>
                            </figcaption>
                        </a>
                    <?php endif ?>
                </figure>
            <?php endforeach ?>
            <?php foreach ($sectors as $key => $value) : ?>
                <?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
                    <div class="col-12 col-sm-12 col-md-4 col-lg-3 col-xl-3">
                        <div class="gallery-item popup-inner">
                            <div class="gallery-content popup-box">
                                <picture>
                                    <img data-src="<?= get_picture("sectors_v", $value->img_url->$lang) ?>" class="img-fluid lazyload" alt="<?= $value->title->$lang ?>" src="<?= get_picture("services_v", $value->img_url->$lang) ?>">
                                </picture>
                                <div class="popup-text">
                                    <a rel="dofollow" class="image-popup" href="<?= get_picture("sectors_v", $value->img_url->$lang) ?>">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </a>
                                    <?php if (!empty($gallery->title->$lang)) : ?>
                                        <h4><?= $gallery->title->$lang ?></h4>
                                    <?php endif ?>
                                </div>
                            </div>

                        </div><!-- .gallery-item end -->
                    </div>
                <?php endif ?>
            <?php endforeach ?>
        </div>
    </div>
</div>
<!-- Gallery Section End -->

<!-- Project Section Start -->
<div class="section section-padding">
    <div class="container">

        <div class="row mb-n9">
            <div class="col-md-5 col-lg-3 mb-8 col-sm-12">
                <div class="project-info">
                    <ul class="mb-n1">
                        <li><span><?= $languageJSON["detailPages"]["publishDate"] ?> :</span> <?= iconv("ISO-8859-9", "UTF-8", strftime("%d %B %Y, %A %X", strtotime($gallery->createdAt))) ?></li>
                        <li><span><?= $languageJSON["detailPages"]["lastUpdate"] ?> :</span> <?= iconv("ISO-8859-9", "UTF-8", strftime("%d %B %Y, %A %X", strtotime($gallery->updatedAt))); ?></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-7 col-lg-9 col-sm-12 mb-8">
                <div class="project-desc">
                    <?php if (!empty($gallery->title->$lang)) : ?>
                        <h4 class="title mb-6"><?= $gallery->title->$lang ?></h4>
                    <?php endif ?>
                    <?= !empty($gallery->content->$lang) ? $gallery->content->$lang : null ?>
                    <div class="project-image mb-10">
                        <div class="row gallery-slider" itemscope>
                            <?php foreach ($gallery_items as $key => $value) : ?>
                                <figure class="col-lg-4 col-md-6" itemprop="associatedMedia" itemscope>
                                    <?php if ($gallery->gallery_type == "files") : ?>
                                        <a rel="dofollow" href="<?= get_picture("galleries_v/$gallery->gallery_type/$gallery->folder_name->$lang", $value->url) ?>" alt="<?= $value->title ?>" download><i class="fa fa-download fa-2x"></i></a>
                                    <?php elseif ($gallery->gallery_type == "videos") : ?>
                                        <video id="my-video<?= $key ?>" controls preload="auto" width="100%">
                                            <source src="<?= get_picture("galleries_v/$gallery->gallery_type/$gallery->folder_name->$lang", $value->url) ?>" />
                                        </video>
                                    <?php elseif ($gallery->gallery_type == "video_urls") : ?>
                                        <iframe src="<?= $value->url ?>" allowfullscreen allowtransparency></iframe>
                                    <?php else : ?>
                                        <a rel="dofollow" href="<?= get_picture("galleries_v/{$gallery->gallery_type}/{$gallery->folder_name->$lang}", $value->url) ?>" title="<?= $languageJSON["detailPages"]["viewItem"] ?>" itemprop="contentUrl" data-size="964x1024">
                                            <picture>
                                                <img class="img-fluid" src="<?= get_picture("galleries_v/{$gallery->gallery_type}/{$gallery->folder_name->$lang}", $value->url) ?>" data-src="<?= get_picture("galleries_v/{$gallery->gallery_type}/{$gallery->folder_name->$lang}", $value->url) ?>" alt="<?= $value->title ?>" itemprop="thumbnail" style="min-height:200px;object-fit:cover">
                                            </picture>
                                            <figcaption itemprop="caption description">
                                                <small><?= $value->title ?></small>
                                                <?= $value->description ?>
                                            </figcaption>
                                        </a>
                                    <?php endif ?>
                                </figure>
                            <?php endforeach ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Project Masonry Section End -->

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