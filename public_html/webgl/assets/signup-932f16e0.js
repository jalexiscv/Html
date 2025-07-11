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

System.register(["./chunk-vendor.js","./chunk-frameworks.js"],(function(){"use strict";var e,t,o;return{setters:[function(t){e=t.a},function(e){t=e.E,o=e.v}],execute:function(){function s(){const e=document.querySelector(".js-password-with-confirmation"),t=document.querySelector(".js-password-confirm");t.value!==e.value?function(e){const t=e.closest(".js-form-group");t.classList.add("errored");const s=e.getAttribute("data-validity-message");if(s){e.setCustomValidity(s);const t=e.closest("form");o(t)}const c=t.querySelector(".error"),r=e.getAttribute("data-error-message");if(!c&&r){const e=document.createElement("dd");e.classList.add("error"),e.innerHTML=r,t.appendChild(e)}}(t):function(e){const t=e.closest(".js-form-group");e.setCustomValidity(""),t.classList.remove("errored");const s=e.closest("form");o(s);const c=t.querySelector(".error");c&&t.removeChild(c)}(t)}t("keyup",".js-password-confirm",s),t("keyup",".js-password-with-confirmation",(()=>{""!==document.querySelector(".js-password-confirm").value&&s()})),e(".js-suggested-usernames-container",(function(e){const t=e.querySelectorAll(".js-suggested-username"),o=document.querySelector(".js-signup-form");if(o&&0!==t.length)for(const s of t)o.appendChild(s)})),e(".js-octocaptcha-parent",(function(e){const t=e.querySelector(".js-octocaptcha-spinner"),o=e.querySelector(".js-octocaptcha-success"),s=e.querySelector(".js-octocaptcha-token"),c=e.querySelector(".js-octocaptcha-form-submit"),r=e.querySelector(".js-octocaptcha-frame-container"),a=e.querySelector(".js-octocaptcha-frame"),n=s.getAttribute("data-octocaptcha-url"),d=s.getAttribute("data-octocaptcha-timeout"),i=d?parseInt(d):3e4;let u=!1;const l=()=>{u||(u=!0,t.classList.add("d-none"),o.classList.remove("d-none"),m())},p=()=>{if(u)return;const t=document.createElement("input");t.type="hidden",t.id="error_loading_captcha",t.name="error_loading_captcha",t.value="1",e.appendChild(t),s.required=!1,l()},m=()=>{e.checkValidity()&&(c.disabled=!1)};setTimeout(p,i),a.addEventListener("error",p),window.addEventListener("message",(e=>{if(e.origin!==n)return;const o=e.data&&e.data.event;var c;"captcha-loaded"===o?u||(u=!0,t.classList.add("d-none"),r.classList.remove("v-hidden","zero-height"),null===(c=a.contentWindow)||void 0===c||c.postMessage({event:"captcha-loaded-ack"},n||"")):"captcha-complete"===o?(s.value=e.data.sessionToken,m()):"captcha-suppressed"===o&&l()}))})),e(".js-plan-choice:checked",{add(e){const t=e.closest(".plan-row");t&&t.classList.add("selected")},remove(e){const t=e.closest(".plan-row");t&&t.classList.remove("selected")}})}}}));
//# sourceMappingURL=signup-f6199c6c.js.map
