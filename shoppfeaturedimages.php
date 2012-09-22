<?php
/*
Plugin Name: Featured Images for Shopp
Description: Adds post thumbnail support to Shopp products. Where a thumbnail is specified this will be used automatically as the product cover image instead of using the first product gallery image, as is the default behaviour. The product post thumbnails can also be used elsewhere at will.
Version: 1.0.1
Author: Barry Hughes
Author URI: http://freshlybakedwebsites.net
License: GPL3

    "Featured Images for Shopp" adds post thumbnail support to Shopp products
    Copyright (C) 2012 Barry Hughes

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/


class ShoppFeaturedImages {
	public $dir = '';
	public $url = '';
	public static $id = 'shoppfimg';


	public static function init() {
		add_action('plugins_loaded', array(__CLASS__, 'loader'));
	}


	public static function loader() {
		if (defined('SHOPP_VERSION') and version_compare(SHOPP_VERSION, '1.2') >= 0)
			new ShoppFeaturedImages;
	}


	public function __construct() {
		$this->dir = dirname(__FILE__);
		$this->url = WP_PLUGIN_URL.'/'.basename($this->dir);
		$productEditorHook = 'add_meta_boxes_'.Product::$posttype;

		add_action('registered_post_type', array($this, 'addThumbnailSupport'));
		add_action($productEditorHook, array($this, 'addJSSupport'));
		add_action($productEditorHook, array($this, 'preparePostIDIndicator'));
		add_action($productEditorHook, array($this, 'registerMetabox'));
		add_filter('shopp_tag_product_coverimage', array($this, 'autoThumbnailSupport'));
	}


	public function addThumbnailSupport($postType, $args = null) {
		if ($postType === Product::$posttype)
			add_post_type_support($postType, 'thumbnail');
	}


	public function addJSSupport() {
		add_thickbox();
		wp_enqueue_script('post');
		wp_enqueue_script('media-upload');
	}


	/**
	 * The post thumbnail UI relies on being able to determine the post ID by
	 * grabbing the value of the #post_ID element (normally a hidden input - but
	 * is missing from the Shopp product editor) and we are simply using the
	 * submitpage_box action as a convenient point to insert it.
	 */
	public function preparePostIDIndicator() {
		add_action('submitpage_box', array($this, 'addPostIDIndicator'));
	}


	public function addPostIDIndicator() {
		$postID = (int) $_GET['id'];
		echo '<input type="hidden" name="post_ID" id="post_ID" value="'.$postID.'" />';
	}


	public function registerMetabox() {
		add_meta_box('postimagediv', __('Featured Image', self::$id),
			array($this, 'renderMetabox'),
			Product::$posttype,	'side', 'low');
	}


	public function renderMetabox($product) {
		$thumbnailID = get_post_meta($product->id, '_thumbnail_id', true);
		echo _wp_post_thumbnail_html($thumbnailID, $product->id);
	}


	/**
	 * Replaces the cover image with the product's featured image, if specified.
	 * This automatic replacement can be turned off by filtering
	 * shopp_auto_featured_thumb and returning false from the filter.
	 */
	public function autoThumbnailSupport($tagOutput) {
		if (apply_filters('shopp_auto_featured_thumb', true) === false)
			return $tagOutput;

		$postID = shopp('product', 'id', 'return=1');
		$size = apply_filters('shopp_featured_img_size', 'post-thumbnail');
		$attr = apply_filters('shopp_featured_img_attr', '');
		$thumbnail = get_the_post_thumbnail($postID, $size, $attr);

		if (empty($thumbnail)) return $tagOutput;
		else return $thumbnail;
	}
}


ShoppFeaturedImages::init();


/*add_filter('shopp_auto_featured_thumb', 'my_new_filter');
function my_new_filter() { return false; }*/