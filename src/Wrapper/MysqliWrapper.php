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

namespace Laemmi\MysqlToMysqliWrapper\Wrapper;

use mysqli;

class MysqliWrapper
{
    /**
     * @var null
     */
    private static $instance = null;

    /**
     * @var mysqli
     */
    private $mysqli;

    /**
     * Get instance
     *
     *  @param mysqli|null $mysqli
     *
     * @return static
     */
    public static function getInstance(mysqli $mysqli = null) : self
    {
        if ($mysqli instanceof mysqli) {
            return new self($mysqli);
        }

        if (! self::$instance instanceof self) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Wrapper constructor.
     *
     * @param mysqli|null $mysqli
     */
    private function __construct(mysqli $mysqli = null)
    {
        $this->mysqli = $mysqli;
    }

    /**
     * @param $name
     * @param $arguments
     *
     * @return mixed
     */
    public function __call($name, $arguments)
    {
        return call_user_func_array([$this->mysqli, $name], $arguments);
    }

    /**
     * Opens a connection to the MySQL Server
     *
     * @param string $server
     * @param string $username
     * @param string $password
     *
     * @return mysqli
     */
    public function connect(string $server = '', string $username = '', string $password = '') : mysqli
    {
        $server   = $server ? $server : ini_get("mysqli.default_host");
        $username = $username ? $username : ini_get("mysqli.default_user");
        $password = $password ? $password : ini_get("mysqli.default_pw");

        $this->mysqli = new mysqli($server, $username, $password);

        return $this->mysqli;
    }

    /**
     * Open a persistent connection to a MySQL server
     *
     * @param string $server
     * @param string $username
     * @param string $password
     *
     * @return mysqli
     */
    public function pconnect(string $server = '', string $username = '', string $password = '') : mysqli
    {
        return $this->connect('p:' . $server, $username, $password);
    }

    /**
     * @param $database_name
     * @param $table_name
     *
     * @return mixed
     */
    public function list_fields($database_name, $table_name)
    {
        return $this->query(sprintf('SHOW COLUMNS FROM %s.%s', $this->escape_string($database_name), $this->escape_string($table_name)));
    }

    /**
     * @param $database_name
     *
     * @return mixed
     */
    public function list_tables($database_name)
    {
        return $this->query(sprintf('SHOW TABLES FROM %s', $this->escape_string($database_name)));
    }

    /**
     * @param $database
     * @param $query
     *
     * @return mixed
     */
    public function db_query($database, $query)
    {
        $this->select_db($database);

        return $this->query($query);
    }

    /**
     * @param $database_name
     *
     * @return mixed
     */
    public function drop_db($database_name)
    {
        return $this->query(sprintf('DROP DATABASE %s', $this->escape_string($database_name)));
    }

    /**
     * @param $database_name
     *
     * @return mixed
     */
    public function create_db($database_name)
    {
        return $this->query(sprintf('CREATE DATABASE %s', $this->escape_string($database_name)));
    }

    /**
     * @return mixed
     */
    public function list_dbs()
    {
        return $this->query('SHOW DATABASES');
    }

    /**
     * @return mixed
     */
    public function list_processes()
    {
        return $this->query('SHOW PROCESSLIST');
    }
}