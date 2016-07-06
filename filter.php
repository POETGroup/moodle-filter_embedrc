<?php
// This file is part of Moodle-oembed-Filter
//
// Moodle-oembed-Filter is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle-oembed-Filter is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle-oembed-Filter.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Filter for component 'filter_embedrc'
 *
 * @package   filter_embedrc
 * @copyright Erich M. Wappis / Guy Thomas 2016
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * code based on the following filter
 * oEmbed filter ( Mike Churchward, James McQuillan, Vinayak (Vin) Bhalerao, Josh Gavant and Rob Dolin)
 */

defined('MOODLE_INTERNAL') || die();

use filter_embedrc\service\oembed;

require_once($CFG->libdir.'/filelib.php');
/**
 * This text filter allows the user to embed content from many external contents providers.
 * The filter is using oEmbed for grabbing the external content.
 *
 * @package    filter_embedrc
 */
class filter_embedrc extends moodle_text_filter {

    /**
     * content gets filtered, links either wrapped in an <a> tag or in a <div> tag with class="oembed"
     * will be replaced by embeded content
     *
     * @param $text HTML to be processed.
     * @param $options
     * @return string String containing processed HTML.
     */
    public function filter($text, array $options = array()) {

        $targettag = get_config('filter_embedrc', 'targettag');

        if ($targettag == 'atag' && stripos($text, '</a>') === false) {
            // Performance shortcut - all regexes below end with the </a> tag.
            // If not present nothing can match.
            return $text;
        }

        $filtered = $text; // We need to return the original value if regex fails!
        if (get_config('filter_embedrc', 'targettag') == 'divtag') {
            $search = '/(?<=(<div class="oembed">))(.*)(?=<\/div>)/';
            $filtered = preg_replace_callback($search, function ($match) {
                $instance = oembed::get_instance();
                return $instance->html_output($match[0]);
            }, $filtered);
        }

        if (get_config('filter_embedrc', 'targettag') == 'atag') {
            $search = '/<a\s[^>]*href="(.*?)"(.*?)>(.*?)<\/a>/';
            $filtered = preg_replace_callback($search, function ($match) {
                $instance = oembed::get_instance();
                $result = $instance->html_output($match[1]);
                if (empty($result)) {
                    $result = $match[0];
                }
                return $result

            }, $filtered);
        }

        if (empty($filtered)) {
            // if $filtered is emtpy return original $text           
            return $text;
        }

        return $filtered;
    }
}
