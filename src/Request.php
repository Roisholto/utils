<?php
namespace Roi\Utils ;
class Request {
  // utility method to get the input stream
public static function getInputs(string $wrapper='php://input')
	{
	return json_decode(file_get_contents($wrapper), true) ;
	}

public static function parseSearch()
	{
	$cols = isset($_GET['cols']) ? $_GET['cols'] : '' ;
	$clause = isset($_GET['clause']) ? json_decode($_GET['clause'],true) : [] ;
	$groupby = isset($_GET['groupby']) ? $_GET['groupby']: '' ;
	$order_by = (isset($_GET['order_by']) )
			?
			$_GET['order_by']
			:
			null ;
	$order_direction = (isset($_GET['order_direction']) and in_array($_GET['order_direction'], ['ASC', 'DESC']) )
			?
			$_GET['order_direction']
			:
			'ASC' ;

	(int) $start = isset($_GET['start']) ? $_GET['start'] : 0 ;
	(int) $limit = isset($_GET['display']) ? $_GET['display']: 100 ;
	$pagination = ['s'=> $start, 'd'=> $limit] ;
	if(isset($_GET['array']))
		$clause = self::multi_to_assoc($clause) ;

	return [
			'cols'=>$cols, 'clause'=>$clause, 'pagination'=> $pagination,
			'groupby'=>$groupby, 'order_by'=>$order_by, 'order_direction'=> $order_direction
			'all'=>$_GET
			] ;
	}

public static function multi_to_assoc(array $arr) : array
	{
  $new_arr = [] ;

  foreach($arr as $k=> $v)
  	{
    $curr_arr = [] ;
    if(is_integer($k))
    	{
      // likely to be an array
      if(is_array($v))
      	{
        // check if it is associative or another multidimensional array ;
        $this_v_keys = array_keys($v) ;
        // $curr_arr = to_assoc($v) ;
        if(is_integer($this_v_keys[0]))
        	{
          $curr_arr[] =   self::multi_to_assoc($v) ; // array_merge($curr_arr); ; //
          }
        else
          {
          $curr_arr= array_merge($curr_arr,$v);
        	}
        }
      else
       	{
        // $v more likely to be a string => logical operator ;
        $curr_arr[] = $v ;
        }
      }
    else
     	{
      // key is string ;
      // then value is either an operator or an associative array representing a col ;
      if(is_array($v))
      	{
        // merge this $v with parent $k;
        $curr_arr[$k] = $v ;
        }
      else
      	{
        // should remain at it spot ;
        $curr_arr[] = $v ;
        }
      }
    $new_arr= array_merge($new_arr,$curr_arr) ;
    }

  return $new_arr ;
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
