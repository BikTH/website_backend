<?php
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP
 *
 * This content is released under the MIT License (MIT)
 *
 * Copyright (c) 2014 - 2019, British Columbia Institute of Technology
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 *
 * @package	CodeIgniter
 * @author	EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2014, EllisLab, Inc. (https://ellislab.com/)
 * @copyright	Copyright (c) 2014 - 2019, British Columbia Institute of Technology (https://bcit.ca/)
 * @license	https://opensource.org/licenses/MIT	MIT License
 * @link	https://codeigniter.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model Class
 *
 * @package		CodeIgniter
 * @subpackage	Libraries
 * @category	Libraries
 * @author		EllisLab Dev Team
 * @link		https://codeigniter.com/user_guide/libraries/config.html
 */
class CI_Model {

	/**
	 * Class constructor
	 *
	 * @link	https://github.com/bcit-ci/CodeIgniter/issues/5332
	 * @return	void
	 */
	public function __construct() {}

	/**
	 * __get magic
	 *
	 * Allows models to access CI's loaded classes using the same
	 * syntax as controllers.
	 *
	 * @param	string	$key
	 */
	public function __get($key)
	{
		// Debugging note:
		//	If you're here because you're getting an error message
		//	saying 'Undefined Property: system/core/Model.php', it's
		//	most likely a typo in your model code.
		return get_instance()->$key;
	}

}




class Mydatabase extends CI_Model{
    protected $base; /* Custom PDO variable */
    protected $data;
    function __construct(){
        parent::__construct();

        $this->base = $this->dbconnect();
    }

    protected function dbconnect(){
        $host = $this->config->item("host");
        $database = $this->config->item("database");
        $username = $this->config->item("username");
        $password = $this->config->item("password");

        try{
            $pdo = new PDO("mysql:host=$host;dbname=$database", $username, $password);
            return $pdo;

        } catch ( Exception $error ){
            die("Error : ".$error->getMessage());
        }
    }

    /**
     * @param $table
     * @param $data
     * @return mixed
     */
    public function insertData($table, $data){
        $this->db->insert($table, $data);
        return $this->db->insert_id();
    }


    /**
     * @param $table
     * @param $where
     */
    public function deleteData($table, $where){
        $this->db->delete($table, $where );
    }


    /**
     * @param $data
     * @param $where
     * @param $table
     * @return mixed
     */
    public function updateData($data, $where, $table, $replace = false){
        $this->db->where($where);
        if( !$replace )
            $this->db->update($table, $data);
        else
            $this->db->replace($table, $data);

        return $this->db->affected_rows();
    }


    /**
     * @param $query
     * @return mixed
     */
    public function execQuery($query, $oneResult = false){
        $query = $this->db->query($query);
        if( !$oneResult )
            return $query->result();
        else
            return $query->last_row();
    }

    public function countQuery($query){
        $query = $this->db->query($query);
        //$query = $this->db->count_all_results();
        return $query->count_all_results();
    }

    /**
     * @param $table
     * @param $where
     * @param string $what
     * @return mixed
     */
    public function getthis($table, $where, $what = "*"){
        $this->db->select($what)->from($table)->where( $where );
        $query = $this->db->get();
        return $query->last_row();
    }

    /**
     * @param $table
     * @param string $what
     * @return mixed
     */
    public function get($table, $what = "*"){
        $this->db->select($what)->from($table);
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * @param $table
     * @param string $where
     * @param string $what
     * @return mixed
     */
    public function getwhere($table, $where = "", $what = "*", $limit ="999", $orderby = "", $direction = "asc"){
        if( $where == "" )
            $this->db->limit($limit)->order_by($orderby, $direction)->select($what)->from($table);
        else{
            $this->db->limit($limit)->order_by($orderby, $direction)->select($what)->from($table)->where( $where );
        }
        $query = $this->db->get();
        return $query->result();
    }


    /**
     * @param $table
     * @param string $where
     * @param string $what
     * @return mixed
     */
    public function sumWhere($table, $where = "", $what = "*"){
        if( $where == "" )
            $this->db->select_sum( $what )->from( $table );
        else{
            $this->db->select_sum( $what )->from( $table );
            $this->db->where( $where );
        }
        $query = $this->db->get();
        return $query->result();
    }

    /**
     * @param $table
     * @param string $where
     * @param string $what
     * @return mixed
     */
    public function countWhere($table, $where = "", $what = "*"){
        if( $where == "" )
            $this->db->from( $table );
        else{
            $this->db->where( $where );
            $this->db->from( $table );
        }
        $query = $this->db->count_all_results();
        return $query;
    }
}
