#!/usr/bin/php

<?php

include('./vendor/autoload.php');

use Guilherme\Timezone\Exceptions\CodeInvalidException;
use Guilherme\Timezone\Exceptions\CountryCodeNotFoundException;
use Guilherme\Timezone\Repository\CountryTimeZone;
use Guilherme\Timezone\UseCases\CountryDate\CountryDate;
use Guilherme\Timezone\UseCases\CountryTimezoneGMT\CountryTimezoneGMT;
use Guilherme\Timezone\UseCases\TimezoneBetweenCountries\TimezoneBetweenCountries;
use Guilherme\Timezone\ValueObject\Code;

$result = match ($argc) {
    2 => oneParam($argv[1]),
    3 => twoParam($argv[1], $argv[2]),
    4 => threeParam($argv[1], $argv[2], $argv[3]),
    default =>  help()
};


function oneParam($command) 
{
    return match ($command) {
        '--help' => help(),
        '-c', '--codes' => countriesAndCodes(),
        '-H', '--hour' => hourHelp(),
        '-t', '--timezone' => timezoneHelp(),
        default =>  "Command $command not found". PHP_EOL . "Run './timezone.php --help for more information'"
    };
}

function twoParam($command, $argument) {
    return match ($command) {
        '-H', '--hour' => countryDate($argument),
        '-t', '--timezone' => timezoneGMT($argument),
        '-c', '--codes' => countriesAndCodesHelp(),
        default => "Command $command not found" . PHP_EOL . "Run 'php ./timezone.php  --help for more information'"
    };
}

function threeParam($command, $argument, $secondArgument) {
    return match ($command) {
        '-t', '--timezone' => timezoneBetweenTwoCountries($argument, $secondArgument),
        default => "Command $command not found" . PHP_EOL . "Run 'php ./timezone.php  --help for more information'"
    };
}



function countryDate(string $countryCode) {

    if ($countryCode === '--help') {
        return hourHelp();
    }

    $countryDate = new CountryDate(new CountryTimeZone());

    try {
        $date = $countryDate->date(new Code($countryCode));
    } catch (CountryCodeNotFoundException $e) {
        return $e->getMessage();
    } catch (CodeInvalidException $e) {
        return $e->getMessage();
    }

    return $date;
}

function timezoneBetweenTwoCountries (string $countryCodeOrigin, string $countryCodeTarget): string
{
    if ($countryCodeOrigin === '--help') {
        return timezoneHelp();
    }

    $timezone = new TimezoneBetweenCountries(new CountryTimeZone());

    try {
        $timezoneCalculated = $timezone->calculate(new Code($countryCodeOrigin), new Code($countryCodeTarget));
    } catch (CountryCodeNotFoundException  $e) {
        return $e->getMessage();
    } catch (CodeInvalidException  $e) {
        return $e->getMessage();
    }

    return $timezoneCalculated;
}

function timezoneGMT(string $codeCountryTarget) {

    if ($codeCountryTarget === '--help') {
        return timezoneHelp();
    }

        $timezone = new CountryTimezoneGMT(new CountryTimeZone());
    try {
        $timezoneCalculated =  $timezone->calculate(new Code($codeCountryTarget));
    } catch (CountryCodeNotFoundException $e) {
        return $e->getMessage();
    } catch (CodeInvalidException $e) {
        return $e->getMessage();
    }

    return $timezoneCalculated;
}

function countriesAndCodes():string
{
    $countries = json_decode(file_get_contents('countries.json'));
    $res = "";

    foreach ($countries as $code => $country){
        $res = $res . "$code -> $country" . PHP_EOL;
    }

    return $res;
}

function help()
{
    return "Usage: 'php ./timezone.php  [COMMAND]'" . PHP_EOL . PHP_EOL
    .'Command:' . PHP_EOL . 
    '-c, --codes  Show all countries and codes ' . PHP_EOL .
    '-H, --hour Show current hour and date of country' . PHP_EOL .
    '-t, --timezone Show country timezone' . PHP_EOL .
     PHP_EOL . "Run 'php ./timezone.php  [COMMAND] --help for more information on a command'";
}

function hourHelp(): string
{
    return '"-H or --hour" requires 1 argument' . PHP_EOL . 
    "This command will show current hour and date of country in 'YYYY-MM-DD HH:ii' format" . PHP_EOL .
    'Usege: php ./timezone.php  -H [COUNTRY_CODE]';
}

function timezoneHelp(): string
{
    return '"-t ou --timezone" requires 1 or 2 arguments' . PHP_EOL . 
    "This command show the timezone, if pass only 1 argument, show timezone comparation with the GMT and country passed, if pass 2 arguments, show timezone comparation between the 2 countries passed" . PHP_EOL .
    'Usege: php ./timezone.php  -t [COUNTRY_CODE] ' . PHP_EOL .
    'Usege: php ./timezone.php  -t [COUNTRY_CODE_ORIGIN] [COUNTRY_CODE_TARGET]';
}

function countriesAndCodesHelp(): string
{
    return 'This command show all contries and your codes' . PHP_EOL . "Country -> Country Code";

}

echo $result;