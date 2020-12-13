<?php
include '../calander/vendor/autoload.php';
/**
 * Converter
 */
class calendar extends Db
{
	private $exploader;

	public function toGrig($date){
		$this->exploader = explode("/", $date);
		$obj = Andegna\DateTimeFactory::of($this->exploader[2], $this->exploader[1], $this->exploader[0]);
		$out_obj = $obj->toGregorian()->format('m/j/Y');

		return $out_obj;// m/d/y
	}

	public function toEthNum($date){
		$gregorian = new DateTime($date);
		$ethopic = new Andegna\DateTime($gregorian);   

		$output =  $ethopic->format("j/m/Y");
		$exp = explode("/", $output);

		if($exp[0] < 10 && $exp[0] > 0){
			$mainout = "0".$exp[0]."/".$exp[1]."/".$exp[2];
		}else{
			$mainout = $exp[0]."/".$exp[1]."/".$exp[2];
		}
		return $mainout; // m/d/y
	}


	public function toEthStr($date){
		$gregorian = new DateTime($date);
		$ethopic = new Andegna\DateTime($gregorian);   

		$output =  $ethopic->format("F j, Y");

		return $output; // ኅዳር 5, 2013
	}

	public function Now(){
		$gregorian_1 = new DateTime('now');
		$ethopic_1 = new Andegna\DateTime($gregorian_1);

		$year_1 =  $ethopic_1->getYear();  
		$month_1 =  $ethopic_1->getMonth(); 
		$day_1 =  $ethopic_1->getDay();    

		$output_1 =  $day_1.'/'.$month_1.'/'.$year_1;

		return $output_1; // m/d/y 
	}

	public function nowMonthYear(){
		$gregorian_1 = new DateTime('now');
		$ethopic_1 = new Andegna\DateTime($gregorian_1);

		$year_1 =  $ethopic_1->getYear();  
		$month_1 =  $ethopic_1->getMonth(); 
		$day_1 =  $ethopic_1->getDay();    

		$output_1 =  array($month_1,$year_1);

		return $output_1; // (m,y) 
	}

	public function toEthNumYear(){
		$gregorian = new DateTime('now');
		$ethopic = new Andegna\DateTime($gregorian);   

		$output =  $ethopic->format("Y");

		return $output; // y
	}

	public function feeType($value)
	{
		if ($value == 0) {
			return "Cash";
		}elseif($value == 1){
			return "Bank";
		}
	}

	public function revenueStatus($value)
	{
		if ($value == 0) {
			return "Waiting";
		}elseif($value == 1){
			return "Approved";
		}elseif($value == 2){
			return "Not Aproved";
		}
	}

	public function monthsForDisplay($value)
	{
		if ($value == 1) {
			return "መስከረም";
		}elseif($value == 2){
			return "ጥቅምት";
		}elseif($value == 3){
			return "ኅዳር";
		}elseif($value == 4){
			return "ታኅሣሥ";
		}elseif($value == 5){
			return "ጥር";
		}elseif($value == 6){
			return "የካቲት";
		}elseif($value == 7){
			return "መጋቢት";
		}elseif($value == 8){
			return "ሚያዝያ";
		}elseif($value == 9){
			return "ግንቦት";
		}elseif($value == 10){
			return "ሰኔ";
		}elseif($value == 11){
			return "ሐምሌ";
		}elseif($value == 12){
			return "ነሐሴ";
		}
	}

	public function monthsArrayForDisplay($month1, $month2, $year1, $year2)
	{
		if($month2 != ""){
			$firstElm = $this->monthsForDisplay($month1)."/".$year1;
			$lastElm = $this->monthsForDisplay($month2)."/".$year2;
			
			$output = array(
				'Vis' => $firstElm." - ".$lastElm, 
				'Num' => array($month1."/".$year1, $month2."/".$year2));
			return $output;

		}elseif ($month2 == "") {
			$output = array(
				'Vis' => $this->monthsForDisplay($month1)."/".$year1, 
				'Num' => array($month1."/".$year1));
			return $output;
		}
	}

	public function timeElapsedString($datetime) {
		date_default_timezone_set("Africa/Addis_Ababa");
	    $now = new DateTime(date("Y-m-d h:i:s"));
	    $ago = new DateTime($datetime);
	    $diff = $now->diff($ago);

	    $diff->w = floor($diff->d / 7);
	    $diff->d -= $diff->w * 7;

	    $string = array(
	        'y' => 'year',
	        'm' => 'month',
	        'w' => 'week',
	        'd' => 'day',
	        'h' => 'hour',
	        'i' => 'minute',
	        's' => 'second',
	    );
	    foreach ($string as $k => &$v) {
	        if ($diff->$k) {
	            $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
	        } else {
	            unset($string[$k]);
	        }
	    }

	    if(isset($string['y'])){
	    	$outProp = $string['y'];
	    }elseif(isset($string['m'])){
	    	$outProp = $string['m'];
	    }elseif(isset($string['w'])){
	    	$outProp = $string['w'];
	    }elseif(isset($string['d'])){
	    	$outProp = $string['d'];
	    }elseif(isset($string['h'])){
	    	$outProp = $string['h'];
	    }elseif(isset($string['i'])){
	    	$outProp = $string['i'];
	    }elseif(isset($string['s'])){
	    	$outProp = $string['s'];
	    }

	    return $outProp ;
	}

}