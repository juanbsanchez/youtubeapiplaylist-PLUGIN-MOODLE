<?php

require_once(dirname(dirname(dirname(__FILE__))).'/config.php');
require_once("$CFG->dirroot/mod/simplecertificate/lib.php");
require_once("$CFG->libdir/pdflib.php");

$id = required_param('id', PARAM_INT); // Course Module ID.

if (!$cm = get_coursemodule_from_id( 'youtubeapiplaylist', $id)) {
    print_error('Course Module ID was incorrect');
}

if (!$course = $DB->get_record('course', array('id' => $cm->course))) {
    print_error('course is misconfigured');
}

if (!$youtubeapiplaylist = $DB->get_record('youtubeapiplaylist', array('id' => $cm->instance))) {
    print_error('course module is incorrect');
}

$context = context_module::instance ($cm->id);
$url = new moodle_url('/mod/youtubeapiplaylist/view.php', array (
    'id' => $cm->id,
));

$PAGE->set_url($url);
$PAGE->set_context($context);
$PAGE->set_cm($cm);

require_login( $course->id, false, $cm);

$PAGE->set_title(format_string($youtubeapiplaylist->name));
$PAGE->set_heading(format_string($course->name));


//Venobox lib
$PAGE->requires->js('/mod/youtubeapiplaylist/venobox/venobox.min.js', true);
$PAGE->requires->css('/mod/youtubeapiplaylist/venobox/venobox.css', true);
$PAGE->requires->css('/mod/youtubeapiplaylist/css/styles.css', true);


$PAGE->requires->js('/mod/youtubeapiplaylist/js/api.js');

$PAGE->requires->js_init_call('youtubeapiplaylist', array(array(
        'apikey' => trim($youtubeapiplaylist->api_key),
        'idplaylist' => trim($youtubeapiplaylist->id_playlist)
)));


echo $OUTPUT->header();

?>

<h1><?php echo $youtubeapiplaylist->name ?></h1>

    <div class="container">

        <main>
        </main>

    </div>

<?php

echo $OUTPUT->footer();



