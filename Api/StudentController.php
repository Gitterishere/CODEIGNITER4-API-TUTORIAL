<?php

namespace App\Controllers\Api;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\models\StudentModel;
use PHPUnit\Framework\MockObject\Builder\Stub;

class StudentController extends ResourceController
{
    protected $modelName = "App\models\StudentModel";
    protected $format = 'json';
    public function addStudent(){
        $data = $this->request->getPost();
        $name = isset($data['name'])? $data['name']:"";
        $email = isset($data['email'])? $data['email']:"";
        $phone_no = isset($data['phone_no'])? $data['phone_no']:"";

        if(empty($name)|| empty($email)){
            return $this->respond([
                'status'=>false,
                'message'=>'Please Provide The Values For Missing Fields',
            ]);


        }

        $student_data = $this->checkStudentByEmail($email);
        if(!empty($student_data)){
            return $this->respond([
                'status'=>true,
                'message'=>'Email Already Exists',
            ]);

        }
        else{
            if($this->model->insert([
                'name'=>$name,
    
                'email'=>$email,
    
                'phone_no'=>$phone_no
            ])){
                return $this->respond([
                    'status'=>true,
                    'message'=>'Succesfully added the data of student',
                ]);
            }
            else{
                return $this->respond([
                    'status'=>false,
                    'message'=>'Failed to add student data',
                ]);
            }
        }
        

        print_r($data);
    }
    public function listStudents(){
        $students = $this->model->findAll();
        return $this->respond([
            'status'=>true,
            'message'=>'Data Feteched Succesfully',
            'data'=>$students

        ]);

    }
    public function getSingleStudentData($student_id){
        $students_data = $this->model->find($student_id);
        if(!empty($students_data)){
            return $this->respond([
                'status'=>true,
                'Message'=>'Data Feteched Succesfully',
                'data'=>$students_data
            ]);
        }else{
            return $this->respond([
                'status'=>false,
                'Message'=>'Error',
            ]);    
                
        }
    }
    public function updateStudent($student_id){
        $student = $this->model->find($student_id);
        if(!empty($student)){
            $data = json_decode(file_get_contents('php://input'),true);
            $updated_data = [
                'name'=>isset($data['name']) && !empty($data['name']) ? $data['name']:$student['name'],
                'email'=>isset($data['email']) && !empty($data['email']) ? $data['email']:$student['email'],
                'phone_no'=>isset($data['phone_no']) && !empty($data['phone_no']) ? $data['phone_no']:$student['phone_no'],
            ];
            $updates = $this->model->update($student_id,$updated_data);
            if($updates){
                return $this->respond([
                    'status'=>true,
                    'Message'=>'Data Updated Successfully'
                ]);
            }else{
                $this->respond([
                    'status'=>false,
                    'Message'=>'Error Occured while updating'
                ]);
            }
        }else{
            $this->respond([
                'status'=>false,
                'Message'=>'Student With Given ID doesnt Exist'
            ]);
        }
    }
    public function deleteStudent($student_id){
        $student = $this->model->find($student_id);
        if(!empty($student)){
            $delete = $this->model->delete($student_id);
            if($delete){
                return $this->respond([
                    'status'=>true,
                    'Message'=>'Student Data Deleted Successfully'
                ]);
            }else{
                $this->respond([
                    'status'=>false,
                    'Message'=>'Student With Given ID doesnt Exist'
                ]);
            }
        }
    }
    private function checkStudentByEmail($email){
        return $this->model->where('email',$email)->first();
    }
}
