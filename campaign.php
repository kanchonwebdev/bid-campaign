<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
date_default_timezone_set("Asia/Dhaka");


$requestMethod = strtoupper($_SERVER['REQUEST_METHOD']);
if ($requestMethod != "POST") {
    header($_SERVER["SERVER_PROTOCOL"] . " 204 method not allowed", true, 204);
    echo json_encode(['error' => 'Method not allowed']);
    exit;
} elseif (!isset($_SERVER['PHP_AUTH_USER'])) {
    header("WWW-Authenticate: Basic realm=\"Private Area\"");
    header("HTTP/1.0 401 Unauthorized");
    echo json_encode(['error' => 'Sorry, you need proper credentials']);
    exit;
} else {
    if ($_SERVER['PHP_AUTH_USER'] == "johndeo" && $_SERVER['PHP_AUTH_PW'] == "123") {
        header("HTTP/1.1 200 OK");
        header('Content-Type: application/json');
    } else {
        header("WWW-Authenticate: Basic realm=\"Private Area\"");
        header("HTTP/1.0 401 Unauthorized");
        echo json_encode(['error' => 'Wrong username and password']);
        exit;
    }
}

$input = file_get_contents('php://input');
$webhook = json_decode($input);

$app_id = $webhook->id;
$app_name = $webhook->app->name;
$device_info = $webhook->device->ua;
$ip = $webhook->device->ip;
$lat = $webhook->device->geo->lat;
$lon = $webhook->device->geo->lon;

if (isset($app_id)) {
    if ($app_id != "myB92gUhMdC5DUxndq3yAg") {
        header("404 Unknown Sender", true, 400);
        echo json_encode(['error' => 'Unknown Sender.']);
        exit;
    }
} else {
    header("400 Wrong Input", true, 400);
    echo json_encode(['error' => 'wrong input']);
    exit;
}

if (isset($app_name)) {
    $result = '{
        "campaignname": "Test_Banner_13th-31st_march_Developer",
        "advertiser": "TestGP",
        "code": "118965F12BE33FB7E",
        "appid": "20240313103027",
        "tld": "https://adplaytechnology.com/",
        "portalname": "",
        "creative_type": "1",
        "creative_id": 167629,
        "day_capping": 0,
        "dimension": "320x480",
        "attribute": "rich-media",
        "url": "https://adplaytechnology.com/",
        "billing_id": "123456789",
        "price": 0.1,
        "bidtype": "CPM",
        "image_url": "https://s3-ap-southeast-1.amazonaws.com/elasticbeanstalk-ap-southeast-1-5410920200615/CampaignFile/20240117030213/D300x250/e63324c6f222208f1dc66d3e2daaaf06.png",
        "htmltag": "",
        "from_hour": "0",
        "to_hour": "23",
        "hs_os": "Android,iOS,Desktop",
        "operator": "Banglalink,GrameenPhone,Robi,Teletalk,Airtel,Wi-Fi",
        "device_make": "No Filter",
        "country": "Bangladesh",
        "city": "",
        "lat": "",
        "lng": "",
        "app_name": null,
        "user_list_id": "0",
        "adplay_logo": 1,
        "vast_video_duration": null,
        "logo_placement": 1,
        "hs_model": null,
        "is_rewarded_inventory": 0,
        "pixel_tag": null,
        "dmp_campaign_audience": 0,
        "platform": null,
        "open_publisher": 1,
        "audience_targeting": 0,
        "native_title": null,
        "native_type": null,
        "native_data_value": null,
        "native_data_cta": null,
        "native_data_rating": null,
        "native_data_price": null,
        "native_img_icon": null
    }';
    
    echo $result;
} else {
    header("400 Wrong Input", true, 400);
    echo json_encode(['error' => 'wrong input']);
    exit;
}
