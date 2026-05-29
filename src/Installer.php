<?php

declare(strict_types=1);

namespace WPSuperpowers;

use Composer\Script\Event;
use RuntimeException;

final class Installer
{
	private const DEFAULT_PATH = '.claude/skills';
	private const SKILLS_DIR   = 'skills';

	/**
	 * Copies skills into one or more project skill directories.
	 *
	 * Configure destinations in the consuming project's composer.json:
	 *
	 * "extra": {
	 *     "wp-superpowers": {
	 *         "skills": {
	 *             "paths": [ ".claude/skills", ".codex/skills" ]
	 *         }
	 *     }
	 * }
	 */
	public static function install(Event $event): void
	{
		$composer   = $event->getComposer();
		$io         = $event->getIO();
		$extra      = $composer->getPackage()->getExtra();
		$vendorDir  = (string) $composer->getConfig()->get('vendor-dir');
		$projectDir = dirname($vendorDir);
		$source     = $vendorDir . '/dhanson-wp/wp-superpowers/' . self::SKILLS_DIR;

		if (! is_dir($source)) {
			$io->writeError('<warning>wp-superpowers: skills directory not found at ' . $source . '</warning>');
			return;
		}

		foreach (self::destinations($extra, $projectDir) as $destination) {
			self::installTo($source, $destination, $io);
		}
	}

	/**
	 * @param array<string, mixed> $extra
	 *
	 * @return list<string>
	 */
	private static function destinations(array $extra, string $projectDir): array
	{
		$config = $extra['wp-superpowers']['skills'] ?? [];
		$paths  = $config['paths'] ?? $config['path'] ?? self::DEFAULT_PATH;
		$paths  = is_array($paths) ? $paths : [ $paths ];

		return array_values(array_map(
			static fn(string $path): string => rtrim($projectDir . '/' . ltrim($path, '/'), '/'),
			$paths
		));
	}

	private static function installTo(string $source, string $destination, object $io): void
	{
		if (! is_dir($destination) && ! mkdir($destination, 0755, true)) {
			throw new RuntimeException('wp-superpowers: failed to create destination directory: ' . $destination);
		}

		$skills = array_filter(
			scandir($source) ?: [],
			static fn(string $entry): bool => $entry !== '.' && $entry !== '..' && is_dir($source . '/' . $entry)
		);

		foreach ($skills as $skill) {
			$skillSource      = $source . '/' . $skill;
			$skillDestination = $destination . '/' . $skill;

			self::removeDirectory($skillDestination);
			self::copyDirectory($skillSource, $skillDestination);

			$io->write('<info>wp-superpowers: installed ' . $skill . ' to ' . $destination . '</info>');
		}
	}

	private static function copyDirectory(string $source, string $destination): void
	{
		if (! is_dir($destination) && ! mkdir($destination, 0755, true)) {
			throw new RuntimeException('wp-superpowers: failed to create directory: ' . $destination);
		}

		$entries = array_filter(
			scandir($source) ?: [],
			static fn(string $entry): bool => $entry !== '.' && $entry !== '..'
		);

		foreach ($entries as $entry) {
			$sourcePath      = $source . '/' . $entry;
			$destinationPath = $destination . '/' . $entry;

			if (is_dir($sourcePath)) {
				self::copyDirectory($sourcePath, $destinationPath);
			} else {
				copy($sourcePath, $destinationPath);
			}
		}
	}

	private static function removeDirectory(string $path): void
	{
		if (! is_dir($path)) {
			return;
		}

		$entries = array_filter(
			scandir($path) ?: [],
			static fn(string $entry): bool => $entry !== '.' && $entry !== '..'
		);

		foreach ($entries as $entry) {
			$entryPath = $path . '/' . $entry;

			if (is_dir($entryPath)) {
				self::removeDirectory($entryPath);
			} else {
				unlink($entryPath);
			}
		}

		rmdir($path);
	}
}
