<?php
/**
 * Created by PhpStorm.
 * User: khadafi
 * Date: 7/20/2016
 * Time: 1:19 PM
 */

require_once "api.php";

$id = $_GET['trans_id'];
$file_name = "Struk_pembelian_id_".$id;
header('Content-type: application/pdf');
header('Content-Disposition: inline; filename="' . $file_name . '"');
$result = download_struk($id);
echo $result;