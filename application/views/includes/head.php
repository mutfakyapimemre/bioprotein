<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>

	<!-- TITLE -->
	<title><?= $settings->company_name ?></title>
	<!-- TITLE -->

	<!-- META TAGS -->
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="author" content="Mutfak Yapım">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no, shrink-to-fit=no">

	<meta name="description" content="<?= clean(@$meta_desc) ?>">
	<meta name="keywords" content="<?= clean(@$meta_keyw) ?>">
	<meta name="subject" content="<?= clean(@$meta_desc) ?>">
	<meta name="copyright" content="<?= $settings->company_name ?>">
	<meta name="language" content="<?= strto("lower|upper", $lang) ?>">
	<meta name="robots" content="index,follow" />
	<meta name="revised" content="<?= turkishDate("d F Y, l H:i:s", date("Y-m-d H:i:s")) ?>" />
	<meta name="abstract" content="<?= clean(@$meta_desc) ?>">
	<meta name="topic" content="<?= clean(@$meta_desc) ?>">
	<meta name="summary" content="<?= clean(@$meta_desc) ?>">
	<meta name="Classification" content="Business">
	<meta name="author" content="Mutfak Yapım, info@mutfakyapim.com">
	<meta name="designer" content="Mutfak Yapım, info@mutfakyapim.com">
	<meta name="copyright" content="Mutfak Yapım, info@mutfakyapim.com 2021 &copy; Tüm Hakları Saklıdır.">
	<meta name="reply-to" content="<?= $settings->email ?>">
	<meta name="owner" content="Mutfak Yapım, info@mutfakyapim.com">
	<meta name="url" content="<?= clean(base_url()) ?>">
	<meta name="identifier-URL" content="<?= clean(base_url()) ?>">
	<meta name="directory" content="submission">
	<meta name="category" content="Article">
	<meta name="coverage" content="Worldwide">
	<meta name="distribution" content="Global">
	<meta name="rating" content="General">
	<meta name="revisit-after" content="7 days">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta content="yes" name="apple-touch-fullscreen" />
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta property="og:image:secure" content="<?= clean(@$og_image) ?>">
	<meta property="og:locale" content="<?= strto("lower", $lang) . '_' . strto("lower|upper", $lang) ?>">

	<meta property="og:url" content="<?= (!empty($og_url) ? clean($og_url) : clean(base_url())) ?>" />
	<meta property="og:type" content="<?= (!empty($og_type) ? clean($og_type) : "website") ?>" />
	<meta property="og:title" content="<?= (!empty($og_title) ? clean($og_title) : clean(@$meta_title)) ?>" />
	<meta property="og:description" content="<?= (!empty($og_description) ? clean($og_description) : clean(@$meta_desc)) ?>" />
	<meta property="og:image" content="<?= clean(@$og_image) ?>" />
	<meta property="og:image:secure_url" content="<?= clean(@$og_image) ?>" />
	<meta name="twitter:title" content="<?= (!empty($og_title) ? clean($og_title) : clean(@$meta_title)) ?>">
	<meta name="twitter:description" content="<?= (!empty($og_description) ? clean($og_description) : clean(@$meta_desc)) ?>">
	<meta name="twitter:image" content="<?= clean(@$og_image) ?>">
	<meta name="twitter:card" content="summary_large_image">
	<meta property="og:site_name" content="<?= (!empty($og_title) ? clean($og_title) : clean(@$meta_title)) ?>">
	<meta name="twitter:image:alt" content="<?= (!empty($og_title) ? clean($og_title) : clean(@$meta_title)) ?>">
	<meta name="googlebot" content="index, follow">
	<!--Favicon-->
	<link rel="shortcut icon" href="<?= get_picture("settings_v", $settings->favicon); ?>" type="image/x-icon">
	<style>
		/* ------------------------------------
			35. Preloader CSS
		---------------------------------------*/
		.preloader-area {
			background-color: #ea4c23;
			position: fixed;
			width: 100%;
			height: 100%;
			z-index: 9999;
		}

		.preloader-area .loader8 {
			position: absolute;
			left: 47.2%;
			top: 47.2%;
			transform: translate(-50%, -50%);
			-webiit-transform: translate(-50%, -50%);
			-ms-transform: translate(-50%, -50%);
			-o-transform: translate(-50%, -50%);
			width: 70px;
			height: 70px;
			border-radius: 50px;
			background-color: rgba(255, 255, 255, 0.2);
			border-width: 30px;
			border-style: double;
			border-color: transparent #fff;
			-webkit-box-sizing: border-box;
			-moz-box-sizing: border-box;
			box-sizing: border-box;
			-webkit-transform-origin: 50% 50%;
			transform-origin: 50% 50%;
			-webkit-animation: loader8 2s linear infinite;
			animation: loader8 2s linear infinite;
		}

		@-webkit-keyframes loader8 {
			0% {
				-webkit-transform: rotate(0deg);
			}

			100% {
				-webkit-transform: rotate(360deg);
			}
		}

		@keyframes loader8 {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}
	</style>

	<!-- META TAGS -->

	<!-- FAVICON -->
	<link rel="icon" href="<?= get_picture("settings_v", $settings->favicon); ?>">
	<!-- FAVICON -->

	<!-- === STYLES === -->
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css">
	</noscript>
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.compat.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.compat.min.css">
	</noscript>
	<!-- FONT AWESOME -->
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
	</noscript>
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/v4-shims.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/v4-shims.min.css">
	</noscript>
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/flatpickr.min.css">
	</noscript>
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/ie.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/ie.min.css">
	</noscript>
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/plugins/confirmDate/confirmDate.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/plugins/confirmDate/confirmDate.min.css">
	</noscript>
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/plugins/monthSelect/style.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/flatpickr/4.6.9/plugins/monthSelect/style.min.css">
	</noscript>
	<!-- iziToast -->
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'" />
	<noscript>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css" />
	</noscript>
	<!-- iziModal -->
	<link rel="preload" type="text/css" href="<?= base_url("public/css/iziModal.min.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'" />
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/iziModal.min.css") ?>" />
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/css/zuck.min.css"); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/zuck.min.css"); ?>">
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/css/skins/facesnap.min.css"); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/skins/facesnap.min.css"); ?>">
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/css/skins/snapgram.min.css"); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/skins/snapgram.min.css"); ?>">
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/css/skins/snapssenger.min.css"); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/skins/snapssenger.min.css"); ?>">
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/css/skins/vemdezap.min.css"); ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/skins/vemdezap.min.css"); ?>">
	</noscript>
	<!-- Photoswipe Gallery -->
	<link rel="preload" type="text/css" href="<?= base_url("public/photoswipe/photoswipe.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/photoswipe/photoswipe.css") ?>">
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/photoswipe/default-skin/default-skin.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/photoswipe/default-skin/default-skin.css") ?>">
	</noscript>
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
	</noscript>
	<link rel="preload" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.5.3/swiper-bundle.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/6.5.3/swiper-bundle.min.css">
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/css/timetable.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/timetable.css") ?>">
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/css/owl.carousel.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/owl.carousel.css") ?>">
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/css/slick.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/slick.css") ?>">
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/css/rsmenu-main.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/rsmenu-main.css") ?>">
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/css/rsmenu-transitions.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/rsmenu-transitions.css") ?>">
	</noscript>
	<link rel="preload" type="text/css" href="<?= base_url("public/css/magnific-popup.css") ?>" as="style" onload="this.onload=null;this.rel='stylesheet'">
	<noscript>
		<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/magnific-popup.css") ?>">
	</noscript>
	<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/style.css") ?>">
	<link rel="stylesheet" type="text/css" href="<?= base_url("public/css/responsive.css") ?>">
	<!--[if lt IE 9]>
            <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
            <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->

	<!-- === STYLES === -->

	<!-- SCRIPTS -->
	<script>
		let base_url = "<?= base_url() ?>";
	</script>
</head>

<body class="home1">
	<!--Preloader area start here-->
	<div class="preloader-area">
		<div class="box">
			<div class="loader8"></div>
		</div>
	</div>
	<!--Preloader area End here-->