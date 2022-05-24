<?php

/**
 * @param array $urls
 * @param array $content
 * @return string
 */
function getEntryURL($urls, $content){
    if(!empty($content['category-data'])){
        if($urls['content']['prefix-enable']){
            if($urls['category']['prefix-enable']){
                return '/'.$urls['pages'][3].'/'.$content['category-data'][0]['url'].'/'.$content['url'];
            }else{
                return '/'.$content['category-data'][0]['url'].'/'.$content['url'];
            }
        }else{
            return '/'.$content['url'];
        }
    }else{
        return '/'.$content['url'];
    }
}

/**
 * @param $key
 * @return mixed
 */
function getCookie($key) {
    if(isset($_COOKIE[md5($key)])){
        return base64_decode($_COOKIE[md5($key)]);
    }else{
        return false;
    }
}

/**
 * @param array $input
 * @param mixed $columnKey
 * @param int|null $indexKey
 * @return array
 */
function arrayColumn($input, $columnKey, $indexKey = null ) {
    $result = array();
    foreach( $input as $k => $v )
        $result[$indexKey ? $v[$indexKey] : $k] = $v[$columnKey];
    return $result;
}

/**
 * @param string $dir
 * @return bool
 */
function deleteFilesInDir($dir){
    $dirs = scandir($dir);
    foreach($dirs as $t){
        if($t != ".." && $t != "." && '.svn'){
            if(is_dir($dir.'/'.$t)){
                deleteFilesInDir($dir.'/'.$t);
            }else if(is_file($dir.'/'.$t)){
                unlink($dir.'/'.$t);
            }
        }
    }
    return true;
}

/**
 * @param array $data
 * @return array
 */
function getImagesArray($data){
    $data = explode(',', $data);
    for($i = 0; $i < count($data); $i++){
        if(strlen($data[$i]) < 5){
            unset($data[$i]);
        }
    }
    return $data;
}

/**
 * @param string $dir
 */
function emptyDirRecursive($dir) {
    if (is_dir($dir)) {
        $scn = scandir($dir);
        foreach ($scn as $files) {
            if ($files !== '.') {
                if ($files !== '..') {
                    if (!is_dir($dir . '/' . $files)) {
                        unlink($dir . '/' . $files);
                    } else {
                        emptyDirRecursive($dir . '/' . $files);
                        rmdir($dir . '/' . $files);
                    }
                }
            }
        }
    }
}

/**
 * @param string $path
 * @return int
 */
function dirSize($path){
    if(is_file($path)) return filesize($path);
    $size = 0;
    $dh = opendir($path);
    while(($file=readdir($dh))!==false) {
        if($file=='.' || $file=='..') continue;
        if(is_file($path.'/'.$file)) $size += filesize($path.'/'.$file);
        else $size += dirSize($path.'/'.$file);
    }
    closedir($dh);
    return $size + filesize($path);
}

/**
 * @param int $bytes
 * @return string
 */
function sizeConvert($bytes){
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

    foreach($arBytes as $arItem) {
        if($bytes >= $arItem["VALUE"]) {
            $result = $bytes / $arItem["VALUE"];
            $result = str_replace(".", "," , strval(round($result, 2)))." ".$arItem["UNIT"];
            break;
        } else {
            $result = "0 ".$arItem["UNIT"];
        }
    }
    return $result;
}

/**
 * @param array $array
 * @param int $id
 * @param array $result
 * @return array
 */
function getSubId($array, $id, &$result = array()) {
    foreach($array as $t) {
        if($t['parent'] == $id) {
            $result[] =  $t['id'];
            getSubId($array, $t['id'], $result);
        }
    }
    return $result;
}

/**
 * @param array $array
 * @param int $id
 * @param int $count
 * @return int|null
 */
function getRecordsCount($array, $id, $count) {
    if(!$id)
        return null;
    $result = $count;
    foreach($array as $t) {
        if($t['parent'] == $id) {
            $result += $t['count'];
            $result += getRecordsCount($array, $t['id'], 0);
        }
    }
    return $result;
}

/**
 * @param array $list
 * @param array $parent
 * @return array
 */
function createTreeArray(&$list, $parent) {
    $tree = array();
    foreach($parent as $k => $l) {
        if(isset($list[$l['id']])) {
            $l['children'] = createTreeArray($list, $list[$l['id']]);
        }
        $tree[] = $l;
    }
    return $tree;
}

/**
 * @param array $array
 * @param mixed $old
 * @param mixed $new
 * @return array
 */
function arrayRenameKey(&$array, $old, $new) {
    if(!is_array($array)) {
        ($array == "") ? $array = array() : false;
        return $array;
    }
    foreach($array as &$arr) {
        if(is_array($old)) {
            foreach($new as $k => $n) {
                (isset($old[$k])) ? true : $old[$k] = NULL;
                $arr[$n] = (isset($arr[$old[$k]]) ? $arr[$old[$k]] : null);
                unset($arr[$old[$k]]);
            }
        } else {
            $arr[$new] = (isset($arr[$old]) ? $arr[$old] : null);
            unset($arr[$old]);
        }
    }
    return $array;
}

/**
 * @param int $id
 * @return void
 */
function getCaptcha($id = 0) {
    $rand = rand(10000, 99999);
    $_SESSION[md5('captcha-'.$id)] = base64_encode(md5($rand));
    $picture = imagecreatetruecolor(60, 30);

    imagecolortransparent($picture, 000);
    imagefilledrectangle($picture, 4, 4, 50, 25, 000);
    imagestring($picture, 5, 5, 7, substr($rand, 0, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 15, 7, substr($rand, 1, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 25, 7, substr($rand, 2, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 35, 7, substr($rand, 3, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));
    imagestring($picture, 5, 45, 7, substr($rand, 4, 1), imagecolorallocate($picture, rand(100, 200), rand(100, 200), rand(100, 200)));

    header("Content-type: image/png");
    imagepng($picture);
    imagedestroy($picture);
}

/**
 * @param array $data
 * @return string
 */
function buildPagination($data){
    $template = '<li%s><a href="%s">%s</a></li>%s';
    $result = '';

    if ($data['page'] > 1 ){
        $result .= sprintf($template, '', $data['url'].'1', '&larr;', "\n");
        $result .= sprintf($template, '', $data['url'].($data['page'] - 1).$data['url-param'], '‹', "\n");
    }
    if ($data['page'] - 2 > 1){
        $result .= sprintf($template, '', $data['url'].($data['page'] - 2).$data['url-param'], $data['page'] - 2, "\n");
    }
    if ($data['page'] - 1 > 1){
        $result .= sprintf($template, '', $data['url'].($data['page'] - 1).$data['url-param'], $data['page'] - 1, "\n");
    }

    $result .= sprintf($template, ' class="active"', '#', $data['page'], "\n");

    if(($data['page'] + 1) < $data['page-count']){
        $result .= sprintf($template, '', $data['url'].($data['page'] + 1).$data['url-param'], $data['page'] + 1, "\n");
    }
    if(($data['page'] + 2) < $data['page-count']){
        $result .= sprintf($template, '', $data['url'].($data['page'] + 2).$data['url-param'], $data['page'] + 2, "\n");
    }
    if($data['page'] < $data['page-count']){
        $result .= sprintf($template, '', $data['url'].($data['page'] + 1).$data['url-param'], '›', "\n");
        $result .= sprintf($template, '', $data['url'].$data['page-count'].$data['url-param'], '&rarr;', "\n");
    }

    return $result;
}