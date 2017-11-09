<?php

class mysql {
	private $connection;

        function __construct ($mysql) {
                $this->connection = mysql_connect ($mysql['host'],$mysql['user'],$mysql['pass']);
                mysql_select_db($mysql['db']);
        }

	function clean ($text) {
                return mysql_real_escape_string($text);
        }

	function error () {
                return mysql_error();
        }

	function g ($sql) {
		return $this->get($sql);
	}

	function get ($sql) {
		return $this->results( $this->query($sql) );
	}

	function n ($query) {
		return $this->num($query);
	}

	function num ($query) {
                return mysql_num_rows($query);
        }
	function q ($sql) {
                return $this->query($sql);
        }

	function query ($sql) {
                return mysql_query($sql, $this->connection);
        }

	function r ($query) {
                return $this->results($query);
        }

	function results ($query) {
                $results = array();
                $i = 0;

                while ($result = mysql_fetch_assoc($query))
                        $results[$i++] = $result;

                return $results;
        }

	function close () {
                mysql_close($this->connection);
        }

}

