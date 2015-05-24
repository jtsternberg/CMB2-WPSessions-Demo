<?php

// Include CMB2 globally for this site.
require WPMU_PLUGIN_DIR . '/cmb2/init.php';

wp_die( defined( 'CMB2_LOADED' ) ? 'CMB2 Loaded!' : 'uh oh! :(', __( 'CMB2 Check', 'wpsessions' ) );
