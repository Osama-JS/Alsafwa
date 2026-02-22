<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Page;
use App\Models\Service;
use App\Models\Activity;
use App\Models\Agency;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q');
        $results = [];

        if ($query) {
            $locale = app()->getLocale();

            // Search in Pages
            $pages = Page::where('status', 'published')
                ->where(function($q) use ($query, $locale) {
                    $q->where('title_' . $locale, 'like', "%{$query}%")
                      ->orWhere('content_' . $locale, 'like', "%{$query}%");
                })->get();

            foreach ($pages as $page) {
                $results[] = [
                    'title' => $page->{'title_' . $locale},
                    'description' => \Str::limit(strip_tags($page->{'content_' . $locale}), 150),
                    'url' => route('home') . '/' . $page->slug, // Assuming generic page route structure or specific page routes
                    'type' => __('صفحة')
                ];
            }

            // Search in Services
            $services = Service::where('status', 'published')
                ->where(function($q) use ($query, $locale) {
                    $q->where('title_' . $locale, 'like', "%{$query}%")
                      ->orWhere('description_' . $locale, 'like', "%{$query}%");
                })->get();

            foreach ($services as $service) {
                $results[] = [
                    'title' => $service->{'title_' . $locale},
                    'description' => \Str::limit(strip_tags($service->{'description_' . $locale}), 150),
                    'url' => route('services.show', $service->slug),
                    'type' => __('خدمة')
                ];
            }

            // Search in Activities
            $activities = Activity::where('status', 'published')
                ->where(function($q) use ($query, $locale) {
                    $q->where('title_' . $locale, 'like', "%{$query}%")
                      ->orWhere('description_' . $locale, 'like', "%{$query}%");
                })->get();

            foreach ($activities as $activity) {
                $results[] = [
                    'title' => $activity->{'title_' . $locale},
                    'description' => \Str::limit(strip_tags($activity->{'description_' . $locale}), 150),
                    'url' => route('activities.show', $activity->slug),
                    'type' => __('نشاط')
                ];
            }

             // Search in Agencies
            $agencies = Agency::where('status', 'published')
                ->where(function($q) use ($query, $locale) {
                    $q->where('name_' . $locale, 'like', "%{$query}%")
                      ->orWhere('description_' . $locale, 'like', "%{$query}%");
                })->get();

            foreach ($agencies as $agency) {
                $results[] = [
                    'title' => $agency->{'name_' . $locale},
                    'description' => \Str::limit(strip_tags($agency->{'description_' . $locale}), 150),
                    'url' => route('agencies.index'), // Link to index as individual agency show page might not exist
                    'type' => __('وكالة')
                ];
            }
        }

        return view('frontend.search.index', compact('results', 'query'));
    }
}
