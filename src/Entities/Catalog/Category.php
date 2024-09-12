<?php

namespace VtexSdk\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

class Category extends AbstractEntity
{
	public function __construct(
		protected string $name,
		protected ?int $fatherCategoryId,
		protected string $title,
		protected string $description,
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