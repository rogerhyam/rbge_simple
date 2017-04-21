<?php
/*
Plugin Name: RBGE Simple
Description: General functionality for tweaking WP for the botanics stories install
Version: 0.1
Author: Roger Hyam
License: GPL2
*/


/* Map Embedding */
function rbge_simple_map( $atts ){
	
	$post_id = get_the_ID();
	$longitude = get_post_meta($post_id, 'geo_longitude', true);
	$latitude = get_post_meta($post_id, 'geo_latitude', true);
	
	if(!empty($atts['zoom'])){
	    $zoom = $atts['zoom'];
	}else{
	    $zoom = 16;
	}

    if(empty($longitude) || empty($latitude)){
        return "<strong>This story hasn't been geocoded.</strong>";
    }else{
        
        $mapCode = 
    	'[google-map-v3 
    	    width="100%" 
    	    height="400" 
    	    zoom="'.$zoom.'" 
    	    maptype="hybrid" 
    	    mapalign="left"
    	    directionhint="false" 
    	    language="default"
    	    poweredby="false"
    	    maptypecontrol="true"
    	    pancontrol="true"
    	    zoomcontrol="true"
    	    scalecontrol="true"
    	    streetviewcontrol="true"
    	    scrollwheelcontrol="false"
    	    draggable="true"
    	    tiltfourtyfive="false" 
    	    addmarkermashupbubble="false"
    	    addmarkermashupbubble="false"
    	    addmarkerlist="'. $latitude .', '. $longitude .'{}1-default.png"
    	    bubbleautopan="true"
    	    showbike="false"
    	    showtraffic="false"
    	    showpanoramio="false"]'
    	;

    	return do_shortcode( $mapCode );
        
        
    }

	 
}
add_shortcode( 'rbge_map_it', 'rbge_simple_map' );


/* Map Linking */
function rbge_simple_map_link( $atts ){
	
	$post_id = get_the_ID();
	$longitude = get_post_meta($post_id, 'geo_longitude', true);
	$latitude = get_post_meta($post_id, 'geo_latitude', true);
	
	if(!empty($atts['zoom'])){
	    $zoom = $atts['zoom'];
	}else{
	    $zoom = 16;
	}

	if(!empty($atts['text'])){
	    $txt = $atts['text'];
	}else{
	    $txt = 'Show map.';
	}

    if(empty($longitude) || empty($latitude)){
        return "<strong>This story hasn't been geocoded.</strong>";
    }else{
        return '<a href="https://maps.google.com/maps?z='.$zoom.'&q=loc:'.$latitude.'+'.$longitude.'">'.$txt.'</a>';
        // directions something like: http://maps.google.com/maps?saddr=%f,%f&daddr=%f,%f
    }
	 
}
add_shortcode( 'rbge_map_link', 'rbge_simple_map_link' );


function rbge_trail_nav($atts){
    
    $widget = '<div class="rbge-trail-nav-wrapper" >';

    if(!empty($atts['next'])){
        //$widget .= '<div class="rbge-trail-nav-next" >';
        $widget .= '<a class="rbge-trail-nav-next" href="/archives/'. $atts['next'] . '"/>';
        $widget .= get_the_title($atts['next']);
        $widget .= '<span class="rbge-trail-nav-label">Next: </span>';
        $widget .= '</a>';
        //$widget .= '</div>';
    }

    if(!empty($atts['previous'])){
        //$widget .= '<div class="rbge-trail-nav-previous" >';
        $widget .= '<a class="rbge-trail-nav-previous" href="/archives/'. $atts['previous'] . '"/>';
        $widget .= '<span class="rbge-trail-nav-label">Previous: </span>';
        $widget .= get_the_title($atts['previous']);
        $widget .= '</a>';
       // $widget .= '</div>';
    }
    

    $widget .= '</div>';
    
    return $widget;

}
add_shortcode('rbge_trail_nav', 'rbge_trail_nav');


/**
 *  [rbge_specimen accession="" ]
 *  [rbge_specimen barcode="" ]
 *
 **/
function rbge_specimen_link($atts){
    
    // sanity check they haven't put both in
    if(!empty($atts['accession']) && !empty($atts['barcode'])){
        $widget = "<strong>You must specify a barcode OR accession not both!</strong>";
        return $widget;
    }
    
    // sanity check we have put one in
    if(empty($atts['accession']) && empty($atts['barcode'])){
        $widget = "<strong>You must specify at least a barcode of accession number.</strong>";
        return $widget;
    }
    
    if(!empty($atts['accession'])){
        $clean = str_replace(' ', '', $atts['accession']);
        $url = 'http://data.rbge.org.uk/living/' . $clean;
    }
    
    if(!empty($atts['barcode'])){
        $clean = str_replace(' ', '', $atts['barcode']);
        $url = 'http://data.rbge.org.uk/herb/' . $clean;
    }
    
    $widget = '<a class="rbge-specimen" href="';
    $widget .= $url;
    $widget .= '" >';
    $widget .= $clean;
    $widget .= '</a>';
    
    return $widget;

}
add_shortcode('rbge_specimen', 'rbge_specimen_link');


