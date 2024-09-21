<?php

namespace Naper\Vtex\Interfaces\Catalog;

use Naper\Vtex\Interfaces\AsyncRepositoryInterface;
use Naper\Vtex\Entities\Catalog\SpecificationField;
use GuzzleHttp\Promise\PromiseInterface;

interface SpecificationFieldRepositoryInterface extends AsyncRepositoryInterface
{
	/**
	 * @return null|SpecificationField|PromiseInterface<null|SpecificationField>
	 */
	public function get(int $id): null|SpecificationField|PromiseInterface;

	public function update(SpecificationField $specification): null|PromiseInterface;

	public function create(SpecificationField $specification): null|PromiseInterface;
}