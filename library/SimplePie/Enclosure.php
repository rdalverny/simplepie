<?php
/**
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
 * 	* Redistributions of source code must retain the above copyright notice, this list of
 * 	  conditions and the following disclaimer.
 *
 * 	* Redistributions in binary form must reproduce the above copyright notice, this list
 * 	  of conditions and the following disclaimer in the documentation and/or other materials
 * 	  provided with the distribution.
 *
 * 	* Neither the name of the SimplePie Team nor the names of its contributors may be used
 * 	  to endorse or promote products derived from this software without specific prior
 * 	  written permission.
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

/**
 * Handles everything related to enclosures (including Media RSS and iTunes RSS)
 *
 * Used by {@see SimplePie_Item::get_enclosure()} and {@see SimplePie_Item::get_enclosures()}
 *
 * This class can be overloaded with {@see SimplePie::set_enclosure_class()}
 *
 * @package SimplePie
 * @subpackage API
 */
class SimplePie_Enclosure
{
	/**
	 * @var string
	 * @see get_bitrate()
	 */
	var $bitrate;

	/**
	 * @var array
	 * @see get_captions()
	 */
	var $captions;

	/**
	 * @var array
	 * @see get_categories()
	 */
	var $categories;

	/**
	 * @var int
	 * @see get_channels()
	 */
	var $channels;

	/**
	 * @var SimplePie_Copyright
	 * @see get_copyright()
	 */
	var $copyright;

	/**
	 * @var array
	 * @see get_credits()
	 */
	var $credits;

	/**
	 * @var string
	 * @see get_description()
	 */
	var $description;

	/**
	 * @var int
	 * @see get_duration()
	 */
	var $duration;

	/**
	 * @var string
	 * @see get_expression()
	 */
	var $expression;

	/**
	 * @var string
	 * @see get_framerate()
	 */
	var $framerate;

	/**
	 * @var string
	 * @see get_handler()
	 */
	var $handler;

	/**
	 * @var array
	 * @see get_hashes()
	 */
	var $hashes;

	/**
	 * @var string
	 * @see get_height()
	 */
	var $height;

	/**
	 * @deprecated
	 * @var null
	 */
	var $javascript;

	/**
	 * @var array
	 * @see get_keywords()
	 */
	var $keywords;

	/**
	 * @var string
	 * @see get_language()
	 */
	var $lang;

	/**
	 * @var string
	 * @see get_length()
	 */
	var $length;

	/**
	 * @var string
	 * @see get_link()
	 */
	var $link;

	/**
	 * @var string
	 * @see get_medium()
	 */
	var $medium;

	/**
	 * @var string
	 * @see get_player()
	 */
	var $player;

	/**
	 * @var array
	 * @see get_ratings()
	 */
	var $ratings;

	/**
	 * @var array
	 * @see get_restrictions()
	 */
	var $restrictions;

	/**
	 * @var string
	 * @see get_sampling_rate()
	 */
	var $samplingrate;

	/**
	 * @var array
	 * @see get_thumbnails()
	 */
	var $thumbnails;

	/**
	 * @var string
	 * @see get_title()
	 */
	var $title;

	/**
	 * @var string
	 * @see get_type()
	 */
	var $type;

	/**
	 * @var string
	 * @see get_width()
	 */
	var $width;

	/**
	 * Constructor, used to input the data
	 *
	 * For documentation on all the parameters, see the corresponding
	 * properties and their accessors
	 *
	 * @uses idna_convert If available, this will convert an IDN
	 */
	public function __construct($link = null, $type = null, $length = null, $javascript = null, $bitrate = null, $captions = null, $categories = null, $channels = null, $copyright = null, $credits = null, $description = null, $duration = null, $expression = null, $framerate = null, $hashes = null, $height = null, $keywords = null, $lang = null, $medium = null, $player = null, $ratings = null, $restrictions = null, $samplingrate = null, $thumbnails = null, $title = null, $width = null)
	{
		$this->bitrate = $bitrate;
		$this->captions = $captions;
		$this->categories = $categories;
		$this->channels = $channels;
		$this->copyright = $copyright;
		$this->credits = $credits;
		$this->description = $description;
		$this->duration = $duration;
		$this->expression = $expression;
		$this->framerate = $framerate;
		$this->hashes = $hashes;
		$this->height = $height;
		$this->keywords = $keywords;
		$this->lang = $lang;
		$this->length = $length;
		$this->link = $link;
		$this->medium = $medium;
		$this->player = $player;
		$this->ratings = $ratings;
		$this->restrictions = $restrictions;
		$this->samplingrate = $samplingrate;
		$this->thumbnails = $thumbnails;
		$this->title = $title;
		$this->type = $type;
		$this->width = $width;

		if (class_exists('idna_convert'))
		{
			$idn = new idna_convert();
			$parsed = SimplePie_Misc::parse_url($link);
			$this->link = SimplePie_Misc::compress_parse_url($parsed['scheme'], $idn->encode($parsed['authority']), $parsed['path'], $parsed['query'], $parsed['fragment']);
		}
		$this->handler = $this->get_handler(); // Needs to load last
	}

	/**
	 * String-ified version
	 *
	 * @return string
	 */
	public function __toString()
	{
		// There is no $this->data here
		return md5(serialize($this));
	}

	/**
	 * Get the bitrate
	 *
	 * @return string|null
	 */
	public function get_bitrate()
	{
		if ($this->bitrate !== null)
		{
			return $this->bitrate;
		}

		return null;
	}

	/**
	 * Get a single caption
	 *
	 * @param int $key
	 * @return SimplePie_Caption|null
	 */
	public function get_caption($key = 0)
	{
		$captions = $this->get_captions();
		if (isset($captions[$key]))
		{
			return $captions[$key];
		}

		return null;
	}

	/**
	 * Get all captions
	 *
	 * @return array|null Array of {@see SimplePie_Caption} objects
	 */
	public function get_captions()
	{
		if ($this->captions !== null)
		{
			return $this->captions;
		}

		return null;
	}

	/**
	 * Get a single category
	 *
	 * @param int $key
	 * @return SimplePie_Category|null
	 */
	public function get_category($key = 0)
	{
		$categories = $this->get_categories();
		if (isset($categories[$key]))
		{
			return $categories[$key];
		}

		return null;
	}

	/**
	 * Get all categories
	 *
	 * @return array|null Array of {@see SimplePie_Category} objects
	 */
	public function get_categories()
	{
		if ($this->categories !== null)
		{
			return $this->categories;
		}

		return null;
	}

	/**
	 * Get the number of audio channels
	 *
	 * @return int|null
	 */
	public function get_channels()
	{
		if ($this->channels !== null)
		{
			return $this->channels;
		}

		return null;
	}

	/**
	 * Get the copyright information
	 *
	 * @return SimplePie_Copyright|null
	 */
	public function get_copyright()
	{
		if ($this->copyright !== null)
		{
			return $this->copyright;
		}

		return null;
	}

	/**
	 * Get a single credit
	 *
	 * @param int $key
	 * @return SimplePie_Credit|null
	 */
	public function get_credit($key = 0)
	{
		$credits = $this->get_credits();
		if (isset($credits[$key]))
		{
			return $credits[$key];
		}

		return null;
	}

	/**
	 * Get all credits
	 *
	 * @return array|null Array of {@see SimplePie_Credit} objects
	 */
	public function get_credits()
	{
		if ($this->credits !== null)
		{
			return $this->credits;
		}

		return null;
	}

	/**
	 * Get the description of the enclosure
	 *
	 * @return string|null
	 */
	public function get_description()
	{
		if ($this->description !== null)
		{
			return $this->description;
		}

		return null;
	}

	/**
	 * Get the duration of the enclosure
	 *
	 * @param bool $convert Convert seconds into hh:mm:ss
	 * @return string|int|null 'hh:mm:ss' string if `$convert` was specified, otherwise integer (or null if none found)
	 */
	public function get_duration($convert = false)
	{
		if ($this->duration !== null)
		{
			if ($convert)
			{
				$time = SimplePie_Misc::time_hms($this->duration);
				return $time;
			}

			return $this->duration;
		}

		return null;
	}

	/**
	 * Get the expression
	 *
	 * @return string Probably one of 'sample', 'full', 'nonstop', 'clip'. Defaults to 'full'
	 */
	public function get_expression()
	{
		if ($this->expression !== null)
		{
			return $this->expression;
		}

		return 'full';
	}

	/**
	 * Get the file extension
	 *
	 * @return string|null
	 */
	public function get_extension()
	{
		if ($this->link !== null)
		{
			$url = SimplePie_Misc::parse_url($this->link);
			if ($url['path'] !== '')
			{
				return pathinfo($url['path'], PATHINFO_EXTENSION);
			}
		}
		return null;
	}

	/**
	 * Get the framerate (in frames-per-second)
	 *
	 * @return string|null
	 */
	public function get_framerate()
	{
		if ($this->framerate !== null)
		{
			return $this->framerate;
		}

		return null;
	}

	/**
	 * Get the preferred handler
	 *
	 * @return string|null One of 'quicktime', 'wmedia', 'html'
	 */
	public function get_handler()
	{
		return $this->get_real_type(true);
	}

	/**
	 * Get a single hash
	 *
	 * @link http://www.rssboard.org/media-rss#media-hash
	 * @param int $key
	 * @return string|null Hash as per `media:hash`, prefixed with "$algo:"
	 */
	public function get_hash($key = 0)
	{
		$hashes = $this->get_hashes();
		if (isset($hashes[$key]))
		{
			return $hashes[$key];
		}

		return null;
	}

	/**
	 * Get all credits
	 *
	 * @return array|null Array of strings, see {@see get_hash()}
	 */
	public function get_hashes()
	{
		if ($this->hashes !== null)
		{
			return $this->hashes;
		}

		return null;
	}

	/**
	 * Get the height
	 *
	 * @return string|null
	 */
	public function get_height()
	{
		if ($this->height !== null)
		{
			return $this->height;
		}

		return null;
	}

	/**
	 * Get the language
	 *
	 * @link http://tools.ietf.org/html/rfc3066
	 * @return string|null Language code as per RFC 3066
	 */
	public function get_language()
	{
		if ($this->lang !== null)
		{
			return $this->lang;
		}

		return null;
	}

	/**
	 * Get a single keyword
	 *
	 * @param int $key
	 * @return string|null
	 */
	public function get_keyword($key = 0)
	{
		$keywords = $this->get_keywords();
		if (isset($keywords[$key]))
		{
			return $keywords[$key];
		}

		return null;
	}

	/**
	 * Get all keywords
	 *
	 * @return array|null Array of strings
	 */
	public function get_keywords()
	{
		if ($this->keywords !== null)
		{
			return $this->keywords;
		}

		return null;
	}

	/**
	 * Get length
	 *
	 * @return float Length in bytes
	 */
	public function get_length()
	{
		if ($this->length !== null)
		{
			return $this->length;
		}

		return null;
	}

	/**
	 * Get the URL
	 *
	 * @return string|null
	 */
	public function get_link()
	{
		if ($this->link !== null)
		{
			return urldecode($this->link);
		}

		return null;
	}

	/**
	 * Get the medium
	 *
	 * @link http://www.rssboard.org/media-rss#media-content
	 * @return string|null Should be one of 'image', 'audio', 'video', 'document', 'executable'
	 */
	public function get_medium()
	{
		if ($this->medium !== null)
		{
			return $this->medium;
		}

		return null;
	}

	/**
	 * Get the player URL
	 *
	 * Typically the same as {@see get_permalink()}
	 * @return string|null Player URL
	 */
	public function get_player()
	{
		if ($this->player !== null)
		{
			return $this->player;
		}

		return null;
	}

	/**
	 * Get a single rating
	 *
	 * @param int $key
	 * @return SimplePie_Rating|null
	 */
	public function get_rating($key = 0)
	{
		$ratings = $this->get_ratings();
		if (isset($ratings[$key]))
		{
			return $ratings[$key];
		}

		return null;
	}

	/**
	 * Get all ratings
	 *
	 * @return array|null Array of {@see SimplePie_Rating} objects
	 */
	public function get_ratings()
	{
		if ($this->ratings !== null)
		{
			return $this->ratings;
		}

		return null;
	}

	/**
	 * Get a single restriction
	 *
	 * @param int $key
	 * @return SimplePie_Restriction|null
	 */
	public function get_restriction($key = 0)
	{
		$restrictions = $this->get_restrictions();
		if (isset($restrictions[$key]))
		{
			return $restrictions[$key];
		}

		return null;
	}

	/**
	 * Get all restrictions
	 *
	 * @return array|null Array of {@see SimplePie_Restriction} objects
	 */
	public function get_restrictions()
	{
		if ($this->restrictions !== null)
		{
			return $this->restrictions;
		}

		return null;
	}

	/**
	 * Get the sampling rate (in kHz)
	 *
	 * @return string|null
	 */
	public function get_sampling_rate()
	{
		if ($this->samplingrate !== null)
		{
			return $this->samplingrate;
		}

		return null;
	}

	/**
	 * Get the file size (in MiB)
	 *
	 * @return float|null File size in mebibytes (1048 bytes)
	 */
	public function get_size()
	{
		$length = $this->get_length();
		if ($length !== null)
		{
			return round($length/1048576, 2);
		}

		return null;
	}

	/**
	 * Get a single thumbnail
	 *
	 * @param int $key
	 * @return string|null Thumbnail URL
	 */
	public function get_thumbnail($key = 0)
	{
		$thumbnails = $this->get_thumbnails();
		if (isset($thumbnails[$key]))
		{
			return $thumbnails[$key];
		}

		return null;
	}

	/**
	 * Get all thumbnails
	 *
	 * @return array|null Array of thumbnail URLs
	 */
	public function get_thumbnails()
	{
		if ($this->thumbnails !== null)
		{
			return $this->thumbnails;
		}

		return null;
	}

	/**
	 * Get the title
	 *
	 * @return string|null
	 */
	public function get_title()
	{
		if ($this->title !== null)
		{
			return $this->title;
		}

		return null;
	}

	/**
	 * Get mimetype of the enclosure
	 *
	 * @see get_real_type()
	 * @return string|null MIME type
	 */
	public function get_type()
	{
		if ($this->type !== null)
		{
			return $this->type;
		}

		return null;
	}

	/**
	 * Get the width
	 *
	 * @return string|null
	 */
	public function get_width()
	{
		if ($this->width !== null)
		{
			return $this->width;
		}

		return null;
	}

	/**
	 * Embed the enclosure using `<embed>`
	 *
	 * @deprecated Use the second parameter to {@see embed} instead
	 *
	 * @param array|string $options See first paramter to {@see embed}
	 * @return string HTML string to output
	 */
	public function native_embed($options='')
	{
		return $this->embed($options, true);
	}

	/**
	 * `$options` is an array or comma-separated key:value string, with the
	 * following properties:
	 *
	 * - `alt` (string): Alternate content for when an end-user does not have
	 *    the appropriate handler installed or when a file type is
	 *    unsupported. Can be any text or HTML. Defaults to blank.
	 * - `altclass` (string): If a file type is unsupported, the end-user will
	 *    see the alt text (above) linked directly to the content. That link
	 *    will have this value as its class name. Defaults to blank.
	 * - `audio` (string): This is an image that should be used as a
	 *    placeholder for audio files before they're loaded (QuickTime-only).
	 *    Can be any relative or absolute URL. Defaults to blank.
	 * - `bgcolor` (string): The background color for the media, if not
	 *    already transparent. Defaults to `#ffffff`.
	 * - `height` (integer): The height of the embedded media. Accepts any
	 *    numeric pixel value (such as `360`) or `auto`. Defaults to `auto`,
	 *    and it is recommended that you use this default.
	 * - `loop` (boolean): Do you want the media to loop when it's done?
	 *    Defaults to `false`.
	 * - `video` (string): This is an image that should be used as a
	 *    placeholder for video files before they're loaded (QuickTime-only).
	 *    Can be any relative or absolute URL. Defaults to blank.
	 * - `width` (integer): The width of the embedded media. Accepts any
	 *    numeric pixel value (such as `480`) or `auto`. Defaults to `auto`,
	 *    and it is recommended that you use this default.
	 * - `widescreen` (boolean): Is the enclosure widescreen or standard?
	 *    This applies only to video enclosures, and will automatically resize
	 *    the content appropriately.  Defaults to `false`, implying 4:3 mode.
	 *
	 * Note: Non-widescreen (4:3) mode with `width` and `height` set to `auto`
	 * will default to 480x360 video resolution.  Widescreen (16:9) mode with
	 * `width` and `height` set to `auto` will default to 480x270 video resolution.
	 *
	 * @todo If the dimensions for media:content are defined, use them when width/height are set to 'auto'.
	 *
	 * @param string|array $options Comma-separated key:value list, or array
	 * @return array
	 */
	public function process_embed_options($options = '')
	{
		$defaults = [
			'audio'    => '',
			'video'    => $this->get_thumbnail(),
			'alt'      => '',
			'altclass' => '',
			'loop'     => 'false',
			'width'    => 'auto',
			'height'   => 'auto',
			'bgcolor'  => '#ffffff',
			'widescreen'  => false,
			'handler'     => $this->get_handler(),
			'type'        => $this->get_real_type(),
			'mime'        => '',
		];

		// Process options and reassign values as necessary
		if (is_array($options))
		{
			$defaults = array_merge($defaults, $options);
		}
		else
		{
			$options = explode(',', $options);
			foreach($options as $option)
			{
				$opt = explode(':', $option, 2);
				if (isset($opt[0], $opt[1]))
				{
					$opt[0] = trim($opt[0]);
					$opt[1] = trim($opt[1]);
					switch ($opt[0])
					{
						case 'audio':
							$defaults['audio'] = $opt[1];
							break;

						case 'video':
							$defaults['video'] = $opt[1];
							break;

						case 'alt':
							$defaults['alt'] = $opt[1];
							break;

						case 'altclass':
							$defaults['altclass'] = $opt[1];
							break;

						case 'loop':
							$defaults['loop'] = $opt[1];
							break;

						case 'width':
							$defaults['width'] = $opt[1];
							break;

						case 'height':
							$defaults['height'] = $opt[1];
							break;

						case 'bgcolor':
							$defaults['bgcolor'] = $opt[1];
							break;

						case 'widescreen':
							$defaults['widescreen'] = $opt[1];
							break;
					}
				}
			}
		}

		//
		$mime = explode('/', $defaults['type'], 2);
		$defaults['mime'] = $mime[0];

		// Process values for 'auto'
		if ($defaults['width'] === 'auto')
		{
			$defaults['width'] = '100%';
			if ($defaults['mime'] === 'video')
			{
				if ($defaults['height'] === 'auto')
				{
					$defaults['width'] = 480;
				}
				elseif ($defaults['widescreen'])
				{
					$defaults['width'] = round((intval($defaults['height']) / 9) * 16);
				}
				else
				{
					$defaults['width'] = round((intval($defaults['height']) / 3) * 4);
				}
			}
		}

		if ($defaults['height'] === 'auto')
		{
			if ($defaults['mime'] === 'audio')
			{
				$defaults['height'] = 0;
			}
			elseif ($defaults['mime'] === 'video')
			{
				if ($defaults['width'] === 'auto')
				{
					$defaults['height'] = $defaults['widescreen'] ? 270 : 360;
				}
				elseif ($defaults['widescreen'])
				{
					$defaults['height'] = round((intval($defaults['width']) / 16) * 9);
				}
				else
				{
					$defaults['height'] = round((intval($defaults['width']) / 4) * 3);
				}
			}
			else
			{
				$defaults['height'] = 376;
			}
		}
		elseif ($defaults['mime'] === 'audio')
		{
			$defaults['height'] = 0;
		}

		// Set proper placeholder value
		if ($defaults['mime'] === 'audio')
		{
			$defaults['placeholder'] = $defaults['audio'];
		}
		elseif ($defaults['mime'] === 'video')
		{
			$defaults['placeholder'] = $defaults['video'];
		}

		return $defaults;
	}

	/**
	 * Embed the enclosure using HTML audio/video/picture elements or Javascript
	 *
	 * @param array|string $options Comma-separated key:value list, or array {@see process_embed_options}
	 * @param bool $native Use `<embed>`
	 * @return string HTML string to output
	 */
	public function embed($options = '', $native = false)
	{
		$options = $this->process_embed_options($options);

		if ($options['handler'] == 'html' &&
			in_array($options['mime'], ['audio', 'video', 'image']))
		{
			return call_user_func_array(
				[ $this, "embed_html_{$options['mime']}" ],
				[
					$this->get_link(),
					$this->get_title(),
					$options
				]
			);
		}

		extract($options);

		$embed = '';

		// QuickTime 7 file types.  Need to test with QuickTime 6.
		if ($handler === 'quicktime')
		{
			$height += 16;
			if ($native)
			{
				if ($placeholder !== '')
				{
					$embed .= "<embed type=\"$type\" style=\"cursor:hand; cursor:pointer;\" href=\"" . $this->get_link() . "\" src=\"$placeholder\" width=\"$width\" height=\"$height\" autoplay=\"false\" target=\"myself\" controller=\"false\" loop=\"$loop\" scale=\"aspect\" bgcolor=\"$bgcolor\" pluginspage=\"http://apple.com/quicktime/download/\"></embed>";
				}
				else
				{
					$embed .= "<embed type=\"$type\" style=\"cursor:hand; cursor:pointer;\" src=\"" . $this->get_link() . "\" width=\"$width\" height=\"$height\" autoplay=\"false\" target=\"myself\" controller=\"true\" loop=\"$loop\" scale=\"aspect\" bgcolor=\"$bgcolor\" pluginspage=\"http://apple.com/quicktime/download/\"></embed>";
				}
			}
			else
			{
				$embed .= "<script type='text/javascript'>embed_quicktime('$type', '$bgcolor', '$width', '$height', '" . $this->get_link() . "', '$placeholder', '$loop');</script>";
			}
		}

		// Windows Media
		elseif ($handler === 'wmedia')
		{
			$height += 45;
			if ($native)
			{
				$embed .= "<embed type=\"application/x-mplayer2\" src=\"" . $this->get_link() . "\" autosize=\"1\" width=\"$width\" height=\"$height\" showcontrols=\"1\" showstatusbar=\"0\" showdisplay=\"0\" autostart=\"0\"></embed>";
			}
			else
			{
				$embed .= "<script type='text/javascript'>embed_wmedia('$width', '$height', '" . $this->get_link() . "');</script>";
			}
		}

		// Everything else
		else $embed .= '<a href="' . $this->get_link() . '" class="' . $altclass . '">' . $alt . '</a>';

		return $embed;
	}

	// QuickTime
	const TYPES_QUICKTIME = array(
		'audio/3gpp', 'audio/3gpp2',
		'audio/aiff', 'audio/x-aiff',
		'audio/mid', 'audio/midi', 'audio/x-midi',
		'audio/m4a', 'audio/x-m4a',
		'video/3gpp', 'video/3gpp2',
		'video/m4v', 'video/x-m4v',
		'video/quicktime',
		'video/sd-video',
	);

	// Windows Media
	const TYPES_WMEDIA = array(
		'application/asx',
		'application/x-mplayer2',
		'audio/x-ms-wma',
		'audio/x-ms-wax',
		'video/x-ms-asf-plugin',
		'video/x-ms-asf',
		'video/x-ms-wm',
		'video/x-ms-wmv',
		'video/x-ms-wvx',
	);

	// HTML5-handled mime types
	const TYPES_HTML = array(
		'image/*',
		'audio/aac', 'audio/x-aac',
		'audio/ogg',
		'audio/wav',
		'audio/x-wav',
		'audio/mp3',
		'audio/x-mp3',
		'audio/mpeg',
		'audio/x-mpeg',
		'audio/mp4',
		'video/ogg',
		'video/webm',
		'video/mp4',
		'video/mpeg',
		'video/x-mpeg',
	);

	//
	const MEDIA_HANDLERS = array(
		'html'      => self::TYPES_HTML,
		'quicktime' => self::TYPES_QUICKTIME,
		'wmedia'    => self::TYPES_WMEDIA,
	);

	//
	const EXTENSIONS_TYPES = array(
		'audio/acc'       => array('aac', 'adts'),
		'audio/aiff'      => array('aif', 'aifc', 'aiff', 'cdda'),
		'audio/midi'      => array('kar', 'mid', 'midi', 'smf'),
		'audio/mp3'       => array('mp3', 'swa'),
		'audio/ms-wax'    => array('wax'),
		'audio/ms-wma'    => array('wma'),
		'audio/ogg'       => array('oga', 'opus'),
		'audio/wav'       => array('bwf', 'wav'),
		'audio/x-m4a'     => array('m4a'),
		'image/*'         => array('jpg', 'jpeg', 'gif', 'bmp', 'png', 'webp'),
		'video/3gpp'      => array('3gp', '3gpp'),
		'video/3gpp2'     => array('3g2', '3gp2'),
		'video/mp4'       => array('mp4', 'mpg4'),
		'video/ogg'       => array('ogg', 'ogv'),
		'video/quicktime' => array('mov', 'qt'),
		'video/sd-video'  => array('sdv'),
		'video/x-m4v'     => array('m4v'),
		'video/x-ms-asf'  => array('asf'),
		'video/x-ms-wm'   => array('wm'),
		'video/x-ms-wmv'  => array('wmv'),
		'video/x-ms-wvx'  => array('wvx'),
		'video/mpeg'      => array('m1s', 'm1v', 'm15', 'm75',
								   'mp2', 'mpa', 'mpeg', 'mpg',
								   'mpm', 'mpv'),
		'video/webm'      => array('webm'),
	);

	/**
	 * Get the real media type
	 *
	 * Often, feeds lie to us, necessitating a bit of deeper inspection. This
	 * converts types to their canonical representations based on the file
	 * extension
	 *
	 * @see get_type()
	 * @param bool $find_handler Internal use only, use {@see get_handler()} instead
	 * @return string MIME type
	 */
	public function get_real_type($find_handler = false)
	{
		$type = null;
		if ($this->get_type() !== null)
		{
			$type = strtolower($this->type);
		}

		// If we encounter an unsupported mime-type, check the file extension and guess intelligently.
		if (!in_array($type, array_values(self::MEDIA_HANDLERS)))
		{
			$type = $this->get_type_from_extension($this->get_extension());
		}

		if ($find_handler)
		{
			return $this->get_handler_from_type($type);
		}

		return $type;
	}

	/**
	 * @param string|null $extension
	 * @return string|null
	 */
	public function get_type_from_extension($extension)
	{
		if ($extension === null) {
			return null;
		}

		$extension = strtolower($extension);
		foreach (self::EXTENSIONS_TYPES as $type => $extensions) {
			if (in_array($extension, $extensions)) {
				return $type;
			}
		}

		return null;
	}

	/**
	 * @param string $type
	 * @return string|null
	 */
	public function get_handler_from_type($type)
	{
		foreach (self::MEDIA_HANDLERS as $handler => $types) {
			if (in_array($type, $types)) {
				return $handler;
			}
		}

		return null;
	}

	/**
	 * Embed audio with native HTML5 <audio> element
	 *
	 * @param string $link url to media
	 * @param string $title
	 * @param array $options
	 * @return string
	 */
	public function embed_html_audio($link, $title, $options)
	{
		if (empty($title)) {
			$title = explode('/', $link);
			$title = end($title);
		}

		return <<<HTML
<figure>
	<audio controls
		   preload="none"
		   loop="{$options['loop']}"
		   title="{$title}">
		<source type="{$options['type']}" src="{$link}" />
		<p>Your browser does not support HTML5 audio. Here is a <a href="{$link}">link to the audio</a> instead.</p>
	</audio>
	<figcaption><a href="{$link}">{$title}</a></figcaption>
</figure>
HTML;
	}

	/**
	 * @param string $link url to video
	 * @param string $title
	 * @param array $options
	 * @return string
	 */
	public function embed_html_video($link, $title, $options)
	{
		if (empty($title)) {
			$title = explode('/', $link);
			$title = end($title);
		}

		return <<<HTML
<figure>
	<video controls
	       preload="none"
		   poster="{$options['video']}"
		   loop="{$options['loop']}"
		   title="{$title}"
		   aria-label="{$title}"
		   style="width: 100%; height: auto;">
		<source type="{$options['type']}" src="{$link}" />
		<a href="{$link}"><img src="{$options['video']}"
						       style="width: 100%; height: auto;"
						       alt="Your browser does not support HTML5 video. Click here to get directly to the video instead." /></a>
	</video>
	<figcaption><a href="{$link}">{$title}</a></figcaption>
</figure>
HTML;
	}

	/**
	 * @param string $link url to image
	 * @param string $title
	 * @param array $options
	 * @return string
	 */
	public function embed_html_image($link, $title, $options)
	{
		if (empty($title)) {
			$title = explode('/', $link);
			$title = end($title);
		}

		return <<<HTML
<figure>
	<picture>
		<img src="{$link}"
			 alt=""
			 title="{$title}"
			 style="width: 100%; height: auto;" />
	</picture>
	<figcaption><a href="{$link}">{$title}</a></figcaption>
</figure>
HTML;
	}
}
