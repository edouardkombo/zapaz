<?php

define("HTTP_GET", 101010);
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

  public function __construct($uri, $port = 80, $requestType = HTTP_GET) {
    $this->port = $port;
    $this->requestType = $requestType;
    $this->requestParameters = array();
    $this->protocol = substr($uri, 0, 5) == "https" ? "https://" : "http://";
    $tmp = parse_url($uri);
    $this->host = $tmp['host'];
    $this->url = str_replace($this->protocol . $this->host, "", $uri);
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
    $t = $this->getRequestCode();

    $socket = fsockopen($this->host, $this->port, $errno, $errstr, 10);
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
      $response .= fgets($socket, 128);
    }
    fclose($socket);

    $this->parse($response);
    return true;
  }

  private function getRequestCode() {
    $h = "";
    $url = $this->url;
    $p = array();
    foreach ($this->requestParameters as $k => $v) {
      array_push($p, urlencode($k) . "=" . urlencode($v));
    }
    $p = implode("&", $p);
    if ($this->requestType == HTTP_POST) {
      $h .= "POST $url HTTP/1.1\n";
    } else {
      $url .= "?" . $p;
      $h .= "GET $url HTTP/1.1\n";
    }
    $h .= "Host: " . $this->host . ":" . $this->port . "\n";
    if ($this->requestType == HTTP_POST)
      $h .= "Content-Length: " . strlen($p) . "\n";
    $h .= "Connection: Close\n";
    if ($this->requestType == HTTP_POST)
      $h .= "Content-Type: application/x-www-form-urlencoded\n";
    $h .= "\n";

    if ($this->requestType == HTTP_GET) {
      $h .= "\n";
    } else if ($this->requestType == HTTP_POST) {
      $h .= $p;
    }

    return $h;
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
    if (!$this->statusIsOk()) {
      return false;
    }
    if (in_array('Transfer-Coding: chunked', $this->responseHeaders)) {
      $this->unchunkHttpResponse();
    }
    $this->responseContent = trim($this->responseContent);

    /* On some servers, the HTTP content starts with the length of its content
     * and ends with a 0 on a last dedied line.
     */
    $end = substr($this->responseContent, -2);
    if ($end == "\n0") {
      $firstLine = "";
      for ($i = 0; $this->responseContent[$i] != "\n"; $i++) {
        $firstLine .= $this->responseContent[$i];
      }
      $size = hexdec($firstLine);
      if ($size > 0 && $size < strlen($this->responseContent) - strlen($firstLine)) {
        $this->responseContent = substr($this->responseContent, strlen($firstLine) + 1, $size);
      }
    }
  }

//
// Validate http responses by checking header.  Expects array of
// headers as argument.  Returns boolean.
//
  public function statusIsOk() {
    if (!is_array($this->responseHeaders) or count($this->responseHeaders) < 1) {
      return false;
    }
    switch (trim(strtolower($this->responseHeaders[0]))) {
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
  function unchunkHttpResponse() {
    if (!is_string($this->responseContent) or strlen($this->responseContent) < 1) {
      return false;
    }
    $eol = "\r\n";
    $add = strlen($eol);
    $tmp = $this->responseContent;
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
    $this->responseContent = $str;
  }

  public function getResponseContent() {
    return $this->responseContent;
  }

}

?>