<?php

namespace Roboxt;

use PhpCollection\Sequence;

/**
 * Class File abstract a robots.txt file.
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class File
{
    /**
     * Default User-Agent name
     *
     * @var string
     */
    private $default = "*";

    /**
     * @var string
     */
    private $content;

    /**
     * @var Sequence
     */
    private $userAgents;

    /**
     * @param $content
     */
    public function __construct($content = null)
    {
        $this->content = $content;
    }

    /**
     * @return string
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Return registered user agents.
     *
     * @return array
     */
    public function allUserAgents()
    {
        return $this->userAgents;
    }

    /**
     * @param UserAgent $userAgent
     */
    public function addUserAgent(UserAgent $userAgent)
    {
        $this->userAgents[$userAgent->getName()] = $userAgent;
    }

    /**
     * @param  $name
     * @return UserAgent
     */
    public function getUserAgent($name)
    {
        if (!isset($this->userAgents[$name])) {
            return $this->userAgents[$this->default];
        }

        return $this->userAgents[$name];
    }
}
