<?php


class MyHttpRequest{
  
  private $url;
  //private $method;
  
  public function __construct($url) {
    $this->url = $url;
  }
//
// Post provided content to an http server and optionally
// convert chunk encoded results.  Returns false on errors,
// result of post on success.  This example only handles http,
// not https.
//
public function httpRequest($uri=null,$port=80, $content=null) {
  if (empty($uri))        { return false; }
  if (!is_numeric($port)) { return false; }
  
  // generate headers in array.
  
  $url = parse_url($uri);
  $ip = $url['host'];
  $uri = str_replace("http://$ip", "", $uri);
  
  $t   = array();
  if ($content != NULL)
  {
	  $t[] = 'POST ' . $uri . ' HTTP/1.1';
	  $t[] = 'Content-Type: text/html';
	  $t[] = 'Host: ' . $ip .':'.$port;
	  $t[] = 'Content-Length: ' . strlen($content);
	  $t[] = 'Connection: Close';
	  $t   = implode("\r\n",$t) . "\r\n\r\n" . $content;
  }
  else
  {
	  $t[] = 'GET ' . $uri . ' HTTP/1.1';
	  $t[] = 'Content-Type: text/html';
	  $t[] = 'Host: ' . $ip .':'.$port;
	  $t[] = 'Connection: Close';
	  $t   = implode("\r\n",$t) . "\r\n\r\n";
  }
  //
  // Open socket, provide error report vars and timeout of 10
  // seconds.
  //
  $fp  = @fsockopen($ip,$port,$errno,$errstr,10);
  // If we don't have a stream resource, abort.
  if (!(get_resource_type($fp) == 'stream')) { return false; }
  //
  // Send headers and content.
  //
  if (!fwrite($fp,$t)) {
    fclose($fp);
    return false;
  }
  //
  // Read all of response into $rsp and close the socket.
  //
  $rsp = '';
  while(!feof($fp)) { $rsp .= fgets($fp,128); }
  fclose($fp);
  //
  // Call parseHttpResponse() to return the results.
  //
  return $rsp;
}

public function getHttpResponseStatus($content=null)
{
  if (empty($content)) { return false; }
  // split into array, headers and content.
  $hunks = explode("\r\n\r\n",trim($content));
  if (!is_array($hunks) or count($hunks) < 2) {
    return false;
  }
  $header  = $hunks[count($hunks) - 2];
  $body    = $hunks[count($hunks) - 1];
  $headers = explode("\n",$header);
  unset($hunks);
  unset($header);
  
  if (!is_array($headers) or count($headers) < 1) { return false; }
  
  $status = str_replace("HTTP/1.0 ", "", trim($headers[0]));
  $status = str_replace("HTTP/1.1 ", "", $status);
  
  return $status;
}

public function httpResponseStatus($uri=null, $post=null)
{
  return  getHttpResponseStatus(httpRequest($uri, 80, $post));
}

//
// Accepts provided http content, checks for a valid http response,
// unchunks if needed, returns http content without headers on
// success, false on any errors.
//
public function parseHttpResponse($content=null) {
  if (empty($content)) { return false; }
  // split into array, headers and content.
  $hunks = explode("\r\n\r\n",trim($content));
  if (!is_array($hunks) or count($hunks) < 2) {
    return false;
  }
  $header  = $hunks[count($hunks) - 2];
  $body    = $hunks[count($hunks) - 1];
  $headers = explode("\n",$header);
  unset($hunks);
  unset($header);
  if (!validateHttpResponse($headers)) { return false; }
  if (in_array('Transfer-Coding: chunked',$headers)) {
    return trim(unchunkHttpResponse($body));
  } else {
    return trim($body);
  }
}

//
// Validate http responses by checking header.  Expects array of
// headers as argument.  Returns boolean.
//
public function  validateHttpResponse($headers=null) {
  if (!is_array($headers) or count($headers) < 1) { return false; }
  switch(trim(strtolower($headers[0]))) {
    case 'http/1.0 100 ok':
    case 'http/1.0 200 ok':
    case 'http/1.1 100 ok':
    case 'http/1.1 200 ok':
        return true;
    break;
  }
  return false;
}

//
// Unchunk http content.  Returns unchunked content on success,
// false on any errors...  Borrows from code posted above by
// jbr at ya-right dot com.
//
function  unchunkHttpResponse($str=null) {
  if (!is_string($str) or strlen($str) < 1) { return false; }
  $eol = "\r\n";
  $add = strlen($eol);
  $tmp = $str;
  $str = '';
  do {
    $tmp = ltrim($tmp);
    $pos = strpos($tmp, $eol);
    if ($pos === false) { return false; }
    $len = hexdec(substr($tmp,0,$pos));
    if (!is_numeric($len) or $len < 0) { return false; }
    $str .= substr($tmp, ($pos + $add), $len);
    $tmp  = substr($tmp, ($len + $pos + $add));
    $check = trim($tmp);
  } while(!empty($check));
  unset($tmp);
  return $str;
}


}
?>