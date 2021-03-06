<?php

use Behat\Behat\Event\ScenarioEvent;

/*
 * This file is part of the Behat\Mink.
 * (c) Konstantin Kudryashov <ever.zet@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

$hooks->beforeScenario('', function($event) {
    $scenario       = $event instanceof ScenarioEvent ? $event->getScenario() : $event->getOutline();
    $environment    = $event->getEnvironment();

    $driver = $environment->getDefaultDriverName();
    foreach ($scenario->getTags() as $tag) {
        if ('javascript' === $tag) {
            $driver = $environment->getJavascriptDriverName();
        } elseif (preg_match('/^mink\:([^\n]+)/', $tag, $matches)) {
            $driver = $matches[1];
        }
    }

    $environment->getMink()->switchToDriver($driver);
    $environment->getMink()->resetDriver();
});
