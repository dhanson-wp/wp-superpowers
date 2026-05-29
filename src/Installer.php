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
			static function (string $path) use ($projectDir): string {
				return self::resolveProjectPath($projectDir, $path);
			},
			$paths
		));
	}

	private static function resolveProjectPath(string $projectDir, string $path): string
	{
		if ('' === trim($path)) {
			throw new RuntimeException('wp-superpowers: destination path cannot be empty.');
		}

		if (self::isAbsolutePath($path)) {
			throw new RuntimeException('wp-superpowers: destination path must be project-relative: ' . $path);
		}

		$projectDir = self::normalizePath($projectDir);
		$resolved   = self::normalizePath($projectDir . '/' . $path);

		if ($resolved === $projectDir) {
			throw new RuntimeException('wp-superpowers: destination path must be a project subdirectory: ' . $path);
		}

		if (0 !== strpos($resolved, $projectDir . '/')) {
			throw new RuntimeException('wp-superpowers: destination path escapes the project directory: ' . $path);
		}

		return $resolved;
	}

	private static function isAbsolutePath(string $path): bool
	{
		return 1 === preg_match('/^(?:[A-Za-z]:[\/\\\\]|[\/\\\\])/', $path);
	}

	private static function normalizePath(string $path): string
	{
		$path  = str_replace('\\', '/', $path);
		$parts = [];

		foreach (explode('/', $path) as $part) {
			if ('' === $part || '.' === $part) {
				continue;
			}

			if ('..' === $part) {
				array_pop($parts);
				continue;
			}

			$parts[] = $part;
		}

		$prefix = 0 === strpos($path, '/') ? '/' : '';

		return rtrim($prefix . implode('/', $parts), '/') ?: $prefix;
	}

	private static function installTo(string $source, string $destination, object $io): void
	{
		if (! is_dir($destination) && ! mkdir($destination, 0755, true)) {
			throw new RuntimeException('wp-superpowers: failed to create destination directory: ' . $destination);
		}

		$skills = array_filter(
			scandir($source) ?: [],
			static function (string $entry) use ($source): bool {
				return $entry !== '.' && $entry !== '..' && is_dir($source . '/' . $entry);
			}
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
		if (is_link($source)) {
			throw new RuntimeException('wp-superpowers: refusing to copy symlinked source directory: ' . $source);
		}

		if (! is_dir($destination) && ! mkdir($destination, 0755, true)) {
			throw new RuntimeException('wp-superpowers: failed to create directory: ' . $destination);
		}

		$entries = array_filter(
			scandir($source) ?: [],
			static function (string $entry): bool {
				return $entry !== '.' && $entry !== '..';
			}
		);

		foreach ($entries as $entry) {
			$sourcePath      = $source . '/' . $entry;
			$destinationPath = $destination . '/' . $entry;

			if (is_dir($sourcePath)) {
				self::copyDirectory($sourcePath, $destinationPath);
			} elseif (is_link($sourcePath)) {
				throw new RuntimeException('wp-superpowers: refusing to copy symlinked source file: ' . $sourcePath);
			} elseif (! copy($sourcePath, $destinationPath)) {
				throw new RuntimeException('wp-superpowers: failed to copy file: ' . $sourcePath);
			}
		}
	}

	private static function removeDirectory(string $path): void
	{
		if (! is_dir($path)) {
			return;
		}

		if (is_link($path)) {
			if (! unlink($path)) {
				throw new RuntimeException('wp-superpowers: failed to remove symlink: ' . $path);
			}

			return;
		}

		$entries = array_filter(
			scandir($path) ?: [],
			static function (string $entry): bool {
				return $entry !== '.' && $entry !== '..';
			}
		);

		foreach ($entries as $entry) {
			$entryPath = $path . '/' . $entry;

			if (is_dir($entryPath)) {
				self::removeDirectory($entryPath);
			} elseif (! unlink($entryPath)) {
				throw new RuntimeException('wp-superpowers: failed to remove file: ' . $entryPath);
			}
		}

		if (! rmdir($path)) {
			throw new RuntimeException('wp-superpowers: failed to remove directory: ' . $path);
		}
	}
}
