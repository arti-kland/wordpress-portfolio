<?php

function jpm_create_table_contact() {

    global $wpdb;

    $tablename = $wpdb -> prefix . "contacts";
    if( $wpdb -> get_var("SHOW TABLES LIKE '$tablename'") != $tablename) {
        $sql = "CREATE TABLE `$tablename` (
            `ctc_id` bigint(20) NOT NULL  AUTO_INCREMENT,
            `created_at` datetime,
            `ctc_nom` varchar (35) NOT NULL,
            `ctc_mail` varchar (255) NOT NULL,
            `ctc_telephone` varchar (15) NULL,
            `ctc_message` text NOT NULL,
            PRIMARY KEY (`ctc_id`),
            INDEX (created_at)
            ) ENGINE = innoDB DEFAULT CHARSET = utf8 AUTO_INCREMENT = 1 ;";
    }
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');

    dbDelta($sql);

}// end function jpm_create_table_contact

add_action("after_switch_theme", "jpm_create_table_contact");

//===================================================================================================================
//                                      Création menu des messages contact
//===================================================================================================================

function jpm_contact_create_menu() {

    add_menu_page('messages', 'Messages', 'edit_pages', 'messages_recus', 'jpm_create_page_contact', 'dashicons-email-alt', 6);

}// end function jpm_contact_create_menu

function jpm_create_page_contact() {

    global $wpdb;
    $tablename = $wpdb -> prefix . "contacts";

    $sql = "SELECT *, DATE_FORMAT(created_at, '%e/%m/%Y à %H:%i') AS date_formatted FROM `$tablename` ORDER BY `created_at` DESC";
    $result = $wpdb -> get_results($sql, OBJECT); ?>

    <div class="container" style="margin-top:40px;">
        <div class="row">
            <div class="col-12">
                <h1>Liste des messages reçus</h1>
                <table id="table-messages" class="table table-bordered">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Téléphone</th>
                        <th>Message</th>
                        <th>&nbsp;</th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php foreach ($result as $res):
                        echo '<tr>';
                        echo '<td>', $res -> ctc_id, '</td>';
                        echo '<td>', $res -> date_formatted, '</td>';
                        echo '<td>', $res -> ctc_nom, '</td>';
                        echo '<td>', $res -> ctc_mail, '</td>';
                        echo '<td>', $res -> ctc_telephone, '</td>';
                        echo '<td>', stripslashes($res -> ctc_message), '</td>';
                        echo '<td><a class="btn btn-danger deletable" data-id="',$res -> ctc_id,'">supprimer</a></td>';
                        echo '</tr>';
                        endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div><!-- /container -->

<?php
}// end function jpm_create_page_contact

add_action('admin_menu', 'jpm_contact_create_menu');