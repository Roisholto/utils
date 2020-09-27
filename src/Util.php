<?php
namespace Roi\Utils ;

class Util {

static function generate_random_id(int $bytes)
  {
  return bin2hex(openssl_random_pseudo_bytes($bytes))   ;
  }
  
}
?>
