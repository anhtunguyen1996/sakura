var U=Object.defineProperty;var z=(s,e,r)=>e in s?U(s,e,{enumerable:!0,configurable:!0,writable:!0,value:r}):s[e]=r;var w=(s,e,r)=>(z(s,typeof e!="symbol"?e+"":e,r),r);import{_ as f}from"./js/_plugin-vue_export-helper.4292a25a.js";import{r as c,o as u,c as m,d as o,a as n,t as _,w as p,b as P,f as C,g as E,F as W,h as F,C as G,j as Y,E as I,x as V}from"./js/vue.runtime.esm-bundler.1bf81f69.js";import{c as Z,a as j}from"./js/vue-router.05c74492.js";import{l as q}from"./js/index.f62253a4.js";import{l as J}from"./js/index.cd7fac8b.js";import{l as K}from"./js/index.0b123ab1.js";import{j as L,s as D,a as Q,u as R,y as X,m as ss,l as es}from"./js/links.4e9269a4.js";import{i as T,s as M,h as ts,T as os}from"./js/postContent.164a8a2e.js";import{d as ns}from"./js/debounce.d062773b.js";import{A as H}from"./js/App.93196b03.js";import{_ as is}from"./js/default-i18n.41786823.js";import{e as as}from"./js/elemLoaded.9a6eb745.js";import{l as rs}from"./js/loadTruSeo.492f84f0.js";import{d as cs}from"./js/Caret.0b57d359.js";import{C as N}from"./js/SettingsRow.2432af31.js";import{B as ls}from"./js/Phone.f2ce89a4.js";import{C as ds}from"./js/Tabs.23866df2.js";import{B as _s}from"./js/Checkbox.1a2fc75a.js";import{B as us}from"./js/RadioToggle.6c005687.js";import{S as ps}from"./js/Settings.6e3cf579.js";import"./js/translations.f6b76bbe.js";import"./js/constants.a78fc4cb.js";import"./js/isArrayLikeObject.76f0d098.js";import"./js/cleanForSlug.10bf84e5.js";import"./js/toString.16b91dfe.js";import"./js/_baseTrim.8725856f.js";import"./js/_stringToArray.4de3b1f3.js";import"./js/html.3d4eb4ad.js";import"./js/get.d55c557c.js";import"./js/toNumber.2fce7e4f.js";/* empty css                */import"./js/allowed.11aae9a6.js";import"./js/params.f0608262.js";/* empty css                                               *//* empty css                                                 */import"./js/JsonValues.870a4901.js";/* empty css                                                 */import"./js/Row.1358a527.js";import"./js/LicenseKeyBar.1b5c44d1.js";import"./js/LogoGear.8ca170d6.js";import"./js/Portal.eef1ce3a.js";import"./js/Index.d52a1c7e.js";import"./js/TruSeoScore.177d3103.js";import"./js/MaxCounts.12b45bab.js";import"./js/Ellipse.ca34fa71.js";import"./js/Tags.bc14d949.js";import"./js/tags.9c0199b3.js";import"./js/Tooltip.fc81232d.js";import"./js/Plus.bd65010b.js";import"./js/Editor.87ec1d9f.js";import"./js/Blur.7ed1854b.js";import"./js/GoogleSearchPreview.45c17759.js";import"./js/HtmlTagsEditor.2a4955ac.js";import"./js/UnfilteredHtml.2d041b8c.js";import"./js/Slide.c4e68d01.js";import"./js/popup.6fe74774.js";import"./js/addons.b699e1f7.js";import"./js/upperFirst.65f07810.js";import"./js/Index.632f6288.js";import"./js/WpTable.623c3ca8.js";import"./js/Table.9759233a.js";import"./js/numbers.cd5a4c70.js";import"./js/PostTypes.9ab32454.js";import"./js/InternalOutbound.fa7c9832.js";import"./js/RequiredPlans.b62db276.js";import"./js/license.1ec1762f.js";import"./js/Image.db916bd7.js";import"./js/FacebookPreview.86376109.js";import"./js/Img.1587831b.js";import"./js/Profile.9b5df52d.js";import"./js/ImageUploader.9f5fb282.js";import"./js/TwitterPreview.dd33ac7c.js";import"./js/Book.067600d2.js";import"./js/Build.a21243d9.js";import"./js/Redirects.684b50e3.js";import"./js/Index.4b5cac99.js";import"./js/strings.03d6ae29.js";import"./js/isString.197b32a2.js";import"./js/ProBadge.5f8b58d0.js";import"./js/External.95afe855.js";import"./js/Exclamation.c5d4ba67.js";import"./js/Gear.a693d6ea.js";import"./js/Card.37225977.js";import"./js/Eye.186bb5fe.js";import"./js/Upsell.7e4e6ca5.js";import"./js/preload-helper.7cd2c8f9.js";import"./js/Information.379a165f.js";import"./js/Checkmark.20d31f86.js";const O=()=>{let e=L().currentPost.postStatus;return D()&&(e=window.wp.data.select("core/editor").getCurrentPostAttribute("status")),e};class ms{constructor(){w(this,"previousPostSlug");w(this,"previousPostStatus");w(this,"updatingRedirects",!1);w(this,"update",ns(()=>{const e=T(),r=O();if(this.previousPostSlug===e&&this.previousPostStatus===r)return;this.previousPostSlug=e,this.previousPostStatus=r,this.updatingRedirects=!0,ss().getPostRedirects({}).finally(()=>{this.updatingRedirects=!1})},2500));const e=Q(),r=R(),a=e.addons.find(t=>t.sku==="aioseo-redirects");!r.aioseo.currentPost||!a||!a.isActive||r.aioseo.redirectsWatcherSet||(this.initWatchers(),r.aioseo.redirectsWatcherSet=!0)}initWatchers(){if(!X()&&D()){const e=window.setInterval(()=>{window.wp.data.select("core/editor").getCurrentPost().id&&(window.clearInterval(e),this.previousPostSlug=T(),this.previousPostStatus=O(),this.watchBlockEditor())},50)}}watchBlockEditor(){window.wp.data.subscribe(()=>{this.updatingRedirects||this.update()})}}function hs(){const s="all-in-one-seo-pack";if(!D()||!M())return;const e=R();if(e.aioseo.registerScoreTogglerSet)return;e.aioseo.registerScoreTogglerSet=!0;const r=window.wp.plugins.registerPlugin,a=window.wp.editPost.PluginSidebarMoreMenuItem,t=window.wp.editPost.PluginSidebar,l=window.wp.element.Fragment,i=window.wp.element.createElement,d=e.aioseo.user.capabilities.aioseo_page_analysis,$=L().currentPost.seo_score,v=is("N/A",s),S=function(x){return!d||!ts()?"score-disabled":80<x?"score-green":50<x?"score-orange":1<x?"score-red":"score-disabled"},h=i("svg",{width:24,height:24,fill:"none",viewBox:"0 0 24 24",xmlns:"http://www.w3.org/2000/svg"},i("path",{d:"M11.9811 23.7877C18.5428 23.7877 23.8623 18.4684 23.8623 11.9066C23.8623 5.34477 18.5428 0.0253906 11.9811 0.0253906C5.41924 0.0253906 0.0998535 5.34477 0.0998535 11.9066C0.0998535 18.4684 5.41924 23.7877 11.9811 23.7877ZM10.0892 4.37389C9.92824 4.12859 9.6301 4.01391 9.35674 4.11048C9.04535 4.22048 8.74079 4.34987 8.44488 4.49781C8.18513 4.6277 8.05479 4.92439 8.11199 5.21372L8.31571 6.24468C8.36815 6.51003 8.25986 6.77935 8.0543 6.95044C7.72937 7.22084 7.42944 7.52654 7.16069 7.86489C6.99366 8.07521 6.73011 8.18668 6.46987 8.13409L5.45923 7.92995C5.17534 7.87259 4.88492 8.00678 4.75864 8.27251C4.68731 8.42264 4.61997 8.57591 4.55683 8.73224C4.49369 8.88855 4.43564 9.04574 4.38258 9.20355C4.28872 9.4829 4.40211 9.78694 4.64318 9.95035L5.50129 10.5321C5.72226 10.6819 5.8323 10.9505 5.80561 11.2198C5.76265 11.6532 5.76441 12.0857 5.80825 12.5112C5.83598 12.7804 5.72684 13.0494 5.5064 13.2L4.64996 13.785C4.40958 13.9493 4.29718 14.2535 4.3918 14.5324C4.49961 14.8502 4.62641 15.1609 4.7714 15.4629C4.89868 15.728 5.18943 15.8609 5.47301 15.8026L6.48336 15.5947C6.7434 15.5412 7.00735 15.6517 7.17499 15.8615C7.43997 16.193 7.73956 16.499 8.07114 16.7733C8.27723 16.9437 8.38649 17.2127 8.33498 17.4782L8.13487 18.5095C8.07868 18.7992 8.2102 19.0955 8.47059 19.2244C8.61773 19.2971 8.76793 19.3659 8.92112 19.4303C9.07434 19.4947 9.22835 19.5539 9.38302 19.6081C9.83552 19.7664 10.4688 19.1996 10.937 18.7805C11.1679 18.5738 11.3103 18.2813 11.3119 17.9682C11.3119 17.9665 11.3119 17.9648 11.3119 17.9632V16.2386C11.3119 16.2204 11.3125 16.2022 11.3139 16.1843C9.93098 15.847 8.90283 14.5775 8.90283 13.0629V11.2317C8.90283 11.0925 9.01342 10.9797 9.14984 10.9797H10.0064V9.17798C10.0064 8.92921 10.204 8.72754 10.4478 8.72754C10.6916 8.72754 10.8892 8.92921 10.8892 9.17798V10.9797H13.2067V9.17798C13.2067 8.92921 13.4043 8.72754 13.6481 8.72754C13.8919 8.72754 14.0895 8.92921 14.0895 9.17798V10.9797H14.9461C15.0825 10.9797 15.193 11.0925 15.193 11.2317V13.0629C15.193 14.6253 14.0989 15.927 12.6497 16.2135C12.6501 16.2218 12.6502 16.2302 12.6502 16.2386V17.9557C12.6502 18.275 12.7969 18.5727 13.0347 18.7801C13.5113 19.1958 14.1555 19.7576 14.6053 19.5987C14.9167 19.4887 15.2213 19.3593 15.5172 19.2113C15.7769 19.0814 15.9073 18.7848 15.8501 18.4954L15.6464 17.4644C15.5939 17.1991 15.7022 16.9298 15.9078 16.7587C16.2327 16.4883 16.5326 16.1826 16.8013 15.8442C16.9684 15.634 17.2319 15.5225 17.4922 15.575L18.5028 15.7792C18.7867 15.8366 19.0771 15.7024 19.2034 15.4366C19.2747 15.2865 19.3421 15.1333 19.4052 14.9769C19.4683 14.8206 19.5264 14.6634 19.5795 14.5056C19.6733 14.2263 19.5599 13.9222 19.3189 13.7588L18.4607 13.177C18.2398 13.0272 18.1297 12.7586 18.1564 12.4893C18.1994 12.056 18.1976 11.6234 18.1538 11.1979C18.1261 10.9287 18.2352 10.6598 18.4556 10.5092L19.3121 9.92409C19.5525 9.75989 19.6649 9.45566 19.5702 9.17674C19.4624 8.85899 19.3356 8.5482 19.1907 8.24628C19.0634 7.98121 18.7726 7.84823 18.489 7.90657L17.4787 8.11444C17.2187 8.16796 16.9547 8.05746 16.7871 7.84769C16.5221 7.51615 16.2225 7.2101 15.8909 6.93588C15.6848 6.76543 15.5756 6.49649 15.6271 6.23094L15.8272 5.19968C15.8834 4.90999 15.7519 4.61365 15.4914 4.48481C15.3443 4.412 15.1941 4.34331 15.0409 4.27886C14.8877 4.21444 14.7337 4.1552 14.579 4.10107C14.3053 4.00526 14.0073 4.12099 13.8472 4.36697L13.277 5.24259C13.1302 5.46808 12.867 5.58035 12.6031 5.55312C12.1784 5.5093 11.7545 5.51109 11.3375 5.55581C11.0737 5.58411 10.8101 5.47276 10.6625 5.24782L10.0892 4.37389Z",fillRule:"evenodd",clipRule:"evenodd",fill:"#005AE0"})),g=i("div",{id:"aioseo-post-settings-sidebar-button",className:S($)},h,i("span",{id:"aioseo-post-score-disabled"},v),i("span",{id:"aioseo-post-score"},$),i("span",{},"/100")),b=e.aioseo.user;r("aioseo-post-settings-sidebar",{render:function(){return!b.capabilities.aioseo_page_analysis&&!b.capabilities.aioseo_page_general_settings&&!b.capabilities.aioseo_page_social_settings&&!b.capabilities.aioseo_page_schema_settings&&!b.capabilities.aioseo_page_advanced_settings?null:i(l,{},i(a,{target:"aioseo-post-settings-sidebar",icon:h},"AIOSEO"),i(t,{name:"aioseo-post-settings-sidebar",icon:g,title:"AIOSEO"},i("div",{id:"aioseo-post-settings-sidebar",className:"aioseo-post-settings-sidebar"},i("div",{id:"aioseo-post-settings-sidebar-vue",className:"aioseo-post-settings-sidebar-vue"},i("div",{className:"aioseo-loading-spinner dark",style:{left:0,right:0,margin:"30px auto"}},i("div",{className:"double-bounce1"},null),i("div",{className:"double-bounce2"},null))))))}})}const gs={data(){return{strings:{areaServedDescription:this.$t.__("The geographic area where a service or offered item is provided.",this.$td)}}}},fs={class:"aioseo-col col-xs-12 text-xs-left"},bs={class:"field-description"};function $s(s,e,r,a,t,l){const i=c("base-input");return u(),m("div",fs,[o(i,{type:"text",size:"medium"}),n("span",bs,_(t.strings.areaServedDescription),1)])}const vs=f(gs,[["render",$s],["__scopeId","data-v-edba6303"]]);const Ss={data(){return{strings:{streetAddress:this.$t.__("Address Line 1",this.$td),streetAddress2:this.$t.__("Address Line 2",this.$td),zipCode:this.$t.__("Zip Code",this.$td),city:this.$t.__("City",this.$td),state:this.$t.__("State",this.$td),country:this.$t.__("Country",this.$td)}}}},ys={class:"columns field-row"},xs={class:"aioseo-col col-xs-12 text-xs-left"},ws={class:"field-description"},Cs={class:"aioseo-col col-xs-12 text-xs-left"},Ps={class:"field-description mt-8"},Ls={class:"aioseo-address-wrapper"},Es={class:"aioseo-col col-xs-12 col-sm-12 col-md-4 text-xs-left"},As={class:"field-description mt-8"},Is={class:"aioseo-col col-xs-12 col-sm-12 col-md-4 text-xs-left"},Vs={class:"field-description mt-8"},Ds={class:"aioseo-col col-xs-12 col-sm-12 col-md-4 text-xs-left"},Hs={class:"field-description mt-8"},Bs={class:"aioseo-col col-xs-12 col-sm-6 text-xs-left"},Ts={class:"field-description mt-8"};function Os(s,e,r,a,t,l){const i=c("base-input"),d=c("base-select");return u(),m("div",ys,[n("div",xs,[n("span",ws,_(t.strings.streetAddress),1),o(i,{type:"text",size:"medium"})]),n("div",Cs,[n("span",Ps,_(t.strings.streetAddress2),1),o(i,{type:"text",size:"medium"})]),n("div",Ls,[n("div",Es,[n("span",As,_(t.strings.zipCode),1),o(i,{type:"text",size:"medium"})]),n("div",Is,[n("span",Vs,_(t.strings.city),1),o(i,{type:"text",size:"medium"})]),n("div",Ds,[n("span",Hs,_(t.strings.state),1),o(i,{type:"text",size:"medium"})])]),n("div",Bs,[n("span",Ts,_(t.strings.country),1),o(d,{size:"medium",options:s.$constants.COUNTRY_LIST},null,8,["options"])])])}const ks=f(Ss,[["render",Os],["__scopeId","data-v-bf2b69da"]]);const Rs={components:{BasePhone:ls},data(){return{strings:{emailAddress:this.$t.__("Email Address",this.$td),phoneNumber:this.$t.__("Phone Number",this.$td),faxNumber:this.$t.__("Fax Number",this.$td)}}}},Ms={class:"aioseo-col col-xs-12 text-xs-left"},Ns={class:"field-description"},Us={class:"aioseo-col col-xs-12 text-xs-left"},zs={class:"field-description mt-8"},Ws={class:"aioseo-col col-xs-12 text-xs-left"},Fs={class:"field-description mt-8"};function Gs(s,e,r,a,t,l){const i=c("base-input"),d=c("base-phone");return u(),m("div",null,[n("div",Ms,[n("span",Ns,_(t.strings.emailAddress),1),o(i,{type:"text",size:"medium"})]),n("div",Us,[n("span",zs,_(t.strings.phoneNumber),1),o(d)]),n("div",Ws,[n("span",Fs,_(t.strings.faxNumber),1),o(d)])])}const Ys=f(Rs,[["render",Gs],["__scopeId","data-v-b7e41a38"]]);const Zs={data(){return{strings:{vatID:this.$t.__("VAT ID:",this.$td),taxID:this.$t.__("Tax ID:",this.$td)}}}},js={class:"aioseo-col col-xs-12 text-xs-left"},qs={class:"field-description"},Js={class:"aioseo-col col-xs-12 text-xs-left"},Ks={class:"field-description mt-8"};function Qs(s,e,r,a,t,l){const i=c("base-input");return u(),m("div",null,[n("div",js,[n("span",qs,_(t.strings.vatID),1),o(i,{type:"text",size:"medium"})]),n("div",Js,[n("span",Ks,_(t.strings.taxID),1),o(i,{type:"text",size:"medium"})])])}const Xs=f(Zs,[["render",Qs],["__scopeId","data-v-16be9b8e"]]),se={data(){return{strings:{businessType:this.$t.__("Type",this.$td)}}}};function ee(s,e,r,a,t,l){const i=c("base-select");return u(),m("div",null,[o(i,{size:"large",options:s.$constants.LOCAL_SEO_BUSINESS_TYPES},null,8,["options"])])}const te=f(se,[["render",ee]]),oe={};function ne(s,e){return u(),m("div")}const ie=f(oe,[["render",ne]]),ae={};function re(s,e){return u(),m("div")}const ce=f(ae,[["render",re]]);const le={data(){return{strings:{name:this.$t.__("name",this.$td),nameDesc:this.$t.__("Your name or company name.",this.$td)}}}},de={class:"aioseo-col col-xs-12 text-xs-left"},_e={class:"field-description"};function ue(s,e,r,a,t,l){const i=c("base-input");return u(),m("div",de,[o(i,{type:"text",size:"medium"}),n("span",_e,_(t.strings.nameDesc),1)])}const pe=f(le,[["render",ue],["__scopeId","data-v-0f8f3d3c"]]);const me={data(){return{currencies:this.$constants.CURRENCY_LIST,strings:{priceIndicator:this.$t.__("Price Indicator",this.$td),currenciesAccepted:this.$t.__("Currencies Accepted",this.$td),paymentMethods:this.$t.__("Payment Methods Accepted",this.$td)}}}},he={class:"aioseo-col col-xs-12 text-xs-left"},ge={class:"field-description"},fe={class:"aioseo-col col-xs-12 text-xs-left"},be={class:"field-description mt-8"},$e={class:"aioseo-col col-xs-12 text-xs-left"},ve={class:"field-description mt-8"};function Se(s,e,r,a,t,l){const i=c("base-select"),d=c("base-input");return u(),m("div",null,[n("div",he,[n("span",ge,_(t.strings.priceIndicator),1),o(i,{size:"medium",options:t.currencies},null,8,["options"])]),n("div",fe,[n("span",be,_(t.strings.currenciesAccepted),1),o(i,{size:"medium",label:"currenciesAccepted","track-by":"value",class:"aioseo-multiselect",options:t.currencies,multiple:""},null,8,["options"])]),n("div",$e,[n("span",ve,_(t.strings.paymentMethods),1),o(d,{type:"text",size:"medium"})])])}const ye=f(me,[["render",Se],["__scopeId","data-v-eae40702"]]);const xe={components:{CoreSettingsRow:N,LocalBusinessAreaServed:vs,LocalBusinessBusinessAddress:ks,LocalBusinessBusinessContact:Ys,LocalBusinessBusinessIds:Xs,LocalBusinessBusinessType:te,LocalBusinessImage:ie,LocalBusinessMap:ce,LocalBusinessName:pe,LocalBusinessPaymentInfo:ye},data(){return{strings:{pageName:this.$t.__("Business Info",this.$td),name:this.$t.__("Name",this.$td),businessType:this.$t.__("Type",this.$td),image:this.$t.__("Image",this.$td),urls:this.$t.__("URLs",this.$td),websiteDesc:this.$t.__("Website URL",this.$td),aboutDesc:this.$t.__("About Page URL",this.$td),contactDesc:this.$t.__("Contact Page URL",this.$td),businessAddress:this.$t.__("Address",this.$td),businessContact:this.$t.__("Contact Info",this.$td),businessIDs:this.$t.__("IDs",this.$td),paymentInfo:this.$t.__("Payment Info",this.$td),areaServed:this.$t.__("Area Served",this.$td),map:this.$t.__("Map",this.$td)}}}},we={class:"aioseo-tab-content aioseo-localseo-info"};function Ce(s,e,r,a,t,l){const i=c("local-business-name"),d=c("core-settings-row"),y=c("local-business-business-type"),$=c("local-business-image"),v=c("local-business-business-address"),S=c("local-business-map"),h=c("local-business-business-contact"),g=c("local-business-business-ids"),b=c("local-business-payment-info"),x=c("local-business-area-served");return u(),m("div",we,[o(d,{name:t.strings.name,class:"info-name-row",align:""},{content:p(()=>[o(i)]),_:1},8,["name"]),o(d,{name:t.strings.businessType,class:"info-business-type",align:""},{content:p(()=>[o(y)]),_:1},8,["name"]),o(d,{class:"info-business-image",name:t.strings.image,align:""},{content:p(()=>[o($)]),_:1},8,["name"]),o(d,{name:t.strings.businessAddress,class:"info-businessaddress-row",align:""},{content:p(()=>[o(v)]),_:1},8,["name"]),o(d,{name:t.strings.map,align:""},{content:p(()=>[o(S)]),_:1},8,["name"]),o(d,{name:t.strings.businessContact,class:"info-businesscontact-row",align:""},{content:p(()=>[o(h)]),_:1},8,["name"]),o(d,{name:t.strings.businessIDs,class:"info-businessids-row",align:""},{content:p(()=>[o(g)]),_:1},8,["name"]),o(d,{name:t.strings.paymentInfo,class:"info-paymentinfo-row",align:""},{content:p(()=>[o(b)]),_:1},8,["name"]),o(d,{name:t.strings.areaServed,class:"info-area-row",align:""},{content:p(()=>[o(x)]),_:1},8,["name"])])}const Pe=f(xe,[["render",Ce]]);const Le={setup(){return{postEditorStore:L()}},components:{BaseCheckbox:_s,BaseRadioToggle:us,CoreSettingsRow:N},data(){return{selectTimezone:[{value:"none",label:this.$t.__("Select your timezone",this.$td)}],strings:{pageName:this.$t.__("Opening Hours",this.$td),useDefaults:this.$t.__("Use Defaults",this.$td),useDefaultsDesc:this.$t.__("Will default opening hours set globally",this.$td),showOpeningHours:this.$t.__("Show Opening Hours",this.$td),labels:this.$t.__("Labels",this.$td),closedLabel:this.$t.__("Closed",this.$td),closedLabelDesc:this.$t.__("Displayed when the business is closed.",this.$td),closed:this.$t.__("Closed",this.$td),settings:this.$t.__("Settings",this.$td),open24h:this.$t.__("Open 24h",this.$td),open24Label:this.$t.__("Open 24h",this.$td),open24LabelDesc:this.$t.__("Displayed when the business is open all day long.",this.$td),alwaysOpen:this.$t.__("Open 24/7",this.$td),use24hFormat:this.$t.__("Use 24h format",this.$td),twoSets:this.$t.__("I have two sets of opening hours per day",this.$td),timezone:this.$t.__("Timezone",this.$td),hours:this.$t.__("Hours",this.$td)},weekdays:{monday:this.$t.__("Monday",this.$td),tuesday:this.$t.__("Tuesday",this.$td),wednesday:this.$t.__("Wednesday",this.$td),thursday:this.$t.__("Thursday",this.$td),friday:this.$t.__("Friday",this.$td),saturday:this.$t.__("Saturday",this.$td),sunday:this.$t.__("Sunday",this.$td)}}},computed:{toggled:function(){return!0},unToggled:function(){return!1},closedLabel:{get(){return this.postEditorStore.currentPost.local_seo.openingHours.closedLabel},set(s){this.postEditorStore.currentPost.local_seo.openingHours.closedLabel=s}}},methods:{getSelectOptions(s){return this.postEditorStore.currentPost.local_seo.openingHours.use24hFormat?this.$constants.HOURS_24H_FORMAT.find(e=>e.value===s):this.$constants.HOURS_12H_FORMAT.find(e=>e.value===s)},saveDay(s,e,r){this.postEditorStore.currentPost.local_seo.openingHours.days[s][e]=r},getWeekDay(s){return this.postEditorStore.currentPost.local_seo.openingHours.days[s]}}},Ee={class:"aioseo-tab-content aioseo-localseo-opening"},Ae={class:"aioseo-col col-xs-12 text-xs-left"},Ie={key:0},Ve={class:"aioseo-col col-xs-12 text-xs-left"},De={class:"aioseo-col col-xs-12 text-xs-left"},He={class:"field-description"},Be={class:"field-description mt-10"},Te={class:"aioseo-col col-xs-12 text-xs-left"},Oe={class:"field-description mt-8"},ke={class:"field-description mt-10"},Re={class:"aioseo-col col-xs-12 text-xs-left"},Me={class:"aioseo-col col-xs-12 text-xs-left"},Ne={class:"aioseo-col col-xs-12 text-xs-left"},Ue={class:"aioseo-col-day text-xs-left"},ze={class:"aioseo-col-hours text-xs-left"},We=n("span",{class:"separator"},"-",-1),Fe={class:"aioseo-col-alwaysopen text-xs-left"};function Ge(s,e,r,a,t,l){const i=c("base-radio-toggle"),d=c("core-settings-row"),y=c("base-input"),$=c("base-toggle"),v=c("base-select"),S=c("base-checkbox");return u(),m("div",Ee,[o(d,{name:t.strings.useDefaults,align:""},{content:p(()=>[n("div",Ae,[o(i,{name:"useDefaults",modelValue:a.postEditorStore.currentPost.local_seo.openingHours.useDefaults,"onUpdate:modelValue":e[0]||(e[0]=h=>a.postEditorStore.currentPost.local_seo.openingHours.useDefaults=h),options:[{label:s.$constants.GLOBAL_STRINGS.no,value:!1},{label:s.$constants.GLOBAL_STRINGS.yes,value:!0}]},null,8,["modelValue","options"])])]),_:1},8,["name"]),a.postEditorStore.currentPost.local_seo.openingHours.useDefaults?C("",!0):(u(),m("div",Ie,[o(d,{name:t.strings.showOpeningHours,class:"info-openinghours-row",align:""},{content:p(()=>[n("div",Ve,[o(i,{name:"openingHours",modelValue:a.postEditorStore.currentPost.local_seo.openingHours.show,"onUpdate:modelValue":e[1]||(e[1]=h=>a.postEditorStore.currentPost.local_seo.openingHours.show=h),options:[{label:s.$constants.GLOBAL_STRINGS.no,value:!1},{label:s.$constants.GLOBAL_STRINGS.yes,value:!0}]},null,8,["modelValue","options"])])]),_:1},8,["name"]),a.postEditorStore.currentPost.local_seo.openingHours.show?(u(),P(d,{key:0,name:t.strings.labels,class:"info-labels-row",align:""},{content:p(()=>[n("div",De,[n("span",He,_(t.strings.closedLabel),1),o(y,{type:"text",size:"medium",modelValue:a.postEditorStore.currentPost.local_seo.openingHours.labels.closed,"onUpdate:modelValue":e[2]||(e[2]=h=>a.postEditorStore.currentPost.local_seo.openingHours.labels.closed=h)},null,8,["modelValue"]),n("span",Be,_(t.strings.closedLabelDesc),1)]),n("div",Te,[n("span",Oe,_(t.strings.open24Label),1),o(y,{size:"medium",modelValue:a.postEditorStore.currentPost.local_seo.openingHours.labels.alwaysOpen,"onUpdate:modelValue":e[3]||(e[3]=h=>a.postEditorStore.currentPost.local_seo.openingHours.labels.alwaysOpen=h)},null,8,["modelValue"]),n("span",ke,_(t.strings.open24LabelDesc),1)])]),_:1},8,["name"])):C("",!0),a.postEditorStore.currentPost.local_seo.openingHours.show?(u(),P(d,{key:1,name:t.strings.settings,class:"info-settings-row",align:""},{content:p(()=>[n("div",Re,[o($,{modelValue:a.postEditorStore.currentPost.local_seo.openingHours.alwaysOpen,"onUpdate:modelValue":e[4]||(e[4]=h=>a.postEditorStore.currentPost.local_seo.openingHours.alwaysOpen=h)},{default:p(()=>[E(_(t.strings.alwaysOpen),1)]),_:1},8,["modelValue"])]),n("div",Me,[o($,{modelValue:a.postEditorStore.currentPost.local_seo.openingHours.use24hFormat,"onUpdate:modelValue":e[5]||(e[5]=h=>a.postEditorStore.currentPost.local_seo.openingHours.use24hFormat=h)},{default:p(()=>[E(_(t.strings.use24hFormat),1)]),_:1},8,["modelValue"])])]),_:1},8,["name"])):C("",!0),a.postEditorStore.currentPost.local_seo.openingHours.show&&!a.postEditorStore.currentPost.local_seo.openingHours.alwaysOpen?(u(),P(d,{key:2,name:t.strings.hours,class:"info-hours-row",align:""},{content:p(()=>[n("div",Ne,[(u(!0),m(W,null,F(t.weekdays,(h,g)=>(u(),m("div",{class:"aioseo-col-flex text-xs-left",key:g},[n("div",Ue,_(h),1),n("div",ze,[o(v,{disabled:l.getWeekDay(g).open24h||l.getWeekDay(g).closed,size:"medium",options:a.postEditorStore.currentPost.local_seo.openingHours.use24hFormat?s.$constants.HOURS_24H_FORMAT:s.$constants.HOURS_12H_FORMAT,modelValue:l.getSelectOptions(l.getWeekDay(g).openTime),"onUpdate:modelValue":b=>l.saveDay(g,"openTime",b.value)},null,8,["disabled","options","modelValue","onUpdate:modelValue"]),We,o(v,{disabled:l.getWeekDay(g).open24h||l.getWeekDay(g).closed,size:"medium",options:a.postEditorStore.currentPost.local_seo.openingHours.use24hFormat?s.$constants.HOURS_24H_FORMAT:s.$constants.HOURS_12H_FORMAT,modelValue:l.getSelectOptions(l.getWeekDay(g).closeTime),"onUpdate:modelValue":b=>l.saveDay(g,"closeTime",b.value)},null,8,["disabled","options","modelValue","onUpdate:modelValue"])]),n("div",Fe,[o(S,{disabled:l.getWeekDay(g).closed,size:"medium",modelValue:l.getWeekDay(g).open24h,"onUpdate:modelValue":b=>l.getWeekDay(g).open24h=b},{default:p(()=>[E(_(t.strings.open24h),1)]),_:2},1032,["disabled","modelValue","onUpdate:modelValue"]),o(S,{size:"medium",class:"closed-label",modelValue:l.getWeekDay(g).closed,"onUpdate:modelValue":b=>l.getWeekDay(g).closed=b},{default:p(()=>[E(_(t.strings.closed),1)]),_:2},1032,["modelValue","onUpdate:modelValue"])])]))),128))])]),_:1},8,["name"])):C("",!0)]))])}const Ye=f(Le,[["render",Ge]]),Ze={};function je(s,e){return u(),m("div")}const qe=f(Ze,[["render",je]]),Je={};function Ke(s,e){return u(),m("div")}const Qe=f(Je,[["render",Ke]]);const Xe={components:{LocalBusinessMapCustomMarker:qe,LocalBusinessMapDefaultStyle:Qe},data(){return{strings:{}}}},st={class:"aioseo-tab-content aioseo-localseo-maps"};function et(s,e,r,a,t,l){const i=c("local-business-map-default-style"),d=c("local-business-map-custom-marker");return u(),m("div",st,[o(i),o(d)])}const tt=f(Xe,[["render",et]]),ot={setup(){return{postEditorStore:L()}},components:{BusinessInfo:Pe,CoreMainTabs:ds,OpeningHours:Ye,Maps:tt,SvgSettings:ps},watch:{"postEditorStore.currentPost":{deep:!0,handler(){cs(this.postEditorStore.savePostState,250)}}},data(){return{tab:"business-info",tabs:[{slug:"business-info",icon:"svg-settings",name:this.$t.__("Business Info",this.$td)},{slug:"opening-hours",icon:"svg-settings",name:this.$t.__("Opening Hours",this.$td)},{slug:"maps",icon:"svg-settings",name:this.$t.__("Maps",this.$td)}]}},methods:{processChangeTab(s){this.tab=s}}},nt={class:"aioseo-app aioseo-post-settings"};function it(s,e,r,a,t,l){const i=c("core-main-tabs");return u(),m("div",nt,[o(i,{tabs:t.tabs,showSaveButton:!1,active:t.tab,internal:"",disableMobile:"",onChanged:e[0]||(e[0]=d=>l.processChangeTab(d))},null,8,["tabs","active"]),o(Y,{name:"route-fade",mode:"out-in"},{default:p(()=>[(u(),P(G(t.tab)))]),_:1})])}const at=f(ot,[["render",it]]),rt={setup(){return{postEditorStore:L()}},components:{"main-view":at}};function ct(s,e,r,a,t,l){const i=c("main-view");return u(),m("div",null,[a.postEditorStore.currentPost.id?(u(),P(i,{key:0})):C("",!0)])}const lt=f(rt,[["render",ct]]),A=Z({history:j(),routes:[{path:"/",component:H}]}),B=s=>(s=q(s),s=J(s),s=K(s),s.use(A),A.app=s,es(s,A),new ms,hs(),s.config.globalProperties.$truSeo=new os,window.addEventListener("load",()=>rs()),s),k=()=>{B(I({name:"Standalone/PostSettings/Sidebar",data(){return{tableContext:"post",screenContext:"sidebar"}},render:()=>V(H)})).mount("#aioseo-post-settings-sidebar-vue")};if(window.aioseo.currentPost){const s=window.aioseo.currentPost.context;document.querySelector(`#aioseo-${s}-settings-metabox`)&&M()&&(!window.wp.blockEditor&&window.wp.blocks&&window.wp.oldEditor&&(window.wp.blockEditor=window.wp.editor),B(I({name:"Standalone/PostSettings/Metabox",data(){return{tableContext:s,screenContext:"metabox"}},render:()=>V(H)})).mount(`#aioseo-${s}-settings-metabox`),s==="post"&&(document.getElementById("aioseo-post-settings-sidebar-vue")?k():(as("#aioseo-post-settings-sidebar-vue","aioseoSidebarVisible"),document.addEventListener("animationstart",function(a){a.animationName==="aioseoSidebarVisible"&&k()},{passive:!0}))))}window.aioseo.currentPost&&window.aioseo.localBusiness&&document.getElementById("aioseo-location-settings-metabox")&&B(I({name:"Standalone/LocalSeo/Metabox",data(){return{screenContext:"metabox"}},render:()=>V(lt)})).mount("#aioseo-location-settings-metabox");
