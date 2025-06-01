<?php
function item_category($name){
    if(strpos($name,'宝箱')!==false) return 'chest';
    if(strpos($name,'时装')!==false) return 'costume';
    if(strpos($name,'卡')!==false) return 'card';
    if(strpos($name,'图鉴')!==false) return 'album';
    if(strpos($name,'礼包')!==false) return 'pack';
    if(strpos($name,'宝石')!==false) return 'gem';
    if(strpos($name,'称号')!==false) return 'title';
    return 'prop';
}

if($_POST){
    $key = trim($_POST['keyword'] ?? '');
    $cat = trim($_POST['category'] ?? '');
    $return = array();
    $file = fopen("onekey/item.admin.txt", "r");
    while(!feof($file)){
        $line = trim(fgets($file));
        if(!$line) continue;
        $txts = explode(';',$line);
        if(count($txts)==2){
            $itemCat = item_category($txts[1]);
            if($cat && $cat != $itemCat) continue;
            if($key && strpos($txts[1], $key) === false) continue;
            $return[] = array('key'=>$txts[0],'val'=>$txts[1]);
        }
    }
    fclose($file);
    echo json_encode($return);
}else{
    echo json_encode([]);
}