<?php
header('Content-type: text/html; charset=utf-8');


function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    echo($result);
    return $result;
}

$endpoint = 'https://test-payment.momo.vn/v2/gateway/api/pos';
$accessKey = 'F8BBA842ECF85';
$secretKey = 'K951B6PE1waDMi640xX08PD3vg6EkVlz';
$orderInfo = 'pay with MoMo';
$partnerCode = 'MOMO';
$redirectUrl = 'https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b';
$ipnUrl = 'https://webhook.site/b3088a6a-2d17-4f8d-a383-71389a6c600b';
$amount = '50000';
$orderId = time()."";
$requestId = time()."";
$extraData ='';
$partnerName = 'MoMo Payment';
$storeId = 'Test Store';
$paymentCode = 'L/U2a6KeeeBBU/pQAa+g8LilOVzWfvLf/P4XOnAQFmnkrKHICj51qrOTUQ+YrX8/Xs1YD4IOdyiGSkCfV6Je9PeRzl3sO+mDzXNG4enhigU3VGPFh67a37dSwItMJXRDuK64DCqv35YPQtiAOVVZV35/1XBw1rWopmRP03YMNgQWedGLHwmPSkRGoT6XtDSeypJtgbLZ5KIOJsdcynBdFEnHAuIjvo4stADmRL8GqdgsZ0jJCx/oq5JGr8wY+a4g9KolEOSTLBTih48RrGZq3LDBbT4QGBjtW+0W+/95n8W0Aot6kzdG4rWg1NB7EltY6/A8RWAHJav4kWQoFcxgfA==';
$orderGroupId ='';
$autoCapture =True;
$lang = 'vi';

if (!empty($_POST)) {

    $accessKey = $_POST["accessKey"];
    $secretKey = $_POST["secretKey"];
    $orderInfo = $_POST["orderInfo"];
    $partnerCode = $_POST["partnerCode"];
    $redirectUrl = $_POST["redirectUrl"];
    $amount = $_POST["amount"];
    $orderId = $_POST["orderId"];
    $paymentCode = $_POST["paymentCode"];
    $orderGroupId = $_POST["orderGroupId"];

    $requestId = time().'';
    $extraData = "";
    //before sign HMAC SHA256 signature
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&paymentCode=" . $paymentCode . "&requestId=" . $requestId;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array(
        'partnerCode' => $partnerCode,
        'partnerName' => "Test",
        'storeId' => 'MomoTestStore',
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'autoCapture' => autoCapture,
        'extraData' => $extraData,
        'paymentCode' => $paymentCode,
        'orderGroupId' => $orderGroupId,
        'signature' => $signature);
    $result = execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);  // decode json

    //Just a example, please check more in there
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>MoMo Sandbox</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.4.1/css/bootstrap.min.css"/>
    <link rel="stylesheet"
          href="./statics/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css"/>
    <!-- CSS -->
</head>
<body>
<div class="container">
    <div class="row">
        <div class="col-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Quick Pay/Thanh toán bằng QR các nhân. More detail at <a style="color: #2f80d1" href="https://developers.momo.vn/v3/vi/docs/payment/api/quick-pay-v2/">here</a></h3>
                </div>
                <div class="panel-body">
                    <form class="" method="POST" target="_blank" enctype="application/x-www-form-urlencoded"
                          action="index.php">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">PartnerCode</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="partnerCode" value="<?php echo $partnerCode; ?>"
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">AccessKey</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="accessKey" value="<?php echo $accessKey;?>"
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">SecretKey</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="secretKey" value="<?php echo $secretKey; ?>"
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">OrderId</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="orderId" value="<?php echo $orderId; ?>"
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">ExtraData</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' type="text" name="extraData" value="<?php echo $extraData?>"
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">OrderInfo</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="orderInfo" value="<?php echo $orderInfo; ?>"
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">Amount</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="amount" value="<?php echo $amount; ?>" class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">paymentCode</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="paymentCode" value="<?php echo $paymentCode; ?>"
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="fxRate" class="col-form-label">RedirectUrl</label>
                                    <div class='input-group date' id='fxRate'>
                                        <input type='text' name="redirectUrl" value="<?php echo $redirectUrl; ?>"
                                               class="form-control"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <p>
                        <div style="margin-top: 1em;">
                            <button type="submit" class="btn btn-primary btn-block">Start MoMo payment....</button>
                        </div>
                        </p>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>

<script type="text/javascript" src="./statics/jquery/dist/jquery.min.js"></script>
<script type="text/javascript" src="./statics/moment/min/moment.min.js"></script>
</html>
