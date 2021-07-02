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

/**
 * Library of workshop module functions needed by Moodle core and other subsystems
 *
 * All the functions neeeded by Moodle core, gradebook, file subsystem etc
 * are placed here.
 *
 * @package    mod_youtubeapi
 * @copyright  2021 Juan Burgos <juanbsanchez1988@gmail.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();
require_once($CFG->dirroot . '/course/lib.php');
require_once($CFG->dirroot . '/grade/lib.php');
require_once($CFG->dirroot . '/grade/querylib.php');

function youtubeapiplaylist_add_instance(stdClass $youtubeapiplaylist) {
    global $DB;

    $youtubeapiplaylist->id = $DB->insert_record('youtubeapiplaylist', $youtubeapiplaylist);
    return $youtubeapiplaylist->id;

}

function youtubeapiplaylist_update_instance(stdClass $youtubeapiplaylist, mod_youtubeapiplaylist_mod_form $mform = null) {
    global $DB, $USER;
    if (empty($youtubeapiplaylist->enforcedefaults)) {
        $youtubeapiplaylist->enforcedefaults = 0;
    }

    // We never change the mode once set.
    unset($youtubeapiplaylist->mode);

    $youtubeapiplaylist->timemodified = time();
    $youtubeapiplaylist->id = $youtubeapiplaylist->instance;

    $result = $DB->update_record('youtubeapiplaylist', $youtubeapiplaylist);


    return $result;
}

/**
 * Delete youtubeapiplaylist instance.
 * @param int $id
 * @return bool true
 */
function youtubeapiplaylist_delete_instance($id) {
    global $DB;

    if (! $youtubeapiplaylist = $DB->get_record('youtubeapiplaylist', array('id' => $id))) {
        return false;
    }

    $DB->delete_records('youtubeapiplaylist', array('id'=>$youtubeapiplaylist->id));

    return true;
}

function youtube_api_extend_navigtaion_course($navigation, $course, $url){
  $url = new moodle_url('/mod/youtubeapiplaylist/index.php');
  $youtubeapinode = navigation_node::create('Youtube Api Playlist', $url, navigation_node::TYPE_CUSTOM, 'YT Api', 'ytapi');
  $navigation->add_node($youtubeapinode);
}