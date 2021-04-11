<?php defined('BASEPATH') or exit('No direct script access allowed'); ?>
<!-- Root element of PhotoSwipe. Must have class pswp. -->
<div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">

	<!-- Background of PhotoSwipe.
	It's a separate element, as animating opacity is faster than rgba() . -->
	<div class="pswp__bg"></div>

	<!--Slides wrapper with overflow:hidden . -->
	<div class="pswp__scroll-wrap">

		<!--Container that holds slides . PhotoSwipe keeps only 3 slides in DOM to save memory . -->
		<!--don't modify these 3 pswp__item elements, data is added later on. -->
		<div class="pswp__container">
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
			<div class="pswp__item"></div>
		</div>

		<!-- Default (PhotoSwipeUI_Default) interface on top of sliding area. Can be changed. -->
		<div class="pswp__ui pswp__ui--hidden">

			<div class="pswp__top-bar">

				<!--  Controls are self-explanatory. Order can be changed. -->

				<div class="pswp__counter"></div>

				<button class="pswp__button pswp__button--close" title="Kapat (Esc)"></button>

				<button class="pswp__button pswp__button--fs" title="Tam Ekran"></button>

				<button class="pswp__button pswp__button--zoom" title="Yakınlaştır / Uzaklaştır"></button>

				<!-- Preloader demo https://codepen.io/dimsemenov/pen/yyBWoR -->
				<div class="pswp__preloader">
					<div class="pswp__preloader__icn">
						<div class="pswp__preloader__cut">
							<div class="pswp__preloader__donut"></div>
						</div>
					</div>
				</div>
			</div>

			<button class="pswp__button pswp__button--arrow--left" title="Önceki (arrow left)">
			</button>

			<button class="pswp__button pswp__button--arrow--right" title="Sonraki (arrow right)">
			</button>

			<div class="pswp__caption">
				<div class="pswp__caption__center"></div>
			</div>

		</div>

	</div>
</div>

<!-- Footer Start -->
<footer id="rs-footer" class="rs-footer">
	<!-- Footer Top -->
	<div class="footer-top-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-10">
					<?= $footer_menus ?>
				</div>
				<div class="col-lg-2">
					<div class="footer-share">
						<ul>
							<?php if (!empty($settings->facebook)) : ?>
								<li><a rel="dofollow" href="<?= $settings->facebook ?>" title="Facebook"><i class="fa fa-facebook"></i></a></li>
							<?php endif ?>
							<?php if (!empty($settings->twitter)) : ?>
								<li><a rel="dofollow" href="<?= $settings->twitter ?>" title="Twitter"><i class="fa fa-twitter"></i></a></li>
							<?php endif ?>
							<?php if (!empty($settings->instagram)) : ?>
								<li><a rel="dofollow" href="<?= $settings->instagram ?>" title="Instagram"><i class="fa fa-instagram"></i></a></li>
							<?php endif ?>
							<?php if (!empty($settings->linkedin)) : ?>
								<li><a rel="dofollow" href="<?= $settings->linkedin ?>" title="Linkedin"><i class="fa fa-linkedin"></i></a></li>
							<?php endif ?>
							<?php if (!empty($settings->youtube)) : ?>
								<li><a rel="dofollow" href="<?= $settings->youtube ?>" title="Youtube"><i class="fa fa-youtube"></i></a></li>
							<?php endif ?>
							<?php if (!empty($settings->medium)) : ?>
								<li><a rel="dofollow" href="<?= $settings->medium ?>" title="Medium"><i class="fa fa-medium"></i></a></li>
							<?php endif ?>
							<?php if (!empty($settings->pinterest)) : ?>
								<li><a rel="dofollow" href="<?= $settings->pinterest ?>" title="Pinterest"><i class="fa fa-pinterest"></i></a></li>
							<?php endif ?>

						</ul>
					</div>
				</div>
			</div>
			<span class="border-link"></span>
		</div>
	</div>
	<div class="footer-middle-section">
		<div class="container">
			<div class="row">
				<div class="col-lg-4">
					<div class="about-widget widgets">
						<div class="footer-logo">
							<a rel="dofollow" href="<?= base_url() ?>" title="<?= $settings->company_name ?>">
								<picture>
									<img src="<?= get_picture("settings_v", $settings->mobile_logo) ?>" data-src="<?= get_picture("settings_v", $settings->mobile_logo) ?>" alt="<?= $settings->company_name ?>" class="img-fluid lazyload">
								</picture>
							</a>
						</div>
						<p><?= $settings->about_us ?></p>
						<?php if (!empty($settings->address)) : ?>
							<div>
								<a rel="dofollow" href="http://maps.google.com/maps?q=<?= urlencode(clean($settings->address)) ?>" target="_blank" title="<?= $languageJSON["footer"]["map"]["value"] ?>"><i class='fa fa-map'></i> <?= $languageJSON["footer"]["map"]["value"] ?></a>
							</div>
						<?php endif ?>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="contact-info widgets">
						<h6><?= $languageJSON["footer"]["address"]["value"] ?></h6>

						<div class="address-info">
							<i class="fa fa-map"></i>
							<p><?= clean($settings->address) ?></p>
						</div>
						<?php if (!empty($settings->email)) : ?>
							<div class="email">
								<i class="fa fa-envelope-o"></i>
								<p>Email: <a rel="dofollow" href="mailto:<?= $settings->email ?>" title="Email"><?= $settings->email ?></a></p>
							</div>
						<?php endif ?>
						<?php if (!empty($settings->phone_1)) : ?>
							<div class="phn-number">
								<i class="fa fa-phone"></i>
								<p><?= $languageJSON["footer"]["phone_1"]["value"] ?>: <a rel="dofollow" href="tel:<?= $settings->phone_1 ?>" title="<?= $languageJSON["footer"]["phone_1"]["value"] ?>"><?= $settings->phone_1 ?></a></p>
							</div>
						<?php endif ?>
						<?php if (!empty($settings->phone_2)) : ?>
							<div class="phn-number">
								<i class="fa fa-mobile-phone"></i>
								<p><?= $languageJSON["footer"]["phone_2"]["value"] ?>: <a rel="dofollow" href="tel:<?= $settings->phone_2 ?>" title="<?= $languageJSON["footer"]["phone_2"]["value"] ?>"><?= $settings->phone_2 ?></a></p>
							</div>
						<?php endif ?>
						<?php if (!empty($settings->fax_1)) : ?>
							<div class="phn-number">
								<i class="fa fa-fax"></i>
								<p><?= $languageJSON["footer"]["fax_1"]["value"] ?>: <a rel="dofollow" href="tel:<?= $settings->fax_1 ?>" title="<?= $languageJSON["footer"]["fax_1"]["value"] ?>"><?= $settings->fax_1 ?></a></p>
							</div>
						<?php endif ?>
						<?php if (!empty($settings->fax_2)) : ?>
							<div class="phn-number">
								<i class="fa fa-fax"></i>
								<p><?= $languageJSON["footer"]["fax_2"]["value"] ?>: <a rel="dofollow" href="tel:<?= $settings->fax_2 ?>" title="<?= $languageJSON["footer"]["fax_2"]["value"] ?>"><?= $settings->fax_2 ?></a></p>
							</div>
						<?php endif ?>
					</div>
				</div>
				<div class="col-lg-4">
					<div class="subscribe-footer widgets">
						<h6><?= $languageJSON["footer"]["newsletter"]["value"] ?></h6>
						<ul>
							<?php foreach ($footerNews as $key => $value) : ?>
								<?php if (strtotime($value->sharedAt->$lang) <= strtotime("now")) : ?>
									<li><a class="text-white" rel="dofollow" href="<?= base_url($languageJSON["routes"]["haberler"] . "/" . $languageJSON["routes"]["haber"] . "/{$value->seo_url->$lang}") ?>"><?= $value->title->$lang ?></a></li>
								<?php endif ?>
							<?php endforeach ?>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Footer Bottom -->
	<div class="footer-bottom-section">
		<div class="container">
			<div class="copyright">
				<div class="row">
					<div class="col-9 col-sm-9 col-md-9 col-lg-9 col-xl-9">
						<p>© <?= date("Y") ?> <a rel="dofollow" href="<?= base_url() ?>" title="<?= $settings->company_name ?>"><?= $settings->company_name ?></a>. <?= $languageJSON["footer"]["allRightsReserved"]["value"] ?></p>
					</div>
					<div class="col-3 col-sm-3 col-md-3 col-lg-3 col-xl-3">
						<a rel="dofollow" href="https://mutfakyapim.com" title="Mutfak Yapım Dijital Reklam Ajansı" class="my-auto">
							<picture><img src="https://mutfakyapim.com/images/mutfak/logo.png" data-src="https://mutfakyapim.com/images/mutfak/logo.png" style="filter:drop-shadow(1px 1px 1px black);" class="img-fluid lazyload" alt="Mutfak Yapım Dijital Reklam Ajansı"></picture>
						</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</footer>
<!-- Footer End -->

<!-- start scrollUp  -->
<div id="scrollUp">
	<i class="fa fa-long-arrow-up"></i>
</div>

<!-- Search Modal Start -->
<div aria-hidden="true" class="modal fade search-modal" role="dialog" tabindex="-1">
	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		<span aria-hidden="true" class="fa fa-close"></span>
	</button>
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="search-block clearfix">
				<form>
					<div class="form-group">
						<input class="form-control" placeholder="Type Your Keyword..." type="text">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>




<!--FOOTER END-->
<a rel="dofollow" class="fixed-phone bg-danger" href="tel:<?= $settings->phone_1 ?>" data-toggle="tooltip" data-title="<?= $languageJSON["footer"]["phone_1"]["value"] ?>" data-placement="left" title="<?= $languageJSON["footer"]["phone_1"]["value"] ?>"><i class="fa fa-phone"></i></a>

<a rel="dofollow" class="fixed-whatsapp bg-success" href="https://api.whatsapp.com/send?phone=<?= $settings->phone_2 ?>&amp;text=<?= urlencode($settings->company_name) ?>." target="_blank" title="WhatsApp" data-toggle="tooltip" data-title="WhatsApp" data-placement="left"><i class="fa fa-whatsapp"></i></a>

<!--layout end-->
<!-- SCRIPTS -->
<script src="<?= base_url("public/js/modernizr-2.8.3.min.js"); ?>"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script>
<!-- Bootstrap Bundle -->
<script async src="https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.3.0/lazysizes.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.js"></script>
<script async defer src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/plugins/minMaxTimePlugin.min.js"></script>
<script async defer src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/plugins/momentPlugin.min.js"></script>
<script async defer src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/plugins/rangePlugin.min.js"></script>
<script async defer src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/plugins/scrollPlugin.min.js"></script>
<script async defer src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/plugins/confirmDate/confirmDate.min.js"></script>
<script async defer src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/plugins/labelPlugin/labelPlugin.min.js"></script>
<script async defer src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.6/plugins/weekSelect/weekSelect.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/l10n/<?= $lang == "en" ? "default" : $lang ?>.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.5.3/swiper-bundle.min.js"></script>
<!-- iziToast -->
<script async defer src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"></script>
<!-- iziModal -->
<script async defer src="<?= base_url("public/js/iziModal.min.js") ?>"></script>
<!-- PhotoSwipe -->
<script async defer src="<?= base_url("public/photoswipe/photoswipe.min.js") ?>"></script>
<script async defer src="<?= base_url("public/photoswipe/photoswipe-ui-default.min.js") ?>"></script>
<script async defer src="<?= base_url("public/js/zuck.css.min.js"); ?>"></script>
<script async defer src="<?= base_url("public/js/zuck.min.js"); ?>"></script>
<script async defer src="<?= base_url("public/js/timetable.js"); ?>"></script>
<script async defer src="<?= base_url("public/js/jquery.nav.js"); ?>"></script>
<script src="<?= base_url("public/js/owl.carousel.min.js"); ?>"></script>
<script async defer src="<?= base_url("public/js/slick.min.js"); ?>"></script>
<script async defer src="<?= base_url("public/js/isotope.pkgd.min.js"); ?>"></script>
<script async defer src="<?= base_url("public/js/imagesloaded.pkgd.min.js"); ?>"></script>
<script src="<?= base_url("public/js/wow.min.js"); ?>"></script>
<script src="<?= base_url("public/js/waypoints.min.js"); ?>"></script>
<script src="<?= base_url("public/js/jquery.counterup.min.js"); ?>"></script>
<script src="<?= base_url("public/js/jquery.magnific-popup.min.js"); ?>"></script>
<script async defer src="<?= base_url("public/js/rsmenu-main.js"); ?>"></script>
<script async defer src="<?= base_url("public/js/skill.bars.jquery.js"); ?>"></script>
<script async defer src="<?= base_url("public/js/plugins.js"); ?>"></script>
<script async defer src="<?= base_url("public/js/bmi.js"); ?>"></script>
<script src="<?= base_url("public/js/main.js") ?>"></script>
<script src="<?= base_url("public/js/app.js") ?>"></script>
<!-- SCRIPTS -->
<script>
	<?php if (!empty($stories)) : ?>
		if ($("#stories").length > 0) {
			let currentSkin = getCurrentSkin();
			$(".stories").each(function(index) {
				let elem = $(this).attr("id");
				let stories = new Zuck(elem, {
					backNative: true,
					previousTap: true,
					skin: currentSkin['name'],
					autoFullScreen: currentSkin['params']['autoFullScreen'],
					avatars: currentSkin['params']['avatars'],
					paginationArrows: currentSkin['params']['paginationArrows'],
					list: currentSkin['params']['list'],
					cubeEffect: currentSkin['params']['cubeEffect'],
					localStorage: true,
					stories: [
						<?php foreach ($stories as $story_key => $story_value) :
							$story_value->img_url = json_decode($story_value->img_url, true);
							$story_value->folder_name = json_decode($story_value->folder_name, true);
							$story_value->updatedAt = json_decode($story_value->updatedAt, true);
							$story_value->title = json_decode($story_value->title, true);
						?>
							<?php if ($story_value->isActive) : ?>(Zuck.buildTimelineItem(
									"<?= $story_value->title[$lang] ?>",
									"<?= get_picture("stories_v/" . ($story_value->folder_name[$lang]), $story_value->img_url[$lang]) ?>",
									"<?= $story_value->title[$lang] ?>",
									"<?= (empty($story_value->url[$lang]) ? "javascript:void(0)" : $story_value->url[$lang]) ?>",
									<?= (empty($story_value->url[$lang]) ? strtotime($story_value->createdAt) : strtotime($story_value->updatedAt)) ?>,
									[
										<?php if (!empty($story_items)) : ?>
											<?php foreach ($story_items as $story_item_key => $story_item_value) : ?>
												<?php if ($story_item_value->isActive && $story_item_value->story_id == $story_value->id) : ?>["<?= $story_item_value->id ?>",
														"<?= $story_item_value->type ?>",
														<?= $story_item_value->length ?>,
														"<?= ($story_item_value->type == "photo" ? base_url("panel/uploads/stories_v/{$story_value->folder_name[$lang]}/{$story_item_value->src}") : base_url("panel/uploads/stories_v/{$story_value->folder_name[$lang]}/{$story_item_value->src}"))  ?>",
														"<?= ($story_item_value->type == "photo" ? base_url("panel/uploads/stories_v/{$story_value->folder_name[$lang]}/{$story_item_value->src}") : base_url("panel/uploads/stories_v/{$story_value->folder_name[$lang]}/{$story_item_value->src}"))  ?>",
														'<?= $story_item_value->url_text ?>',
														'<?= $story_item_value->url ?>',
														false,
														timestamp()
													],
												<?php endif; ?>
											<?php endforeach; ?>
										<?php endif; ?>
									]
								)),
							<?php endif; ?>
						<?php endforeach; ?>
					],
					language: {
						unmute: '<?= $languageJSON["story"]["unmute"]["value"] ?>',
						keyboardTip: '<?= $languageJSON["story"]["keyboardTip"]["value"] ?>',
						visitLink: '<?= $languageJSON["story"]["visitLink"]["value"] ?>',
						time: {
							ago: '<?= $languageJSON["story"]["ago"]["value"] ?>',
							hour: '<?= $languageJSON["story"]["hour"]["value"] ?>',
							hours: '<?= $languageJSON["story"]["hours"]["value"] ?>',
							minute: '<?= $languageJSON["story"]["minute"]["value"] ?>',
							minutes: '<?= $languageJSON["story"]["minutes"]["value"] ?>',
							fromnow: '<?= $languageJSON["story"]["fromnow"]["value"] ?>',
							seconds: '<?= $languageJSON["story"]["seconds"]["value"] ?>',
							yesterday: '<?= $languageJSON["story"]["yesterday"]["value"] ?>',
							tomorrow: '<?= $languageJSON["story"]["tomorrow"]["value"] ?>',
							days: '<?= $languageJSON["story"]["days"]["value"] ?>'
						}
					}
				});
			});

		}
	<?php endif; ?>
	$(window).on("load", function() {
		$(".date-pick").flatpickr({
			enableTime: true,
			enableSeconds: true,
			dateFormat: "Y-m-d H:i:s",
			time_24hr: true,
			disableMobile: true,
			inline: false,
			minDate: "today",
			locale: "<?= $lang == "en" ? "default" : $lang ?>",
			onChange: function(selectedDates, dateStr, instance) {
				let full_date = new Date(selectedDates);
				let date = full_date.getDate();
				let month = full_date.toLocaleDateString("<?= $lang == "en" ? "default" : $lang . "-" . strto("lower|upper", $lang) ?>", {
					month: "long"
				});
				let year = full_date.getFullYear();
				$(instance.element).parents('.check-form').find('.val-date').html(date);
				$(instance.element).parents('.check-form').find('.month').html(month);
				$(instance.element).parents('.check-form').find('.year').html(year);
			},
		});
	});
</script>
<?php $this->load->view("includes/alert") ?>
</body>

</html>