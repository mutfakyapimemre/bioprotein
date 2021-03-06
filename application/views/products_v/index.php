<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Breadcrumbs Start -->
<div class="rs-breadcrumbs">
    <img src="<?= base_url("public/images/bg/contact-bg.webp") ?>" alt="<?= strto("lower|upper", $languageJSON["detailPages"]["products"]); ?>">
    <div class="breadcrumbs-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="page-title"><?= strto("lower|upper", $languageJSON["detailPages"]["products"]); ?></h1>
                    <ul>
                        <li>
                            <a class="active" rel="dofollow" href="<?= base_url(); ?>" title="<?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?>"><?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?></a>
                        </li>
                        <li><?= strto("lower|upper", $languageJSON["detailPages"]["products"]); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumbs End -->

<!-- RS Blog Start -->
<div id="rs-blog" class="rs-blog blog-pages sec-spacer">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8">
                <div class="row pagination-itams">
                    <?php foreach ($products as $key => $value) : ?>
                        <?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
                            <!-- .blog-item  Start -->
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="blog-item shadow-sm">
                                    <div class="blog-img">
                                        <?php if ($value->isDiscount) : ?>
                                            <span class="discount-badge">%<?= $value->discount->$lang ?></span>
                                        <?php endif ?>
                                        <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" class="blog-overlay" title="<?= $value->title->$lang ?>">
                                            <?php $imageURL = null ?>
                                            <?php if (!empty($product_images)) : ?>
                                                <?php foreach ($product_images as $k => $v) : ?>
                                                    <?php if ($v->product_id == $value->id && $v->isCover) : ?>
                                                        <?php $imageURL = $v->url ?>
                                                    <?php endif ?>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                            <picture>
                                                <img src="<?= get_picture("products_v", $imageURL) ?>" data-src="<?= get_picture("products_v", $imageURL) ?>" alt="<?= $value->title->$lang ?>" class="lazyload img-fluid w-100" style="min-height: 255px;max-height:255px;object-fit:cover">
                                            </picture>
                                        </a>
                                    </div>
                                    <h4 class="blog-title text-center"><a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $value->title->$lang ?></a></h4>
                                    <div class="blog-meta text-center">
                                        <div class="meta">
                                            <?php $count = count(explode(",", $value->category_id)) ?>
                                            <?php $i = 1 ?>
                                            <?php foreach ($categories as $k => $v) : ?>
                                                <?php if (in_array($v->id, explode(",", $value->category_id))) : ?>
                                                    <?php if ($i < $count) : ?>
                                                        <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/{$v->seo_url->$lang}") ?>" title="<?= $v->title->$lang ?>"><?= $v->title->$lang ?></a>,
                                                    <?php else : ?>
                                                        <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/{$v->seo_url->$lang}") ?>" title="<?= $v->title->$lang ?>"><?= $v->title->$lang ?></a>
                                                    <?php endif ?>
                                                    <?php $i++ ?>
                                                <?php endif; ?>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                    <div class="rating-price text-center">
                                        <?php if ($value->isDiscount) : ?>
                                            <span class="product-price-mark"><?= $formatter->formatCurrency($value->price->$lang, $currency) ?></span>
                                            <span class="product-price"><?= $formatter->formatCurrency((($value->price->$lang) - (($value->price->$lang * $value->discount->$lang) / 100)), $currency) ?></span>
                                        <?php else : ?>
                                            <span class="product-price"><?= $formatter->formatCurrency($value->price->$lang, $currency) ?></span>
                                        <?php endif ?>
                                    </div>
                                    <div class="blog-btn text-center pb-3">
                                        <a rel="dofollow" class="link" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $languageJSON["detailPages"]["viewProduct"] ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a>
                                    </div>
                                </div>
                            </div>
                        <?php endif ?>
                        <!-- .blog-item  End -->
                    <?php endforeach ?>
                    <!-- Pagination Start -->
                    <div class="col-12" data-aos="fade-up" data-aos-delay="300">
                        <?= $links ?>
                    </div>
                    <!-- Pagination End -->
                </div>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4">
                <div class="sidebar-area mmt-60">
                    <div class="search-box">
                        <h4 class="title"><?= $languageJSON["detailPages"]["searchProduct"] ?></h4>
                        <div class="box-search">
                            <form action="<?= base_url($languageJSON["routes"]["urunler"]) ?>" method="GET" enctype="multipart/form-data">
                                <input class="form-control" placeholder="<?= $languageJSON["detailPages"]["searchProduct"] ?>..." name="search" id="srch-term" type="text">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                    <?php if (!empty($categories)) : ?>
                        <div class="cate-box">
                            <h4 class="title"><?= $languageJSON["detailPages"]["productCategories"] ?></h4>
                            <ul>
                                <?php foreach ($categories as $key => $value) : ?>
                                    <li>
                                        <i class="fa fa-angle-right" aria-hidden="true"></i> <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/{$value->seo_url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $value->title->$lang ?></a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>
                    <?php if (!empty($latestProducts)) : ?>

                        <div class="latest-courses">
                            <h4 class="title"><?= $languageJSON["detailPages"]["latestCategoryProducts"] ?></h4>
                            <?php foreach ($latestProducts as $key => $value) : ?>
                                <?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
                                    <div class="post-item">
                                        <div class="post-img">
                                            <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>">
                                                <?php $imgURL = null ?>
                                                <?php if (!empty($product_images)) : ?>
                                                    <?php foreach ($product_images as $k => $v) : ?>
                                                        <?php if ($v->product_id == $value->id && $v->isCover) : ?>
                                                            <?php $imgURL = $v->url ?>
                                                        <?php endif ?>
                                                    <?php endforeach ?>
                                                <?php endif ?>
                                                <picture>
                                                    <img src="<?= get_picture("products_v", $imgURL) ?>" data-src="<?= get_picture("products_v", $imgURL) ?>" alt="<?= $value->title->$lang ?>" class="lazyload img-fluid w-100">
                                                </picture>
                                            </a>
                                        </div>
                                        <div class="post-desc">
                                            <h6><a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $value->title->$lang ?></a></h6>
                                            <div>
                                                <?php if ($value->isDiscount) : ?>
                                                    <span class="admin-mark"><?= $formatter->formatCurrency($value->price->$lang, $currency) ?></span>
                                                    <span class="admin"><?= $formatter->formatCurrency(($value->price->$lang - ($value->price->$lang * $value->discount->$lang) / 100), $currency) ?></span>
                                                <?php else : ?>
                                                    <span class="admin"><?= $formatter->formatCurrency($value->price->$lang, $currency) ?></span>
                                                <?php endif ?>
                                            </div>
                                            <small class="date"><small><?= iconv("ISO-8859-9", "UTF-8", strftime("%d %B %Y, %A %X", strtotime($value->updatedAt))); ?></small></small>
                                        </div>
                                    </div>
                                <?php endif ?>
                            <?php endforeach ?>
                        </div>
                    <?php endif ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php if (!empty($suggestedProducts)) : ?>
    <!-- Products Start -->
    <div id="rs-products" class="rs-products dark-bg section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center sec-arrow-dark">
                        <h4><?= $settings->company_name ?></h4>
                        <h2><?= $languageJSON["homepage"]["suggestedProducts"]["value"] ?></h2>
                    </div>
                </div>
            </div>
            <div class="rs-carousel owl-carousel" data-loop="<?= (count($suggestedProducts) > 2 ? "true" : "false") ?>" data-items="3" data-margin="30" data-autoplay="true" data-autoplay-timeout="6000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="true" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="true" data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="true" data-ipad-device-dots2="false" data-md-device="3" data-md-device-nav="true" data-md-device-dots="false">
                <?php foreach ($suggestedProducts as $key => $value) : ?>
                    <?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
                        <?php $imageURL = null ?>
                        <?php if (!empty($product_images)) : ?>
                            <?php foreach ($product_images as $k => $v) : ?>
                                <?php if ($v->product_id == $value->id && $v->isCover) : ?>
                                    <?php $imageURL = $v->url ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>
                        <div class="product-item popup-inner">
                            <div class="product-img popup-box">
                                <?php if ($value->isDiscount) : ?>
                                    <span class="discount-badge">%<?= $value->discount->$lang ?></span>
                                <?php endif ?>
                                <picture>
                                    <img src="<?= get_picture("products_v", $imageURL) ?>" data-src="<?= get_picture("products_v", $imageURL) ?>" alt="<?= $value->title->$lang ?>" class="img-fluid lazyload" style="min-height: 255px;object-fit:cover;max-height:255px">
                                </picture>
                                <div class="popup-arrow">
                                    <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-details">
                                <h4 class="product-title"><a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $value->title->$lang ?></a></h4>
                                <div class="rating-price">
                                    <?php if ($value->isDiscount) : ?>
                                        <span class="product-price-mark"><?= $formatter->formatCurrency($value->price->$lang, $currency) ?></span>
                                        <span class="product-price"><?= $formatter->formatCurrency((($value->price->$lang) - (($value->price->$lang * $value->discount->$lang) / 100)), $currency) ?></span>
                                    <?php else : ?>
                                        <span class="product-price"><?= $formatter->formatCurrency($value->price->$lang, $currency) ?></span>
                                    <?php endif ?>
                                </div>
                                <div class="product-btn">
                                    <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $languageJSON["homepage"]["viewProducts"]["value"] ?></a></a>
                                </div>
                            </div>
                        </div><!-- .product-item end -->
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <!-- Products End -->
<?php endif ?>

<?php if (!empty($newProducts)) : ?>
    <!-- Products Start -->
    <div id="rs-products" class="rs-products section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h4><?= $settings->company_name ?></h4>
                        <h2><?= $languageJSON["detailPages"]["newProducts"] ?></h2>
                    </div>
                </div>
            </div>
            <div class="rs-carousel owl-carousel" data-loop="<?= (count($newProducts) > 2 ? "true" : "false") ?>" data-items="3" data-margin="30" data-autoplay="true" data-autoplay-timeout="6000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="true" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="true" data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="true" data-ipad-device-dots2="false" data-md-device="3" data-md-device-nav="true" data-md-device-dots="false">
                <?php foreach ($newProducts as $key => $value) : ?>
                    <?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
                        <?php $imageURL = null ?>
                        <?php if (!empty($product_images)) : ?>
                            <?php foreach ($product_images as $k => $v) : ?>
                                <?php if ($v->product_id == $value->id && $v->isCover) : ?>
                                    <?php $imageURL = $v->url ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>
                        <div class="product-item popup-inner">
                            <div class="product-img popup-box">
                                <?php if ($value->isDiscount) : ?>
                                    <span class="discount-badge">%<?= $value->discount->$lang ?></span>
                                <?php endif ?>
                                <picture>
                                    <img src="<?= get_picture("products_v", $imageURL) ?>" data-src="<?= get_picture("products_v", $imageURL) ?>" alt="<?= $value->title->$lang ?>" class="img-fluid lazyload" style="min-height: 255px;object-fit:cover;max-height:255px">
                                </picture>
                                <div class="popup-arrow">
                                    <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-details">
                                <h4 class="product-title"><a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $value->title->$lang ?></a></h4>
                                <div class="rating-price">
                                    <?php if ($value->isDiscount) : ?>
                                        <span class="product-price-mark"><?= $formatter->formatCurrency($value->price->$lang, $currency) ?></span>
                                        <span class="product-price"><?= $formatter->formatCurrency((($value->price->$lang) - (($value->price->$lang * $value->discount->$lang) / 100)), $currency) ?></span>
                                    <?php else : ?>
                                        <span class="product-price"><?= $formatter->formatCurrency($value->price->$lang, $currency) ?></span>
                                    <?php endif ?>
                                </div>
                                <div class="product-btn">
                                    <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $languageJSON["homepage"]["viewProducts"]["value"] ?></a></a>
                                </div>
                            </div>
                        </div><!-- .product-item end -->
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <!-- Products End -->
<?php endif ?>

<?php if (!empty($discountProducts)) : ?>
    <!-- Products Start -->
    <div id="rs-products" class="rs-products dark-bg section-padding">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center">
                        <h4><?= $settings->company_name ?></h4>
                        <h2><?= $languageJSON["detailPages"]["discountProducts"] ?></h2>
                    </div>
                </div>
            </div>
            <div class="rs-carousel owl-carousel" data-loop="<?= (count($discountProducts) > 2 ? "true" : "false") ?>" data-items="3" data-margin="30" data-autoplay="true" data-autoplay-timeout="6000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="true" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="true" data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="true" data-ipad-device-dots2="false" data-md-device="3" data-md-device-nav="true" data-md-device-dots="false">
                <?php foreach ($discountProducts as $key => $value) : ?>
                    <?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
                        <?php $imageURL = null ?>
                        <?php if (!empty($product_images)) : ?>
                            <?php foreach ($product_images as $k => $v) : ?>
                                <?php if ($v->product_id == $value->id && $v->isCover) : ?>
                                    <?php $imageURL = $v->url ?>
                                <?php endif ?>
                            <?php endforeach ?>
                        <?php endif ?>
                        <div class="product-item popup-inner">
                            <div class="product-img popup-box">
                                <?php if ($value->isDiscount) : ?>
                                    <span class="discount-badge">%<?= $value->discount->$lang ?></span>
                                <?php endif ?>
                                <picture>
                                    <img src="<?= get_picture("products_v", $imageURL) ?>" data-src="<?= get_picture("products_v", $imageURL) ?>" alt="<?= $value->title->$lang ?>" class="img-fluid lazyload" style="min-height: 255px;object-fit:cover;max-height:255px">
                                </picture>
                                <div class="popup-arrow">
                                    <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="product-details">
                                <h4 class="product-title"><a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $value->title->$lang ?></a></h4>
                                <div class="rating-price">
                                    <?php if ($value->isDiscount) : ?>
                                        <span class="product-price-mark"><?= $formatter->formatCurrency($value->price->$lang, $currency) ?></span>
                                        <span class="product-price"><?= $formatter->formatCurrency((($value->price->$lang) - (($value->price->$lang * $value->discount->$lang) / 100)), $currency) ?></span>
                                    <?php else : ?>
                                        <span class="product-price"><?= $formatter->formatCurrency($value->price->$lang, $currency) ?></span>
                                    <?php endif ?>
                                </div>
                                <div class="product-btn">
                                    <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["urunler"] . "/" . $languageJSON["routes"]["urun"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $languageJSON["homepage"]["viewProducts"]["value"] ?></a></a>
                                </div>
                            </div>
                        </div><!-- .product-item end -->
                    <?php endif ?>
                <?php endforeach ?>
            </div>
        </div>
    </div>
    <!-- Products End -->
<?php endif ?>

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