<?php

namespace Naper\Vtex\Repositories;

use GuzzleHttp\Client;

abstract class AbstractRepository
{
	protected Client $client;
	protected string $baseUrl;
	protected string $appKey;
	protected string $appToken;

	protected function getHeaders(): array
	{
		return [
			'Accept' => 'application/json',
			'Content-Type' => 'application/json',
			'X-VTEX-API-AppKey' => $this->appKey,
			'X-VTEX-API-AppToken' => $this->appToken,
		];
	}
}