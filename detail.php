<?php
/**
 * Created by PhpStorm.
 * User: KHADAFI
 * Date: 7/5/2016
 * Time: 1:23 PM
 */

require_once "api.php";

if (isset($_GET['trans_id'])) {
    $trans_id = $_GET['trans_id'];
    $result = getTransaksiDetail($trans_id);
    //echo $result;
    $data = json_decode($result);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Sample</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/select2.min.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="container">
    <div class="row">

        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Detail Transaksi</div>
                <div class="panel-body">
                    <form class="form-horizontal" id="form_submit" method="post" action="api.php">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Tanggal</label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->created_at ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Transaksi ID</label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->trans_id ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Produk </label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->product_name ?>
                                    - <?= $data->product_detail ?></p>
                            </div>
                        </div>


                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">No HP</label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->no_hp ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">No Pelanggan</label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->no_pelanggan ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Harga</label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->harga ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Status</label>

                            <div class="col-sm-10">
                                <?php
                                $lable_status = "";
                                if ($data->status_id == 5) {
                                    $lable_status = "label-warning";
                                } else if ($data->status_id == 1 || $data->status_id == 14) {
                                    $lable_status = "label-danger";
                                } else if ($data->status_id == 4) {
                                    $lable_status = "label-success";
                                } else {
                                    $lable_status = "label-info";
                                }
                                ?>
                                <p class="form-control-static"><label class="label label-sm <?=$lable_status?>"><?= $data->status ?></label></p>
                            </div>
                        </div>

                        <?php
                            if($data->status_id == 4){
                            ?>

                                <a target="_blank" href="struk.php?trans_id=<?= $data->trans_id ?>" class="btn btn-primary">Download Struk</a>
                                <?php
                            }
                        ?>

                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/jquery.form.min.js"></script>

</body>

</html>
