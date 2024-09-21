<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read int $id
 * @property-read int $fieldTypeId
 * @property-read int $fieldGroupId
 * @property-read string $name
 * @property-read string $description
 * @property-read int $position
 * @property-read bool $isFilter
 * @property-read bool $isRequired
 * @property-read bool $isOnProductDetails
 * @property-read bool $isStockKeepingUnit
 * @property-read bool $isActive
 * @property-read bool $isTopMenuLinkActive
 * @property-read bool $isSideMenuLinkActive
 * @property-read string|null $defaultValue
 */
class Specification extends AbstractEntity
{
	public function __construct(
		protected int $id,
		protected int $fieldTypeId,
		protected int $fieldGroupId,
		protected string $name,
		protected string $description,
		protected int $position,
		protected bool $isFilter,
		protected bool $isRequired,
		protected bool $isOnProductDetails,
		protected bool $isStockKeepingUnit,
		protected bool $isActive,
		protected bool $isTopMenuLinkActive,
		protected bool $isSideMenuLinkActive,
		protected ?string $defaultValue,
	) {
		//
	}
}
