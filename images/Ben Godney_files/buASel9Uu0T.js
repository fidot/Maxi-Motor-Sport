/*!CK:3009089217!*//*1418088190,*/

if (self.CavalryLogger) { CavalryLogger.start_js(["D2Rfa"]); }

__d("AppRequestReminders",["AsyncRequest","CSS","DOM","ge"],function(a,b,c,d,e,f,g,h,i,j){var k=0,l={},m=1,n=j('OtherAppReqReminder'),o=function(u,v,w){l[v]={node:u,seq:m++,reqCount:w};},p=function(u){k=u;},q=function(u){return u.id.split('_')[1];},r=function(u){var v=j(u),w=v.nextSibling;if(w!==n){h.show(w);k-=l[q(w)].reqCount;}s(k);},s=function(u){new g().setURI('/ajax/reminders/update_count.php').setData({new_count:u}).setMethod('POST').send();},t=function(u,v){if(n&&v&&u>0){i.setContent(j('OtherAppReqLabel'),v);}else if(n){h.hide(n);}else h.hide(j('OtherAppReqReminder'));};f.initNode=o;f.handleRemove=r;f.updateCount=t;f.setTotalOtherCount=p;},null);
__d("RequestListController",["Arbiter","ChannelConstants","CSS","DOM"],function(a,b,c,d,e,f,g,h,i,j){function k(l){"use strict";this.$RequestListController0=l;this.$RequestListController1=0;this.$RequestListController2={};g.subscribe(h.getArbiterType('jewel_requests_remove_old'),this.$RequestListController3.bind(this));this.fromDom();}k.prototype.$RequestListController4=function(l){"use strict";var m=l.match(/^(\d+)_(\d+)/);return (m)?{requester:m[1],type:m[2]}:(void 0);};k.prototype.$RequestListController5=function(l){"use strict";var m=l?this.$RequestListController4(l):(void 0),n;if(m&&m.requester){n=parseInt(m.requester,10);if(isNaN(n))n=(void 0);}var o;if(m&&m.type){o=parseInt(m.type,10);if(isNaN(o))o=(void 0);}return {requester:n,type:o};};k.prototype.fromDom=function(){"use strict";j.scry(this.$RequestListController0,'.fbRequestList li.objectListItem').forEach(function(l){var m=l.getAttribute('id');if(m){var n=this.$RequestListController5(m);if(n.requester)this.$RequestListController2[n.requester]={id:m,item:l};++this.$RequestListController1;}}.bind(this));this.$RequestListController6();};k.prototype.$RequestListController3=function(l,m){"use strict";var n=this.$RequestListController2[m.obj.from];if(n){j.remove(n.item);delete this.$RequestListController2[m.obj.from];--this.$RequestListController1;this.$RequestListController6();}};k.prototype.$RequestListController6=function(){"use strict";j.scry(this.$RequestListController0,'li.empty').forEach(function(l){i.conditionShow(l,this.$RequestListController1<=0);}.bind(this));};e.exports=k;},null);