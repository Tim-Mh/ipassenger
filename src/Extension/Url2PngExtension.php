<?php

namespace App\Extension;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class Url2PngExtension extends AbstractExtension
{
    public function getFunctions()
    {
    return [
    new TwigFunction('url2png_v6', [$this, 'url2png_v6']),
    ];
    }

    public function url2png_v6($url)
    {
    $URL2PNG_APIKEY = "PC1EA5686B79A9D";
    $URL2PNG_SECRET = "S_FDE718096BFD5";

    # urlencode request target
    $options['url'] = urlencode($url);
    # usage
    $options['unique'] = round(time() / 60 / 60, 0);      # Limit capture to once per hour
    $options['fullpage'] = 'false';      # [true,false] Default: false
    $options['thumbnail_max_width'] = 'false';      # scaled image width in pixels; Default no-scaling.
    $options['viewport'] = "1280x1024";  # Max 5000x5000; Default 1280x1024

    # create the query string based on the options
    foreach ($options as $key => $value) {
    $_parts[] = "$key=$value";
    }

    # create a token from the ENTIRE query string
    $query_string = implode("&", $_parts);
    $TOKEN = md5($query_string . $URL2PNG_SECRET);

    return "https://api.url2png.com/v6/$URL2PNG_APIKEY/$TOKEN/png/?$query_string";
    }
    }
