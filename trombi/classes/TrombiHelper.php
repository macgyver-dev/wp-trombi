<?php
if( !class_exists( 'TrombiHelper' ) ) :

	class TrombiHelper {
		function verifyNonce(){
			$nonce     = isset( $_REQUEST[ $this->nonceId() ] ) ? $_REQUEST[ $this->nonceId() ] : null;
			$nonceText = $this->nonceText();
			if ( ! wp_verify_nonce( $nonce, $nonceText ) ) {
				return false;
			}
			return true;
		}

        function nonceText(){
        	return "trombi_nonce";
        }
		function nonceId() {
			return "trombi_nonce";
		}
	}
endif;
