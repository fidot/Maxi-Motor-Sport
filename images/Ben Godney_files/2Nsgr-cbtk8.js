/*!CK:3171778959!*//*1420621532,*/

if (self.CavalryLogger) { CavalryLogger.start_js(["K6A61"]); }

__d("AdsImageDataManager",["AdsAPIAdAccountFields","AdsBaseDataManager","AdsImageActions","AdsImageDataManagerFields","GraphAPI","Set","fbt"],function(a,b,c,d,e,f,g,h,i,j,k,l,m){'use strict';for(var n in h)if(h.hasOwnProperty(n))p[n]=h[n];var o=h===null?null:h.prototype;p.prototype=Object.create(o);p.prototype.constructor=p;p.__superConstructor__=h;function p(){if(h!==null)h.apply(this,arguments);}p.prototype.loadAll=function(q,r){k('2.2').account(q).edge(g.ADIMAGES).get({date_format:'U',fields:j,hashes:r}).done(function(s){var t=new l(r);s.data.forEach(function(u){this.__handleSuccess(['load'],u.hash,null,u);t["delete"](u.hash);}.bind(this));if(t.size>0)t.forEach(function(u){this.__handleError(['load'],u,null,new Error(m._("Unable to load image hash \"{image hash}\". It may be invalid.",[m.param("image hash",u)])));}.bind(this));}.bind(this),function(s){r.forEach(function(t){this.__handleError(['load'],t,null,s);}.bind(this));}.bind(this));};p.prototype.load=function(q,r){this.loadAll(q,[r]);};p.prototype.__onBatchLoaded=function(q){i.imagesLoaded(q);};p.prototype.__onBatchLoadError=function(q){i.imagesLoadError(q);};e.exports=new p();},null);