<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read int $skuId
 * @property-read int $fieldId
 * @property-read int $fieldValueId
 * @property-read int|null $id
 * @property-read string|null $text
 */
class SkuSpecification extends AbstractEntity
{
	public function __construct(
		protected int $skuId,
		protected int $fieldId,
		protected int $fieldValueId,
		protected ?int $id = null,
		protected ?string $text = null,
	) {
		//
	}
}