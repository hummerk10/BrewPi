<?php

class mysql {
	private $connection;

        function __construct ($mysql) {
                $this->connection = mysqli_connect ($mysql['host'],$mysql['user'],$mysql['pass'],$mysql['db']);
                mysqli_select_db($this->connection,$mysql['db']);
        }

	function clean ($text) {
                return mysqli_real_escape_string($text);
        }

	function error () {
                return mysqli_error();
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
                return mysqli_num_rows($query);
        }
	function q ($sql) {
                return $this->query($sql);
        }

	function query ($sql) {
                return mysqli_query( $this->connection,$sql);
        }

	function r ($query) {
                return $this->results($query);
        }

	function results ($query) {
                $results = array();
                $i = 0;

                while ($result = mysqli_fetch_assoc($query))
                        $results[$i++] = $result;

                return $results;
        }

	function close () {
                mysqli_close($this->connection);
        }

}

