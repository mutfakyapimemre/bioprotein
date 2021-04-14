<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Home extends CI_Controller
{
    /**
     * Variables
     */
    public $viewFolder = "";
    public $viewData = "";
    /**
     * Constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->viewFolder = "home_v";
        $this->viewData = new stdClass();
        /**
         * Sitemap
         */
        $this->viewData->page_urls = [];
        (!empty(get_cookie("lang")) ? get_cookie("lang") : "tr");
        $this->viewData->lang = (!empty(get_cookie("lang")) ? get_cookie("lang") : "tr");
        if (empty(get_cookie("lang", true)) || !isset($_COOKIE["lang"])) :
            set_cookie("lang", "tr", strtotime("+1 Year"));
        endif;
        $this->viewData->languageJSON = json_decode(file_get_contents(base_url("panel/assets/language/{$this->viewData->lang}.json")), true);
        $this->viewData->settings = $this->general_model->get("settings", null, ["isActive" => 1, "lang" => $this->viewData->lang]);
        $allLanguages = $this->general_model->get_all("settings", null, "rank ASC", ["isActive" => 1]);
        $languages = [];
        foreach ($allLanguages as $key => $value) :
            array_push($languages, $value->lang);
        endforeach;
        $locales = $this->general_model->get("languages", null, ["code" => strto("lower", $this->viewData->lang)]);
        setlocale(LC_ALL, $locales->code);
        $currency = $this->general_model->get("countries", null, ["code" => strto("lower|upper", $this->viewData->lang)]);
        $this->viewData->currency = $currency->currency_code;
        $this->viewData->formatter = new NumberFormatter($locales->code, NumberFormatter::CURRENCY);
        $this->viewData->menus = $this->show_tree('HEADER', $this->viewData->lang);
        $this->viewData->mobileMenus = $this->show_tree('MOBILE', $this->viewData->lang);
        $this->viewData->rightMenus = $this->show_tree('HEADER_RIGHT', $this->viewData->lang);
        $this->viewData->footer_menus = $this->show_tree('FOOTER', $this->viewData->lang);
        $this->viewData->languages = $languages;
        $this->viewData->stories = $this->general_model->get_all("stories", null, "rank ASC", ["isActive" => 1]);
        $this->viewData->story_items = $this->general_model->get_all("story_items", null, "rank ASC", ["isActive" => 1, "lang" => $this->viewData->lang]);
        /**
         * Testimonials
         */
        $this->viewData->testimonials = $this->general_model->get_all("testimonials", null, "id DESC", ["isActive" => 1], [], [], [6]);
        foreach ($this->viewData->testimonials as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->testimonials[$key]->$k = json_decode($v);
                else :
                    $this->viewData->testimonials[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;

        /**
         * Brands
         */
        $this->viewData->brands = $this->general_model->get_all("brands", null, "id DESC", ["isActive" => 1], [], [], []);
        foreach ($this->viewData->brands as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->brands[$key]->$k = json_decode($v);
                else :
                    $this->viewData->brands[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Footer Services
         */
        $this->viewData->footerServices = $this->general_model->get_all("services", null, "id DESC", ["isActive" => 1], [], [], [9]);
        foreach ($this->viewData->footerServices as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->footerServices[$key]->$k = json_decode($v);
                else :
                    $this->viewData->footerServices[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Footer News
         */
        $this->viewData->footerNews = $this->general_model->get_all("news", null, "id DESC", ["isActive" => 1], [], [], [9]);
        foreach ($this->viewData->footerNews as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->footerNews[$key]->$k = json_decode($v);
                else :
                    $this->viewData->footerNews[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
    }
    /**
     * Render
     */
    public function render()
    {
        $this->load->view("includes/head", (array)$this->viewData);
        $this->load->view("includes/header");
        $this->load->view($this->viewFolder);
        $this->load->view("includes/footer");
    }
    /**
     * Error 
     */
    public function error()
    {
        $this->viewFolder = "404_v/index";
        $this->render();
    }
    /**
     * Index
     */
    public function index()
    {
        /**
         * JSON DECODING
         * =============
         */

        /**
         * News
         */
        $this->viewData->news = $this->general_model->get_all("news", null, "id DESC", ['isActive' => 1], [], [], [6]);
        foreach ($this->viewData->news as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->news[$key]->$k = json_decode($v);
                else :
                    $this->viewData->news[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Slides
         */
        $this->viewData->slides = $this->general_model->get_all("slides", null, "rank ASC", ["isActive" => 1]);
        foreach ($this->viewData->slides as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->slides[$key]->$k = json_decode($v);
                else :
                    $this->viewData->slides[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Ads
         */
        $this->viewData->ads = $this->general_model->get_all("ads", null, "rank ASC", ["isActive" => 1]);
        foreach ($this->viewData->ads as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->ads[$key]->$k = json_decode($v);
                else :
                    $this->viewData->ads[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * News Categories
         */
        $this->viewData->news_categories = $this->general_model->get_all("news_categories", null, "rank ASC", ["isActive" => 1]);
        foreach ($this->viewData->news_categories as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->news_categories[$key]->$k = json_decode($v);
                else :
                    $this->viewData->news_categories[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Services
         */
        $this->viewData->services = $this->general_model->get_all("services", null, "rank ASC", ["isActive" => 1], [], [], [6]);
        foreach ($this->viewData->services as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->services[$key]->$k = json_decode($v);
                else :
                    $this->viewData->services[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get Suggested Products
         */
        $this->viewData->suggestedProducts = $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1, "isSuggested" => 1], [], [], [20]);
        shuffle($this->viewData->suggestedProducts);
        foreach ($this->viewData->suggestedProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->suggestedProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->suggestedProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get New Products
         */
        $this->viewData->newProducts = $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1, "isNew" => 1], [], [], [20]);
        shuffle($this->viewData->newProducts);
        foreach ($this->viewData->newProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->newProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->newProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get Discount Products
         */
        $this->viewData->discountProducts = $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1, "isDiscount" => 1], [], [], [20]);
        shuffle($this->viewData->discountProducts);
        foreach ($this->viewData->discountProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->discountProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->discountProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;

        /**
         * JSON DECODING END
         * =================
         */

        /**
         * Product Images
         */
        $this->viewData->product_images = $this->general_model->get_all("product_images", null, "rank ASC", ["isActive" => 1, "isCover" => 1, "lang" => $this->viewData->lang]);

        /**
         * About Gallery
         */
        $this->viewData->homeGallery = $this->general_model->get("galleries", null, ["id" => 1, "isActive" => 1]);
        $this->viewData->homeGalleryItems = $this->general_model->get_all("images", null, "rank ASC", ["gallery_id" => 1, "isActive" => 1, "lang" => $this->viewData->lang]);

        $this->viewData->meta_title = $this->viewData->settings->company_name;
        $this->viewData->meta_desc  = str_replace("”", "\"", stripslashes($this->viewData->settings->meta_description));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);

        $this->viewData->og_url                 = clean(base_url());
        $this->viewData->og_image           = clean(get_picture("settings_v", $this->viewData->settings->logo));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = clean($this->viewData->settings->company_name);
        $this->viewData->og_description           = clean($this->viewData->settings->meta_description);
        $this->viewFolder = "home_v/index";
        $this->render();
    }
    /**
     * Show Tree
     */
    public function show_tree($position = 'HEADER', $lang = 'tr')
    {
        // create array to store all menus ids
        $store_all_id = array();
        // get all parent menus ids by using isactive
        $id_result = $this->general_model->get_all("menus", null, "rank ASC", ["position" => $position, "isActive" => 1]);
        // loop through all menus to save parent ids $store_all_id array
        foreach ($id_result as $menu_id) {
            array_push($store_all_id, $menu_id->top_id);
        }
        // return all hierarchical tree data from in_parent by sending
        //  initiate parameters 0 is the main parent,news id, all parent ids
        return  $this->in_parent(0, $position, $lang, $store_all_id);
    }
    /**
     * recursive function to loop
     * through all comments and retrieve it
     */
    public function in_parent($in_parent, $position, $lang, $store_all_id)
    {
        // this variable to save all concatenated html
        $html = "";
        // build hierarchy  html structure based on ul li (parent-child) nodes
        if (in_array($in_parent, $store_all_id)) :
            $result = $this->general_model->get_all("menus", null, "rank ASC", ["position" => $position, "top_id" => $in_parent, "isActive" => 1]);
            $html .=  '<ul class="' . ($position == "HEADER" ? ($in_parent == 0 ? "nav-menu" : "sub-menu") : ($position == "HEADER_RIGHT" ? "useful-link" : ($position == "MOBILE" ? ($in_parent == 0 ? "mobile-menu" : "dropdown") : "sitemap-widget"))) . '">';
            foreach ($result as $key => $value) :
                $page = $this->general_model->get("pages", null, ["isActive" => 1, "id" => $value->page_id]);
                if ($value->page_id != 0) :
                    if (!empty($page)) :
                        $page->url = (!empty($page->url) ? json_decode($page->url, true)[$lang] : null);
                    endif;
                endif;
                $value->title = (!empty($value->title) ? json_decode($value->title, true)[$lang] : null);
                if (!empty($value->url)) :
                    $value->url = (!empty($value->url) ? json_decode($value->url, true)[$lang] : null);
                endif;
                $html .= '<li ' . (($position == "MOBILE" || $position == "HEADER") && in_array($value->id, $store_all_id) ? ((!empty($page->url) && ($this->uri->segment(1) == strto("lower", seo(@$page->url)) || $this->uri->segment(2) == strto("lower", seo(@$page->url)))) || $this->uri->segment(1) == strto("lower", seo($value->title)) || $this->uri->segment(2) == strto("lower", seo($value->title)) || ($this->uri->segment(1) === null && $value->url === '/') ? "class='current-menu-item current_page_item menu-item-has-children'" : "class='menu-item-has-children'") : ((!empty($page->url) && ($this->uri->segment(1) == strto("lower", seo(@$page->url)) || $this->uri->segment(2) == strto("lower", seo(@$page->url)))) || ($this->uri->segment(1) === null && $value->url === '/') || $this->uri->segment(1) == strto("lower", seo($value->title)) || $this->uri->segment(2) == strto("lower", seo($value->title)) ? "class='current-menu-item current_page_item'" : null)) . '>';
                if (empty($value->url)) :
                    if (!empty($page->url)) :
                        $html .= '<a rel="dofollow" href="' . base_url($this->viewData->languageJSON["routes"]["sayfa"] . "/" . (!empty($page->url) ? $page->url : null)) . '" target="' . $value->target . '" title="' . $value->title . '">' . $value->title . '</a>';
                        array_push($this->viewData->page_urls, base_url($this->viewData->languageJSON["routes"]["sayfa"] . "/" . (!empty($page->url) ? $page->url : null)));
                    else :
                        $html .= '<a rel="dofollow" href="' . base_url(seo(strto("lower", $value->title))) . '" target="' . $value->target . '" title="' . $value->title . '">' . $value->title . '</a>';
                        array_push($this->viewData->page_urls, base_url(seo(strto("lower", $value->title))));
                    endif;
                else :
                    $url = parse_url($value->url, PHP_URL_SCHEME);
                    if ($url == "http" || $url == "https") :
                        $html .= '<a rel="dofollow" href="' . $value->url . '" target="' . $value->target . '" title="' . $value->title . '">' . $value->title . '</a>';
                        array_push($this->viewData->page_urls, $value->url);
                    else :
                        $html .= '<a rel="dofollow" href="' . base_url($value->url) . '" target="' . $value->target . '" title="' . $value->title . '">' . $value->title . '</a>';
                        array_push($this->viewData->page_urls, base_url($value->url));
                    endif;
                endif;
                $html .= $this->in_parent($value->id, $position, $lang, $store_all_id);
                $html .= "</li>";
            endforeach;
            $html .=  "</ul>";
        endif;

        return $html;
    }
    /**
     * Services
     */
    public function services()
    {
        $seo_url = $this->uri->segment(2);
        $search = null;
        if (!empty(clean($this->input->get("search")))) :
            $search = clean($this->input->get("search"));
        endif;
        $config = [];
        $config['base_url'] = (!empty($seo_url) && !is_numeric($seo_url) ? base_url($this->uri->segment(1) . "/{$seo_url}") : base_url($this->uri->segment(1)));
        $config['uri_segment'] = (!empty($seo_url) && !is_numeric($seo_url) ? 3 : 2);
        $config['use_page_numbers'] = TRUE;
        $config["full_tag_open"] = "<ul class='pagination justify-content-center'>";
        $config["first_link"] = "<i class='fa fa-angle-double-left'></i>";
        $config["first_tag_open"] = "<li>";
        $config["first_tag_close"] = "</li>";
        $config["prev_link"] = "<i class='fa fa-angle-left'></i>";
        $config["prev_tag_open"] = "<li class='prev'>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a rel='dofollow' href='javascript:void(0)'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["next_link"] = "<i class='fa fa-angle-right'></i>";
        $config["next_tag_open"] = "<li class='next'>";
        $config["next_tag_close"] = "</li>";
        $config["last_link"] = "<i class='fa fa-angle-double-right'></i>";
        $config["last_tag_open"] = "<li>";
        $config["last_tag_close"] = "</li>";
        $config["full_tag_close"] = "</ul>";
        $config['attributes'] = array('class' => '');
        $config['total_rows'] = (!empty($search) ? $this->general_model->rowCount("services", ["isActive" => 1], ["title" => $search, "content" => $search, "createdAt" => $search, "updatedAt" => $search]) : $this->general_model->rowCount("services", ["isActive" => 1]));
        $config['per_page'] = 8;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);
        $page = $config['uri_segment'] * $config['per_page'];
        $config['reuse_query_string'] = true;
        //$config['page_query_string'] = true;
        $this->pagination->initialize($config);
        if (!empty($seo_url) && !is_numeric($seo_url) && !empty($this->uri->segment(3))) :
            $uri_segment = $this->uri->segment(3);
        elseif (!empty($seo_url) && is_numeric($seo_url)) :
            $uri_segment = $this->uri->segment(2);
        else :
            $uri_segment = 1;
        endif;

        $offset = ($uri_segment - 1) * $config['per_page'];
        $this->viewData->services = (!empty($seo_url) && !is_numeric($seo_url) ? (!empty($search) ? $this->general_model->get_all("services", null, null, ["isActive" => 1], ["title" => $search, "content" => $search, "createdAt" => $search, "updatedAt" => $search], [], [$config["per_page"], $offset]) : $this->general_model->get_all("services", null, null, ["isActive" => 1], [], [], [$config["per_page"], $offset])) : (!empty($search) ? $this->general_model->get_all("services", null, null, ["isActive" => 1], ["title" => $search, "content" => $search, "createdAt" => $search, "updatedAt" => $search], [], [$config["per_page"], $offset]) : $this->general_model->get_all("services", null, null, ["isActive" => 1], [], [], [$config["per_page"], $offset])));
        foreach ($this->viewData->services as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->services[$key]->$k = json_decode($v);
                else :
                    $this->viewData->services[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        $this->viewData->latestServices = $this->general_model->get_all("services", null, "id DESC", ["isActive" => 1], [], [], [5]);
        foreach ($this->viewData->latestServices as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->latestServices[$key]->$k = json_decode($v);
                else :
                    $this->viewData->latestServices[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        $this->viewData->links = $this->pagination->create_links();

        $this->viewData->meta_title = $this->viewData->settings->company_name;
        $this->viewData->meta_desc  = str_replace("”", "\"", stripslashes($this->viewData->settings->meta_description));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);

        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["hizmetlerimiz"]));
        $this->viewData->og_image           = clean(get_picture("settings_v", $this->viewData->settings->logo));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = clean($this->viewData->settings->company_name);
        $this->viewData->og_description           = clean($this->viewData->settings->meta_description);
        if (empty($this->viewData->services)) :
            $this->viewFolder = "404_v/index";
        else :
            $this->viewFolder = "services_v/index";
        endif;
        $this->render();
    }
    /**
     * Service Detail
     */
    public function service_detail()
    {
        $seo_url = $this->uri->segment(3);
        $this->viewData->service = $this->general_model->get("services", null, ["isActive" => 1], [], ['url' => '"' . $seo_url . '"']);
        if (!empty($this->viewData->service)) :
            foreach ($this->viewData->service as $key => $data) :
                if (isJson($data)) :
                    $this->viewData->service->$key = json_decode($data);
                else :
                    $this->viewData->service->$key = $data;
                endif;
            endforeach;
        endif;
        $this->viewData->latestServices = $this->general_model->get_all("services", null, "id DESC", ["isActive" => 1], [], [], [5]);
        foreach ($this->viewData->latestServices as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->latestServices[$key]->$k = json_decode($v);
                else :
                    $this->viewData->latestServices[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        $lang = $this->viewData->lang;
        $this->viewData->meta_title = @$this->viewData->service->title->$lang;
        $this->viewData->meta_desc  = clean(str_replace("”", "\"", stripslashes(@$this->viewData->service->content->$lang)));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);
        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["hizmet"] . "/" . $seo_url));
        $this->viewData->og_image           = clean(get_picture("services_v", @$this->viewData->service->img_url->$lang));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = @$this->viewData->service->title->$lang;
        $this->viewData->og_description           = clean(str_replace("”", "\"", stripslashes(@$this->viewData->service->content->$lang)));
        if (empty($this->viewData->service)) :
            $this->viewFolder = "404_v/index";
        else :
            $this->viewFolder = "service_detail_v/index";
        endif;
        $this->render();
    }
    /**
     * Sectors
     */
    public function sectors()
    {
        $this->viewData->sectors = $this->general_model->get_all("sectors", null, null, ["isActive" => 1], [], [], []);

        foreach ($this->viewData->sectors as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->sectors[$key]->$k = json_decode($v);
                else :
                    $this->viewData->sectors[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;

        $lang = $this->viewData->lang;
        $this->viewData->links = $this->pagination->create_links();

        $this->viewData->meta_title = $this->viewData->settings->company_name;
        $this->viewData->meta_desc  = str_replace("”", "\"", stripslashes($this->viewData->settings->meta_description));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);

        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["sektorler"]));
        $this->viewData->og_image           = clean(get_picture("settings_v", $this->viewData->settings->logo));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = clean($this->viewData->settings->company_name);
        $this->viewData->og_description           = clean($this->viewData->settings->meta_description);

        if (empty($this->viewData->sectors)) :
            $this->viewFolder = "404_v/index";
        else :
            $this->viewFolder = "sectors_v/index";
        endif;
        $this->render();
    }
    /**
     * Pages
     */
    public function page()
    {
        $seo_url = $this->uri->segment(2);
        $this->viewData->item = $this->general_model->get("pages", null, ["isActive" => 1], [], ['url' => '"' . $seo_url . '"']);
        $lang = $this->viewData->lang;
        $this->viewData->meta_title = @json_decode(@$this->viewData->item->title)->$lang;
        $this->viewData->meta_desc  = clean(str_replace("”", "\"", stripslashes(@json_decode(@$this->viewData->item->content)->$lang)));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);
        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["sayfa"] . "/" . $seo_url));
        $this->viewData->og_image           = clean(get_picture("pages_v", @json_decode(@$this->viewData->item->img_url)->$lang));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = @json_decode(@$this->viewData->item->title)->$lang;
        $this->viewData->og_description           = clean(str_replace("”", "\"", stripslashes(@json_decode(@$this->viewData->item->content)->$lang)));
        if (empty($this->viewData->item)) :
            $this->viewFolder = "404_v/index";
        else :
            $this->viewFolder = "page_v/index";
        endif;
        $this->render();
    }
    /**
     * News
     */
    public function news()
    {
        $seo_url = $this->uri->segment(2);
        $search = null;
        if (!empty(clean($this->input->get("search")))) :
            $search = clean($this->input->get("search"));
        endif;
        $category_id = null;
        $category = null;
        if (!empty($seo_url) && !is_numeric($seo_url)) :
            $category = $this->general_model->get("news_categories", null, ["isActive" => 1], [], ["seo_url" => '"' . $seo_url . '"']);
            if (!empty($category)) :
                $category_id = $category->id;
                $category->seo_url = (!empty($category->seo_url) ? json_decode($category->seo_url, true)[$this->viewData->lang] : null);
                $category->title = (!empty($category->title) ? json_decode($category->title, true)[$this->viewData->lang] : null);
            endif;
        endif;
        $config = [];
        $config['base_url'] = (!empty($seo_url) && !is_numeric($seo_url) ? base_url($this->uri->segment(1) . "/{$seo_url}") : base_url($this->uri->segment(1)));
        $config['uri_segment'] = (!empty($seo_url) && !is_numeric($seo_url) ? 3 : 2);
        $config['use_page_numbers'] = TRUE;
        $config["full_tag_open"] = "<ul class='pagination justify-content-center'>";
        $config["first_link"] = "<i class='fa fa-angle-double-left'></i>";
        $config["first_tag_open"] = "<li>";
        $config["first_tag_close"] = "</li>";
        $config["prev_link"] = "<i class='fa fa-angle-left'></i>";
        $config["prev_tag_open"] = "<li class='prev'>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a rel='dofollow' href='javascript:void(0)'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["next_link"] = "<i class='fa fa-angle-right'></i>";
        $config["next_tag_open"] = "<li class='next'>";
        $config["next_tag_close"] = "</li>";
        $config["last_link"] = "<i class='fa fa-angle-double-right'></i>";
        $config["last_tag_open"] = "<li>";
        $config["last_tag_close"] = "</li>";
        $config["full_tag_close"] = "</ul>";
        $config['attributes'] = array('class' => '');
        $config['total_rows'] = (!empty($seo_url) && !is_numeric($seo_url) ? (!empty($search) ? $this->general_model->rowCount("news", ["isActive" => 1, "category_id" => $category_id], ["title" =>  $search, "content" =>  $search, "createdAt" => $search, "updatedAt" =>  $search]) : $this->general_model->rowCount("news", ["isActive" => 1, "category_id" => $category_id])) : (!empty($search) ? $this->general_model->rowCount("news", ["isActive" => 1], ["title" =>  $search, "content" => $search, "createdAt" =>  $search, "updatedAt" =>  $search]) : $this->general_model->rowCount("news", ["isActive" => 1,])));
        $config['per_page'] = 8;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);
        $page = $config['uri_segment'] * $config['per_page'];
        $config['reuse_query_string'] = true;
        //$config['page_query_string'] = true;
        $this->pagination->initialize($config);
        if (!empty($seo_url) && !is_numeric($seo_url) && !empty($this->uri->segment(3))) :
            $uri_segment = $this->uri->segment(3);
        elseif (!empty($seo_url) && is_numeric($seo_url)) :
            $uri_segment = $this->uri->segment(2);
        else :
            $uri_segment = 1;
        endif;
        $this->viewData->news_category = $category;
        $offset = ($uri_segment - 1) * $config['per_page'];
        $this->viewData->news = (!empty($seo_url) && !is_numeric($seo_url) ? (!empty($search) ? $this->general_model->get_all("news", null, null, ['category_id' => $category_id, "isActive" => 1], ["title" =>  $search, "content" =>  $search, "createdAt" => $search, "updatedAt" =>  $search], [], [$config["per_page"], $offset]) : $this->general_model->get_all("news", null, null, ['category_id' => $category_id, "isActive" => 1], [], [], [$config["per_page"], $offset])) : (!empty($search) ? $this->general_model->get_all("news", null, null, ["isActive" => 1], ["title" =>  $search, "content" =>  $search, "createdAt" =>  $search, "updatedAt" =>  $search], [], [$config["per_page"], $offset]) : $this->general_model->get_all("news", null, null, ["isActive" => 1], [], [], [$config["per_page"], $offset])));

        foreach ($this->viewData->news as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->news[$key]->$k = json_decode($v);
                else :
                    $this->viewData->news[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        $this->viewData->categories = $this->general_model->get_all("news_categories", null, "id DESC", ["isActive" => 1]);
        foreach ($this->viewData->categories as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->categories[$key]->$k = json_decode($v);
                else :
                    $this->viewData->categories[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        $this->viewData->latestNews = (!empty($seo_url) && !is_numeric($seo_url) ? $this->general_model->get_all("news", null, "id DESC", ['category_id' => $category_id, "isActive" => 1], [], [], [5]) : $this->general_model->get_all("news", null, "id DESC", ["isActive" => 1], [], [], [5]));
        foreach ($this->viewData->latestNews as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->latestNews[$key]->$k = json_decode($v);
                else :
                    $this->viewData->latestNews[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        $this->viewData->meta_title = $this->viewData->settings->company_name;
        $this->viewData->meta_desc  = str_replace("”", "\"", stripslashes($this->viewData->settings->meta_description));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);

        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["haberler"]));
        $this->viewData->og_image           = clean(get_picture("settings_v", $this->viewData->settings->logo));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = clean($this->viewData->settings->company_name);
        $this->viewData->og_description           = clean($this->viewData->settings->meta_description);
        $this->viewData->links = $this->pagination->create_links();
        if (empty($this->viewData->news)) :
            $this->viewFolder = "404_v/index";
        else :
            $this->viewFolder = "news_v/index";
        endif;
        $this->render();
    }
    /**
     * News Detail
     */
    public function news_detail($seo_url)
    {
        $this->viewData->news = $this->general_model->get("news", null, ["isActive" => 1], [], ['seo_url' => '"' . $seo_url . '"']);
        if (!empty($this->viewData->news)) :
            foreach ($this->viewData->news as $key => $data) :
                if (isJson($data)) :
                    $this->viewData->news->$key = json_decode($data);
                else :
                    $this->viewData->news->$key = $data;
                endif;
            endforeach;
        endif;
        if (!empty($this->viewData->news->category_id)) :
            $this->viewData->category = $this->general_model->get("news_categories", null, ["id" => @$this->viewData->news->category_id, "isActive" => 1]);
        endif;
        $lang = $this->viewData->lang;
        $this->viewData->categories = $this->general_model->get_all("news_categories", null, "id DESC", ["isActive" => 1]);
        foreach ($this->viewData->categories as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->categories[$key]->$k = json_decode($v);
                else :
                    $this->viewData->categories[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        $this->viewData->latestNews = (!empty($this->viewData->news->category_id) ? $this->general_model->get_all("news", null, "id DESC", ['category_id' => @$this->viewData->news->category_id, "isActive" => 1], [], [], [5]) : $this->general_model->get_all("news", null, "id DESC", ["isActive" => 1], [], [], [5]));
        foreach ($this->viewData->latestNews as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->latestNews[$key]->$k = json_decode($v);
                else :
                    $this->viewData->latestNews[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        $this->viewData->randomNews = (!empty($this->viewData->news->category_id) ? $this->general_model->get_all("news", null, "id DESC", ['category_id' => @$this->viewData->news->category_id, "isActive" => 1], [], [], [3]) : $this->general_model->get_all("news", null, "id DESC", ["isActive" => 1], [], [], [3]));
        shuffle($this->viewData->randomNews);
        foreach ($this->viewData->randomNews as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->randomNews[$key]->$k = json_decode($v);
                else :
                    $this->viewData->randomNews[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        $this->viewData->meta_title = @$this->viewData->news->title->$lang;
        $this->viewData->meta_desc  = clean(str_replace("”", "\"", stripslashes(@$this->viewData->news->content->$lang)));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);
        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["sayfa"] . "/" . $seo_url));
        $this->viewData->og_image           = clean(get_picture("news_v", @$this->viewData->news->img_url->$lang));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = @$this->viewData->news->title->$lang;
        $this->viewData->og_description           = clean(str_replace("”", "\"", stripslashes(@$this->viewData->news->content->$lang)));
        if (empty($this->viewData->news)) :
            $this->viewFolder = "404_v/index";
        else :
            $this->viewFolder = "news_detail_v/index";
        endif;
        $this->render();
    }
    /**
     * Products
     */
    public function products()
    {
        $search = null;
        if (!empty(clean($this->input->get("search")))) :
            $search = clean($this->input->get("search"));
        endif;
        $seo_url = $this->uri->segment(2);
        $category_id = null;
        $category = null;
        if (!empty($seo_url) && !is_numeric($seo_url)) :
            $category = $this->general_model->get("product_categories", null, ["isActive" => 1], [], ["seo_url" => '"' . $seo_url . '"']);
            if (!empty($category)) :
                $category_id = $category->id;
                $category->seo_url = (!empty($category->seo_url) ? json_decode($category->seo_url, true)[$this->viewData->lang] : null);
                $category->title = (!empty($category->title) ? json_decode($category->title, true)[$this->viewData->lang] : null);
            endif;
        endif;
        $config = [];
        $config['base_url'] = (!empty($seo_url) && !is_numeric($seo_url) ? base_url($this->uri->segment(1) . "/{$seo_url}") : base_url($this->uri->segment(1)));
        $config['uri_segment'] = (!empty($seo_url) && !is_numeric($seo_url) ? 3 : 2);
        $config['use_page_numbers'] = TRUE;
        $config["full_tag_open"] = "<ul class='pagination justify-content-center'>";
        $config["first_link"] = "<i class='fa fa-angle-double-left'></i>";
        $config["first_tag_open"] = "<li>";
        $config["first_tag_close"] = "</li>";
        $config["prev_link"] = "<i class='fa fa-angle-left'></i>";
        $config["prev_tag_open"] = "<li class='prev'>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a rel='dofollow' href='javascript:void(0)'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["next_link"] = "<i class='fa fa-angle-right'></i>";
        $config["next_tag_open"] = "<li class='next'>";
        $config["next_tag_close"] = "</li>";
        $config["last_link"] = "<i class='fa fa-angle-double-right'></i>";
        $config["last_tag_open"] = "<li>";
        $config["last_tag_close"] = "</li>";
        $config["full_tag_close"] = "</ul>";
        $config['attributes'] = array('class' => '');
        $config['total_rows'] = (!empty($seo_url) && !is_numeric($seo_url) ? (!empty($search) ? $this->general_model->rowCount("products", ["isActive" => 1], ["category_id" => $category_id, "title" =>  $search, "content" =>  $search, "createdAt" => $search, "updatedAt" =>  $search]) : $this->general_model->rowCount("products", ["isActive" => 1], ["category_id" => $category_id])) : (!empty($search) ? $this->general_model->rowCount("products", ["isActive" => 1,], ["title" =>  $search, "content" =>  $search, "createdAt" => $search, "updatedAt" =>  $search]) : $this->general_model->rowCount("products", ["isActive" => 1,], [])));
        $config['per_page'] = 12;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);
        $page = $config['uri_segment'] * $config['per_page'];
        $this->pagination->initialize($config);
        if (!empty($seo_url) && !is_numeric($seo_url) && !empty($this->uri->segment(3))) :
            $uri_segment = $this->uri->segment(3);
        elseif (!empty($seo_url) && is_numeric($seo_url)) :
            $uri_segment = $this->uri->segment(2);
        else :
            $uri_segment = 1;
        endif;
        $this->viewData->products_category = $category;
        $offset = ($uri_segment - 1) * $config['per_page'];
        /**
         * Get All Categories
         */
        $this->viewData->categories = $this->general_model->get_all("product_categories", null, "rank ASC", ["isActive" => 1], [], [], []);
        foreach ($this->viewData->categories as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->categories[$key]->$k = json_decode($v);
                else :
                    $this->viewData->categories[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get Product Images
         */
        $this->viewData->product_images = $this->general_model->get_all("product_images", null, "rank ASC", ["isActive" => 1]);
        /**
         * Get Products
         */
        $this->viewData->products = (!empty($seo_url) && !is_numeric($seo_url) ? (!empty($search) ? $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1], ["category_id" => $category_id, "title" =>  $search, "content" =>  $search, "createdAt" => $search, "updatedAt" =>  $search], [], [$config["per_page"], $offset]) : $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1], ["category_id" => $category_id], [], [$config["per_page"], $offset])) : (!empty($search) ? $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1], ["title" =>  $search, "content" =>  $search, "createdAt" => $search, "updatedAt" =>  $search], [], [$config["per_page"], $offset]) : $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1], [], [], [$config["per_page"], $offset])));
        foreach ($this->viewData->products as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->products[$key]->$k = json_decode($v);
                else :
                    $this->viewData->products[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get Latest Products
         */
        $this->viewData->latestProducts = (!empty($category_id) ? $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1], ["category_id" => $category_id,], [], [5], []) : $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1], [], [], [5]));
        foreach ($this->viewData->latestProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->latestProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->latestProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get Random Products
         */
        $this->viewData->randomProducts = (!empty($category_id) ? $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1], ["category_id" => $category_id,], [], [], []) : $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1], [], [], [3]));
        shuffle($this->viewData->randomProducts);
        foreach ($this->viewData->randomProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->randomProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->randomProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get Suggested Products
         */
        $this->viewData->suggestedProducts = $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1, "isSuggested" => 1], [], [], [20]);
        shuffle($this->viewData->suggestedProducts);
        foreach ($this->viewData->suggestedProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->suggestedProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->suggestedProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get New Products
         */
        $this->viewData->newProducts = $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1, "isNew" => 1], [], [], [20]);
        shuffle($this->viewData->newProducts);
        foreach ($this->viewData->newProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->newProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->newProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get Discount Products
         */
        $this->viewData->discountProducts = $this->general_model->get_all("products", null, "id DESC", ["isActive" => 1, "isDiscount" => 1], [], [], [20]);
        shuffle($this->viewData->discountProducts);
        foreach ($this->viewData->discountProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->discountProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->discountProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Meta
         */
        $this->viewData->meta_title = $this->viewData->settings->company_name;
        $this->viewData->meta_desc  = str_replace("”", "\"", stripslashes($this->viewData->settings->meta_description));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);

        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["haberler"]));
        $this->viewData->og_image           = clean(get_picture("settings_v", $this->viewData->settings->logo));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = clean($this->viewData->settings->company_name);
        $this->viewData->og_description           = clean($this->viewData->settings->meta_description);
        $this->viewData->links = $this->pagination->create_links();
        if (empty($this->viewData->products)) :
            $this->viewFolder = "404_v/index";
        else :
            $this->viewFolder = "products_v/index";
        endif;
        $this->render();
    }
    /**
     * Product Detail
     */
    public function product_detail($seo_url)
    {
        /**
         * Get Product Detail
         */
        $this->viewData->product = $this->general_model->get("products", null, ["isActive" => 1], [], ['url' => '"' . $seo_url . '"']);
        if (!empty($this->viewData->product)) :
            foreach ($this->viewData->product as $key => $data) :
                if (isJson($data)) :
                    $this->viewData->product->$key = json_decode($data);
                else :
                    $this->viewData->product->$key = $data;
                endif;
            endforeach;
        endif;
        /**
         * Get Product Categories
         */
        if (!empty($this->viewData->product->category_id)) :
            $this->viewData->product_categories = $this->general_model->get_all("product_categories", null, "rank ASC", ["isActive" => 1], [], [], [], ["id" => explode(",", @$this->viewData->product->category_id)]);
            foreach ($this->viewData->product_categories as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $this->viewData->product_categories[$key]->$k = json_decode($v);
                    else :
                        $this->viewData->product_categories[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
        endif;
        /**
         * Get All Categories
         */
        $this->viewData->categories = $this->general_model->get_all("product_categories", null, "rank ASC", ["isActive" => 1], [], [], []);
        foreach ($this->viewData->categories as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->categories[$key]->$k = json_decode($v);
                else :
                    $this->viewData->categories[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get Product Images
         */
        $this->viewData->product_images = $this->general_model->get_all("product_images", null, "rank ASC", ["isActive" => 1, "product_id" => @$this->viewData->product->id]);
        $imgURL = null;
        if (!empty($this->viewData->product_images)) :
            foreach ($this->viewData->product_images as $key => $value) :
                if ($value->isCover) :
                    $imgURL = $value->url;
                endif;
            endforeach;
        endif;
        /**
         * Get All Cover Product Images
         */
        $this->viewData->product_all_images = $this->general_model->get_all("product_images", null, "rank ASC", ["isActive" => 1, "isCover" => 1]);
        /**
         * Split Category 
         */
        $implodedCategories = [];
        $splittedCategories = explode(",", @$this->viewData->product->category_id);
        if (!empty($splittedCategories)) :
            foreach ($splittedCategories as $key => $value) :
                array_push($implodedCategories, ["category_id" => $value]);
            endforeach;
        endif;
        /**
         * Get Latest Products
         */
        $this->viewData->latestProducts = (!empty($this->viewData->product->category_id) ? $this->general_model->get_all("products", null, "id DESC", ["id!=" => @$this->viewData->product->id, "isActive" => 1], ['category_id' => $implodedCategories], [], [5], []) : $this->general_model->get_all("products", null, "id DESC", ["id!=" => @$this->viewData->product->id, "isActive" => 1], [], [], [5]));
        foreach ($this->viewData->latestProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->latestProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->latestProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get Suggested Products
         */
        $this->viewData->suggestedProducts = (!empty($this->viewData->product->category_id) ? $this->general_model->get_all("products", null, "id DESC", ["id!=" => @$this->viewData->product->id, "isActive" => 1, "isSuggested" => 1], ['category_id' =>  $implodedCategories], [], [20], []) : $this->general_model->get_all("products", null, "id DESC", ["id!=" => @$this->viewData->product->id, "isActive" => 1, "isSuggested" => 1], [], [], [20]));
        shuffle($this->viewData->suggestedProducts);
        foreach ($this->viewData->suggestedProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->suggestedProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->suggestedProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get New Products
         */
        $this->viewData->newProducts = (!empty($this->viewData->product->category_id) ? $this->general_model->get_all("products", null, "id DESC", ["id!=" => @$this->viewData->product->id, "isActive" => 1, "isNew" => 1], ['category_id' =>  $implodedCategories], [], [20], []) : $this->general_model->get_all("products", null, "id DESC", ["id!=" => @$this->viewData->product->id, "isActive" => 1, "isNew" => 1], [], [], [20]));
        shuffle($this->viewData->newProducts);
        foreach ($this->viewData->newProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->newProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->newProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Get Discount Products
         */
        $this->viewData->discountProducts = (!empty($this->viewData->product->category_id) ? $this->general_model->get_all("products", null, "id DESC", ["id!=" => @$this->viewData->product->id, "isActive" => 1, "isDiscount" => 1], ['category_id' =>  $implodedCategories], [], [20], []) : $this->general_model->get_all("products", null, "id DESC", ["id!=" => @$this->viewData->product->id, "isActive" => 1, "isDiscount" => 1], [], [], [20]));
        shuffle($this->viewData->discountProducts);
        foreach ($this->viewData->discountProducts as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->discountProducts[$key]->$k = json_decode($v);
                else :
                    $this->viewData->discountProducts[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        /**
         * Meta
         */
        $lang = $this->viewData->lang;
        $this->viewData->meta_title = @$this->viewData->product->title->$lang;
        $this->viewData->meta_desc  = clean(str_replace("”", "\"", stripslashes(@$this->viewData->product->content->$lang)));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);
        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["sayfa"] . "/" . $seo_url));
        $this->viewData->og_image           = clean(get_picture("products_v", $imgURL));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = @$this->viewData->product->title->$lang;
        $this->viewData->og_description           = clean(str_replace("”", "\"", stripslashes(@$this->viewData->product->content->$lang)));
        if (empty($this->viewData->product)) :
            $this->viewFolder = "404_v/index";
        else :
            $this->viewFolder = "product_detail_v/index";
        endif;
        $this->render();
    }
    /**
     * Galleries
     */
    public function galleries()
    {
        $seo_url = $this->uri->segment(2);
        if (!empty($seo_url) && !is_numeric($seo_url)) :
            $gallery_id = @$this->general_model->get("galleries", null, ["isActive" => 1, "isCover" => 0], [], ["url" => '"' . $seo_url . '"'])->id;
        endif;
        $config = [];
        $config['base_url'] = (!empty($seo_url) && !is_numeric($seo_url) ? base_url("galeriler/{$seo_url}") : base_url("galeriler"));
        $config['uri_segment'] = (!empty($seo_url) && !is_numeric($seo_url) ? 3 : 2);
        $config['use_page_numbers'] = TRUE;
        $config["full_tag_open"] = "<ul class='pagination justify-content-center'>";
        $config["first_link"] = "<i class='fa fa-angle-double-left'></i>";
        $config["first_tag_open"] = "<li>";
        $config["first_tag_close"] = "</li>";
        $config["prev_link"] = "<i class='fa fa-angle-left'></i>";
        $config["prev_tag_open"] = "<li class='prev'>";
        $config["prev_tag_close"] = "</li>";
        $config["cur_tag_open"] = "<li class='active'><a rel='dofollow' href='javascript:void(0)'>";
        $config["cur_tag_close"] = "</a></li>";
        $config["num_tag_open"] = "<li>";
        $config["num_tag_close"] = "</li>";
        $config["next_link"] = "<i class='fa fa-angle-right'></i>";
        $config["next_tag_open"] = "<li class='next'>";
        $config["next_tag_close"] = "</li>";
        $config["last_link"] = "<i class='fa fa-angle-double-right'></i>";
        $config["last_tag_open"] = "<li>";
        $config["last_tag_close"] = "</li>";
        $config["full_tag_close"] = "</ul>";
        $config['attributes'] = array('class' => '');
        $config['total_rows'] = (!empty($seo_url) && !is_numeric($seo_url) && !empty($gallery_id) ? $this->general_model->rowCount("galleries", ["isActive" => 1, "isCover" => 0, "gallery_id" => @$gallery_id]) : $this->general_model->rowCount("galleries", ["isActive" => 1,]));
        $config['per_page'] = 8;
        $choice = $config["total_rows"] / $config["per_page"];
        $config["num_links"] = round($choice);
        $page = $config['uri_segment'] * $config['per_page'];
        $this->pagination->initialize($config);
        if (!empty($seo_url) && !is_numeric($seo_url) && !empty($this->uri->segment(3))) :
            $uri_segment = $this->uri->segment(3);
        elseif (!empty($seo_url) && is_numeric($seo_url)) :
            $uri_segment = $this->uri->segment(2);
        else :
            $uri_segment = 1;
        endif;

        $offset = ($uri_segment - 1) * $config['per_page'];
        $this->viewData->galleries = (!empty($seo_url) && !is_numeric($seo_url) && !empty($gallery_id) ? $this->general_model->get_all("galleries", null, null, ['gallery_id' => @$gallery_id, "isCover" => 0, "isActive" => 1], [], [], [$config["per_page"], $offset]) : $this->general_model->get_all("galleries", null, null, ["isActive" => 1, "isCover" => 0], [], [], [$config["per_page"], $offset]));
        foreach ($this->viewData->galleries as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->galleries[$key]->$k = json_decode($v);
                else :
                    $this->viewData->galleries[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        $this->viewData->links = $this->pagination->create_links();
        $this->viewData->meta_title = $this->viewData->settings->company_name;
        $this->viewData->meta_desc  = str_replace("”", "\"", stripslashes($this->viewData->settings->meta_description));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);

        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["galeriler"]));
        $this->viewData->og_image           = clean(get_picture("settings_v", $this->viewData->settings->logo));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = clean($this->viewData->settings->company_name);
        $this->viewData->og_description           = clean($this->viewData->settings->meta_description);
        if (empty($this->viewData->galleries)) :
            $this->viewFolder = "404_v/index";
        else :
            $this->viewFolder = "galleries_v/index";
        endif;
        $this->render();
    }
    /**
     * Gallery Detail
     */
    public function gallery_detail($seo_url)
    {
        $this->viewData->gallery = $this->general_model->get("galleries", null, ["isActive" => 1], [], ['url' => '"' . $seo_url . '"']);
        if (!empty($this->viewData->gallery)) :
            foreach ($this->viewData->gallery as $key => $data) :
                if (isJson($data)) :
                    $this->viewData->gallery->$key = json_decode($data);
                else :
                    $this->viewData->gallery->$key = $data;
                endif;
            endforeach;
        endif;
        $gallery_type = !empty($this->viewData->gallery->gallery_type) ? $this->viewData->gallery->gallery_type : null;
        $this->viewData->meta_title = $this->viewData->settings->company_name;
        $this->viewData->meta_desc  = str_replace("”", "\"", stripslashes($this->viewData->settings->meta_description));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);

        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["galeri"] . "/" . $seo_url));
        $this->viewData->og_image           = clean(get_picture("settings_v", $this->viewData->settings->logo));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = clean($this->viewData->settings->company_name);
        $this->viewData->og_description           = clean($this->viewData->settings->meta_description);
        $this->viewData->gallery_items = !empty($gallery_type) ? $this->general_model->get_all("{$gallery_type}", null, "rank ASC", ["gallery_id" => @$this->viewData->gallery->id, "isActive" => 1, "lang" => $this->viewData->lang]) : [];
        if (empty($this->viewData->gallery_items)) :
            $this->viewFolder = "404_v/index";
        else :
            $this->viewFolder = "gallery_detail_v/index";
        endif;
        $this->render();
    }
    /**
     * Contact
     */
    public function contact()
    {
        $this->viewFolder = "contact_v/index";
        $this->viewData->meta_title = $this->viewData->settings->company_name;
        $this->viewData->meta_desc  = str_replace("”", "\"", stripslashes($this->viewData->settings->meta_description));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);

        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["iletisim"]));
        $this->viewData->og_image           = clean(get_picture("settings_v", $this->viewData->settings->logo));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = clean($this->viewData->settings->company_name);
        $this->viewData->og_description           = clean($this->viewData->settings->meta_description);
        $this->render();
    }
    /**
     * Contact Form
     */
    public function contact_form()
    {
        $data = rClean($this->input->post());
        if (checkEmpty($data)["error"]) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => $this->viewData->languageJSON["contactForm"]["errorMessageTitleText"]["value"], "message" => $this->viewData->languageJSON["contactForm"]["emptyMessageText"]["value"] . " \"{$key}\" " . $this->viewData->languageJSON["contactForm"]["emptyMessageText2"]["value"]]);
            die();
        else :
            $email_message = "\"" . $data['full_name'] . "\" İsimli ziyaretçi yeni mesaj gönderdi. \n <b>Ad Soyad : </b> " . $data["full_name"] . "\n <b>Telefon : </b> " . $data["phone"] . "\n <b>E-mail : </b> " . $data["email"] . "\n <b>Konu : </b>" . $data["subject"] . "\n <b>Mesaj : </b>" . $data["comment"];
            if (send_emailv2(null, "Yeni Bir Mesajınız Var! | " . $this->viewData->settings->company_name, $email_message, [], $this->viewData->lang)) :
                echo json_encode(["success" => true, "title" => $this->viewData->languageJSON["contactForm"]["successMessageTitleText"]["value"], "message" => $this->viewData->languageJSON["contactForm"]["successMessageText"]["value"]]);
                die();
            else :
                echo json_encode(["success" => false, "title" => $this->viewData->languageJSON["contactForm"]["errorMessageTitleText"]["value"], "message" => $this->viewData->languageJSON["contactForm"]["errorEmailMessageText"]["value"]]);
                die();
            endif;
        endif;
    }
    /**
     * Offer
     */
    public function offer()
    {
        $this->viewFolder = "offer_v/index";

        /**
         * Services
         */
        $this->viewData->services = $this->general_model->get_all("services", [], [], ["isActive" => 1]);
        foreach ($this->viewData->services as $key => $data) :
            foreach ($data as $k => $v) :
                if (isJson($v)) :
                    $this->viewData->services[$key]->$k = json_decode($v);
                else :
                    $this->viewData->services[$key]->$k = $v;
                endif;
            endforeach;
        endforeach;
        $this->viewData->meta_title = $this->viewData->settings->company_name;
        $this->viewData->meta_desc  = str_replace("”", "\"", stripslashes($this->viewData->settings->meta_description));
        $this->viewData->meta_keyw  = clean($this->viewData->settings->meta_keywords);

        $this->viewData->og_url                 = clean(base_url($this->viewData->languageJSON["routes"]["hizli-teklif-al"]));
        $this->viewData->og_image           = clean(get_picture("settings_v", $this->viewData->settings->logo));
        $this->viewData->og_type          = "article";
        $this->viewData->og_title           = clean($this->viewData->settings->company_name);
        $this->viewData->og_description           = clean($this->viewData->settings->meta_description);
        $this->render();
    }
    /**
     * Make Offer
     */
    public function make_offer()
    {
        $data = rClean($this->input->post());
        if (checkEmpty($data)["error"]) :
            $key = checkEmpty($data)["key"];
            echo json_encode(["success" => false, "title" => $this->viewData->languageJSON["offerForm"]["errorMessageTitleText"]["value"], "message" => $this->viewData->languageJSON["offerForm"]["emptyMessageText"]["value"] . " \"{$key}\" " . $this->viewData->languageJSON["offerForm"]["emptyMessageText2"]["value"]]);
            die();
        else :
            $service = $this->general_model->get("services", null, ["id" => $data["type"], "isActive" => 1]);
            $title = null;
            if (!empty($service)) :
                $title = json_decode($service->title)[$this->viewData->lang];
            endif;
            $email_message = "\"" . $data['full_name'] . "\" İsimli ziyaretçi yeni bir teklif oluşturdu. \n <b>Ad Soyad : </b> " . $data["full_name"] . "\n <b>Telefon : </b> " . $data["phone"] . "\n <b>E-mail : </b> " . $data["email"] . "\n <b>Teklif Poliçesi : </b>" . $title . "\n <b>Teklif Mesajı : </b>" . $data["message"];
            if (send_emailv2(null, "Yeni Bir Teklif Başvurusu Var! | " . $this->viewData->settings->company_name, $email_message, [], $this->viewData->lang)) :
                if ($this->general_model->add("offers", $data)) :
                    echo json_encode(["success" => true, "title" => $this->viewData->languageJSON["offerForm"]["successMessageTitleText"]["value"], "message" => $this->viewData->languageJSON["offerForm"]["successMessageText"]["value"]]);
                    die();
                else :
                    echo json_encode(["success" => false, "title" => $this->viewData->languageJSON["offerForm"]["errorMessageTitleText"]["value"], "message" => $this->viewData->languageJSON["offerForm"]["errorMessageText"]["value"]]);
                    die();
                endif;
            else :
                echo json_encode(["success" => false, "title" => $this->viewData->languageJSON["offerForm"]["errorMessageTitleText"]["value"], "message" => $this->viewData->languageJSON["offerForm"]["errorEmailMessageText"]["value"]]);
                die();
            endif;
        endif;
    }
    /**
     * Change Language
     */
    public function switchLanguage()
    {
        if (!empty($this->input->post("lang"))) :
            $lang = $this->input->post("lang");
        else :
            $lang = "tr";
        endif;
        set_cookie("lang", $lang, strtotime("+1 year"));
        redirect(base_url());
    }
    /**
     * Generate a sitemap index file
     * More information about sitemap indexes: http://www.sitemaps.org/protocol.html#index
     */
    public function sitemapindex()
    {
        /**
         * Page URLs
         */
        if (!empty($this->viewData->page_urls)) :
            foreach (array_unique($this->viewData->page_urls) as $key => $value) :
                $this->sitemapmodel->add($value, NULL, 'always', 1);
            endforeach;
        endif;
        /**
         * News Categories
         */
        $news_categories = $this->general_model->get_all("news_categories", null, "rank ASC", ["isActive" => 1]);
        if (!empty($news_categories)) :
            foreach ($news_categories as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $news_categories[$key]->$k = json_decode($v);
                    else :
                        $news_categories[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($news_categories as $k => $v) :
                if (!empty($v->seo_url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["haberler"] . "/{$v->seo_url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * News
         */
        $news = $this->general_model->get_all("news", null, "id DESC", ['isActive' => 1], [], [], []);
        if (!empty($news)) :
            foreach ($news as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $news[$key]->$k = json_decode($v);
                    else :
                        $news[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($news as $k => $v) :
                if (!empty($v->seo_url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["haberler"] . "/" . $this->viewData->languageJSON["routes"]["haber"] . "/{$v->seo_url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Product Categories
         */
        $product_categories = $this->general_model->get_all("product_categories", null, "rank ASC", ["isActive" => 1]);
        if (!empty($product_categories)) :
            foreach ($product_categories as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $product_categories[$key]->$k = json_decode($v);
                    else :
                        $product_categories[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($product_categories as $k => $v) :
                if (!empty($v->seo_url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["urunler"] . "/{$v->seo_url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Products
         */
        $products = $this->general_model->get_all("products", null, "id DESC", ['isActive' => 1], [], [], []);
        if (!empty($products)) :
            foreach ($products as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $products[$key]->$k = json_decode($v);
                    else :
                        $products[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($products as $k => $v) :
                if (!empty($v->url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["urunler"] . "/" . $this->viewData->languageJSON["routes"]["urun"] . "/{$v->url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Slides
         */
        $slides = $this->general_model->get_all("slides", null, "rank ASC", ["isActive" => 1]);
        if (!empty($slides)) :
            foreach ($slides as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $slides[$key]->$k = json_decode($v);
                    else :
                        $slides[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($slides as $k => $v) :
                if (!empty($v->button_url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add($v->button_url->{$this->viewData->lang}, NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Ads
         */
        $ads = $this->general_model->get_all("ads", null, "rank ASC", ["isActive" => 1]);
        if (!empty($ads)) :
            foreach ($ads as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $ads[$key]->$k = json_decode($v);
                    else :
                        $ads[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($ads as $k => $v) :
                if (!empty($v->url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add($v->url->{$this->viewData->lang}, NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Services
         */
        $services = $this->general_model->get_all("services", null, "rank ASC", ["isActive" => 1], [], [], []);
        if (!empty($services)) :
            foreach ($services as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $services[$key]->$k = json_decode($v);
                    else :
                        $services[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($services as $k => $v) :
                if (!empty($v->url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["hizmetlerimiz"] . "/" . $this->viewData->languageJSON["routes"]["hizmet"] . "/{$v->url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Galleries
         */
        $galleries = $this->general_model->get_all("galleries", null, "rank ASC", ["isActive" => 1, "isCover" => 0], [], [], []);
        if (!empty($galleries)) :
            foreach ($galleries as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $galleries[$key]->$k = json_decode($v);
                    else :
                        $galleries[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($galleries as $k => $v) :
                if (!empty($v->url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["galeriler"] . "/" . $this->viewData->languageJSON["routes"]["galeri"] . "/{$v->url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        $this->sitemapmodel->output('sitemapindex');
    }
    /**
     * Generate a sitemap url file
     * More information about sitemap example xml: https://www.sitemaps.org/protocol.html#sitemapXmlExample
     */
    public function sitemap()
    {
        /**
         * Page URLs
         */
        if (!empty($this->viewData->page_urls)) :
            foreach (array_unique($this->viewData->page_urls) as $key => $value) :
                $this->sitemapmodel->add($value, NULL, 'always', 1);
            endforeach;
        endif;
        /**
         * News Categories
         */
        $news_categories = $this->general_model->get_all("news_categories", null, "rank ASC", ["isActive" => 1]);
        if (!empty($news_categories)) :
            foreach ($news_categories as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $news_categories[$key]->$k = json_decode($v);
                    else :
                        $news_categories[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($news_categories as $k => $v) :
                if (!empty($v->seo_url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["haberler"] . "/{$v->seo_url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * News
         */
        $news = $this->general_model->get_all("news", null, "id DESC", ['isActive' => 1], [], [], []);
        if (!empty($news)) :
            foreach ($news as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $news[$key]->$k = json_decode($v);
                    else :
                        $news[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($news as $k => $v) :
                if (!empty($v->seo_url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["haberler"] . "/" . $this->viewData->languageJSON["routes"]["haber"] . "/{$v->seo_url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Product Categories
         */
        $product_categories = $this->general_model->get_all("product_categories", null, "rank ASC", ["isActive" => 1]);
        if (!empty($product_categories)) :
            foreach ($product_categories as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $product_categories[$key]->$k = json_decode($v);
                    else :
                        $product_categories[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($product_categories as $k => $v) :
                if (!empty($v->seo_url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["urunler"] . "/{$v->seo_url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Products
         */
        $products = $this->general_model->get_all("products", null, "id DESC", ['isActive' => 1], [], [], []);
        if (!empty($products)) :
            foreach ($products as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $products[$key]->$k = json_decode($v);
                    else :
                        $products[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($products as $k => $v) :
                if (!empty($v->url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["urunler"] . "/" . $this->viewData->languageJSON["routes"]["urun"] . "/{$v->url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Slides
         */
        $slides = $this->general_model->get_all("slides", null, "rank ASC", ["isActive" => 1]);
        if (!empty($slides)) :
            foreach ($slides as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $slides[$key]->$k = json_decode($v);
                    else :
                        $slides[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($slides as $k => $v) :
                if (!empty($v->button_url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add($v->button_url->{$this->viewData->lang}, NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Ads
         */
        $ads = $this->general_model->get_all("ads", null, "rank ASC", ["isActive" => 1]);
        if (!empty($ads)) :
            foreach ($ads as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $ads[$key]->$k = json_decode($v);
                    else :
                        $ads[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($ads as $k => $v) :
                if (!empty($v->url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add($v->url->{$this->viewData->lang}, NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Services
         */
        $services = $this->general_model->get_all("services", null, "rank ASC", ["isActive" => 1], [], [], []);
        if (!empty($services)) :
            foreach ($services as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $services[$key]->$k = json_decode($v);
                    else :
                        $services[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($services as $k => $v) :
                if (!empty($v->url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["hizmetlerimiz"] . "/" . $this->viewData->languageJSON["routes"]["hizmet"] . "/{$v->url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        /**
         * Galleries
         */
        $galleries = $this->general_model->get_all("galleries", null, "rank ASC", ["isActive" => 1, "isCover" => 0], [], [], []);
        if (!empty($galleries)) :
            foreach ($galleries as $key => $data) :
                foreach ($data as $k => $v) :
                    if (isJson($v)) :
                        $galleries[$key]->$k = json_decode($v);
                    else :
                        $galleries[$key]->$k = $v;
                    endif;
                endforeach;
            endforeach;
            foreach ($galleries as $k => $v) :
                if (!empty($v->url->{$this->viewData->lang})) :
                    $this->sitemapmodel->add(base_url($this->viewData->languageJSON["routes"]["galeriler"] . "/" . $this->viewData->languageJSON["routes"]["galeri"] . "/{$v->url->{$this->viewData->lang}}"), NULL, 'always', 1);
                endif;
            endforeach;
        endif;
        $this->sitemapmodel->output();
    }
}
