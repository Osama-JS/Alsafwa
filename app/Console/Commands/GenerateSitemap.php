<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Page;
use App\Models\Service;
use App\Models\Activity;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Generate the sitemap.';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // Static Pages
        $sitemap->add(Url::create(route('home'))->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $sitemap->add(Url::create(route('about'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        $sitemap->add(Url::create(route('services.index'))->setPriority(0.9)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create(route('agencies.index'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create(route('activities.index'))->setPriority(0.8)->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        $sitemap->add(Url::create(route('branches.index'))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        $sitemap->add(Url::create(route('gallery.index'))->setPriority(0.7)->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        $sitemap->add(Url::create(route('contact'))->setPriority(0.5)->setChangeFrequency(Url::CHANGE_FREQUENCY_YEARLY));

        // Dynamic Pages
        Page::where('status', 'published')->each(function (Page $page) use ($sitemap) {
            $sitemap->add(Url::create(route('home') . '/' . $page->slug) // Assuming route structure
                ->setPriority(0.6)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY));
        });

        Service::where('status', 'published')->each(function (Service $service) use ($sitemap) {
            $sitemap->add(Url::create(route('services.show', $service->slug))
                ->setPriority(0.8)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        });

        Activity::where('status', 'published')->each(function (Activity $activity) use ($sitemap) {
            $sitemap->add(Url::create(route('activities.show', $activity->slug))
                ->setPriority(0.7)
                ->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY));
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap generated successfully.');
    }
}
