<?php
/**
 * Controller
 *
 * Database-driven Webtechnology
 * Taught by Stijn Eikelboom
 * Based on code by Reinard van Dalen
 */

include 'model.php';

/* Connect to DB */
$db = connect_db('localhost', 'ddwt23_week2', 'ddwt23','ddwt23');

/* Landing page */
if (new_route('/DDWT23/week2/', 'get')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

    /* Page info */
    $page_title = 'Home';
    $breadcrumbs = get_breadcrumbs([
        'DDWT23' => na('/DDWT23/', False),
        'Week 2' => na('/DDWT23/week2/', False),
        'Home' => na('/DDWT23/week2/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT23/week2/', True),
        'Overview' => na('/DDWT23/week2/overview/', False),
        'Add Series' => na('/DDWT23/week2/add/', False),
        'My Account' => na('/DDWT23/week2/myaccount/', False),
        'Registration' => na('/DDWT23/week2/register/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'The online platform to list your favorite series';
    $page_content = 'On Series Overview you can list your favorite series. You can see the favorite series of all Series Overview users. By sharing your favorite series, you can get inspired by others and explore new series.';

    /* Choose Template */
    include use_template('main');
}

/* Overview page */
elseif (new_route('/DDWT23/week2/overview/', 'get')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT23' => na('/DDWT23/', False),
        'Week 2' => na('/DDWT23/week2/', False),
        'Overview' => na('/DDWT23/week2/overview', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT23/week2/', False),
        'Overview' => na('/DDWT23/week2/overview', True),
        'Add Series' => na('/DDWT23/week2/add/', False),
        'My Account' => na('/DDWT23/week2/myaccount/', False),
        'Registration' => na('/DDWT23/week2/register/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = get_series_table(get_series($db));

    /* Choose Template */
    include use_template('main');
}

/* Single series */
elseif (new_route('/DDWT23/week2/series/', 'get')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

    /* Get series from db */
    $series_id = $_GET['series_id'];
    $series_info = get_series_info($db, $series_id);

    /* Page info */
    $page_title = $series_info['name'];
    $breadcrumbs = get_breadcrumbs([
        'DDWT23' => na('/DDWT23/', False),
        'Week 2' => na('/DDWT23/week2/', False),
        'Overview' => na('/DDWT23/week2/overview/', False),
        $series_info['name'] => na('/DDWT23/week2/series/?series_id='.$series_id, True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT23/week2/', False),
        'Overview' => na('/DDWT23/week2/overview', True),
        'Add series' => na('/DDWT23/week2/add/', False),
        'My Account' => na('/DDWT23/week2/myaccount/', False),
        'Registration' => na('/DDWT23/week2/register/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = sprintf("Information about %s", $series_info['name']);
    $page_content = $series_info['abstract'];
    $nbr_seasons = $series_info['seasons'];
    $creators = $series_info['creator'];

    /* Choose Template */
    include use_template('series');
}

/* Add series GET */
elseif (new_route('/DDWT23/week2/add/', 'get')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

    /* Page info */
    $page_title = 'Add Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT23' => na('/DDWT23/', False),
        'Week 2' => na('/DDWT23/week2/', False),
        'Add Series' => na('/DDWT23/week2/new/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT23/week2/', False),
        'Overview' => na('/DDWT23/week2/overview', False),
        'Add Series' => na('/DDWT23/week2/add/', True),
        'My Account' => na('/DDWT23/week2/myaccount/', False),
        'Registration' => na('/DDWT23/week2/register/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'Add your favorite series';
    $page_content = 'Fill in the details of you favorite series.';
    $submit_btn = 'Add Series';
    $form_action = '/DDWT23/week2/add/';

    /* Choose Template */
    include use_template('new');
}

/* Add series POST */
elseif (new_route('/DDWT23/week2/add/', 'post')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

    /* Page info */
    $page_title = 'Add Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT23' => na('/DDWT23/', False),
        'Week 2' => na('/DDWT23/week2/', False),
        'Add Series' => na('/DDWT23/week2/add/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT23/week2/', False),
        'Overview' => na('/DDWT23/week2/overview', False),
        'Add Series' => na('/DDWT23/week2/add/', True),
        'My Account' => na('/DDWT23/week2/myaccount/', False),
        'Registration' => na('/DDWT23/week2/register/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'Add your favorite series';
    $page_content = 'Fill in the details of you favorite series.';
    $submit_btn = 'Add Series';
    $form_action = '/DDWT23/week2/add/';

    /* Add series to database */
    $feedback = add_series($db, $_POST);
    $error_msg = get_error($feedback);

    include use_template('new');
}

/* Edit series GET */
elseif (new_route('/DDWT23/week2/edit/', 'get')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

    /* Get series info from db */
    $series_id = $_GET['series_id'];
    $series_info = get_series_info($db, $series_id);

    /* Page info */
    $page_title = 'Edit Series';
    $breadcrumbs = get_breadcrumbs([
        'DDWT23' => na('/DDWT23/', False),
        'Week 2' => na('/DDWT23/week2/', False),
        sprintf("Edit Series %s", $series_info['name']) => na('/DDWT23/week2/new/', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT23/week2/', False),
        'Overview' => na('/DDWT23/week2/overview', False),
        'Add Series' => na('/DDWT23/week2/add/', False),
        'My Account' => na('/DDWT23/week2/myaccount/', False),
        'Registration' => na('/DDWT23/week2/register/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = sprintf('Edit %s', $series_info['name']);
    $page_content = 'Edit the series below.';
    $submit_btn = 'Edit Series';
    $form_action = '/DDWT23/week2/edit/';

    /* Choose Template */
    include use_template('new');
}

/* Edit series POST */
elseif (new_route('/DDWT23/week2/edit/', 'post')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

    /* Update series in database */
    $feedback = update_series($db, $_POST);
    $error_msg = get_error($feedback);

    /* Get series info from db */
    $series_id = $_POST['series_id'];
    $series_info = get_series_info($db, $series_id);

    /* Page info */
    $page_title = $series_info['name'];
    $breadcrumbs = get_breadcrumbs([
        'DDWT23' => na('/DDWT23/', False),
        'Week 2' => na('/DDWT23/week2/', False),
        'Overview' => na('/DDWT23/week2/overview/', False),
        $series_info['name'] => na('/DDWT23/week2/series/?series_id='.$series_id, True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT23/week2/', False),
        'Overview' => na('/DDWT23/week2/overview', False),
        'Add Series' => na('/DDWT23/week2/add/', False),
        'My Account' => na('/DDWT23/week2/myaccount/', False),
        'Registration' => na('/DDWT23/week2/register/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = sprintf('Information about %s', $series_info['name']);
    $page_content = $series_info['abstract'];
    $nbr_seasons = $series_info['seasons'];
    $creators = $series_info['creator'];

    /* Choose Template */
    include use_template('series');
}

/* Remove series */
elseif (new_route('/DDWT23/week2/remove/', 'post')) {
    /* Get Number of Series */
    $nbr_series = count_series($db);

    /* Remove series in database */
    $series_id = $_POST['series_id'];
    $feedback = remove_series($db, $series_id);
    $error_msg = get_error($feedback);

    /* Page info */
    $page_title = 'Overview';
    $breadcrumbs = get_breadcrumbs([
        'DDWT23' => na('/DDWT23/', False),
        'Week 2' => na('/DDWT23/week2/', False),
        'Overview' => na('/DDWT23/week2/overview', True)
    ]);
    $navigation = get_navigation([
        'Home' => na('/DDWT23/week2/', False),
        'Overview' => na('/DDWT23/week2/overview', True),
        'Add Series' => na('/DDWT23/week2/add/', False),
        'My Account' => na('/DDWT23/week2/myaccount/', False),
        'Registration' => na('/DDWT23/week2/register/', False)
    ]);

    /* Page content */
    $right_column = use_template('cards');
    $page_subtitle = 'The overview of all series';
    $page_content = 'Here you find all series listed on Series Overview.';
    $left_content = get_series_table(get_series($db));

    /* Choose Template */
    include use_template('main');
}

else {
    http_response_code(404);
    echo '404 Not Found';
}
