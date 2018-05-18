<?php
/***************************************************************************
*                                                                          *
* Add-on developed by technical support department and it is not official  *
* Simtech addon. Addon is distributed on a principle "AS IS" and Simtech   *
* company is not responsible for any forthcoming changes or any unintended *
* consequences.															   *
*                                                                          *
***************************************************************************/

use Tygh\Registry;

if (!defined('BOOTSTRAP')) { die('Access denied'); }

function fn_images_sorting_get_products(&$params, &$fields, &$sortings, &$condition, &$join) {

	//Check for sorting in the admin panel
	if(Registry::get('addons.images_sorting.sort_in_admin_panel') == 'N' && AREA == "A"){
		return false;
	}

	$join = ' LEFT JOIN ?:images_links AS images_links ON products.product_id = images_links.object_id AND images_links.type="M" AND images_links.object_type="product" ' .$join;
	$fields['detailed_image'] = ' IF(images_links.detailed_id IS NULL OR images_links.detailed_id=0, 0, 1) as images ';
	$sortings[$params['sort_by']] = "images desc," .$sortings[$params['sort_by']];

	if(Registry::get('addons.images_sorting.unimaged_products') == 'hide' && AREA == "C"){
		$condition .= " AND IF(images_links.detailed_id IS NULL OR images_links.detailed_id=0, 1, 0)=0 ";
	}
}