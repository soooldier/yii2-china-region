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
            $path = dirname(__FILE__).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.'map.php';
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
     * @return array|boolean
     */
    public static function getRegionChildren($region)
    {
        if(empty($region)) {
            return false;
        }
        $province = str_pad(substr($region, 0, 2), 6, 0);
        $regions = self::regions($province);
        if(empty($regions)) {
            return false;
        }

        if($region == $province) {
            return $regions['children'];
        }
        $next = str_pad(substr($region, 0, 4), 6, 0);
        if($region == $next) {
            return $regions['children'][$next]['children'];
        }
        return $regions['children'][$next]['children'][$region]['children'];
    }

    /**
     * 取得城市名
     * @param string $region
     * @param string $sep
     * @return string|boolean
     */
    public static function getRegionName($region, $sep = " ")
    {
        if(empty($region)) {
            return false;
        }
        $province = str_pad(substr($region, 0, 2), 6, 0);
        $regions = self::regions($province);
        if(empty($regions)) {
            return false;
        }
        $regionName = $regions['name'];

        $next = str_pad(substr($region, 0, 4), 6, 0);
        if(isset($regions['children'][$next])) {
            $regionName .= $sep.$regions['children'][$next]['name'];
        }
        if(isset($regions['children'][$next]['children'][$region])) {
            $regionName .= $regions['children'][$next]['children'][$region]['name'];
        }
        return $regionName;
    }

    /**
     * @param $province
     * @return array
     */
    protected static function regions($province)
    {
        static $regions;
        if(empty($regions[$province])) {
            $path = dirname(__FILE__).DIRECTORY_SEPARATOR.'data'.DIRECTORY_SEPARATOR.$province.'.php';
            if (!is_readable($path)) {
                return [];
            }

            $regions[$province] = require_once($path);
        }
        return $regions[$province];
    }
}