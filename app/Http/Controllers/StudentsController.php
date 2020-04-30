<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Log;
use \Illuminate\Http\Response as Res;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Excel;
use App\Exports\ExportAllStudents;

class StudentsController extends ApiController {

    public function __construct() {
        
    }

    public function SaveOrUpdate(Request $request) {

        $rules = array(
            'id' => 'required_without_all:name,class,city,state,pincode,address|numeric',
            'name' => 'required|required_without:id',
            'class' => 'required|required_without:id|numeric',
            'city' => 'required|required_without:id',
            'state' => 'required|required_without:id',
            'pincode' => 'required|required_without:id|numeric|digits:6',
            'address' => 'required|required_without:id'
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->respondValidationError('Fields Validation Failed.', $validator->errors());
        }

        try {
            $students = NULL;
            if ($request->input('id') != NULL) {
                $students = \App\Students::where('id', $request->input('id'))->first();
                if ($students === NULL) {
                    return $this->respond([
                                'status' => 'error',
                                'status_code' => Res::HTTP_NOT_FOUND,
                                'message' => 'No Records Found!',
                    ]);
                }
                $status_code = Res::HTTP_OK;
                $message = 'Record Updated Successfully!';
                $students->updated_at = Carbon::now();
            }
            if ($students === NULL) {
                $students = new \App\Students;
                $students->created_at = Carbon::now();
                $status_code = Res::HTTP_CREATED;
                $message = 'Record Created Successfully!';
            }
            $students->name = $request->input('name');
            $students->class = $request->input('class');
            $students->city = $request->input('city');
            $students->state = $request->input('state');
            $students->pincode = $request->input('pincode');
            $students->address = $request->input('address');
            $students->address = $request->input('address');
            $students->save();

            return $this->respond([
                        'status' => 'success',
                        'status_code' => $status_code,
                        'data' => $students,
                        'message' => $message,
            ]);
        } catch (QueryException $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        } catch (\PDOException $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        } catch (\Exception $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        }
    }

    public function FindById(Request $request) {
        $rules = array(
            'id' => 'required|numeric',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->respondValidationError('Fields Validation Failed.', $validator->errors());
        }

        try {
            $students = \App\Students::where('id', $request->input('id'))->first();

            if ($students === NULL) {
                return $this->respond([
                            'status' => 'error',
                            'status_code' => Res::HTTP_NOT_FOUND,
                            'message' => 'No Records Found!',
                ]);
            }

            return $this->respond([
                        'status' => 'success',
                        'status_code' => Res::HTTP_OK,
                        'data' => $students,
                        'message' => 'Student Record Found!'
            ]);
        } catch (QueryException $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        } catch (\PDOException $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        } catch (\Exception $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        }
    }

    public function FetchAll(Request $request) {
        $rules = array(
            'id' => 'sometimes|nullable|numeric',
            'name' => 'sometimes|nullable',
            'class' => 'sometimes|nullable|numeric',
            'city' => 'sometimes|nullable',
            'state' => 'sometimes|nullable',
            'pincode' => 'sometimes|nullable|numeric',
            'address' => 'sometimes|nullable',
            'start_date' => 'required_with:end_date|date|date_format:d-m-Y',
            'end_date' => 'required_with:start_date|date|after:start_date|date_format:d-m-Y',
            'download' => 'sometimes|nullable|in:pdf,xlsx',
            'records_per_page' => 'sometimes|nullable|numeric',
            'page_number' => 'sometimes|nullable|numeric|gte:1',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->respondValidationError('Fields Validation Failed.', $validator->errors());
        }

        try {

            $request['records_per_page'] = $request->input('records_per_page') ?: 15;
            $request['page_number'] = $request->input('page_number') ?: 1;
            $offset = ($request->input('page_number') - 1) * $request->input('records_per_page');

            $students = \App\Students::
                    when($request->input('id') != NULL, function($query) use ($request) {
                        return $query->where('id', $request->input('id'));
                    })
                    ->when($request->input('name') != NULL, function($query) use ($request) {
                        return $query->where('name', $request->input('name'));
                    })
                    ->when($request->input('class') != NULL, function($query) use ($request) {
                        return $query->where('class', $request->input('class'));
                    })
                    ->when($request->input('city') != NULL, function($query) use ($request) {
                        return $query->where('city', $request->input('city'));
                    })
                    ->when($request->input('state') != NULL, function($query) use ($request) {
                        return $query->where('state', $request->input('state'));
                    })
                    ->when($request->input('pincode') != NULL, function($query) use ($request) {
                        return $query->where('pincode', $request->input('pincode'));
                    })
                    ->when($request->input('class') != NULL, function($query) use ($request) {
                        return $query->where('class', $request->input('class'));
                    })
                    ->when($request->input('start_date') != NULL && $request->input('end_date') != NULL, function($query) use($request) {
                return $query->whereBetween(DB::raw("DATE_FORMAT(created_at, '%d-%m-%Y')"), [$request->input('start_date'), $request->input('end_date')]);
            });
            //->get()->toArray();

            $studentss_xlsx = $students->get();
            $count = $students->get()->count();
            $students->offset($offset);
            $students->limit($request->input('records_per_page'));
            $studentss = $students->get()->toArray();
            $pages = ceil($count / $request->input('records_per_page'));

            if ($request->input('download') == 'xlsx') {
                try {
                    $fileName = 'Students' . date('d-m-y') . '.xlsx';
                    return Excel::download(new ExportAllStudents($studentss_xlsx), $fileName);
                } catch (\Exception $e) {
                    \Log::emergency($e);
                    return 'Failed';
                }
            }

            if ($request->input('download') == 'pdf') {
                try {

                    $students_pdf = ['students' => $studentss, 'count' => $count];
                    $pdf = \PDF::loadView('pdf.students', $students_pdf);
                    $pdf->setPaper('A4', 'landscape');
                    return $pdf->download('students.pdf');
                } catch (\Exception $e) {
                    \Log::emergency($e);
                    return 'Failed';
                }
            }

            return $this->respond([
                        'status' => 'success',
                        'status_code' => Res::HTTP_OK,
                        'data' => $studentss,
                        'message' => 'Students Record Found!'
            ]);
        } catch (QueryException $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        } catch (\PDOException $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        } catch (\Exception $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        }
    }

    public function DeleteById(Request $request) {
        $rules = array(
            'id' => 'required|numeric',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return $this->respondValidationError('Fields Validation Failed.', $validator->errors());
        }

        try {
            $students = \App\Students::where('id', $request->input('id'))->first();

            if ($students === NULL) {
                return $this->respond([
                            'status' => 'error',
                            'status_code' => Res::HTTP_NOT_FOUND,
                            'message' => 'No Records Found!',
                ]);
            }
            $students->delete();
            return $this->respond([
                        'status' => 'success',
                        'status_code' => Res::HTTP_OK,
                        'message' => 'Student Record Deleted!'
            ]);
        } catch (QueryException $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        } catch (\PDOException $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        } catch (\Exception $e) {
            Log::emergency($e);
            return $this->respondInternalErrors();
        }
    }

}
