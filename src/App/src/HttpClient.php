<?php

namespace App;

class HttpClient
{
	protected $client;

	protected $url;

	protected $baseUrl;

	public function __construct($url = null)
	{
		if($url)
		{
			$this->setUrl($url);
		}
	}

	public function setClient()
	{
		if(!$this->client)
		{
			$this->client = curl_init();
		}
	}

	public function setUrl($url)
	{
		$this->url = $url;
	}

	public function getUrl()
	{
		return $this->url;
	}

	public function setBaseUrl($baseUrl)
	{
		$this->baseUrl = $baseUrl;
	}

	public function getBaseUrl()
	{
		return $this->baseUrl;
	}

	public function post($params = null, $json = false)
	{
		if(is_array($params) && !$json)
		{
			$params = http_build_query($params);
		}

		if($json && (is_object($params) || is_array($params)))
		{
			$params = json_encode($params);
		}

		$this->setClient();

		curl_setopt_array($this->client, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $this->url,
			CURLOPT_POST => 1,
			CURLOPT_POSTFIELDS => $params
		));

		curl_setopt($this->client, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($this->client, CURLOPT_SSL_VERIFYPEER, false);

		if($json)
		{
			curl_setopt($this->client, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($params))
			);
		}

		$response = curl_exec($this->client);

		$this->closeClient();

		return $response;
	}

	public function postAsync($params = null, $useSession = true)
	{
		$queryString = "";
		if($params)
		{
			foreach ($params as $key => &$val) {
				if (is_array($val)) $val = implode(',', $val);
				$post_params[] = $key.'='.urlencode($val);
			}
			$queryString = implode('&', $post_params);
		}

		$queryString = "";

		$eol = "\r\n";

		$urlParts = parse_url($this->getUrl());

		$port = 80;
		$host = $urlParts['host'];
		if(isset($urlParts['scheme']) && $urlParts['scheme'] == 'https')
		{
			$host = 'ssl://' . $host;
			$port = 443;
		}

		$port = isset($urlParts['port'])? $urlParts['port'] : $port;

		$socket = fsockopen($host, $port, $errno, $errstr, 60);

		if(!$socket)
		{
			return false;
		}

		$output = 'POST ' . $urlParts['path'] . ' HTTP/1.1'. $eol;
		$output .= 'Host: ' . $urlParts['host'] . $eol ;
		if($useSession)
		{
			$output .= 'Cookie: PHPSESSID=' . $_COOKIE['PHPSESSID'] . $eol;
		}
		$output .= 'Content-Type: application/x-www-form-urlencoded'. $eol;
		$output .= 'Content-Length: ' . strlen($queryString) . $eol;
		$output .= 'Connection: Close' . $eol . $eol;
		if($queryString)
		{
			$output .= $queryString;
		}

		fwrite($socket, $output);
		//fwrite($socket, "\n", 1);

		//sleep(1);
		//
		//fgets($socket, 128);

		//$response = [];
		//
		//while (!feof($socket))
		//{
		//	$response[] = fgets($socket, 256);
		//}
		//
		//error_log(print_r($response,true));

		fclose($socket);
	}

	public function get($params = null)
	{
		$url = $this->getUrl() . $this->getQueryString($params);

		$this->setClient();

		curl_setopt_array($this->client, array(
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url,
			CURLOPT_POST => false,
			CURLOPT_HTTPGET => true,
		));
		$response = curl_exec($this->client);

		$this->closeClient();

		return $response;
	}

	public function getAsync($params = null, $useSession = true)
	{
		//$queryString = $this->getQueryString($params);
		//
		//$urlParts = parse_url($this->getUrl());
		//
		//$port = 80;
		//$host = $urlParts['host'];
		//if(isset($urlParts['scheme']) && $urlParts['scheme'] == 'https')
		//{
		//	$host = 'ssl://' . $host;
		//	$port = 443;
		//}
		//
		//$port = isset($urlParts['port'])? $urlParts['port'] : $port;
		//
		//$socket = fsockopen($host, $port, $errno, $errstr, 60);
		//
		//if(!$socket)
		//{
		//	return false;
		//}
		//
		//$output = 'GET ' . $urlParts['path'] . $queryString . ' HTTP/1.1'. PHP_EOL;
		//$output .= 'Host: ' . $urlParts['host'] .  PHP_EOL;
		//$output .= 'Content-Type: application/x-www-form-urlencoded'. PHP_EOL;
		//if($useSession)
		//{
		//	$output .= 'Cookie: PHPSESSID=' . $_COOKIE['PHPSESSID'] . PHP_EOL;
		//}
		//$output .= 'Connection: Close' . PHP_EOL . PHP_EOL;
		//
		//fwrite($socket, $output);
		//fclose($socket);


		$connectTimeout = 30;
		$urlParts = parse_url($this->getUrl());
		$host = $urlParts['host'];
		$ssl = false;
		$port = 80;
		if(isset($urlParts['scheme']) && $urlParts['scheme'] == 'https')
		{
			$ssl = true;
			$host = 'ssl://' . $host;
			$port = 443;
		}
		$endpoint = $urlParts['path'];

		$cookie_str = '';

		foreach ($_COOKIE as $k => $v) {
			$cookie_str .= urlencode($k) .'='. urlencode($v) .'; ';
		}
		$sslstr = ($ssl) ? "ssl://" : "";
		$request =  "GET $endpoint HTTP/1.1\r\n";
		$request .= "Host: $host\r\n";
		if (!empty($cookie_str)) {
			$request .= 'Cookie: '. substr($cookie_str, 0, -2);
		}
		$request .= "Connection: Close\r\n";
		$request .= "\r\n";
		$errno = null;
		$errstr = null;
		$port = $port;
		if (($fp = @fsockopen($sslstr.$host, $port, $errno, $errstr, $connectTimeout)) == false) {
			return;
		}
		fputs($fp,$request);
		fclose($fp);


	}

	public function closeClient()
	{
		if($this->client)
		{
			curl_close($this->client);
			$this->client = null;
		}
	}

	private function getQueryString($params = null)
	{
		if($params)
		{
			return '?' . http_build_query($params);
		}
	}
}