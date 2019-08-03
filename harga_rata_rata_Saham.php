<?php  
	function apiRequest ($method, $url, $data){
			$ch = curl_init();

			switch ($method){
		      case "POST":
		         curl_setopt($ch, CURLOPT_POST, 1);
		         if ($data)
		            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
		         break;
		      case "PUT":
		         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
		         if ($data)
		            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));			 					
		         break;
		     case "DELETE":
		         curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		         if ($data)
		            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));			 					
		         break;   
		      default:
		         if ($data)
		            $url = sprintf("%s?%s", $url, http_build_query($data));
		   }

	        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: application/json"));
	        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
	        curl_setopt($ch, CURLOPT_HEADER, FALSE);
	        curl_setopt($ch, CURLOPT_URL, $url);
	        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT ,0);
	        curl_setopt($ch, CURLOPT_TIMEOUT, 400);

	        $results = curl_exec($ch);
	        curl_close($ch);

	        if ($results) {
	            $json_results = json_decode(utf8_encode($results),TRUE);
	            return $json_results;
	        } else {
	        	return "Request Failed.";
	        }
		}
	$jumlah=0;
	$tamp=0;
	$url = 'https://www.idx.co.id/umbraco/Surface/ListedCompany/GetTradingInfoSS?code=CPIN&length=100';
    $results = apiRequest('GET',$url,null);
    $nilai1=0;
    $nilai2=0;
    $nilai3=0;
    $nilai4=0;
    $nilai5=0;
    $c_senin=0;
    $c_selasa=0;
    $c_rabu=0;
    $c_kamis=0;
    $c_jumat=0;
    $c_sabtu=0;
    foreach ($results['replies'] as $key) {
    	//$num = date('N', strtotime($key['Date'])); 
		 $date=$key['Date']; 
		 $date=substr($date,0,10 );
		 $dayOfWeek = date("l", strtotime($date));
		 if($dayOfWeek=="Monday"){
		 	$nilai1+=$key['Close'];
		 	$c_senin++;
		 	$dayOfWeek="Senin";
		 }else if($dayOfWeek=="Tuesday"){
		 	$nilai2+=$key['Close'];
		 	$c_selasa++;
		 	$dayOfWeek="Selasa";
		 }else if($dayOfWeek=="Wednesday"){
		 	$nilai3+=$key['Close'];
		 	$c_rabu++;
		 	$dayOfWeek="Rabu";
		 }else if($dayOfWeek=="Thursday"){
		 	$nilai4+=$key['Close'];
		 	$c_kamis++;
		 	$dayOfWeek="Kamis";
		 }else if($dayOfWeek=="Friday"){
		 	$nilai5+=$key['Close'];
		 	$c_jumat++;
		 	$dayOfWeek="Jumat";
		 }		
		// echo $dayOfWeek;
		// //echo $day;
		// echo ":";
		// echo $hari[$num];
    	// echo $key['Close'];
    	// $tamp+=$key['Close'];
    	// $jumlah++;
    	// echo "<br>";
    }
    $hasil = array(	'Senin' => number_format(($nilai1/$c_senin),2) ,
    				'Selasa'=> number_format(($nilai2/$c_selasa),2),
    				'Rabu'=> number_format(($nilai3/$c_rabu),2),
    				'Kamis'=> number_format(($nilai4/$c_kamis),2),
    				'Jumat'=> number_format(($nilai5/$c_jumat),2)

     );
    $hasil_json=json_encode($hasil);
    echo ($hasil_json);
   
     
    
?>