<?php
date_default_timezone_set("Asia/Bangkok");
define('DB_SERVER','localhost');
define('DB_USER','root');
define('DB_PASS' ,'');
/*define('DB_PASS' ,'ri,,skik=');*/
define('DB_NAME', 'method_statement');

class db_conn{
	var $DB;
	function __construct(){
	//	$conDB = mysqli_connect(DB_SERVER,DB_USER,DB_PASS) or die('localhost connection problem'.mysqli_error());
		$conDB = mysqli_connect(DB_SERVER,DB_USER,DB_PASS) or die('localhost connection problem:' . mysqli_connect_error());
		$this->DB = $conDB;
		mysqli_select_db($conDB,DB_NAME);
		mysqli_query($this->DB,"SET NAMES utf8");
	}
	public function sqlQuery($strSQL){
		mysqli_query($this->DB,"SET NAMES utf8");
		$objQuery = mysqli_query($this->DB, $strSQL);
		return $objQuery;
	}
	
	/**
	 * Summary of sqlEscapestr
	 * @param mixed $value
	 * @return string
	 */
	public function sqlEscapestr($value){
		if($value != ''){
			$obj = mysqli_real_escape_string($this->DB,$value);
		}else{
			$obj = $value;
		}
		return $obj;
	}
	function DateThai($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
		$strMonthThai=$strMonthCut[$strMonth];
		if($strDate==''){
			$returnstr ='';
		}else{
			$returnstr="$strDay $strMonthThai $strYear";
		}
		return "$returnstr";
	}

	function DateThaifull($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม
		");
		$strMonthThai=$strMonthCut[$strMonth];
		
		if($strDate==''){
			$returnstr ='';
		}else{
			$returnstr="$strDay $strMonthThai $strYear";
		}
		return "$returnstr";
	}
	function Monthen($strDate)
	{
		$strYear = date("Y",strtotime($strDate))+543;
		$strMonth= date("n",strtotime($strDate));
		$strDay= date("j",strtotime($strDate));
		$strHour= date("H",strtotime($strDate));
		$strMinute= date("i",strtotime($strDate));
		
		$strSeconds= date("s",strtotime($strDate));
		$strMonthCut = Array("","Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Nov
		");
		$strMonth=$strMonthCut[$strMonth];
		
		if($strDate==''){
			$returnstr ='';
		}else{
			$returnstr="$strDay $strMonth $strYear";
		}
		return "$returnstr";
	}

}
?>