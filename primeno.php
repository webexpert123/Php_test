<?php
// phpinfo(); die;
ini_set('memory_limit', '2048M');
?>
<?php
session_start();
$_SESSION['result'] =array();

function checksum_isprimeno_shift($arr,$limit){
  $result = array();
  $i = 0;
    for($i=0; $i<count($arr); $i++){
        if(count($arr) >2)
         checksum_isprimeno($arr,$limit);   

        array_shift($arr);  
    }
}

function get_prime_arr($limit){
  $i = 2; 
  $prime[] = 2;
  while($i < $limit){
     $is_prime = gmp_prob_prime($i);
    // $nextprime =  gmp_nextprime($i);
    // $prime[] =  gmp_strval($nextprime);
     if($is_prime == 2)
      $prime[] = $i;

    $i++;
  }
  return array_values(array_unique($prime));
}


function checksum_isprimeno($arr,$limit){
  $arr_count = array();
  $sum_of_primeno = array_sum($arr);
  // $is_prime = find_prime($sum_of_primeno);
  $is_prime = gmp_prob_prime($sum_of_primeno);

  if($is_prime == 2 && $sum_of_primeno < $limit ){
    $_SESSION['result'][$sum_of_primeno][] = $arr;  
  } else {
    array_pop($arr);
    checksum_isprimeno($arr,$limit);
  }

}

function  count_prime($data){
  foreach ($data as $k => $v) {
     foreach ($v as $key => $value) { 
       $count_prime[count($v[$key])] = $k;       
      }      
    }
    return $count_prime;
}
// echo '<pre>';
// echo memory_get_usage();
  $limit = 10000;
  $arr = get_prime_arr($limit);
  checksum_isprimeno_shift($arr,$limit);
  $result = $_SESSION['result'];
    $count_prime_arr = count_prime($result);
    $term = max(array_keys($count_prime_arr));
    $sum_of_prime = $count_prime_arr[$term];
    echo "The longest sum of consecutive primes below<b> $limit </b>that addss to a prime, contains<b> $term</b> terms, and is equal to <b>$sum_of_prime<b>."; 
?>
