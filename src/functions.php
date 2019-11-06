<?php
/**
 * Permission is hereby granted, free of charge, to any person obtaining a
 * copy of this software and associated documentation files (the "Software"),
 * to deal in the Software without restriction, including without limitation
 * the rights to use, copy, modify, merge, publish, distribute, sublicense,
 * and/or sell copies of the Software, and to permit persons to whom the
 * Software is furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS
 * IN THE SOFTWARE.
 *
 * @category   Laemmi\MysqlToMysqliWrapper
 * @author     Michael Lämmlein <laemmi@spacerabbit.de>
 * @copyright  ©2019 laemmi
 * @license    http://www.opensource.org/licenses/mit-license.php MIT-License
 * @version    1.0.0
 * @since      05.11.2019
 */

require_once __DIR__ . '/Wrapper/MysqliWrapper.php';

use Laemmi\MysqlToMysqliWrapper\Wrapper\MysqliWrapper;

// Make sure the MySQL extension is not loaded and there is no other drop in replacement active
if (! extension_loaded('mysql') && ! function_exists('mysql_connect')) {

    // Validate if the MySQLi extension is present
    if (! extension_loaded('mysqli')) {
        trigger_error('The extension "MySQLi" is not available', E_USER_ERROR);
    }

    // Define MySQL constants
    define('MYSQL_CLIENT_COMPRESS',     MYSQLI_CLIENT_COMPRESS);
    define('MYSQL_CLIENT_IGNORE_SPACE', MYSQLI_CLIENT_IGNORE_SPACE);
    define('MYSQL_CLIENT_INTERACTIVE',  MYSQLI_CLIENT_INTERACTIVE);
    define('MYSQL_CLIENT_SSL',          MYSQLI_CLIENT_SSL);

    define('MYSQL_ASSOC', MYSQLI_ASSOC);
    define('MYSQL_NUM',   MYSQLI_NUM);
    define('MYSQL_BOTH',  MYSQLI_BOTH);

    /**
     * Open a connection to a MySQL Server
     *
     * @param string $server
     * @param string $username
     * @param string $password
     * @param $new_link
     * @param $client_flags
     *
     * @return mysqli|bool
     */
    function mysql_connect($server = '', $username = '', $password = '', $new_link = false, $client_flags = 0)
    {
        return MysqliWrapper::getInstance()->connect($server, $username, $password);
    }

    /**
     * Open a persistent connection to a MySQL server
     *
     * @param string $server
     * @param string $username
     * @param string $password
     * @param $client_flags
     *
     * @return mysqli|bool
     */
    function mysql_pconnect($server = '', $username = '', $password = '', $client_flags = 0)
    {
        return MysqliWrapper::getInstance()->pconnect($server, $username, $password);
    }

    /**
     * Select a MySQL database
     *
     * @param $database_name
     * @param $mysqli
     *
     * @return bool
     */
    function mysql_select_db($database_name, mysqli $mysqli = null) : bool
    {
        return MysqliWrapper::getInstance($mysqli)->select_db($database_name);
    }

    /**
     * Send a MySQL query
     *
     * @param $query
     * @param mysqli|null $mysqli
     *
     * @return bool|mysqli_result
     */
    function mysql_query($query, mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->query($query);
    }

    /**
     * Escapes special characters in a string for use in an SQL statement
     *
     * @param $string
     * @param mysqli|null $mysqli
     *
     * @return string
     */
    function mysql_real_escape_string($string, mysqli $mysqli = null) : string
    {
        return MysqliWrapper::getInstance($mysqli)->escape_string($string);
    }

    /**
     * Escapes a string for use in a mysql_query
     *
     * @param $string
     *
     * @return string
     */
    function mysql_escape_string($string) : string
    {
        return MysqliWrapper::getInstance()->escape_string($string);
    }

    /**
     * Fetch a result row as an associative array
     *
     * @param mysqli_result $result
     *
     * @return bool|array
     */
    function mysql_fetch_assoc(mysqli_result $result)
    {
        $result = $result->fetch_assoc();
        if (null === $result) {
            $result = false;
        }

        return $result;
    }

    /**
     * Fetch a result row as an object
     *
     * @param mysqli_result $result
     *
     * @return object|stdClass
     */
    function mysql_fetch_object(mysqli_result $result)
    {
        $result = $result->fetch_object();
        if (null === $result) {
            $result = false;
        }

        return $result;
    }

    /**
     * Get number of rows in result
     *
     * @param mysqli_result $result
     *
     * @return bool|int
     */
    function mysql_num_rows(mysqli_result $result)
    {
        $result = $result->num_rows;
        if (null === $result) {
            $result = false;
        }

        return $result;
    }

    /**
     * Get a result row as an enumerated array
     *
     * @param mysqli_result $result
     *
     * @return bool|array
     */
    function mysql_fetch_row(mysqli_result $result)
    {
        $result = $result->fetch_row();
        if (null === $result) {
            $result = false;
        }

        return $result;
    }

    /**
     * Get number of affected rows in previous MySQL operation
     *
     * @param mysqli|null $mysqli
     *
     * @return int
     */
    function mysql_affected_rows(mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->affected_rows;
    }

    /**
     * Returns the name of the character set
     *
     * @param mysqli|null $mysqli
     *
     * @return void
     */
    function mysql_client_encoding(mysqli $mysqli = null)
    {
        MysqliWrapper::getInstance($mysqli)->character_set_name();
    }

    /**
     * Close MySQL connection
     *
     * @param mysqli|null $mysqli
     *
     * @return bool
     */
    function mysql_close(mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->close();
    }

    /**
     * Create a MySQL database
     *
     * @param $database_name
     * @param mysqli|null $mysqli
     *
     * @return bool
     */
    function mysql_create_db($database_name, mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->create_db($database_name);
    }

    /**
     * Returns the numerical value of the error message from previous MySQL operation
     *
     * @param mysqli|null $mysqli
     *
     * @return int
     */
    function mysql_errno(mysqli $mysqli = null) : int
    {
        return MysqliWrapper::getInstance($mysqli)->errno;
    }

    /**
     * Retrieves database name from the call to mysql_list_dbs()
     *
     * @param mysqli_result $result
     * @param int $row
     * @param null $field
     *
     * @return bool
     */
    function mysql_db_name(mysqli_result $result, int $row, $field = null)
    {
        $result->data_seek($row);
        $row = $result->fetch_row();
        if (! isset($row[$field])) {
            return false;
        }

        return $row[$field];
    }

    /**
     * Returns the text of the error message from previous MySQL operation
     *
     * @param mysqli|null $mysqli
     *
     * @return string
     */
    function mysql_error(mysqli $mysqli = null) : string
    {
        return MysqliWrapper::getInstance($mysqli)->error;
    }

    /**
     * Fetch a result row as an associative array, a numeric array, or both
     *
     * @param mysqli_result $result
     * @param $result_type
     *
     * @return void
     */
    function mysql_fetch_array(mysqli_result $result, $result_type = MYSQL_BOTH)
    {
        return $result->fetch_array($result_type);
    }

    /**
     * Ping a server connection or reconnect if there is no connection
     *
     * @param mysqli|null $mysqli
     *
     * @return bool
     */
    function mysql_ping(mysqli $mysqli = null) : bool
    {
        return MysqliWrapper::getInstance($mysqli)->ping();
    }

    /**
     * Send an SQL query to MySQL without fetching and buffering the result rows
     *
     * @param $query
     * @param mysqli|null $mysqli
     *
     * @return mixed
     */
    function mysql_unbuffered_query($query, mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->query($query, MYSQLI_USE_RESULT);
    }

    /**
     * Get MySQL client info
     *
     * @return string
     */
    function mysql_get_client_info() : string
    {
        return MysqliWrapper::getInstance()->get_client_info();
    }

    /**
     * Free result memory
     *
     * @param mysqli_result $result
     *
     * @return void
     */
    function mysql_free_result(mysqli_result $result)
    {
        $result->free();
    }

    /**
     * List databases available on a MySQL server
     *
     * @param mysqli|null $mysqli
     *
     * @return bool|mysqli_result
     */
    function mysql_list_dbs(mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->list_dbs();
    }

    /**
     * List MySQL table fields
     *
     * @param $database_name
     * @param $table_name
     * @param mysqli|null $mysqli
     *
     * @return bool|mysqli_result
     */
    function mysql_list_fields($database_name, $table_name, mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->list_fields($database_name, $table_name);
    }

    /**
     * List MySQL processes
     *
     * @param mysqli|null $mysqli
     *
     * @return bool|mysqli_result
     */
    function mysql_list_processes(mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->list_processes();
    }

    /**
     * Sets the client character set
     *
     * @param $charset
     * @param mysqli|null $mysqli
     *
     * @return bool
     */
    function mysql_set_charset($charset, mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->set_charset($charset);
    }

    /**
     * Get information about the most recent query
     *
     * @param mysqli|null $mysqli
     *
     * @return bool|string
     */
    function mysql_info(mysqli $mysqli = null)
    {
        $result = MysqliWrapper::getInstance($mysqli)->info;
        if (null === $result) {
            return false;
        }

        return $result;
    }

    /**
     * Get current system status
     *
     * @param mysqli|null $mysqli
     *
     * @return bool|string
     */
    function mysql_stat(mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->stat;
    }

    /**
     * Return the current thread ID
     *
     * @param mysqli|null $mysqli
     *
     * @return bool|string
     */
    function mysql_thread_id(mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->thread_id;
    }

    /**
     * Get MySQL host info
     *
     * @param mysqli|null $mysqli
     *
     * @return bool|string
     */
    function mysql_get_host_info(mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->host_info;
    }

    /**
     * Get MySQL protocol info
     *
     * @param mysqli|null $mysqli
     *
     * @return bool|string
     */
    function mysql_get_proto_info(mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->protocol_version;
    }

    /**
     * Get MySQL server info
     *
     * @param mysqli|null $mysqli
     *
     * @return bool|string
     */
    function mysql_get_server_info(mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->server_info;
    }

    /**
     * Get table name of field
     *
     * @param mysqli_result $result
     * @param $i
     *
     * @return string|bool
     */
    function mysql_tablename(mysqli_result $result, $i)
    {
        $result->data_seek($i);
        $row = $result->fetch_array();
        if (! isset($row[0])) {
            return false;
        }

        return $row[0];
    }

    /**
     * Get the ID generated in the last query
     *
     * @param mysqli|null $mysqli
     *
     * @return int|string
     */
    function mysql_insert_id(mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->insert_id;
    }

    /**
     * Get result data
     *
     * @param mysqli_result $result
     * @param $row
     * @param int $field
     *
     * @return mixed
     */
    function mysql_result(mysqli_result $result, $row, $field = 0)
    {
        $result->data_seek($row);
        $row = $result->fetch_array();
        if (! isset($row[$field])) {
            return false;
        }

        return $row[$field];
    }

    /**
     * Get number of fields in result
     *
     * @param mysqli_result $result
     *
     * @return int
     */
    function mysql_num_fields(mysqli_result $result)
    {
        return $result->field_count;
    }

    /**
     * List tables in a MySQL database
     *
     * @param $database_name
     * @param mysqli|null $mysqli
     *
     * @return bool|string
     */
    function mysql_list_tables($database_name, mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->list_tables($database_name);
    }

    /**
     * Get column information from a result and return as an object
     *
     * @param mysqli_result $result
     * @param int $field_offset
     *
     * @return bool|object
     */
    function mysql_fetch_field(mysqli_result $result, $field_offset = 0)
    {
        if ($field_offset) {
            $result->field_seek($field_offset);
        }

        return $result->fetch_field();
    }

    /**
     * Returns the length of the specified field
     *
     * @param mysqli_result $result
     * @param int $field_offset
     *
     * @return bool
     */
    function mysql_field_len(mysqli_result $result, $field_offset = 0)
    {
        $info = $result->fetch_field_direct($field_offset);
        return is_object($info) ? $info->length : false;
    }

    /**
     * Drop (delete) a MySQL database
     *
     * @param $database_name
     * @param mysqli|null $mysqli
     *
     * @return bool
     */
    function mysql_drop_db($database_name, mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->drop_db($database_name);
    }

    /**
     * Move internal result pointer
     *
     * @param mysqli_result $result
     * @param int $row_number
     *
     * @return void
     */
    function mysql_data_seek(mysqli_result $result, $row_number = 0)
    {
        $result->data_seek($row_number);
    }

    /**
     * Get the name of the specified field in a result
     *
     * @param mysqli_result $result
     * @param $field_offset
     *
     * @return bool
     */
    function mysql_field_name(mysqli_result $result, $field_offset = 0)
    {
        $info = $result->fetch_field_direct($field_offset);
        return is_object($info) ? $info->name : false;
    }

    /**
     * Get the length of each output in a result
     *
     * @param mysqli_result $result
     *
     * @return array|bool
     */
    function mysql_fetch_lengths(mysqli_result $result)
    {
        return $result->lengths;
    }

    /**
     * Get the type of the specified field in a result
     *
     * @param mysqli_result $result
     * @param $field_offset
     *
     * @return string
     */
    function mysql_field_type(mysqli_result $result, $field_offset = 0)
    {
        $unknown = 'unknown';
        $info = $result->fetch_field_direct($field_offset);
        if (empty($info->type)) {
            return $unknown;
        }

        switch ($info->type) {
            case MYSQLI_TYPE_FLOAT:
            case MYSQLI_TYPE_DOUBLE:
            case MYSQLI_TYPE_DECIMAL:
            case MYSQLI_TYPE_NEWDECIMAL:
                return 'real';

            case MYSQLI_TYPE_BIT:
                return 'bit';

            case MYSQLI_TYPE_TINY:
                return 'tinyint';

            case MYSQLI_TYPE_TIME:
                return 'time';

            case MYSQLI_TYPE_DATE:
                return 'date';

            case MYSQLI_TYPE_DATETIME:
                return 'datetime';

            case MYSQLI_TYPE_TIMESTAMP:
                return 'timestamp';

            case MYSQLI_TYPE_YEAR:
                return 'year';

            case MYSQLI_TYPE_STRING:
            case MYSQLI_TYPE_VAR_STRING:
                return 'string';

            case MYSQLI_TYPE_SHORT:
            case MYSQLI_TYPE_LONG:
            case MYSQLI_TYPE_LONGLONG:
            case MYSQLI_TYPE_INT24:
                return 'int';

            case MYSQLI_TYPE_CHAR:
                return 'char';

            case MYSQLI_TYPE_ENUM:
                return 'enum';

            case MYSQLI_TYPE_TINY_BLOB:
            case MYSQLI_TYPE_MEDIUM_BLOB:
            case MYSQLI_TYPE_LONG_BLOB:
            case MYSQLI_TYPE_BLOB:
                return 'blob';

            case MYSQLI_TYPE_null:
                return 'null';

            case MYSQLI_TYPE_NEWDATE:
            case MYSQLI_TYPE_INTERVAL:
            case MYSQLI_TYPE_SET:
            case MYSQLI_TYPE_GEOMETRY:
            default:
                return $unknown;
        }
    }

    /**
     * Get name of the table the specified field is in
     *
     * @param mysqli_result $result
     * @param $field_offset
     *
     * @return bool
     */
    function mysql_field_table(mysqli_result $result, $field_offset = 0)
    {
        $info = $result->fetch_field_direct($field_offset);
        return is_object($info) ? $info->table : false;
    }

    /**
     * Get the flags associated with the specified field in a result
     *
     * @param mysqli_result $result
     * @param int $field_offset
     *
     * @return bool
     */
    function mysql_field_flags(mysqli_result $result, $field_offset = 0)
    {
        $finfo = $result->fetch_field_direct($field_offset);

        $mysqliflags = [
            MYSQLI_NOT_null_FLAG            => 'not_null',
            MYSQLI_PRI_KEY_FLAG             => 'primary_key',
            MYSQLI_UNIQUE_KEY_FLAG          => 'unique_key',
            MYSQLI_MULTIPLE_KEY_FLAG        => 'multiple_key',
            MYSQLI_BLOB_FLAG                => 'blob',
            MYSQLI_UNSIGNED_FLAG            => 'unsigned',
            MYSQLI_ZEROFILL_FLAG            => 'zerofill',
            MYSQLI_AUTO_INCREMENT_FLAG      => 'auto_increment',
            MYSQLI_TIMESTAMP_FLAG           => 'timestamp',
            MYSQLI_SET_FLAG                 => 'set',
            MYSQLI_NUM_FLAG                 => 'num',
            MYSQLI_PART_KEY_FLAG            => 'part_key',
            MYSQLI_GROUP_FLAG               => 'group',
            MYSQLI_ENUM_FLAG                => 'enum',
            MYSQLI_BINARY_FLAG              => 'binary',
            MYSQLI_NO_DEFAULT_VALUE_FLAG    => 'no_default_value',
            MYSQLI_ON_UPDATE_NOW_FLAG       => 'on_update_now',
        ];

        $return = [];
        foreach ($mysqliflags as $flag => $flag_value) {
            if ($finfo->flags & $flag) {
                $return[] = $flag_value;
            }
        }

        return implode(' ', $return);
    }

    /**
     * Set result pointer to a specified field offset
     *
     * @param mysqli_result $result
     * @param int $field_offset
     *
     * @return bool
     */
    function mysql_field_seek(mysqli_result $result, $field_offset = 0)
    {
        return $result->field_seek($field_offset);
    }

    /**
     * Selects a database and executes a query on it
     *
     * @param $database
     * @param $query
     * @param mysqli|null $mysqli
     *
     * @return bool
     */
    function mysql_db_query($database, $query, mysqli $mysqli = null)
    {
        return MysqliWrapper::getInstance($mysqli)->db_query($database, $query);
    }
}
