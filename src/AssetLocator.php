<?php

declare(strict_types=1);

namespace Contributte\Webpack;

use Contributte\Webpack\AssetNameResolver\AssetNameResolverInterface;
use Contributte\Webpack\DevServer\DevServer;

final class AssetLocator
{
	private BuildDirectoryProvider $directoryProvider;

	private PublicPathProvider $publicPathProvider;

	private AssetNameResolverInterface $assetResolver;

	private DevServer $devServer;

	/** @var string[] */
	private array $ignoredAssetNames;

	/**
	 * @param string[] $ignoredAssetNames
	 */
	public function __construct(
		BuildDirectoryProvider $directoryProvider,
		PublicPathProvider $publicPathProvider,
		AssetNameResolverInterface $assetResolver,
		DevServer $devServer,
		array $ignoredAssetNames
	) {
		$this->directoryProvider = $directoryProvider;
		$this->publicPathProvider = $publicPathProvider;
		$this->assetResolver = $assetResolver;
		$this->devServer = $devServer;
		$this->ignoredAssetNames = $ignoredAssetNames;
	}

	private function locateInPath(string $path, string $asset): string
	{
		if ($this->devServer->isAvailable() && \in_array($asset, $this->ignoredAssetNames, true)) {
			return 'data:,';
		}

		return \rtrim($path, '/') . '/' . \ltrim($this->assetResolver->resolveAssetName($asset), '/');
	}

	public function locateInPublicPath(string $asset): string
	{
		return $this->locateInPath($this->publicPathProvider->getPublicPath(), $asset);
	}

	public function locateInBuildDirectory(string $asset): string
	{
		return $this->locateInPath($this->directoryProvider->getBuildDirectory(), $asset);
	}
}
