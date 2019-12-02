<?php
if ( ! class_exists( 'TrombiPostMeta' ) ):

	class TrombiPostMeta {

		function __construct() {
			add_action( 'add_meta_boxes', array( $this, 'info_member_meta_box' ) );
			add_action( 'save_post', array( $this, 'save_trombi_meta_data' ), 10, 2 );
		}

		function info_member_meta_box() {
			add_meta_box(
				'info_member_meta_box',
				__( 'Membre Info', TROMBI_SLUG ),
				array( $this, 'trombi_meta_info_member' ),
				'trombi',
				'normal',
				'high' );
		}

		function trombi_meta_info_member( $post ) {

			global $trombi;
			wp_nonce_field( $trombi->nonceText(), 'trombi_nonce' );
			$meta = get_post_meta( $post->ID );
			?>
            <table class="form-table" role="presentation">
                <tr>
                    <th>
                        <label for="short_bio"><?php _e( 'Short Bio:', TROMBI_SLUG ); ?></label>
                    </th>
                    <td scope="row">
                    <textarea name="short_bio" rows="5" style="float: left;width: 75%;"
                              value=""><?php echo( @$meta['short_bio'][0] ? @$meta['short_bio'][0] : null ) ?></textarea>
                        <div style="float: left;width: 75%;">
                            <span><?php _e( 'Ajouter une petite description', TROMBI_SLUG ); ?></span>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="lastName"><?php _e( 'Noms', TROMBI_SLUG ); ?>:</label>
                    </th>
                    <td scope="row">
                        <input type="text" name="lastName" style="float: left;width: 75%;"
                               value="<?php echo( @$meta['lastName'][0] ? @$meta['lastName'][0] : null ) ?>">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="firstName"><?php _e( 'Prénom', TROMBI_SLUG ); ?>:</label>
                    </th>
                    <td scope="row">
                        <input type="firstName" name="firstName" style="float: left;width: 75%;"
                               value="<?php echo( @$meta['firstName'][0] ? @$meta['firstName'][0] : null ) ?>">
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="professions"><?php _e( 'Profession', TROMBI_SLUG ); ?>:</label>
                    </th>
                    <td scope="row">
						<?php
						global $wpdb;
						$table_name = $wpdb->prefix . 'trombi_professions';
						$object     = $wpdb->get_results( "SELECT * FROM $table_name" );
						$array      = json_decode( json_encode( $object ), true );
						?>
                        <select style="float: left;width: 75%;">
							<?php
							for ( $i = 0; $i < count( $array ); $i ++ ) {

								$job = null;

								foreach ( $array[ $i ] as $key => $value ) {

									if ( $key == "Professions" ) {
										$job = $value;
									}
								}
								$value = ( @$meta['Professions'][0] ? @$meta['Professions'][0] : null );
								?>
                                <option value="<?php echo $value ?>"
                                        name="<?php echo $job ?>"><?php echo $job ?></option>
                            <?php } ?>

                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="available"><?php _e( 'Disponibilité', TROMBI_SLUG ); ?>:</label>
                    </th>
                    <td scope="row">
                        <select type="available" name="available" style="float: left;width: 75%;">
                            <option value="<?php echo( @$meta['available'][0] ? @$meta['available'][0] : null ) ?>"
                                    name="available">Présent
                            </option>
                            <option value="<?php echo( @$meta['available'][0] ? @$meta['available'][0] : null ) ?>"
                                    name="available">Absent
                            </option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>
                        <label for="phone"><?php _e( 'Téléphone', TROMBI_SLUG ); ?>:</label>
                    </th>
                    <td scope="row">
                        <input type="text" name="phone" style="float: left;width: 75%;"
                               value="<?php echo( @$meta['phone'][0] ? @$meta['phone'][0] : null ) ?>">
                    </td>
                </tr>
            </table>

			<?php
		}

		function save_trombi_meta_data( $post_id, $post ) {

			global $wpdb;

			if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
				return;
			}

			global $trombi;

			if ( ! $trombi->verifyNonce() ) {
				return $post_id;
			}
			if ( $trombi->post_type != $post->post_type ) {
				return $post_id;
			}

			if ( isset( $_REQUEST['short_bio'] ) ) {
				$short_bio = sanitize_text_field( $_REQUEST['short_bio'] );
				update_post_meta( $post_id, 'short_bio', sanitize_text_field( $_REQUEST['short_bio'] ) );
			}

			if ( isset( $_REQUEST['firstName'] ) ) {
				$firstName = sanitize_text_field( $_REQUEST['firstName'] );
				update_post_meta( $post_id, 'firstName', sanitize_text_field( ucwords( $_REQUEST['firstName'] ) ) );
			}


			if ( isset( $_REQUEST['lastName'] ) ) {
				$lastName = sanitize_text_field( $_REQUEST['lastName'] );
				update_post_meta( $post_id, 'lastName', sanitize_text_field( ucwords( $_REQUEST['lastName'] ) ) );
			}

			if ( isset( $_REQUEST['professions'] ) ) {
				$profession = sanitize_text_field( $_REQUEST['professions'] );
				update_post_meta( $post_id, 'professions', sanitize_text_field( ucwords( $_REQUEST['professions'] ) ) );
			}
			if ( isset( $_REQUEST['available'] ) ) {
				$available = sanitize_text_field( $_REQUEST['available'] );
				update_post_meta( $post_id, 'available', sanitize_text_field( ucwords( $_REQUEST['available'] ) ) );
			}

			if ( isset( $_REQUEST['phone'] ) ) {
				$phone = sanitize_text_field( $_POST['phone'] );
				update_post_meta( $post_id, 'telephone', sanitize_text_field( $_REQUEST['telephone'] ) );
			}

			$table_name = $wpdb->prefix . 'trombi_members';
			$wpdb->insert( $table_name, array(
				'lastName'   => ucwords( $lastName ),
				'firstName'  => ucwords( $firstName ),
				'profession' => ucwords( $profession ),
				'available'  => ucwords( $available ),
				'phone'      => $phone,
				'short_bio'  => $short_bio
			) );

		}



	}
endif;
