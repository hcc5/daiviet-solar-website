<?php
/* Template Name: Công cụ tính điện */
if (!defined('ABSPATH')) exit; get_header(); ?>

<section class="dvs-page-hero">
  <div class="dvs-container">
    <span class="dvs-eyebrow">Công cụ tính toán</span>
    <h1>Tính nhanh hóa đơn tiền điện &amp; hệ thống điện mặt trời</h1>
    <p class="dvs-page-hero__lead">Nhập hóa đơn tiền điện hoặc lượng điện tiêu thụ để xem ngay số tiền điện theo biểu giá EVN, công suất hệ điện mặt trời phù hợp, số tấm pin, diện tích mái cần dùng, công suất inverter và dung lượng pin lưu trữ (nếu chọn hybrid).</p>
  </div>
</section>

<section class="dvs-section dvs-calc-section">
  <div class="dvs-container">
    <?php
    $dvc_phone    = preg_replace('/\s+/', '', get_theme_mod('dvs_hotline', '0978021216'));
    $dvc_phone_lb = get_theme_mod('dvs_hotline', '0978 021 216');
    $dvc_zalo     = get_theme_mod('dvs_zalo', 'https://zalo.me/0978021216');
    ?>
    <div class="dvc" data-dvc data-dvc-cfg='{"contactUrl":"<?php echo esc_js(home_url('/lien-he/')); ?>","phone":"<?php echo esc_js($dvc_phone); ?>","phoneLabel":"<?php echo esc_js($dvc_phone_lb); ?>","zalo":"<?php echo esc_js($dvc_zalo); ?>"}'>
    <style>
    .dvc{--dvc-primary:var(--dvs-navy,#0b1f3a);--dvc-accent:var(--dvs-amber,#f5a623);--dvc-accent-ink:#3b2a00;--dvc-ink:var(--dvs-ink,#1f2937);--dvc-muted:var(--dvs-gray,#64748b);--dvc-line:var(--dvs-border,#e2e8f0);--dvc-soft:var(--dvs-bg-alt,#f6f8fb);--dvc-good:var(--dvs-green,#15803d);font-family:inherit;color:var(--dvc-ink);max-width:1100px;margin:0 auto;background:#fff;border:1px solid var(--dvc-line);border-radius:var(--dvs-radius,18px);box-shadow:var(--dvs-shadow,0 8px 28px rgba(15,23,42,.07));overflow:hidden;line-height:1.5}
    .dvc *{box-sizing:border-box}
    .dvc-head{padding:24px 28px 8px}
    .dvc-head h2{margin:0 0 6px;font-size:1.55rem;line-height:1.25;color:var(--dvc-primary)}
    .dvc-head p{margin:0;color:var(--dvc-muted);font-size:.98rem}
    .dvc-tabs{display:grid;grid-template-columns:repeat(4,1fr);gap:8px;padding:16px 28px 0}
    .dvc-tabs button{appearance:none;border:1px solid var(--dvc-line);background:#fff;color:var(--dvc-ink);font:inherit;font-weight:600;font-size:.95rem;padding:12px 10px;border-radius:12px;cursor:pointer;transition:all .15s;line-height:1.3}
    .dvc-tabs button:hover{border-color:var(--dvc-primary)}
    .dvc-tabs button[aria-selected=true]{background:var(--dvc-primary);border-color:var(--dvc-primary);color:#fff;box-shadow:0 4px 12px rgba(11,74,143,.28)}
    .dvc-body{display:grid;grid-template-columns:minmax(280px,370px) 1fr;gap:24px;padding:22px 28px 28px}
    .dvc-in{display:flex;flex-direction:column;gap:14px}
    .dvc-field label,.dvc-field .dvc-lb{display:block;font-weight:600;font-size:.9rem;margin-bottom:5px}
    .dvc-field input[type=text],.dvc-field select{width:100%;font:inherit;font-size:1rem;padding:11px 12px;border:1px solid #cbd5e1;border-radius:10px;background:#fff;color:var(--dvc-ink)}
    .dvc-field input[type=text]:focus,.dvc-field select:focus{outline:2px solid var(--dvc-accent);outline-offset:1px;border-color:var(--dvc-accent)}
    .dvc-field small{display:block;color:var(--dvc-muted);font-size:.8rem;margin-top:4px}
    .dvc-row{display:flex;align-items:center;gap:10px}
    .dvc input[type=range]{flex:1;accent-color:var(--dvc-accent);height:28px}
    .dvc-val{min-width:64px;text-align:right;font-weight:700;color:var(--dvc-primary)}
    .dvc-adjust{border:1px dashed #cbd5e1;border-radius:12px;padding:12px 14px;background:var(--dvc-soft)}
    .dvc-adjust-t{display:flex;justify-content:space-between;align-items:baseline;font-weight:700;font-size:.9rem;margin-bottom:2px}
    .dvc-link{appearance:none;background:none;border:0;padding:0;color:var(--dvc-primary);font:inherit;font-size:.8rem;font-weight:600;text-decoration:underline;cursor:pointer}
    .dvc-out{min-width:0}
    .dvc-empty{border:1px dashed #cbd5e1;border-radius:14px;padding:44px 20px;text-align:center;color:var(--dvc-muted);background:var(--dvc-soft)}
    .dvc-hero{background:linear-gradient(135deg,var(--dvc-primary),#0a3566);color:#fff;border-radius:14px;padding:18px 20px;display:flex;flex-wrap:wrap;justify-content:space-between;gap:10px 18px;align-items:center}
    .dvc-hero .k{font-size:.85rem;opacity:.85}
    .dvc-hero .v{font-size:2.1rem;font-weight:800;line-height:1.1}
    .dvc-hero .v span{font-size:1.1rem;font-weight:600;margin-left:4px}
    .dvc-hero .s{font-size:.9rem;opacity:.9;text-align:right}
    .dvc-warn{margin-top:10px;background:#fff7e0;border:1px solid #f3d27a;color:#6b4a00;border-radius:10px;padding:9px 12px;font-size:.88rem}
    .dvc-tiles{display:grid;grid-template-columns:repeat(2,1fr);gap:10px;margin-top:12px}
    .dvc-tile{border:1px solid var(--dvc-line);border-radius:12px;padding:12px 14px;background:#fff}
    .dvc-tile.good{border-color:#bbe5c8;background:#f1fbf4}
    .dvc-tl{font-size:.82rem;color:var(--dvc-muted);font-weight:600}
    .dvc-tv{font-size:1.5rem;font-weight:800;line-height:1.2;margin-top:2px}
    .dvc-tile.good .dvc-tv{color:var(--dvc-good)}
    .dvc-tu{font-size:.82rem;color:var(--dvc-muted)}
    .dvc-ts{font-size:.8rem;color:var(--dvc-muted);margin-top:3px}
    .dvc-h{font-size:1rem;margin:18px 0 8px;color:var(--dvc-primary);font-weight:700}
    .dvc-prod{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
    .dvc-cfg{list-style:none;margin:0;padding:0;border:1px solid var(--dvc-line);border-radius:12px;overflow:hidden}
    .dvc-cfg li{display:flex;justify-content:space-between;gap:12px;padding:9px 14px;font-size:.93rem}
    .dvc-cfg li:nth-child(odd){background:var(--dvc-soft)}
    .dvc-cfg b{text-align:right}
    .dvc-chart{border:1px solid var(--dvc-line);border-radius:12px;padding:10px 8px 4px}
    .dvc-chart svg{display:block;width:100%;height:auto}
    .dvc-chart .ln{fill:none;stroke:var(--dvc-primary);stroke-width:2.6;stroke-linejoin:round}
    .dvc-chart .zero{stroke:#94a3b8;stroke-width:1;stroke-dasharray:4 4}
    .dvc-chart .grid{stroke:#eef2f7;stroke-width:1}
    .dvc-chart text{fill:var(--dvc-muted);font-size:11px;font-family:inherit}
    .dvc-chart .pb{fill:var(--dvc-accent);stroke:#fff;stroke-width:2}
    .dvc-chart .pbt{fill:var(--dvc-accent-ink);font-weight:700;font-size:12px}
    .dvc-cta{display:flex;flex-wrap:wrap;gap:10px;margin-top:18px}
    .dvc-cta a{display:inline-block;text-decoration:none;font-weight:700;padding:13px 20px;border-radius:12px;font-size:.98rem;text-align:center}
    .dvc-cta a.p{background:var(--dvc-accent);color:var(--dvc-accent-ink)}
    .dvc-cta a.p:hover{filter:brightness(.95)}
    .dvc-cta a.s{border:1px solid var(--dvc-primary);color:var(--dvc-primary);background:#fff}
    .dvc-cta a.s:hover{background:var(--dvc-soft)}
    .dvc-note{margin-top:14px;font-size:.78rem;color:var(--dvc-muted)}
    .dvc [hidden]{display:none!important}
    .dvc-3{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
    .dvc-3 label{font-size:.8rem!important}
    .dvc-tblw{overflow-x:auto;border:1px solid var(--dvc-line);border-radius:12px}
    .dvc-tbl{width:100%;border-collapse:collapse;font-size:.92rem}
    .dvc-tbl th{background:var(--dvc-soft);text-align:right;padding:9px 12px;font-size:.8rem;color:var(--dvc-muted)}
    .dvc-tbl th:first-child,.dvc-tbl td:first-child{text-align:left}
    .dvc-tbl td{padding:9px 12px;text-align:right;border-top:1px solid var(--dvc-line)}
    .dvc-tbl tr.sum td{background:var(--dvc-soft);font-weight:600}
    .dvc-tbl tr.tot td{background:#fff7e0;font-weight:800;font-size:1rem}
    .dvc-tip{margin-top:12px;background:#f1fbf4;border:1px solid #bbe5c8;color:#14532d;border-radius:10px;padding:10px 12px;font-size:.9rem}
    @media(max-width:820px){.dvc-body{grid-template-columns:1fr;padding:18px 16px 22px}.dvc-head{padding:20px 16px 6px}.dvc-tabs{padding:14px 16px 0;gap:6px;grid-template-columns:repeat(2,1fr)}.dvc-tabs button{font-size:.82rem;padding:10px 6px}.dvc-hero .s{text-align:left}.dvc-hero .v{font-size:1.8rem}}
    @media(max-width:480px){.dvc-tbl th,.dvc-tbl td{padding:8px 5px;font-size:.78rem}.dvc-tbl tr.tot td{font-size:.86rem}.dvc-prod{grid-template-columns:1fr}.dvc-cta a{flex:1 1 100%}.dvc-tiles{grid-template-columns:1fr}.dvc-3{grid-template-columns:1fr}}
    </style>
    <div class="dvc-head">
    <h2 data-o="title">Tính nhanh hệ thống điện mặt trời cho nhà bạn</h2>
    <p data-o="sub">Nhập hóa đơn điện, nhận ngay công suất đề xuất, sản lượng, tiền tiết kiệm và thời gian hoàn vốn sơ bộ.</p>
    </div>
    <div class="dvc-tabs" role="tablist" aria-label="Loại công cụ" data-tabbar>
    <button type="button" role="tab" data-mode="hoaluoi" aria-selected="true">Nhà dân<br>hòa lưới</button>
    <button type="button" role="tab" data-mode="hybrid" aria-selected="false">Nhà dân<br>hybrid + pin lưu trữ</button>
    <button type="button" role="tab" data-mode="dn" aria-selected="false">Doanh nghiệp<br>nhà xưởng</button>
    <button type="button" role="tab" data-mode="bill" aria-selected="false">Tính tiền điện<br>theo biểu giá EVN</button>
    </div>
    <div class="dvc-body">
    <form class="dvc-in" onsubmit="return false" autocomplete="off">
    <div class="dvc-field" data-show="hoaluoi hybrid">
    <label>Tiền điện trung bình mỗi tháng (VNĐ)<input type="text" inputmode="numeric" data-f="bill" placeholder="Ví dụ: 2.500.000"></label>
    <small>Lấy theo hóa đơn gần nhất (đã gồm VAT). Số kWh được quy đổi tự động.</small>
    </div>
    <div class="dvc-field" data-show="hoaluoi hybrid">
    <label>Hoặc điện tiêu thụ (kWh/tháng)<input type="text" inputmode="numeric" data-f="kwhR" placeholder="Ví dụ: 750"></label>
    </div>
    <div class="dvc-field" data-show="dn">
    <label>Điện tiêu thụ trung bình (kWh/tháng)<input type="text" inputmode="numeric" data-f="kwhD" placeholder="Ví dụ: 40.000"></label>
    </div>
    <div class="dvc-field" data-show="dn">
    <label>Giá điện giờ bình thường (đồng/kWh, chưa VAT)<input type="text" inputmode="numeric" data-f="price" placeholder="Xem trên hóa đơn tiền điện"></label>
    <small>Nhập đúng đơn giá giờ bình thường theo hợp đồng của doanh nghiệp để kết quả sát thực tế.</small>
    <select data-f="pset" style="margin-top:8px" aria-label="Chọn nhanh đơn giá theo biểu giá EVN"></select>
    </div>
    <div class="dvc-field" data-show="hoaluoi hybrid dn">
    <label>Khu vực lắp đặt<select data-f="region"><option value="bac">Miền Bắc</option><option value="trung">Miền Trung và Tây Nguyên</option><option value="nam">Miền Nam</option></select></label>
    </div>
    <div class="dvc-field" data-show="hoaluoi hybrid dn">
    <label>Diện tích mái khả dụng (m², không bắt buộc)<input type="text" inputmode="numeric" data-f="roof" placeholder="Bỏ trống nếu chưa biết"></label>
    </div>
    <div class="dvc-field" data-show="hoaluoi hybrid dn">
    <span class="dvc-lb">Tỷ lệ điện dùng vào ban ngày (6h–17h)</span>
    <div class="dvc-row"><input type="range" min="10" max="100" step="5" value="45" data-f="day" aria-label="Tỷ lệ điện dùng ban ngày"><span class="dvc-val" data-o="day">45%</span></div>
    <small data-o="dayhint"></small>
    </div>
    <div class="dvc-field" data-show="bill">
    <label>Đối tượng sử dụng điện<select data-f="btype">
    <option value="sh">Sinh hoạt</option>
    <option value="kd">Kinh doanh</option>
    <option value="sx">Sản xuất</option>
    <option value="yt">Bệnh viện, nhà trẻ, mẫu giáo, trường phổ thông</option>
    <option value="cs">Chiếu sáng công cộng, cơ quan hành chính sự nghiệp</option>
    </select></label>
    </div>
    <div class="dvc-field" data-show="bill" data-sub="sh">
    <label>Số hộ dùng chung một công tơ<input type="text" inputmode="numeric" data-f="hos" value="1"></label>
    <small>Nhà cho thuê nhiều hộ dùng chung công tơ: các bậc thang được nhân theo số hộ.</small>
    </div>
    <div class="dvc-field" data-show="bill" data-sub="kd sx yt cs">
    <label>Cấp điện áp<select data-f="blevel"></select></label>
    </div>
    <div class="dvc-field" data-show="bill" data-sub="sh yt cs">
    <label>Điện năng tiêu thụ trong tháng (kWh)<input type="text" inputmode="numeric" data-f="bkwh" placeholder="Ví dụ: 350"></label>
    </div>
    <div class="dvc-field" data-show="bill" data-sub="kd sx">
    <span class="dvc-lb">Điện năng tiêu thụ theo khung giờ (kWh)</span>
    <div class="dvc-3">
    <label>Bình thường<input type="text" inputmode="numeric" data-f="bkwhN" placeholder="0"></label>
    <label>Thấp điểm<input type="text" inputmode="numeric" data-f="bkwhT" placeholder="0"></label>
    <label>Cao điểm<input type="text" inputmode="numeric" data-f="bkwhC" placeholder="0"></label>
    </div>
    <small>Lấy theo hóa đơn. Thứ Hai–Thứ Bảy: cao điểm 9h30–11h30 và 17h–20h; thấp điểm 22h–4h; còn lại là bình thường. Chủ nhật không có giờ cao điểm.</small>
    </div>
    <div class="dvc-field" data-show="bill">
    <label>Thuế GTGT<select data-f="bvat"></select></label>
    </div>
    <div class="dvc-adjust" data-adjust hidden>
    <div class="dvc-adjust-t"><span>Tùy chỉnh công suất</span><button type="button" class="dvc-link" data-reset>Về mức đề xuất</button></div>
    <div class="dvc-row"><input type="range" data-f="panels" aria-label="Số tấm pin"><span class="dvc-val" data-o="panels"></span></div>
    <div data-battbox hidden>
    <div class="dvc-adjust-t" style="margin-top:8px"><span>Dung lượng pin lưu trữ</span></div>
    <div class="dvc-row"><input type="range" data-f="batt" aria-label="Dung lượng pin"><span class="dvc-val" data-o="batt"></span></div>
    </div>
    </div>
    </form>
    <div class="dvc-out" aria-live="polite">
    <div class="dvc-empty" data-empty>Nhập tiền điện (hoặc số kWh) ở bên trái để xem kết quả tính toán.</div>
    <div data-result hidden></div>
    </div>
    </div>
    </div>
  </div>
</section>

<?php get_footer(); ?>
