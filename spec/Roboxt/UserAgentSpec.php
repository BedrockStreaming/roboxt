<?php

namespace spec\Roboxt;

use PhpCollection\Sequence;
use PhpSpec\Exception\Example\PendingException;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Roboxt\Directive\Directive;

class UserAgentSpec extends ObjectBehavior
{
    function it_should_return_directives(Sequence $directives)
    {
        $this->beConstructedWith('googlebot', $directives);
        $this->getName()->shouldEqual('googlebot');
        $this->allDirectives()->shouldEqual($directives);

        $directives->add(Argument::type('Roboxt\Directive\Directive'))->shouldBeCalled();
        $this->addDirective(new Directive('Allow', 'foo'));
    }

    function it_should_check_that_an_url_is_indexable()
    {
        $url = "/forum";

        $directives = new Sequence();
        $directives->add(new Directive('Disallow', '/forumold/'));

        $this->beConstructedWith('foo', $directives);
        $this->isIndexable($url)->shouldReturn(true);
    }

    function it_should_check_that_an_url_is_not_indexable()
    {
        $url = "/forumold/bar";

        $directives = new Sequence();
        $directives->add(new Directive('Disallow', '/forumold/'));

        $this->beConstructedWith('foo', $directives);
        $this->isIndexable($url)->shouldReturn(false);
    }

    function it_should_check_that_an_url_is_indexable_event_with_a_disallow_directive()
    {
        $url = "/bar/foo";

        $directives = new Sequence();
        $directives->add(new Directive('Disallow', '/bar'));
        $directives->add(new Directive('Allow', '/bar/foo'));

        $this->beConstructedWith('GoolgeBot', $directives);
        $this->isIndexable($url)->shouldReturn(true);
    }
}
