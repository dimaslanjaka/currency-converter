<?php

/**
 * Usage:.
// Output screenshot:
// http://cl.ly/NsqF
// -------------------------------------------------------

include_once 'console.php';

// ::log method usage
// -------------------------------------------------------
Console::log('Im Red!', 'red');
Console::log('Im Blue on White!', 'white', true, 'blue');

Console::log('I dont have an EOF', false);
Console::log("\tThis is where I come in.", 'light_green');
Console::log('You can swap my variables', 'black', 'yellow');
Console::log(str_repeat('-', 60));

// Direct usage
// -------------------------------------------------------
echo Console::blue('Blue Text') . "\n";
echo Console::black('Black Text on Magenta Background', 'magenta') . "\n";
echo Console::red('Im supposed to be red, but Im reversed!', 'reverse') . "\n";
echo Console::red('I have an underline', 'underline') . "\n";
echo Console::blue('I should be blue on light gray but Im reversed too.', 'light_gray', 'reverse') . "\n";

// Ding!
// -------------------------------------------------------
echo Console::bell();
 */
/**
 * PHP Colored CLI
 * Used to log strings with custom colors to console using php.
 *
 * Copyright (C) 2013 Sallar Kaboli <sallar.kaboli@gmail.com>
 * MIT Liencesed
 * http://opensource.org/licenses/MIT
 *
 * Original colored CLI output script:
 * (C) Jesse Donat https://github.com/donatj
 */
class Console
{
    public static $foreground_colors = [
        'bold' => '1',    'dim' => '2',
        'black' => '0;30', 'dark_gray' => '1;30',
        'blue' => '0;34', 'light_blue' => '1;34',
        'green' => '0;32', 'light_green' => '1;32',
        'cyan' => '0;36', 'light_cyan' => '1;36',
        'red' => '0;31', 'light_red' => '1;31',
        'purple' => '0;35', 'light_purple' => '1;35',
        'brown' => '0;33', 'yellow' => '1;33',
        'light_gray' => '0;37', 'white' => '1;37',
        'normal' => '0;39',
    ];

    public static $background_colors = [
        'black' => '40',   'red' => '41',
        'green' => '42',   'yellow' => '43',
        'blue' => '44',   'magenta' => '45',
        'cyan' => '46',   'light_gray' => '47',
    ];

    public static $win;

    public static $win_color = [
        'black' => '0', 'green' => '10',
        'red' => '12', 'white' => '15',
        'pink' => '13', 'cyan' => '11',
        'grey' => '8', 'lightgrey' => '7',
        'yellow' => '14', 'blue' => '9'
    ];

    public static $options = [
        'underline' => '4',    'blink' => '5',
        'reverse' => '7',    'hidden' => '8',
    ];

    public static $EOF = "\n";

    public function __construct()
    {
        self::$win = ('WIN' === strtoupper(substr(PHP_OS, 0, 3)));
    }
    static function welcome()
    {
        echo <<<EOF
        '||'      ____            ,
        ||       ` // .. ...    /|  ... ..   /\\  ... ...
        ||        //   ||  ||  / |   ||' '' || ||  '|..'
        ||        \\   ||  ||  __|_  ||     || ||   .|.
       .||.....|   )) .||. ||. ---- .||.    || || .|  ||.
                  //             |          || ||
                 /'             '-'          \\/
EOF;
    }

    public static function warna($text, $warna)
    {
        $warna = strtoupper($warna);
        $list = [];
        $list['BLACK'] = "\033[30m";
        $list['RED'] = "\033[31m";
        $list['GREEN'] = "\033[32m";
        $list['YELLOW'] = "\033[33m";
        $list['BLUE'] = "\033[34m";
        $list['MAGENTA'] = "\033[35m";
        $list['CYAN'] = "\033[36m";
        $list['WHITE'] = "\033[37m";
        $list['RESET'] = "\033[39m";
        $warna = $list[$warna];
        $reset = $list['RESET'];
        if (in_array($warna, $list)) {
            $text = "$warna$text$reset";
        } else {
            $text = $text;
        }

        return $text;
    }

    /**
     * Logs a string to console.
     *
     * @param string $str        Input String
     * @param string $color      Text Color
     * @param bool   $newline    Append EOF?
     * @param [type] $background Background Color
     *
     * @return [type] Formatted output
     */
    public static function log($str = '', $color = 'normal', $newline = true, $background_color = null)
    {
        if (is_bool($color)) {
            $newline = $color;
            $color = 'normal';
        } elseif (is_string($color) && is_string($newline)) {
            $background_color = $newline;
            $newline = true;
        }
        $str = $newline ? $str . self::$EOF : $str;

        echo self::$color($str, $background_color);
    }

    /**
     * Anything below this point (and its related variables):
     * Colored CLI Output is: (C) Jesse Donat
     * https://gist.github.com/donatj/1315354
     * -------------------------------------------------------------.
     */

    /**
     * Check function enabled.
     *
     * @param string $func
     *
     * @return boolean
     */
    public static function isEnabled($func)
    {
        return is_callable($func) && false === stripos(ini_get('disable_functions'), $func);
    }
    /**
     * is mac ?
     *
     * @return void
     */
    public static function ismac()
    {
        $user_agent = getenv('HTTP_USER_AGENT');
        return false !== strpos($user_agent, 'Mac');
    }

    /**
     * Catches static calls (Wildcard).
     *
     * @param string $foreground_color Text Color
     * @param array  $args             Options
     *
     * @return string Colored string
     */
    public static function __callStatic($foreground_color, $args)
    {
        self::$win = ('WIN' === strtoupper(substr(PHP_OS, 0, 3)));
        $printenv = shell_exec('printenv >nul 2>&1 && ( echo found ) || ( echo fail )');
        $string = $args[0];
        $colored_string = '';
        if (self::$win && trim($printenv) == 'fail') {
            //Windows
            return $string;
        } elseif (!self::ismac() || trim($printenv) == 'found') {
            // Linux
            if (isset(self::$foreground_colors[$foreground_color])) {
                $colored_string .= "\033[" . self::$foreground_colors[$foreground_color] . 'm';
            } else {
                throw new Exception($foreground_color . ' not a valid color');
            }

            array_shift($args);

            foreach ($args as $option) {
                // Check if given background color found
                if (isset(self::$background_colors[$option])) {
                    $colored_string .= "\033[" . self::$background_colors[$option] . 'm';
                } elseif (isset(self::$options[$option])) {
                    $colored_string .= "\033[" . self::$options[$option] . 'm';
                }
            }

            // Add string and end coloring
            $colored_string .= $string . "\033[0m";
        } else {
            $colored_string = $string;
        }

        return $colored_string;
    }

    /**
     * Plays a bell sound in console (if available).
     *
     * @param int $count Bell play count
     *
     * @return string Bell play string
     */
    public static function bell($count = 1)
    {
        echo str_repeat("\007", $count);
    }
}
