<?php
/*
Plugin Name: RBGE Simple
Description: General functionality for tweaking WP for the botanics stories install
Version: 0.1
Author: Roger Hyam
License: GPL2
*/


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


