<?php

/**
 * Class DataBase
 * @author icefog <icefog.s.a@gmail.com>
 * @package Hammer
 */

defined('APP') or die();

class DataBase {

    /**
     * @var mysqli
     */
    private $conn;

    /**
     * @var
     */
    private $stats;

    /**
     * @var
     */
    private $emode;

    /**
     * @var
     */
    private $exname;

    /**
     * @const
     */
    const RESULT_ASSOC = MYSQLI_ASSOC;

    /**
     * @const
     */
    const RESULT_NUM = MYSQLI_NUM;

    /**
     * DataBase constructor.
     */
    function __construct() {
        $opt = include PATH . '/config/db-config.php';
        $this->emode = $opt['errmode'];
        $this->exname = $opt['exception'];

        if ($opt['pconnect']) {
            $opt['host'] = "p:" . $opt['host'];
        }

        @$this->conn = mysqli_connect($opt['host'], $opt['user'], $opt['pass'], $opt['db'], $opt['port'], $opt['socket']);
        if (!$this->conn) {
            $this->error(mysqli_connect_errno() . " " . mysqli_connect_error());
        }

        mysqli_set_charset($this->conn, $opt['charset']) or $this->error(mysqli_error($this->conn));
        unset($opt);
    }

    /**
     * @return bool|mysqli_result
     */
    public function query() {
        return $this->rawQuery($this->prepareQuery(func_get_args()));
    }

    /**
     * @param $result
     * @param int $mode
     * @return array|null
     */
    public function fetch($result, $mode = self::RESULT_ASSOC) {
        return mysqli_fetch_array($result, $mode);
    }

    /**
     * @return int
     */
    public function affectedRows() {
        return mysqli_affected_rows($this->conn);
    }

    /**
     * @return int|string
     */
    public function insertId() {
        return mysqli_insert_id($this->conn);
    }

    /**
     * @param $result
     * @return int
     */
    public function numRows($result) {
        return mysqli_num_rows($result);
    }

    /**
     * @param $result
     */
    public function free($result) {
        mysqli_free_result($result);
    }

    /**
     * @return bool|mixed
     */
    public function getOne() {
        $query = $this->prepareQuery(func_get_args());
        if ($res = $this->rawQuery($query)) {
            $row = $this->fetch($res);
            if (is_array($row)) {
                return reset($row);
            }
            $this->free($res);
        }
        return FALSE;
    }

    /**
     * @return array|bool|null
     */
    public function getRow() {
        $query = $this->prepareQuery(func_get_args());
        if ($res = $this->rawQuery($query)) {
            $ret = $this->fetch($res);
            $this->free($res);
            return $ret;
        }
        return FALSE;
    }

    /**
     * @return array
     */
    public function getCol() {
        $ret = array();
        $query = $this->prepareQuery(func_get_args());
        if ($res = $this->rawQuery($query)) {
            while ($row = $this->fetch($res)) {
                $ret[] = reset($row);
            }
            $this->free($res);
        }
        return $ret;
    }

    /**
     * @return array
     */
    public function getAll() {
        $ret = array();
        $query = $this->prepareQuery(func_get_args());
        if ($res = $this->rawQuery($query)) {
            while ($row = $this->fetch($res)) {
                $ret[] = $row;
            }
            $this->free($res);
        }
        return $ret;
    }

    /**
     * @return array
     */
    public function getInd() {
        $args = func_get_args();
        $index = array_shift($args);
        $query = $this->prepareQuery($args);

        $ret = array();
        if ($res = $this->rawQuery($query)) {
            while ($row = $this->fetch($res)) {
                $ret[$row[$index]] = $row;
            }
            $this->free($res);
        }
        return $ret;
    }

    /**
     * @return array
     */
    public function getIndCol() {
        $args = func_get_args();
        $index = array_shift($args);
        $query = $this->prepareQuery($args);

        $ret = array();
        if ($res = $this->rawQuery($query)) {
            while ($row = $this->fetch($res)) {
                $key = $row[$index];
                unset($row[$index]);
                $ret[$key] = reset($row);
            }
            $this->free($res);
        }
        return $ret;
    }

    /**
     * @return string
     */
    public function parse() {
        return $this->prepareQuery(func_get_args());
    }

    /**
     * @param $input
     * @param $allowed
     * @param bool $default
     * @return bool
     */
    public function whiteList($input, $allowed, $default = FALSE) {
        $found = array_search($input, $allowed);
        return ($found === FALSE) ? $default : $allowed[$found];
    }

    /**
     * @param $input
     * @param $allowed
     * @return mixed
     */
    public function filterArray($input, $allowed) {
        foreach (array_keys($input) as $key) {
            if (!in_array($key, $allowed)) {
                unset($input[$key]);
            }
        }
        return $input;
    }

    /**
     * @return mixed
     */
    public function lastQuery() {
        $last = end($this->stats);
        return $last['query'];
    }

    /**
     * @return mixed
     */
    public function getStats() {
        return $this->stats;
    }

    /**
     * @param $query
     * @return bool|mysqli_result
     */
    private function rawQuery($query) {
        $start = microtime(TRUE);
        $res = mysqli_query($this->conn, $query);
        $timer = microtime(TRUE) - $start;

        $this->stats[] = array(
            'query' => $query,
            'start' => $start,
            'timer' => $timer,
        );
        if (!$res) {
            $error = mysqli_error($this->conn);

            end($this->stats);
            $key = key($this->stats);
            $this->stats[$key]['error'] = $error;
            $this->cutStats();

            $this->error("$error. Full query: [$query]");
        }
        $this->cutStats();
        return $res;
    }

    /**
     * @param $args
     * @return string
     */
    private function prepareQuery($args) {
        $query = '';
        $raw = array_shift($args);
        $array = preg_split('~(\?[nsiuap])~u', $raw, null, PREG_SPLIT_DELIM_CAPTURE);
        $anum = count($args);
        $pnum = floor(count($array) / 2);
        if ($pnum != $anum) {
            $this->error("Number of args ($anum) doesn't match number of placeholders ($pnum) in [$raw]");
        }

        foreach ($array as $i => $part) {
            if (($i % 2) == 0) {
                $query .= $part;
                continue;
            }

            $value = array_shift($args);
            switch ($part) {
                case '?n':
                    $part = $this->escapeIdent($value);
                    break;
                case '?s':
                    $part = $this->escapeString($value);
                    break;
                case '?i':
                    $part = $this->escapeInt($value);
                    break;
                case '?a':
                    $part = $this->createIN($value);
                    break;
                case '?u':
                    $part = $this->createSET($value);
                    break;
                case '?p':
                    $part = $value;
                    break;
            }
            $query .= $part;
        }
        return $query;
    }

    /**
     * @param $value
     * @return bool|string
     */
    private function escapeInt($value) {
        if ($value === NULL) {
            return 'NULL';
        }
        if (!is_numeric($value)) {
            $this->error("Integer (?i) placeholder expects numeric value, " . gettype($value) . " given");
            return FALSE;
        }
        if (is_float($value)) {
            $value = number_format($value, 0, '.', '');
        }
        return $value;
    }

    /**
     * @param $value
     * @return string
     */
    private function escapeString($value) {
        if ($value === NULL) {
            return 'NULL';
        }
        return "'" . mysqli_real_escape_string($this->conn, $value) . "'";
    }

    /**
     * @param $value
     * @return string
     */
    private function escapeIdent($value) {
        if ($value) {
            return "`" . str_replace("`", "``", $value) . "`";
        } else {
            $this->error("Empty value for identifier (?n) placeholder");
        }
    }

    /**
     * @param $data
     * @return string|void
     */
    private function createIN($data) {
        if (!is_array($data)) {
            $this->error("Value for IN (?a) placeholder should be array");
            return;
        }
        if (!$data) {
            return 'NULL';
        }
        $query = $comma = '';
        foreach ($data as $value) {
            $query .= $comma . $this->escapeString($value);
            $comma = ",";
        }
        return $query;
    }

    /**
     * @param $data
     * @return string|void
     */
    private function createSET($data) {
        if (!is_array($data)) {
            $this->error("SET (?u) placeholder expects array, " . gettype($data) . " given");
            return;
        }
        if (!$data) {
            $this->error("Empty array for SET (?u) placeholder");
            return;
        }
        $query = $comma = '';
        foreach ($data as $key => $value) {
            $query .= $comma . $this->escapeIdent($key) . '=' . $this->escapeString($value);
            $comma = ",";
        }
        return $query;
    }

    /**
     * @param $err
     */
    private function error($err) {
        $err = __CLASS__ . ": " . $err;

        if ($this->emode == 'error') {
            $err .= ". Error initiated in " . $this->caller() . ", thrown";
            trigger_error($err, E_USER_ERROR);
        } else {
            throw new $this->exname($err);
        }
    }

    /**
     * @return string
     */
    private function caller() {
        $trace = debug_backtrace();
        $caller = '';
        foreach ($trace as $t) {
            if (isset($t['class']) && $t['class'] == __CLASS__) {
                $caller = $t['file'] . " on line " . $t['line'];
            } else {
                break;
            }
        }
        return $caller;
    }

    /**
     * @return void
     */
    private function cutStats() {
        if (count($this->stats) > 100) {
            reset($this->stats);
            $first = key($this->stats);
            unset($this->stats[$first]);
        }
    }
}