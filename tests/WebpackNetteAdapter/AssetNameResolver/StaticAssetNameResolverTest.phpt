<?php

declare(strict_types = 1);

namespace OopsTests\WebpackNetteAdapter\AssetNameResolver;

use Oops\WebpackNetteAdapter\AssetNameResolver\CannotResolveAssetNameException;
use Oops\WebpackNetteAdapter\AssetNameResolver\StaticAssetNameResolver;
use Tester\Assert;
use Tester\TestCase;


require_once __DIR__ . '/../../bootstrap.php';


/**
 * @testCase
 */
class StaticAssetNameResolverTest extends TestCase
{

	public function testResolver()
	{
		$resolver = new StaticAssetNameResolver([
			'asset.js' => 'cached.resolved.asset.js',
		]);

		Assert::same('cached.resolved.asset.js', $resolver->resolveAssetName('asset.js'));
	}


	public function testCannotResolveAsset()
	{
		$resolver = new StaticAssetNameResolver([
			'asset.js' => 'cached.resolved.asset.js',
		]);

		Assert::throws(function () use ($resolver) {
			$resolver->resolveAssetName('unknownAsset.js');
		}, CannotResolveAssetNameException::class);
	}

}


(new StaticAssetNameResolverTest())->run();
