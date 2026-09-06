var e=e=>`Rp ${Math.round(Number(e)||0).toLocaleString(`id-ID`)}`,t=(e,t,n)=>{let r=e.querySelector(t);if(!r)return n;try{return JSON.parse(r.textContent||`null`)??n}catch{return n}},n=()=>{let n=document.querySelector(`[data-order-form]`);if(!n||n.dataset.orderBound===`true`)return;n.dataset.orderBound=`true`;let r=t(n,`[data-order-catalog]`,[]),i=t(n,`[data-order-categories]`,[]),a=t(n,`[data-order-old]`,{materials:[],sizes:[]}),o=n.querySelector(`[data-order-category]`),s=n.querySelector(`[data-order-product]`),c=n.querySelector(`[data-order-product-wrap]`),l=n.querySelector(`[data-order-product-error]`),u=n.querySelector(`[data-order-materials]`),d=n.querySelector(`[data-order-sizes]`),f=n.querySelector(`[data-order-total]`),p=new Set((a.materials||[]).map(String)),m={};(a.sizes||[]).forEach(e=>{e?.ukuran_id!=null&&(m[String(e.ukuran_id)]=e.kuantitas??0)});let h=e=>r.find(t=>String(t.id)===String(e)),g=e=>i.find(t=>String(t.id)===String(e)),_=()=>g(o?.value)??i[0],v=e=>e?.products??[],y=e=>v(e).length>1,b=()=>h(s?.value),x=e=>{if(!c)return;let t=y(e);c.classList.toggle(`hidden`,!t),t?c.removeAttribute(`aria-hidden`):c.setAttribute(`aria-hidden`,`true`)},S=(e,t)=>{if(!s)return;let n=v(e),r=n.some(e=>String(e.id)===String(t))?String(t):``,i=y(e)&&r===``?`<option value="">Pilih salah satu</option>`:``;s.innerHTML=i+n.map(e=>{let t=h(e.id)?.price??0;return`<option value="${e.id}" data-price="${t}">${e.name}</option>`}).join(``),r===``?y(e)?s.value=``:s.value=String(n[0]?.id??``):s.value=r},C=()=>{let e={...m};return d?.querySelectorAll(`[data-ukuran-id]`).forEach(t=>{e[t.dataset.ukuranId]=t.querySelector(`input[type="number"]`)?.value??0}),e},w=e=>{if(!u)return;let t=e?.materials??[];if(!t.length){u.innerHTML=``;return}let r=p.size?p:new Set(Array.from(n.querySelectorAll(`input[name="materials[]"]:checked`)).map(e=>e.value));if(u.innerHTML=t.map(e=>{let t=r.has(String(e.id));return`
                    <label style="display:flex;align-items:center;gap:0.75rem;padding:0.75rem 1rem;background:#FFFFFF;border:1px solid ${t?`#1C2430`:`#E2E5E9`};border-radius:10px;font-size:0.875rem;font-weight:600;color:#1C2430;cursor:pointer;transition:all 0.15s;">
                        <input type="checkbox" name="materials[]" value="${e.id}" style="accent-color:#1C2430;width:1rem;height:1rem;" ${t?`checked`:``}>
                        <span>${e.name}</span>
                    </label>
                `}).join(``),!u.querySelector(`input:checked`)){let e=u.querySelector(`input[type="checkbox"]`);e&&(e.checked=!0)}},T=e=>{if(!d)return;let t=C(),n=e??[];if(!n.length){d.innerHTML=`<p style="padding:1rem 1.25rem;font-size:0.875rem;color:#667085;">Ukuran untuk kategori ini belum diatur.</p>`;return}d.innerHTML=n.map((e,r)=>`
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
            `).join(``)},E=()=>{if(typeof window.updateOrderEstimate==`function`){window.updateOrderEstimate();return}if(!f)return;let t=Number(b()?.price)||0,r=[...n.querySelectorAll(`[data-order-qty], input[name*="[kuantitas]"]`)].reduce((e,t)=>e+Math.max(0,Number(t.value)||0),0);f.textContent=e(t*r)},D=()=>{let e=_();x(e),T(e?.sizes),w(b()),E()};o?.addEventListener(`change`,()=>{p=new Set,l?.classList.add(`hidden`),S(_()),D()}),s?.addEventListener(`change`,()=>{p=new Set,l?.classList.add(`hidden`),D()}),n.addEventListener(`input`,E),n.addEventListener(`change`,e=>{e.target.matches(`[data-order-qty], input[name*="[kuantitas]"], [data-order-product]`)&&E()}),n.addEventListener(`submit`,e=>{s&&!s.value&&(e.preventDefault(),l?.classList.remove(`hidden`),s.focus())}),D(),window.FitVendorOrder={change(e){let t=h(e),n=i.find(t=>(t.products??[]).some(t=>String(t.id)===String(e)));return o&&n&&(o.value=String(n.id)),S(n??_(),e),p=new Set,l?.classList.add(`hidden`),D(),!!t}}};document.readyState===`loading`?document.addEventListener(`DOMContentLoaded`,n):n();