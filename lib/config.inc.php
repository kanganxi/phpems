<?php

/** 常规常量设置 */
define('DOMAINTYPE','off');
define('CH','exam_');
define('CDO','');
define('CP','/');
define('CRT',180);
define('CS','1hqfx6ticwRxtfviTp940vng!yC^QK^6');//请随机生成32位字符串修改此处值
define('HE','utf-8');
define('PN',10);
define('TIME',time());
if(dirname($_SERVER['SCRIPT_NAME']))
    define('WP','http://'.$_SERVER['SERVER_NAME'].dirname($_SERVER['SCRIPT_NAME']).'/');
else
    define('WP','http://'.$_SERVER['SERVER_NAME'].'/');
define('OPENOSS',false);

/** 数据库设置 */
define('SQLDEBUG',0);
define('DB','pe6');//MYSQL数据库名
define('DH','127.0.0.1');//MYSQL主机名，不用改
define('DU','root');//MYSQL数据库用户名
define('DP','root');//MYSQL数据库用户密码
define('DTH','x2_');//系统表前缀，不用改

/** 微信相关设置 */
define('USEWX',true);//微信使用开关，绑定用户，false时不启用
define('WXAUTOREG',true);//微信开启自动注册,设置为false时转向登录和注册页面，绑定openid
//define('FOCUSWX',true);//强制引导关注微信
//define('WXQRCODE','qrcode.png');//微信公众号二维码地址
define('EP','@phpems.net');//微信开启自动注册时注册邮箱后缀
define('WXAPPID','wxa121211544e08');
define('WXAPPSECRET','a3d931c59f52280bb12312312321');
define('WXMCHID','1311111702');
define('WXKEY','zhelishi32weidewxkey');

/** 支付宝相关设置 */
define('ALIPART','2011111122450284825');
define('ALIKEY','j8tn111111x7l0wddmx111111111itkiw');
define('ALIACC','suo11111@126.com');

/** payjz相关设置 */
define('PAYJSASWX','YES');//使用PAYJZ的微信支付接口代替微信支付，请自行申请替换下方设置，不要使用默认值。不使用请设置为NO
define('PAYJSMCHID','1551052561');
define('PAYJSKEY','Zz8ks1ZP3UPKeTGi');



?>