<?php

namespace App\Libraries\Elasticsearch;

trait Installer
{

    protected $indices = [
        'sands_dev_kb' => [
            'category' => [
                'type' => 'string',
                'analyzer' => 'keyword',
            ],
            'title' => [
                'type' => 'string',
            ],
            'contents' => [
                'type' => 'string',
            ],
            'tags' => [
                'type' => 'string',
                'analyzer' => 'keyword',
            ],
        ],
    ];

    protected function createIndexes()
    {
        $this->info('Creating Indices');

        foreach ($this->indices as $index => $properties) {
            if (!$this->elasticsearch->indices()->exists(['index' => $index])) {
                $this->elasticsearch->indices()->create(['index' => $index]);
            }
        }

        $this->info('Indices Created');
    }

    protected function updateIndexSettings()
    {
        $this->info('Mapping');

        foreach ($this->indices as $index => $properties) {
            $this->elasticsearch->indices()->putMapping([
                'index' => $index,
                'type' => 'docs',
                'body' => [
                    'docs' => [
                        '_timestamp' => [
                            'enabled' => true,
                        ],
                        'properties' => $properties,
                    ],
                ],
            ]);
        }

        $this->info('Mapping Done');
    }

    protected function runInstaller()
    {
        $this->elasticsearch = app('elasticsearch');
        $this->createIndexes();
        $this->updateIndexSettings();
    }

}
