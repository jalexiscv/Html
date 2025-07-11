/*
 * **
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ ░FRAMEWORK                                  2023-12-01 23:19:27
 *  ** █ ░█▀▀█ █▀▀█ █▀▀▄ █▀▀ ░█─░█ ─▀─ █▀▀▀ █▀▀▀ █▀▀ [App\Modules\Account\Views\Processes\Creator\deny.php]
 *  ** █ ░█─── █──█ █──█ █▀▀ ░█▀▀█ ▀█▀ █─▀█ █─▀█ ▀▀█ Copyright 2023 - CloudEngine S.A.S., Inc. <admin@cgine.com>
 *  ** █ ░█▄▄█ ▀▀▀▀ ▀▀▀─ ▀▀▀ ░█─░█ ▀▀▀ ▀▀▀▀ ▀▀▀▀ ▀▀▀ Para obtener información completa sobre derechos de autor y licencia,
 *  ** █                                             consulte la LICENCIA archivo que se distribuyó con este código fuente.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ EL SOFTWARE SE PROPORCIONA -TAL CUAL-, SIN GARANTÍA DE NINGÚN TIPO, EXPRESA O
 *  ** █ IMPLÍCITA, INCLUYENDO PERO NO LIMITADO A LAS GARANTÍAS DE COMERCIABILIDAD,
 *  ** █ APTITUD PARA UN PROPÓSITO PARTICULAR Y NO INFRACCIÓN. EN NINGÚN CASO SERÁ
 *  ** █ LOS AUTORES O TITULARES DE LOS DERECHOS DE AUTOR SERÁN RESPONSABLES DE CUALQUIER
 *  ** █ RECLAMO, DAÑOS U OTROS RESPONSABILIDAD, YA SEA EN UNA ACCIÓN DE CONTRATO,
 *  ** █ AGRAVIO O DE OTRO MODO, QUE SURJA DESDE, FUERA O EN RELACIÓN CON EL SOFTWARE
 *  ** █ O EL USO U OTROS NEGOCIACIONES EN EL SOFTWARE.
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @Author Jose Alexis Correa Valencia <jalexiscv@gmail.com>
 *  ** █ @link https://www.codehiggs.com
 *  ** █ @Version 1.5.0 @since PHP 7, PHP 8
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ Datos recibidos desde el controlador - @ModuleController
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  ** █ @authentication, @request, @dates, @parent, @component, @view, @oid, @views, @prefix
 *  ** █ ---------------------------------------------------------------------------------------------------------------------
 *  **
 */

System.register(["./chunk-vendor.js","./chunk-frameworks.js"],(function(){"use strict";var e,t,n,s,o,c,r,a;return{setters:[function(s){e=s.o,t=s.a,n=s.r},function(e){s=e.U,o=e.V,c=e.c,r=e.a_,a=e.a$}],execute:function(){function l(){document.body.classList.add("is-sending"),document.body.classList.remove("is-sent","is-not-sent")}function u(){document.body.classList.add("is-sent"),document.body.classList.remove("is-sending")}function d(e){e&&(document.querySelector(".js-sms-error").textContent=e),document.body.classList.add("is-not-sent"),document.body.classList.remove("is-sending")}e("details-menu-selected",".js-select-plan-menu",(function(e){const t=e.detail.relatedTarget,n=document.querySelectorAll(".js-plan-card-section");for(const r of n)r instanceof HTMLElement&&(r.hidden=!0);const s=e.currentTarget.querySelectorAll("[role^=menuitem]"),o=Array.from(s).indexOf(t),c=Array.from(n)[o];c instanceof HTMLElement&&(c.hidden=!1)}),{capture:!0}),t(".js-transform-notice",{constructor:HTMLElement,add(e){const t=s("org_transform_notice");for(const s of t){const t=document.createElement("span");try{t.textContent=atob(decodeURIComponent(s.value)),o(s.key),e.appendChild(t),e.hidden=!1}catch(n){}return}}}),n(".js-send-auth-code",(async(e,t)=>{let n;l();try{n=await t.text()}catch(s){d(s.response.text)}n&&u()})),e("click",".js-send-two-factor-code",(async function(e){const t=e.currentTarget,n=t.form,s=`${n.querySelector(".js-country-code-select").value} ${n.querySelector(".js-sms-number").value}`;l();const o=t.parentElement.querySelector(".js-data-url-csrf"),c=new FormData;c.append("number",s);const r=t.getAttribute("data-url"),a=await fetch(r,{method:"POST",mode:"same-origin",body:c,headers:{"Scoped-CSRF-Token":o.value,"X-Requested-With":"XMLHttpRequest"}});if(a.ok)u(),n.querySelector(".js-2fa-otp").focus();else{d(await a.text())}for(const l of n.querySelectorAll(".js-2fa-enable"))(l instanceof HTMLInputElement||l instanceof HTMLButtonElement)&&(l.disabled=!a.ok)})),e("click",".js-enable-enable-two-factor-auth-button",(function(){const e=document.querySelector(".js-enable-two-factor-auth-button");e.disabled=!1,e.removeAttribute("aria-label"),e.classList.remove("tooltipped")})),t(".js-two-factor-sms-fallback-button",(function(e){e.addEventListener("toggle",(function(e){const t=e.currentTarget;for(const n of t.querySelectorAll(".flash"))n instanceof HTMLElement&&(n.hidden=!0);t.querySelector(".js-configure-sms-fallback").hidden=!1,t.querySelector(".js-verify-sms-fallback").hidden=!0}))})),n(".js-two-factor-set-sms-fallback",(async(e,t)=>{let n;try{n=await t.text()}catch(s){const t=e.querySelector(".js-configure-sms-fallback"),n=e.querySelector(".js-verify-sms-fallback"),o=(t.hidden?n:t).querySelector(".flash");switch(s.response.status){case 422:case 429:o.textContent=s.response.text,o.hidden=!1}}if(n)switch(n.status){case 200:case 201:window.location.reload();break;case 202:e.querySelector(".js-configure-sms-fallback").hidden=!0,e.querySelector(".js-verify-sms-fallback").hidden=!1,e.querySelector(".js-fallback-otp").focus()}})),t(".js-webauthn-support",{constructor:HTMLInputElement,add(e){c(e,r())}}),t(".js-webauthn-iuvpaa-support",{constructor:HTMLInputElement,async add(e){c(e,await a())}})}}}));
//# sourceMappingURL=sessions-f6981f6d.js.map
