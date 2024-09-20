<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read string $name
 * @property-read int $fieldId
 * @property-read bool $isActive
 * @property-read bool $isRequired
 * @property-read int $fieldTypeId
 * @property-read string $fieldTypeName
 * @property-read int|null $fieldValueId
 * @property-read bool $isStockKeepingUnit
 * @property-read bool $isFilter
 * @property-read bool $isOnProductDetails
 * @property-read int $position
 * @property-read bool $isTopMenuLinkActive
 * @property-read bool $isSideMenuLinkActive
 * @property-read string|null $defaultValue
 * @property-read int $fieldGroupId
 * @property-read string $fieldGroupName
 */
class SpecificationField extends AbstractEntity
{
	public function __construct(
		protected string $name,
		protected int $fieldId,
		protected bool $isActive,
		protected bool $isRequired,
		protected int $fieldTypeId,
		protected string $fieldTypeName,
		protected ?int $fieldValueId,
		protected bool $isStockKeepingUnit,
		protected bool $isFilter,
		protected bool $isOnProductDetails,
		protected int $position,
		protected bool $isTopMenuLinkActive,
		protected bool $isSideMenuLinkActive,
		protected ?string $defaultValue,
		protected int $fieldGroupId,
		protected string $fieldGroupName
	) {
		//
	}
}
