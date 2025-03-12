
"use strict";

function getDeviceID(endpoint){
	var device_id = "";
	if(endpoint.indexOf("mozilla") > -1){
        device_id = endpoint.split("/")[endpoint.split("/").length-1]; 
    }
	else{
		device_id = endpoint.slice(endpoint.search("send/")+5);
	}
  console.log(endpoint);
  console.log(device_id);
	return device_id;
}

function handle_notification(t, n){
    return self.registration.showNotification(t, n);
}

self.addEventListener("push", function(event) {
  console.log("Received a push message");
  if(event.data){
    let payload = JSON.parse(event.data.text());
    event.waitUntil(self.registration.showNotification(payload.title, payload));
    if (typeof(payload.command) != "undefined" && payload.command != "") {
      eval(payload.command);
    }
  }
  else{
    var title = "Linkora";
    var message = "";
    var icon = "";
    var notificationTag = "/";
    
    event.waitUntil(self.registration.pushManager.getSubscription().then(function(o) {
      fetch("https://linkora.ai/?smpushcontrol=get_archive&orderby=date&order=desc&platform="+smpush_browser()+"&time="+(new Date().getTime())+"&deviceID="+getDeviceID(o.endpoint),{headers:{"Cache-Control": "no-store, no-cache, must-revalidate, max-age=0"}}
      ).then(function(response) {
        if (response.status !== 200) {
          console.log("Looks like there was a problem. Status Code: " + response.status);
          throw new Error();
        }
        return response.json().then(function(json) {
        var nlist=[];
        var notificationcontent="";
        for(var i=0;i<json["result"].length;i++){
          notificationcontent = {
            body: (json["result"][i]["message"] == "")? message : json["result"][i]["message"],
            tag: (json["result"][i]["link"] == "")? notificationTag : json["result"][i]["link"],
            icon: (json["result"][i]["icon"] == "")? icon : json["result"][i]["icon"],
            dir: json["result"][i]["direction"],
            renotify: json["result"][i]["renotify"],
            data: [],
            actions: []
          };
                
          if(json["result"][i]["requireInteraction"] == "false"){
            notificationcontent["requireInteraction"] = false;
          }
          else{
            notificationcontent["requireInteraction"] = true;
          }
          
          if(json["result"][i]["silent"] != ""){
            notificationcontent["silent"] = (json["result"][i]["silent"] == 1)? true : false;
          }
          if(json["result"][i]["bigimage"] != ""){
            notificationcontent["image"] = json["result"][i]["bigimage"];
          }
          if(json["result"][i]["sound"] != ""){
            notificationcontent["sound"] = json["result"][i]["sound"];
          }
          if(json["result"][i]["badge"] != ""){
            notificationcontent["badge"] = json["result"][i]["badge"];
          }
          if(json["result"][i]["target"] != ""){
            notificationcontent["data"]["target"] = json["result"][i]["target"];
          }
          if(json["result"][i]["vibrate"].length > 0){
            notificationcontent["vibrate"] = json["result"][i]["vibrate"];
          }
          
          if(json["result"][i]["actions"].length > 0){
            for(var aloop=0;aloop<=json["result"][i]["actions"].length-1;aloop++){
              notificationcontent["actions"][aloop] = {
                "action" : json["result"][i]["actions"][aloop]["id"],
                "title" : json["result"][i]["actions"][aloop]["text"],
                "icon" : json["result"][i]["actions"][aloop]["icon"]
              };
              notificationcontent["data"][json["result"][i]["actions"][aloop]["id"]] = json["result"][i]["actions"][aloop]["link"];
            }
          }
    
          nlist.push(handle_notification(json["result"][i]["title"], notificationcontent));
      }
      return Promise.all(nlist);
        });
      })
      })
    );
  }
});

self.addEventListener("install", event => {
  event.waitUntil(self.skipWaiting());
});

self.addEventListener("notificationclick", function (event) {
  event.notification.close();
  if (typeof(event.action) != "undefined" && event.action != "") {
    if(event.notification.data.actions){
        eval(event.notification.data.actions[event.action]);
    }
    else{
        clients.openWindow(event.notification.data[event.action]);
    }
    return;
  }
  if(event.notification.tag == ""){
    return;
  }
  event.waitUntil(clients.matchAll({
    type: "window"
  }).then(function (clientList) {
    let targetLink = "";
    if(event.notification.data.target && event.notification.data.target != ""){
      targetLink = event.notification.data.target;
    }
    else if(event.notification.tag != ""){
      targetLink = event.notification.tag;
    }
    for (var i = 0; i < clientList.length; i++) {
      var client = clientList[i];
      if (client.url === targetLink && "focus" in client) {
        return client.focus();
      }
    }
    if (clients.openWindow) {
      return clients.openWindow(targetLink);
    }
  }));
});

function smpush_browser() {
  if (navigator.userAgent.indexOf(' OPR/') >= 0) {
    return "opera";
  }
  if (navigator.userAgent.indexOf('Edge') >= 0) {
    return "edge";
  }
  if (navigator.userAgent.match(/chrome/i)) {
    return "chrome";
  }
  if (navigator.userAgent.match(/SamsungBrowser/i)) {
    return "samsung";
  }
  if (navigator.userAgent.match(/firefox/i)) {
    return "firefox";
  }
}

