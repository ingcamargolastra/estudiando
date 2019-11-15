<?php

namespace App\Providers;

use Elasticsearch\Client;
use Elasticsearch\ClientBuilder;
use Illuminate\Support\ServiceProvider;

use App\Articles\ArticlesRepository;
use App\Articles\ElasticsearchRepository;
use App\Articles\EloquentRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

        $this->app->bind(ArticlesRepository::class, function ($app) {
            if (! config('services.search.enabled')) {
                return new EloquentRepository();
            }
            return new ElasticsearchRepository(
                $app->make(Client::class)
            );
        });
        $this->bindSearchClient();
    }

    private function bindSearchClient()
    {
        $this->app->bind(Client::class, function ($app) {
            return ClientBuilder::create()
                ->setHosts($app['config']->get('services.search.hosts'))
                ->build();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
