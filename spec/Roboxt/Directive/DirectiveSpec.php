<?php

namespace spec\Roboxt\Directive;

use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class DirectiveSpec extends ObjectBehavior
{
    function it_should_return_line_name_and_value()
    {
        $this->beConstructedWith('name', 'value');
        $this->getName()->shouldEqual('name');
        $this->getValue()->shouldEqual('value');
    }

    function it_should_be_a_disallow_directive()
    {
        $this->beConstructedWith('Disallow', '/foo');
        $this->isDisallow()->shouldBe(true);
    }

    function it_should_be_an_allow_directive()
    {
        $this->beConstructedWith('Allow', '/foo');
        $this->isAllow()->shouldBe(true);
    }

    function it_should_check_if_a_user_is_matched()
    {
        $this->beConstructedWith('Disallow', '/*/foo');

        $this->match('/foo/bar')->shouldReturn(false);
        $this->match('/bar/foo')->shouldReturn(true);
        $this->match('/*?')->shouldReturn(false);
    }
}
