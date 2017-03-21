<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/10/8
 * Time: 9:50
 */
namespace Common\Controller;
use Common\Controller\AppframeController;

class MobliebaseController extends AppframeController{
    public $user_msg;
    function _initialize(){
        parent::_initialize();
        //获取微信用户信息的方法
        // $this->user_msg = $this->getWeiXinUser();
        // $this->assign('user_msg',$this->getWeiXinUser());
        // $this->assign('getSignPackage',$this->getSignPackage());
        // //将分享后的直播id与分享者的用户名记录在cookie中
        // $this->set_share_msg();

    }
    /**
     * 记录分享者信息
     **/
    protected function set_share_msg(){
        if(!empty($_GET['live_id']) && !empty($_GET['share_live_openid'])){
            $time = time() + 2592000;
            setcookie("share_live_id",$_GET['live_id'],$time);
            setcookie("share_live_openid",$_GET['share_live_openid'],$time);
        }else if(!empty($_GET['stream_id']) && !empty($_GET['share_stream_openid'])){
            $time = time() + 2592000;
            setcookie("share_stream_id",$_GET['stream_id'],$time);
            setcookie("share_stream_openid",$_GET['share_stream_openid'],$time);
        }
    }
    /**
     * 模板显示
     * @param type $templateFile 指定要调用的模板文件
     * @param type $charset 输出编码
     * @param type $contentType 输出类型
     * @param string $content 输出内容
     * 此方法作用在于实现后台模板直接存放在各自项目目录下。例如Admin项目的后台模板，直接存放在Admin/Tpl/目录下
     */
    public function display($templateFile = '', $charset = '', $contentType = '', $content = '', $prefix = '') {
        parent::display($this->parseTemplate($templateFile), $charset, $contentType);
    }
    /**
     * 自动定位模板文件
     * @access protected
     * @param string $template 模板文件规则
     * @return string
     */
    public function parseTemplate($template='') {
        $tmpl_path=C("SP_WAP_TMPL_PATH");
        define("SP_TMPL_PATH", $tmpl_path);
        // 获取当前主题名称
        $theme      =    C('SP_ADMIN_DEFAULT_THEME');

        if(is_file($template)) {
            // 获取当前主题的模版路径
            define('THEME_PATH',   $tmpl_path.$theme."/");
            return $template;
        }
//        print_r($tmpl_path);
//        die();
        $depr       =   C('TMPL_FILE_DEPR');
        $template   =   str_replace(':', $depr, $template);

        // 获取当前模块
        $module   =  MODULE_NAME."/";
        if(strpos($template,'@')){ // 跨模块调用模版文件
            list($module,$template)  =   explode('@',$template);
        }

        // 获取当前主题的模版路径
        define('THEME_PATH',   $tmpl_path.$theme."/");

        // 分析模板文件规则
        if('' == $template) {
            // 如果模板文件名为空 按照默认规则定位
            $template = CONTROLLER_NAME . $depr . ACTION_NAME;
        }elseif(false === strpos($template, '/')){
            $template = CONTROLLER_NAME . $depr . $template;
        }

        C("TMPL_PARSE_STRING.__TMPL__",__ROOT__."/".THEME_PATH);

        C('SP_VIEW_PATH',$tmpl_path);
        C('DEFAULT_THEME',$theme);
        define("SP_CURRENT_THEME", $theme);

        $file = sp_add_template_file_suffix(THEME_PATH.$module.$template);
        $file= str_replace("//",'/',$file);
        if(!file_exists_case($file)) E(L('_TEMPLATE_NOT_EXIST_').':'.$file);
        return $file;
    }
    /**
     *
     * 通过跳转获取用户的openid，跳转流程如下：
     * 1、设置自己需要调回的url及其其他参数，跳转到微信服务器https://open.weixin.qq.com/connect/oauth2/authorize
     * 2、微信服务处理完成之后会跳转回用户redirect_uri地址，此时会带上一些参数，如：code
     *
     * @return 用户的openid
     */
//    public function GetOpenid() {
//        //通过code获得openid
//        if (!isset($_GET['code'])){
//            //触发微信返回code码
//            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
//            $url = $this->__CreateOauthUrlForCode($baseUrl);
//            Header("Location: $url");
//            exit();
//        } else {
//            //获取code码，以获取openid
//            $code = $_GET['code'];
//            $openid = $this->getOpenidFromMp($code);
//            return $openid;
//        }
//    }
    public function GetOpenid() {
        //通过code获得openid
        if (!isset($_GET['openid'])){
            //触发微信返回code码
            $baseUrl = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
            $url = $this->__CreateOauthUrlForCode($baseUrl);
            Header("Location: $url");
            exit();
        } else {
            //获取code码，以获取openid
            return $_GET;
        }
    }
    /**
     *
     * 构造获取code的url连接
     * @param string $redirectUrl 微信服务器回跳的url，需要url编码
     *
     * @return 返回构造好的url
     */
//    private function __CreateOauthUrlForCode($redirectUrl){
//        $urlObj["appid"] = C('APP_ID');
//        $urlObj["redirect_uri"] = "$redirectUrl";
//        $urlObj["response_type"] = "code";
//        $urlObj["scope"] = "snsapi_base";
//        $urlObj["state"] = "STATE"."#wechat_redirect";
//        $bizString = $this->ToUrlParams($urlObj);
//        return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
//    }
    private function __CreateOauthUrlForCode($redirectUrl){
        $urlObj["backurl"] = "$redirectUrl";
        $bizString = $this->ToUrlParams($urlObj);
        return "http://haokan.wx.cibn.cc/WxApi_haibo/getopenid?".$bizString;
    }
    /**
     *
     * 通过code从工作平台获取openid机器access_token
     * @param string $code 微信跳转回来带上的code
     *
     * @return openid
     */
    public function GetOpenidFromMp($code){
        $url = $this->__CreateOauthUrlForOpenid($code);
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, $this->curl_timeout);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        //取出openid
        $data = json_decode($res,true);
        $this->data = $data;
        $openid = $data['openid'];
        return $openid;
    }
    /**
     *
     * 构造获取open和access_toke的url地址
     * @param string $code，微信跳转带回的code
     *
     * @return 请求的url
     */
    private function __CreateOauthUrlForOpenid($code){
        $urlObj["appid"] = C('APP_ID');
        $urlObj["secret"] = C('SECERT');
        $urlObj["code"] = $code;
        $urlObj["grant_type"] = "authorization_code";
        $bizString = $this->ToUrlParams($urlObj);
        return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
    }
    /**
     *
     * 拼接签名字符串
     * @param array $urlObj
     *
     * @return 返回已经拼接好的字符串
     */
    private function ToUrlParams($urlObj){
        $buff = "";
        foreach ($urlObj as $k => $v) {
            if($k != "sign"){
                $buff .= $k . "=" . $v . "&";
            }
        }
        $buff = trim($buff, "&");
        return $buff;
    }
    public function getWeiXinMsg($token,$openid) {
        $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=".$token."&openid=".$openid."&lang=zh_CN";
        $data = self::getCurl($url);
        $data_array = json_decode($data,true);
        if(!empty($data_array)){
            // if($data_array['subscribe'] == 1){
            if(true){
                $count = M('weixin_user')->where(['openid'=>$data_array['openid']])->count();
                if($count == 0){
                    $data_msg['openid'] =  $data_array['openid'];
                    $data_msg['msg'] = json_encode($data_array);
                    $i = M('weixin_user')->add($data_msg);
                    if($i==false) {
                        print_r('数据保存失败');
                        die();
                    }
                }
            }else{
                //如果没有关注微信则会重新定向到二维码页面
                $this->redirect("Home/Qrcode/index");
            }
        }
        return $data_array;
    }
    protected function getCurl($url){
        //初始化curl
        $ch = curl_init();
        //设置超时
        curl_setopt($ch, CURLOPT_TIMEOUT, 700);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        //运行curl，结果以jason形式返回
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
    /**
     *
     * 产生随机字符串，不长于32位
     * @param int $length
     * @return 产生的随机字符串
     */
    public static function getNonceStr($length = 32){
        $chars = "abcdefghijklmnopqrstuvwxyz0123456789";
        $str ="";
        for ( $i = 0; $i < $length; $i++ )  {
            $str .= substr($chars, mt_rand(0, strlen($chars)-1), 1);
        }
        return $str;
    }

    /**
     * 生成签名
     * @return 签名，本函数不覆盖sign成员变量，如要设置签名需要调用SetSign方法赋值
     */
    public function MakeSign($array){
        //签名步骤一：按字典序排序参数
        ksort($array);
        $string = $this->ToUrlParam($array);
        //签名步骤二：在string后加入KEY
        $string = $string . "&key=".C('KEY');
        //签名步骤三：MD5加密
        $string = md5($string);
        //签名步骤四：所有字符转为大写
        $result = strtoupper($string);
        return $result;
    }

    /**
     * 格式化参数格式化成url参数
     */
    public function ToUrlParam($data){
        $buff = "";
        foreach ($data as $k => $v)
        {
            if($k != "sign" && $v != "" && !is_array($v)){
                $buff .= $k . "=" . $v . "&";
            }
        }

        $buff = trim($buff, "&");
        return $buff;
    }
    /**
     * 输出xml字符
     * @throws WxPayException
     **/
    public function ToXml($array){

        $xml = "<xml>";
        foreach ($array as $key=>$val)
        {
            if (is_numeric($val)){
                $xml.="<".$key.">".$val."</".$key.">";
            }else{
                $xml.="<".$key."><![CDATA[".$val."]]></".$key.">";
            }
        }
        $xml.="</xml>";
        return $xml;
    }
    /**
     * 将xml转为array
     * @param string $xml
     * @throws WxPayException
     */
    public function FromXml($xml){
        if(!$xml){
            print_r('xml异常');
            die();
        }
        //将XML转为array
        //禁止引用外部xml实体
        libxml_disable_entity_loader(true);
        $array = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
        return $array;
    }
    /**
     *
     * 获取jsapi支付的参数
     * @param array $UnifiedOrderResult 统一支付接口返回的数据
     * @throws WxPayException
     *
     * @return json数据，可直接填入js函数作为参数
     */
    public function GetJsApiParameters($UnifiedOrderResult)
    {
        if(!array_key_exists("appid", $UnifiedOrderResult)
            || !array_key_exists("prepay_id", $UnifiedOrderResult)
            || $UnifiedOrderResult['prepay_id'] == "")
        {
            print_r('参数错误');
            die();
        }
        $parametersArray['appId'] = $UnifiedOrderResult["appid"];
        $timeStamp = time();
        $parametersArray['timeStamp'] = "$timeStamp";
        $parametersArray['nonceStr'] = $this->getNonceStr();
        $parametersArray['package'] = "prepay_id=" . $UnifiedOrderResult['prepay_id'];
        $parametersArray['signType'] = "MD5";
        $sing = $this->MakeSign($parametersArray);
        $parametersArray['paySign'] = $sing;
        $parameters = json_encode($parametersArray);
        return $parameters;
    }
    /**
     * 获取关注微信人的详细信息
     **/
    public function getWeiXinUser(){
        $weixin_user_model = M('weixin_user');
        if(!empty($_COOKIE['openid20'])){
            $user_msg['openid'] = $_COOKIE['openid20'];
            $weixin_user_data = $weixin_user_model->where(['openid'=>$_COOKIE['openid20']])->find();
            $user_msg['headimgurl'] = !empty($weixin_user_data['user_img']) ? $weixin_user_data['user_img'] : $_COOKIE['headimgurl'];
            $user_msg['nickname'] = !empty($weixin_user_data['user_nick']) ? $weixin_user_data['user_nick'] : $_COOKIE['nickname'];
            $user_msg['sex'] = !empty($weixin_user_data['user_sex']) ? $weixin_user_data['user_sex'] : $_COOKIE['sex'];
        }else{
            $openid = $this->GetOpenid();
            $data = M("weixin_token")->where(['id'=>'1'])->find();
            $weixin_user_data = $weixin_user_model->where(['openid'=>$_COOKIE['openid20']])->find();
            $user_msg_r = $this->getWeiXinMsg($data['weixin_access_token'],$openid['openid']);
            $time = time() + 2592000;
            setcookie("openid20",$user_msg_r['openid'],$time);
            $user_msg['openid'] = $user_msg_r['openid'];
            if(!empty($weixin_user_data['user_img'])){
                setcookie("headimgurl",$weixin_user_data['user_img'],$time);
                $user_msg['headimgurl'] = $weixin_user_data['user_img'];
            }else{
                setcookie("headimgurl",$user_msg_r['headimgurl'],$time);
                $user_msg['headimgurl'] = $user_msg_r['headimgurl'];
            }

            if(!empty($weixin_user_data['user_img'])){
                setcookie("nickname",$weixin_user_data['user_nick'],$time);
                $user_msg['nickname'] = $weixin_user_data['user_nick'];
            }else{
                setcookie("nickname",$user_msg_r['nickname'],$time);
                $user_msg['nickname'] = $user_msg_r['nickname'];
            }

            if(!empty($weixin_user_data['user_img'])){
                setcookie("sex",$weixin_user_data['user_sex'],$time);
                $user_msg['sex'] = $weixin_user_data['user_sex'];
            }else{
                setcookie("sex",$user_msg_r['sex'],$time);
                $user_msg['sex'] = $user_msg_r['sex'];
            }

        }
        return $user_msg;
    }
    /**
     * 获取jsapi配置信息
     **/
    public function getSignPackage() {
        $weixin_token_model = M('weixin_token');
        $weixin_token_data = $weixin_token_model->where(['id'=>1])->find();
        $jsapiTicket = $weixin_token_data['js_api_ticket'];

        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $timestamp = time();
        $nonceStr = $this->createNonceStr();

        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";

        $signature = sha1($string);

        $signPackage = array(
            "appId"     => C('APP_ID'),
            "nonceStr"  => $nonceStr,
            "timestamp" => $timestamp,
            "url"       => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }
    //jsapi随机数
    private function createNonceStr($length = 16) {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for ($i = 0; $i < $length; $i++) {
            $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
        }
        return $str;
    }
}
