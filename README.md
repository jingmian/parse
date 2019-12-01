# Videoparse短视频解析接口文档

## Videoparse(https://www.videoparse.cn) 短视频解析接口已支持：抖音、快手、小红书、西瓜视频、今日头条、微视、火山小视频、陌陌视频、映客视频、小咖秀、开眼、全民小视频、全民K歌、最右、小影、微博、美拍、皮皮虾等平台的短视频去水印解析API接口


### 一. 解析短视频接口
**URL：https://api-sv.videoparse.cn/api/video/normalParse**  
**请求方式：GET/POST**  
**请求参数：**  

|字段|类型|必填|备注|赋值|
|---|---|---|---|---|  
| appid | string | Y | appid |开发者后台生成的appid|
| appsecret | string | Y | appsecret |开发者后台生成的appsecret|
| url | string | Y | 要解析的短视频地址 |

**返回结果：**  

**成功：**  

	{"code":0,"msg":"success","body":{"source":"douyin","url":"http:\/\/v.douyin.com\/2duavD\/","title":"\u767e\u5c81\u5c71\u4e3a\u4ec0\u4e48\u79f0\u4e3a\u6c34\u4e2d\u8d35\u65cf \u89c6\u9891\u5bfb\u627e\u7b54\u6848@\u6296\u97f3\u5c0f\u52a9\u624b","cover_url":"https:\/\/p1.pstatp.com\/large\/1bda8000852aa26656c12.jpg","video_url":"http:\/\/v6-dy.ixigua.com\/2c3a7f072b949101ceac0d465b35ef82\/5ca88513\/video\/m\/2203c9cfb2a446e4c99bb6b34927f3e875911619893d00005d48e8bf9a57\/?rc=am13aWg5bnlobDMzN2kzM0ApQHRAbzM2NzU1ODkzNDo1Ojk3PDNAKXUpQGczdylAZmxkamV6aGhkZjs0QDVecWBkb15pLV8tLWItL3NzLW8jbyM2LzYtLi0uLS0yMi4tLS4vaTpiLW8jOmAtbyNtbCtiK2p0OiMvLl4=","video_key":"ZRGO3V1JNKJ270QWE5"}}
	
  
**失败：**	

	{"code":10001,"msg":"parameter lost","body":[]}

**返回字段注释** 

|字段名|注释|备注|
|---|---|---|
|code|错误码|错误码:请参考错误码说明|
|msg|错误信息|错误码:请参考错误码说明|
|body|||
|source|解析视频来源|如：douyin、kuaishou|
|url|开发者请求的url||
|title|短视频标题||
|cover_url|短视频封面||
|video_url|无水印的视频地址|此地址有有效期限制，不可作为永久存储|

PHP EXAMPLE：
	
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

### 二. 解析短视频接口 - 安全版
**URL：https://api-sv.videoparse.cn/api/video/parse**  
**请求方式：GET/POST**  
**请求参数：**  

|字段|类型|必填|备注|赋值|
|---|---|---|---|---|  
| appid | string | Y | appid |开发者后台生成的appid|
| url | string | Y | 要解析的短视频地址 |
| timestamp | string | Y | 时间戳 | 秒数时间戳 |
| sign | string | Y | 参数签名 | 通过签名算法生成(部分语言如:c#，md5后得到的是大写的字符串，需将每次md5加密后的字符串转换为小写) |

**签名算法验证 <a href="https://www.videoparse.cn/home/checkSign">签名验证</a>**

签名算法：

	假设传入的参数如下：
	appid: 26jJu99MPXrNtkgH
	url： http://v.douyin.com/2duavD/
	timestamp：1546766273
	appsecret: mtUjY1z2D7TiZDqb
	
	注意：部分语言(例如:c#)，字符串通过md5加密后，得到的为大写的字符串，请将每次md5加密后得到的字符串转换为小写
	
	签名步骤如下：
	
	第一步：对参数按照key=value的格式，并按照参数名ASCII字典序排序如下(格式为：appid=appid&amp;timestamp=秒级时间戳&url=编码后的短视频地址，注意：需要先对传入url值进行编码):
	stringA=&quot;appid=26jJu99MPXrNtkgH&amp;timestamp=1546766273&url=http%3A%2F%2Fv.douyin.com%2F2duavD%2F&quot;
	
	第二步：将stringA进行MD5加密，然后从第6位开始，截取18位，拼接上API密钥，成为新的字符串stringB:
	stringB=substr(md5(stringA), 6, 18).appsecret    //	得到：439cb914566659b146mtUjY1z2D7TiZDqb
	
	第三步:将stringB进行MD5加密后，从10位开始，截取16位，得到最终的签名字符串sign：
	sign = substr(md5(stringB), 10, 16)
	
	得到结果：
		a22919cc4d9eafce
	
	PHP 实现的签名算法代码：
	
	function sign($appId, $appSecret, $url, $timestamp) {
		$param = [
			'appid'		=> $appId,
			'url'		=> $url,
			'timestamp'	=> $timestamp,
		];
		ksort($param);
		return substr(md5(substr(md5(http_build_query($param)), 6, 18) . $appSecret), 10, 16);
	}
	

**返回结果：**  

**成功：**  

	{"code":0,"msg":"success","body":{"source":"douyin","url":"http:\/\/v.douyin.com\/2duavD\/","title":"\u767e\u5c81\u5c71\u4e3a\u4ec0\u4e48\u79f0\u4e3a\u6c34\u4e2d\u8d35\u65cf \u89c6\u9891\u5bfb\u627e\u7b54\u6848@\u6296\u97f3\u5c0f\u52a9\u624b","cover_url":"https:\/\/p1.pstatp.com\/large\/1bda8000852aa26656c12.jpg","video_url":"http:\/\/v6-dy.ixigua.com\/2c3a7f072b949101ceac0d465b35ef82\/5ca88513\/video\/m\/2203c9cfb2a446e4c99bb6b34927f3e875911619893d00005d48e8bf9a57\/?rc=am13aWg5bnlobDMzN2kzM0ApQHRAbzM2NzU1ODkzNDo1Ojk3PDNAKXUpQGczdylAZmxkamV6aGhkZjs0QDVecWBkb15pLV8tLWItL3NzLW8jbyM2LzYtLi0uLS0yMi4tLS4vaTpiLW8jOmAtbyNtbCtiK2p0OiMvLl4=","video_key":"ZRGO3V1JNKJ270QWE5"}}
	
  
**失败：**	

	{"code":10001,"msg":"parameter lost","body":[]}

**返回字段注释** 

|字段名|注释|备注|
|---|---|---|
|code|错误码|错误码:请参考错误码说明|
|msg|错误信息|错误码:请参考错误码说明|
|body|||
|source|解析视频来源|如：douyin、kuaishou|
|url|开发者请求的url||
|title|短视频标题||
|cover_url|短视频封面||
|video_url|无水印的视频地址|此地址有有效期限制，不可作为永久存储|

PHP EXAMPLE：

	function curlPost( $url = '', $data ) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url );
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 1); //部分环境下，需要将参数值设为2，即：curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
		curl_setopt($ch, CURLOPT_TIMEOUT, 10);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		$response = curl_exec( $ch );
		curl_close ( $ch );
	
		return $response;	
	}
	
	function sign($appId, $appSecret, $url, $timestamp) {
		$param = [
			'appid'		=> $appId,
			'url'		=> $url,
			'timestamp'	=> $timestamp,
		];
		ksort($param);
		return substr(md5(substr(md5(http_build_query($param)), 6, 18) . $appSecret), 10, 16);
	}
	
	//开发者后台生成的appid
	$appId = '';
	
	//开发者后台生成的appsecret
	$appSecret = '';
	
	//需要解析的url
	$url = '';
	
	//时间戳
	$timestamp = time();
	
	//生成签名
	$sign = sign($appId, $appSecret, $url, $timestamp);
	
	//curl post请求接口解析短视频
	$param = [
		'appid'		=> $appId,
		'url'		=> $url,
		'timestamp'	=> $timestamp,
		'sign'		=> $sign,
	];
	
	$apiUrl = 'https://api-sv.videoparse.cn/api/video/parse';
	$videoInfo = curlPost($apiUrl, $param);
	print_r($videoInfo);

### 三. 获取开发者信息接口
**URL：https://api-sv.videoparse.cn/api/user/getInfo**  
**请求方式：GET/POST**  
**请求参数：**  

|字段|类型|必填|备注|赋值|
|---|---|---|---|---| 
| appid | string | Y | appid |开发者后台生成的appid|

**返回结果：**  

**成功：**  

	{"code":0,"msg":"success","body":{"username":"test","appid":"2m3Ju99MPXrNtkgH","end_time":"1525931778","wallet":"100"}}
	
**失败：**

{"code":10001,"msg":"parameter lost","body":[]}

返回字段注释

|字段名|注释|备注|
|---|---|---|
|code|错误码|错误码:请参考错误码说明|
|msg|错误信息|错误码:请参考错误码说明|
|body|||
|username|开发用户名||
|appid|appid||
|end_time|vip到期时间||
|wallet|剩余解析次数||

### 错误码说明
|错误码|注释|
|---|---|
|code|错误码|
|0|解析成功|
|10001|请求参数缺失|
|10002|请求参数不合法|
|10003|开发者权限错误或开发者不存在|
|10004|签名校验失败|
|10005|请求接口的ip地址不在白名单或开发者没有设置ip白名单|
|10006|当前开发者不是vip或没有解析次数|
|10007|解析视频失败|
|10008|请求参数url地址不合法|
|10009|请求受限|
|10010|vip已过期或无解析次数|
