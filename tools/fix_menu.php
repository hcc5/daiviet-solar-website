<?php
// Run via: wp eval-file fix_menu.php --allow-root --path=/var/www/html
$menu = wp_get_nav_menu_object('menu-chinh-dai-viet-solar');
if (!$menu) { echo "Menu not found\n"; exit(1); }
$menu_id = $menu->term_id;

$parent_products = 43;
$parent_services = 44;

// item_id => [title, path, parent_id, position]
$items = [
    16 => ['Sản phẩm',                    'san-pham',              $parent_products, 5],
    15 => ['Công nghệ',                   'cong-nghe',             $parent_products, 6],
    19 => ['Cấu hình cho nhà dân',        'cau-hinh-nha-dan',      $parent_products, 7],
    20 => ['Cấu hình cho doanh nghiệp',   'cau-hinh-doanh-nghiep', $parent_products, 8],
    17 => ['Quy trình lắp đặt',           'quy-trinh-lap-dat',     $parent_services, 9],
    18 => ['Bảo hành & bảo dưỡng',        'bao-hanh-bao-duong',    $parent_services, 10],
    22 => ['Tin tức',                     'tin-tuc',               $parent_services, 11],
];

foreach ($items as $item_id => $info) {
    list($title, $path, $parent_id, $position) = $info;
    $page = get_page_by_path($path);
    if (!$page) { echo "Page not found for $path\n"; continue; }
    $res = wp_update_nav_menu_item($menu_id, $item_id, [
        'menu-item-title'      => $title,
        'menu-item-object-id'  => $page->ID,
        'menu-item-object'     => 'page',
        'menu-item-type'       => 'post_type',
        'menu-item-parent-id'  => $parent_id,
        'menu-item-position'   => $position,
        'menu-item-status'     => 'publish',
    ]);
    if (is_wp_error($res)) {
        echo "Error updating $item_id: " . $res->get_error_message() . "\n";
    } else {
        echo "Fixed item $item_id ($title) -> page {$page->ID}, parent $parent_id\n";
    }
}

// Also make sure parent group titles are correct (in case of earlier issues) and positions right
wp_update_nav_menu_item($menu_id, $parent_products, [
    'menu-item-title'     => 'Sản phẩm & Giải pháp',
    'menu-item-url'       => '#',
    'menu-item-type'      => 'custom',
    'menu-item-status'    => 'publish',
    'menu-item-position'  => 2,
]);
wp_update_nav_menu_item($menu_id, $parent_services, [
    'menu-item-title'     => 'Dịch vụ & Bảo hành',
    'menu-item-url'       => '#',
    'menu-item-type'      => 'custom',
    'menu-item-status'    => 'publish',
    'menu-item-position'  => 3,
]);
wp_update_nav_menu_item($menu_id, 14, ['menu-item-title' => 'Trang chủ', 'menu-item-position' => 1]);
wp_update_nav_menu_item($menu_id, 21, ['menu-item-title' => 'Liên hệ', 'menu-item-position' => 4]);

echo "DONE\n";
