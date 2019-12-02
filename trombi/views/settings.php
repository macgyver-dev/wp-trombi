<?php
global $trombi;
global $wpdb;

$settings = get_option( $trombi->options['settings'] );

if ( isset( $_POST['addJob'] ) ) {

	if ( ! empty( $_POST['job'] ) ) {
		$addJob = ucwords( sanitize_text_field( $_POST['job'] ) );

		$table_name = $wpdb->prefix . 'trombi_professions';
		$wpdb->insert( $table_name, array(
			'Professions' => $addJob
		) );

	} else {
		exit;
	}
}

if ( isset( $_POST['submitDeleteCheckboxToDB'] ) ) {
	if ( ! empty( $_POST['checkedJob'] ) ) {

		foreach ( $_POST['checkedJob'] as $value ) {
			$wpdb->query( "DELETE FROM wp_trombi_professions WHERE Professions= '$value' " );
		}
	}
}


?>

<div class="wrap">

    <h2>
        <div id="icon-options-general" class="dashicons dashicons-format-chat"></div>
		<?php _e( 'Setting', 'domain' ); ?>
    </h2>

    <div id="postbox-container">
        <div id="#dashboard-widgets" class="meta-box-sortables ui-sortable">
            <div class="postbox" id="scg-wrapper">
                <h3 class="hndle ui-sortable-handle"><span>Shortcode</span></h3>
                <div class="inside">
                    <label>trombi</label>
                </div>
            </div>
        </div>
    </div>
    <div id="postbox-container">
        <div id="#dashboard-widgets" class="meta-box-sortables ui-sortable">
            <div id="pro-feature" class="postbox">
                <div class="handlediv" title="Click to toggle"><br></div>
                <h3 class="hndle ui-sortable-handle"><span>Setting profession</span></h3>
                <div class="inside">
                    <form method="post">
                        <div style="margin-bottom:10px">
                            <div>
                                <label for="job"><?php _e( 'Ajouter une profession', TROMBI_SLUG ); ?>: </label>
                            </div>
                            <input type="text" style="width: 35%;" name="job"/>
                            <input type="submit" name="addJob" value="Ajouter"
                                   class="button button-primary" style="width: 15%;height:30px;"/>
                        </div>
                        <div id="posttype-page" class="posttypediv " style=" padding:50px">
                            <div class="tabs-panel ">
								<?php
								global $wpdb;
								$table_name = $wpdb->prefix . 'trombi_professions';
								$object     = $wpdb->get_results( "SELECT * FROM $table_name" );
								$array      = json_decode( json_encode( $object ), true );

								for ( $i = 0; $i < count( $array ); $i ++ ) {

									$job = null;

									foreach ( $array[ $i ] as $key => $value ) {

										if ( $key == "Professions" ) {
											$job = $value;
										}
									}
									echo '<input type="checkbox"  name="checkedJob[]" value="' . $job . '" >';
									echo '<label for="' . $job . '">' . $job . '</label> <br />';
								}
								?>
                            </div>
                        </div>
                        <input type="submit" name="submitDeleteCheckboxToDB" class="button button-primary autowidth"
                               value="Supprimer">
                    </form>
                </div>
            </div>
        </div>
    </div>


