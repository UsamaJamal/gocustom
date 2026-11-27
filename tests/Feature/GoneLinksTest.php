<?php

namespace Tests\Feature;

use Tests\TestCase;

class GoneLinksTest extends TestCase
{
    /**
     * Test that all spam and deprecated prize links return 410 Gone.
     */
    public function test_prize_links_return_410_gone()
    {
        $links = [
            '/delivery-information.php?prize/2582478',
            '/delivery-information.php',
            '/prize/16834912',
            '/prize/7676867',
            '/prize/8665112',
            '/prize/19026201',
            '/prize',
        ];

        foreach ($links as $link) {
            $response = $this->get($link);
            $response->assertStatus(410);
        }
    }

    /**
     * Test that normal pages still work properly.
     */
    public function test_homepage_still_loads()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Test that www.gocustomboxes.com redirects 301 to non-www https://gocustomboxes.com.
     */
    public function test_www_redirects_to_non_www()
    {
        // Homepage
        $response = $this->get('https://www.gocustomboxes.com/');
        $response->assertStatus(301);
        $response->assertRedirect('https://gocustomboxes.com/');

        // Inner page with trailing slash
        $response = $this->get('https://www.gocustomboxes.com/about-us/');
        $response->assertStatus(301);
        $response->assertRedirect('https://gocustomboxes.com/about-us/');

        // Inner page without trailing slash
        $response = $this->get('https://www.gocustomboxes.com/about-us');
        $response->assertStatus(301);
        $response->assertRedirect('https://gocustomboxes.com/about-us/');

        // URL with query string
        $response = $this->get('https://www.gocustomboxes.com/search?q=box');
        $response->assertStatus(301);
        $response->assertRedirect('https://gocustomboxes.com/search/?q=box');
    }
}
