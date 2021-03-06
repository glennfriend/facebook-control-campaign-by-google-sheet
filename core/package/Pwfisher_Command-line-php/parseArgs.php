<?php
/**
 * parseArgs Command Line Interface (CLI) utility function.
 * @author              Patrick Fisher <patrick@pwfisher.com>
 * @see                 https://github.com/pwfisher/CommandLine.php
 */
function parseArgs($argv = null) {
    $argv = $argv ? $argv : $_SERVER['argv']; array_shift($argv); $o = array();
    for ($i = 0, $j = count($argv); $i < $j; $i++) { $a = $argv[$i];
        if (substr($a, 0, 2) == '--') { $eq = strpos($a, '=');
            if ($eq !== false) { $o[substr($a, 2, $eq - 2)] = substr($a, $eq + 1); }
            else { $k = substr($a, 2);
                if ($i + 1 < $j && $argv[$i + 1][0] !== '-') { $o[$k] = $argv[$i + 1]; $i++; }
                else if (!isset($o[$k])) { $o[$k] = true; } } }
        else if (substr($a, 0, 1) == '-') {
            if (substr($a, 2, 1) == '=') { $o[substr($a, 1, 1)] = substr($a, 3); }
            else {
                foreach (str_split(substr($a, 1)) as $k) { if (!isset($o[$k])) { $o[$k] = true; } }
                if ($i + 1 < $j && $argv[$i + 1][0] !== '-') { $o[$k] = $argv[$i + 1]; $i++; } } }
        else { $o[] = $a; } }
    return $o;
}
