<?php

namespace DarshPhpDev\EasyRegex;

use BadMethodCallException;
class EasyRegex{

	protected $pattern;
	protected $patternWrapSymbol;

	protected static $simplePatterns = [
		'startsWith' 	=> '^',
		'onceOrMore' 	=> '+',
		'zeroOrMore' 	=> '*',
		'anyChar'		=> '.',
		'tab'			=> '\\t',
		'newLine'		=> '\\n',
		'whitespace'	=> '\s',
		'anyWord'		=> '\w',
		'backslash'		=> '\\\\',
	];

	public function make($delemiter = '/')
	{
		$this->patternWrapSymbol = $delemiter;
		return $this;
	}

	public function add($str)
	{
		$this->pattern .= $str;
		return $this;
	}

	public function literally(...$letters)
	{
		return count($letters) > 0 ? $this->add($this->escape(implode('', $letters))) : $this;
	}

	public function anyLetterOf(...$letters)
	{
		return count($letters) > 0 ? $this->add('[' . implode('', $letters) . ']') : $this;
	}

	public function exceptLetterOf(...$letters)
	{
		return count($letters) > 0 ? $this->add('[^' . implode('', $letters) . ']') : $this;
	}

	public function letterPatternOf(...$letters)
	{
		return count($letters) > 0 ? $this->add('(' . implode('', $letters) . ')') : $this;
	}

	public function exceptPatternOf(...$letters)
	{
		return count($letters) > 0 ? $this->add('[^' . implode('', $letters) . ']') : $this;
	}

	public function digit($min = 0, $max = 9)
	{
		return $this->add("[$min-$max]");
	}

	public function notDigit($min = 0, $max = 9)
	{
		return $this->add("[^$min-$max]");
	}

	public function atLeast($min)
	{
	    return $this->add(sprintf('{%d,}', $min));
	}

	public function atMost($count)
	{
	    return $this->add(sprintf('{%d}', $count));
	}

	public function smallLetter($min = 'a', $max = 'z')
	{
		return $this->add("[$min-$max]");
	}

	public function exceptSmallLetters($min = 'a', $max = 'z')
	{
		return $this->add("[^$min-$max]");
	}

	public function capitalLetters($min = 'A', $max = 'Z')
	{
		return $this->add("[$min-$max]");
	}

	public function exceptCapitalLetters($min = 'A', $max = 'Z')
	{
		return $this->add("[^$min-$max]");
	}

	public function optional()
	{
		return $this->add("?");
	}

	public function rawRegex($raw)
	{
		return $this->add($raw);
	}

	public function endPattern()
	{
		$this->add("/");
		return $this;
	}

	public function where($closure)
	{
		$newInstance = new self;
		$closure($newInstance);
		return $this->add('(' . $newInstance->regex() . ')');
	}

	public function regex()
	{
		return $this->pattern;
	}

	public function toRegexString()
	{
		return $this->patternWrapSymbol . $this->regex() . $this->patternWrapSymbol;
	}

	public function match($string)
	{
		return preg_match($this->toRegexString(), $string);
	}

	public function escape($str)
	{
		return preg_quote($str);
	}

	public function __call($method, $arguments)
	{
		if(isset(self::$simplePatterns[$method])){
			return $this->add(self::$simplePatterns[$method]);
		}
		return new BadMethodCallException(sprintf('Call to undefined method %s->%s()', get_class($this), $method));
	}
}
