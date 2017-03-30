<?php
/**
 * Created by PhpStorm.
 * User: KHADAFI
 * Date: 7/5/2016
 * Time: 10:58 AM
 */

session_start();
//silahkan register dulu di bisatopup.com, kemudian kontak daffigusti0890@gmail.com untuk selanjutnya.
$api_key = "";


function http_post($url, $param)
{
    //set POST variables
    global $api_key;
    $fields_string = http_build_query($param);

    $headers = array();
    $headers[] = "X-Authorization: $api_key";

    //open connection
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:39.0) Gecko/20100101 Firefox/39.0");
    //set the url, number of POST vars, POST data
    curl_setopt($ch, CURLOPT_URL, $url);

    curl_setopt($ch, CURLOPT_REFERER, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $fields_string);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    //execute post
    $result = curl_exec($ch);
    //echo $result;
    //exit;
    //close connection
    curl_close($ch);
    return $result;
}

function http_get($url)
{
    global $api_key;
    // is cURL installed yet?
    if (!function_exists('curl_init')) {
        die('Sorry cURL is not installed!');
    }

    // OK cool - then let's create a new cURL resource handle
    $ch = curl_init();

    // Now set some options (most are optional)

    // Set URL to download
    curl_setopt($ch, CURLOPT_URL, $url);
    $headers = array();
    $headers[] = "X-Authorization: $api_key";

    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    // Set a referer
    curl_setopt($ch, CURLOPT_REFERER, $url);

    // User agent
    curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.3; WOW64; rv:39.0) Gecko/20100101 Firefox/39.0");

    // Include header in result? (0 = yes, 1 = no)
    curl_setopt($ch, CURLOPT_HEADER, 0);

    // Should cURL return or print out the data? (true = return, false = print)
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Timeout in seconds
    curl_setopt($ch, CURLOPT_TIMEOUT, 120);

    // Download the given URL, and return output
    $output = curl_exec($ch);

    // Close the cURL resource, and free system resources
    curl_close($ch);

    return $output;

}

if (isset($_POST['method'])) {
    $method = $_POST['method'];
    if ($method == "product") {
        echo getProduct();
    } else if ($method == "daftar_product") {
        $id = $_POST['id'];
        echo getProductDetail($id);
    } else if ($method == "nominal") {
        $id = $_POST['id'];
        echo getNominal($id);
    } else if ($method == "harga") {
        $id = $_POST['id'];
        echo getHarga($id);
    } else if ($method == "beli") {
        echo beli();
    }else if ($method == "bayar") {
        echo bayar_tagihan();
    }
}

function getProduct()
{
    $url = "http://api.bisatopup.com/product";

    $result = http_get($url);
    return $result;
}

function getProductDetail($id)
{
    $url = "http://api.bisatopup.com/product/daftar/$id";
    $result = http_get($url);
    return $result;
}

function getNominal($id)
{
    $url = "http://api.bisatopup.com/product/detail/$id";
    $result = http_get($url);
    return $result;

}

function getHarga($id)
{
    $url = "http://api.bisatopup.com/harga/product/$id";
    $result = http_get($url);

    $data = json_decode($result);
    // var_dump($data);
    $price = $data->base_price + 100;

    $data->base_price = $data->base_price + 100;

    $result = json_encode($data);

    return $result;
}

function getTransaksiDetail($id)
{
    $url = "http://api.bisatopup.com/transaksi/detail/$id";
    $result = http_get($url);
    return $result;
}

function download_struk($id)
{
    $url = "http://api.bisatopup.com/transaksi/download-struk/$id";
    $result = http_get($url);
    return $result;
}
function cekTagihan()
{
    $url = "http://api.bisatopup.com/tagihan/cek";
    $post_param = [
        'product' => $_POST['product'],
        'phone_number' => $_POST['nomor_hp'],
        'nomor_rekening' => $_POST['nomor_rekening'],
    ];
    $result = http_post($url,$post_param);
    return $result;
}

function beli()
{

    $product_detail = $_POST['product_detail'];
    $hargaagent = $_POST['hargaagent'];
    $no_hp = $_POST['no_tujuan'];

    if ($hargaagent > 20000) {
        $error = "Gagal, Saldo anda tidak cukup, silahkan Melakukan Topup";

        return json_encode([
            'error'=>true,
            'message'=>$error
        ]);
    } else {
        $post_param = [
            'product_detail' => $product_detail,
            'phone_number' => $no_hp
        ];
        $result = http_post("http://api.bisatopup.com/transaksi/beli", $post_param);


        return $result;
    }
}

function bayar_tagihan()
{

    $trans_id = $_POST['trans_id'];
    $hargaagent = $_SESSION['jumlah_bayar'];
    $hargaagent = $hargaagent + 1000;

    if ($hargaagent > 400000) {
        $error = "Gagal, Saldo anda tidak cukup, silahkan Melakukan Topup";

        return json_encode([
            'error'=>true,
            'message'=>$error
        ]);
    } else {
        $post_param = [
            'transaction_id' => $trans_id
        ];
        $result = http_post("http://api.bisatopup.com/transaksi/bayar", $post_param);


        return $result;
    }
}