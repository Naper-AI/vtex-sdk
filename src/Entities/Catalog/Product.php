<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;
use DateTimeInterface;

/**
 * @property-read string $name
 * @property-read string $title
 * @property-read int $departmentId
 * @property-read int $categoryId
 * @property-read int $brandId
 * @property-read string $linkId
 * @property-read string $refId
 * @property-read bool $isVisible
 * @property-read string $description
 * @property-read string|null $descriptionShort
 * @property-read DateTimeInterface $releaseDate
 * @property-read array $keyWords
 * @property-read bool $isActive
 * @property-read string|null $taxCode
 * @property-read string|null $metaTagDescription
 * @property-read int|null $supplierId
 * @property-read bool $showWithoutStock
 * @property-read string|null $adWordsRemarketingCode
 * @property-read string|null $lomadeeCampaignCode
 * @property-read int|null $score
 * @property-read int|null $id
 */
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
		protected ?string $descriptionShort,
		protected ?DateTimeInterface $releaseDate,
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