<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Breadcrumb Section Start -->
<div class="section breadcrumb-bg">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="cr-breadcrumb-area">
                    <h1 class="title"><?= $languageJSON["offer"]["offer"]["value"] ?></h1>
                    <ul class="breadcrumb-list">
                        <li><a rel="dofollow" href="<?= base_url(); ?>" title="<?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?>"><?= strto("lower|upper", $languageJSON["routes"]["anasayfa"]) ?></a></li>
                        <li><span><?= $languageJSON["offer"]["offer"]["value"] ?></span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Breadcrumb Section End -->

<!-- Contact Form Start -->
<div class="section bg-gray section-padding" data-aos="fade-up" data-aos-delay="100">
    <div class="container">
        <div class="row">
            <!-- Section Title Start -->
            <div class="col-12 section-title" data-aos="fade-up" data-aos-delay="300">
                <h2 class="title"><?= $languageJSON["offer"]["offer"]["value"] ?></h2>
                <span></span>
                <p></p>
            </div>
            <!-- Section Title End -->
        </div>
        <div class="row">
            <div class="offset-lg-2 col-lg-8">
                <div class="contact-form">
                    <form onsubmit="return false" id="offerform" enctype="multipart/form-data" method="POST">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label><?= $languageJSON["offerForm"]["namesurname"]["value"] ?></label>
                                    <input type="text" placeholder="<?= $languageJSON["offerForm"]["namesurname"]["value"] ?>" name="full_name" data-aos="fade-right" data-aos-delay="300" minlength="2" maxlength="70" class="input-item" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label><?= $languageJSON["offerForm"]["emailaddress"]["value"] ?></label>
                                    <input type="email" placeholder="<?= $languageJSON["offerForm"]["emailaddress"]["value"] ?>" name="email" data-aos="fade-left" data-aos-delay="300" class="input-item" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label><?= $languageJSON["offerForm"]["phonenumber"]["value"] ?></label>
                                    <input type="text" placeholder="<?= $languageJSON["offerForm"]["phonenumber"]["value"] ?>" name="phone" minlength="11" maxlength="19" data-aos="fade-up" data-aos-delay="400" class="input-item" required>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6">
                                <div class="form-group">
                                    <label><?= $languageJSON["offerForm"]["type"]["value"] ?></label>
                                    <select name="type" id="type" class="select-item" required data-aos="fade-up" data-aos-delay="500">
                                        <?php if (!empty($services)) : ?>
                                            <option value=""><?= $languageJSON["offerForm"]["type"]["value"] ?></option>
                                            <?php foreach ($services as $key => $value) : ?>
                                                <option value="<?= $value->id ?>"><?= $value->title->$lang ?></option>
                                            <?php endforeach ?>
                                        <?php endif ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <div class="form-group">
                                    <label><?= $languageJSON["offerForm"]["note"]["value"] ?></label>
                                    <textarea name="message" class="textarea-item" placeholder="<?= $languageJSON["offerForm"]["note"]["value"] ?>" data-aos="fade-up" data-aos-delay="600"></textarea>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                <button type="button" data-aos="fade-up" data-aos-delay="700" data-url="<?= base_url($languageJSON["routes"]["teklif-basvurusu"]) ?>" class="btn btn-primary btn-hover-dark makeOffer"><?= $languageJSON["offerForm"]["makeoffer"]["value"] ?></button>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- Contact Form End -->