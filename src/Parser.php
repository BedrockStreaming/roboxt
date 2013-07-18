<?php

namespace Roboxt;

use PhpCollection\Sequence;
use Roboxt\Directive\Directive;

/**
 * Class Parser
 *
 * @author Benjamin Grandfond <benjaming@theodo.fr>
 */
class Parser
{
    /**
     * Reads robots.txt file
     *
     * @param  string $filePath
     * @return string
     */
    public function read($filePath)
    {
        return file_get_contents($filePath);
    }

    /**
     * Parses a robots.txt file.
     * The end result is a multidimensional array.
     * Each time the parser finds a "User-Agent" directive,
     * we create a new group of directives starting by this one.
     *
     * @param  string   $filePath
     * @return Sequence
     */
    public function parse($filePath)
    {
        $file  = new File($this->read($filePath));
        $lines = explode("\n", $file->getContent());

        foreach ($lines as $content) {
            // Skip empty lines
            if (empty($content)) {
                continue;
            }

            list($name, $value) = explode(':', $content);
            $directive = new Directive($name, trim($value));

            // If the directive's name is "User-Agent" then register a UserAgent in the file
            if (!isset($userAgent) || $directive->isUserAgent()) {
                $userAgent = new UserAgent($directive->getValue(), new Sequence());
                $file->addUserAgent($userAgent);
            } else {
                $userAgent->addDirective($directive);
            }
        }

        return $file;
    }
}
