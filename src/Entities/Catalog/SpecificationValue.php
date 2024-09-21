<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read int $fieldId
 * @property-read int|null $fieldValueId
 * @property-read string $value
 * @property-read bool $isActive
 * @property-read int $position
 * 
 */
class SpecificationValue extends AbstractEntity
{
	public function __construct(
		protected int $fieldId,
		protected string $value,
		protected bool $isActive,
		protected int $position,
		protected ?int $fieldValueId = null,
	) {
		//
	}
}
