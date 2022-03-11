<?
include_once('_common.php');

$secret_key = "thelog0780";
$secret_iv = "#@$%^&*()_+=-";

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

// print_r(Encrypt('::1',$secret_key,$secret_iv));
// print_r(Encrypt('logcompany',$secret_key,$secret_iv));

?>