<?php

/* TO DO
- Ability to change alert image
*/


function render_blu_alert_banner() {

    $municipal_alerts_options = get_option( 'municipal_alerts_option_name' );
    $alert_header = $municipal_alerts_options['alert_header_1']; 
    $alert_message = $municipal_alerts_options['alert_message_2'];
    $alert_severity = $municipal_alerts_options['alert_severity_level_3'];
    $last_updated = $municipal_alerts_options['alert_udpated_date'];

    switch ($alert_severity) {
        case "Low":
          $alert_level = "alert-success";
          break;
        case "Medium":
            $alert_level = "alert-warning";
          break;
        case "High":
            $alert_level = "alert-danger";
          break;
        default:
            $alert_level = "alert-success";
      }

    $alert = '
    <div class="container-fluid p-0">
        <div class="blu-alert alert alert-dismissable ' . $alert_level . '" role="alert">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-md-11">
                        <div class="row">
                            <div class="col-12 col-sm-2 text-center mb-3">
                                <img class="alert-img" src="' . plugin_dir_url( __FILE__ ) . 'img/circle-exclamation-solid.svg" />
                            </div>
                            <div class="col-12 col-sm-10 text-center text-md-left">
							    <h4 class="alert-title">' . $alert_header . '</h4>
                                <p>' . $alert_message . '</p>
                            </div>
					    </div>
					    <hr>
                        <div class="text-right">
					        <small>Last Updated: ' . $last_updated . '</small>
                        </div>
				    </div>
                    <div class="col-12 col-md-1 order-1 order-md-2">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" title="' . __("Close this message", "blu-alerts") . '">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>	
            </div>
        </div>
    </div>';
    
    
    echo $alert;
}

/*Check if the alert is active in WP settings*/
$municipal_alerts_options = get_option( 'municipal_alerts_option_name' );
$alert_active = $municipal_alerts_options['enabled_0'];

if ($alert_active == "On") {

    if ( ! function_exists( 'wp_body_open' ) ) {
        /**
        * Add backwards compatibility support for wp_body_open function.
        */
        function wp_body_open() {
            add_action( 'wp_body_open', 'render_blu_alert_banner' );
        }
    }
    add_action( 'wp_body_open', 'render_blu_alert_banner' );

} else{
    /*Do nothing*/
}

?>