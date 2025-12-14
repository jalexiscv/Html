<?php

namespace App\Libraries\Sitemaps;

use App\Libraries\Sitemaps\Factory;

class Test extends TestCase
{

    public function testSchemaResults()
    {
        $schema = Factory::schema('organization')
            ->url('https://example.com')
            ->logo('https://example.com/logo.png')
            ->contactPoint
            ->telephone('+1-000-555-1212')
            ->contactType('customer service');

        $data = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'url' => 'https://example.com',
            'logo' => 'https://example.com/logo.png',
            'contactPoint' =>
                [
                    '@type' => 'ContactPoint',
                    'telephone' => '+1-000-555-1212',
                    'contactType' => 'customer service'
                ]
        ];

        $this->assertEquals($data, $schema->getRoot()->toArray());

        $this->assertEquals($data, Factory::schema('organization', $data)->toArray());
    }

}
