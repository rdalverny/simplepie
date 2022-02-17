<?php
/**
 * Tests for SimplePie_Enclosure
 *
 * SimplePie
 *
 * A PHP-Based RSS and Atom Feed Framework.
 * Takes the hard work out of managing a complete RSS/Atom solution.
 *
 * Copyright (c) 2004-2016, Ryan Parman, Sam Sneddon, Ryan McCue, and contributors
 * All rights reserved.
 *
 * Redistribution and use in source and binary forms, with or without modification, are
 * permitted provided that the following conditions are met:
 *
 *  * Redistributions of source code must retain the above copyright notice, this list of
 *    conditions and the following disclaimer.
 *
 *  * Redistributions in binary form must reproduce the above copyright notice, this list
 *    of conditions and the following disclaimer in the documentation and/or other materials
 *    provided with the distribution.
 *
 *  * Neither the name of the SimplePie Team nor the names of its contributors may be used
 *    to endorse or promote products derived from this software without specific prior
 *    written permission.
 *
 * THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS
 * OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY
 * AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT HOLDERS
 * AND CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR
 * CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR
 * SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY
 * THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR
 * OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE
 * POSSIBILITY OF SUCH DAMAGE.
 *
 * @package SimplePie
 * @copyright 2004-2016 Ryan Parman, Sam Sneddon, Ryan McCue
 * @author Ryan Parman
 * @author Sam Sneddon
 * @author Ryan McCue
 * @link http://simplepie.org/ SimplePie
 * @license http://www.opensource.org/licenses/bsd-license.php BSD License
 */

require_once dirname(__FILE__) . '/bootstrap.php';

class EnclosureTest extends PHPUnit\Framework\TestCase
{
    /**
     * Run a test using a sprintf template and data
     *
     * @param string $template 
     */
    protected function buildFeedFromTemplate(string $template, array $data)
    {
        if (!is_array($data))
        {
            $data = array($data);
        }
        $xml = vsprintf($template, $data);
        $feed = new SimplePie();
        $feed->set_raw_data($xml);
        $feed->enable_cache(false);
        $feed->init();

        return $feed;
    }

    /**
     * Facilitates comparing HTML outputs
     */
    function tidyHTML(string $html) : string
    {
        $config = [
            'show-body-only' => true,
            'output-html' => true,
            'indent' => true,
            'indent-attributes' => true,
            'sort-attributes' => true,
            'wrap' => 100,

        ];
        $tidy = new Tidy();
        $tidy->parseString($html, $config, 'utf8');
        $tidy->cleanRepair();
        return $tidy->html();
    }

    public function feedEnclosureProvider()
    {
        return [
            'audio mp3 enclosure' => [
                '<rss version="2.0"><channel><item>
                    <description>test description</description>
                    <enclosure type="audio/mpeg" url="http://example.com/audio.mp3"/>
                </item></channel></rss>',
                '<figure>
                    <audio controls=""
                            loop="false"
                            preload="none"
                            title="audio.mp3">
                        <source src="http://example.com/audio.mp3" type="audio/mp3">
                        <p>Your browser does not support HTML5 audio.
                            Here is a <a href="http://example.com/audio.mp3">link to the audio</a> instead.
                        </p>
                    </audio>
                    <figcaption>
                      <a href="http://example.com/audio.mp3">audio.mp3</a>
                    </figcaption>
                </figure>'
            ],
            'audio ogg enclosure' => [
                '<rss version="2.0"><channel><item>
                    <description>test description</description>
                    <enclosure type="audio/ogg" url="http://example.com/audio.oga"/>
                </item></channel></rss>',
                '<figure>
                    <audio controls=""
                            loop="false"
                            preload="none"
                            title="audio.oga">
                        <source src="http://example.com/audio.oga" type="audio/ogg">
                        <p>Your browser does not support HTML5 audio.
                            Here is a <a href="http://example.com/audio.oga">link to the audio</a> instead.
                        </p>
                    </audio>
                    <figcaption>
                      <a href="http://example.com/audio.oga">audio.oga</a>
                    </figcaption>
                </figure>'
            ],
            'audio midi enclosure' => [
                '<rss version="2.0"><channel><item>
                    <description>test description</description>
                    <enclosure url="http://example.com/piece.mid"/>
                </item></channel></rss>',
                '<embed autoplay="false"
                        bgcolor="#FFFFFF"
                        controller="true"
                        height="16"
                        loop="false"
                        pluginspage="http://apple.com/quicktime/download/"
                        scale="aspect"
                        src="http://example.com/piece.mid"
                        style="cursor:hand; cursor:pointer;"
                        target="myself"
                        type="audio/midi"
                        width="100%">'     
            ],
            'video webm enclosure' => [
                '<rss version="2.0"><channel><item>
                    <description>test description</description>
                    <enclosure type="video/webm" url="http://example.com/video.webm"/>
                </item></channel></rss>',
                '<figure>
                    <video controls=""
                            aria-label="video.webm"
                            loop="false"
                            poster=""
                            preload="none"
                            style="width: 100%; height: auto;"
                            title="video.webm">
                        <source src="http://example.com/video.webm" type="video/webm">
                        <a href="http://example.com/video.webm">
                            <img alt="Your browser does not support HTML5 video. Click here to get directly to  the video instead."
                                src=""
                                style="width: 100%; height: auto;">
                        </a>
                    </video>
                    <figcaption>
                        <a href="http://example.com/video.webm">video.webm</a>
                    </figcaption>
                </figure>'
            ],
            'video mp4 enclosure with media element' => [
                '<rss version="2.0" xmlns:media="http://search.yahoo.com/mrss/"><channel><item>
                    <description>test description</description>
                    <media:content url="http://example.com/movie.mp4">
                        <media:thumbnail url="http://example.com/poster.jpg" width="75" height="50" />
                    </media:content>
                </item></channel></rss>',
                '<figure>
                    <video controls=""
                            aria-label="movie.mp4"
                            loop="false"
                            poster="http://example.com/poster.jpg"
                            preload="none"
                            style="width: 100%; height: auto;"
                            title="movie.mp4">
                        <source src="http://example.com/movie.mp4" type="video/mp4">
                        <a href="http://example.com/movie.mp4">
                            <img alt="Your browser does not support HTML5 video. Click here to get directly to the video instead."
                                src="http://example.com/poster.jpg"
                                style="width: 100%; height: auto;"></a>
                    </video>
                    <figcaption>
                      <a href="http://example.com/movie.mp4">movie.mp4</a>
                    </figcaption>
                </figure>'
            ],
            'video wmv enclosure' => [
                '<rss version="2.0"><channel><item>
                    <description>test description</description>
                    <enclosure url="http://example.com/video.wmv"/>
                </item></channel></rss>',
                '<embed autosize="1"
                        autostart="0"
                        height="405"
                        showcontrols="1"
                        showdisplay="0"
                        showstatusbar="0"
                        src="http://example.com/video.wmv"
                        type="application/x-mplayer2"
                        width="480">'
            ],
            'image enclosure' => [
                '<rss version="2.0"><channel><item>
                    <description>test description</description>
                    <enclosure type="image/jpg" url="image.jpeg"/>
                </item></channel></rss>',
                '<figure>
                    <picture>
                        <img src="image.jpeg"
                            alt=""
                            title="image.jpeg"
                            style="width: 100%; height: auto;" />
                    </picture>
                    <figcaption><a href="image.jpeg">image.jpeg</a></figcaption>
                </figure>'
            ],
        ];
    }

    /**
     * @dataProvider feedEnclosureProvider
     */
    public function testEmbedEnclosure($given, $expected)
    {
        $feed = $this->buildFeedFromTemplate($given, []);
        $item = $feed->get_item();
        $this->assertSame('test description', $item->get_content());

        $enc = $item->get_enclosure();
        $this->assertEquals($this->tidyHTML($expected), $this->tidyHTML($enc->embed([], true)));
    }

}

