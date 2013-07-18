<?php

namespace Roboxt\Directive;

/**
 * Class Directive
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class Directive
{
    const USER_AGENT = "User-Agent";
    const DISALLOW   = "Disallow";
    const ALLOW      = "Allow";

    /**
     * @var string $name
     */
    private $name;

    /**
     * @var string $value
     */
    private $value;

    /**
     * @param $name
     * @param $value
     */
    public function __construct($name, $value)
    {
        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @return bool
     */
    public function isUserAgent()
    {
        return false !== stripos($this->name, self::USER_AGENT);
    }

    /**
     * @return bool
     */
    public function isDisallow()
    {
        return false !== stripos($this->name, self::DISALLOW);
    }

    /**
     * @return bool
     */
    public function isAllow()
    {
        return 0 == stripos($this->name, self::ALLOW);
    }

    /**
     * Check that a url matches the directive's pattern.
     *
     * @param  $url
     * @return bool
     */
    public function match($url)
    {
        return 1 == preg_match($this->preparePattern($this->getValue()), $url);
    }

    /**
     * Transform the value to a valid regex pattern.
     *
     * @param  $pattern
     * @return string
     */
    private function preparePattern($pattern)
    {
        /**
         * Transforms "/ to "\/" and ".*" to "*"
         * to easily reverse transform "*" to ".*"
         */
        $pattern = str_replace(['/', '.*', '?', '+'], ['\/', '*', '\?', '\+'], $pattern);
        $pattern = str_replace('*', '.*', $pattern);

        return "@".$pattern."@";
    }
}
