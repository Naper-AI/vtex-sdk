<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read int $id
 * @property-read string $name
 * @property-read bool $isActive
 * @property-read string $title
 * @property-read string $metaTagDescription
 * @property-read string|null $imageUrl
 */
class Brand extends AbstractEntity
{
	public function __construct(
		protected int $id,
		protected string $name,
		protected bool $isActive,
		protected string $title,
		protected string $metaTagDescription,
		protected ?string $imageUrl,
	) {
		//
	}
}
