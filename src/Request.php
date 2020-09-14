<?php
namespace Roi\Utils ;
class Request {
  // utility method to get the input stream
public static function getInputs(string $wrapper='php://input')
	{
	return json_decode(file_get_contents($wrapper), true) ;
	}

// returns query parameters
public static function getQuery(string $url)
	{

	}

public static function getHeaders($key)
	{

	}
}
?>
