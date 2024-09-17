<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read int|null $fieldValueId
 * @property-read int $fieldId
 * @property-read string $name
 * @property-read string|null $text
 * @property-read bool $isActive
 * @property-read int $position
 */
class SpecificationValue extends AbstractEntity
{
	public function __construct(
		protected ?int $fieldValueId = null,
		protected int $fieldId,
		protected string $name,
		protected ?string $text,
		protected bool $isActive,
		protected int $position,
	) {
		//
	}
}