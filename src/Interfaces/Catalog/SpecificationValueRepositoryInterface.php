<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\SpecificationValue;
use Doctrine\Common\Collections\Collection;
use GuzzleHttp\Promise\PromiseInterface;

interface SpecificationValueRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return Collection<SpecificationValue>|PromiseInterface
	 */
	public function getValues(int $fieldId): Collection|PromiseInterface;

	public function update(SpecificationValue $specification): null|PromiseInterface;

	public function create(SpecificationValue $specification): null|PromiseInterface;
}