# Đại Việt Solar — Website mới (WordPress)

Theme WordPress hiện đại, chuẩn SEO, tự viết từ đầu (không dùng page builder) cho Đại Việt Solar — tập trung quảng bá công nghệ, sản phẩm, quy trình lắp đặt, bảo hành/bảo dưỡng và cấu hình đề xuất cho nhà dân/doanh nghiệp.

## Cấu trúc dự án

```
daiviet-solar-website/
├── docker-compose.yml          # Stack WordPress + MariaDB
├── .env.example                 # Mẫu biến môi trường (copy thành .env khi deploy)
└── wp-content/themes/daiviet-solar/
    ├── style.css                 # Header theme bắt buộc của WordPress
    ├── functions.php             # Setup theme, SEO on-page, Customizer, form liên hệ
    ├── header.php / footer.php
    ├── front-page.php            # Trang chủ
    ├── page-cong-nghe.php
    ├── page-san-pham.php
    ├── page-quy-trinh-lap-dat.php
    ├── page-bao-hanh-bao-duong.php
    ├── page-cau-hinh-nha-dan.php
    ├── page-cau-hinh-doanh-nghiep.php
    ├── page-lien-he.php          # Form liên hệ (lưu vào wp-admin, gửi email)
    ├── single.php / archive.php / index.php / page.php / 404.php
    ├── inc/setup-content.php     # Tự tạo trang + menu + permalink khi kích hoạt theme
    └── assets/css/style.css, assets/js/main.js
```

## Tính năng chính

- **Trang admin WordPress** có sẵn để đăng bài blog/tin tức (`/wp-admin`), không cần cài thêm plugin.
- **Chuẩn SEO on-page**: meta description, canonical, Open Graph, Twitter card, JSON-LD `LocalBusiness` — viết trực tiếp trong `functions.php`, không phụ thuộc plugin Yoast.
- **Tự động hoá**: WordPress REST API bật sẵn (`/wp-json/wp/v2/`) để tích hợp n8n hoặc script tự động đăng bài; form liên hệ lưu thành custom post type `dvs_lead` (hiển thị trong wp-admin, có `show_in_rest` để đọc qua API).
- **7 trang nội dung** tự động tạo khi kích hoạt theme: Công nghệ, Sản phẩm, Quy trình lắp đặt, Bảo hành & bảo dưỡng, Cấu hình nhà dân, Cấu hình doanh nghiệp, Liên hệ.
- **Responsive**, font Be Vietnam Pro hỗ trợ tiếng Việt đầy đủ dấu.

## Chạy thử local / deploy qua Portainer

1. Copy `.env.example` thành `.env`, đổi mật khẩu DB.
2. Deploy stack (`docker compose up -d` hoặc qua Portainer → Stacks → tạo mới, dán nội dung `docker-compose.yml`, khai báo biến môi trường trong UI Portainer).
3. Truy cập `http://<ip>:<WP_PUBLISH_PORT>` để cài đặt WordPress lần đầu (ngôn ngữ, tài khoản admin).
4. Vào **Giao diện → Theme**, kích hoạt theme **Dai Viet Solar** — hệ thống sẽ tự tạo 7 trang + menu chính.
5. Vào **Giao diện → Tùy biến → Thông tin liên hệ Đại Việt Solar** để cập nhật hotline, email, địa chỉ, Zalo, Facebook.
6. (Tuỳ chọn) Gắn domain thật qua Nginx Proxy Manager: forward domain đến container `daiviet-solar-wp` cổng 80 trong network `proxy`.

## Ghi chú

- Nếu deploy sau NPM/reverse proxy qua domain thật, đặt `WP_HOME`/`WP_SITEURL` trong `.env` bằng domain đó (ví dụ `https://daivietsolar-new.example.vn`) rồi `docker compose up -d` lại.
- Thư mục theme được bind-mount trực tiếp từ repo (`wp-content/themes/daiviet-solar`), nên sửa code trong repo và pull về là thấy thay đổi ngay, không cần build lại image.
