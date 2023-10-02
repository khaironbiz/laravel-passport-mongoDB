<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\StrokeRisk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StrokeRiskController extends Controller
{
    public function index()
    {

    }
    public function pasien()
    {

    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'id_pasien'         => 'required',
            'systole'           => 'required',
            'diastole'          => 'required',
            'heartRate'         => 'required',
            'atrialFibrilation' => ['required', Rule::in(['i regular', 'i dont know', 'regular'])],
            'smoking'           => ['required', Rule::in(['yes', 'quite', 'no smoking'])],
            'cholesterol'       => 'required',
            'glucose'           => 'required',
            'exercise'          => 'required',
            'bodyWeight'        => 'required',
            'bodyLength'        => 'required',
            'familyStroke'      => ['required', Rule::in(['yes', 'not sure', 'no'])]
        ]);
        // algoritma untuk blood pressure
        $systole = (int) $request->systole;
        $diastole = (int) $request->diastole;
        if( $systole >= 140){
            $result_systole = ">= 140";
            $interpretation_systole = "High Risk";
        }elseif($systole < 140 ){
            $result_systole = "< 140";
            $interpretation_systole = "Caution";
        }elseif($systole <= 120 ){
            $result_systole = "<= 120";
            $interpretation_systole = "Low Risk";
        }else{
            $result_systole = null;
            $interpretation_systole = null;
        }
        if($diastole >=90){
            $result_diastole = ">= 90";
            $interpretation_diastole = "High Risk";
        }elseif($diastole < 90) {
            $result_diastole = "< 90";
            $interpretation_diastole = "Caution";
        }elseif($diastole <= 80){
            $result_diastole = "<= 80";
            $interpretation_diastole = "Low Risk";
        }
        // interpretation BP
        if($interpretation_diastole == "High Risk" || $interpretation_systole == "High Risk"){
            $interpretation_bp = "High Risk";
        }elseif($interpretation_diastole == "Caution" && $interpretation_systole == "Caution"){
            $interpretation_bp = "Caution";
        }
        //interpretation AF
        if($request->atrialFibrilation == "i regular"){
            $interpretation_af = "High Risk";
        }elseif($request->atrialFibrilation == "i dont know"){
            $interpretation_af = "Caution";
        }elseif($request->atrialFibrilation == "regular"){
            $interpretation_af = "Low Risk";
        }else{
            $interpretation_af = null;
        }
        // interpretasi smoking
        if($request->smoking == "yes"){
            $interpretation_smoking = "High Risk";
        }elseif($request->smoking == "quite"){
            $interpretation_smoking = "Caution";
        }elseif($request->smoking == "no smoking"){
            $interpretation_smoking = "Low Risk";
        }else{
            $interpretation_smoking = null;
        }

        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }else{
            $data_stroke_risk = [
                'id_pasien'     => Auth::id(),
                'date'          => time(),
                'blood_pressure'    => [
                    'result'    => (int) $request->systole."/".(int) $request->diastole." mmHg",
                    'interpretation'    => $interpretation_bp,
                    'data'      => [
                        'systole'   => [
                            'value'     => (int) $request->systole,
                            'unit'      => 'mmHg',
                        ],
                        'diastole'  => [
                            'value'     => (int) $request->diastole,
                            'unit'      => 'mmHg',
                        ],
                    ]
                ],
                'atrialFibrilation' => [
                    'result'            => $request->atrialFibrilation,
                    'interpretation'    => $interpretation_af,
                    'data'      => [
                        'heart_rate'    => [
                            'value'     => (int) $request->heartRate,
                            'unit'      => 'beat/minute',
                        ],
                    ]
                ],
                'smoking'           => [
                    'result'            => $request->smoking,
                    'interpretation'    => $interpretation_smoking
                ],
                'cholesterol'       => [
                    'result'    => (int) $request->cholesterol,
                    'data'      => [
                        'cholesterol'   => [
                            'value'     => (int) $request->cholesterol,
                            'unit'      => 'mg/dL',
                        ]
                    ]
                ],
                'glucose'    => [
                    'result'    => (int) $request->glucose,
                    'data'      => [
                        'glucoseFasting'   => [
                            'value'     => (int) $request->glucose,
                            'unit'      => 'mg/dL',
                        ]
                    ]
                ],
                'exercise'          => [
                    'result'    => $request->exercise,
                    'data'      => [
                        'exercise'   => [
                            'value'     => $request->exercise,
                            'unit'      => 'minutes',
                        ]
                    ]
                ],
                'bmi'               => [
                    'result'    => round (((int)$request->bodyWeight/((int)$request->bodyLength*(int)$request->bodyLength)*10000),2),
                    'data'      => [
                        'bodyWeight'   => [
                            'value'     => $request->bodyWeight,
                            'unit'      => 'Kg',
                        ],
                        'bodyLength'   => [
                            'value'     => $request->bodyLength,
                            'unit'      => 'cm',
                        ]
                    ]
                ],
                'familyStroke'      => [
                    'result'    => $request->familyStroke
                ],
            ];
            $status_code    = 201;
            $message        = "Created";
            $data = [
                'errors'    => $validator->errors(),
                'input'     => $request->all(),
                'stroke_risk'   => $data_stroke_risk
            ];
        }
        $data_post   = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($data_post, $status_code );
    }
}
