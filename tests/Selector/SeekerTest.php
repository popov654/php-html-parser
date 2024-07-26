<?php

declare(strict_types=1);

use PHPHtmlParser\Dom\Node\HtmlNode;
use PHPHtmlParser\DTO\Selector\RuleDTO;
use PHPHtmlParser\Selector\Seeker;
use PHPUnit\Framework\TestCase;

class SeekerTest extends TestCase
{
    public function testSeekReturnEmptyArray()
    {
        $ruleDTO = RuleDTO::makeFromPrimitives(
            'tag',
            '=',
            null,
            null,
            false,
            false
        );
        $seeker = new Seeker();
        $results = $seeker->seek([], $ruleDTO, []);
        $this->assertCount(0, $results);
    }

    public function testSeekNthChild()
    {
        $ruleDTO = RuleDTO::makeFromPrimitives(
            '*',
            '=',
            1,
            null,
            false,
            false
        );

        $test = new HtmlNode('div');
        $p1 = new HtmlNode('p');
        $div = new HtmlNode('div');
        $p2 = new HtmlNode('p');
        $test->addChild($p1);
        $test->addChild($div);
        $test->addChild($p2);

        $seeker = new Seeker();

        $results = $seeker->seek([$test], $ruleDTO, []);
        $this->assertCount(1, $results);
        $this->assertEquals('p', $results[0]->getTag()->name());

        $ruleDTO = RuleDTO::makeFromPrimitives(
            '*',
            '=',
            -1,
            null,
            false,
            false
        );

        $results = $seeker->seek([$test], $ruleDTO, []);
        $this->assertCount(1, $results);
        $this->assertEquals('p', $results[0]->getTag()->name());
    }
}
