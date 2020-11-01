# Laravel EasyRegex Package

[![Issues](https://img.shields.io/github/issues/DarshPhpDev/easyregex.svg?style=flat-square)](https://github.com/DarshPhpDev/easyregex/issues)
[![Stars](https://img.shields.io/github/stars/DarshPhpDev/easyregex.svg?style=flat-square)](https://github.com/DarshPhpDev/easyregex/stargazers)
[![Downloads](https://img.shields.io/packagist/dt/DarshPhpDev/easyregex.svg?style=flat-square)](https://github.com/DarshPhpDev/easyregex)
[![License](https://poser.pugx.org/DarshPhpDev/easyregex/license.svg)](https://github.com/DarshPhpDev/easyregex)

## Simple Regex Pattern Generator and Validator.
#### Regular expressions are dense. This makes them hard to read, but not in proportion to the information they carry. It has a very terse syntax and if you make even the smallest mistake it won’t perform as expected.

#### It's Ok. Writing regular expressions will not be your biggest fears any more!


## INSTALLATION

Install the package through [Composer](http://getcomposer.org/).

`composer require darshphpdev/easyregex`

## CONFIGURATION
Optional: The service provider will automatically get registered. 
Or you may manually add the service provider to providers array in your config/app.php file:
```php
'providers' => [
    // ...
    DarshPhpDev\EasyRegex\\EasyRegexServiceProvider::class,
];
```

## HOW TO USE

-   [Quick Usage](#quick)
-   [Usage](#usage)
-   [Examples](#examples)
-   [Credits](#credits)
-   [License](#license)

## Quick Usage

```php
// In your controller
// Use The Helper class RegexBuilder to build and validate regex
use RegexBuilder;

$regex = RegexBuilder::make()->startsWith()->literally('abc')
					->anyLetterOf('A', 'B', 'C')
					->zeroOrMore()
			    		->where(function ($query) {
					        $query->digit()->smallLetter();
					    })->toRegexString();
// the above example will return the regex string /^abc[ABC]*([0-9][a-z])/

// you can also match your string against the generated regex
$regexObject = RegexBuilder::make()->startsWith()->literally('abc')
					->anyLetterOf('A', 'B', 'C')
					->zeroOrMore()
			    		->where(function ($query) {
					        $query->digit()->smallLetter();
					    });
$isMatching = $regexObject->match('abcAAA5g');		// $isMatching = true
$isMatching = $regexObject->match('abdd5g');		// $isMatching = false

// you can also specify the wrapping symbol as an argument to the make() function
// default is '/'
$regex = RegexBuilder::make('#')->literally('a')
				->letterPatternOf('ABC')
				->zeroOrMore()
	    			->toRegexString();
// the above example will return the regex string #a(ABC)*#

// you can also use the global helper regexBuilder()
$regex = regexBuilder()->make()->digit()
			->capitalLetters('A', 'F')
			->onceOrMore()
			->toRegexString();			    		
// the above example will return the regex string /[0-9][A-F]+/
// FOR FULL USAGE, SEE BELOW..
```

## Usage

### Table Of Helper Regex Functions

Use the following function to build your regex string.

|        Function        |                                          Description                                          |                         Arguments                         |
|:----------------------:|:---------------------------------------------------------------------------------------------:|:---------------------------------------------------------:|
|         make()         | Initialize the builder object, set the default wrapper delimiter /                            |                   $delimiter (Optional)                   |
|      startsWith()      | Inserts the start with regex symbol                                                           |                             -                             |
|      onceOrMore()      | Repeat the preceding letter/pattern once or more                                              |                             -                             |
|      zeroOrMore()      | Repeat the preceding letter/pattern zero times or more                                        |                             -                             |
|        anyChar()       | Matches any character or digit including special ones.                                        |                             -                             |
|          tab()         | Matches tab                                                                                   |                             -                             |
|        newLine()       | Matches new line                                                                              |                             -                             |
|      whitespace()      | Matches white space                                                                           |                             -                             |
|        anyWord()       | Matches any word (letters or digits)                                                          |                             -                             |
|       literally()      | Matches any single letter or set of letters or pattern including special chars and meta chars |                      $str (Required)                      |
|      anyLetterOf()     | Matches one letter of the given single or multiple parameters                                 |                    $letters (Required)                    |
|    exceptLetterOf()    | Ignores one letter of the given single or multiple parameters                                 |                    $letters (Required)                    |
|    letterPatternOf()   | Matches the whole letter set with the given sorting.                                          |                    $letters (Required)                    |
|    exceptPatternOf()   | Matches any thing except for the whole letter set with the given sorting.                     |                    $letters (Required)                    |
|         digit()        | Matches any digit                                                                             | - $min (Optional) default[0] - $max (Optional) default[9] |
|       notDigit()       | Matches any thing except any digit                                                            | - $min (Optional) default[0] - $max (Optional) default[9] |
|        atLeast()       | Matches Repeating the preceding pattern at least $number of times                             |                     $number (Required)                    |
|        atMost()        | Matches Repeating the preceding pattern at most $number of times                              |                     $number (Required)                    |
|      smallLetter()     | Matches any small letter between $min and $max letters                                        | - $min (Optional) default[a] - $max (Optional) default[z] |
|  exceptSmallLetters()  | Matches any small letter except those between $min and $max letters                           | - $min (Optional) default[a] - $max (Optional) default[z] |
|    capitalLetters()    | Matches any capital letter between $min and $max letters                                      | - $min (Optional) default[A] - $max (Optional) default[Z] |
| exceptCapitalLetters() | Matches any capital letter except those between $min and $max letters                         | - $min (Optional) default[A] - $max (Optional) default[Z] |
|       optional()       | Make the preceding pattern optional                                                           |                             -                             |
|       rawRegex()       | Add raw regex string                                                                          |                         $rawString                        |
|         where()        | Group set of regex expressions                                                                |                    Closure function(){}                   |
|     toRegexString()    | Return the final Regex string.                                                                |                             -                             |
|         match()        | Validate your $input against the generated regex string                                       |                     $input (Required)                     |

## Examples

### More examples!

```php
$regex = RegexBuilder::make()->literally('Regex')->toRegexString();
// $regex = /Regex/
$regex = RegexBuilder::make()->anyLetterOf('a', 'b', 'c')->toRegexString();
// $regex = /[abc]/
$regex = RegexBuilder::make()->exceptLetterOf('c')->toRegexString();
// $regex = /[^c]/
$regex = RegexBuilder::make()->letterPatternOf('july')->toRegexString();
// $regex = /(july)/
$regex = RegexBuilder::make()->digit()->anyChar()->toRegexString();
// $regex = /[0-9]./
$regex = RegexBuilder::make()->anyChar()->atMost(5)->toRegexString();
// $regex = /.{5}/
$regex = RegexBuilder::make()->exceptSmallLetters('u', 'z')->toRegexString();
// $regex = /[^u-z]/
$regex = RegexBuilder::make()->capitalLetters('A', 'F')->toRegexString();
// $regex = /[A-F]/
$regex = RegexBuilder::make()->rawRegex('a(ABC)*')->match('aABCABCABC');
// $regex = true
$regex = RegexBuilder::make()->rawRegex('a(ABC)*')->match('aABCABCA');
// $regex = false

// and so on..
```
### Any suggestions or enhancements are very welcomed.

## Credits

- [MUSTAFA AHMED](https://github.com/DarshPhpDev)

## License

The EasyRegex Package is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)

