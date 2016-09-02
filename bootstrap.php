<?php

use Terabin\Sitemap\Listener;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Event\DiscussionWasStarted;

return function (Dispatcher $events) {
//  return "a";
    $events->subscribe(Listener\GenerateSitemap::class);
    //$events->listen(DiscussionWasStarted::class, function (DiscussionWasStarted $event) {
      //echo("VSF");
    // do stuff before a post is saved
    //});
};
