<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!--Full width header Start-->
<div class="full-width-header">
    <!-- Toolbar Start -->
    <div class="rs-toolbar hidden-md">
        <div class="container">
            <div class="row">
                <div class="col-12 col-sm-12 col-md-9 col-lg-9 col-xl-9">
                    <div class="rs-toolbar-left">
                        <?php if (!empty($settings->phone_1)) : ?>
                            <div class="welcome-message">
                                <a rel="dofollow" href="tel:<?= $settings->phone_1 ?>" title="<?= $languageJSON["footer"]["phone_1"]["value"] ?>" class="align-items-center my-auto py-auto"><i class="fa fa-phone align-items-center my-auto py-auto"></i> <?= $settings->phone_1 ?></a>
                            </div>
                        <?php endif ?>
                        <?php if (!empty($settings->phone_2)) : ?>
                            <div class="welcome-message">
                                <a rel="dofollow" href="tel:<?= $settings->phone_2 ?>" title="<?= $languageJSON["footer"]["phone_2"]["value"] ?>" class="align-items-center my-auto py-auto"><i class="fa fa-mobile-phone align-items-center my-auto py-auto"></i> <?= $settings->phone_2 ?></a>
                            </div>
                        <?php endif ?>
                        <?php if (!empty($settings->fax_1)) : ?>
                            <div class="welcome-message">
                                <a rel="dofollow" href="tel:<?= $settings->fax_1 ?>" title="<?= $languageJSON["footer"]["fax_1"]["value"] ?>" class="align-items-center my-auto py-auto"><i class="fa fa-fax align-items-center my-auto py-auto"></i> <?= $settings->fax_1 ?></a>
                            </div>
                        <?php endif ?>
                        <?php if (!empty($settings->fax_2)) : ?>
                            <div class="welcome-message">
                                <a rel="dofollow" href="tel:<?= $settings->fax_2 ?>" title="<?= $languageJSON["footer"]["fax_2"]["value"] ?>" class="align-items-center my-auto py-auto"><i class="fa fa-fax align-items-center my-auto py-auto"></i> <?= $settings->fax_2 ?></a>
                            </div>
                        <?php endif ?>
                        <?php if (!empty($settings->email)) : ?>
                            <div class="welcome-message">
                                <a rel="dofollow" href="mailto:<?= $settings->email ?>" title="E-mail" class="align-items-center my-auto py-auto"><i class="fa fa-envelope align-items-center my-auto py-auto"></i> <?= $settings->email ?></a>
                            </div>
                        <?php endif ?>
                    </div>
                </div><!-- .rs-toolbar-left end-->
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 col-xl-3">
                    <div class="rs-toolbar-right">
                        <div class="toolbar-share-icon">
                            <ul>
                                <?php if (!empty($settings->facebook)) : ?>
                                    <li>
                                        <a rel="dofollow" href="<?= $settings->facebook ?>" title="Facebook" class="align-items-center my-auto py-auto mx-auto"><i class="fa fa-facebook align-items-center my-auto py-auto mx-auto"></i></a>
                                    </li>
                                <?php endif ?>
                                <?php if (!empty($settings->twitter)) : ?>
                                    <li>
                                        <a rel="dofollow" href="<?= $settings->twitter ?>" title="Twitter" class="align-items-center my-auto py-auto mx-auto"><i class="fa fa-twitter align-items-center my-auto py-auto mx-auto"></i></a>
                                    </li>
                                <?php endif ?>
                                <?php if (!empty($settings->instagram)) : ?>
                                    <li>
                                        <a rel="dofollow" href="<?= $settings->instagram ?>" title="Instagram" class="align-items-center my-auto py-auto mx-auto"><i class="fa fa-instagram align-items-center my-auto py-auto mx-auto"></i></a>
                                    </li>
                                <?php endif ?>
                                <?php if (!empty($settings->linkedin)) : ?>
                                    <li>
                                        <a rel="dofollow" href="<?= $settings->linkedin ?>" title="Linkedin" class="align-items-center my-auto py-auto mx-auto"><i class="fa fa-linkedin align-items-center my-auto py-auto mx-auto"></i></a>
                                    </li>
                                <?php endif ?>
                                <?php if (!empty($settings->youtube)) : ?>
                                    <li>
                                        <a rel="dofollow" href="<?= $settings->youtube ?>" title="Youtube" class="align-items-center my-auto py-auto mx-auto"><i class="fa fa-youtube align-items-center my-auto py-auto mx-auto"></i></a>
                                    </li>
                                <?php endif ?>
                                <?php if (!empty($settings->medium)) : ?>
                                    <li>
                                        <a rel="dofollow" href="<?= $settings->medium ?>" title="Medium" class="align-items-center my-auto py-auto mx-auto"><i class="fa fa-medium align-items-center my-auto py-auto mx-auto"></i></a>
                                    </li>
                                <?php endif ?>
                                <?php if (!empty($settings->pinterest)) : ?>
                                    <li>
                                        <a rel="dofollow" href="<?= $settings->pinterest ?>" title="Pinterest" class="align-items-center my-auto py-auto mx-auto"><i class="fa fa-pinterest align-items-center my-auto py-auto mx-auto"></i></a>
                                    </li>
                                <?php endif ?>
                            </ul>
                        </div>
                    </div><!-- .rs-toolbar-right end-->
                </div>
            </div>
        </div>
    </div>
    <!-- Toolbar End -->

    <!--Header Start-->
    <header id="rs-header" class="rs-header rs-defult-header bg-dark">
        <div class="menu-area menu-sticky bg-dark">
            <div class="container">
                <div class="main-menu">
                    <div class="row">
                        <div class="col-12">
                            <!-- logo-area star-->
                            <div class="logo-area">
                                <a rel="dofollow" href="<?= base_url() ?>" title="<?= $settings->company_name ?>">
                                    <picture>
                                        <img src="<?= get_picture("settings_v", $settings->logo) ?>" data-src="<?= get_picture("settings_v", $settings->logo) ?>" alt="<?= $settings->company_name ?>" class="lazyload img-full img-fluid">
                                    </picture>
                                </a>
                            </div><!-- .logo-area end-->

                            <!-- mainmenu-area start -->
                            <div class="mainmenu-area">
                                <a class="rs-menu-toggle"><i class="fa fa-bars"></i></a>
                                <nav class="rs-menu">
                                    <?= $menus ?>
                                </nav>
                                <div class="cart-area">
                                    <form action="<?= base_url($languageJSON["routes"]["dil-degistir"]) ?>" method="POST" enctype="multipart/form-data" id="langform" class="off-canvas-search-btn">
                                        <select name="lang" onchange="$('#langform').submit()" required>
                                            <?php if (!empty($languages)) : ?>
                                                <option value="">TR</option>
                                                <?php foreach ($languages as $key => $value) : ?>
                                                    <option value="<?= $value ?>" <?= ($value === $lang ? "selected" : null) ?>><?= strto("lower|upper", $value) ?></option>
                                                <?php endforeach ?>
                                            <?php endif ?>
                                        </select>
                                    </form>
                                </div>
                                <div class="cart-area2">
                                    <a class="rs-search" data-target=".search-modal" data-toggle="modal" href="javascript:void(0)">
                                        <i class="fa fa-search"></i></a>
                                </div>

                            </div><!-- .mainmenu-area end -->
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </header>
    <!--Header End-->
</div>
<!--Full width header End-->