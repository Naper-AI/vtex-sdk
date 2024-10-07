<?php

namespace Naper\Vtex\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

/**
 * @property-read string $itemId
 * @property-read float|null $listPrice
 * @property-read float $costPrice
 * @property-read float $markup
 * @property-read float $basePrice
 * @property-read array<int,array{tradePolicyId:string,value:float,listPrice:float|null,minQuantity:int,dateRange:array{from:string,to:string}}> $fixedPrices
 */
class SkuPrice extends AbstractEntity
{
	/**
	 * @param array<int,array{tradePolicyId:string,value:float,listPrice:float|null,minQuantity:int,dateRange:array{from:string,to:string}}> $fixedPrices
	 */
	public function __construct(
		protected string $itemId,
		protected ?float $listPrice,
		protected float $costPrice,
		protected float $markup,
		protected float $basePrice,
		protected array $fixedPrices,	
	) {
		//
	}
}
