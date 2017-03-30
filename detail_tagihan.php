<?php
/**
 * Created by PhpStorm.
 * User: KHADAFI
 * Date: 7/5/2016
 * Time: 1:23 PM
 */

require_once "api.php";
$tagihan_bayar = false;
$mesage = "";
if (isset($_POST['product'])) {

    $result = cekTagihan();
    echo $result;
    $data = json_decode($result);

    if($data->error){
//        echo $data->message;
        $message = $data->message;
//        exit;
    }else{
        $tagihan_bayar = true;
        $data = $data->data;
        $_SESSION['jumlah_bayar']= $data->jumlah_bayar;
    }

//    exit;
}else{
    echo "invalid tagihan ";
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
        <?php
        if($tagihan_bayar){
        ?>


        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Detail Tagihan</div>
                <div class="panel-body">
                    <form class="form-horizontal" id="form_submit" method="post" action="api.php">
                        <input type="hidden" value="<?= $data->tagihan_id ?>" name="trans_id">
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Tagihan ID</label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->tagihan_id ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Produk </label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?=$_POST['product']?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Nama</label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->nama ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Periode</label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->periode ?></p>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Jumlah Tagihan</label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->jumlah_tagihan ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Admin Fee</label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->admin ?></p>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label" for="exampleInputPassword1">Total Bayar</label>

                            <div class="col-sm-10">
                                <p class="form-control-static"><?= $data->jumlah_tagihan+$data->admin ?></p>
                            </div>
                        </div>
                        <button type="submit" id="btn_submit" class="btn btn-default">Bayar</button>

                    </form>
                </div>
            </div>

        </div>
        <?php}else {?>

        <div class="col-md-12">
            <div class="alert alert-danger"><?php echo $message;?></div>
            </div>
        <?php}?>
    </div>
</div>

<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<!-- Include all compiled plugins (below), or include individual files as needed -->
<script src="js/bootstrap.min.js"></script>
<script src="js/select2.min.js"></script>
<script src="js/jquery.form.min.js"></script>

<script>
    var options = {
        beforeSubmit: function () {
            $("#btn_submit").button("loading");
        },
        error: function (data) {

            $("#btn_submit").button("reset");

        },

        success: function (data) {
            $("#btn_submit").button("reset");
            if(data.error){
                alert(data.message);
            }else {
                window.location.href = "detail.php?trans_id="+data.trans_id;
            }

        },
        dataType: 'json',
        data : {
            method : 'bayar'
        }
    };

    // pass options to ajaxForm
    $('#form_submit').ajaxForm(options);
</script>
</body>

</html>
