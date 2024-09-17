<?php

namespace Naper\Vtex\Repositories;

use GuzzleHttp\Client;

abstract class AbstractRepository
{
	protected Client $client;
	protected string $baseUrl;
	protected string $AppKey;
	protected string $AppToken;

	protected function getHeaders(): array
	{
		return [
			'Accept' => 'application/json',
			'Content-Type' => 'application/json',
			'X-VTEX-API-AppKey' => $this->AppKey,
			'X-VTEX-API-AppToken' => $this->AppToken,
		];
	}
}