<?php

namespace Terabin\Sitemap\Listener;

use DirectoryIterator;
use Illuminate\Contracts\Events\Dispatcher;
use Flarum\Event\DiscussionWasStarted;
use Flarum\Core\Discussion;
use Flarum\Core\User;
use samdark\sitemap\Sitemap;
use samdark\sitemap\Index;
use Sijad\Pages\Page;
use Flarum\Tags\Tag;

class GenerateSitemap
{
    public function subscribe(Dispatcher $events)
    {
      $events->listen(DiscussionWasStarted::class, function (DiscussionWasStarted $event) {
        $this->UpdateSitemap();
      });
    }

    /**
     * Generate a new sitemap.
     */
    public function UpdateSitemap()
    {
      // create sitemap
      $sitemap = new Sitemap(__DIR__ . '/../../../../../sitemap.xml');

      // Get all discussions
      $discussions = Discussion::all();

      // Get all discussions
      $users = User::all();


      //Add home
      $sitemap->addItem('http://' . $_SERVER['HTTP_HOST'], time(), Sitemap::DAILY, 0.9);

      //Add users
      foreach ($users as $user)
      {
         $sitemap->addItem('http://' . $_SERVER['HTTP_HOST'] . '/u/' . $user->username, time(), Sitemap::DAILY, 0.5);
      }

      //Get all tags
      if (class_exists('Tag')){
        $tags = Tag::all();

        //Add tags
        foreach ($tags as $tag)
        {
           $sitemap->addItem('http://' . $_SERVER['HTTP_HOST'] . '/t/' . $tag->slug, time(), Sitemap::DAILY, 0.9);
        }
      }

      //Get all pages
      if (class_exists('Page')){
        $pages = Page::all();

        //Add pages
        foreach ($pages as $page)
        {
           $sitemap->addItem('http://' . $_SERVER['HTTP_HOST'] . '/p/' . $page->id . '-' . $page->slug, time(), Sitemap::DAILY, 0.5);
        }
      }

      // Add discussions
      foreach ($discussions as $discussion)
      {
         $sitemap->addItem('http://' . $_SERVER['HTTP_HOST'] . '/d/' . $discussion->id . '-' . $discussion->slug, strtotime($discussion->last_time), Sitemap::DAILY, 0.7);
      }

      // Write
      $sitemap->write();
    }
}
