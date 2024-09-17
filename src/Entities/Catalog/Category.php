<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read string $name
 * @property-read int|null $fatherCategoryId
 * @property-read string $title
 * @property-read string|null $description
 * @property-read array $keywords
 * @property-read bool $isActive
 * @property-read string|null $lomadeeCampaignCode
 * @property-read string|null $adWordsRemarketingCode
 * @property-read bool $showInStoreFront
 * @property-read bool $showBrandFilter
 * @property-read bool $activeStoreFrontLink
 * @property-read int $globalCategoryId
 * @property-read string $stockKeepingUnitSelectionMode
 * @property-read int|null $score
 * @property-read int|null $id
 * @property-read string|null $linkId
 * @property-read bool|null $hasChildren
 */
class Category extends AbstractEntity
{
	public function __construct(
		protected string $name,
		protected ?int $fatherCategoryId,
		protected string $title,
		protected ?string $description,
		protected array $keywords,
		protected bool $isActive,
		protected ?string $lomadeeCampaignCode, //
		protected ?string $adWordsRemarketingCode, //
		protected bool $showInStoreFront,
		protected bool $showBrandFilter,
		protected bool $activeStoreFrontLink,
		protected int $globalCategoryId,
		protected string $stockKeepingUnitSelectionMode,
		protected ?int $score,
		protected ?int $id = null,
		protected ?string $linkId = null,
		protected ?bool $hasChildren = null,
	) {
		//
	}
}