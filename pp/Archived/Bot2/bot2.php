<?php
error_reporting(0);
function getStr($string, $start, $end)
{
        $str = explode($start, $string);
        $str = explode($end, ($str[1]));
        return $str[0];
}

function warna($text, $warna)
{
        $warna = strtoupper($warna);
        $list = array();
        $list['BLACK'] = "\033[30m";
        $list['RED'] = "\033[31m";
        $list['GREEN'] = "\033[32m";
        $list['YELLOW'] = "\033[33m";
        $list['BLUE'] = "\033[34m";
        $list['MAGENTA'] = "\033[35m";
        $list['CYAN'] = "\033[36m";
        $list['WHITE'] = "\033[37m";
        $list['RESET'] = "\033[39m";
        $warna = $list[$warna];
        $reset = $list['RESET'];
        if (in_array($warna, $list)) {
                $text = "$warna$text$reset";
        } else {
                $text = $text;
        }
        return $text;
}
function jpy_to_twd($cookie, $csrf)
{
        $arr = array("\r", "	");
        $url = "https://www.paypal.com/myaccount/money/api/currencies/transfer";
        $h = explode("\n", str_replace($arr, "", "Cookie: $cookie
	Content-Type: application/json
	user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/79.0.3945.130 Safari/537.36"));
        $body = "{\"sourceCurrency\":\"JPY\",\"sourceAmount\":2,\"targetCurrency\":\"TWD\",\"_csrf\":\"$csrf\"}";
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $h);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $body);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $x = curl_exec($ch);
        curl_close($ch);
        return json_decode($x, true);
}
echo "#################\n#  @muhtoevill  #\n#   SGB-Team    #\n#  Binary-Team  #\n#################\n";
echo "DWYOR JANGAN SALAHKAN SAYA BILA TERJADI SESUATU YANG TIDAK MENYENANGKAN\n";
//echo "Berapa kali: ";
//$loop = trim(fgets(STDIN));
$loop = 3;
$file = file_get_contents("cookie.txt");
$cookie = $file;
$csrf = file_get_contents("csrf.txt");
for ($x = 0; $x < $loop; $x++) {
        $jpy_to_twd =  jpy_to_twd($cookie, $csrf);
        $output_send_jpy_twd = json_encode($jpy_to_twd);
        $amount = getStr($output_send_jpy_twd, '"value":"', '"');
        if (strpos($output_send_jpy_twd, "null") == true) {
                $text3 = "Berhasil convert 2 JPY  to $amount TWD";
                echo date('d-m-Y H:i:s ') . $text3 . "\n";
        } else {
                $text4 = "Gagal Convert";
                echo date('d-m-Y H:i:s ') . $text4 . "\n";
        }
        sleep(1);
}
