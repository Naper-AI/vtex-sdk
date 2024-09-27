<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read string $itemId
 * @property-read int|null $listPrice
 * @property-read int $costPrice
 * @property-read float $markup
 * @property-read int $basePrice
 * @property-read array<int,array{tradePolicyId:string,value:float,listPrice:float|null,minQuantity:int,dateRange:array{from:string,to:string}}> $fixedPrices
 */
class SkuPrice extends AbstractEntity
{
	/**
	 * @param array<int,array{tradePolicyId:string,value:float,listPrice:float|null,minQuantity:int,dateRange:array{from:string,to:string}}> $fixedPrices
	 */
	public function __construct(
		protected string $itemId,
		protected ?int $listPrice,
		protected int $costPrice,
		protected float $markup,
		protected int $basePrice,
		protected array $fixedPrices,	
	) {
		//
	}
}
