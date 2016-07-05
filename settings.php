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
 * @copyright 2012 Matthew Cannings, Sandwell College; modified 2015 by Microsoft, Inc.
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * code based on the following filters...
 * Screencast (Mark Schall)
 * Soundcloud (Troy Williams)
 */

defined('MOODLE_INTERNAL') || die;

require_once(__DIR__.'/filter.php');
require_once($CFG->libdir.'/formslib.php');

if ($ADMIN->fulltree) {
    $targettags = [
        'a'  =>  get_string('atag'),
        'div'=>  get_string('divtag'),
    ];
    
    $cachelifespan =[
        '0' =>  get_string('cachelifespan_disabled', 'filter_embedrc'),
        '1' =>  get_string('cachelifespan_daily', 'filter_embedrc'),
        '2' =>  get_string('cachelifespan_weekly', 'filter_embedrc')
    ];
    
    $torf = [
        '1' => get_string('yes'),
        '0' => get_string('no')
    ];
    
    $config = get_config('filter_embedrc');
    $item = new admin_setting_configselect('filter_embedrc/cachelifespan', get_string('cachelifespan', 'filter_embedrc'), get_string('cachelifespan_dec', 'filter_embedrc'),'1', $cachelifespan);
    $settings->add($item);
    
    $item = new admin_setting_configselect('filter_embedrc/targettag', get_string('targettag', 'filter_embedrc'),  get_string('targettag_desc', 'filter_embedrc'),'atag', ['atag' => 'atag','divtag'=>'divtag']);
    $settings->add($item);
    
    $item = new admin_setting_configselect('filter_embedrc/providers_restrict', get_string('providers_restrict', 'filter_embedrc'), get_string('providers_restrict_desc', 'filter_embedrc'), 0, $torf);
    $settings->add($item);
    
    $targettag = get_config('filter_embedrc', 'targettag');
    if ($config->providers_restrict == 1) {
        $providers = json_decode($config->providers_cached, true);
        foreach ($providers as $provider) {
            $providers_allowed_default[$provider['provider_name']] = $provider['provider_name'];
        }
        $item = new admin_setting_configmulticheckbox('filter_embedrc/providers_allowed', get_string('providers_allowed', 'filter_embedrc'), get_string('providers_allowed_desc', 'filter_embedrc'), implode(',', array_values($providers_allowed_default)), $providers_allowed_default);
        $settings->add($item);
    }
}