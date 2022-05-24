<?php
/**
 * Class Report
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class Report extends Core{

    /**
     * @param int $user
     * @return string
     */
    public function getMainChartDateJSON($user){
        header('Content-Type: application/json');
        $data['visits'] = array_reverse($this->getDb()->getAll("SELECT * FROM statistics ORDER BY statistics.id DESC LIMIT ?i", 31));
        $data['actions']['all'] = array_reverse($this->getDb()->getAll("SELECT DATE(logs.time) day, COUNT(logs.id) count FROM logs GROUP BY DATE(logs.time) ORDER BY logs.time DESC LIMIT ?i", 31));
        $data['actions']['user'] = array_reverse($this->getDb()->getAll("SELECT DATE(logs.time) day, COUNT(logs.id) count FROM logs WHERE logs.user = ?i GROUP BY DATE(logs.time) ORDER BY logs.time DESC LIMIT ?i",$user, 31));
        return  json_encode($data);
    }

    /**
     * @return string
     */
    public function getMainStorageDateJSON(){
        header('Content-Type: application/json');
        $dbStatus = $this->getDb()->query("SHOW TABLE STATUS");
        $dbSize = 0;

        foreach ($dbStatus as $t){
            $dbSize += $t["Data_length"] + $t["Index_length"];
        }

        $cacheSize = dirSize(PATH.'/cache');
        $imagesSize = dirSize(PATH.$this->getSettings()->settings['images-dir']);
        $uploadsSize = dirSize(PATH.$this->getSettings()->settings['uploads-dir']);
        $imagesThumbnailsSize = dirSize(PATH.$this->getSettings()->settings['images-thumb-dir']);

        $imagesSize = $imagesSize - $imagesThumbnailsSize;

        $data['size']['mysql'] = sizeConvert($dbSize);
        $data['size']['cache'] = sizeConvert($cacheSize);
        $data['size']['images'] = sizeConvert($imagesSize);
        $data['size']['uploads'] = sizeConvert($uploadsSize);
        $data['size']['thumbnails'] = sizeConvert($imagesThumbnailsSize);
        return  json_encode($data);
    }
}