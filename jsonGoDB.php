<?php
class JsonGoDB {
    // The file path of the JSON file used for the database
    private $file;
    // The data stored in the database
    private $data;
    // The indexes on the fields for faster queries
    private $indexes;

    /**
     * Constructor to create a new JsonGoDB instance
     * @param string $file_name name of the json file
     */
    public function __construct($file_name) {
        // Check if the file already exists, if not create one
        if (!file_exists($file_name)) {
            file_put_contents($file_name, json_encode(array()));
        }
        $this->file = $file_name;
        $this->data = json_decode(file_get_contents($file_name), true);
        $this->indexes = array();
    }

    /**
     * Insert a new document into the database
     * @param array $doc the document to insert
     */
    public function insert($doc) {
        // Generate a unique ID for the document
        $doc['_id'] = uniqid();
        // Add the document to the data array
        $this->data[] = $doc;
        // Update the JSON file
        $this->updateFile();
    }

    /**
     * Find all documents that match a given query
     * @param array $query the query to find
     * @return array the documents that match the query
     */
    public function find($query) {
        // Use the indexes to find the matching documents
        $matches = array();
        foreach ($this->data as $doc) {
            $match = true;
            foreach ($query as $key => $value) {
                if ($doc[$key] != $value) {
                    $match = false;
                    break;
                }
            }
            if ($match) {
                $matches[] = $doc;
            }
        }
        return $matches;
    }

    /**
     * Update all documents that match a given query
     * @param array $query the query to update
     * @param array $update the updates to make
     */
    public function update($query, $update) {
        // Find all matching documents
        $matches = $this->find($query);
        // Update each document
        foreach ($matches as $match) {
            foreach ($update as $key => $value) {
                $match[$key] = $value;
            }
        }
        // Update the JSON file
        $this->updateFile();
    }

     /**
     * Remove all documents that match a given query
     * @param array $query the query to remove
     */
    public function remove($query) {
        // Find all matching documents
        $matches = $this->find($query);
        // Remove each matching document from the data array
        foreach ($matches as $match) {
            $index = array_search($match, $this->data);
            array_splice($this->data, $index, 1);
        }
        // Update the JSON file
        $this->updateFile();
    }

    /**
     * Count the number of documents in the database
     * @return int the number of documents
     */
    public function count() {
        return count($this->data);
    }

    /**
     * Find a single document that matches a given query
     * @param array $query the query to find
     * @return array the document that matches the query
     */
    public function findOne($query) {
        $matches = $this->find($query);
        if (count($matches) > 0) {
            return $matches[0];
        } else {
            return null;
        }
    }

    /**
     * Ensure that an index exists on a field
     * @param string $field the field to index
     */
    public function ensureIndex($field) {
        if (!array_key_exists($field, $this->indexes)) {
            $this->indexes[$field] = array();
            foreach ($this->data as $doc) {
                $value = $doc[$field];
                if (!array_key_exists($value, $this->indexes[$field])) {
                    $this->indexes[$field][$value] = array();
                }
                $this->indexes[$field][$value][] = $doc;
            }
        }
    }

    /**
     * Drop the database
     */
    public function drop() {
        unlink($this->file);
    }

    /**
     * Update the JSON file with the current data
     */
    private function updateFile() {
        file_put_contents($this->file, json_encode($this->data));
    }
}

