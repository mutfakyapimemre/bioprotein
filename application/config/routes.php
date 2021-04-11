<?php
defined('BASEPATH') or exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'home/index';
$route['404_override'] = 'home/error';
//$route['404_override'] = 'home/error';
$route['translate_uri_dashes'] = FALSE;
$route["sitemap.xml"] = "home/sitemap";
$route["sitemapindex.xml"] = "home/sitemapindex";
$route["haberler"] = "home/news";
$route["haberler/(:num)"] = "home/news/$1";
$route["haberler/(:any)"] = "home/news/$1";
$route["haberler/(:any)/(:num)"] = "home/news/$1/$2";
$route["haberler/haber/(:any)"] = "home/news_detail/$1";

$route["urunler"] = "home/products";
$route["urunler/(:num)"] = "home/products/$1";
$route["urunler/(:any)"] = "home/products/$1";
$route["urunler/(:any)/(:num)"] = "home/products/$1/$2";
$route["urunler/urun/(:any)"] = "home/product_detail/$1";

$route["hizmetlerimiz"] = "home/services";
$route["hizmetlerimiz/(:num)"] = "home/services/$1";
$route["hizmetlerimiz/(:any)"] = "home/services/$1";
$route["hizmetlerimiz/(:any)/(:num)"] = "home/services/$1/$2";
$route["hizmetlerimiz/hizmet/(:any)"] = "home/service_detail/$1";

$route["sektorler"] = "home/sectors";
$route["sektorler/(:num)"] = "home/sectors/$1";
$route["sektorler/(:any)"] = "home/sectors/$1";
$route["sektorler/(:any)/(:num)"] = "home/sectors/$1/$2";

$route["galeriler"] = "home/galleries";
$route["galeriler/(:num)"] = "home/galleries/$1";
$route["galeriler/(:any)"] = "home/galleries/$1";
$route["galeriler/(:any)/(:num)"] = "home/galleries/$1/$2";
$route["galeriler/galeri/(:any)"] = "home/gallery_detail/$1";

$route["hizli-teklif-al"] = "home/offer";
$route['teklif-basvurusu'] = 'home/make_offer';
$route['iletisim-formu'] = 'home/contact_form';
$route['iletisim'] = 'home/contact';
$route['sayfa/(:any)'] = 'home/page/$1';
$route['dil-degistir'] = 'home/switchLanguage';
