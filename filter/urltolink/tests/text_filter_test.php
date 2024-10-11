<?php
// This file is part of agpu - http://agpu.org/
//
// agpu is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// agpu is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with agpu.  If not, see <http://www.gnu.org/licenses/>.

namespace filter_urltolink;

/**
 * Unit test for the text_filter
 *
 * @package    filter_urltolink
 * @category   test
 * @copyright  2010 David Mudrak <david@agpu.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @covers \filter_urltolink\text_filter
 */
final class text_filter_test extends \basic_testcase {
    /**
     * Data provider for test_convert_urls_into_links.
     *
     * @return array
     */
    public static function get_convert_urls_into_links_test_cases(): array {
        // Create a 4095 and 4096 long URLs.
        $superlong4095 = str_pad('http://www.superlong4095.com?this=something', 4095, 'a');
        $superlong4096 = str_pad('http://www.superlong4096.com?this=something', 4096, 'a');

        // phpcs:disable agpu.Files.LineLength.MaxExceeded, agpu.Files.LineLength.TooLong
        $texts = [
            // Just a url.
            'http://agpu.org - URL' => '<a href="http://agpu.org" class="_blanktarget">http://agpu.org</a> - URL',
            'www.agpu.org - URL' => '<a href="http://www.agpu.org" class="_blanktarget">www.agpu.org</a> - URL',
            // Url with params.
            'URL: http://agpu.org/s/i=1&j=2' => 'URL: <a href="http://agpu.org/s/i=1&j=2" class="_blanktarget">http://agpu.org/s/i=1&j=2</a>',
            // Url with escaped params.
            'URL: www.agpu.org/s/i=1&amp;j=2' => 'URL: <a href="http://www.agpu.org/s/i=1&amp;j=2" class="_blanktarget">www.agpu.org/s/i=1&amp;j=2</a>',
            // Https url with params.
            'URL: https://agpu.org/s/i=1&j=2' => 'URL: <a href="https://agpu.org/s/i=1&j=2" class="_blanktarget">https://agpu.org/s/i=1&j=2</a>',
            // Url with port and params.
            'URL: http://agpu.org:8080/s/i=1' => 'URL: <a href="http://agpu.org:8080/s/i=1" class="_blanktarget">http://agpu.org:8080/s/i=1</a>',
            // URL with complex fragment.
            'Most voted issues: https://tracker.agpu.org/browse/MDL#selectedTab=com.atlassian.jira.plugin.system.project%3Apopularissues-panel' => 'Most voted issues: <a href="https://tracker.agpu.org/browse/MDL#selectedTab=com.atlassian.jira.plugin.system.project%3Apopularissues-panel" class="_blanktarget">https://tracker.agpu.org/browse/MDL#selectedTab=com.atlassian.jira.plugin.system.project%3Apopularissues-panel</a>',
            // Domain with more parts.
            'URL: www.bbc.co.uk.' => 'URL: <a href="http://www.bbc.co.uk" class="_blanktarget">www.bbc.co.uk</a>.',
            // URL in brackets.
            '(http://agpu.org) - URL' => '(<a href="http://agpu.org" class="_blanktarget">http://agpu.org</a>) - URL',
            '(www.agpu.org) - URL' => '(<a href="http://www.agpu.org" class="_blanktarget">www.agpu.org</a>) - URL',
            // URL in brackets with a path.
            '(http://example.com/index.html) - URL' => '(<a href="http://example.com/index.html" class="_blanktarget">http://example.com/index.html</a>) - URL',
            '(www.example.com/index.html) - URL' => '(<a href="http://www.example.com/index.html" class="_blanktarget">www.example.com/index.html</a>) - URL',
            // URL in brackets with anchor.
            '(http://agpu.org/main#anchor) - URL' => '(<a href="http://agpu.org/main#anchor" class="_blanktarget">http://agpu.org/main#anchor</a>) - URL',
            '(www.agpu.org/main#anchor) - URL' => '(<a href="http://www.agpu.org/main#anchor" class="_blanktarget">www.agpu.org/main#anchor</a>) - URL',
            // URL in square brackets.
            '[http://agpu.org] - URL' => '[<a href="http://agpu.org" class="_blanktarget">http://agpu.org</a>] - URL',
            '[www.agpu.org] - URL' => '[<a href="http://www.agpu.org" class="_blanktarget">www.agpu.org</a>] - URL',
            // URL in square brackets with a path.
            '[http://example.com/index.html] - URL' => '[<a href="http://example.com/index.html" class="_blanktarget">http://example.com/index.html</a>] - URL',
            '[www.example.com/index.html] - URL' => '[<a href="http://www.example.com/index.html" class="_blanktarget">www.example.com/index.html</a>] - URL',
            // URL in square brackets with anchor.
            '[http://agpu.org/main#anchor] - URL' => '[<a href="http://agpu.org/main#anchor" class="_blanktarget">http://agpu.org/main#anchor</a>] - URL',
            '[www.agpu.org/main#anchor] - URL' => '[<a href="http://www.agpu.org/main#anchor" class="_blanktarget">www.agpu.org/main#anchor</a>] - URL',
            // Brackets within the url.
            'URL: http://cc.org/url_(withpar)_go/?i=2' => 'URL: <a href="http://cc.org/url_(withpar)_go/?i=2" class="_blanktarget">http://cc.org/url_(withpar)_go/?i=2</a>',
            'URL: www.cc.org/url_(withpar)_go/?i=2' => 'URL: <a href="http://www.cc.org/url_(withpar)_go/?i=2" class="_blanktarget">www.cc.org/url_(withpar)_go/?i=2</a>',
            'URL: http://cc.org/url_(with)_(par)_go/?i=2' => 'URL: <a href="http://cc.org/url_(with)_(par)_go/?i=2" class="_blanktarget">http://cc.org/url_(with)_(par)_go/?i=2</a>',
            'URL: www.cc.org/url_(with)_(par)_go/?i=2' => 'URL: <a href="http://www.cc.org/url_(with)_(par)_go/?i=2" class="_blanktarget">www.cc.org/url_(with)_(par)_go/?i=2</a>',
            'http://en.wikipedia.org/wiki/%28#Parentheses_.28_.29 - URL' => '<a href="http://en.wikipedia.org/wiki/%28#Parentheses_.28_.29" class="_blanktarget">http://en.wikipedia.org/wiki/%28#Parentheses_.28_.29</a> - URL',
            'http://en.wikipedia.org/wiki/(#Parentheses_.28_.29 - URL' => '<a href="http://en.wikipedia.org/wiki/(#Parentheses_.28_.29" class="_blanktarget">http://en.wikipedia.org/wiki/(#Parentheses_.28_.29</a> - URL',
            // Escaped brackets in url.
            'http://en.wikipedia.org/wiki/Slash_%28punctuation%29' => '<a href="http://en.wikipedia.org/wiki/Slash_%28punctuation%29" class="_blanktarget">http://en.wikipedia.org/wiki/Slash_%28punctuation%29</a>',
            // Anchor tag.
            'URL: <a href="http://agpu.org">http://agpu.org</a>' => 'URL: <a href="http://agpu.org">http://agpu.org</a>',
            'URL: <a href="http://agpu.org">www.agpu.org</a>' => 'URL: <a href="http://agpu.org">www.agpu.org</a>',
            'URL: <a href="http://agpu.org"> http://agpu.org</a>' => 'URL: <a href="http://agpu.org"> http://agpu.org</a>',
            'URL: <a href="http://agpu.org"> www.agpu.org</a>' => 'URL: <a href="http://agpu.org"> www.agpu.org</a>',
            // Trailing fullstop.
            'URL: http://agpu.org/s/i=1&j=2.' => 'URL: <a href="http://agpu.org/s/i=1&j=2" class="_blanktarget">http://agpu.org/s/i=1&j=2</a>.',
            'URL: www.agpu.org/s/i=1&amp;j=2.' => 'URL: <a href="http://www.agpu.org/s/i=1&amp;j=2" class="_blanktarget">www.agpu.org/s/i=1&amp;j=2</a>.',
            // Trailing unmatched bracket.
            'URL: http://agpu.org)<br />' => 'URL: <a href="http://agpu.org" class="_blanktarget">http://agpu.org</a>)<br />',
            // Partially escaped html.
            'URL: <p>text www.agpu.org&lt;/p> text' => 'URL: <p>text <a href="http://www.agpu.org" class="_blanktarget">www.agpu.org</a>&lt;/p> text',
            // Decimal url parameter.
            'URL: www.agpu.org?u=1.23' => 'URL: <a href="http://www.agpu.org?u=1.23" class="_blanktarget">www.agpu.org?u=1.23</a>',
            // Escaped space in url.
            'URL: www.agpu.org?u=test+param&' => 'URL: <a href="http://www.agpu.org?u=test+param&" class="_blanktarget">www.agpu.org?u=test+param&</a>',
            // Multiple urls.
            'URL: http://agpu.org www.agpu.org'
            => 'URL: <a href="http://agpu.org" class="_blanktarget">http://agpu.org</a> <a href="http://www.agpu.org" class="_blanktarget">www.agpu.org</a>',
            // Containing anchor tags including a class parameter and a url to convert.
            'URL: <a href="http://agpu.org">http://agpu.org</a> www.agpu.org <a class="customclass" href="http://agpu.org">http://agpu.org</a>'
            => 'URL: <a href="http://agpu.org">http://agpu.org</a> <a href="http://www.agpu.org" class="_blanktarget">www.agpu.org</a> <a class="customclass" href="http://agpu.org">http://agpu.org</a>',
            // Subdomain.
            'http://subdomain.agpu.org - URL' => '<a href="http://subdomain.agpu.org" class="_blanktarget">http://subdomain.agpu.org</a> - URL',
            // Multiple subdomains.
            'http://subdomain.subdomain.agpu.org - URL' => '<a href="http://subdomain.subdomain.agpu.org" class="_blanktarget">http://subdomain.subdomain.agpu.org</a> - URL',
            // Looks almost like a link but isnt.
            'This contains http, http:// and www but no actual links.' => 'This contains http, http:// and www but no actual links.',
            // No link at all.
            'This is a story about agpu.coming to a cinema near you.' => 'This is a story about agpu.coming to a cinema near you.',
            // URLs containing utf 8 characters.
            'http://Iñtërnâtiônàlizætiøn.com?ô=nëø' => '<a href="http://Iñtërnâtiônàlizætiøn.com?ô=nëø" class="_blanktarget">http://Iñtërnâtiônàlizætiøn.com?ô=nëø</a>',
            'www.Iñtërnâtiônàlizætiøn.com?ô=nëø' => '<a href="http://www.Iñtërnâtiônàlizætiøn.com?ô=nëø" class="_blanktarget">www.Iñtërnâtiônàlizætiøn.com?ô=nëø</a>',
            // Text containing utf 8 characters outside of a url.
            'Iñtërnâtiônàlizætiøn is important to http://agpu.org' => 'Iñtërnâtiônàlizætiøn is important to <a href="http://agpu.org" class="_blanktarget">http://agpu.org</a>',
            // Too hard to identify without additional regexs.
            'agpu.org' => 'agpu.org',
            // Some text with no link between related html tags.
            '<b>no link here</b>' => '<b>no link here</b>',
            // Some text with a link between related html tags.
            '<b>a link here www.agpu.org</b>' => '<b>a link here <a href="http://www.agpu.org" class="_blanktarget">www.agpu.org</a></b>',
            // Some text containing a link within unrelated tags.
            '<br />This is some text. www.agpu.com then some more text<br />' => '<br />This is some text. <a href="http://www.agpu.com" class="_blanktarget">www.agpu.com</a> then some more text<br />',
            // Check we aren't modifying img tags.
            'image<img src="http://agpu.org/logo/logo-240x60.gif" />' => 'image<img src="http://agpu.org/logo/logo-240x60.gif" />',
            'image<img src="www.agpu.org/logo/logo-240x60.gif" />'    => 'image<img src="www.agpu.org/logo/logo-240x60.gif" />',
            'image<img src="http://www.example.com/logo.gif" />'        => 'image<img src="http://www.example.com/logo.gif" />',
            // And another url within one tag.
            '<td background="http://agpu.org">&nbsp;</td>' => '<td background="http://agpu.org">&nbsp;</td>',
            '<td background="www.agpu.org">&nbsp;</td>' => '<td background="www.agpu.org">&nbsp;</td>',
            '<form name="input" action="http://agpu.org/submit.asp" method="get">' => '<form name="input" action="http://agpu.org/submit.asp" method="get">',
            '<input type="submit" value="Go to http://agpu.org">' => '<input type="submit" value="Go to http://agpu.org">',
            '<td background="https://www.agpu.org">&nbsp;</td>' => '<td background="https://www.agpu.org">&nbsp;</td>',
            // CSS URLs.
            '<table style="background-image: url(\'http://agpu.org/pic.jpg\');">' => '<table style="background-image: url(\'http://agpu.org/pic.jpg\');">',
            '<table style="background-image: url(http://agpu.org/pic.jpg);">' => '<table style="background-image: url(http://agpu.org/pic.jpg);">',
            '<table style="background-image: url("http://agpu.org/pic.jpg");">' => '<table style="background-image: url("http://agpu.org/pic.jpg");">',
            '<table style="background-image: url( http://agpu.org/pic.jpg );">' => '<table style="background-image: url( http://agpu.org/pic.jpg );">',
            // Partially escaped img tag.
            'partially escaped img tag &lt;img src="http://agpu.org/logo/logo-240x60.gif" />' => 'partially escaped img tag &lt;img src="http://agpu.org/logo/logo-240x60.gif" />',
            // Double http with www.
            'One more link like http://www.agpu.org to test' => 'One more link like <a href="http://www.agpu.org" class="_blanktarget">http://www.agpu.org</a> to test',
            // Encoded URLs in the path.
            'URL: http://127.0.0.1/one%28parenthesis%29/path?param=value' => 'URL: <a href="http://127.0.0.1/one%28parenthesis%29/path?param=value" class="_blanktarget">http://127.0.0.1/one%28parenthesis%29/path?param=value</a>',
            'URL: www.localhost.com/one%28parenthesis%29/path?param=value' => 'URL: <a href="http://www.localhost.com/one%28parenthesis%29/path?param=value" class="_blanktarget">www.localhost.com/one%28parenthesis%29/path?param=value</a>',
            // Encoded URLs in the query.
            'URL: http://127.0.0.1/path/to?param=value_with%28parenthesis%29&param2=1' => 'URL: <a href="http://127.0.0.1/path/to?param=value_with%28parenthesis%29&param2=1" class="_blanktarget">http://127.0.0.1/path/to?param=value_with%28parenthesis%29&param2=1</a>',
            'URL: www.localhost.com/path/to?param=value_with%28parenthesis%29&param2=1' => 'URL: <a href="http://www.localhost.com/path/to?param=value_with%28parenthesis%29&param2=1" class="_blanktarget">www.localhost.com/path/to?param=value_with%28parenthesis%29&param2=1</a>',
            // Test URL less than 4096 characters in size is converted to link.
            'URL: ' . $superlong4095 => 'URL: <a href="' . $superlong4095 . '" class="_blanktarget">' . $superlong4095 . '</a>',
            // Test URL equal to or greater than 4096 characters in size is not converted to link.
            'URL: ' . $superlong4096 => 'URL: ' . $superlong4096,
            // Testing URL within a span tag.
            'URL: <span style="kasd"> my link to http://google.com </span>' => 'URL: <span style="kasd"> my link to <a href="http://google.com" class="_blanktarget">http://google.com</a> </span>',
            // Nested tags test.
            '<b><i>www.google.com</i></b>' => '<b><i><a href="http://www.google.com" class="_blanktarget">www.google.com</a></i></b>',
            // Test realistic content.
            '<p><span style="color: rgb(37, 37, 37); font-family: sans-serif; line-height: 22.3999996185303px;">Lorem ipsum amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut http://google.com aliquip ex ea <a href="http://google.com">commodo consequat</a>. Duis aute irure in reprehenderit in excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing mollit anim id est laborum.</span><br></p>'
            =>
            '<p><span style="color: rgb(37, 37, 37); font-family: sans-serif; line-height: 22.3999996185303px;">Lorem ipsum amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut <a href="http://google.com" class="_blanktarget">http://google.com</a> aliquip ex ea <a href="http://google.com">commodo consequat</a>. Duis aute irure in reprehenderit in excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia <a href="https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing" class="_blanktarget">https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing</a> <a href="https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing" class="_blanktarget">https://docs.google.com/document/d/BrokenLinkPleaseAyacDHc_Ov8aoskoSVQsfmLHP_jYAkRMk/edit?usp=sharing</a> mollit anim id est laborum.</span><br></p>',
            // Test some broken html.
            '5 < 10 www.google.com <a href="hi.com">im a link</a>' => '5 < 10 <a href="http://www.google.com" class="_blanktarget">www.google.com</a> <a href="hi.com">im a link</a>',
            'h3 (www.styles.com/h3) < h1 (www.styles.com/h1)' => 'h3 (<a href="http://www.styles.com/h3" class="_blanktarget">www.styles.com/h3</a>) < h1 (<a href="http://www.styles.com/h1" class="_blanktarget">www.styles.com/h1</a>)',
            '<p>text www.agpu.org&lt;/p> text' => '<p>text <a href="http://www.agpu.org" class="_blanktarget">www.agpu.org</a>&lt;/p> text',
            // Some more urls.
            '<link rel="search" type="application/opensearchdescription+xml" href="/osd.jsp" title="Peer review - agpu Tracker"/>' => '<link rel="search" type="application/opensearchdescription+xml" href="/osd.jsp" title="Peer review - agpu Tracker"/>',
            '<a href="https://agpudev.io"></a><span>www.google.com</span><span class="placeholder"></span>' =>
                '<a href="https://agpudev.io"></a><span><a href="http://www.google.com" class="_blanktarget">www.google.com</a>' .
                '</span><span class="placeholder"></span>',
            'http://nolandforzombies.com <a href="zombiesFTW.com">Zombies FTW</a> http://aliens.org' => '<a href="http://nolandforzombies.com" class="_blanktarget">http://nolandforzombies.com</a> <a href="zombiesFTW.com">Zombies FTW</a> <a href="http://aliens.org" class="_blanktarget">http://aliens.org</a>',
            // Test 'nolink' class.
            'URL: <span class="nolink">http://agpu.org</span>' => 'URL: <span class="nolink">http://agpu.org</span>',
            '<span class="nolink">URL: http://agpu.org</span>' => '<span class="nolink">URL: http://agpu.org</span>',
        ];

        // phpcs:enable

        $data = [];
        foreach ($texts as $text => $correctresult) {
            $data[] = [$text, $correctresult];
        }
        return $data;
    }

    /**
     * Test the convert_urls_into_links method.
     *
     * @dataProvider get_convert_urls_into_links_test_cases
     * @param string $text
     * @param string $correctresult
     */
    public function test_convert_urls_into_links($text, $correctresult): void {
        $testablefilter = $this->get_testable_text_filter();

        $testablefilter->convert_urls_into_links($text);
        $this->assertEquals($correctresult, $text);
    }

    /**
     * Get a copy of the filter configured for testing.
     *
     * @param array ...$args
     * @return \filter_urltolink\text_filter
     */
    protected function get_testable_text_filter(...$args): text_filter {
        return new class extends text_filter {
            // phpcs:ignore agpu.Commenting.MissingDocblock.MissingTestcaseMethodDescription
            public function __construct() {
            }
            // phpcs:ignore agpu.Commenting.MissingDocblock.MissingTestcaseMethodDescription, Generic.CodeAnalysis.UselessOverridingMethod.Found
            public function convert_urls_into_links(&$text) {
                parent::convert_urls_into_links($text);
            }
        };
    }
}
