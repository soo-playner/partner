<?
include_once('_common.php');

$secret_key = "thelog0780";
$secret_iv = "#@$%^&*()_+=-";

$now_date_time = G5_TIME_YMDHIS;

function Encrypt($str, $secret_key='', $secret_iv='') { 
    $key = hash('sha256', $secret_key); 
    $iv = substr(hash('sha256', $secret_iv), 0, 32) ; 
    return str_replace("=", "", base64_encode( openssl_encrypt($str, "AES-256-CBC", $key, 0, $iv)) );
} 

function Decrypt($str, $secret_key='', $secret_iv='') { 
    $key = hash('sha256', $secret_key); 
    $iv = substr(hash('sha256', $secret_iv), 0, 32);
    return openssl_decrypt( base64_decode($str), "AES-256-CBC", $key, 0, $iv ); 
}

function isExpToken($str){
    global $secret_key,$secret_iv;
    Decrypt($str,$secret_key,$secret_iv);
}

function APIKEY($str){
    global $secret_key,$secret_iv;
    // $result = Decrypt($str,$secret_key,$secret_iv);
    $result = sql_query("SELECT * from license WHERE apikey = '{$str}' AND period = 1 ");
    $res_cnt = sql_num_rows($result);
    if($res_cnt > 0){
        return true;
    }else{
        return false;
    }
}

/* print_r(Encrypt('211.238.13.217',$secret_key,$secret_iv));
echo "<br>";
print_r(Decrypt('OXZ6bWw3UnR6VEJDZ3JVTzZIRzRyUT09',$secret_key,$secret_iv));
echo "<br>"; */
// print_R(Encrypt('samwoo',$secret_key,$secret_iv));


$headers = getallheaders();
$content_type = $headers['Content-Type'];
$authyn = false;

if(isset($headers["Authorization"])){
    $authStr = $headers["Authorization"];
    $jwttoken = str_replace("Bearer ", "", $authStr);
    $authyn = APIKEY($jwttoken);
}

// API_KEY 
if($authyn){
    if( $content_type == 'application/json' ){
        $data = $json_array = json_decode(file_get_contents('php://input'), true);
    }else{
        $data = $_POST;
    }

    if($data['registration'] && $data['ip']){
        $license_use = sql_fetch("SELECT * from license WHERE license = '{$data['registration']}' AND ip = '{$data['ip']}' ");
        
        if($license_use){
            $up_sql = "UPDATE license set used = used + 1 WHERE license = '{$license_use['license']}' ";
            $update = sql_query($up_sql);
            echo (json_encode(array("success" => $license_use['license'],"own" => $license_use['client'],"code" => 200)));
        }else{
            echo (json_encode(array("error" => "Bad Request OR Key INVALID","code" => 400)));
            sql_query("INSERT INTO license_use SET apikey= '{$jwttoken}', license = '{$data['registration']}',datetime = '{$now_date_time}', ip = '{$data['ip']}' ");
        }

    }else{
        echo (json_encode(array("error" => "Bad Request","code" => 400)));
    }
    
}else{
    echo (json_encode(array("error" => "API KEY INVALID","code" => 401)));
}





// ob_clean
// echo (json_encode(array("result" => "failed", "code" => "0005", "sql" => "대상자 업데이트 오류")));
?>