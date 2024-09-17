<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Doctrine\Common\Collections\Collection;
use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\SkuFile;
use GuzzleHttp\Promise\PromiseInterface;

interface SkuFileRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return Collection<array-key,SkuFile>|PromiseInterface<Collection<array-key,SkuFile>>
	 */
	public function getBySkuId(int $id): Collection|PromiseInterface;

	public function update(SkuFile $file): null|PromiseInterface;

	public function create(SkuFile $fille): null|PromiseInterface;
}