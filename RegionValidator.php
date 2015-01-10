<?php
/**
 * Created by PhpStorm.
 * User: soooldier
 * Date: 1/4/15
 * Time: 21:05
 */
namespace china\region;

use yii\validators\Validator;
use china\region\RegionUtils;

/**
 * Class Region
 * @package \china\region
 */
class RegionValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = Yii::t('yii', 'The format of {attribute} is invalid.');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
        return RegionUtils::getRegionName($value) ? null : [$this->message, []];
    }
}