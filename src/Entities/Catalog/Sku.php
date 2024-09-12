<?php

namespace VtexSdk\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;
use DateTimeInterface;

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
		protected ?string $modalType = null,
		protected bool $kitItemsSellApart, // The name is wrong in the API
		protected array $videos = [],
	) {
		//
	}
}