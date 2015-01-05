<?php
/**
 * Created by PhpStorm.
 * User: soooldier
 * Date: 1/4/15
 * Time: 21:15
 */
namespace china\region;

class RegionUtils
{
    /**
     * 取得所有的省份
     * @return array|LogicException
     */
    public static function getAllProvinces()
    {
        static $province;
        if(empty($province)) {
            $path = dirname(__FILE__).DIRECTORY_SEPARATOR.'map.php';
            if (!is_readable($path)) {
                throw new \LogicException("Mapping file can not be found");
            }

            $province = require_once($path);
        }
        return $province;
    }

    /**
     * 取得某一城市下的子城市
     * @param $region
     * @return array
     */
    public static function getRegionChildren($region)
    {
        static $regions;
        $province = str_pad(substr($region, 0, 2), 6, 0);
        if(empty($regions[$province])) {
            $path = dirname(__FILE__).DIRECTORY_SEPARATOR.$province.'.php';
            if (!is_readable($path)) {
                return [];
            }

            $regions[$province] = require_once($path);
        }

        if($region == $province) {
            return $regions[$province]['children'];
        }
        $next = str_pad(substr($region, 0, 4), 6, 0);
        if($region == $next) {
            return $regions[$province]['children'][$next]['children'];
        }
        return $regions[$province]['children'][$next]['children'][$region]['children'];
    }
}