var scripts = document.getElementsByTagName("script");
var script_location = scripts[scripts.length-1].src;
script_location = script_location.substring(0, script_location.lastIndexOf("/"));

var tracker_holder = document.createElement('div');
tracker_holder.innerHTML = "<iframe src=\"" + script_location +"/analytics.php?url=" + encodeURIComponent(window.location.href) + "&referrer=" + encodeURIComponent(document.referrer) + "\" style=\"position:fixed; left:-1px; top:-1px; width:1px; height:1px; display:none; border:none; outline:none;\" width=\"1px\" height=\"1px\"></iframe>";
document.getElementsByTagName('body')[0].appendChild(tracker_holder);