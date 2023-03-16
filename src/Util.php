<?php

/**
 * General utility functions
 * Since 2005
 *
 * PHP5
 *
 * @version 0.1 7th December 2009
 * @version 1.0 28th August 2011
 * @version 1.1 1st November 2011 Start of versioning. __() now returns source text if Symfony's I18N fails.
 *                                Deprecated ambiguous fixHttpAddress() function.
 * @version 1.1.1 6th November 2011 __() checks if I18N is enabled.
 * @version 2.0 27th February 2015 Namespaced. Cleanup.
 * @version 2.5 29th July 2015 Cleanup of legacy dependencies.
 * @version 3.0 16th March 2023 Cleanup of legacy dependencies.
 *
 * @todo Write unit tests.
 *
 * @copyright Tormi Talv
 */
declare(strict_types=1);

namespace Tormit\Helper;

use Tormit\Helper\Enums\PrependHttp as EnumPrependHttp;

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
        $fileInfo = new \SplFileInfo($filename);
        return $fileInfo->getExtension();
    }

    /**
     * Find filename from file name
     *
     * @param string $filename
     *
     * @return  string  found filename without extension
     */
    public static function findFilename(string $filename): string
    {
        $fileInfo = new \SplFileInfo($filename);
        return $fileInfo->getBasename('.' . self::findExt($filename));
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
     * @param int $length
     * @param string|null $extraFeed
     * @param bool $includeSpecialChars
     * @return  string  generated string
     *
     * @throws \Exception
     * @version 1.0 7th january 2006
     * @version 2.0 10th July 2011 - Improved randomness.
     * @version 2.5 11th July 2013 - Improved randomness. Special characters option.
     * @version 2.5 11th July 2013 - Improved randomness. Special characters option.
     * @version 3.0 11th July 2023 - Using random_bytes from PHP 7.0+
     */
    public static function randStr(int $length = 32, ?string $extraFeed = null, bool $includeSpecialChars = true): string
    {
        if ($length <= 0) {
            throw new \InvalidArgumentException('Length must be a positive integer.');
        }

        $characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        if ($includeSpecialChars) {
            $characters .= '!@#$%^&*()-_=+[]{}|;:,.<>?';
        }
        if ($extraFeed) {
            $characters .= $extraFeed;
        }

        $charactersLength = strlen($characters);
        $randomBytes = random_bytes($length);
        $randomString = '';

        for ($i = 0; $i < $length; ++$i) {
            $randomString .= $characters[ord($randomBytes[$i]) % $charactersLength];
        }

        return $randomString;
    }

    /**
     * Return one or more elements randomly from array
     *
     * @param array $inputArray Source array
     * @param int $count Number of elements to return
     * @return mixed Random elements
     **/
    public static function array_random(array $inputArray, int $count = 1): mixed
    {
        if ($count <= 0) {
            throw new \InvalidArgumentException('Count must be a positive integer.');
        }

        if ($count > count($inputArray)) {
            return null;
        }

        $pickedElements = [];
        $arrayLength = count($inputArray);

        for ($i = 0; $i < $count; $i++) {
            $randomIndex = random_int($i, $arrayLength - 1);
            if ($randomIndex !== $i) {
                $pickedElements[$i] = $pickedElements[$randomIndex] ?? $inputArray[$randomIndex];
            }
            $pickedElements[$randomIndex] = $inputArray[$i];
        }

        return $count === 1 ? $pickedElements[0] : array_slice($pickedElements, 0, $count);
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
     * @param array<string, string> $row [name => value]
     * @param string $prefix
     * @param string $suffix
     * @return string
     */
    public static function generatePhpConstants(array $row, string $prefix = '', string $suffix = ''): string
    {
        $constants = "";

        foreach ($row as $key => $value) {
            $constantName = strtoupper(self::sanitizeConstantName($prefix . $key . $suffix));
            $constantValue = var_export($value, true);
            $constants .= "const {$constantName} = {$constantValue};\n";
        }

        return $constants;
    }

    private static function sanitizeConstantName(string $name): string
    {
        return preg_replace('/[^a-zA-Z0-9_]/', '', $name);
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
        } else if ($type == self::DIVIDE_TEXT_FILL) {
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
     * @param string $url Incomplete url.
     * @return string String with preceding "http://"
     */
    public static function prependHttp(string $url, EnumPrependHttp $useHttps = EnumPrependHttp::False): string
    {
        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            return $url;
        }

        if ($useHttps === EnumPrependHttp::Auto && self::isHttpsRequest()) {
            $useHttps = EnumPrependHttp::True;
        }

        if ($useHttps === EnumPrependHttp::True) {
            return 'https://' . $url;
        } else {
            return 'http://' . $url;
        }
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
     * @return string
     */
    public static function truncateAroundKeyword(string $content, string $keyword, int $size = 80): string
    {
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

        $dots1 = '...';
        if ($start === 0) {
            $dots1 = '';
        }
        $dots2 = '...';
        if ($start + $length >= \voku\helper\UTF8::strlen($content)) {
            $dots2 = '';
        }
        $truncated = $dots1 . \voku\helper\UTF8::substr($content, $start, $size + \voku\helper\UTF8::strlen($keyword) + $size) . $dots2;

        $finalValue = \voku\helper\UTF8::str_ireplace($keyword, "<strong>$keyword</strong>", $truncated);
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
     * @param string $delimiter
     * @return string
     */
    public static function truncateText(string $text, int $length = 30, string $delimiter = '...'): string
    {
        if (\voku\helper\UTF8::strlen($text) > $length) {
            $truncatedText = \voku\helper\UTF8::substr(\voku\helper\UTF8::trim($text), 0, $length - \voku\helper\UTF8::strlen($delimiter));

            return $truncatedText . $delimiter;
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
     * @param int $bytes File size in bytes
     * @param string $sep
     * @return string Converted file size with unit
     */
    public static function fileSize(int $bytes, string $sep = ' '): string
    {
        if ($bytes < 0) {
            throw new \InvalidArgumentException('Bytes must be a non-negative integer.');
        }

        $units = ['B', 'KiB', 'MiB', 'GiB', 'TiB', 'PiB', 'EiB', 'ZiB', 'YiB'];
        $unitIndex = 0;

        while ($bytes >= 1024 && $unitIndex < count($units) - 1) {
            $bytes /= 1024;
            $unitIndex++;
        }

        return sprintf('%.2f%s%s', $bytes, $sep, $units[$unitIndex]);
    }

    public static function guessMime(string $filePath, string $defaultType = 'application/octet-stream'): string
    {
        // Attempt to get the MIME type using the Fileinfo extension
        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($filePath);

        // If the MIME type was successfully retrieved, return it
        if ($mimeType !== false) {
            return $mimeType;
        }

        // Attempt to get the MIME type based on the file extension
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);

        if (array_key_exists($extension, self::$extensionToType)) {
            return self::$extensionToType[$extension];
        }

        // Return the default MIME type if the MIME type could not be determined
        return $defaultType;
    }

    public static function iniGetBytes(string $key): float
    {
        $iniValue = ini_get($key);
        $iniValue = trim($iniValue);
        $lastChar = strtolower($iniValue[strlen($iniValue) - 1]);

        // Remove the last character if it's a unit (K, M, or G)
        if (in_array($lastChar, ['k', 'm', 'g'])) {
            $iniValue = substr($iniValue, 0, -1);
        }

        // Convert the value to bytes based on the unit
        switch ($lastChar) {
            case 'g':
                $iniValue *= 1024;
            // Fall through intended
            case 'm':
                $iniValue *= 1024;
            // Fall through intended
            case 'k':
                $iniValue *= 1024;
        }

        return $iniValue;
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
        // Ignore CLI executions
        if (PHP_SAPI === 'cli') {
            return false;
        }

        // Check for common server variables indicating HTTPS
        if (isset($_SERVER['HTTPS']) && strtolower($_SERVER['HTTPS']) !== 'off') {
            return true;
        }

        // Check for cloud provider-specific variables
        if (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && strtolower($_SERVER['HTTP_X_FORWARDED_PROTO']) === 'https') {
            return true;
        }

        if (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && strtolower($_SERVER['HTTP_X_FORWARDED_SSL']) === 'on') {
            return true;
        }

        if (isset($_SERVER['HTTP_X_ARR_SSL']) || isset($_SERVER['HTTP_X_SSL'])) {
            return true;
        }

        // Default to false if no indication of HTTPS is found
        return false;
    }

    public static function singlelinefy(string $text): string
    {
        return strip_tags(preg_replace('/\s+/', ' ', trim($text)));
    }

    public static function floatval(string|int|float|null $string): float
    {
        if (!$string) {
            return 0.0;
        }

        // Replace commas with periods
        $string = str_replace(',', '.', (string)$string);

        return floatval($string);
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

    #[\JetBrains\PhpStorm\Pure]
    public static function autoAppendSlash(string $url, string $slash = '/'): string
    {
        if (!\Illuminate\Support\Str::endsWith($url, $slash)) {
            $url = $url . $slash;
        }

        return $url;
    }

    public static function rotateTableArray(array $array, ?string $field = null): array
    {
        if (!is_array(reset($array))) { // not multidimensional
            return $array;
        }
        $newArray = [];
        foreach ($array as $i => $level1) {
            foreach ($level1 as $j => $level2) {
                if ($field !== null) {
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
     * @param string $filePath
     * @return bool
     */
    public static function isTextFile(string $filePath): bool
    {
        if (!file_exists($filePath) || !is_readable($filePath)) {
            return false;
        }

        $finfo = new \finfo(FILEINFO_MIME_TYPE);
        $mimeType = $finfo->file($filePath);

        return (str_starts_with($mimeType, 'text/'));
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
        if ($min >= $max) {
            throw new \InvalidArgumentException('The $min parameter must be less than the $max parameter.');
        }

        $factor = 10 ** $decimals;
        $randomInt = mt_rand((int)($min * $factor), (int)($max * $factor));

        return round($randomInt / $factor, $decimals);
    }


    public static function addFilter(string $tag, callable $callback): void
    {
        if (!isset(self::$filters[$tag])) {
            self::$filters[$tag] = [];
        }

        self::$filters[$tag][] = $callback;
    }

    public static function applyFilters(string $tag, $value)
    {
        if (isset(self::$filters[$tag]) && is_array(self::$filters[$tag])) {
            foreach (self::$filters[$tag] as $callback) {
                $ret = call_user_func($callback, $value);
                if ($ret !== null) {
                    $value = $ret;
                }
            }
        }

        return $value;
    }

    public static function addAction(string $tag, callable $callback): void
    {
        if (!isset(self::$actions[$tag])) {
            self::$actions[$tag] = [];
        }

        self::$actions[$tag][] = $callback;
    }

    public static function applyActions(string $tag): void
    {
        if (isset(self::$actions[$tag]) && is_array(self::$actions[$tag])) {
            $args = func_get_args();
            foreach (self::$actions[$tag] as $callback) {
                call_user_func_array($callback, array_splice($args, 1));
            }
        }
    }

    public static function parseDomain(string $url): string
    {
        $subTlds = array(
            'co' => 1,
            'com' => 1,
            'org' => 1,
            'net' => 1,
        );

        $host = parse_url($url, PHP_URL_HOST);
        $hostParts = explode('.', $host);

        $domain = '';
        if (count($hostParts) >= 2) {
            if (isset($subTlds[$hostParts[count($hostParts) - 2]])) {
                if (count($hostParts) >= 3) {
                    $domain = $hostParts[count($hostParts) - 3] . '.' . $hostParts[count($hostParts) - 2] . '.' . $hostParts[count($hostParts) - 1];
                }
            } else {
                $domain = $hostParts[count($hostParts) - 2] . '.' . $hostParts[count($hostParts) - 1];
            }
        }

        return $domain;
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
                        } else if ($isKey0 && $isKey1) {
                            $args[2][$key] = $args[1][$key];
                        } else if (!$isKey1) {
                            $args[2][$key] = $args[0][$key];
                        } else if (!$isKey0) {
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



