<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read int $id
 * @property-read int $archiveId
 * @property-read int $skuId
 * @property-read string $name
 * @property-read bool $isMain
 * @property-read string|null $text
 * @property-read string|null $label
 * @property-read string|null $url
 * @property-read string|null $fileLocation
 */
class SkuFile extends AbstractEntity
{
	public function __construct(
		protected int $id,
		protected int $archiveId,
		protected int $skuId,
		protected string $name,
		protected bool $isMain,
		protected ?string $text,
		protected ?string $label,
		protected ?string $url,
		protected ?string $fileLocation,
	) {
		//
	}
}
