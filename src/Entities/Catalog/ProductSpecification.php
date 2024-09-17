<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read int|null $id
 * @property-read string $name
 * @property-read array $values
 */
class ProductSpecification extends AbstractEntity
{
	public function __construct(
		protected ?int $id,
		protected string $name,
		protected array $values,
	) {
		//
	}
}