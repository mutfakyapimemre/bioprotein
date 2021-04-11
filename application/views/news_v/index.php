<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Breadcrumbs Start -->
<div class="rs-breadcrumbs">
    <img src="<?= base_url("public/images/bg/contact-bg.webp") ?>" alt="<?= strto("lower|upper", $languageJSON["routes"]["haberler"]); ?>">
    <div class="breadcrumbs-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="page-title"><?= strto("lower|upper", $languageJSON["routes"]["haberler"]); ?></h1>
                    <ul>
                        <li>
                            <a class="active" rel="dofollow" href="<?= base_url(); ?>" title="<?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?>"><?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?></a>
                        </li>
                        <li><?= strto("lower|upper", $languageJSON["routes"]["haberler"]); ?></li>
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
            <div class="col-lg-8">
                <div class="row pagination-itams">
                    <?php foreach ($news as $key => $value) : ?>
                        <?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
                            <!-- .blog-item  Start -->
                            <div class="col-md-6">
                                <div class="blog-item">
                                    <div class="blog-img">
                                        <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/" . $languageJSON["routes"]["haber"] . "/{$value->seo_url->$lang}") ?>" class="blog-overlay" title="<?= $value->title->$lang ?>">
                                            <picture>
                                                <img src="<?= get_picture("news_v", $value->img_url->$lang) ?>" data-src="<?= get_picture("news_v", $value->img_url->$lang) ?>" alt="<?= $value->title->$lang ?>" class="lazyload img-fluid w-100">
                                            </picture>
                                        </a>
                                    </div>
                                    <div class="blog-meta d-flex flex-wrap">
                                        <div class="meta flex-fill">
                                            <small style="cursor: pointer;" data-toggle="tooltip" title="<?= $languageJSON["detailPages"]["publishDate"] ?>" data-title="<?= $languageJSON["detailPages"]["publishDate"] ?>" data-placement="top"><small><?= iconv("ISO-8859-9", "UTF-8", strftime("%d %B %Y, %A %X", strtotime($value->createdAt))) ?></small></small>
                                        </div>
                                        <div class="meta flex-fill">
                                            <small style="cursor: pointer;" data-toggle="tooltip" title="<?= $languageJSON["detailPages"]["lastUpdate"] ?>" data-title="<?= $languageJSON["detailPages"]["lastUpdate"] ?>" data-placement="top"><small><?= iconv("ISO-8859-9", "UTF-8", strftime("%d %B %Y, %A %X", strtotime($value->updatedAt))); ?></small></small>
                                        </div>
                                    </div>
                                    <div class="blog-meta">
                                        <div class="meta">
                                            <?php foreach ($categories as $k => $v) : ?>
                                                <?php if ($v->id == $value->category_id) : ?>
                                                    <span><a rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/{$v->seo_url->$lang}") ?>" title="<?= $v->title->$lang ?>"><?= $v->title->$lang ?></a></span>
                                                <?php endif ?>
                                            <?php endforeach ?>
                                        </div>
                                    </div>
                                    <h4 class="blog-title"><a rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/" . $languageJSON["routes"]["haber"] . "/{$value->seo_url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $value->title->$lang ?></a></h4>
                                    <div class="blog-dsc">
                                        <?= mb_word_wrap($value->content->$lang, 250, "...") ?>
                                    </div>
                                    <div class="blog-btn">
                                        <a rel="dofollow" class="link" href="<?= base_url($languageJSON["routes"]["haberler"] . "/" . $languageJSON["routes"]["haber"] . "/{$value->seo_url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $languageJSON["detailPages"]["viewNews"] ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a>
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
            <div class="col-lg-4">
                <div class="sidebar-area mmt-60">
                    <div class="search-box">
                        <h4 class="title"><?= $languageJSON["detailPages"]["searchNews"] ?></h4>
                        <div class="box-search">
                            <form action="<?= !empty($this->uri->segment(2) && !is_numeric($this->uri->segment(2))) ? base_url($languageJSON["routes"]["haberler"] . "/" . $this->uri->segment(2)) : base_url($languageJSON["routes"]["haberler"]) ?>" method="GET" enctype="multipart/form-data">
                                <input class="form-control" placeholder="<?= $languageJSON["detailPages"]["searchNews"] ?>..." name="search" id="srch-term" type="text">
                                <button class="btn btn-default" type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                    <?php if (!empty($categories)) : ?>
                        <div class="cate-box">
                            <h4 class="title"><?= $languageJSON["detailPages"]["newsCategories"] ?></h4>
                            <ul>
                                <?php foreach ($categories as $key => $value) : ?>
                                    <li>
                                        <i class="fa fa-angle-right" aria-hidden="true"></i> <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/{$value->seo_url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $value->title->$lang ?></a>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    <?php endif ?>
                    <?php if (!empty($latestNews)) : ?>
                        <div class="latest-courses">
                            <h4 class="title"><?= $languageJSON["detailPages"]["latestNews"] ?></h4>
                            <?php foreach ($latestNews as $key => $value) : ?>
                                <?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
                                    <div class="post-item">
                                        <div class="post-img">
                                            <a rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/" . $languageJSON["routes"]["haber"] . "/{$value->seo_url->$lang}") ?>" title="<?= $value->title->$lang ?>">
                                                <picture>
                                                    <img src="<?= get_picture("news_v", $value->img_url->$lang) ?>" data-src="<?= get_picture("news_v", $value->img_url->$lang) ?>" alt="<?= $value->title->$lang ?>" class="lazyload img-fluid w-100">
                                                </picture>
                                            </a>
                                        </div>
                                        <div class="post-desc">
                                            <h6><a rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/" . $languageJSON["routes"]["haber"] . "/{$value->seo_url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $value->title->$lang ?></a></h6>
                                            <span class="admin d-block"><?php foreach ($categories as $k => $v) : ?>
                                                    <?php if ($v->id == $value->category_id) : ?>
                                                        <span><a rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/{$v->seo_url->$lang}") ?>" title="<?= $v->title->$lang ?>"><?= $v->title->$lang ?></a></span>
                                                    <?php endif ?>
                                                <?php endforeach ?></span>
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