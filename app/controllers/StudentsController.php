<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: StudentsController
 * 
 * Automatically generated via CLI.
 */
class StudentsController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->database();
        $this->call->model('StudentsModel');
        $this->call->library('form_validation');
        $this->call->helper(['url', 'alert']);
    }

    public function home()
    {
        $this->call->view('home');
    }

    public function dashboard()
    {
        // Get latest 5 students for the table
        $data['students'] = $this->StudentsModel->getLatestStudents(5);
        // Get total count of all active students
        $data['total_students'] = count($this->StudentsModel->getAllStudents());
        // Get count of new students (added in the last 7 days)
        $data['new_students_count'] = $this->StudentsModel->getNewStudentsCount();
        $this->call->view('dashboard', $data);
    }

    public function index()
    {
        // Redirect to paginated students view
        redirect('students');
    }

    public function display($id){
        $student = $this->StudentsModel->getStudentById($id);
        if ($student) {
            $data['user'] = array($student);
        } else {
            $data['user'] = array();
        }
        $this->call->view('StudentsView', $data);
    }

    public function add() {
        // Check if the request is POST
        if ($this->io->method() === 'post') {
            $this->form_validation
                ->name('first_name')
                ->required()
                ->min_length(2);
            $this->form_validation
                ->name('last_name')
                ->required()
                ->min_length(2);

            if ($this->form_validation->run()) {
                $first_name = $this->io->post('first_name');
                $last_name = $this->io->post('last_name');

                if ($this->StudentsModel->create($first_name, $last_name)) {
                    redirect('students');
                } else {
                    set_flash_alert('danger', 'Student was not added successfully.');
                    redirect('students/add');
                }
            } else {
                $errors = $this->form_validation->get_errors();
                $data['error'] = implode('<br>', $errors);
                $this->call->view('add_student', $data);
            }
        } else {
            $this->call->view('add_student');
        }
    }
    public function edit($id) {
        if ($this->io->method() === 'post') {
            $this->form_validation
                ->name('first_name')
                ->required()
                ->min_length(2);
            $this->form_validation
                ->name('last_name')
                ->required()
                ->min_length(2);

            if ($this->form_validation->run()) {
                $data = array(
                    'first_name' => $this->io->post('first_name'),
                    'last_name'  => $this->io->post('last_name')
                );

                if ($this->StudentsModel->update($id, $data)) {
                    set_flash_alert('success', 'Student was updated successfully!');
                    redirect('students');
                } else {
                    set_flash_alert('danger', 'Failed to update student.');
                    redirect('students/edit/' . $id);
                }
            } else {
                $errors = $this->form_validation->get_errors();
                $data['error'] = implode('<br>', $errors);
                $data['student'] = $this->StudentsModel->getStudentById($id);
                $this->call->view('edit_student', $data);
            }
        } else {
            $data['student'] = $this->StudentsModel->getStudentById($id);
            if (!$data['student']) {
                set_flash_alert('danger', 'Student not found.');
                redirect('students');
            }
            $this->call->view('edit_student', $data);
        }
    }

    public function delete($id) {
        if ($this->StudentsModel->soft_delete($id)) {
            set_flash_alert('success', 'Student was deleted successfully!');
        } else {
            set_flash_alert('danger', 'Failed to delete student.');
        }
        redirect('students');
    }
    
    public function pagination_test() {
        
        // Get the current page number
        $page = 1;
        if(isset($_GET['page']) && !empty($_GET['page'])) {
            $page = (int)$this->io->get('page');
        }
        
        // Get search query if any
        $search = '';
        if(isset($_GET['search']) && !empty($_GET['search'])) {
            $search = trim($this->io->get('search'));
        }
        
        // Set records per page
        $records_per_page = 10;
        if(isset($_GET['show']) && !empty($_GET['show'])) {
            $records_per_page = (int) $this->io->get('show');
        }
        
        // Get students with pagination
        $result = $this->StudentsModel->getStudentsWithPagination($search, $records_per_page, $page);
        $data['students'] = $result['records'];
        $total_rows = $result['total_rows'];
        
        // Configure pagination
        $this->pagination->set_options([
            'first_link'     => '«',
            'last_link'      => '»',
            'next_link'      => '›',
            'prev_link'      => '‹',
            'page_delimiter' => '&page='
        ]);
        
        // Set the theme and initialize
        $this->pagination->set_theme('bootstrap');
        $base_url = site_url('students/');  // Using the route we've confirmed exists
        $url_params = "?search=$search&show=$records_per_page";
        $this->pagination->initialize($total_rows, $records_per_page, $page, $base_url.$url_params);
        
        // Generate pagination links
        $data['pagination'] = $this->pagination->paginate();
        
        // Pass additional data to the view
        $data['search'] = $search;
        $data['records_per_page'] = $records_per_page;
        $data['total_rows'] = $total_rows;
        $data['current_page'] = $page;
        $data['showing_start'] = ($page - 1) * $records_per_page + 1;
        if($total_rows == 0) {
            $data['showing_start'] = 0;
        }
        $data['showing_end'] = min($page * $records_per_page, $total_rows);
        
        $this->call->view('StudentsView', $data);
    }
    
    public function deleted() {
        // Get the current page number
        $page = 1;
        if(isset($_GET['page']) && !empty($_GET['page'])) {
            $page = (int)$this->io->get('page');
        }
        
        // Get search query if any
        $search = '';
        if(isset($_GET['search']) && !empty($_GET['search'])) {
            $search = trim($this->io->get('search'));
        }
        
        // Set records per page
        $records_per_page = 10;
        if(isset($_GET['show']) && !empty($_GET['show'])) {
            $records_per_page = (int) $this->io->get('show');
        }
        
        // Get deleted students with pagination
        $result = $this->StudentsModel->getDeletedStudentsWithPagination($search, $records_per_page, $page);
        $data['deleted_students'] = $result['records'];
        $total_rows = $result['total_rows'];
        
        // Configure pagination
        $this->pagination->set_options([
            'first_link'     => '«',
            'last_link'      => '»',
            'next_link'      => '›',
            'prev_link'      => '‹',
            'page_delimiter' => '&page='
        ]);
        
        // Set the theme and initialize
        $this->pagination->set_theme('bootstrap');
        $base_url = site_url('students/deleted/');
        $url_params = "?search=$search&show=$records_per_page";
        $this->pagination->initialize($total_rows, $records_per_page, $page, $base_url.$url_params);
        
        // Generate pagination links
        $data['pagination'] = $this->pagination->paginate();
        
        // Pass additional data to the view
        $data['search'] = $search;
        $data['records_per_page'] = $records_per_page;
        $data['total_rows'] = $total_rows;
        $data['current_page'] = $page;
        $data['showing_start'] = ($page - 1) * $records_per_page + 1;
        if($total_rows == 0) {
            $data['showing_start'] = 0;
        }
        $data['showing_end'] = min($page * $records_per_page, $total_rows);
        
        $this->call->view('deleted_students', $data);
    }
    
    public function restore($id) {
        if ($this->StudentsModel->restore($id)) {
            set_flash_alert('success', 'Student was restored successfully!');
        } else {
            set_flash_alert('danger', 'Failed to restore student.');
        }
        redirect('students/deleted');
    }
}