<?php

namespace spec\Roboxt;

use PhpSpec\ObjectBehavior;
use Roboxt\Directive\Directive;
use Roboxt\File;
use Roboxt\UserAgent;

class FileSpec extends ObjectBehavior
{
    function it_should_add_a_collection_of_directives_for_a_user_agent(
        UserAgent $default,
        UserAgent $googlebot
    )
    {
        $default->getName()->willReturn(File::DEFAULT_UA_NAME);
        $googlebot->getName()->willReturn('google');

        $this->addUserAgent($default);
        $this->addUserAgent($googlebot);

        $this->allUserAgents()->shouldHaveCount(2);
        $this->getUserAgent('*')->shouldEqual($default);
        $this->getUserAgent('google')->shouldEqual($googlebot);
        $this->getUserAgent('foo')->shouldEqual($default);
    }

    function it_should_fallback_on_the_default_user_agent_if_the_url_is_indexable_with_a_specific_user_agent(
        UserAgent $default,
        UserAgent $googlebot
    )
    {
        $default->getName()->willReturn(File::DEFAULT_UA_NAME);
        $googlebot->getName()->willReturn('google');

        $this->addUserAgent($default);
        $this->addUserAgent($googlebot);

        $googlebot->isUrlAllowed('/foo')->shouldBeCalled()->willReturn(true);
        $default->isUrlAllowed('/foo')->shouldBeCalled()->willReturn(true);
        $this->isUrlAllowedByUserAgent('/foo', 'google')->shouldReturn(true);

        $googlebot->isUrlAllowed('/bar')->shouldBeCalled()->willReturn(false);
        $this->isUrlAllowedByUserAgent('/bar', 'google')->shouldReturn(false);

        $googlebot->isUrlAllowed('/baz')->shouldBeCalled()->willReturn(true);
        $default->isUrlAllowed('/baz')->shouldBeCalled()->willReturn(false);
        $this->isUrlAllowedByUserAgent('/baz', 'google')->shouldReturn(false);
    }
}
