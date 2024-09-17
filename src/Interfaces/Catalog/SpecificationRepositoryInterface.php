<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\Specification;
use GuzzleHttp\Promise\PromiseInterface;

interface SpecificationRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return Specification|PromiseInterface<Specification>
	 */
	public function get(int $id): Specification|PromiseInterface;

	public function update(Specification $specification): null|PromiseInterface;

	public function create(Specification $specification): null|PromiseInterface;
}