<?php
class TPBANK
{
	public function get_token($username, $password)
	{
		$url = "https://ebank.tpb.vn/gateway/api/auth/login";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
			"DEVICE_ID: LYjkjqGZ3HhGP5520GxPP2j94RDMC7Xje77MI7" . rand(10000000, 999999999999),
			"PLATFORM_VERSION: 91",
			"DEVICE_NAME: Chrome",
			"SOURCE_APP: HYDRO",
			"Authorization: Bearer",
			"Content-Type: application/json",
			"Accept: application/json, text/plain, */*",
			"Referer: https://ebank.tpb.vn/retail/vX/login?returnUrl=%2Fmain",
			"sec-ch-ua-mobile: ?0",
			"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36",
			"PLATFORM_NAME: WEB",
			"APP_VERSION: 1.3",
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = '{"username":"' . $username . '","password":"' . $password . '"}';

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		return $resp;
	}
	public function get_history($token, $stk_tpbank)
	{
		$ngay_bat_dau_check = date("Ymd");
		$ngay_ket_thuc_check = date("Ymd");
		// 	$ngay_bat_dau_check = '20220421';
		// $ngay_ket_thuc_check = '20220428';
		$url = "https://ebank.tpb.vn/gateway/api/smart-search-presentation-service/v1/account-transactions/find";

		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_POST, true);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

		$headers = array(
			"Connection: keep-alive",
			"DEVICE_ID: LYjkjqGZ3HhGP5520GxPP2j94RDMC7Xje77MI7" . rand(10000000, 999999999999),
			"PLATFORM_VERSION: 91",
			"DEVICE_NAME: Chrome",
			"SOURCE_APP: HYDRO",
			"Authorization: Bearer " . $token,
			"XSRF-TOKEN=3229191c-b7ce-4772-ab93-55a" . rand(10000000, 999999999999),
			"Content-Type: application/json",
			"Accept: application/json, text/plain, */*",
			"sec-ch-ua-mobile: ?0",
			"User-Agent: Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/91.0.4472.164 Safari/537.36",
			"PLATFORM_NAME: WEB",
			"APP_VERSION: 1.3",
			"Origin: https://ebank.tpb.vn",
			"Sec-Fetch-Site: same-origin",
			"Sec-Fetch-Mode: cors",
			"Sec-Fetch-Dest: empty",
			"Referer: https://ebank.tpb.vn/retail/vX/main/inquiry/account/transaction?id=" . $stk_tpbank,
			"Accept-Language: vi-VN,vi;q=0.9,fr-FR;q=0.8,fr;q=0.7,en-US;q=0.6,en;q=0.5",
			"Cookie: _ga=GA1.2.1679888794.1623516" . rand(10000000, 999999999999) . "; _gid=GA1.2.580582711.162" . rand(10000000, 999999999999) . "; _gcl_au=1.1.756417552.162" . rand(10000000, 999999999999) . "; Authorization=" . $token,
		);
		curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

		$data = '{"accountNo":"' . $stk_tpbank . '","currency":"VND","fromDate":"' . $ngay_bat_dau_check . '","toDate":"' . $ngay_ket_thuc_check . '","keyword":""}';

		curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

		//for debug only!
		curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

		$resp = curl_exec($curl);
		curl_close($curl);
		return $resp;
	}
}

$TPBANK = new TPBANK;
//bước 1
echo $TPBANK->get_token('sdt','pass');
//bước 2: khi lấy được token rồi dán vào 
$token = "token lấy được từ bước 1";
$stk ="số tài khoản của bạn";
echo $TPBANK->get_history($token,$stk);
