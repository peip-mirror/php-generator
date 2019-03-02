<?php

/**
 * Test: Nette\PhpGenerator\Formatter::formatDocComment() & unformatDocComment()
 */

declare(strict_types=1);

use Nette\PhpGenerator\Formatter;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


Assert::same('', Formatter::formatDocComment(' '));
Assert::same("/** @var string */\n", Formatter::formatDocComment('@var string'));
Assert::same("/**\n * @var string\n */\n", Formatter::formatDocComment("@var string\n"));
Assert::same("/**\n * A\n * B\n * C\n */\n", Formatter::formatDocComment("A\nB\nC\n"));

Assert::same('', Formatter::unformatDocComment(''));
Assert::same('', Formatter::unformatDocComment("/**  */\n\r\t"));
Assert::same('@var string', Formatter::unformatDocComment(' /** @var string */ '));
Assert::same('@var string', Formatter::unformatDocComment("/**\n * @var string\n */"));
Assert::same("A\nB\nC", Formatter::unformatDocComment("/**\n * A\n * B\n * C\n */\n"));
