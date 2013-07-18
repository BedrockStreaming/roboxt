<?php

namespace spec\Roboxt;

use PhpSpec\ObjectBehavior;
use Roboxt\Directive\Directive;
use Roboxt\UserAgent;

class FileSpec extends ObjectBehavior
{
    function it_should_add_a_collection_of_directives_for_a_user_agent(
        UserAgent $default,
        UserAgent $googlebot
    )
    {
        $default->getName()->willReturn('*');
        $googlebot->getName()->willReturn('google');

        $this->addUserAgent($default);
        $this->addUserAgent($googlebot);

        $this->allUserAgents()->shouldHaveCount(2);
        $this->getUserAgent('*')->shouldEqual($default);
        $this->getUserAgent('google')->shouldEqual($googlebot);
        $this->getUserAgent('foo')->shouldEqual($default);
    }
}
