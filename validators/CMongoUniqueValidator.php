<?php
/**
 * CUniqueValidator class file.
 *
 * @author Leon Ma
 */

class CMongoUniqueValidator extends CValidator
{
	public $allowEmpty=true;

	public function validateAttribute($object, $attribute)
	{
		$value = $object->{$attribute};
		if($this->allowEmpty && ($value === null || $value === ''))
			return;

		$criteria = new EMongoCriteria;
		$criteria->{$attribute} = $value;
        	$criteria->addCond('_id', '!=', $object->_id);
		$count = $object->count($criteria);

		if($count !== 0)
			$this->addError(
				$object,
				$attribute,
				Yii::t('yii', '{attribute} is not unique in DB.')
			);
	}
}
