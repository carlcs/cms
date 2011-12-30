<?php

class TemplateHelper
{
	/**
	 * Returns whether a variable is a tag or not
	 * @param mixed $var The variable
	 * @return bool Whether it's a tag or not
	 */
	public static function isTag($var)
	{
		return (is_object($var) && isset($var->__tag__));
	}

	/**
	 * Returns the appropriate tag for a variable
	 * @param mixed $var The variable
	 * @param object A tag instance for the variable
	 */
	public static function getVarTag($var = '')
	{
		// if $var is a tag, just return it
		if (self::isTag($var))
			return $var;

		// is it a number?
		if (is_int($var) || is_float($var))
			return new NumTag($var);

		// is it an array?
		if (is_array($var))
			return new ArrayTag($var);

		// is it a bool?
		if (is_bool($var))
			return new BoolTag($var);

		// is it an object?
		if (is_object($var))
		{
			return new ObjectTag($var);
		}

		// default to a string
		return new StringTag($var);
	}

	/**
	 * Combines and serializes the subtag name and arguments into a unique key
	 * @param string $tag The subtag name
	 * @param array $args The arguments passed to the subtag
	 * @return string The subtag's cache key
	 */
	public static function generateTagCacheKey($tag, $args)
	{
		$cacheKey = $tag;
		if ($args) $cacheKey .= '('.serialize($args).')';

		return $cacheKey;
	}
}