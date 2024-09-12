<?php

namespace VtexSdk\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;
use DateTimeInterface;

class Product extends AbstractEntity
{
	public function __construct(
		protected string $name,
		protected string $title,
		protected int $departmentId,
		protected int $categoryId,
		protected int $brandId,
		protected string $linkId,
		protected string $refId,
		protected bool $isVisible,
		protected string $description,
		protected string $descriptionShort,
		protected DateTimeInterface $releaseDate,
		protected array $keyWords,
		protected bool $isActive,
		protected ?string $taxCode,
		protected ?string $metaTagDescription,
		protected ?int $supplierId,
		protected bool $showWithoutStock,
		protected ?string $adWordsRemarketingCode,
		protected ?string $lomadeeCampaignCode,
		protected ?int $score,
		protected ?int $id = null,
	) {
		//
	}
}