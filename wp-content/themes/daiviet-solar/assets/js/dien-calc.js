/* ĐẠI VIỆT SOLAR – Công cụ tính điện mặt trời & biểu giá EVN */
(function(root){
'use strict';
var CFG={
contactUrl:'/lien-he/',
phone:'0978021216',phoneLabel:'0978 021 216',
zalo:'https://zalo.me/0978021216',
tariff:[[50,1984],[100,2050],[200,2380],[300,2998],[400,3350],[Infinity,3460]],
vat:0.08,
evn:{
sx:[{label:'Từ 110 kV trở lên',bt:1811,td:1146,cd:3266},{label:'22 kV đến dưới 110 kV',bt:1833,td:1190,cd:3398},{label:'6 kV đến dưới 22 kV',bt:1899,td:1234,cd:3508},{label:'Dưới 6 kV',bt:1987,td:1300,cd:3640}],
kd:[{label:'Từ 22 kV trở lên',bt:2887,td:1609,cd:5025},{label:'6 kV đến dưới 22 kV',bt:3108,td:1829,cd:5202},{label:'Dưới 6 kV',bt:3152,td:1918,cd:5422}],
yt:[{label:'Từ 6 kV trở lên',p:1940},{label:'Dưới 6 kV',p:2072}],
cs:[{label:'Từ 6 kV trở lên',p:2138},{label:'Dưới 6 kV',p:2226}]
},
yield:{bac:3.4,trung:4.0,nam:4.2},
panelWp:620,
areaPerKwp:6,
degradation:0.005,
priceEscalation:0,
omPercent:0,
sellPrice:0,
daysPerMonth:30,
acDc:1.2,
battery:{dod:0.9,eff:0.9,moduleKwh:5},
hybridNightTarget:0.7,
matchFactor:{hoaluoi:0.85,hybrid:1,dn:0.95},
defaultDay:{hoaluoi:45,hybrid:40,dn:80},
prices:{
hoaluoi:[{upTo:10,perKwp:null},{upTo:30,perKwp:null},{upTo:Infinity,perKwp:null}],
hybrid:[{upTo:10,perKwp:null},{upTo:30,perKwp:null},{upTo:Infinity,perKwp:null}],
batteryPerKwh:null,
dn:[{upTo:100,perKwp:null},{upTo:500,perKwp:null},{upTo:1000,perKwp:null},{upTo:Infinity,perKwp:null}]
}
};
var HINT={
hoaluoi:'Nhà ít ở ban ngày khoảng 30%; ở nhà hoặc kinh doanh tại nhà khoảng 60–70%.',
hybrid:'Phần điện dùng ban đêm sẽ được lưu vào pin để dùng lại.',
dn:'Làm 1 ca ban ngày khoảng 80–90%; 2 ca khoảng 55%; 3 ca khoảng 35%.'
};
var ALL=['hoaluoi','hybrid','dn','bill'];
var EMPTY={solar:'Nhập tiền điện (hoặc số kWh) ở bên trái để xem kết quả tính toán.',bill:'Nhập số điện tiêu thụ (kWh) ở bên trái để tính tiền điện theo biểu giá EVN.'};
var TT={solar:['Tính nhanh hệ thống điện mặt trời cho nhà bạn','Nhập hóa đơn điện, nhận ngay công suất đề xuất, sản lượng, tiền tiết kiệm và thời gian hoàn vốn sơ bộ.'],bill:['Tính tiền điện theo biểu giá EVN','Nhập số điện tiêu thụ để biết hóa đơn mỗi tháng, rồi xem hệ thống điện mặt trời giúp giảm được bao nhiêu.'],mixed:['Tính tiền điện và hệ thống điện mặt trời phù hợp','Tính hóa đơn theo biểu giá EVN, hoặc nhập hóa đơn để nhận công suất đề xuất, tiền tiết kiệm và thời gian hoàn vốn sơ bộ.']};
function num(v){var n=Number(String(v==null?'':v).replace(/[^\d]/g,''));return isFinite(n)?n:0;}
function fmtInt(n){return Math.round(n).toLocaleString('vi-VN');}
function fmtDec(n,d){return n.toLocaleString('vi-VN',{minimumFractionDigits:d,maximumFractionDigits:d});}
function fmtMoney(n){var a=Math.abs(n);if(a>=1e9)return fmtDec(n/1e9,2)+' tỷ';if(a>=1e6)return fmtDec(n/1e6,a>=1e7?1:2)+' triệu';return fmtInt(n)+' đ';}
function fmtEnergy(k){if(k>=1e6)return fmtDec(k/1e6,2)+' GWh';if(k>=1e4)return fmtDec(k/1e3,1)+' MWh';return fmtInt(k)+' kWh';}
function costKwh(k){var prev=0,sum=0,t=CFG.tariff,i,ub,take;for(i=0;i<t.length;i++){ub=t[i][0];take=Math.min(k,ub)-prev;if(take>0)sum+=take*t[i][1];prev=ub;if(k<=ub)break;}return sum;}
function billKwh(k){return costKwh(k)*(1+CFG.vat);}
function kwhFromBill(b){var net=b/(1+CFG.vat),prev=0,t=CFG.tariff,i,seg;for(i=0;i<t.length;i++){seg=(t[i][0]-prev)*t[i][1];if(net<=seg||!isFinite(seg))return prev+net/t[i][1];net-=seg;prev=t[i][0];}return prev;}
function tierPrice(list,kwp){var i;for(i=0;i<list.length;i++){if(kwp<=list[i].upTo)return list[i].perKwp;}return list[list.length-1].perKwp;}
function pickInverter(ac){var L=[3,5,6,8,10,12,15,20,25,30,40,50,60,80,100,110],i;if(ac>110)return '~'+(Math.ceil(ac/10)*10)+' kW (ghép nhiều inverter)';for(i=0;i<L.length;i++){if(L[i]>=ac)return L[i]+' kW';}return '110 kW';}
function compute(i){
var C=CFG,d=C.daysPerMonth,y=C.yield[i.region]||C.yield.bac,mode=i.mode,hy=mode==='hybrid',dn=mode==='dn';
var kwh=i.kwh;
if(!(kwh>0))return null;
if(dn&&!(i.price>0))return null;
var ds=Math.min(1,Math.max(0,i.day));
var Dd=kwh*ds/d,Nd=kwh*(1-ds)/d,mf=C.matchFactor[mode],wp=C.panelWp;
var roofCap=i.roof>0?i.roof/C.areaPerKwp:Infinity;
var nt=C.hybridNightTarget,eff=C.battery.eff,dod=C.battery.dod,mod=C.battery.moduleKwh;
var recKwp,recBatt=0;
if(hy){recKwp=(Dd+Nd*nt/eff)/y;recBatt=Math.ceil(Nd*nt/(dod*eff)/mod)*mod;}
else{recKwp=Dd*mf/y;}
var recPanels=Math.max(1,Math.round(recKwp*1000/wp));
var maxPanels=roofCap===Infinity?Infinity:Math.max(1,Math.floor(roofCap*1000/wp));
var roofLimited=recPanels>maxPanels;
if(roofLimited)recPanels=maxPanels;
var panels=i.panels>0?i.panels:recPanels;
var kwp=panels*wp/1000;
var batt=hy?(i.batt!=null&&i.batt>=0?i.batt:recBatt):0;
var Pd=kwp*y,direct,stored=0,delivered=0,surplus;
if(hy){direct=Math.min(Pd,Dd);surplus=Pd-direct;stored=Math.min(surplus,batt*dod);delivered=Math.min(stored*eff,Nd);if(delivered<stored*eff)stored=delivered/eff;}
else{direct=Math.min(Pd,Dd*mf);}
var used=direct+delivered,unused=Math.max(0,Pd-direct-stored);
var Pm=Pd*d,Py=Pd*365,usedM=used*d;
var sav,billB=null,billA=null;
if(dn){sav=usedM*i.price;}
else{billB=billKwh(kwh);billA=billKwh(Math.max(0,kwh-usedM));sav=billB-billA+(mode==='hoaluoi'?unused*d*C.sellPrice:0);}
var capex=null,pr=C.prices,p;
if(dn){p=tierPrice(pr.dn,kwp);if(p!=null)capex=kwp*p;}
else if(hy){p=tierPrice(pr.hybrid,kwp);if(p!=null&&(batt===0||pr.batteryPerKwh!=null))capex=kwp*p+batt*(pr.batteryPerKwh||0);}
else{p=tierPrice(pr.hoaluoi,kwp);if(p!=null)capex=kwp*p;}
var om=capex!=null?capex*C.omPercent:0;
var cum=capex!=null?-capex:0,prevCum,series=[{year:0,cum:cum}],payback=null,sum20=0,P20=0,n,deg,esc,saveN;
for(n=1;n<=25;n++){
deg=Math.pow(1-C.degradation,n-1);esc=Math.pow(1+C.priceEscalation,n-1);
saveN=sav*12*deg*esc-om;prevCum=cum;cum+=saveN;series.push({year:n,cum:cum});
if(capex!=null&&payback==null&&cum>=0&&saveN>0){payback=(n-1)+(-prevCum)/saveN;}
if(n<=20){sum20+=saveN;P20+=Py*deg;}
}
if(capex!=null&&payback==null)payback=Infinity;
return {mode:mode,kwh:kwh,kwp:kwp,panels:panels,recPanels:recPanels,recBatt:recBatt,batt:batt,roofLimited:roofLimited,roofCap:roofCap,overRoof:roofCap!==Infinity&&kwp>roofCap+1e-9,
areaNeeded:kwp*C.areaPerKwp,inverter:pickInverter(kwp/C.acDc),Pd:Pd,Pm:Pm,Py:Py,P20:P20,usePct:Pd>0?used/Pd:0,
savMonth:sav,savYear:sav*12,sav20:sum20,billB:billB,billA:billA,capex:capex,payback:payback,series:series};
}
function evnLevels(t){var E=CFG.evn;return t==='kd'?E.kd:t==='sx'?E.sx:t==='yt'?E.yt:t==='cs'?E.cs:[];}
function computeBill(i){
var t=i.type,vat=i.vat,rows=[],sub=0,kwh=0,go=null,goKwh=0,goPrice=0,hos=1,L,b,prev,ub,lo,take,amt,T=CFG.tariff;
if(t==='sh'){
kwh=i.kwh;if(!(kwh>0))return null;
hos=Math.max(1,i.hos||1);prev=0;
for(b=0;b<T.length&&prev<kwh;b++){
ub=T[b][0]*hos;take=Math.min(kwh,ub)-prev;
if(take>0){amt=Math.round(take*T[b][1]);lo=prev;rows.push({label:'Bậc '+(b+1)+' ('+(ub===Infinity?(lo+1)+'+':(b===0?'0':(lo+1))+'–'+ub)+' kWh)',kwh:take,price:T[b][1],amt:amt});sub+=amt;}
prev=ub;
}
if(hos===1){go='hoaluoi';goKwh=kwh;}
}else{
L=evnLevels(t)[i.level];if(!L)return null;
if(t==='kd'||t==='sx'){
kwh=i.n+i.t+i.c;if(!(kwh>0))return null;
[['Giờ bình thường',i.n,L.bt],['Giờ thấp điểm',i.t,L.td],['Giờ cao điểm',i.c,L.cd]].forEach(function(x){if(x[1]>0){var a=Math.round(x[1]*x[2]);rows.push({label:x[0],kwh:x[1],price:x[2],amt:a});sub+=a;}});
goPrice=L.bt;
}else{
kwh=i.kwh;if(!(kwh>0))return null;
amt=Math.round(kwh*L.p);rows.push({label:'Giá điện, '+L.label.toLowerCase(),kwh:kwh,price:L.p,amt:amt});sub=amt;goPrice=L.p;
}
go='dn';goKwh=kwh;
}
var vatAmt=Math.round(sub*vat);
return {type:t,rows:rows,sub:sub,vat:vat,vatAmt:vatAmt,total:sub+vatAmt,kwh:kwh,avg:(sub+vatAmt)/kwh,go:go,goKwh:goKwh,goPrice:goPrice,hos:hos};
}
function renderBill(b,allow){
var h='',i,r,top;
h+='<div class="dvc-hero"><div><div class="k">Tiền điện phải trả (đã gồm VAT)</div><div class="v">'+fmtInt(b.total)+'<span>đồng</span></div></div><div class="s">'+fmtInt(b.kwh)+' kWh<br>bình quân '+fmtInt(b.avg)+' đ/kWh</div></div>';
h+='<div class="dvc-h">Chi tiết cách tính</div><div class="dvc-tblw"><table class="dvc-tbl"><thead><tr><th>Khoản mục</th><th>kWh</th><th>Đơn giá (đ)</th><th>Thành tiền (đ)</th></tr></thead><tbody>';
for(i=0;i<b.rows.length;i++){r=b.rows[i];h+='<tr><td>'+r.label+'</td><td>'+fmtInt(r.kwh)+'</td><td>'+fmtInt(r.price)+'</td><td>'+fmtInt(r.amt)+'</td></tr>';}
h+='<tr class="sum"><td colspan="3">Cộng tiền điện (chưa VAT)</td><td>'+fmtInt(b.sub)+'</td></tr><tr class="sum"><td colspan="3">Thuế GTGT ('+fmtDec(b.vat*100,0)+'%)</td><td>'+fmtInt(b.vatAmt)+'</td></tr><tr class="tot"><td colspan="3">Tổng cộng</td><td>'+fmtInt(b.total)+'</td></tr></tbody></table></div>';
if(b.type==='sh'&&b.rows.length>=3){top=b.rows[b.rows.length-1];h+='<div class="dvc-tip">Những kWh cuối cùng trong tháng đang bị tính giá <b>'+fmtInt(top.price*(1+b.vat))+' đ/kWh</b> (đã gồm VAT). Điện mặt trời tự dùng sẽ thay đúng phần điện đắt nhất này.</div>';}
else if(b.type==='kd'||b.type==='sx'){h+='<div class="dvc-tip">Điện mặt trời phát vào ban ngày, thay cho điện giờ bình thường ('+fmtInt(b.goPrice)+' đ/kWh chưa VAT) và một phần giờ cao điểm buổi sáng (9h30–11h30).</div>';}
if(b.go&&allow.indexOf(b.go)>=0){h+='<div class="dvc-cta"><a class="p" href="#" data-go="'+b.go+'" data-kwh="'+Math.round(b.goKwh)+'" data-price="'+b.goPrice+'">Tính điện mặt trời cho hóa đơn này</a><a class="s" href="'+CFG.contactUrl+'">Đăng ký khảo sát miễn phí</a></div>';}
else{h+='<div class="dvc-cta"><a class="p" href="'+CFG.contactUrl+'">Đăng ký khảo sát miễn phí</a><a class="s" href="tel:'+CFG.phone+'">Gọi '+CFG.phoneLabel+'</a><a class="s" href="'+CFG.zalo+'" target="_blank" rel="noopener">Chat Zalo</a></div>';}
h+='<p class="dvc-note">Biểu giá theo Quyết định 1279/QĐ-BCT ngày 09/5/2025 của Bộ Công Thương (nguồn thông tin: www.evn.com.vn). Số tiền mang tính tham khảo, chưa tính trường hợp đổi giá giữa kỳ, tiền công suất phản kháng và các khoản khác; hóa đơn chính thức do EVN phát hành.</p>';
return h;
}
function tile(l,v,u,s,c){return '<div class="dvc-tile '+(c||'')+'"><div class="dvc-tl">'+l+'</div><div class="dvc-tv">'+v+'</div>'+(u?'<div class="dvc-tu">'+u+'</div>':'')+(s?'<div class="dvc-ts">'+s+'</div>':'')+'</div>';}
function chart(r,cw){
var W=Math.max(300,Math.min(640,cw||640)),H=W<480?190:230,pl=W<480?54:64,pr=14,pt=14,pb=30,N=(r.payback!=null&&isFinite(r.payback)&&r.payback>20)?25:20,s=r.series.slice(0,N+1),i,mn=0,mx=0,v,out='',ticks,t;
for(i=0;i<s.length;i++){mn=Math.min(mn,s[i].cum);mx=Math.max(mx,s[i].cum);}
if(mx===mn)mx=mn+1;
var hasC=r.capex!=null,sp=mx-mn;if(hasC)mn-=sp*0.06;mx+=sp*0.06;
function X(k){return pl+(W-pl-pr)*k/N;}
function Y(val){return pt+(H-pt-pb)*(1-(val-mn)/(mx-mn));}
var d='';
for(i=0;i<s.length;i++){d+=(i?'L':'M')+X(s[i].year).toFixed(1)+' '+Y(s[i].cum).toFixed(1);}
out+='<svg viewBox="0 0 '+W+' '+H+'" role="img" aria-label="Biểu đồ dòng tiền tích lũy theo năm">';
ticks=hasC?[mn+(mx-mn)*0.06,0,mx-(mx-mn)*0.06]:[0,mx-(mx-mn)*0.06];
for(i=0;i<ticks.length;i++){t=ticks[i];out+='<line class="'+(t===0?'zero':'grid')+'" x1="'+pl+'" x2="'+(W-pr)+'" y1="'+Y(t).toFixed(1)+'" y2="'+Y(t).toFixed(1)+'"></line><text x="'+(pl-8)+'" y="'+(Y(t)+4).toFixed(1)+'" text-anchor="end">'+(t===0?'0':fmtMoney(t))+'</text>';}
for(v=0;v<=N;v+=5){out+='<text x="'+X(v).toFixed(1)+'" y="'+(H-10)+'" text-anchor="'+(v===N?'end':'middle')+'">'+(v===N?v+' năm':v)+'</text>';}
out+='<path class="ln" d="'+d+'"></path>';
if(r.payback!=null&&isFinite(r.payback)&&r.payback<=N){out+='<circle class="pb" cx="'+X(r.payback).toFixed(1)+'" cy="'+Y(0).toFixed(1)+'" r="6"></circle><text class="pbt" x="'+Math.min(X(r.payback)+10,W-90).toFixed(1)+'" y="'+(Y(0)-10).toFixed(1)+'">Hoàn vốn ~'+fmtDec(r.payback,1)+' năm</text>';}
out+='</svg>';
return out;
}
function render(r,cw){
var hy=r.mode==='hybrid',dn=r.mode==='dn',h='',hasCap=r.capex!=null,pbTxt;
h+='<div class="dvc-hero"><div><div class="k">Công suất đề xuất</div><div class="v">'+fmtDec(r.kwp,2)+'<span>kWp</span></div></div><div class="s">'+r.panels+' tấm × '+CFG.panelWp+'W<br>cần khoảng '+fmtInt(r.areaNeeded)+' m² mái</div></div>';
if(r.roofLimited)h+='<div class="dvc-warn">Diện tích mái bạn nhập giới hạn công suất ở mức này. Có thể cân nhắc mở rộng vị trí lắp đặt để tối ưu hơn.</div>';
if(r.overRoof)h+='<div class="dvc-warn">Công suất đang chọn lớn hơn diện tích mái khả dụng bạn nhập.</div>';
h+='<div class="dvc-tiles">';
h+=tile('Tiết kiệm mỗi tháng',fmtMoney(r.savMonth),'đồng/tháng',(r.billB!=null?'Tiền điện: '+fmtMoney(r.billB)+' → '+fmtMoney(r.billA):'Giảm tiền điện hằng tháng'),'good');
h+=tile('Tiết kiệm mỗi năm',fmtMoney(r.savYear),'đồng/năm','Tính theo sản lượng năm đầu','good');
if(hasCap){
pbTxt=isFinite(r.payback)?fmtDec(r.payback,1):'> 25';
h+=tile('Vốn đầu tư ước tính',fmtMoney(r.capex),'đồng','Chưa gồm chi phí phát sinh theo mái');
h+=tile('Thời gian hoàn vốn',pbTxt,'năm','Sau đó điện gần như miễn phí');
}else{
h+=tile('Vốn đầu tư ước tính','Liên hệ','báo giá','Cấu hình đã sẵn sàng để báo giá');
h+=tile('Thời gian hoàn vốn','Sau báo giá','','Kỹ sư gửi bảng hoàn vốn chi tiết');
}
h+='</div>';
h+='<div class="dvc-h">Sản lượng điện mặt trời</div><div class="dvc-prod">';
h+=tile('Mỗi tháng',fmtEnergy(r.Pm),'','~'+fmtDec(r.Pd,1)+' kWh/ngày');
h+=tile('Mỗi năm',fmtEnergy(r.Py),'','Năm đầu tiên');
h+=tile('Trong 20 năm',fmtEnergy(r.P20),'','Đã trừ suy giảm tấm pin '+fmtDec(CFG.degradation*100,1)+'%/năm');
h+='</div>';
h+='<div class="dvc-h">Cấu hình sơ bộ</div><ul class="dvc-cfg">';
h+='<li><span>Tấm pin</span><b>'+r.panels+' tấm '+CFG.panelWp+'W ('+fmtDec(r.kwp,2)+' kWp)</b></li>';
h+='<li><span>Biến tần (inverter)</span><b>'+(hy?'Hybrid ':'Hòa lưới ')+r.inverter+'</b></li>';
if(hy)h+='<li><span>Pin lưu trữ</span><b>'+(r.batt>0?fmtDec(r.batt,1)+' kWh':'Không dùng pin')+'</b></li>';
h+='<li><span>Tỷ lệ điện mặt trời được dùng</span><b>'+fmtInt(r.usePct*100)+'%</b></li>';
h+='<li><span>Tiêu thụ điện hiện tại</span><b>'+fmtInt(r.kwh)+' kWh/tháng</b></li>';
h+='</ul>';
h+='<div class="dvc-h">'+(hasCap?'Dòng tiền tích lũy (sau khi trừ vốn đầu tư)':'Tiền điện tiết kiệm tích lũy')+'</div><div class="dvc-chart">'+chart(r,cw-18)+'</div>';
h+='<div class="dvc-cta"><a class="p" href="'+CFG.contactUrl+'">Đăng ký khảo sát miễn phí</a><a class="s" href="tel:'+CFG.phone+'">Gọi '+CFG.phoneLabel+'</a><a class="s" href="'+CFG.zalo+'" target="_blank" rel="noopener">Chat Zalo</a></div>';
h+='<p class="dvc-note">Kết quả mang tính tham khảo sơ bộ, dựa trên bức xạ trung bình theo vùng'+(dn?'':', biểu giá điện sinh hoạt EVN hiện hành (6 bậc, VAT '+fmtInt(CFG.vat*100)+'%)')+(dn?', đơn giá điện bạn nhập (chưa VAT)':'')+' và chưa tính điện dư bán lên lưới. Cấu hình, báo giá và hoàn vốn chính thức được xác nhận sau khi kỹ sư khảo sát mái.</p>';
return h;
}
function initOne(el){
if(el.getAttribute('data-ready'))return;
el.setAttribute('data-ready','1');
var override=el.getAttribute('data-dvc-cfg');
if(override){try{var ov=JSON.parse(override);for(var k in ov){if(ov[k])CFG[k]=ov[k];}}catch(e){}}
function $(s){return el.querySelector(s);}
function $$(s){return [].slice.call(el.querySelectorAll(s));}
var F={},st={mode:'hoaluoi',panels:0,batt:null};
var allow=(el.getAttribute('data-tabs')||ALL.join(',')).split(',').map(function(s){return s.replace(/\s/g,'');}).filter(function(s){return ALL.indexOf(s)>=0;});
if(!allow.length)allow=ALL.slice();
$$('[data-f]').forEach(function(n){F[n.getAttribute('data-f')]=n;});
var out=$('[data-result]'),empty=$('[data-empty]'),adj=$('[data-adjust]'),battBox=$('[data-battbox]');
function oSet(k,t){var n=$('[data-o='+k+']');if(n)n.textContent=t;}
function fmtField(n){var v=num(n.value);n.value=v?v.toLocaleString('vi-VN'):'';}
function applyVis(){var m=st.mode,t=F.btype.value;$$('[data-show]').forEach(function(n){var ok=n.getAttribute('data-show').split(' ').indexOf(m)>=0,s;if(ok&&m==='bill'){s=n.getAttribute('data-sub');if(s)ok=s.split(' ').indexOf(t)>=0;}n.hidden=!ok;});}
function setTitle(){var mixed=allow.indexOf('bill')>=0&&allow.length>1,tt=mixed?TT.mixed:(st.mode==='bill'?TT.bill:TT.solar);oSet('title',tt[0]);oSet('sub',tt[1]);}
function fillLevels(){var L=evnLevels(F.btype.value),h='',j;for(j=0;j<L.length;j++){h+='<option value="'+j+'">'+L[j].label+'</option>';}F.blevel.innerHTML=h;}
function fillPset(){var h='<option value="">Chọn nhanh đơn giá theo biểu giá EVN (giờ bình thường)</option>',E=CFG.evn;E.sx.forEach(function(L){h+='<option value="'+L.bt+'">Sản xuất, '+L.label+': '+fmtInt(L.bt)+' đ/kWh</option>';});E.kd.forEach(function(L){h+='<option value="'+L.bt+'">Kinh doanh, '+L.label+': '+fmtInt(L.bt)+' đ/kWh</option>';});F.pset.innerHTML=h;}
function fillVat(){var vs=[CFG.vat],h='',j;[0.08,0.1].forEach(function(v){if(vs.indexOf(v)<0)vs.push(v);});for(j=0;j<vs.length;j++){h+='<option value="'+vs[j]+'">'+fmtDec(vs[j]*100,0)+'%'+(j===0?' (mặc định)':'')+'</option>';}F.bvat.innerHTML=h;}
function updateBill(){
var b=computeBill({type:F.btype.value,kwh:num(F.bkwh.value),hos:num(F.hos.value)||1,level:Number(F.blevel.value)||0,n:num(F.bkwhN.value),t:num(F.bkwhT.value),c:num(F.bkwhC.value),vat:Number(F.bvat.value)});
adj.hidden=true;
if(!b){out.hidden=true;empty.hidden=false;empty.textContent=EMPTY.bill;return;}
empty.hidden=true;out.hidden=false;out.innerHTML=renderBill(b,allow);
}
function goSolar(m,k,p){
if(m==='hoaluoi'){F.kwhR.value=k.toLocaleString('vi-VN');F.bill.value=Math.round(billKwh(k)).toLocaleString('vi-VN');}
else{F.kwhD.value=k.toLocaleString('vi-VN');F.price.value=p?p.toLocaleString('vi-VN'):'';F.pset.value='';}
setMode(m);
if(el.scrollIntoView)el.scrollIntoView({behavior:'smooth',block:'start'});
}
function setMode(m){
st.mode=m;st.panels=0;st.batt=null;
$$('[data-mode]').forEach(function(b){b.setAttribute('aria-selected',b.getAttribute('data-mode')===m?'true':'false');});
applyVis();setTitle();
if(m!=='bill'){F.day.value=CFG.defaultDay[m];oSet('day',CFG.defaultDay[m]+'%');oSet('dayhint',HINT[m]);}
update(true);
}
function read(){
var m=st.mode;
return {mode:m,kwh:m==='dn'?num(F.kwhD.value):num(F.kwhR.value),price:num(F.price.value),region:F.region.value,roof:num(F.roof.value),day:Number(F.day.value)/100,panels:st.panels,batt:st.batt};
}
function setupSliders(r){
var pmin=Math.max(1,Math.round(r.recPanels*0.5)),pmax=Math.max(pmin+1,Math.round(r.recPanels*1.5));
F.panels.min=pmin;F.panels.max=pmax;F.panels.step=1;F.panels.value=r.panels;
if(r.mode==='hybrid'){var bm=CFG.battery.moduleKwh;F.batt.min=0;F.batt.max=Math.max(r.recBatt*2,bm*2);F.batt.step=bm;F.batt.value=r.batt;}
}
function labels(r){
oSet('panels',r.panels+' tấm');
if(r.mode==='hybrid')oSet('batt',fmtDec(r.batt,1)+' kWh');
}
function update(reset){
if(st.mode==='bill'){updateBill();return;}
var i=read(),r=compute(i);
if(!r){out.hidden=true;adj.hidden=true;empty.hidden=false;empty.textContent=EMPTY.solar;return;}
if(reset){
st.panels=0;st.batt=null;i.panels=0;i.batt=null;r=compute(i);
setupSliders(r);
}
battBox.hidden=r.mode!=='hybrid';
adj.hidden=false;empty.hidden=true;out.hidden=false;
labels(r);
out.innerHTML=render(r,out.clientWidth||640);
}
$$('[data-mode]').forEach(function(b){b.addEventListener('click',function(){setMode(b.getAttribute('data-mode'));});});
F.bill.addEventListener('input',function(){var b=num(F.bill.value);F.kwhR.value=b?Math.round(kwhFromBill(b)).toLocaleString('vi-VN'):'';update(true);});
F.kwhR.addEventListener('input',function(){var k=num(F.kwhR.value);F.bill.value=k?Math.round(billKwh(k)).toLocaleString('vi-VN'):'';update(true);});
['kwhD','price','roof'].forEach(function(k){F[k].addEventListener('input',function(){update(true);});});
['bill','kwhR','kwhD','price','roof'].forEach(function(k){F[k].addEventListener('blur',function(){fmtField(F[k]);});});
F.region.addEventListener('change',function(){update(true);});
F.day.addEventListener('input',function(){oSet('day',F.day.value+'%');update(true);});
F.panels.addEventListener('input',function(){st.panels=Number(F.panels.value);update(false);});
F.batt.addEventListener('input',function(){st.batt=Number(F.batt.value);update(false);});
$('[data-reset]').addEventListener('click',function(){update(true);});
var lw=0;
window.addEventListener('resize',function(){var w=out.clientWidth;if(Math.abs(w-lw)>40){lw=w;if(!out.hidden)update(false);}});
$$('[data-mode]').forEach(function(b){b.hidden=allow.indexOf(b.getAttribute('data-mode'))<0;});
if(allow.length<2)$('[data-tabbar]').hidden=true;
fillLevels();fillPset();fillVat();
F.btype.addEventListener('change',function(){fillLevels();applyVis();update(true);});
['blevel','bvat'].forEach(function(k){F[k].addEventListener('change',function(){update(true);});});
['bkwh','hos','bkwhN','bkwhT','bkwhC'].forEach(function(k){F[k].addEventListener('input',function(){update(true);});F[k].addEventListener('blur',function(){fmtField(F[k]);});});
F.pset.addEventListener('change',function(){var v=Number(F.pset.value);if(v){F.price.value=v.toLocaleString('vi-VN');update(true);}});
out.addEventListener('click',function(e){var a=e.target.closest?e.target.closest('[data-go]'):null;if(!a)return;e.preventDefault();goSolar(a.getAttribute('data-go'),Number(a.getAttribute('data-kwh')),Number(a.getAttribute('data-price')));});
setMode(allow[0]);
}
root.DVSolarCalc={CFG:CFG,compute:compute,computeBill:computeBill,billKwh:billKwh,kwhFromBill:kwhFromBill};
if(typeof document!=='undefined'){
var boot=function(){[].slice.call(document.querySelectorAll('[data-dvc]')).forEach(initOne);};
if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',boot);else boot();
}
})(typeof window!=='undefined'?window:globalThis);
