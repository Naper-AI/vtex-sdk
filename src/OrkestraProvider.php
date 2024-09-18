<?php

namespace Naper\Vtex;

use Orkestra\App;
use Orkestra\Interfaces\ProviderInterface;

use Naper\Vtex\Interfaces\Catalog\CategoryRepositoryInterface;
use Naper\Vtex\Interfaces\Catalog\ProductRepositoryInterface;
use Naper\Vtex\Interfaces\Catalog\SkuFileRepositoryInterface;
use Naper\Vtex\Interfaces\Catalog\SkuPriceRepositoryInterface;
use Naper\Vtex\Interfaces\Catalog\SkuRepositoryInterface;
use Naper\Vtex\Interfaces\Catalog\SkuSpecificationRepositoryInterface;
use Naper\Vtex\Interfaces\Catalog\SpecificationRepositoryInterface;
use Naper\Vtex\Interfaces\Catalog\SpecificationValueRepositoryInterface;

use Naper\Vtex\Repositories\Catalog\CategoryRepository;
use Naper\Vtex\Repositories\Catalog\ProductRepository;
use Naper\Vtex\Repositories\Catalog\SkuFileRepository;
use Naper\Vtex\Repositories\Catalog\SkuPriceRepository;
use Naper\Vtex\Repositories\Catalog\SkuRepository;
use Naper\Vtex\Repositories\Catalog\SkuSpecificationRepository;
use Naper\Vtex\Repositories\Catalog\SpecificationRepository;
use Naper\Vtex\Repositories\Catalog\SpecificationValueRepository;

class OrkestraProvider implements ProviderInterface
{
	public function register(App $app): void
	{
		$app->config()->set('definition', [
			'vtex' => ['The vtex API configuration', [
				'base_url' => '',
				'app_key' => '',
				'app_token' => '',
				'account_name' => '',
			]],
		]);

		$app->config()->set('validation', [
			'vtex' => function (array $config) {
				$required = ['base_url', 'app_key', 'app_token', 'account_name'];
				$missing = array_diff($required, array_keys($config));
				return empty($missing) ? true : 'Missing required keys (' . implode(', ', $missing) . ')';
			},
		]);

		$getConfig = fn(string $key) => $app->config()->get('vtex')[$key];

		$vtexConfig = [
			'baseUrl' => fn () => $getConfig('base_url'),
			'appKey' => fn () => $getConfig('app_key'),
			'appToken' => fn () => $getConfig('app_token'),
		];

		$getAccountName = fn () => $getConfig('account_name');

		/**
		 * Catalog API binds
		 */
		$app->bind(CategoryRepositoryInterface::class, CategoryRepository::class)->constructor(...$vtexConfig);
		$app->bind(ProductRepositoryInterface::class, ProductRepository::class)->constructor(...$vtexConfig);
		$app->bind(SkuRepositoryInterface::class, SkuRepository::class)->constructor(...$vtexConfig);
		$app->bind(SkuSpecificationRepositoryInterface::class, SkuSpecificationRepository::class)->constructor(...$vtexConfig);
		$app->bind(SkuPriceRepositoryInterface::class, SkuPriceRepository::class)->constructor(...$vtexConfig, accountName: $getAccountName);
		$app->bind(SkuFileRepositoryInterface::class, SkuFileRepository::class)->constructor(...$vtexConfig);
		$app->bind(SpecificationRepositoryInterface::class, SpecificationRepository::class)->constructor(...$vtexConfig);
		$app->bind(SpecificationValueRepositoryInterface::class, SpecificationValueRepository::class)->constructor(...$vtexConfig);
	}

	public function boot(App $app): void
	{
		//
	}
}