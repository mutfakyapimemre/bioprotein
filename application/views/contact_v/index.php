<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Breadcrumbs Start -->
<div class="rs-breadcrumbs">
    <img src="<?= base_url("public/images/bg/contact-bg.webp") ?>" alt="<?= strto("lower|upper", $languageJSON["contact"]["contact"]["value"]) ?>">
    <div class="breadcrumbs-inner">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h1 class="page-title"><?= strto("lower|upper", $languageJSON["contact"]["contact"]["value"]) ?></h1>
                    <ul>
                        <li>
                            <a class="active" rel="dofollow" href="<?= base_url(); ?>" title="<?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?>"><?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?></a>
                        </li>
                        <li><?= strto("lower|upper", $languageJSON["contact"]["contact"]["value"]); ?></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumbs End -->


<!-- Contact Page Start -->
<div class="contact-page-section sec-spacer">
    <div class="container">
        <div class="conatact-page mb-3"><?= htmlspecialchars_decode($settings->map) ?></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="row contact-info practical-information">
                    <div class="col-lg-12">
                        <h4 class="uppercase title-headding text-center"><?= strto("lower|upper", $languageJSON["contact"]["contact"]["value"]) ?></h4>
                    </div>
                    <div class="col-lg-6 text-center">
                        <div class="info-text address mb-2">
                            <h4 class="title"><?= strto("lower|upper", $languageJSON["contact"]["address"]["value"]); ?></h4>
                            <?php if (!empty($settings->address)) : ?>
                                <p><?= clean($settings->address) ?></p>
                            <?php endif ?>
                            <a rel="dofollow" href="http://maps.google.com/maps?q=<?= urlencode(clean($settings->address)) ?>" target="_blank" title="<?= $languageJSON["footer"]["map"]["value"] ?>"><i class="fa fa-map"></i> <?= $languageJSON["footer"]["map"]["value"] ?></a>
                        </div>
                        <div class="info-text phone">
                            <h4 class="title"><?= strto("lower|upper", $languageJSON["contact"]["phone"]["value"]); ?></h4>
                            <?php if (!empty($settings->phone_1)) : ?>
                                <p><a rel="dofollow" href="tel:<?= $settings->phone_1 ?>" title="<?= $languageJSON["footer"]["phone_1"]["value"] ?>"><i class="fa fa-phone"></i> <?= $settings->phone_1 ?></a></p>
                            <?php endif ?>
                            <?php if (!empty($settings->phone_2)) : ?>
                                <p><a rel="dofollow" href="tel:<?= $settings->phone_2 ?>" title="<?= $languageJSON["footer"]["phone_2"]["value"] ?>"><i class="fa fa-mobile-phone"></i> <?= $settings->phone_2 ?></a></p>
                            <?php endif ?>
                        </div>
                    </div>
                    <div class="col-lg-6 text-center">
                        <div class="info-text phone mb-2">
                            <h4 class="title"><?= strto("lower|upper", $languageJSON["contact"]["fax"]["value"]); ?></h4>
                            <?php if (!empty($settings->fax_1)) : ?>
                                <p><a rel="dofollow" href="tel:<?= $settings->fax_1 ?>" title="<?= $languageJSON["footer"]["fax_1"]["value"] ?>"><i class="fa fa-fax"></i> <?= $settings->fax_1 ?></a></p>
                            <?php endif ?>
                            <?php if (!empty($settings->fax_2)) : ?>
                                <p><a rel="dofollow" href="tel:<?= $settings->fax_2 ?>" title="<?= $languageJSON["footer"]["fax_2"]["value"] ?>"><i class="fa fa-fax"></i> <?= $settings->fax_2 ?></a></p>
                            <?php endif ?>
                        </div>
                        <div class="info-text">
                            <h4 class="title"><?= strto("lower|upper", $languageJSON["contact"]["email"]["value"]); ?></h4>
                            <p><a rel="dofollow" href="mailto:<?= $settings->email ?>" title="E-mail"><i class="fa fa-envelope"></i> <?= $settings->email ?></a></p>
                            <?php if (!empty($settings->facebook)) : ?>
                                <p><a rel="dofollow" href="<?= $settings->facebook ?>" title="Facebook"><i class="fa fa-facebook"></i> Facebook</a></p>
                            <?php endif ?>
                            <?php if (!empty($settings->twitter)) : ?>
                                <p><a rel="dofollow" href="<?= $settings->twitter ?>" title="Twitter"><i class="fa fa-twitter"></i> Twitter</a></p>
                            <?php endif ?>
                            <?php if (!empty($settings->instagram)) : ?>
                                <p><a rel="dofollow" href="<?= $settings->instagram ?>" title="Instagram"><i class="fa fa-instagram"></i> Instagram</a></p>
                            <?php endif ?>
                            <?php if (!empty($settings->linkedin)) : ?>
                                <p><a rel="dofollow" href="<?= $settings->linkedin ?>" title="Linkedin"><i class="fa fa-linkedin"></i> Linkedin</a></p>
                            <?php endif ?>
                            <?php if (!empty($settings->youtube)) : ?>
                                <p><a rel="dofollow" href="<?= $settings->youtube ?>" title="Youtube"><i class="fa fa-youtube"></i> Youtube</a></p>
                            <?php endif ?>
                            <?php if (!empty($settings->medium)) : ?>
                                <p><a rel="dofollow" href="<?= $settings->medium ?>" title="Medium"><i class="fa fa-medium"></i> Medium</a></p>
                            <?php endif ?>
                            <?php if (!empty($settings->pinterest)) : ?>
                                <p><a rel="dofollow" href="<?= $settings->pinterest ?>" title="Pinterest"><i class="fa fa-pinterest"></i> Pinterest</a></p>
                            <?php endif ?>
                        </div>
                    </div>
                </div>
                <div class="row contact-info get-in-touch">
                    <div class="col-lg-12">
                        <h4 class="uppercase title-headding text-center"><?= $languageJSON["contactForm"]["contactForm"]["value"] ?></h4>
                        <h6 class="uppercase title-headding text-center"><?= $languageJSON["contactForm"]["contactFormDesc"]["value"] ?></h6>
                    </div>
                    <div class="col-lg-8 offset-lg-2">
                        <div class="contact-form-area">
                            <form onsubmit="return false" enctype="multipart/form-data" method="POST" id="contact-form">
                                <div class="row">
                                    <div class="col-12 mb-3">
                                        <input class="form-control" type="text" name="full_name" data-aos="fade-right" data-aos-delay="300" placeholder="<?= $languageJSON["contactForm"]["namesurname"]["value"] ?>" required minlength="2" maxlength="70">
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <input class="form-control" type="email" name="email" data-aos="fade-left" data-aos-delay="300" placeholder="<?= $languageJSON["contactForm"]["emailaddress"]["value"] ?>" required>
                                    </div>
                                    <div class="col-md-6 col-12 mb-3">
                                        <input class="form-control" type="text" name="phone" data-aos="fade-up" data-aos-delay="400" placeholder="<?= $languageJSON["contactForm"]["phonenumber"]["value"] ?>" minlength="11" maxlength="19" required>
                                    </div>
                                    <div class="col-12 mb-3">
                                        <input class="form-control" type="text" name="subject" data-aos="fade-up" data-aos-delay="500" placeholder="<?= $languageJSON["contactForm"]["subject"]["value"] ?>">
                                    </div>
                                    <div class="col-12 mb-3">
                                        <textarea class="form-control" name="comment" data-aos="fade-up" data-aos-delay="600"></textarea>
                                    </div>
                                    <div class="col-12 text-center justify-content-center">
                                        <button type="button" data-aos="fade-up" data-aos-delay="700" data-url="<?= base_url($languageJSON["routes"]["iletisim-formu"]) ?>" class="primary-btn btnSubmitForm"><?= $languageJSON["contactForm"]["submit"]["value"] ?> <i class="fa fa-arrow-right"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  Contact Page End  -->

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