<?php
namespace Roi\Utils ; // individual
//Class ot handle building clause part of a query just an=s the name suggests
class SqlClauseBuilder {

public $logic_operators = [
  'like'=>['symbol'=>'LIKE', 'many'=>0, 'format'=>'%s LIKE %s'],
  'equalto'=>['symbol'=>'IN', 'many'=>1, 'format'=>'%s IN (%s)'],
  'notequalto'=>['symbol'=>'!=', 'many'=>0, 'format'=>'%s != (%s)'], // NOT IN
  'greaterthan'=>['symbol'=>'>','many'=>0, 'format'=>'%s > (%s)'],
  'lesserthan'=>['symbol'=>'<', 'many'=>0, 'format'=>'%s < %s'],
  'greaterthanorequalto'=>['symbol'=>'>=', 'many'=>0, 'format'=>'%s >= %s '],
  'lesserthanorequalto'=>['symbol'=>'<=', 'many'=>0, 'format'=>'%s <= %s'],
  'between'=>['symbol'=>'BETWEEN', 'many'=>1, 'format'=> '%s BETWEEN %s AND %s'],
  'notbetween'=>['symbol'=>'NOT BETWEEN', 'many'=>1, 'format'=> '%s NOT BETWEEN %s AND %s'],
  'isnull'=> ['symbol'=>"IS NULL", 'many'=>-1, 'format'=> '%s IS NULL' ],
  'notisnull'=> ['symbol'=>"IS NULL", 'many'=>-1, 'format'=> '%s NOT IS NULL' ]
  ] ;

public $cond_operators  = ['or'=>'OR', 'and'=>'AND']  ;

function __construct($searchable)
  {
  $this->searchable = $searchable ;
  /*
  searchable is an associative array of the form
  [
  usercol=>['col'=>'', factors=>[], 'bind_as'=>''] ;
  ]
  usercol -> imply the column that is passed by user to the api,
  usercol['col'] -> imply the corresponding column in the database ;
  usercol['factors'] -> imply the clause that are acceptable i.e the logicsl operastors allowed in the column
  usercol['bind_as'] -> imply the datatype that PDO Should bind to  ;

  Example ------------------
      $searchable_params = [
                      'mid'=>['col'=>'merchants.m_id','factors'=>['equalto'],'bind_as'=>PDO::PARAM_STR],
                      'name'=>['col'=> 'merchants.name', 'factors'=>['like','equalto'], 'bind_as'=>PDO::PARAM_STR],
                      'type'=>['col'=> 'merchants.type', 'factors'=>['equalto'], 'bind_as'=>PDO::PARAM_STR ],
                      'closeness'=>['col'=>'merchants.location' , 'factors'=>['greaterthan','lesserthan'], 'bind_as'=>PDO::PARAM_STR ]
                      ] ;

      $clausebuilder = new sqlClauseBuilder($searchable_params) ;
      $search = ['name'=>['data'=>['Bob%'],'factor'=>'like'] ]  ]
      $clause = $clausebuilder->build($build) ;  // returns ['clause'=> 'merchants.name LIKE ?', 'binds'=>[ ['Bob%',PDO::PARAM_STR] ] )
  */

  }

function build($search)
  {
  $rs = $this->test_key($search) ;
  $rs['clause'] = ($rs['clause']!='') ? '('.$rs['clause'].')' : ' ';
  /*
  $search is of the form ['usercol'=>['data'=>[data1,...],'factor'=>''] ]
  */
  return $rs ;
  }

// handles associative arrays
private function test_key($arr)
  {
  $max_nest = 'infinity' ; //  maximum number of nesting, implement later
  $clause = '' ;
  $sql_params = [] ;

  foreach($arr as $k=> $v)
    {
    if(gettype($k) == 'integer')
      {
      // then $v is either a string or an array i.e 0=>['col'=>[data]] or 0=>'operator'
      if(is_array($v))
        {
        $clause.= ' ( ';
        $pro_key = $this->test_key($v) ;
        $clause.= $pro_key['clause'] ;
        $sql_params = array_merge($sql_params, $pro_key['binds']) ;
        $clause.= ' ) ' ;
        }
      else
        {
        $op = isset($this->cond_operators[$v]) ? $this->cond_operators[$v] : '' ;
        $clause.= " $op " ;
        }
      // if string, then its an operator ; else it is a group of col ref
      // if group call funtion again ;
      }
    else // the key is a string ,
      {
      // then it is a column reference ;
      // process
      $pro_col = $this->process_col($k,$v) ;
      $clause.= $pro_col['clause'] ;
      // print_r($pro_col) ;
      $sql_params = array_merge($sql_params, $pro_col['binds']) ;
      }
    }

  return ['clause'=>$clause, 'binds'=>$sql_params] ;
  }

private function process_col($col, $dt) : array
  {
  $rt = ['clause'=>'','binds'=>[]] ;

  if(!array_key_exists($col, $this->searchable))
    {
    return $rt ;
    }

  $db_col = $this->searchable[$col]['col'] ;
  // expecting [data=>[], factor,'operator']
  $data = (isset($dt['data']) and is_array($dt['data']) ) ?  $dt['data'] : [] ;
  $factor = ( isset($dt['factor']) and in_array($dt['factor'], $this->searchable[$col]['factors']) ) ? $dt['factor'] : null;
  $str = '' ;

  if(!$factor)
    throw new \Exception("Factor \" $factor \" not found ");

  if (count($data)>0)
      {
      $factor = $this->logic_operators[$factor] ;
      $symbol = $factor['symbol'] ;
      $format = $factor['format'] ;
      $bindvalas = $this->searchable[$col]['bind_as'] ;
      $binded = [] ;
      if($factor['many']>-1 )
        {
        // $str.= ' ( ' ;
        // ==1 or $factor['many']== 0
        if($factor['many'] == 1)
          {
          for($i=0; $i< count($data); $i++)
            {
            $binded[] = [$data[$i], $bindvalas ] ;
            $placeholder[] = '?' ;
            // echo 'looped through data '.$i ;
            }
          // since IN operator is of type x in y
          // y here is a single string ;
          // thus x in (?,?,?,?, ...)
          if($symbol == 'IN')
            $placeholder = [implode(', ',$placeholder)] ;
          }
        else
          {
          $binded[] = [$data[0], $bindvalas ] ; // select only the first data ;
          $placeholder[] = '?' ;
          }

        $str.= vsprintf($format, array_merge([],[$db_col], $placeholder) )  ;
        }
      else // then factor is assumed to be -1 ;
        {
        // ideally for is null and ! is null ;
        $str.= sprintf($format, $db_col ) ;
        }
      }
  else
    {
    throw new \Exception("Expecting \" data \" as an array ");
    }

  return  ['clause'=>$str, 'binds'=>$binded] ;
  }
}
 ?>
