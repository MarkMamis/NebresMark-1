<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: StudentsModel
 * 
 * Automatically generated via CLI.
 */
class StudentsModel extends Model {
    protected $table = 'students';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function create($first_name, $last_name) {
        $data = array(
            'first_name' => $first_name,
            'last_name'  => $last_name
        );
        return $this->db->table($this->table)->insert($data);
    }

    public function update($id, $data) {
        // Only allow first_name and last_name to be updated
        $allowed = ['first_name', 'last_name'];
        $filtered = array_intersect_key($data, array_flip($allowed));
        
        // Make sure we have data to update
        if (empty($filtered)) {
            return false;
        }
        
        return $this->db->table($this->table)
                       ->where('id', $id)
                       ->update($filtered);
    }

    public function delete($id) {
        return $this->db->table($this->table)
                       ->where('id', $id)
                       ->update(['deleted_at' => date('Y-m-d H:i:s')]);
    }
    
    public function soft_delete($id) {
        return $this->delete($id);
    }
    
    public function restore($id) {
        return $this->db->table($this->table)
                      ->where('id', $id)
                      ->update(['deleted_at' => NULL]);
    }

    public function getAllStudents()
    {
        return $this->db->table($this->table)->where_null('deleted_at')->get_all();
    }
    
    public function getDeletedStudents()
    {
        return $this->db->table($this->table)->where_not_null('deleted_at')->get_all();
    }

    public function getStudentById($id)
    {
        return $this->db->table($this->table)
                       ->where('id', $id)
                       ->get();
    }

    public function getNewStudentsCount()
    {
    // No created_at column, so just count all students not deleted
    $result = $this->db->table($this->table)
        ->where_null('deleted_at')
        ->get_all();
    return count($result);
    }

    public function getLatestStudents($limit = 5)
    {
        return $this->db->table($this->table)
                       ->where_null('deleted_at')
                       ->order_by('id', 'DESC')
                       ->limit($limit)
                       ->get_all();
    }

    public function getStudentsWithPagination($search = '', $per_page = 10, $page = 1)
    {
        // Create the base query
        $query = $this->db->table($this->table)->where_null('deleted_at');
        
        // Apply search filter if provided
        if (!empty($search)) {
            $query->like('id', '%'.$search.'%')
                  ->or_like('first_name', '%'.$search.'%')
                  ->or_like('last_name', '%'.$search.'%');
        }
        
        // Clone the query before pagination to get total count
        $countQuery = clone $query;
        
        // Get total records for pagination
        $total_rows = $countQuery->select_count('*', 'count')->get()['count'];
        
        // Get paginated records
        $records = $query->order_by('id', 'ASC')
                         ->pagination($per_page, $page)
                         ->get_all();
        
        return [
            'records' => $records,
            'total_rows' => $total_rows
        ];
    }
    
    public function getDeletedStudentsWithPagination($search = '', $per_page = 10, $page = 1)
    {
        // Create the base query
        $query = $this->db->table($this->table)->where_not_null('deleted_at');
        
        // Apply search filter if provided
        if (!empty($search)) {
            $query->like('id', '%'.$search.'%')
                  ->or_like('first_name', '%'.$search.'%')
                  ->or_like('last_name', '%'.$search.'%');
        }
        
        // Clone the query before pagination to get total count
        $countQuery = clone $query;
        
        // Get total records for pagination
        $total_rows = $countQuery->select_count('*', 'count')->get()['count'];
        
        // Get paginated records
        $records = $query->order_by('deleted_at', 'DESC')
                         ->pagination($per_page, $page)
                         ->get_all();
        
        return [
            'records' => $records,
            'total_rows' => $total_rows
        ];
    }
}