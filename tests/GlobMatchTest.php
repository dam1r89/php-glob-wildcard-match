<?php

use PHPUnit\Framework\TestCase;
use dam1r89\GlobMatch\GlobMatch;

class GlobMatchTest extends TestCase
{
    public function testSimplePatterns()
    {
        $glob = new GlobMatch();
        $this->assertTrue($glob->match('pizza *', 'pizza something'));
        $this->assertFalse($glob->match('pizza', 'pizza something'));
    }

    public function testEscapingRegExpChars()
    {
        $glob = new GlobMatch();
        $this->assertTrue($glob->match('p/izza *', 'p/izza something'));
        $this->assertTrue($glob->match('p[izza *', 'p[izza something'));
        $this->assertTrue($glob->match('piz.za *', 'piz.za something'));
        $this->assertTrue($glob->match('p/i[z.za *', 'p/i[z.za something'));
    }

    public function testAbusingConstants()
    {
        $glob = new GlobMatch();
        $this->assertTrue($glob->match('p/izza __MATCH_PLACEHOLDER_0__', 'p/izza __MATCH_PLACEHOLDER_0__'));
        $this->assertTrue($glob->match('p/izza *', 'p/izza __MATCH_PLACEHOLDER_0__'));
        $this->assertTrue($glob->match('p/izza __MATCH_PLACEHOLDER_1__', 'p/izza __MATCH_PLACEHOLDER_1__'));
    }

    public function testGettingResults()
    {
        $glob = new GlobMatch();
        $this->assertTrue($glob->match('pizza *', 'pizza something'));
    }

    public function testWildcardInMiddle()
    {
        $glob = new GlobMatch();
        $this->assertTrue($glob->match('pizza * is awesome', 'pizza with chease is awesome'));
        $this->assertFalse($glob->match('pizza * is awesome', 'pizza with meat is not awesome'));

        $this->assertTrue($glob->match('pizza ? is awesome', 'pizza 1 is awesome'));
        $this->assertFalse($glob->match('pizza ? is awesome', 'pizza 2 is not awesome'));

        $this->assertTrue($glob->match('pizza * is * awesome', 'pizza with hings is really awesome'));
        $this->assertFalse($glob->match('pizza * is *', 'pizza with hings isn\'t really something'));

        $this->assertTrue($glob->match('pizza * is awesome', 'pizza with cheese is awesome'));
        $this->assertFalse($glob->match('pizza * is awesome', 'pizza with cheese is not awesome'));

    }
}