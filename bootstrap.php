<?php

use Terabin\Sitemap\Listener;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Event\DiscussionWasStarted;

return function (Dispatcher $events) {
    $events->subscribe(Listener\GenerateSitemap::class);
};
