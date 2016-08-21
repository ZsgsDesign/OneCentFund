var ua = window.navigator.userAgent.toLowerCase();
if(ua.match(/MicroMessenger/i) == 'micromessenger'){
  location.replace("wechat.php");
}
else if(ua.match(/MSIE 9.0/i) == 'msie 9.0'){
  location.replace("unsupported.php");
}
else if(ua.match(/MSIE 8.0/i) == 'msie 8.0'){
  location.replace("unsupported.php");
}
else if(ua.match(/MSIE 7.0/i) == 'msie 7.0'){
  location.replace("unsupported.php");
}
else if(ua.match(/MSIE 6.0/i) == 'msie 6.0'){
  location.replace("unsupported.php");
}