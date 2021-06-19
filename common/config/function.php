<?php

/**
 * 浏览器友好的变量输出
 * @param mixed $var 变量
 * @param boolean $hidden 是否显示隐藏 默认为false
 * @param boolean $echo 是否输出 默认为True 如果为false 则返回输出字符串
 * @param string $label 标签 默认为空
 * @param boolean $strict 是否严谨 默认为true
 * @return void|string
 */
function dd($var, $hidden = FALSE, $echo = true, $label = null, $strict = true)
{
    $label = ($label === null) ? '' : rtrim($label) . ' ';
    if (!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            if ($hidden) {
                $output = '<pre style="display:none;">' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            } else {
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
        } else {
            $output = $label . print_r($var, true);
        }
    } else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if (!extension_loaded('xdebug')) {
            $output = preg_replace('/\]\=\>\n(\s+)/m', '] => ', $output);
            if ($hidden) {
                $output = '<pre style="display:none;">' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            } else {
                $output = '<pre>' . $label . htmlspecialchars($output, ENT_QUOTES) . '</pre>';
            }
        }
    }
    if ($echo) {
        echo($output);die;
        return null;
    } else
        return $output;
}

/**
 * 路由截取
 * @param String $s 路由名称
 * @return String
 * */
function namecut($s = ''){
    $sArr = str_split($s);
    $fName = '';
    foreach ($sArr as $k => $c){
        if($k !=0 && $c>= 'A' && $c<= 'Z'){
            $fName .= '-'.$c;
        }else{
            $fName .= $c;
        }
    }
    return strtolower($fName);
}