<?php

/**
 * This file is part of the Nette Framework (https://nette.org)
 * Copyright (c) 2004 David Grudl (https://davidgrudl.com)
 */

declare(strict_types=1);

namespace Nette\PhpGenerator;



/**
 * PHP code generator utils.
 * @internal
 */
final class Helpers extends Formatter
{
	public const PHP_IDENT = '[a-zA-Z_\x7f-\xff][a-zA-Z0-9_\x7f-\xff]*';


	public static function formatArgs(string $statement, array $args): string
	{
		return Formatter::format($statement, ...$args);
	}


	public static function isIdentifier($value): bool
	{
		return is_string($value) && preg_match('#^' . self::PHP_IDENT . '\z#', $value);
	}


	public static function isNamespaceIdentifier($value, bool $allowLeadingSlash = false): bool
	{
		$re = '#^' . ($allowLeadingSlash ? '\\\\?' : '') . self::PHP_IDENT . '(\\\\' . self::PHP_IDENT . ')*\z#';
		return is_string($value) && preg_match($re, $value);
	}


	/**
	 * @return object
	 * @internal
	 */
	public static function createObject(string $class, array $props)
	{
		return unserialize('O' . substr(serialize($class), 1, -1) . substr(serialize($props), 1));
	}


	public static function extractNamespace(string $name): string
	{
		return ($pos = strrpos($name, '\\')) ? substr($name, 0, $pos) : '';
	}


	public static function extractShortName(string $name): string
	{
		return ($pos = strrpos($name, '\\')) === false ? $name : substr($name, $pos + 1);
	}


	/** @deprecated */
	public static function tabsToSpaces(string $s, int $count = Formatter::INDENT_LENGTH): string
	{
		return str_replace("\t", str_repeat(' ', $count), $s);
	}
}
