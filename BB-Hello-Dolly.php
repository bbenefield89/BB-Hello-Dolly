<?php

/*
Plugin Name: Hello Dolly - Copy
Plugin URI: https://www.bbenefield.com
Description: Copy of the infamous Hello Dolly plugin provided by default from WordPress
Author: Brandon Benefield
Author URI: https://www.bbenefield.com
Version: 1.0.0
*/

if (!defined('ABSPATH')) {
    exit();
}

function get_lyrics() {
  $lyrics_array = [
    "Hello, Dolly",
    "Well, hello, Dolly",
    "It's so nice to have you back where you belong",
    "You're lookin' swell, Dolly",
    "I can tell, Dolly",
    "You're still glowin', you're still crowin'",
    "You're still goin' strong",
    "We feel the room swayin'",
    "While the band's playin'",
    "One of your old favourite songs from way back when",
    "So, take her wrap, fellas",
    "Find her an empty lap, fellas",
    "Dolly'll never go away again",
    "Hello, Dolly",
    "Well, hello, Dolly",
    "It's so nice to have you back where you belong",
    "You're lookin' swell, Dolly",
    "I can tell, Dolly",
    "You're still glowin', you're still crowin'",
    "You're still goin' strong",
    "We feel the room swayin'",
    "While the band's playin'",
    "One of your old favourite songs from way back when",
    "Golly, gee, fellas",
    "Find her a vacant knee, fellas",
    "Dolly'll never go away",
    "Dolly'll never go away",
    "Dolly'll never go away again"
  ];
  
  echo $lyrics_array[ rand(0, 27) ];
}
add_shortcode('Hello_Dolly_Copy', 'get_lyrics');
