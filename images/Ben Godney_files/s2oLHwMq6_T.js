/*!CK:3675105689!*//*1420443165,*/

if (self.CavalryLogger) { CavalryLogger.start_js(["mqtyV"]); }

__d("AdsImageActions",["AdsDispatcher","AdsImageActionType"],function(a,b,c,d,e,f,g,h){'use strict';var i={imagesLoaded:function(j){g.handleUpdateFromServerResponse({actionType:h.BATCH_LOADED,images:j});},imagesLoadError:function(j){g.handleUpdateFromServerResponse({actionType:h.BATCH_LOAD_ERROR,errors:j});},imageListPartialLoad:function(j,k){g.handleUpdateFromServerResponse({actionType:h.LIST_PARTIAL_LOAD,accountID:j,images:k});},imageListLoaded:function(j,k){g.handleUpdateFromServerResponse({actionType:h.LIST_LOADED,accountID:j,images:k});},imageListLoadError:function(j){g.handleUpdateFromServerResponse({actionType:h.LIST_LOAD_ERROR,accountID:j});}};e.exports=i;},null);