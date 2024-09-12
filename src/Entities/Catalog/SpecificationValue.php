<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

class SpecificationValue extends AbstractEntity
{
	public function __construct(
		protected ?int $id,
		protected string $name,
		protected array $values,
	) {
		//
	}
}