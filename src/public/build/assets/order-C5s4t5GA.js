var e=e=>`Rp ${Math.round(Number(e)||0).toLocaleString(`id-ID`)}`,t=(e,t,n)=>{let r=e.querySelector(t);if(!r)return n;try{return JSON.parse(r.textContent||`null`)??n}catch{return n}},n=()=>{let n=document.querySelector(`[data-order-form]`);if(!n||n.dataset.orderBound===`true`)return;n.dataset.orderBound=`true`,t(n,`[data-order-catalog]`,[]);let r=t(n,`[data-order-categories]`,[]),i=t(n,`[data-order-old]`,{materials:[],sizes:[]}),a=n.querySelector(`[data-order-category]`),o=n.querySelector(`[data-order-product]`),s=document.getElementById(`category-unit-price`),c=n.querySelector(`[data-order-materials]`),l=n.querySelector(`[data-order-sizes]`),u=n.querySelector(`[data-order-total]`),d=new Set((i.materials||[]).map(String)),f={};(i.sizes||[]).forEach(e=>{e?.ukuran_id!=null&&(f[String(e.ukuran_id)]=e.kuantitas??0)});let p=e=>r.find(t=>String(t.id)===String(e)),m=()=>p(a?.value)??r[0],h=()=>{let e=Number(a?.selectedOptions?.[0]?.dataset?.price);return Number.isFinite(e)&&e>=0?e:Number(m()?.price)||0},g=()=>{let e={...f};return l?.querySelectorAll(`[data-ukuran-id]`).forEach(t=>{e[t.dataset.ukuranId]=t.querySelector(`input[type="number"]`)?.value??0}),e},_=e=>{if(!c)return;let t=e?.materials??[];if(!t.length){c.innerHTML=``;return}let r=d.size?d:new Set(Array.from(n.querySelectorAll(`input[name="materials[]"]:checked`)).map(e=>e.value));if(c.innerHTML=t.map(e=>{let t=r.has(String(e.id));return`
                    <label style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem 1rem;background:#FFFFFF;border:1px solid ${t?`#1C2430`:`#E2E5E9`};border-radius:10px;font-size:0.875rem;font-weight:600;color:#1C2430;cursor:pointer;transition:all 0.15s;">
                        <input type="checkbox" name="materials[]" value="${e.id}" style="accent-color:#1C2430;width:1rem;height:1rem;" ${t?`checked`:``}>
                        <span>${e.name}</span>
                    </label>
                `}).join(``),!c.querySelector(`input:checked`)){let e=c.querySelector(`input[type="checkbox"]`);e&&(e.checked=!0)}},v=e=>{if(!l)return;let t=g(),n=e??[];if(!n.length){l.innerHTML=`<p style="padding:1rem 1.25rem;font-size:0.875rem;color:#667085;">Ukuran untuk kategori ini belum diatur.</p>`;return}l.innerHTML=n.map((e,r)=>`
                <div
                    class="request-size-row"
                    data-ukuran-id="${e.id}"
                    style="display:flex;align-items:center;justify-content:space-between;height:68px;min-height:68px;padding:0 16px;background:#FFFFFF;${r<n.length-1?`border-bottom:1px solid #E2E5E9;`:``}"
                >
                    <input type="hidden" name="sizes[${r}][ukuran_id]" value="${e.id}">
                    <label style="font-size:0.9375rem;font-weight:600;color:#1C2430;cursor:pointer;" for="qty-${e.id}">${e.name}</label>
                    <input
                        id="qty-${e.id}"
                        type="number"
                        min="0"
                        step="1"
                        inputmode="numeric"
                        data-order-qty
                        name="sizes[${r}][kuantitas]"
                        value="${t[String(e.id)]??0}"
                        style="width:96px;height:42px;min-height:42px;border:1px solid #E2E5E9;border-radius:8px;background:#FFFFFF;padding:0 0.5rem;font-size:0.9375rem;font-weight:600;color:#1C2430;text-align:center;outline:none;"
                        onfocus="this.style.borderColor='#1C2430';this.style.background='#FFFFFF';"
                        onblur="this.style.borderColor='#E2E5E9';this.style.background='#FFFFFF';"
                    >
                </div>
            `).join(``)},y=()=>{let t=h();if(s&&(s.textContent=e(t)),!u)return;let r=[...n.querySelectorAll(`[data-order-qty], input[name*="[kuantitas]"]`)].reduce((e,t)=>e+Math.max(0,Number(t.value)||0),0);u.textContent=e(t*r)},b=()=>{let t=m();if(o&&t){let e=a?.selectedOptions?.[0]?.dataset?.productId||t.product_id||``;e&&(o.value=String(e))}s&&(s.textContent=e(h())),v(t?.sizes),_(t),y()};a?.addEventListener(`change`,()=>{d=new Set,b()}),n.addEventListener(`input`,y),n.addEventListener(`change`,e=>{e.target.matches(`[data-order-qty], input[name*="[kuantitas]"]`)&&y()}),n.addEventListener(`submit`,()=>{let e=m();if(o&&(!o.value||o.value===``)){let t=a?.selectedOptions?.[0]?.dataset?.productId||e?.product_id||``;t&&(o.value=String(t))}}),b(),window.FitVendorOrder={change(e){let t=r.find(t=>String(t.id)===String(e)||String(t.product_id)===String(e));return a&&t&&(a.value=String(t.id)),d=new Set,b(),!!t}}};document.readyState===`loading`?document.addEventListener(`DOMContentLoaded`,n):n();