/*!CK:3247540964!*//*1420443165,*/

if (self.CavalryLogger) { CavalryLogger.start_js(["rvsxg"]); }

__d("AdsBaseDataManager",["AdsError","Map","fbt","invariant","setImmediate"],function(a,b,c,d,e,f,g,h,i,j,k){function l(){"use strict";this.$AdsBaseDataManager0=0;this.$AdsBaseDataManager1=this.__initSuccessHandlers();this.$AdsBaseDataManager2=this.__initErrorHandlers();this.$AdsBaseDataManager3=null;this.$AdsBaseDataManager4=null;this.$AdsBaseDataManager5();this.$AdsBaseDataManager6=null;this.$AdsBaseDataManager7=this.$AdsBaseDataManager8.bind(this);}l.prototype.getAndIncrementVersion=function(){"use strict";this.$AdsBaseDataManager0+=1;return this.$AdsBaseDataManager0;};l.prototype.__initSuccessHandlers=function(){"use strict";var m=new h();if(this.__onBatchCreated)m.set('create',this.__onBatchCreated.bind(this));if(this.__onBatchLoaded)m.set('load',this.__onBatchLoaded.bind(this));if(this.__onBatchUpdated)m.set('update',this.__onBatchUpdated.bind(this));if(this.__onBatchDeleted)m.set('delete',this.__onBatchDeleted.bind(this));return m;};l.prototype.__initErrorHandlers=function(){"use strict";var m=new h();if(this.__onBatchCreateError)m.set('create',this.__onBatchCreateError.bind(this));if(this.__onBatchLoadError)m.set('load',this.__onBatchLoadError.bind(this));if(this.__onBatchUpdateError)m.set('update',this.__onBatchUpdateError.bind(this));if(this.__onBatchDeleteError)m.set('delete',this.__onBatchDeleteError.bind(this));return m;};l.prototype.__getObjectTypeLabel=function(){"use strict";return ("object");};l.prototype.__getObjectError=function(m,n){"use strict";var o;if(n&&n.message){o=n.message;}else o=i._("There was an unexpected error for the {object_type} with ID: {object_id}",[i.param("object_type",this.__getObjectTypeLabel()),i.param("object_id",''+m)]);return g.createError('object_load_error_'+m,o);};l.prototype.__handleSuccess=function(m,n,o,p){"use strict";if(p){m.forEach(function(q){var r=this.$AdsBaseDataManager3.get(q);r.set(n,{response:p,version:o});}.bind(this));if(!this.$AdsBaseDataManager6)this.$AdsBaseDataManager6=k(this.$AdsBaseDataManager7);}};l.prototype.__handleError=function(m,n,o,p){"use strict";if(p){m.forEach(function(q){var r=this.$AdsBaseDataManager4.get(q);r.set(n,{response:p,version:o});}.bind(this));if(!this.$AdsBaseDataManager6)this.$AdsBaseDataManager6=k(this.$AdsBaseDataManager7);}};l.prototype.$AdsBaseDataManager5=function(){"use strict";var m=new h();this.$AdsBaseDataManager1.forEach(function(o,p){m.set(p,new h());});this.$AdsBaseDataManager3=m;var n=new h();this.$AdsBaseDataManager2.forEach(function(o,p){n.set(p,new h());});this.$AdsBaseDataManager4=n;};l.prototype.$AdsBaseDataManager8=function(){"use strict";this.$AdsBaseDataManager9(this.$AdsBaseDataManager3,this.$AdsBaseDataManager1);this.$AdsBaseDataManager9(this.$AdsBaseDataManager4,this.$AdsBaseDataManager2);this.$AdsBaseDataManager6=null;this.$AdsBaseDataManager5();};l.prototype.$AdsBaseDataManager9=function(m,n){"use strict";m.forEach(function(o,p){j(n.has(p));if(o.size>0){var q=new h(),r=new h();o.forEach(function(t,u){q.set(u,t.response);r.set(u,t.version);});var s=n.get(p);s(q,r);}});};e.exports=l;},null);