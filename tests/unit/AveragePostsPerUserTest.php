<?php

declare(strict_types = 1);

namespace Tests\unit;

use PHPUnit\Framework\TestCase;
use SocialPost\Hydrator\FictionalPostHydrator;
use Statistics\Builder\ParamsBuilder;
use Statistics\Calculator\AveragePostCountByUser;

/**
 * Class ATestTest
 *
 * @package Tests\unit
 */
class AveragePostsPerUserTest extends TestCase
{
    /**
     * @test
     */
    public function testAveragePostsPerUser(): void
    {
        $calculator = new AveragePostCountByUser();
        $params = ParamsBuilder::reportStatsParams(new \DateTime('2018-08-10'));
        $calculator->setParameters($params[3]);
        $hydrator = new FictionalPostHydrator();
        $response = json_decode(file_get_contents(__DIR__ . '/../data/social-posts-response.json'), true);

        foreach ($response['data']['posts'] as $postData) {
            $calculator->accumulateData($hydrator->hydrate($postData));
        }

        $result = $calculator->calculate();


        $this->assertEquals(1, $result->getValue());
    }
}
