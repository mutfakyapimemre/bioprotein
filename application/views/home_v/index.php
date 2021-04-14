<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<?php if (!empty($slides)) : ?>
	<!-- Slider Area Start -->
	<div id="rs-slider" class="rs-slider rs-slider1">
		<div id="home-slider">
			<?php foreach ($slides as $key => $value) : ?>
				<?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
					<!-- Item 1 -->
					<div class="item <?= ($key == 0 ? "active" : null) ?>">
						<div class="slider-overlay"></div>
						<img src="<?= get_picture("slides_v", $value->img_url->$lang) ?>" data-src="<?= get_picture("slides_v", $value->img_url->$lang) ?>" alt="<?= $value->title->$lang ?>" />
						<div class="slide-content">
							<div class="display-table">
								<div class="display-table-cell">
									<div class="container text-center">
										<h1 class="slider-title" data-animation-in="fadeInLeft" data-animation-out="animate-out"><span class="next-step primary-color"><?= $settings->company_name ?></span> <?= $settings->slogan ?> </h1>
										<?php if (!empty($value->title->$lang)) : ?>
											<h2 class="slider-title"><?= $value->title->$lang ?></h2>
										<?php endif ?>
										<p><?= $value->description->$lang ?></p>
										<?php if ($value->allowButton->$lang == "1") : ?>
											<a rel="dofollow" target="_blank" href="<?= $value->button_url->$lang ?>" title="<?= $value->button_caption->$lang ?>" class="primary-btn" data-animation-in="lightSpeedIn" data-animation-out="animate-out"><?= $value->button_caption->$lang ?></a>
										<?php endif ?>
									</div>
								</div>
							</div>
						</div>
					</div><!-- .item 1 end-->
				<?php endif ?>
			<?php endforeach ?>
		</div>
	</div>
	<!-- Slider Area End -->
<?php endif ?>

<div id="storiesSticky2" class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 storiesSticky bg-light">
	<?php if (!empty($stories)) : ?>
		<div id="stories" class="stories carousel pt-2 mb-0 pb-0 snapgram pt-1">
		</div>
	<?php endif; ?>
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
			<div class="button-box text-center">
				<a class="primary-btn" href="<?= base_url($languageJSON["routes"]["urunler"]) ?>"><?= $languageJSON["detailPages"]["viewProducts"] ?></a>
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
			<div class="button-box text-center">
				<a class="primary-btn" href="<?= base_url($languageJSON["routes"]["urunler"]) ?>"><?= $languageJSON["detailPages"]["viewProducts"] ?></a>
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
			<div class="button-box text-center">
				<a class="primary-btn" href="<?= base_url($languageJSON["routes"]["urunler"]) ?>"><?= $languageJSON["detailPages"]["viewProducts"] ?></a>
			</div>
		</div>
	</div>
	<!-- Products End -->
<?php endif ?>

<!-- About Us Start -->
<div id="rs-about" class="rs-about section-padding">
	<div class="container">
		<div class="section-title text-center sec-arrow-dark">
			<h4><?= $settings->company_name ?></h4>
			<h2><?= $languageJSON["homepage"]["about_us"]["value"] ?></h2>
		</div><!-- .section-title end-->
		<div class="row">
			<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<div class="about-details">
					<?= $settings->about_us ?>
					<div class="ceo-founder mt-3">
						<div class="author-info">
							<h4><a rel="dofollow" href="<?= $languageJSON["homepage"]["about_us_btn_link"]["value"] ?>" title="<?= $languageJSON["homepage"]["about_us_btn"]["value"] ?>"><?= $languageJSON["homepage"]["about_us_btn"]["value"] ?></a></h4>
						</div>
					</div>
				</div>
			</div>
			<div class="col-12 col-sm-12 col-md-6 col-lg-6 col-xl-6">
				<div class="about-left mmt-40">
					<?php if (!empty($homeGallery) && !empty($homeGalleryItems)) : ?>
						<?php $homeGallery->folder_name = json_decode($homeGallery->folder_name, true) ?>
						<div class="about-image">
							<div class="about-slider swiper-container">
								<div class="swiper-wrapper">
									<?php foreach ($homeGalleryItems as $key => $value) : ?>
										<div class="swiper-slide bg-position mb-md-40 mb-sm-40">
											<picture>
												<img src="<?= get_picture("galleries_v/{$homeGallery->gallery_type}/{$homeGallery->folder_name[$lang]}", $value->url) ?>" data-src="<?= get_picture("galleries_v/{$homeGallery->gallery_type}/{$homeGallery->folder_name[$lang]}", $value->url) ?>" alt="<?= $value->title ?>" class="img-fluid lazyload swiper-lazy" style="min-height: 225px;object-fit:cover">
											</picture>
											<div class="swiper-lazy-preloader"></div>
										</div>
										<!--abt-img end-->
									<?php endforeach ?>


								</div>
								<!-- Slider pagination -->
								<div class="swiper-pagination"></div>

								<div class="about-slider-prev swiper-button-prev main-slider-nav"><i class="fa fa-angle-left"></i></div>
								<div class="about-slider-next swiper-button-next main-slider-nav"><i class="fa fa-angle-right"></i></div>
							</div>
						</div>
						<!--abt_carousel end-->
					<?php endif ?>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- About Us End -->

<?php if (!empty($services)) : ?>
	<!--  What We Do Start -->
	<div class="rs-what-wedo section-padding dark-bg">
		<div class="container">
			<div class="section-title text-center sec-arrow-dark">
				<h4><?= $settings->company_name ?></h4>
				<h2><?= $languageJSON["homepage"]["services"]["value"] ?></h2>
			</div><!-- .section-title end-->
			<div class="row">
				<div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
					<div class="rs-carousel owl-carousel" data-loop="<?= (count($services) > 2 ? "true" : "false") ?>" data-items="3" data-margin="30" data-autoplay="true" data-autoplay-timeout="5000" data-smart-speed="2000" data-dots="true" data-nav="false" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="true" data-mobile-device-dots="true" data-ipad-device="2" data-ipad-device-nav="false" data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="false" data-ipad-device-dots2="true" data-md-device="3" data-md-device-nav="false" data-md-device-dots="true">
						<?php foreach ($services as $key => $value) : ?>
							<?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
								<div class="single-postion">
									<a rel="dofollow" class="project-overlay" href="<?= base_url($languageJSON["routes"]["hizmet"] . "/{$value->url->$lang}") ?>" title="<?= $languageJSON["homepage"]["viewServices"]["value"] ?>">
										<picture>
											<img src="<?= get_picture("services_v", $value->img_url->$lang) ?>" data-src="<?= get_picture("services_v", $value->img_url->$lang) ?>" alt="<?= $value->title->$lang ?>" class="img-fluid lazyload" style="min-height: 255px;object-fit:cover">
										</picture>
									</a>
									<div class="position-details text-center">
										<h4 class="htitle"><?= $value->title->$lang ?></h4>
										<div class="hover-text">
											<a rel="dofollow" href="<?= base_url($languageJSON["routes"]["hizmet"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>">
												<h4><?= $value->title->$lang ?></h4>
											</a>
											<p><?= mb_word_wrap($value->content->$lang, 150, "...") ?></p>
											<div class="link">
												<a rel="dofollow" href="<?= base_url($languageJSON["routes"]["hizmet"] . "/{$value->url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $languageJSON["homepage"]["viewServices"]["value"] ?></a><i class="fa fa-long-arrow-right"></i>
											</div>
										</div>
									</div>
								</div><!-- .single-postion end-->
							<?php endif ?>
						<?php endforeach ?>
					</div>
				</div>
			</div><!-- .row -->
		</div><!-- .container -->
	</div>
	<!--  What We Do End -->
<?php endif ?>

<?php if (!empty($news)) : ?>
	<!-- RS Blog Start -->
	<div id="rs-blog" class="rs-blog section-padding">
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<div class="section-title text-center sec-arrow-dark">
						<h4><?= $settings->company_name ?></h4>
						<h2><?= $languageJSON["homepage"]["news"]["value"] ?></h2>

					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<div class="rs-carousel owl-carousel" data-loop="<?= (count($news) > 2 ? "true" : "false") ?>" data-items="3" data-margin="30" data-autoplay="true" data-autoplay-timeout="8000" data-smart-speed="2000" data-dots="false" data-nav="true" data-nav-speed="false" data-mobile-device="1" data-mobile-device-nav="true" data-mobile-device-dots="false" data-ipad-device="2" data-ipad-device-nav="true" data-ipad-device-dots="false" data-ipad-device2="2" data-ipad-device-nav2="true" data-ipad-device-dots2="false" data-md-device="3" data-md-device-nav="true" data-md-device-dots="false">
						<?php foreach ($news as $key => $value) : ?>
							<?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
								<?php $category = get_news_category_title($value->category_id); ?>
								<?php $category->title = json_decode($category->title, true)[$lang]; ?>
								<?php $category->seo_url = json_decode($category->seo_url, true)[$lang]; ?>
								<div class="blog-item">
									<div class="blog-img">
										<a rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/" . $languageJSON["routes"]["haber"] . "/{$value->seo_url->$lang}") ?>" title="<?= $value->title->$lang ?>">
											<picture>
												<img src="<?= get_picture("news_v", $value->img_url->$lang) ?>" data-src="<?= get_picture("news_v", $value->img_url->$lang) ?>" class="lazyload" alt="<?= $value->title->$lang ?>">
											</picture>
										</a>
									</div>
									<div class="blog-meta">
										<div class="meta">
											<span><a rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/{$category->seo_url}") ?>" title="<?= $category->title ?>"><?= $category->title ?></a></span>
										</div>
										<div class="meta">
											<?= iconv("ISO-8859-9", "UTF-8", strftime("%d %B %Y, %A %X", strtotime($value->updatedAt))); ?>
										</div>
									</div>
									<h4 class="blog-title"><a rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/" . $languageJSON["routes"]["haber"] . "/{$value->seo_url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $value->title->$lang ?></a></h4>
									<div class="blog-dsc">
										<?= mb_word_wrap($value->content->$lang, 250, "...") ?>
									</div>
									<div class="blog-btn">
										<a rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/" . $languageJSON["routes"]["haber"] . "/{$value->seo_url->$lang}") ?>" title="<?= $value->title->$lang ?>"><?= $languageJSON["homepage"]["viewNews"]["value"] ?> <i class="fa fa-angle-right" aria-hidden="true"></i></a>
									</div>
								</div><!-- .blog-item end -->
							<?php endif ?>
						<?php endforeach ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- RS Blog End -->
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