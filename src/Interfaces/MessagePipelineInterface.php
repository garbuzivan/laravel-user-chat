<?php

namespace Garbuzivan\LaravelUserChat\Interfaces;

use Closure;
use Garbuzivan\LaravelUserChat\Pipeline\MessagePipeline;

interface MessagePipelineInterface
{
    public function handle(MessagePipeline $data, Closure $next): MessagePipeline;
}
