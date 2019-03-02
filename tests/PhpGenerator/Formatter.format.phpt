<?php

/**
 * Test: Nette\PhpGenerator\Formatter::format()
 */

declare(strict_types=1);

use Nette\PhpGenerator\Formatter;
use Nette\PhpGenerator\Helpers;
use Tester\Assert;


require __DIR__ . '/../bootstrap.php';


Assert::same('func', Formatter::format('func'));
Assert::same('func(1)', Formatter::format('func(?)', 1));
Assert::same('func', Helpers::formatArgs('func', []));
Assert::same('func(1)', Helpers::formatArgs('func(?)', [1]));
Assert::same('func(1 ? 2 : 3)', Formatter::format('func(1 \? 2 : 3)'));
Assert::same('func([1, 2])', Formatter::format('func(?)', [1, 2]));
Assert::same('func(1, 2)', Formatter::format('func(...?)', [1, 2]));
Assert::same('func(1, 2)', Formatter::format('func(?*)', [1, 2])); // old way
same(
'func(
	10,
	11,
	12,
	13,
	14,
	15,
	16,
	17,
	18,
	19,
	20,
	21,
	22,
	23,
	24,
	25,
	26,
	27,
	28,
	29,
	30,
	31,
	32,
	33,
	34,
	35,
	36
)',
	Formatter::format('func(?*)', range(10, 36))
);

Assert::exception(function () {
	Formatter::format('func(...?)', 1, 2);
}, Nette\InvalidArgumentException::class, 'Argument must be an array.');

Assert::exception(function () {
	Formatter::format('func(?)', 1, 2);
}, Nette\InvalidArgumentException::class, 'Insufficient number of placeholders.');

Assert::exception(function () {
	Formatter::format('func(?, ?, ?)', [1, 2]);
}, Nette\InvalidArgumentException::class, 'Insufficient number of arguments.');

Assert::same('$a = 2', Formatter::format('$? = ?', 'a', 2));
Assert::same('$obj->a = 2', Formatter::format('$obj->? = ?', 'a', 2));
Assert::same('$obj->{1} = 2', Formatter::format('$obj->? = ?', 1, 2));
Assert::same('$obj->{\' \'} = 2', Formatter::format('$obj->? = ?', ' ', 2));

Assert::with(Formatter::class, function () {
	Assert::same('Item', Formatter::formatMember('Item'));
	Assert::same("{'0Item'}", Formatter::formatMember('0Item'));
});
