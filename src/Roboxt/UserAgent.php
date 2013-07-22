<?php

namespace Roboxt;

use PhpCollection\Sequence;
use Roboxt\Directive\Directive;

/**
 * Class UserAgent
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class UserAgent
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var Sequence
     */
    private $directives;

    /**
     * @param string   $name
     * @param Sequence $directives
     */
    public function __construct($name, Sequence $directives)
    {
        $this->name = $name;
        $this->directives = $directives;
    }

    /**
     * @return Sequence
     */
    public function allDirectives()
    {
        return $this->directives;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param Directive $directive
     */
    public function addDirective(Directive $directive)
    {
        $this->directives->add($directive);
    }

    /**
     * Check if a url is allowed to be indexed by the bot.
     *
     * @param $url
     * @return bool
     */
    public function isUrlAllowed($url)
    {
        // By default an url is allowed to any bot.
        $indexable = true;

        foreach ($this->directives as $directive) {
            if ($directive->match($url)) {
                if ($directive->isAllow()) {
                    return true;
                } elseif ($directive->isDisallow()) {
                    $indexable = false;
                }
            }
        }

        return $indexable;
    }
}
