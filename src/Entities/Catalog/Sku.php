<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read int $id
 * @property-read int $productId
 * @property-read bool $isActive
 * @property-read bool|null $activateIfPossible
 * @property-read string $name
 * @property-read string $refId
 * @property-read float|null $packagedHeight
 * @property-read float|null $packagedLength
 * @property-read float|null $packagedWidth
 * @property-read float|null $packagedWeightKg
 * @property-read float|null $height
 * @property-read float|null $length
 * @property-read float|null $width
 * @property-read float|null $weightKg
 * @property-read float|null $cubicWeight
 * @property-read bool $isKit
 * @property-read float|null $rewardValue
 * @property-read string|null $manufacturerCode
 * @property-read int $commercialConditionId
 * @property-read string $measurementUnit
 * @property-read float $unitMultiplier
 * @property-read string|null $modalType
 * @property-read bool $kitItemsSellApart
 * @property-read array $videos
 */
class Sku extends AbstractEntity
{
	public function __construct(
		protected int $id,
		protected int $productId,
		protected bool $isActive,
		protected ?bool $activateIfPossible,
		protected string $name,
		protected string $refId,
		protected ?float $packagedHeight,
		protected ?float $packagedLength,
		protected ?float $packagedWidth,
		protected ?float $packagedWeightKg,
		protected ?float $height,
		protected ?float $length,
		protected ?float $width,
		protected ?float $weightKg,
		protected ?float $cubicWeight,
		protected bool $isKit,
		protected ?float $rewardValue,
		protected ?string $manufacturerCode,
		protected int $commercialConditionId,
		protected string $measurementUnit,
		protected float $unitMultiplier,
		protected bool $kitItemsSellApart, // The name is wrong in the API
		protected ?string $modalType = null,
		protected array $videos = [],
	) {
		//
	}
}