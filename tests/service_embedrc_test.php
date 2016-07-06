<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

use filter_embedrc\service\oembed;

defined('MOODLE_INTERNAL') || die();

class testable_oembed extends oembed {
    public function get_providers() {
        return $this->providers;
    }
    public function protected_get_cached_providers($ignorelifespan = false) {
        return $this->get_cached_providers($ignorelifespan = false);
    }
    public function protected_get_sites() {
        return $this->get_sites();
    }
    /**
     * Singleton
     *
     * @return oembed
     */
    public static function get_instance() {
        /** @var $instance oembed */
        static $instance;
        if ($instance) {
            return $instance;
        } else {
            return new testable_oembed();
        }
    }
}
/**
 * Tests for course_service.php
 *
 * @package   filter_embedrc
 * @author    gthomas2
 * @copyright Copyright (c) 2016 Guy Thomas
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
class filter_embedrc_service_oembed_testcase extends advanced_testcase {

    public function test_instance() {
        $this->resetAfterTest(true);
        $this->setAdminUser();
        $oembed = testable_oembed::get_instance();
        $this->assertNotEmpty($oembed);
    }
    public function assert_providers_ok($providers) {
        $this->assertNotEmpty($providers);
        $provider = reset($providers);
        $this->assertNotEmpty($provider['provider_name']);
        $this->assertNotEmpty($provider['provider_url']);
        $this->assertNotEmpty($provider['endpoints']);
    }
    public function test_sites() {
        $this->resetAfterTest(true);
        $this->setAdminUser();
        $oembed = testable_oembed::get_instance();
        $sites = $oembed->protected_get_sites();
        $this->assertNotEmpty($sites);
        $site = reset($sites);
        $this->assertNotEmpty($site['provider_name']);
        $this->assertNotEmpty($site['regex']);
        $this->assertNotEmpty($site['endpoint']);
    }
    public function test_providers() {
        $this->resetAfterTest(true);
        $this->setAdminUser();
        $oembed = testable_oembed::get_instance();
        $providers = $oembed->get_providers();
        $this->assert_providers_ok($providers);
    }
    public function test_get_cached_providers() {
        $this->resetAfterTest(true);
        $this->setAdminUser();
        $oembed = testable_oembed::get_instance();
        $providers = $oembed->protected_get_cached_providers();
        $this->assert_providers_ok($providers);
    }
    public function test_html() {
        $this->resetAfterTest(true);
        $this->setAdminUser();
        $oembed = testable_oembed::get_instance();
        $text = $oembed->html_output('https://www.youtube.com/watch?v=Dsws8T9_cEE');
        $expectedtext = '<iframe width="480" height="270"' .
            ' src="https://www.youtube.com/embed/Dsws8T9_cEE?feature=oembed"' .
            ' frameborder="0" allowfullscreen></iframe>';
        $this->assertEquals($expectedtext, $text);
    }
}



