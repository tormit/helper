<?php

/**
 * General utility functions
 * Since 2005
 *
 * PHP8
 *
 * @version 0.1 7th December 2009
 * @version 1.0 28th August 2011
 * @version 1.1 1st November 2011 Start of versioning. __() now returns source text if Symfony's I18N fails.
 *                                Deprecated ambiguous fixHttpAddress() function.
 * @version 1.1.1 6th November 2011 __() checks if I18N is enabled.
 * @version 2.0 27th February 2015 Namespaced. Cleanup.
 * @version 2.5 29th July 2015 Cleanup of legacy dependencies.
 * @version 2.6 18th July 2016 UTF8 support. Batch actions.
 * @version 3.0 17th July 2018 More UTF8 support. PHP 7.1 minimum.
 * @version 4.0 13th January 2021 Improvements. PHP 7.4 minimum.
 * @version 4.1 27th March 2024 Many improvements over time.
 * @version 5.0 30th July 2024 Cleanups and optimizations. Removed Laravel usage. PHP 8.1 minimum.
 *
 * @todo Write unit tests.
 *
 * @copyright Tormi Talv
 */
declare(strict_types=1);

namespace Tormit\Helper;

class Util
{

    public const DIVIDE_TEXT_EQUAL = 0;
    public const DIVIDE_TEXT_FILL = 1;

    private static array $extensionToType = array(
        'ez' => 'application/andrew-inset',
        'atom' => 'application/atom+xml',
        'jar' => 'application/java-archive',
        'hqx' => 'application/mac-binhex40',
        'cpt' => 'application/mac-compactpro',
        'mathml' => 'application/mathml+xml',
        'doc' => 'application/msword',
        'dat' => 'application/octet-stream',
        'oda' => 'application/oda',
        'ogg' => 'application/ogg',
        'pdf' => 'application/pdf',
        'ai' => 'application/postscript',
        'eps' => 'application/postscript',
        'ps' => 'application/postscript',
        'rdf' => 'application/rdf+xml',
        'rss' => 'application/rss+xml',
        'smi' => 'application/smil',
        'smil' => 'application/smil',
        'gram' => 'application/srgs',
        'grxml' => 'application/srgs+xml',
        'kml' => 'application/vnd.google-earth.kml+xml',
        'kmz' => 'application/vnd.google-earth.kmz',
        'mif' => 'application/vnd.mif',
        'xul' => 'application/vnd.mozilla.xul+xml',
        'xls' => 'application/vnd.ms-excel',
        'xlb' => 'application/vnd.ms-excel',
        'xlt' => 'application/vnd.ms-excel',
        'xlam' => 'application/vnd.ms-excel.addin.macroEnabled.12',
        'xlsb' => 'application/vnd.ms-excel.sheet.binary.macroEnabled.12',
        'xlsm' => 'application/vnd.ms-excel.sheet.macroEnabled.12',
        'xltm' => 'application/vnd.ms-excel.template.macroEnabled.12',
        'docm' => 'application/vnd.ms-word.document.macroEnabled.12',
        'dotm' => 'application/vnd.ms-word.template.macroEnabled.12',
        'ppam' => 'application/vnd.ms-powerpoint.addin.macroEnabled.12',
        'pptm' => 'application/vnd.ms-powerpoint.presentation.macroEnabled.12',
        'ppsm' => 'application/vnd.ms-powerpoint.slideshow.macroEnabled.12',
        'potm' => 'application/vnd.ms-powerpoint.template.macroEnabled.12',
        'ppt' => 'application/vnd.ms-powerpoint',
        'pps' => 'application/vnd.ms-powerpoint',
        'odc' => 'application/vnd.oasis.opendocument.chart',
        'odb' => 'application/vnd.oasis.opendocument.database',
        'odf' => 'application/vnd.oasis.opendocument.formula',
        'odg' => 'application/vnd.oasis.opendocument.graphics',
        'otg' => 'application/vnd.oasis.opendocument.graphics-template',
        'odi' => 'application/vnd.oasis.opendocument.image',
        'odp' => 'application/vnd.oasis.opendocument.presentation',
        'otp' => 'application/vnd.oasis.opendocument.presentation-template',
        'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        'ots' => 'application/vnd.oasis.opendocument.spreadsheet-template',
        'odt' => 'application/vnd.oasis.opendocument.text',
        'odm' => 'application/vnd.oasis.opendocument.text-master',
        'ott' => 'application/vnd.oasis.opendocument.text-template',
        'oth' => 'application/vnd.oasis.opendocument.text-web',
        'potx' => 'application/vnd.openxmlformats-officedocument.presentationml.template',
        'ppsx' => 'application/vnd.openxmlformats-officedocument.presentationml.slideshow',
        'pptx' => 'application/vnd.openxmlformats-officedocument.presentationml.presentation',
        'xlsx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'xltx' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.template',
        'docx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'dotx' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.template',
        'vsd' => 'application/vnd.visio',
        'wbxml' => 'application/vnd.wap.wbxml',
        'wmlc' => 'application/vnd.wap.wmlc',
        'wmlsc' => 'application/vnd.wap.wmlscriptc',
        'vxml' => 'application/voicexml+xml',
        'bcpio' => 'application/x-bcpio',
        'vcd' => 'application/x-cdlink',
        'pgn' => 'application/x-chess-pgn',
        'cpio' => 'application/x-cpio',
        'csh' => 'application/x-csh',
        'dcr' => 'application/x-director',
        'dir' => 'application/x-director',
        'dxr' => 'application/x-director',
        'dvi' => 'application/x-dvi',
        'spl' => 'application/x-futuresplash',
        'tgz' => 'application/x-gtar',
        'gtar' => 'application/x-gtar',
        'hdf' => 'application/x-hdf',
        'js' => 'application/x-javascript',
        'skp' => 'application/x-koan',
        'skd' => 'application/x-koan',
        'skt' => 'application/x-koan',
        'skm' => 'application/x-koan',
        'latex' => 'application/x-latex',
        'nc' => 'application/x-netcdf',
        'cdf' => 'application/x-netcdf',
        'sh' => 'application/x-sh',
        'shar' => 'application/x-shar',
        'swf' => 'application/x-shockwave-flash',
        'sit' => 'application/x-stuffit',
        'sv4cpio' => 'application/x-sv4cpio',
        'sv4crc' => 'application/x-sv4crc',
        'tar' => 'application/x-tar',
        'tcl' => 'application/x-tcl',
        'tex' => 'application/x-tex',
        'texinfo' => 'application/x-texinfo',
        'texi' => 'application/x-texinfo',
        't' => 'application/x-troff',
        'tr' => 'application/x-troff',
        'roff' => 'application/x-troff',
        'man' => 'application/x-troff-man',
        'me' => 'application/x-troff-me',
        'ms' => 'application/x-troff-ms',
        'ustar' => 'application/x-ustar',
        'src' => 'application/x-wais-source',
        'xhtml' => 'application/xhtml+xml',
        'xht' => 'application/xhtml+xml',
        'xslt' => 'application/xslt+xml',
        'xml' => 'application/xml',
        'xsl' => 'application/xml',
        'dtd' => 'application/xml-dtd',
        'zip' => 'application/zip',
        'au' => 'audio/basic',
        'snd' => 'audio/basic',
        'mid' => 'audio/midi',
        'midi' => 'audio/midi',
        'kar' => 'audio/midi',
        'mpga' => 'audio/mpeg',
        'mp2' => 'audio/mpeg',
        'mp3' => 'audio/mpeg',
        'aif' => 'audio/x-aiff',
        'aiff' => 'audio/x-aiff',
        'aifc' => 'audio/x-aiff',
        'm3u' => 'audio/x-mpegurl',
        'wma' => 'audio/x-ms-wma',
        'wax' => 'audio/x-ms-wax',
        'ram' => 'audio/x-pn-realaudio',
        'ra' => 'audio/x-pn-realaudio',
        'rm' => 'application/vnd.rn-realmedia',
        'wav' => 'audio/x-wav',
        'pdb' => 'chemical/x-pdb',
        'xyz' => 'chemical/x-xyz',
        'bmp' => 'image/bmp',
        'cgm' => 'image/cgm',
        'gif' => 'image/gif',
        'ief' => 'image/ief',
        'jpeg' => 'image/jpeg',
        'jpg' => 'image/jpeg',
        'jpe' => 'image/jpeg',
        'png' => 'image/png',
        'svg' => 'image/svg+xml',
        'tiff' => 'image/tiff',
        'tif' => 'image/tiff',
        'djvu' => 'image/vnd.djvu',
        'djv' => 'image/vnd.djvu',
        'wbmp' => 'image/vnd.wap.wbmp',
        'ras' => 'image/x-cmu-raster',
        'ico' => 'image/x-icon',
        'pnm' => 'image/x-portable-anymap',
        'pbm' => 'image/x-portable-bitmap',
        'pgm' => 'image/x-portable-graymap',
        'ppm' => 'image/x-portable-pixmap',
        'rgb' => 'image/x-rgb',
        'xbm' => 'image/x-xbitmap',
        'psd' => 'image/x-photoshop',
        'xpm' => 'image/x-xpixmap',
        'xwd' => 'image/x-xwindowdump',
        'eml' => 'message/rfc822',
        'igs' => 'model/iges',
        'iges' => 'model/iges',
        'msh' => 'model/mesh',
        'mesh' => 'model/mesh',
        'silo' => 'model/mesh',
        'wrl' => 'model/vrml',
        'vrml' => 'model/vrml',
        'ics' => 'text/calendar',
        'ifb' => 'text/calendar',
        'css' => 'text/css',
        'csv' => 'text/csv',
        'html' => 'text/html',
        'htm' => 'text/html',
        'txt' => 'text/plain',
        'asc' => 'text/plain',
        'rtx' => 'text/richtext',
        'rtf' => 'text/rtf',
        'sgml' => 'text/sgml',
        'sgm' => 'text/sgml',
        'tsv' => 'text/tab-separated-values',
        'wml' => 'text/vnd.wap.wml',
        'wmls' => 'text/vnd.wap.wmlscript',
        'etx' => 'text/x-setext',
        'mpeg' => 'video/mpeg',
        'mpg' => 'video/mpeg',
        'mpe' => 'video/mpeg',
        'qt' => 'video/quicktime',
        'mov' => 'video/quicktime',
        'mxu' => 'video/vnd.mpegurl',
        'm4u' => 'video/vnd.mpegurl',
        'flv' => 'video/x-flv',
        'asf' => 'video/x-ms-asf',
        'asx' => 'video/x-ms-asf',
        'wmv' => 'video/x-ms-wmv',
        'wm' => 'video/x-ms-wm',
        'wmx' => 'video/x-ms-wmx',
        'avi' => 'video/x-msvideo',
        'ogv' => 'video/ogg',
        'movie' => 'video/x-sgi-movie',
        'ice' => 'x-conference/x-cooltalk',
        'ddoc' => 'application/x-ddoc'
    );

    protected static array $filters = [];
    protected static array $actions = [];

    /**
     * Find extension from file name
     *
     * @param string $filename
     *
     * @return  string  found extension
     */
    public static function findExt(string $filename): string
    {
        $filename = strtolower($filename);
        $exts = explode(".", $filename);

        if (count($exts) === 0) {
            return '';
        }

        return array_pop($exts);
    }

    /**
     * Find filename from file name
     *
     * @param string $filename
     *
     * @return  string  found extension
     */
    public static function findFilename(string $filename): string
    {
        $filename = basename($filename);
        $exts = explode(".", $filename);
        array_pop($exts);

        return implode('.', $exts);
    }

    /**
     * Deletes directory recursively
     *
     * @param string $dir
     * @param bool $clearOnly
     * @param bool $preserveRootDir Whether to remove root of $dir.
     *
     * @param callable|null $preCondition ($file)
     * @return boolean
     */
    public static function rmdirPath(string $dir, bool $clearOnly = false, bool $preserveRootDir = true, ?callable $preCondition = null): bool
    {
        if (!file_exists($dir)) {
            return true;
        }

        if (!is_dir($dir)) {
            return unlink($dir);
        }

        foreach (scandir($dir) as $item) {
            if ($item == '.' || $item == '..') {
                continue;
            }
            if (is_callable($preCondition)) {
                if (!$preCondition($dir . DIRECTORY_SEPARATOR . $item)) {
                    continue;
                }
            }

            self::rmdirPath($dir . DIRECTORY_SEPARATOR . $item, $clearOnly, false, $preCondition);
        }

        if (!$clearOnly && !$preserveRootDir) {
            return rmdir($dir);
        } else {
            return true;
        }
    }

    public static function clearDir(string $dir): bool
    {
        return self::rmdirPath($dir, true);
    }

    /**
     * Convert data from csv file into php array
     *
     * @param string $file
     * @param string $separator
     * @param bool $skipHeader
     * @param bool $utf8Encode
     * @return array
     * @throws \Exception
     */
    public static function csvToArray(string $file, string $separator = ',', bool $skipHeader = false, bool $utf8Encode = false): array
    {
        if (!is_readable($file)) {
            throw new \Exception('Cannot read ' . $file);
        }

        $f = fopen($file, 'r');
        $row = 0;
        $master = [];
        $header = [];
        if ($f !== false) {
            while (($data = fgetcsv($f, 0, $separator)) !== false) {
                if ($skipHeader && $row == 0) {
                    $header = $data;
                    $row++;
                    continue;
                }

                $num = count($data);
                if (empty($header)) {
                    for ($column = 0; $column < $num; $column++) {
                        $master[$row][] = $utf8Encode ? utf8_encode($data[$column]) : $data[$column];
                    }
                } else {
                    for ($column = 0; $column < $num; $column++) {
                        $master[$row][$header[$column]] = $utf8Encode ? utf8_encode($data[$column]) : $data[$column];
                    }
                }
                $row++;
            }
            fclose($f);
        }
        return $master;
    }

    /**
     * Random string generator.
     *
     * @param int $len
     * @param string $extraFeed array Can be any variable. Array with some user input recommended.
     * @param bool $allowSpecialCharacters
     *
     * @return  string  generated string
     *
     * @version 1.0 7th january 2006
     * @version 2.0 10th July 2011 - Improved randomness.
     * @version 2.5 11th July 2013 - Improved randomness. Special characters option.
     * @version 3.0 30th July 2024 - Use random_int
     */
    public static function randStr(int $len, string $extraFeed, bool $allowSpecialCharacters = false): string
    {
        $alphaNum = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789";
        $specialChars = '!"#%&/\()[]{}+-_.,:;|';

        // Base symbols set is alphanumeric characters
        $symbols = $alphaNum;

        // Optionally add special characters
        if ($allowSpecialCharacters) {
            $symbols .= $specialChars;
        }

        // Seed additional randomness
        $symbols .= $extraFeed;

        // Convert string to an array of UTF-8 characters
        $symbolsArray = preg_split('//u', $symbols, -1, PREG_SPLIT_NO_EMPTY);

        $maxIndex = count($symbolsArray) - 1;

        // Ensure the random pool is at least as large as the requested length
        $randPoolSize = max(100, $len);  // Ensure pool is large enough
        $pool = [];
        for ($i = 0; $i < $randPoolSize; $i++) {
            $randomIndex = random_int(0, $maxIndex);
            $pool[] = $symbolsArray[$randomIndex];
        }

        // Select a valid UTF-8 substring from the pool
        $randOffset = random_int(0, $randPoolSize - $len);
        $finalChars = array_slice($pool, $randOffset, $len);

        return implode('', $finalChars);
    }

    /**
     * Return one or more elements randomly from array
     *
     * @param array $arr Source array
     * @param int $num Number of elements to return
     * @return mixed Random elements
     **/
    public static function array_random(array $arr, int $num = 1): mixed
    {
        if ($num === 1) {
            // Return a single random element
            return $arr[array_rand($arr)];
        }

        if ($num >= count($arr)) {
            // If $num is greater than or equal to the array size, just shuffle and return the array
            shuffle($arr);
            return $arr;
        }

        $keys = array_rand($arr, $num);
        $results = [];
        foreach ($keys as $key) {
            $results[] = $arr[$key];
        }
        return $results;
    }

    /**
     * @return string
     */
    public static function getRequestUriStartPath(): string
    {
        if (empty($_SERVER['REQUEST_URI'])) {
            return '';
        }

        $reqUriParts = explode('/', trim($_SERVER['REQUEST_URI'], "\t\n\r\0\x0B/"));

        if (isset($reqUriParts[0])) {
            return $reqUriParts[0];
        }

        return '';
    }

    /**
     * @param array $row [name => value]
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function generatePhpConstants(array $row, string $prefix = '', string $suffix = ''): string
    {
        $lines = '';

        $santitizeName = function ($name) {
            return strtoupper(preg_replace('/[^a-z^0-9^_^\x7f-\xff][^a-z^0-9^_^\x7f-\xff]*/i', '', $name));
        };

        foreach (array_flip($row) as $name => $value) {
            $lines .= sprintf(
                "const %s%s%s = %s;\n",
                $santitizeName($prefix),
                $santitizeName($name),
                $santitizeName($suffix),
                var_export($value, true)
            );
        }

        return $lines;
    }

    /**
     * Flatten a multi-dimensional array
     *
     * @param array $array Source array
     * @return mixed flat array
     **/
    public static function array_flatten(array $array): array
    {
        $result = [];
        array_walk_recursive($array, function ($item) use (&$result) {
            $result[] = $item;
        });
        return $result;
    }

    /**
     * Get full path for currently executing script
     *
     * @param bool $full
     * @return string
     */
    public static function getWebPath(bool $full = false): string
    {
        if (isset($_SERVER['HTTPS']) and (!empty($_SERVER['HTTPS'])) and strtolower($_SERVER['HTTPS']) != 'off') {
            $https = 's';
        } else {
            $https = '';
        }
        $scriptDir = (in_array(
            dirname($_SERVER['SCRIPT_NAME']),
            array('\\', '/')
        )) ? '' : dirname($_SERVER['SCRIPT_NAME']);
        return (($full) ? 'http' . $https . '://' . $_SERVER['SERVER_NAME'] : '') . $scriptDir;
    }

    /**
     * Fixes http address.
     *
     * @param string $www
     * @return string fixed input
     * @deprecated Use Util::prependHttp() instead
     *
     */
    public static function fixHttpAddress(string $www): string
    {
        if (!str_starts_with($www, 'http://')) {
            $www = 'http://' . $www;
        }
        return $www;
    }

    /**
     * Divides string into pieces by method specified by $type
     *
     * @param string $string source
     * @param int $numberOfPieces Used with Util::DIVIDE_TEXT_EQUAL
     * @param int $pieceSize Used with Util::DIVIDE_TEXT_FILL
     * @param int $type
     *      Util::DIVIDE_TEXT_EQUAL - divides text equally over $numberOfPieces;
     *      Util::DIVIDE_TEXT_FILL - divides text into n pieces of size $pieceSize
     *
     * @return string[] Parts of source string. If source string is empty, then empty array will be returned.
     */
    public static function divideText(
        string $string,
        int $numberOfPieces,
        int $pieceSize,
        int $type = self::DIVIDE_TEXT_EQUAL
    ): array {
        $pieces = [];
        $stringLength = strlen($string);

        if ($stringLength == 0 || ($numberOfPieces == 0 && $pieceSize == 0)) {
            return $pieces;
        }

        if ($type == self::DIVIDE_TEXT_EQUAL) {
            if ($stringLength >= $numberOfPieces) {
                for ($i = 0; $i < $numberOfPieces; $i++) {
                    $pieces[] = substr(
                        $string,
                        $i * floor($stringLength / $numberOfPieces),
                        (int)ceil($stringLength / $numberOfPieces)
                    );
                }
            } else {
                // create empty pieces to avoid breaking application when reading array values
                $pieces = array_fill(0, $numberOfPieces, '');
            }
        } elseif ($type == self::DIVIDE_TEXT_FILL) {
            $numberOfFullPieces = floor($stringLength / $pieceSize);
            $reminder = $stringLength % $pieceSize;

            for ($i = 0; $i < $numberOfFullPieces; $i++) {
                $pieces[] = substr($string, $i * $pieceSize, $pieceSize);
            }
            $pieces[] = substr($string, $stringLength - $reminder);
        }

        return $pieces;
    }

    /**
     * Prepends "http://" to the string.
     *
     * @param string $string Incomplete url.
     * @return string String with preceding "http://"
     */
    public static function prependHttp(string $string): string
    {
        if (strlen($string) > 0) {
            preg_match('%(\w+)://(\S+)%', $string, $matches, PREG_OFFSET_CAPTURE);
            if (count($matches) <= 2 || $matches[1][1] !== 0) {

                if (stripos($string, '://') === 0) {
                    return 'http' . $string;
                }

                return 'http://' . $string;
            }
        }

        return $string;
    }

    /**
     * Makes link shorter by removing some components
     *
     * @param string $string Complete url
     * @param array $options
     * @return string
     */
    public static function shortenUrl(string $string, array $options = []): string
    {
        $defaultOptions = array(
            'strip-protocol' => true,
            'length' => PHP_INT_MAX,
            'soft-cut' => false,
        );
        $options = $options + $defaultOptions;

        if (strlen($string) > 0) {
            if ($options['strip-protocol'] === true) {
                preg_match('%(\w+)://(\S+)%', $string, $matches);
                if (count($matches) >= 2) {
                    $string = $matches[2];
                }
            }

            if ($options['length'] !== PHP_INT_MAX) {
                if ($options['soft-cut'] === true) {
                    if (strlen($string) > $options['length']) {
                        $string = substr($string, 0, $options['length'] - 3);
                        $string .= '...';
                    }
                } else {
                    $string = substr($string, 0, $options['length']);
                }
            }
        }

        return $string;
    }

    /**
     * @param string $content
     * @param string $keyword
     * @param int $size
     * @param string $wrapKeywordIn
     * @param string $end
     * @return string
     */
    public static function truncateAroundKeyword(
        string $content,
        string $keyword,
        int $size = 80,
        string $wrapKeywordIn = '<strong>%s</strong>',
        string $end = '...'
    ): string {
        $content = \voku\helper\UTF8::strip_tags($content);
        $pos = \voku\helper\UTF8::stripos($content, $keyword);

        if (!$pos) {
            $pos = 0;
        }

        $start = $pos - $size;
        if ($start < 0) {
            $start = 0;
        }

        $length = $size + \voku\helper\UTF8::strlen($keyword) + $size;

        $dots1 = $end;
        if ($start === 0) {
            $dots1 = '';
        }
        $dots2 = $end;
        if ($start + $length >= \voku\helper\UTF8::strlen($content)) {
            $dots2 = '';
        }
        $truncated = $dots1 . \voku\helper\UTF8::substr($content, $start, $size + \voku\helper\UTF8::strlen($keyword) + $size) . $dots2;

        $finalValue = \voku\helper\UTF8::str_ireplace($keyword, strtr($wrapKeywordIn, ['%s' => $keyword]), $truncated);
        if (is_string($finalValue)) {
            return $finalValue;
        }

        return $content;
    }

    /**
     * Truncates +text+ to the length of +length+ and replaces the last three characters with the +truncate_string+
     * if the +text+ is longer than +length+.
     *
     * @param string $text
     * @param int $length
     * @param string $end
     * @return string
     */
    public static function truncateText(string $text, int $length = 30, string $end = '...'): string
    {
        if (\voku\helper\UTF8::strlen($text) > $length) {
            $truncatedText = \voku\helper\UTF8::substr(\voku\helper\UTF8::trim($text), 0, $length - \voku\helper\UTF8::strlen($end));

            return $truncatedText . $end;
        }

        return $text;
    }

    /**
     * Extract person name into $nrOfParts parts(first name, last name[, or more]).
     *
     * @param string $name
     * @param int $nrOfParts
     * @return array
     * @example John Smith -> 2 ==> ['John', 'Smith']
     * @example John Smith Wesson -> 2 ==> ['John', 'Smith'], 4 ==> ['John', 'Smith', 'Wesson', '']
     * @example John -> ['John', '']
     *
     */
    public static function explodeName(string $name, int $nrOfParts = 2): array
    {
        $parts = [];
        if (strlen($name) > 0) {
            $nameParts = preg_split('/[ \t\r\n]+/i', $name, $nrOfParts);
            if ($nameParts) {
                for ($i = 0; $i < $nrOfParts; $i++) {
                    if (isset($nameParts[$i])) {
                        $parts[$i] = $nameParts[$i];
                    } else {
                        $parts[$i] = '';
                    }
                }
            }
        }

        return $parts;
    }

    public static function cleanupArray(array &$array, array $stripedFieldNames, int $level = 1, int $recursionLimit = 50): void
    {
        foreach ($array as $key => &$value) {
            if (isset($stripedFieldNames[$key]) && $stripedFieldNames[$key]) {
                unset($array[$key]);
                continue;
            }

            if (is_array($value) && $level <= $recursionLimit) {
                self::cleanupArray($value, $stripedFieldNames, $level + 1);
            }
        }
    }

    /**
     * Util for file size
     *
     * @param int $size File size in bytes
     * @param string $sep
     * @return string Converted file size with unit
     */
    public static function fileSize(int $size, string $sep = ' '): string
    {
        $unit = null;
        $units = array('B', 'KB', 'MB', 'GB', 'TB');

        for ($i = 0, $c = count($units); $i < $c; $i++) {
            if ($size > 1024) {
                $size = $size / 1024;
            } else {
                $unit = $units[$i];
                break;
            }
        }

        return round($size, 2) . $sep . $unit;
    }

    public static function guessMime(string $file, string $defaultType = 'application/octet-stream'): string
    {
        if (!is_readable($file)) {
            return $defaultType;
        }

        if (isset(self::$extensionToType[self::findExt($file)])) {
            return self::$extensionToType[self::findExt($file)];
        }

        if (class_exists('\finfo')) {
            if (!$finfo = new \finfo(FILEINFO_MIME)) {
                return $defaultType;
            }

            $type = $finfo->file($file);

            // remove charset (added as of PHP 5.3)
            if (false !== $pos = strpos($type, ';')) {
                $type = substr($type, 0, $pos);
            }

            return $type;
        }


        return $defaultType;
    }

    public static function iniGetBytes(string $key): float
    {
        $val = ini_get($key);
        $val = trim($val);
        $last = strtolower($val[strlen($val) - 1]);
        switch ($last) {
            // The 'G' modifier is available since PHP 5.1.0
            case 'g':
                $val *= 1024;
            case 'm':
                $val *= 1024;
            case 'k':
                $val *= 1024;
        }

        return $val;
    }

    public static function arrayFlatten(array $a1, string $parentKey = '', int $level = 1, array $except = [])
    {
        $flat = [];
        foreach ($a1 as $k => $v) {
            if (in_array($k, $except)) {
                $flat[$parentKey . $k] = $v;
                continue;
            }

            if (is_array($v)) {
                if ($level <= 50) {
                    $flat += self::arrayFlatten($v, $parentKey . $k . '___', $level++, $except);
                }
            } else {
                $flat[$parentKey . $k] = $v;
            }
        }

        return $flat;
    }

    public static function parseYoutubeUrl(string $url): ?string
    {
        $pattern = '#^(?:https?://)?'; # Optional URL scheme. Either http or https.
        $pattern .= '(?:www\.)?'; #  Optional www subdomain.
        $pattern .= '(?:'; #  Group host alternatives:
        $pattern .= 'youtu\.be/'; #    Either youtu.be,
        $pattern .= '|youtube\.com'; #    or youtube.com
        $pattern .= '(?:'; #    Group path alternatives:
        $pattern .= '/embed/'; #      Either /embed/,
        $pattern .= '|/v/'; #      or /v/,
        $pattern .= '|/watch\?v='; #      or /watch?v=,
        $pattern .= '|/watch\?.+&v='; #      or /watch?other_param&v=
        $pattern .= ')'; #    End path alternatives.
        $pattern .= ')'; #  End host alternatives.
        $pattern .= '([\w-]{11})'; # 11 characters (Length of Youtube video ids).
        $pattern .= '(?:.+)?$#x'; # Optional other ending URL parameters.
        preg_match($pattern, $url, $matches);
        return (isset($matches[1])) ? $matches[1] : null;
    }


    public static function parseEmailAddressIntoArray(string $address): array
    {
        $emails = [];

        if (preg_match_all('/\s*"?([^><,"]+)"?\s*((?:<[^><,]+>)?)\s*/', $address, $matches, PREG_SET_ORDER) > 0) {
            foreach ($matches as $m) {
                if (!empty($m[2])) {
                    $emails[trim($m[2], '<>')] = $m[1];
                } else {
                    $emails[$m[1]] = '';
                }
            }
        }

        return $emails;
    }

    public static function trimmedStrlen(string $str): int
    {
        return (int)\voku\helper\UTF8::strlen(\voku\helper\UTF8::trim($str));
    }

    public static function autoParagraph(string $text): string
    {
        if (!preg_match('%(<p[^>]*>.*?</p>)%i', $text)) {
            return sprintf('<p class="util-autoParagraph">%s</p>', $text);
        } else {
            return $text;
        }
    }

    public static function isHttpsRequest(): bool
    {
        return isset($_SERVER['HTTPS']) && strlen($_SERVER['HTTPS']) > 0 && $_SERVER['HTTPS'] != 'off';
    }

    public static function singlelinefy(string $text): string
    {
        return strip_tags(str_replace(array("\n", "\r"), ' ', $text));
    }

    public static function floatval($value): float
    {
        if (is_float($value)) {
            return $value;
        }

        return floatval(str_replace(',', '.', (string)$value));
    }

    public static function clamp($min, $max, $currentValue)
    {
        if (!is_numeric($min) || !is_numeric($max) || !is_numeric($currentValue)) {
            throw new \InvalidArgumentException('All inputs must be numeric!');
        }

        return max($min, min($max, $currentValue));
    }

    public static function autoPrependSlash(string $url, string $slash = '/'): string
    {
        if (stripos($url, $slash) !== 0) {
            $url = $slash . $url;
        }

        return $url;
    }

    public static function autoAppendSlash(string $url, string $slash = '/'): string
    {
        if (!str_ends_with($url, $slash)) {
            $url .= $slash;
        }

        return $url;
    }

    public static function rotateTableArray(array $array, ?string $field = null): array
    {
        if (empty($array)) {
            // Return the original array if it is empty.
            return $array;
        }

        $firstKey = array_key_first($array);
        if (!is_array($array[$firstKey])) {
            // Return the original array if the first element is not an array, indicating it's not multidimensional.
            return $array;
        }

        $newArray = [];
        foreach ($array as $i => $level1) {
            if (!is_array($level1)) {
                continue; // Skip if the inner element is not an array.
            }
            foreach ($level1 as $j => $level2) {
                if ($field !== null && isset($level2[$field])) {
                    // Use the specified field as the key if it exists in the sub-array.
                    $newArray[$level2[$field]][$i] = $level2;
                } else {
                    $newArray[$j][$i] = $level2;
                }
            }
        }
        return $newArray;
    }

    public static function replaceEmpty(string $value, string $replacer = '-'): string
    {
        if (empty($value)) {
            return $replacer;
        } else {
            return $value;
        }
    }

    public static function deepCount(array $array = []): int
    {
        $count = 0;
        foreach ($array as $item) {
            $count++;
            if (is_array($item)) {
                $count += self::deepCount($item);
            }
        }

        return $count;
    }

    public static function isExternalUrl(string $url): bool
    {
        $url = trim($url);
        if (strlen($url) == 0) {
            throw new \InvalidArgumentException('Empty url');
        }

        if (stripos($url, 'skype:') !== false || preg_match('/www\.\w+\.(com|ee|org|net)/i', $url)) {
            return true;
        }

        // not external
        if (!preg_match('/^[A-Za-z]+:\/\//i', $url) && stripos($url, '@') === false && !preg_match('/[\w\.]+\/\w+([\w\.])*/i', $url)) {
            return false;
        }

        // find if local path
        preg_match('%[/\\\]*\w+[/\\\]+%i', $url, $result, PREG_OFFSET_CAPTURE);
        if (preg_match('/^file:\/\//i', $url) || isset($result[0][1]) && $result[0][1] === 0) {
            return false;
        }

        $regex =
            '%(https|http|ftp)\:\/\/|([a-z0-9A-Z]+\.[a-z0-9A-Z]+\.[a-zA-Z]{2,4})|([a-z0-9A-Z]+\.[a-zA-Z]{2,4})|\?([a-zA-Z0-9]+[\&\=\#a-z]+)%i'; // Anchor
        if (preg_match($regex, $url, $result)) {
            return true;
        }

        return false;
    }

    /**
     *
     * Credits http://stackoverflow.com/a/632786
     *
     * @param string $file
     * @return bool
     */
    public static function isTextFile(string $file): bool
    {
        if (!file_exists($file) || !is_readable($file)) {
            return false;
        }
        // return mime type ala mimetype extension
        $finfo = finfo_open(FILEINFO_MIME);
        $mimeType = finfo_file($finfo, $file);
        finfo_close($finfo);

        if (str_starts_with($mimeType, 'text')) {
            return true;
        }

        $firstBytes = file_get_contents($file, false, null, 0, 512);
        $firstBytes = str_replace(["\t", "\r", "\n"], ' ', $firstBytes);

        return ctype_print($firstBytes);
    }

    /**
     * Strips selected tags. If no tag given, all tags will be stripped.
     *
     * Credits https://stackoverflow.com/questions/3491353/php-regex-remove-font-tag/3491371#3491371
     * Modified by Tormi
     *
     * @param string $str
     * @param array $tags
     * @param bool $stripContent
     * @return string
     */
    public static function stripSelectedTags(string $str, array $tags = [], bool $stripContent = false): string
    {
        if (count($tags) == 0) {
            return strip_tags($str);
        }
        $content = '';
        foreach ($tags as $tag) {
            if ($stripContent) {
                $content = '(.+</*' . $tag . '>*)';
            }
            $str = preg_replace('#</?' . $tag . '[^>]*>' . $content . '#is', '', $str);
        }
        return $str;
    }

    public static function randFloat(float $min, float $max, int $decimals = 2): float
    {
        $step = pow(10, $decimals);
        return round(mt_rand((int)($min * $step), (int)($max * $step)) / $step, $decimals);
    }


    // WordPress like actions and filters logic
    public static function addFilter(string $tag, callable $callback): void
    {
        self::$filters[$tag] ??= [];
        self::$filters[$tag][] = $callback;
    }

    public static function applyFilters(string $tag, mixed $value): mixed
    {
        if (empty(self::$filters[$tag])) {
            return $value;
        }

        foreach (self::$filters[$tag] as $callback) {
            $value = $callback($value) ?? $value;
        }

        return $value;
    }

    public static function addAction(string $tag, callable $callback): void
    {
        self::$actions[$tag] ??= [];
        self::$actions[$tag][] = $callback;
    }

    public static function applyActions(string $tag, ...$args): void
    {
        if (empty(self::$actions[$tag])) {
            return;
        }

        foreach (self::$actions[$tag] as $callback) {
            $callback(...$args);
        }
    }

    public static function isSerialised(string $value): bool
    {
        if (empty($value)) {
            return false;
        }

        if (str_starts_with($value, 'N;')) {
            return true;
        }

        return preg_match('/([a|b|c|d|o|r]{1}):\d+/i', $value);
    }


    /**
     * // code from php at moechofe dot com (array_merge comment on php.net)
     * // used in sfToolkit
     *
     * // Added hack to prevent merging certain subarrays(___doNotMerge)
     *
     * array arrayDeepMerge ( array array1 [, array array2 [, array ...]] )
     *
     * Like array_merge
     *
     *  arrayDeepMerge() merges the elements of one or more arrays together so
     * that the values of one are appended to the end of the previous one. It
     * returns the resulting array.
     *  If the input arrays have the same string keys, then the later value for
     * that key will overwrite the previous one. If, however, the arrays contain
     * numeric keys, the later value will not overwrite the original value, but
     * will be appended.
     *  If only one array is given and the array is numerically indexed, the keys
     * get reindexed in a continuous way.
     *
     * Different from array_merge
     *  If string keys have arrays for values, these arrays will merge recursively.
     */
    public static function arrayMergeDeep(): array
    {
        switch (func_num_args()) {
            case 0:
                return [];
            case 1:
                return func_get_arg(0);
            case 2:
                $args = func_get_args();
                $args[2] = [];
                if (is_array($args[0]) && is_array($args[1])) {
                    if (isset($args[0]['___doNotMerge'])) {
                        if ($args[0]['___doNotMerge'] == true) {
                            unset($args[0]['___doNotMerge']);
                            return $args[0];
                        } else {
                            unset($args[0]['___doNotMerge']);
                        }
                    }
                    if (isset($args[1]['___doNotMerge']) && $args[1]['___doNotMerge'] == true) {
                        unset($args[1]['___doNotMerge']);
                        return $args[1];
                    }
                    foreach (array_unique(array_merge(array_keys($args[0]), array_keys($args[1]))) as $key) {
                        $isKey0 = array_key_exists($key, $args[0]);
                        $isKey1 = array_key_exists($key, $args[1]);
                        if ($isKey0 && $isKey1 && is_array($args[0][$key]) && is_array($args[1][$key])) {
                            $args[2][$key] = self::arrayMergeDeep($args[0][$key], $args[1][$key]);
                        } elseif ($isKey0 && $isKey1) {
                            $args[2][$key] = $args[1][$key];
                        } elseif (!$isKey1) {
                            $args[2][$key] = $args[0][$key];
                        } elseif (!$isKey0) {
                            $args[2][$key] = $args[1][$key];
                        }
                    }
                    return $args[2];
                } else {
                    return $args[1];
                }
            default :
                $args = func_get_args();
                $args[1] = self::arrayMergeDeep($args[0], $args[1]);
                array_shift($args);

                return self::arrayMergeDeep(...$args); // !! PHP 5.6 feature
        }
    }

    /**
     * Run a workload on number of items by range.
     *
     * @param int $itemsCount
     * @param callable $workload ($offset, $batchSize)
     * @param int $batchSize
     * @param int $initialOffset
     */
    public static function runBatchAction(int $itemsCount, callable $workload, int $batchSize, int $initialOffset = 0): void
    {
        $offset = $initialOffset;

        while ($offset < $itemsCount) {
            if ($workload($offset, $batchSize) === false) {
                break;
            }

            $offset += $batchSize;
        }
    }

}



