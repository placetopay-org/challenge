import{c as M,e as ct,w as dt,t as ft,n as G,r as k,f as ht,d as K,b as ot,V as F}from"./axios-DrmxFAda.js";import{V as gt}from"./laravel-vapor-CYz-MNB8.js";var pt={exports:{}},Y={exports:{}},z={exports:{}};/*!
  * Bootstrap data.js v5.3.3 (https://getbootstrap.com/)
  * Copyright 2011-2024 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */var X;function mt(){return X||(X=1,function(p,d){(function(e,c){p.exports=c()})(M,function(){const e=new Map;return{set(f,r,n){e.has(f)||e.set(f,new Map);const s=e.get(f);if(!s.has(r)&&s.size!==0){console.error(`Bootstrap doesn't allow more than one instance per element. Bound instance: ${Array.from(s.keys())[0]}.`);return}s.set(r,n)},get(f,r){return e.has(f)&&e.get(f).get(r)||null},remove(f,r){if(!e.has(f))return;const n=e.get(f);n.delete(r),n.size===0&&e.delete(f)}}})}(z)),z.exports}var B={exports:{}},U={exports:{}};/*!
  * Bootstrap index.js v5.3.3 (https://getbootstrap.com/)
  * Copyright 2011-2024 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */var Z;function H(){return Z||(Z=1,function(p,d){(function(e,c){c(d)})(M,function(e){const r="transitionend",n=t=>(t&&window.CSS&&window.CSS.escape&&(t=t.replace(/#([^\s"#']+)/g,(i,o)=>`#${CSS.escape(o)}`)),t),s=t=>t==null?`${t}`:Object.prototype.toString.call(t).match(/\s([a-z]+)/i)[1].toLowerCase(),b=t=>{do t+=Math.floor(Math.random()*1e6);while(document.getElementById(t));return t},h=t=>{if(!t)return 0;let{transitionDuration:i,transitionDelay:o}=window.getComputedStyle(t);const l=Number.parseFloat(i),m=Number.parseFloat(o);return!l&&!m?0:(i=i.split(",")[0],o=o.split(",")[0],(Number.parseFloat(i)+Number.parseFloat(o))*1e3)},y=t=>{t.dispatchEvent(new Event(r))},C=t=>!t||typeof t!="object"?!1:(typeof t.jquery<"u"&&(t=t[0]),typeof t.nodeType<"u"),N=t=>C(t)?t.jquery?t[0]:t:typeof t=="string"&&t.length>0?document.querySelector(n(t)):null,V=t=>{if(!C(t)||t.getClientRects().length===0)return!1;const i=getComputedStyle(t).getPropertyValue("visibility")==="visible",o=t.closest("details:not([open])");if(!o)return i;if(o!==t){const l=t.closest("summary");if(l&&l.parentNode!==o||l===null)return!1}return i},$=t=>!t||t.nodeType!==Node.ELEMENT_NODE||t.classList.contains("disabled")?!0:typeof t.disabled<"u"?t.disabled:t.hasAttribute("disabled")&&t.getAttribute("disabled")!=="false",I=t=>{if(!document.documentElement.attachShadow)return null;if(typeof t.getRootNode=="function"){const i=t.getRootNode();return i instanceof ShadowRoot?i:null}return t instanceof ShadowRoot?t:t.parentNode?I(t.parentNode):null},T=()=>{},w=t=>{t.offsetHeight},q=()=>window.jQuery&&!document.body.hasAttribute("data-bs-no-jquery")?window.jQuery:null,L=[],O=t=>{document.readyState==="loading"?(L.length||document.addEventListener("DOMContentLoaded",()=>{for(const i of L)i()}),L.push(t)):t()},x=()=>document.documentElement.dir==="rtl",u=t=>{O(()=>{const i=q();if(i){const o=t.NAME,l=i.fn[o];i.fn[o]=t.jQueryInterface,i.fn[o].Constructor=t,i.fn[o].noConflict=()=>(i.fn[o]=l,t.jQueryInterface)}})},a=(t,i=[],o=t)=>typeof t=="function"?t(...i):o,g=(t,i,o=!0)=>{if(!o){a(t);return}const m=h(i)+5;let _=!1;const v=({target:A})=>{A===i&&(_=!0,i.removeEventListener(r,v),a(t))};i.addEventListener(r,v),setTimeout(()=>{_||y(i)},m)},E=(t,i,o,l)=>{const m=t.length;let _=t.indexOf(i);return _===-1?!o&&l?t[m-1]:t[0]:(_+=o?1:-1,l&&(_=(_+m)%m),t[Math.max(0,Math.min(_,m-1))])};e.defineJQueryPlugin=u,e.execute=a,e.executeAfterTransition=g,e.findShadowRoot=I,e.getElement=N,e.getNextActiveElement=E,e.getTransitionDurationFromElement=h,e.getUID=b,e.getjQuery=q,e.isDisabled=$,e.isElement=C,e.isRTL=x,e.isVisible=V,e.noop=T,e.onDOMContentLoaded=O,e.parseSelector=n,e.reflow=w,e.toType=s,e.triggerTransitionEnd=y,Object.defineProperty(e,Symbol.toStringTag,{value:"Module"})})}(U,U.exports)),U.exports}/*!
  * Bootstrap event-handler.js v5.3.3 (https://getbootstrap.com/)
  * Copyright 2011-2024 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */var tt;function it(){return tt||(tt=1,function(p,d){(function(e,c){p.exports=c(H())})(M,function(e){const c=/[^.]*(?=\..*)\.|.*/,f=/\..*/,r=/::\d+$/,n={};let s=1;const b={mouseenter:"mouseover",mouseleave:"mouseout"},h=new Set(["click","dblclick","mouseup","mousedown","contextmenu","mousewheel","DOMMouseScroll","mouseover","mouseout","mousemove","selectstart","selectend","keydown","keypress","keyup","orientationchange","touchstart","touchmove","touchend","touchcancel","pointerdown","pointermove","pointerup","pointerleave","pointercancel","gesturestart","gesturechange","gestureend","focus","blur","change","reset","select","submit","focusin","focusout","load","unload","beforeunload","resize","move","DOMContentLoaded","readystatechange","error","abort","scroll"]);function y(u,a){return a&&`${a}::${s++}`||u.uidEvent||s++}function C(u){const a=y(u);return u.uidEvent=a,n[a]=n[a]||{},n[a]}function N(u,a){return function g(E){return x(E,{delegateTarget:u}),g.oneOff&&O.off(u,E.type,a),a.apply(u,[E])}}function V(u,a,g){return function E(t){const i=u.querySelectorAll(a);for(let{target:o}=t;o&&o!==this;o=o.parentNode)for(const l of i)if(l===o)return x(t,{delegateTarget:o}),E.oneOff&&O.off(u,t.type,a,g),g.apply(o,[t])}}function $(u,a,g=null){return Object.values(u).find(E=>E.callable===a&&E.delegationSelector===g)}function I(u,a,g){const E=typeof a=="string",t=E?g:a||g;let i=L(u);return h.has(i)||(i=u),[E,t,i]}function T(u,a,g,E,t){if(typeof a!="string"||!u)return;let[i,o,l]=I(a,g,E);a in b&&(o=(ut=>function(P){if(!P.relatedTarget||P.relatedTarget!==P.delegateTarget&&!P.delegateTarget.contains(P.relatedTarget))return ut.call(this,P)})(o));const m=C(u),_=m[l]||(m[l]={}),v=$(_,o,i?g:null);if(v){v.oneOff=v.oneOff&&t;return}const A=y(o,a.replace(c,"")),S=i?V(u,g,o):N(u,o);S.delegationSelector=i?g:null,S.callable=o,S.oneOff=t,S.uidEvent=A,_[A]=S,u.addEventListener(l,S,i)}function w(u,a,g,E,t){const i=$(a[g],E,t);i&&(u.removeEventListener(g,i,!!t),delete a[g][i.uidEvent])}function q(u,a,g,E){const t=a[g]||{};for(const[i,o]of Object.entries(t))i.includes(E)&&w(u,a,g,o.callable,o.delegationSelector)}function L(u){return u=u.replace(f,""),b[u]||u}const O={on(u,a,g,E){T(u,a,g,E,!1)},one(u,a,g,E){T(u,a,g,E,!0)},off(u,a,g,E){if(typeof a!="string"||!u)return;const[t,i,o]=I(a,g,E),l=o!==a,m=C(u),_=m[o]||{},v=a.startsWith(".");if(typeof i<"u"){if(!Object.keys(_).length)return;w(u,m,o,i,t?g:null);return}if(v)for(const A of Object.keys(m))q(u,m,A,a.slice(1));for(const[A,S]of Object.entries(_)){const D=A.replace(r,"");(!l||a.includes(D))&&w(u,m,o,S.callable,S.delegationSelector)}},trigger(u,a,g){if(typeof a!="string"||!u)return null;const E=e.getjQuery(),t=L(a),i=a!==t;let o=null,l=!0,m=!0,_=!1;i&&E&&(o=E.Event(a,g),E(u).trigger(o),l=!o.isPropagationStopped(),m=!o.isImmediatePropagationStopped(),_=o.isDefaultPrevented());const v=x(new Event(a,{bubbles:l,cancelable:!0}),g);return _&&v.preventDefault(),m&&u.dispatchEvent(v),v.defaultPrevented&&o&&o.preventDefault(),v}};function x(u,a={}){for(const[g,E]of Object.entries(a))try{u[g]=E}catch{Object.defineProperty(u,g,{configurable:!0,get(){return E}})}return u}return O})}(B)),B.exports}var Q={exports:{}},j={exports:{}};/*!
  * Bootstrap manipulator.js v5.3.3 (https://getbootstrap.com/)
  * Copyright 2011-2024 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */var et;function _t(){return et||(et=1,function(p,d){(function(e,c){p.exports=c()})(M,function(){function e(r){if(r==="true")return!0;if(r==="false")return!1;if(r===Number(r).toString())return Number(r);if(r===""||r==="null")return null;if(typeof r!="string")return r;try{return JSON.parse(decodeURIComponent(r))}catch{return r}}function c(r){return r.replace(/[A-Z]/g,n=>`-${n.toLowerCase()}`)}return{setDataAttribute(r,n,s){r.setAttribute(`data-bs-${c(n)}`,s)},removeDataAttribute(r,n){r.removeAttribute(`data-bs-${c(n)}`)},getDataAttributes(r){if(!r)return{};const n={},s=Object.keys(r.dataset).filter(b=>b.startsWith("bs")&&!b.startsWith("bsConfig"));for(const b of s){let h=b.replace(/^bs/,"");h=h.charAt(0).toLowerCase()+h.slice(1,h.length),n[h]=e(r.dataset[b])}return n},getDataAttribute(r,n){return e(r.getAttribute(`data-bs-${c(n)}`))}}})}(j)),j.exports}/*!
  * Bootstrap config.js v5.3.3 (https://getbootstrap.com/)
  * Copyright 2011-2024 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */var nt;function Et(){return nt||(nt=1,function(p,d){(function(e,c){p.exports=c(_t(),H())})(M,function(e,c){class f{static get Default(){return{}}static get DefaultType(){return{}}static get NAME(){throw new Error('You have to implement the static method "NAME", for each component!')}_getConfig(n){return n=this._mergeConfigObj(n),n=this._configAfterMerge(n),this._typeCheckConfig(n),n}_configAfterMerge(n){return n}_mergeConfigObj(n,s){const b=c.isElement(s)?e.getDataAttribute(s,"config"):{};return{...this.constructor.Default,...typeof b=="object"?b:{},...c.isElement(s)?e.getDataAttributes(s):{},...typeof n=="object"?n:{}}}_typeCheckConfig(n,s=this.constructor.DefaultType){for(const[b,h]of Object.entries(s)){const y=n[b],C=c.isElement(y)?"element":c.toType(y);if(!new RegExp(h).test(C))throw new TypeError(`${this.constructor.NAME.toUpperCase()}: Option "${b}" provided type "${C}" but expected type "${h}".`)}}}return f})}(Q)),Q.exports}/*!
  * Bootstrap base-component.js v5.3.3 (https://getbootstrap.com/)
  * Copyright 2011-2024 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */var rt;function bt(){return rt||(rt=1,function(p,d){(function(e,c){p.exports=c(mt(),it(),Et(),H())})(M,function(e,c,f,r){const n="5.3.3";class s extends f{constructor(h,y){super(),h=r.getElement(h),h&&(this._element=h,this._config=this._getConfig(y),e.set(this._element,this.constructor.DATA_KEY,this))}dispose(){e.remove(this._element,this.constructor.DATA_KEY),c.off(this._element,this.constructor.EVENT_KEY);for(const h of Object.getOwnPropertyNames(this))this[h]=null}_queueCallback(h,y,C=!0){r.executeAfterTransition(h,y,C)}_getConfig(h){return h=this._mergeConfigObj(h,this._element),h=this._configAfterMerge(h),this._typeCheckConfig(h),h}static getInstance(h){return e.get(r.getElement(h),this.DATA_KEY)}static getOrCreateInstance(h,y={}){return this.getInstance(h)||new this(h,typeof y=="object"?y:null)}static get VERSION(){return n}static get DATA_KEY(){return`bs.${this.NAME}`}static get EVENT_KEY(){return`.${this.DATA_KEY}`}static eventName(h){return`${h}${this.EVENT_KEY}`}}return s})}(Y)),Y.exports}var W={exports:{}};/*!
  * Bootstrap selector-engine.js v5.3.3 (https://getbootstrap.com/)
  * Copyright 2011-2024 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */var st;function vt(){return st||(st=1,function(p,d){(function(e,c){p.exports=c(H())})(M,function(e){const c=r=>{let n=r.getAttribute("data-bs-target");if(!n||n==="#"){let s=r.getAttribute("href");if(!s||!s.includes("#")&&!s.startsWith("."))return null;s.includes("#")&&!s.startsWith("#")&&(s=`#${s.split("#")[1]}`),n=s&&s!=="#"?s.trim():null}return n?n.split(",").map(s=>e.parseSelector(s)).join(","):null},f={find(r,n=document.documentElement){return[].concat(...Element.prototype.querySelectorAll.call(n,r))},findOne(r,n=document.documentElement){return Element.prototype.querySelector.call(n,r)},children(r,n){return[].concat(...r.children).filter(s=>s.matches(n))},parents(r,n){const s=[];let b=r.parentNode.closest(n);for(;b;)s.push(b),b=b.parentNode.closest(n);return s},prev(r,n){let s=r.previousElementSibling;for(;s;){if(s.matches(n))return[s];s=s.previousElementSibling}return[]},next(r,n){let s=r.nextElementSibling;for(;s;){if(s.matches(n))return[s];s=s.nextElementSibling}return[]},focusableChildren(r){const n=["a","button","input","textarea","select","details","[tabindex]",'[contenteditable="true"]'].map(s=>`${s}:not([tabindex^="-"])`).join(",");return this.find(n,r).filter(s=>!e.isDisabled(s)&&e.isVisible(s))},getSelectorFromElement(r){const n=c(r);return n&&f.findOne(n)?n:null},getElementFromSelector(r){const n=c(r);return n?f.findOne(n):null},getMultipleElementsFromSelector(r){const n=c(r);return n?f.find(n):[]}};return f})}(W)),W.exports}/*!
  * Bootstrap collapse.js v5.3.3 (https://getbootstrap.com/)
  * Copyright 2011-2024 The Bootstrap Authors (https://github.com/twbs/bootstrap/graphs/contributors)
  * Licensed under MIT (https://github.com/twbs/bootstrap/blob/main/LICENSE)
  */(function(p,d){(function(e,c){p.exports=c(bt(),it(),vt(),H())})(M,function(e,c,f,r){const n="collapse",b=".bs.collapse",h=".data-api",y=`show${b}`,C=`shown${b}`,N=`hide${b}`,V=`hidden${b}`,$=`click${b}${h}`,I="show",T="collapse",w="collapsing",q="collapsed",L=`:scope .${T} .${T}`,O="collapse-horizontal",x="width",u="height",a=".collapse.show, .collapse.collapsing",g='[data-bs-toggle="collapse"]',E={parent:null,toggle:!0},t={parent:"(null|element)",toggle:"boolean"};class i extends e{constructor(l,m){super(l,m),this._isTransitioning=!1,this._triggerArray=[];const _=f.find(g);for(const v of _){const A=f.getSelectorFromElement(v),S=f.find(A).filter(D=>D===this._element);A!==null&&S.length&&this._triggerArray.push(v)}this._initializeChildren(),this._config.parent||this._addAriaAndCollapsedClass(this._triggerArray,this._isShown()),this._config.toggle&&this.toggle()}static get Default(){return E}static get DefaultType(){return t}static get NAME(){return n}toggle(){this._isShown()?this.hide():this.show()}show(){if(this._isTransitioning||this._isShown())return;let l=[];if(this._config.parent&&(l=this._getFirstLevelChildren(a).filter(D=>D!==this._element).map(D=>i.getOrCreateInstance(D,{toggle:!1}))),l.length&&l[0]._isTransitioning||c.trigger(this._element,y).defaultPrevented)return;for(const D of l)D.hide();const _=this._getDimension();this._element.classList.remove(T),this._element.classList.add(w),this._element.style[_]=0,this._addAriaAndCollapsedClass(this._triggerArray,!0),this._isTransitioning=!0;const v=()=>{this._isTransitioning=!1,this._element.classList.remove(w),this._element.classList.add(T,I),this._element.style[_]="",c.trigger(this._element,C)},S=`scroll${_[0].toUpperCase()+_.slice(1)}`;this._queueCallback(v,this._element,!0),this._element.style[_]=`${this._element[S]}px`}hide(){if(this._isTransitioning||!this._isShown()||c.trigger(this._element,N).defaultPrevented)return;const m=this._getDimension();this._element.style[m]=`${this._element.getBoundingClientRect()[m]}px`,r.reflow(this._element),this._element.classList.add(w),this._element.classList.remove(T,I);for(const v of this._triggerArray){const A=f.getElementFromSelector(v);A&&!this._isShown(A)&&this._addAriaAndCollapsedClass([v],!1)}this._isTransitioning=!0;const _=()=>{this._isTransitioning=!1,this._element.classList.remove(w),this._element.classList.add(T),c.trigger(this._element,V)};this._element.style[m]="",this._queueCallback(_,this._element,!0)}_isShown(l=this._element){return l.classList.contains(I)}_configAfterMerge(l){return l.toggle=!!l.toggle,l.parent=r.getElement(l.parent),l}_getDimension(){return this._element.classList.contains(O)?x:u}_initializeChildren(){if(!this._config.parent)return;const l=this._getFirstLevelChildren(g);for(const m of l){const _=f.getElementFromSelector(m);_&&this._addAriaAndCollapsedClass([m],this._isShown(_))}}_getFirstLevelChildren(l){const m=f.find(L,this._config.parent);return f.find(l,this._config.parent).filter(_=>!m.includes(_))}_addAriaAndCollapsedClass(l,m){if(l.length)for(const _ of l)_.classList.toggle(q,!m),_.setAttribute("aria-expanded",m)}static jQueryInterface(l){const m={};return typeof l=="string"&&/show|hide/.test(l)&&(m.toggle=!1),this.each(function(){const _=i.getOrCreateInstance(this,m);if(typeof l=="string"){if(typeof _[l]>"u")throw new TypeError(`No method named "${l}"`);_[l]()}})}}return c.on(document,$,g,function(o){(o.target.tagName==="A"||o.delegateTarget&&o.delegateTarget.tagName==="A")&&o.preventDefault();for(const l of f.getMultipleElementsFromSelector(this))i.getOrCreateInstance(l,{toggle:!1}).toggle()}),r.defineJQueryPlugin(i),i})})(pt);let J;const at=60,R=ct({resend:!1,attemps:3,counter:at});dt(()=>R.counter,p=>{p===0&&clearInterval(J)});const lt=()=>{const p=()=>{d(),clearInterval(J),J=setInterval(()=>{R.counter--},1e3)},d=()=>{R.counter=at},e=()=>{R.resend=!0},c=()=>{R.resend=!1},f=()=>R.counter,r=()=>R.resend;return{...ft(R),startCountDown:p,enableResend:e,disableResend:c,getCounter:f,isResendable:r}},yt={props:{url:{type:String,default:null},acsTransId:{type:String,default:null},question:{type:String,default:null},label:{type:String,default:null},errorMessage:{type:String,default:null},completionMessage:{type:String,default:null}},setup(p){const d=k(!1),e=k(""),{enableResend:c,disableResend:f,startCountDown:r}=lt();return ht(()=>{const n=sessionStorage.getItem("transaction");!n||p.acsTransId!==n?axios.post(p.url,{acsTransId:p.acsTransId}).then(s=>{d.value=!0,e.value=s.data.error??p.question,c(),r()}).catch(()=>{f(),d.value=!0,e.value="<label>"+p.errorMessage+"</label>"}):(d.value=!0,e.value="<label>"+p.completionMessage+"</label>")}),{sent:d,message:e}}};var At=function(){var d=this,e=d._self._c;return e("div",[d.sent?e("div",{domProps:{innerHTML:d._s(d.message)}}):e("div",{staticClass:"text-center"},[e("div",{staticClass:"row mb-3"},[e("label",{staticClass:"label-detail"},[d._v(d._s(d.label))])]),e("img",{staticClass:"circle",attrs:{alt:d.label,src:d.asset("images/svg/spinner.svg")}})])])},Ct=[],St=G(yt,At,Ct,!1,null,null);const Tt=St.exports,wt={props:{url:{type:String,required:!0},acsTransId:{type:String,required:!0},buttonText:{type:String,required:!0},resendText:{type:String,required:!0},errorMessage:{type:String,required:!0}},setup(p){const d=k(""),e=k(4e3),c=k(!1),{getCounter:f,isResendable:r,startCountDown:n,disableResend:s}=lt(),b=K(()=>f()===0&&c.value===!1),h=K(()=>f()===0?p.buttonText:`${p.resendText} ${f()}`),y=K(()=>d.value.length>0);return{message:d,canResend:b,buttonContent:h,displayAlert:y,resend:()=>{f()===0&&(c.value=!0,axios.post(p.url,{acsTransId:p.acsTransId}).then(N=>{d.value=N.data.message,n()}).catch(N=>{s(),d.value=p.errorMessage,e.value=2e4}).finally(()=>{c.value=!1,setTimeout(()=>{d.value=""},e.value)}))},isResendable:r}}};var Dt=function(){var d=this,e=d._self._c;return e("div",[d.isResendable()?e("button",{staticClass:"form-control btn btn-outline-dark btn-xl mt-0 mb-2",attrs:{disabled:!d.canResend,role:"button"},on:{click:function(c){return c.preventDefault(),d.resend.apply(null,arguments)}}},[d._v(" "+d._s(d.buttonContent)+" ")]):d._e(),d.displayAlert?e("div",{staticClass:"alert alert-light text-center fw-bold",attrs:{role:"alert"}},[d._v(" "+d._s(d.message)+" ")]):d._e()])},It=[],Nt=G(wt,Dt,It,!1,null,null);const Lt=Nt.exports,Ot={name:"CheckNotifiedComponent",props:{transactionId:String},data(){return{intervals:[3e4,2e4,1e4],currentInterval:0,intervalId:null}},mounted(){this.startPolling()},beforeDestroy(){this.intervalId&&clearInterval(this.intervalId)},methods:{startPolling(){this.intervalId=setInterval(this.checkAuthStatus,this.intervals[this.currentInterval])},checkAuthStatus(){window.axios.post("/api/v1/check-notified-transaction/"+this.transactionId).then(p=>{p.data.status==="Y"?(clearInterval(this.intervalId),this.submitForm()):(clearInterval(this.intervalId),this.currentInterval<this.intervals.length-1&&this.currentInterval++,this.intervalId=setInterval(this.checkAuthStatus,this.intervals[this.currentInterval]))})},submitForm(){const p=document.getElementById("oob-form");p&&p.submit()}}};var Rt=function(){var d=this,e=d._self._c;return e("div")},Mt=[],xt=G(Ot,Rt,Mt,!1,null,null);const $t=xt.exports;var qt={BASE_URL:"/build/",MODE:"production",DEV:!1,PROD:!0,SSR:!1};ot.defaults.headers.common["X-Requested-With"]="XMLHttpRequest";window.axios=ot;window.Vapor=gt;window.Vapor.withBaseAssetUrl(qt.VITE_VAPOR_ASSET_URL);F.component("send-otp-component",Tt);F.component("resend-otp-component",Lt);F.component("check-notified-component",$t);F.mixin({methods:{asset:window.Vapor.asset}});window.app=new F({el:"#otp",name:"OTP"});
