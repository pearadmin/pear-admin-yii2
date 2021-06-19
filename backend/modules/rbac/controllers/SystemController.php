<?php

namespace backend\modules\rbac\controllers;

use yii\filters\VerbFilter;
use yii\web\Controller;
use rbac\models\System;
use Yii;
use yii\base\ErrorException;

/**
 * System controller
 *
 * @author earnest <464605059@qq.com>
 * */
class SystemController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'getdirs' => ['post']
                ],
            ],
        ];
    }

    /**
     * 浏览器跳转'system/index'页面
     * @return mixed
     * */
    public function actionIndex(){
        return $this->render('index');
    }

    /**
     * 获取根目录下所有文件，根目录:web/common
     * @return Json
     * */
    public function actionGetdirs($cur_route = ''){
        $param = Yii::$app->getRequest()->post();
        $cur_route = isset($param['data'])?$param['data']:'';
        $route = Yii::$app->basePath.'/web/common/'.$cur_route;
        $dirs = scandir($route);
        $data = [];
        $key = 0;
        foreach ($dirs as $d){
            $dir = $route. $d ;
            $suffix = pathinfo($dir, PATHINFO_EXTENSION);
            if(is_dir($dir)){
                if($d == '.' || $d == '..'){
                    continue;
                }
                $data[$key]['name'] = $d.'/';
                $data[$key]['type'] = 1;
                $data[$key]['file_type'] = 'directory';
            }else if(is_file($dir)){
                $data[$key]['name'] = mb_convert_encoding($d, "UTF-8", "gbk");
                $data[$key]['type'] = 2;
                $data[$key]['file_type'] = $suffix;
            }
            $data[$key]['updated_at'] = date('Y-m-d H:i:s',filemtime($dir));
            $data[$key]['created_at'] = date('Y-m-d H:i:s',filectime($dir));

            $data[$key]['permission'] = substr(base_convert(@fileperms($dir),10,8),-4);
            $data[$key]['size'] = $this->FileSizeConvert(filesize($dir));
            $data[$key]['owner'] = strtoupper(substr(PHP_OS,0,3))==='WIN'?fileowner($dir):posix_getpwuid(fileowner($dir));
            $key++;
        }

        $count = count($data);
        $last_names = array_column($data,'type');
        array_multisort($last_names,SORT_ASC,$data);

        if(isset($param['page']) && $param['page'] != ''){
            $data = array_slice($data,($param['page']-1)*$param['limit'],$param['limit']);
        }

        if(isset($param['filename']) && $param['filename']!=''){
            $_data = array();
            foreach ($data as $item){
                if(strpos($item['name'],$param['filename']) !==false){
                    array_push($_data,$item);
                }
            }
            $data = $_data;
        }

        return json_encode(['code'=>0,'count'=>$count,'data'=>$data,'cur_route'=>$cur_route]);
    }

    /**
     * 获取指定文件的大小
     * @return Json
     * */
    public function actionGetFolderSize(){
        $path = Yii::$app->basePath.'/web/common/'.Yii::$app->getRequest()->post('path','');
        $res = $this->GetFils($path);
        $size = 0;
        if(isset($res['files'])){
            foreach ($res['files'] as $resItem){
                $size = bcadd(filesize($resItem),$size);
            }
        }
        $size = $this->FileSizeConvert($size);

        return json_encode(['code'=>200,'size'=>$size]);
    }

    /**
     * 更新指定文件的名称
     * @return Json
     * */
    public function actionRename(){
        try{
            $param = Yii::$app->getRequest()->post();
            $res['code'] = 1;
            $res['msg'] = 'FALSE';

            $old_file = Yii::$app->basePath.'/web/common/'.$param['cur_route'].'/'.$param['data']['name'];
            $new_file = Yii::$app->basePath.'/web/common/'.$param['cur_route'].'/'.$param['name'];
            if(is_dir($old_file) || is_file($old_file)){
                if (rename($old_file,$new_file)) {
                    $res['code'] = 0;
                    $res['msg'] = 'SUCCESS';
                }
            }
        }catch (ErrorException $e){
            $res['code'] = 1;
            $res['msg'] = $e->getMessage();
        }

        return json_encode($res);
    }

    /**
     * 更新指定文件的权限
     * @return Json
     * */
    public function actionUpdatePerms(){
        try {
            $param = Yii::$app->getRequest()->post();
            $file_name = Yii::$app->basePath.'/web/common/'.$param['cur_route'].'/'.$param['data']['name'];
            if(is_dir($file_name)||is_file($file_name)){
                $model = $param['name'];
                $res = @chmod($file_name,octdec($model));
                if($res){
                    return json_encode(['code'=>200,'msg'=>'SUCCESS']);
                }
            }
        }catch (ErrorException $e){
            $res['msg'] = $e->getMessage();
            return json_encode(['code'=>400,'msg'=>$e->getMessage()]);
        }
    }

    /**
     * 删除指定文件
     * @return Json
     * */
    public function actionRemove(){
        $param = Yii::$app->getRequest()->post();
        $route =  Yii::$app->basePath.'/web/common/'.$param['route'];
        if(is_file($route)){
            unlink($route);
            return json_encode(['code'=>200,'msg'=>'SUCCESS']);
        }else if(is_dir($route)){
            $res = $this->deleteDir($route);
            if(is_dir($route)){
                $res = $this->deleteDir($route);
            }
            if($res){
                return json_encode(['code'=>200,'msg'=>'SUCCESS']);
            }else{
                return json_encode(['code'=>400,'msg'=>$route.':权限不够']);
            }
        }
    }

    /**
     * 删除指定文件
     * @return fixed
     * */
    public function actionDel(){
        try {
            $param = Yii::$app->getRequest()->post();
            if(isset($param['data']) && count($param['data']) > 0){
                foreach ($param['data'] as $item){
                    $path = Yii::$app->basePath.'/web/common/'.$param['cur_route'].$item['name'];
                    if(is_dir($path)){
                        return json_encode(['code'=>400,'msg'=>$item['name'].'为文件夹，请手动删除']);
                    }
                }

                foreach ($param['data'] as $item){
                    $path = Yii::$app->basePath.'/web/common/'.$param['cur_route'].$item['name'];
                    if(is_file($path)){
                        unlink($path);
                    }
                }
                return json_encode(['code'=>200,'msg'=>'SUCCESS']);
            }else{
                return json_encode(['code'=>400,'msg'=>'请选择数据']);
            }
        }catch (ErrorException $e){
            return json_encode(['code'=>400,'msg'=>$e->getMessage()]);
        }
    }

    /**
     * 下载指定文件
     * @return Json
     * */
    public function actionDownload(){
        $param = Yii::$app->getRequest()->post();
        $file =  Yii::$app->basePath.'/web/common/images.zip';
        $filename = basename($file);
        header("Content-type: application/octet-stream");
        //处理中文文件名
        $ua = $_SERVER["HTTP_USER_AGENT"];
        $encoded_filename = rawurlencode($filename);
        if (preg_match("/MSIE/", $ua)) {
            header('Content-Disposition: attachment; filename="' . $encoded_filename . '"');
        } else if (preg_match("/Firefox/", $ua)) {
            header("Content-Disposition: attachment; filename*=\"utf8''" . $filename . '"');
        } else {
            header('Content-Disposition: attachment; filename="' . $filename . '"');
        }
        header("Content-Length: ". filesize($file));
        readfile($file);
    }

    /**
     * 删除指定文件夹已经子文件
     * @return boolean
     * */
    protected function deleteDir($dir)
    {
        if (!$handle = @opendir($dir)) {
            return false;
        }
        while (false !== ($file = readdir($handle))) {
            if ($file !== "." && $file !== "..") {       //排除当前目录与父级目录
                $file = $dir . '/' . $file;
                if (is_dir($file)) {
                    $this->deleteDir($file);
                } else {
                    unlink($file);
                }
            }

        }
        return @rmdir($dir);
    }

    /**
     * 压缩指定文件
     * @return Json
     * */
    public function actionCompressedFile(){
        try{
            $param = Yii::$app->getRequest()->post();
            $param['data']['name'] = mb_convert_encoding($param['data']['name'], "UTF-8", "gbk");
            if(isset($param['data']['name']) && isset($param['cur_route'])){
                $filename = explode('/',$param['data']['name']);
                $path = Yii::$app->basePath.'/web/common/'.$param['cur_route'].''.$filename[0];
                if(is_file($path)){
                    return json_encode(['code'=>400,'msg'=>'文件无法压缩']);
                }

                $filename  = Yii::$app->basePath.'/web/common/'.$param['cur_route'].''.$filename[0].'.zip';
                $zip = new \ZipArchive();
                if($zip->open($filename, \ZipArchive::CREATE)=== TRUE){
                    $this->addDirToZip($path, $zip,$param['cur_route']);
                    $zip->close();
                }

                return json_encode(['code'=>200,'msg'=>'SUCCESS']);
            }

        }catch (ErrorException $db){
            return json_encode(['code'=>400,'msg'=>$db->getMessage()],JSON_UNESCAPED_UNICODE);
        }

    }

    /**
     * 创建文件或文件夹
     * @return Json
     * */
    public function actionCreate(){
        try {
            $param = Yii::$app->getRequest()->post();

            if(isset($param['file_name']) && $param['file_name'] != ''){
                $path = Yii::$app->basePath.'/web/common/'.$param['cur_route'].$param['file_name'];

                if($param['type'] == 'file'){
                    if(is_file($path) ){
                        return json_encode(['code'=>400,'msg'=>'文件已存在']);
                    }
                    $res = file_put_contents($path,'');
                }else if($param['type'] == 'dir'){
                    if(is_dir($path)){
                        return json_encode(['code'=>400,'msg'=>'文件夹已存在']);
                    }
                    $res = mkdir(iconv("UTF-8", "GBK", $path),0777,true);
                }

                if($res || $res == 0){
                    return json_encode(['code'=>200,'msg'=>'SUCCESS']);
                }
            }else{
                return json_encode(['code'=>400,'msg'=>'文件名错误']);
            }
        }catch (ErrorException $e){
            return json_encode(['code'=>400,'msg'=>$e->getMessage()]);
        }
    }

    /**
     * 压缩文件方法
     * @return boolean
     * */
    protected function addDirToZip($path,$zip,$cur_route){
        $handler = opendir($path);
        $files = array_diff(scandir($path),array('..','.'));
        if (count($files) == 0){
            //echo $path;die;
            $path = preg_replace('/\//','\\',$path);
            $emptyDirsArr = explode('\\',$path);
            $zip->addEmptyDir(array_pop($emptyDirsArr));

        }else{
            while(($filename = readdir($handler))!==false){
                if($filename != "." && $filename != ".."){
                    if(is_dir($path."/".$filename)){
                        $this->addDirToZip($path."/".$filename, $zip,$cur_route.'/'.$filename);
                    }else{
                        $localname = $cur_route.'/'.$filename;
                        if(substr($localname ,0,1)=='/'){
                            $localname = substr($localname,1);
                        }

                        $zip->addFile($path."/".$filename,$localname);
                    }
                }
            }
        }

        @closedir($path);
    }

    /**
     * 根据路径获取子文件名称
     * @return array
     * */
    protected function GetFils($path){
        $res = [];
        $this->ListFiles($path,$res);
        return $res;
    }

    /**
     * 递归获取子文件名称
     * @param String $path 当前文件路径
     * @param array $res 当前目录中的文件名集合
     * @return array
     * */
    protected function ListFiles($path,&$res){
        $files = scandir($path);
        foreach($files as $v){
            $_path = $path.'/'.$v;
            if(is_dir($_path)){
                if($v=='.' || $v=='..'){
                    continue;
                }
                $res['dirs'][] = $_path;
                $this->ListFiles($_path,$res);
            }else{
                $res['files'][] = $_path;
            }
        }
    }

    /**
     * 将bytes字符转换成可以简单的字符单位
     * @param string $bytes
     * @return string
     */
    protected function FileSizeConvert($bytes)
    {
        if($bytes == 0){
            return '0B';
        }

        $bytes = floatval($bytes);
        $arBytes = array(
            0 => array(
                "UNIT" => "TB",
                "VALUE" => pow(1024, 4)
            ),
            1 => array(
                "UNIT" => "GB",
                "VALUE" => pow(1024, 3)
            ),
            2 => array(
                "UNIT" => "MB",
                "VALUE" => pow(1024, 2)
            ),
            3 => array(
                "UNIT" => "KB",
                "VALUE" => 1024
            ),
            4 => array(
                "UNIT" => "B",
                "VALUE" => 1
            ),
        );

        foreach ($arBytes as $arItem) {
            if ($bytes >= $arItem["VALUE"]) {
                $result = $bytes / $arItem["VALUE"];
                $result = strval(round($result, 2)) . " " . $arItem["UNIT"];
                break;
            }
        }
        return $result;
    }

/********************************************************系统设置*******************************************************/

    /**
     * 保存系统设置数据
     * @return Json
     * */
    public function actionUpload(){
        $param = Yii::$app->getRequest()->post();
        $model = System::findOne(1);
        $model->logo_title = $param['logo_title'];
        $model->tab_max = $param['tab_max'];
        $model->keep_load = $param['keep_load'];
        $model->index_title = $param['index_title'];
        $model->index_href = $param['index_href'];
        $model->links_title = json_encode($param['links_title']);
        $model->links_href = json_encode($param['links_href']);
        $model->links_icon = json_encode($param['links_icon']);

        if(isset($param['session']) && $param['session'] == 'on'){
            $model->session = 1;
        }else{
            $model->session = 0;
        }

        if(isset($param['muilt_tab']) && $param['muilt_tab'] == 'on'){
            $model->muilt_tab = 1;
        }else{
            $model->muilt_tab = 0;
        }

        if(isset($param['verify_code']) && $param['verify_code'] == 'on'){
            $model->verify_code = 1;
        }else{
            $model->verify_code = 0;
        }

        if(isset($param['menu_control']) && $param['menu_control'] == 'on'){
            $model->menu_control = 1;
        }else{
            $model->menu_control = 0;
        }

        if(isset($param['menu_accordion']) && $param['menu_accordion'] == 'on'){
            $model->menu_accordion = 1;
        }else{
            $model->menu_accordion = 0;
        }

        if(isset($param['file_name']) && $param['file_name'] != ''){
            $path = Yii::$app->basePath.'/web/plugins/admin/images/logo/'.$param['file_name'];
            if(!is_dir(dirname($path))){
                mkdir(dirname($path),0777);
            }

            $imgdata = substr($param['file_content'],strpos($param['file_content'],",") + 1);
            file_put_contents($path,base64_decode($imgdata));
            $model->file_name = '/plugins/admin/images/logo/'.$param['file_name'];
        }

        if($model->save()){
            return json_encode(['code'=>200,'icon'=>'1','msg'=>'SUCCESS']);
        }else{
            return json_encode(['code'=>400,'icon'=>'2','msg'=>$model->getErrors()]);
        }

    }

    /**
     * 浏览器跳转'system/sys-set'页面
     * @return fixed
     * */
    public function actionSysSet(){
        $model = System::find()->where(['id'=>1])->asArray()->one();
        $links_title = json_decode($model['links_title'],true);
        $links_icon = json_decode($model['links_icon'],true);
        $links_href = json_decode($model['links_href'],true);

        $_model = [];
        foreach ($links_title as $key => $item){
            $_model['links'][$key]['icon'] = $links_icon[$key];
            $_model['links'][$key]['title'] = $links_title[$key];
            $_model['links'][$key]['href'] = $links_href[$key];
        }

        $_model['logo']['image'] = $model['file_name'];
        $_model['logo']['logo_title'] = $model['logo_title'];

        $_model['tab']['muilt_tab'] = $model['muilt_tab'] == 1 ? true:false;
        $_model['tab']['session'] = $model['session'] == 1 ? true:false;;
        $_model['tab']['tab_max'] = $model['tab_max'];
        $_model['tab']['index']['index_href'] = $model['index_href'];
        $_model['tab']['index']['index_title'] = $model['index_title'];
        $_model['other']['keep_load'] = $model['keep_load'];
        $_model['other']['verify_code'] =  $model['verify_code'] == 1?true:false;
        $_model['menu']['control'] = $model['menu_control'];
        $_model['menu']['accordion'] = $model['menu_accordion'];

        return $this->render('sys-set',['model'=>$_model]);
    }

    /**
     * 获取右侧面板设置数据
     * @return Json
     * */
    public function actionGetLinks(){
        $model = System::find()->where(['id'=>1])->asArray()->one();
        $links_title = json_decode($model['links_title'],true);
        $links_icon = json_decode($model['links_icon'],true);
        $links_href = json_decode($model['links_href'],true);

        $_model = [];
        foreach ($links_title as $key => $item){
            $_model['data'][$key]['icon'] = $links_icon[$key];
            $_model['data'][$key]['title'] = $links_title[$key];
            $_model['data'][$key]['href'] = $links_href[$key];
        }
        $param = Yii::$app->getRequest()->post();
        if(isset($param['action']) && $param['action'] == 'add'){
            return json_encode($param['data']);
        }

        $_model['code'] = 0;
        return json_encode($_model);
    }


}