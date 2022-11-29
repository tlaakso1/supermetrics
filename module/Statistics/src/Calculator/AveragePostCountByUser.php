<?php

namespace Statistics\Calculator;

use SocialPost\Dto\SocialPostTo;
use Statistics\Dto\StatisticsTo;

/**
 * Class Calculator
 *
 * @package Statistics\Calculator
 */
class AveragePostCountByUser extends AbstractCalculator
{

    protected const UNITS = 'posts';

    /**
     * @var array
     */
    private $userIds = [];

    /**
     * @var int
     */
    private $postCount = 0;

    /**
     * @param SocialPostTo $postTo
     */
    protected function doAccumulate(SocialPostTo $postTo): void
    {
        $this->postCount++;
        if(!in_array($postTo->getAuthorId(), $this->userIds)) {
            $this->userIds[] = $postTo->getAuthorId();
        }
    }

    /**
     * @return StatisticsTo
     */
    protected function doCalculate(): StatisticsTo
    {
        $value = $this->postCount / count($this->userIds);

        return (new StatisticsTo())->setValue(round($value,2));
    }
}
