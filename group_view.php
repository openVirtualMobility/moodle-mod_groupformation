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
 * Prints a particular instance of groupformation
 *
 * @package     mod_groupformation
 * @author      Eduard Gallwas, Johannes Konert, Rene Roepke, Nora Wester, Ahmed Zukic
 * @copyright   2015 MoodlePeers
 * @license     http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */
require_once('../../config.php');
require('header.php');

require_once($CFG->dirroot . '/mod/groupformation/classes/controller/group_controller.php');
require_once($CFG->dirroot . '/mod/groupformation/classes/view_controller/group_view_controller.php');

$filename = substr(__FILE__, strrpos(__FILE__, '\\') + 1);
$url = new moodle_url('/mod/groupformation/' . $filename, $urlparams);

// Set PAGE config.
$PAGE->set_url($url);
$PAGE->set_title(format_string($groupformation->name));
$PAGE->set_heading(format_string($course->fullname));

if (has_capability('mod/groupformation:editsettings', $context)) {
    $returnurl = new moodle_url('/mod/groupformation/analysis_view.php', array('id' => $id, 'do_show' => 'analysis'));
    redirect($returnurl);
} else {
    $currenttab = $doshow;
}

// Import jQuery and js file.
groupformation_add_jquery($PAGE, 'survey_functions.js');

echo $OUTPUT->header();

// Print the tabs.
require('tabs.php');

$userid = $USER->id;
if ($store->is_archived()) {
    echo '<div class="alert" id="commited_view">' . get_string('archived_activity_answers', 'groupformation') . '</div>';
} else {
    $controller = new mod_groupformation_group_controller($groupformation->id);
    $viewcontroller = new mod_groupformation_group_view_controller($groupformation->id, $controller);
    echo $viewcontroller->render();
}
echo $OUTPUT->footer();
