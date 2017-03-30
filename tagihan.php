<?php
/**
 * Created by PhpStorm.
 * User: KHADAFI
 * Date: 7/4/2016
 * Time: 10:37 AM
 */

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
                <div class="panel-heading">Pulsa & PPOB</div>
                <div class="panel-body">
                    <form id="form_submit" method="post" action="detail_tagihan.php">

                        <div class="form-group">
                            <label for="exampleInputPassword1">Produk</label>
                            <select id="product" class="select2 form-control">

                            </select>
                        </div>

                        <div class="form-group" style="display: none" id="daftar_produk_div">
                            <label for="exampleInputPassword1">Daftar Produk</label>
                            <select id="daftar_product" name="product" class="select2 form-control">

                            </select>
                        </div>


                        <div class="form-group" style="display: none" id="no_hp">
                            <label for="exampleInputPassword1">Masukkan Nomor Handphone anda</label>
                           <input required type="text" class="form-control" name="nomor_hp" placeholder="Contoh : 085212342343">
                        </div>
                        <div class="form-group" style="display: none" id="nomor_rekening">
                            <label for="exampleInputPassword1">Masukkan Nomor Tujuan</label>
                            <input required type="text" class="form-control" name="nomor_rekening" placeholder="Masukkan nomor rekening / nomor pelanggan">
                        </div>


                        <button type="submit" id="btn_submit" class="btn btn-default">Submit</button>
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

<script type="text/javascript">
    $(document).ready(function () {
//        $(".select2").select2();

        $("#product").select2({
            placeholder: "Pilih produk",
            ajax: {
                type: 'post',
                url: 'api.php',
                dataType: 'json',
                data: function () {
                    return {
                        id : 20,
                        method : 'daftar_product'
                    };
                },
                cache: true,
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj) {
                            return {id: obj.product_id, text: obj.product_name};
                        })
                    };
                }
            }
        });

        var $eventSelect = $("#product");
        $eventSelect.on("change", function (e) {
            var id = $(this).val();

            loadProductDetail(id);
        });


    });

    function loadProductDetail(id){
        $("#daftar_produk_div").show();
        $("#daftar_product").html("");
        $("#daftar_product").select2({
            placeholder: "Pilih tagihan",
            ajax: {
                type: 'post',
                url: 'api.php',
                dataType: 'json',
                data: function () {
                    return {
                        id : id,
                        method : 'daftar_product'
                    };
                },
                processResults: function (data) {
                    return {
                        results: $.map(data, function (obj) {
                            return {id: obj.code, text: obj.product_name};
                        })
                    };
                },
                cache: true
            }
        });

        var $eventSelect = $("#daftar_product");
        $eventSelect.on("change", function (e) {
            var id = $(this).val();
            $("#no_hp").show();
            $("#nomor_rekening").show();
        });
    }


</script>

</body>

</html>
