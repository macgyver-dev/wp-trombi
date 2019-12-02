<?php

if ( ! class_exists( 'TrombiShortCode' ) ):

	class TrombiShortCode {

		function __construct() {
			add_shortcode( 'trombi', array( $this, 'trombi_shortcode' ) );
		}



		function trombi_shortcode() {
		    $this->isotop_css();
			?>
            <h1>Isotope - filtering</h1>

            <div class="button-group filters-button-group">
                <button class="button is-checked" data-filter="*">show all</button>
                <button class="button" data-filter=".metal">Présent</button>
                <button class="button" data-filter=".transition">Absent</button>
            </div>

            <div class="grid">
              <div class="element-item post-transition metal " data-category="metal">
                    <h3 class="name">Lead</h3>
                    <p class="symbol">Pb</p>
                    <p class="number">82</p>
                    <p class="weight">207.2</p>
                </div>
                <div class="element-item transition metal " data-category="metal">
                    <h3 class="name">Gold</h3>
                    <p class="symbol">Au</p>
                    <p class="number">79</p>
                    <p class="weight">196.967</p>
                </div>
                <div class="element-item transition metal " data-category="transition">
                    <h3 class="name">Cadmium</h3>
                    <p class="symbol">Cd</p>
                    <p class="number">48</p>
                    <p class="weight">112.411</p>
                </div>
                <div class="element-item transition metal " data-category="transition">
                    <h3 class="name">Rhenium</h3>
                    <p class="symbol">Re</p>
                    <p class="number">75</p>
                    <p class="weight">186.207</p>
                </div>
            </div>
			<?php

            $this->isotop_js();
            $this->isotop_front_end();
		}

		function isotop_css() {
			$css_File = file_get_contents(TROMBI_PLUGIN_DIR. "/assets/css/isotop.css"); // Can use single quot as well...
			echo '<style type="text/css">' . $css_File . '</style>';
		}
		function isotop_front_end() {
		    $link = TROMBI_PLUGIN_URL . '/assets/js/isotop.js';
			$js_File = '<script type="text/javascript" src="'.$link.'"></script>';
			echo $js_File;
		}

		function isotop_js() {
			$link = TROMBI_PLUGIN_URL . '/assets/js/isotope.pkgd.min.js';
			$js_File = '<script type="text/javascript" src="'.$link.'"></script>';
			echo $js_File;
		}
	}

endif;
