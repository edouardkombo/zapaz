<?php

define("HTTP_GET" , 101010);
define("HTTP_POST", 010101);
define("HTTP_SECURED", 110000);
define("HTTP_UNSECURED", 111000);

class HttpCommunicator {

  private $url;
  private $host;
  private $protocol;
  private $port;
  private $requestParameters;
  private $requestType;
  private $responseHeaders;
  private $responseContent;

  public function __construct($uri, $port = 80, $requestType = HTTP_GET, $requestProtocol = HTTP_UNSECURED) {
    $this->port = $port;
    $this->requestType = $requestType;
    $this->requestParameters = array();
    $this->protocol = $requestProtocol == HTTP_SECURED ? "https://" : "http://";
    $tmp = parse_url($uri);
    $this->host = $tmp['host'];
    $this->url = str_replace($this->protocol.$this->host, "", $uri);
  }
  
  public function setRequestType($requestType) {
    $this->requestType = $requestType;
  }
  
  public function addParameter($name, $value) {
    if ($name != null && $name != "" && $value != null && $value != "") {
      $this->requestParameters[$name] = $value;
    }
  }

  public function send() {
    $t = array();
    if ($content != NULL) {
      $t[] = 'POST ' . $this->url . ' HTTP/1.1';
      $t[] = 'Content-Type: text/html';
      $t[] = 'Host: ' . $ip . ':' . $port;
      $t[] = 'Content-Length: ' . strlen($content);
      $t[] = 'Connection: Close';
      $t = implode("\r\n", $t) . "\r\n\r\n" . $content;
    } else {
      $t[] = 'GET ' . $ur . ' HTTP/1.1';
      $t = implode("\r\n", $t) . "\r\n\r\n";
    }
    $this->prepareRequestHeader();

    $socket = @fsockopen($ip, $port, $errno, $errstr, 10);
    // If we don't have a stream resource, abort.
    if (!(get_resource_type($socket) == 'stream')) {
      return false;
    }
    if (!fwrite($socket, $t)) {
      fclose($socket);
      return false;
    }

    $response = '';
    while (!feof($socket)) {
      $response .= fgets($socket, 256);
    }
    fclose($socket);
    
    $this->parse($response);
    return true;
  }

  public function getHttpResponseStatus($content=null) {
    if (empty($content)) {
      return false;
    }
    // split into array, headers and content.
    $hunks = explode("\r\n\r\n", trim($content));
    if (!is_array($hunks) or count($hunks) < 2) {
      return false;
    }
    $header = $hunks[count($hunks) - 2];
    $body = $hunks[count($hunks) - 1];
    $headers = explode("\n", $header);
    unset($hunks);
    unset($header);

    if (!is_array($headers) or count($headers) < 1) {
      return false;
    }

    $status = str_replace("HTTP/1.0 ", "", trim($headers[0]));
    $status = str_replace("HTTP/1.1 ", "", $status);

    return $status;
  }

  public function httpResponseStatus($uri=null, $post=null) {
    return getHttpResponseStatus(httpRequest($uri, 80, $post));
  }
  
  private function getRequestCode() {
    $h = "";
    $url = $this->url;
    $p = array();
    foreach ($this->requestParameters as $k => $v) {
      array_push($p, url_encode(utf8_encode($k))."=".url_encode(utf8_encode($v)));
    }
    $p = implode("&", $p);
    if ($this->requestType == HTTP_POST) {
      $h .= "POST $url HTTP/1.1";
    } else {
      $url .= "?".$p;
      $h .= "GET $url HTTP/1.1";
    }
    $h .= "Content-Length: ".strlen($p)."\n";
    $h .= "Content-Type: text/html\n";
    $h .= "Host: ".$this->host.":".$this->post."\n";
    $h .= "Connection: Close\n";
  }
  
  private function parse($content) {
    // split into array, headers and content.
    $hunks = explode("\r\n\r\n", trim($content));
    if (!is_array($hunks) or count($hunks) < 2) {
      return false;
    }
    $this->responseHeaders = $hunks[count($hunks) - 2];
    $this->responseContent = $hunks[count($hunks) - 1];
    $this->responseHeaders = explode("\n", $this->responseHeaders);
    unset($hunks);
    unset($header);
    if (!$this->validateHttpResponse($headers)) {
      return false;
    }
    if (in_array('Transfer-Coding: chunked', $this->responseHeaders)) {
      return trim($this->unchunkHttpResponse($body));
    } else {
      return trim($body);
    }
  }

//
// Validate http responses by checking header.  Expects array of
// headers as argument.  Returns boolean.
//
  public function validateHttpResponse($headers=null) {
    if (!is_array($headers) or count($headers) < 1) {
      return false;
    }
    switch (trim(strtolower($headers[0]))) {
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
  function unchunkHttpResponse($str=null) {
    if (!is_string($str) or strlen($str) < 1) {
      return false;
    }
    $eol = "\r\n";
    $add = strlen($eol);
    $tmp = $str;
    $str = '';
    do {
      $tmp = ltrim($tmp);
      $pos = strpos($tmp, $eol);
      if ($pos === false) {
        return false;
      }
      $len = hexdec(substr($tmp, 0, $pos));
      if (!is_numeric($len) or $len < 0) {
        return false;
      }
      $str .= substr($tmp, ($pos + $add), $len);
      $tmp = substr($tmp, ($len + $pos + $add));
      $check = trim($tmp);
    } while (!empty($check));
    unset($tmp);
    return $str;
  }

}

?>