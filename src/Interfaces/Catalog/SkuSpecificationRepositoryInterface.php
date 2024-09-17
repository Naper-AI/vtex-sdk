<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\SkuSpecification;
use Doctrine\Common\Collections\Collection;
use GuzzleHttp\Promise\PromiseInterface;

interface SkuSpecificationRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return Collection<array-key,SkuSpecification>|PromiseInterface<Collection<array-key,SkuSpecification>>
	 */
	public function getBySkuId(int $id): Collection|PromiseInterface;

	public function update(SkuSpecification $specification): null|PromiseInterface;

	public function create(SkuSpecification $specification): null|PromiseInterface;
}