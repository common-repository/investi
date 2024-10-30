<?php

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

function investi_accordion_func( $atts ) {
	$filterRegex = $atts['filter-regex'] ?? '';
  $maximumNumYears = $atts['maximum-num-years'] ?? '';
  $searchBox = investi_is_flag('searchbox', $atts ) ? 'data-investi-searchbox' : '';
  $priceSensitiveOnly = investi_is_flag('price-sensitive-only', $atts ) ? 'data-investi-price-sensitive-only' : '';
    return "<div class=\"investi-announcements-accordion\"
    data-investi-show-price-sensitive-column 
    data-investi-filter-regex=\"$filterRegex\"
    data-investi-no-data-message=\"No announcements\"
    data-investi-maximum-num-years=\"$maximumNumYears\"
    $searchBox
    $priceSensitiveOnly
    ></div>    
    ";
}

function investi_shareprice_func( $atts ) {
    $color = $atts['color'] ?? '';

    return "
    
    <style>
    
  .investi-market-data-last-container
    {
    border-bottom: 8px solid $color;
  }
.market-data-movement-section {
    border-bottom: 2px solid $color;
}
  .market-data-updated-section {
    border-bottom: 2px solid $color;
  }

</style>
    
    <div class=\"investi-share-price\" ></div>   
    ";
}

function investi_shareprice_chart_func( $atts ) {
    $color = $atts['color'] ?? '';
    
    return "
    
    <script src=\"//code.highcharts.com/stock/8.0.2/highstock.js\"></script>
    
    <div id=\"investi-share-price-chart\" 
    data-investi-chart-theme-color-hex=\"$color\" 
    data-investi-chart-theme-yAxisColor-hex=\"$color\"     
    data-investi-chart-theme-xAxisColor-hex=\"$color\"    
      
    
    ></div>
    ";
}
function investi_announcements_summary_v2_func( $atts ) {
    $color = $atts['color'] ?? '';;    
    $dateFormat = $atts['date-format'] ?? '';;
    if(empty($dateFormat)){
      $dateFormat = "dd MMM yyyy";
    }
    $numAnnouncements = $atts['num-announcements'] ?? '';
    
    $filterRegex = $atts['filter-regex'] ?? '';
    $header = investi_announcement_header($atts);
    $searchBox = investi_is_flag('searchbox', $atts ) ? 'data-investi-searchbox' : '';
    return "
    
    <style>
    
    .investi-announcement-headline a:hover {
      color: $color;
    }
      
    </style>
    
    $header
    
    <div class=\"investi-announcements-summary-v2\"
    data-investi-num-announcements=\"$numAnnouncements\"
    data-investi-date-format=\"$dateFormat\"
    data-investi-filter-regex=\"$filterRegex\"
    data-investi-no-data-message=\"No announcements\"
    $searchBox
    ></div>
    ";
}

function investi_share_price_table_func( $atts ) {
    
    return "<div class=\"investi-share-price-table\"></div>
    ";
}

function investi_announcement_header($atts){
    
  if(is_array($atts) && array_key_exists('no-header', $atts)){
    return "";
  }
  
  $headerText = $atts['header-text'] ?? '';
  $color = $atts['color'] ?? '';
  $lightColor = $atts['light-color'] ?? '';
  if(empty($color)){
    $color = "#505050";
  }
  if(empty($lightColor)){
    $lightColor = "#A0A0A0";
  }
  
  $link = $atts['link'] ?? '';
  $viewAll = '';
  if(!empty($link)){
    $viewAll = "<a href=\"$link\">View All »</a>";
  }

  return "<div class=\"investi-announcements-header\" style=\"background: linear-gradient(90deg, $color 0, $lightColor 100%)\">
  <h2>$headerText</h2>
   $viewAll   
  </div> ";
}

function investi_is_flag( $flag, $atts ) {
  foreach ( $atts as $key => $value )
      if ( $value === $flag && is_int( $key ) ) return true;
  return false;
}

function investi_announcements_tab_func( $atts ) {
  $color = $atts['color'] ?? '';
  $lightColor = $atts['light-color'] ?? '';  
  
  if(empty($color)){
    $color = "#505050";
  }
  if(empty($lightColor)){
    $lightColor = "#A0A0A0";
  }
  $filterRegex = $atts['filter-regex'] ?? '';
  $maximumNumYears = $atts['maximum-num-years'] ?? '';
  $searchBox = investi_is_flag('searchbox', $atts ) ? 'data-investi-searchbox' : '';
  
  return "

<style>


.investi-tab:before {
  content: 'Filter by Year:';
  margin-right: 20px;
}

.investi-tab {
  border-bottom: solid 1px #939393;
  margin-bottom: 15px;
  align-items:center;
}

.investi-tablinks.active,
.investi-tablinks:hover {
  color: #fff;
  background: linear-gradient(90deg, $color 0, $lightColor 100%);
  cursor: pointer;
}


.investi-announcement-row>div:first-of-type {
  color: $color;
  font-weight: 700;
}



</style>

  <div class=\"investi-announcements-tab\" 
  data-investi-date-format=\"dd MMM yyyy\"   
  data-investi-filter-regex=\"$filterRegex\"
  data-investi-maximum-num-years=\"$maximumNumYears\"
  $searchBox
    ></div>
  ";
}

function investi_share_price_symbol_func(){
  return investi_share_price_field("investi-share-price-symbol");
}
function investi_share_price_last_func(){
  return investi_share_price_field("investi-share-price-last");
}

function investi_share_price_market_cap_func(){
  return investi_share_price_field("investi-market-cap");
}
function investi_share_price_shares_on_issue_func(){
  return investi_share_price_field("investi-shares-on-issue");
}
function investi_share_price_movement_percent_func(){
  return investi_share_price_field("investi-share-price-movement-percent");
}
function investi_share_price_movement_func(){
  return investi_share_price_field("investi-share-price-movement");
}
function investi_share_price_volume_func(){
  return investi_share_price_field("investi-share-price-volume");
}
function investi_share_price_prevClose_func(){
  return investi_share_price_field("investi-share-price-prevClose");
}
function investi_share_price_low_func(){
  return investi_share_price_field("investi-share-price-low");
}
function investi_share_price_low52Week_func(){
  return investi_share_price_field("investi-share-price-low52Week");
}
function investi_share_price_high_func(){
  return investi_share_price_field("investi-share-price-high");
}
function investi_share_price_high52Week_func(){
  return investi_share_price_field("investi-share-price-high52Week");
}
function investi_share_price_ask_func(){
  return investi_share_price_field("investi-share-price-ask");
}
function investi_share_price_open_func(){
  return investi_share_price_field("investi-share-price-open");
}
function investi_share_price_bid_func(){
  return investi_share_price_field("investi-share-price-bid");
}
function investi_share_price_updated_func(){
  return investi_share_price_field("investi-share-price-updated");
}


function investi_share_price_field($className){
  return "<div class=\"$className\"></div>";
}

function investi_carousel_func($atts){
  $dateFormat = $atts['date-format']  ?? '';
    if(empty($dateFormat)){
      $dateFormat = "dd MMM yyyy";
    }    
    
    $filterRegex = $atts['filter-regex'] ?? '';
    
    $slickCss = plugins_url( 'slick/slick.css' , __FILE__ );
    $slickThemeCss = plugins_url( 'slick/slick-theme.css' , __FILE__ );
    $slickJs = plugins_url( 'slick/slick.min.js' , __FILE__ );

    wp_enqueue_script(
      'slick-js',
      $slickJs,
      array('jquery'),
      null,
      true
    );

    return "
    <link rel=\"stylesheet\" type=\"text/css\" href=\"$slickCss\"/>
    <link rel=\"stylesheet\" type=\"text/css\" href=\"$slickThemeCss\"/>
    
    <div class=\"investi-carousel\" 
    data-investi-date-format=\"$dateFormat\"
    data-investi-filter-regex=\"$filterRegex\"
    >
      
    </div>
   
    
    
    
    ";
}