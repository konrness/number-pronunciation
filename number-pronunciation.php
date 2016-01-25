<?php
/**
 * Challenge Yourselph - 036
 * Pronouncing Hex
 *
 * Usage:
 *  php number-pronunciation.php 0xABCD
 *  php number-pronunciation.php 1234
 *
 * @author Konr Ness <konr.ness@gmail.com>
 */

use NumberPronunciation\BoxFactory;

// parse command options
$input = isset($argv[1]) ? $argv[1] : null;

if (null === $input) {
    echo <<<HELP
Usage:
  php number-pronunciation.php <number>

  <file>   A number in decimal or hexadecimal format
HELP;
}

require_once __DIR__ . '/vendor/autoload.php';

$parser = new \NumberPronunciation\NumberParser();

try {
    $number = $parser->parse($input);
    $pronouncer = \NumberPronunciation\Pronouncer\PronouncerFactory::create($number->getBase());
    $pronunciation = $pronouncer->pronounce($number);
} catch (InvalidArgumentException $e) {
    echo sprintf("Error: %s", $e->getMessage()) . PHP_EOL;
    exit(1);
}

echo sprintf("%s is pronounced: %s", $input, $pronunciation) . PHP_EOL;