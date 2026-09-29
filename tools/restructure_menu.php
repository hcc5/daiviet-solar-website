<?php
// Run via: wp eval-file restructure_menu.php --allow-root --path=/var/www/html
$menu = wp_get_nav_menu_object('menu-chinh-dai-viet-solar');
if (!$menu) { echo "Menu not found\n"; exit(1); }
$menu_id = $menu->term_id;

// 1) Create two parent group items (custom links, non-navigating)
$parent_products = wp_update_nav_menu_item($menu_id, 0, [
    'menu-item-title'     => 'Sản phẩm & Giải pháp',
    'menu-item-url'       => '#',
    'menu-item-status'    => 'publish',
    'menu-item-type'      => 'custom',
    'menu-item-position'  => 2,
]);

$parent_services = wp_update_nav_menu_item($menu_id, 0, [
    'menu-item-title'     => 'Dịch vụ & Bảo hành',
    'menu-item-url'       => '#',
    'menu-item-status'    => 'publish',
    'menu-item-type'      => 'custom',
    'menu-item-position'  => 3,
]);

if (is_wp_error($parent_products) || is_wp_error($parent_services)) {
    echo "Error creating parent items\n";
    print_r($parent_products);
    print_r($parent_services);
    exit(1);
}

echo "Created parent items: products=$parent_products services=$parent_services\n";

// 2) Map existing child items to db_id => [new parent id, order within submenu]
$children_map = [
    16 => [$parent_products, 1], // Sản phẩm
    15 => [$parent_products, 2], // Công nghệ
    19 => [$parent_products, 3], // Cấu hình cho nhà dân
    20 => [$parent_products, 4], // Cấu hình cho doanh nghiệp
    17 => [$parent_services, 1], // Quy trình lắp đặt
    18 => [$parent_services, 2], // Bảo hành & bảo dưỡng
    22 => [$parent_services, 3], // Tin tức
];

foreach ($children_map as $item_id => $info) {
    list($parent_id, $order) = $info;
    $item = get_post($item_id);
    if (!$item) { echo "Item $item_id not found, skipping\n"; continue; }
    $menu_item_db_id = wp_update_nav_menu_item($menu_id, $item_id, [
        'menu-item-title'       => get_post_meta($item_id, '_menu_item_title', true) ?: $item->post_title,
        'menu-item-object-id'   => get_post_meta($item_id, '_menu_item_object_id', true),
        'menu-item-object'      => get_post_meta($item_id, '_menu_item_object', true),
        'menu-item-type'        => get_post_meta($item_id, '_menu_item_type', true),
        'menu-item-url'         => get_post_meta($item_id, '_menu_item_url', true),
        'menu-item-parent-id'   => $parent_id,
        'menu-item-position'    => 10 + $order, // temp, will renumber below
        'menu-item-status'      => 'publish',
    ]);
    if (is_wp_error($menu_item_db_id)) {
        echo "Error updating item $item_id: " . $menu_item_db_id->get_error_message() . "\n";
    } else {
        echo "Updated item $item_id -> parent $parent_id\n";
    }
}

// 3) Renumber top-level items: Trang chủ(14)=1, Sản phẩm&GP=2, Dịch vụ&BH=3, Liên hệ(21)=4
wp_update_nav_menu_item($menu_id, 14, ['menu-item-position' => 1]);
wp_update_nav_menu_item($menu_id, $parent_products, ['menu-item-position' => 2]);
wp_update_nav_menu_item($menu_id, $parent_services, ['menu-item-position' => 3]);
wp_update_nav_menu_item($menu_id, 21, ['menu-item-position' => 4]);

// Renumber children within each parent group so wp_nav_menu renders correct sub order
wp_update_nav_menu_item($menu_id, 16, ['menu-item-position' => 5, 'menu-item-parent-id' => $parent_products]);
wp_update_nav_menu_item($menu_id, 15, ['menu-item-position' => 6, 'menu-item-parent-id' => $parent_products]);
wp_update_nav_menu_item($menu_id, 19, ['menu-item-position' => 7, 'menu-item-parent-id' => $parent_products]);
wp_update_nav_menu_item($menu_id, 20, ['menu-item-position' => 8, 'menu-item-parent-id' => $parent_products]);
wp_update_nav_menu_item($menu_id, 17, ['menu-item-position' => 9, 'menu-item-parent-id' => $parent_services]);
wp_update_nav_menu_item($menu_id, 18, ['menu-item-position' => 10, 'menu-item-parent-id' => $parent_services]);
wp_update_nav_menu_item($menu_id, 22, ['menu-item-position' => 11, 'menu-item-parent-id' => $parent_services]);

echo "DONE\n";
