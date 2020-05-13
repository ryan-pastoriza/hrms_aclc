<?php
/**
 * @Author: khrey
 * @Date:   2015-09-29 10:10:23
 * @Last Modified by:   gian
 * @Last Modified time: 2016-01-08 10:35:47
 */
defined('BASEPATH') OR exit('No direct script access allowed');

class Funcs
{
	protected $ci;

	public function __construct()
	{
        $this->ci =& get_instance();
	}

	public function range($int = false, $min = false, $max = false, $exclude = false)
	{
		if ($exclude) {
			return ($min<=$int && $int<=$max);
		}
		 return ($min<$int && $int<$max);
	}	
	public function time_interval($fromTime = false, $toTime = false)
	{
		$fromTime = new DateTime($fromTime);
	    $toTime = new DateTime($toTime);
	    return $fromTime->diff($toTime);
	}
	public function search_in_array($array, $key, $value)
	{
		$toret = false;
	    $results = array();

	    if (is_array($array)) {
	        if (isset($array[$key]) && $array[$key] == $value) {
	            $results[] = $array;
	        }
	        
	        foreach ($array as $subarray) {
	            $results = array_merge($results, $this->search_in_array($subarray, $key, $value));
	        }
	    }
	    elseif (is_object($array)) {
	    	if (isset($array->$key) && $array->$key == $value) {
	        	$results[] = $array;
	        }

	    }

	    return $results;
	}
	public function datesInArray($fDate,$tDate){
		// returns each date in an array
		$fDate 	    = new DateTime( $fDate );
		$tDate 	    = new DateTime( $tDate ." + 1 day" );
		$interval 	= DateInterval::createFromDateString('1 day');
		$period 	= new DatePeriod($fDate, $interval, $tDate);
		
		return $period;
	}

}

/* End of file funcs.php */
/* Location: ./application/libraries/funcs.php */
