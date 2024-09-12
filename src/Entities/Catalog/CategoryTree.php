<?php

namespace VtexSdk\Entities\Catalog;

use Orkestra\Entities\AbstractEntity;

class CategoryTree extends AbstractEntity
{
	protected array $children = [];

	public function __construct(
		protected int $id,
		protected string $name,
		protected bool $hasChildren,
		protected string $url,
		protected string $title,
		protected string $metaTagDescription
	) {
		//
	}

	public function setChildren(array $children): void
	{
		foreach ($children as $child) {
			if (!is_array($child) && !$child instanceof self) {
				continue;
			}

			if ($child instanceof self) {
				$this->children[] = $child;
				continue;
			}

			$instance = new self(
				$child['id'],
				$child['name'],
				$child['hasChildren'],
				$child['url'],
				$child['title'] ?? $child['Title'],
				$child['metaTagDescription'] ?? $child['MetaTagDescription']
			);

			if ($instance->hasChildren) {
				$instance->setChildren($child['children']);
			}

			$this->children[] = $instance;
		}
	}
}