<?php
/**
 * 
 * Videoparse(https://www.videoparse.cn)
 * 支持：抖音、快手、小红书、西瓜视频、今日头条、微视、火山小视频、陌陌视频、映客视频、小咖秀、开眼、全民小视频、全民K歌、最右、小影、微博、美拍、皮皮虾等平台的短视频去水印解析API接口
 *
 * 解析短视频接口
 */

//开发者后台生成的appid
$appId = '';

//开发者后台生成的appsecret
$appSecret = '';

//需要解析的url
$url = '';

$param = [
	'appid'		=> $appId,
	'appsecret'	=> $appSecret,
	'url'		=> $url,
];

//得到请求的地址：https://api-sv.videoparse.cn/api/video/normalParse?appid=2m3Ju99MPXrNtkgH&appsecret=bNG3JYjT83qp4cib&url=http%3A%2F%2Fv.douyin.com%2Fa2X5ab%2F
$apiUrl = 'https://api-sv.videoparse.cn/api/video/normalParse?'.http_build_query($param);
$videoInfo = file_get_contents($apiUrl);
print_r($videoInfo);