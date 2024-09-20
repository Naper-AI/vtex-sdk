<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\SpecificationField;
use GuzzleHttp\Promise\PromiseInterface;

interface SpecificationFieldRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return SpecificationField|PromiseInterface<SpecificationField>
	 */
	public function get(int $id): SpecificationField|PromiseInterface;

	public function update(SpecificationField $specification): null|PromiseInterface;

	public function create(SpecificationField $specification): null|PromiseInterface;
}