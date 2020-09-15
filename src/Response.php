<?php
namespace Roi\Utils ;

class Response {

  const UNKNOWN = '04' ;
  const SERVICE_ERROR = '03' ;
  const PROCESS_ERROR = '02' ;
  const DATA_ERROR = '01' ;
  const SUCCESS = '1' ;
  const SCHEMA_ERROR = '011' ;
  const NOT_FOUND = '00' ;

  const STATUS_TYPES = [
    '1'=>'success',
    '01'=>'dataError',
    '02'=>'processError',
    '03'=>'serviceError',
    '04'=>'unknown',
    '011'=>'schemaError',
    '00'=>'notFound' // usually when resource id not found ;
    ] ;

  private static function isDev() {
    return env('APP_ENV') == 'local' ; // development
  }

  public static function create(string $status, string $message, array $data = [], array $debug=[]) : array
    {
    if(array_key_exists($status, self::STATUS_TYPES))
      {
  		$rs = [] ;
  		if($status === '1')
  			{
  			$rs['status'] = 1 ;
  			$rs['message'] = $message ;
  			}
  		else
  			{
        $rs['status'] = 0 ;  
  			$rs['error'] = self::STATUS_TYPES[$status] ;
  			$rs['description'] = $message ;
  			}

  		if(count($debug) and static::isDev())
  			{
  			$rs['debug'] = $debug ;
  			}

  		$rs['data'] = $data ;
  		return $rs ;
  		}
  	else
  		{
  		throw new \Exception("status key does not exist");
  		}
  	}
}
?>
