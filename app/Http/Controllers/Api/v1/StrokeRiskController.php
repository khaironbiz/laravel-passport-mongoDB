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
        $systole            = (int) $request->systole;
        $diastole           = (int) $request->diastole;
        $atrial_fibrilasi   = (string) $request->atrialFibrilation;
        $smoking            = (string) $request->smoking;
        $cholesterol        = (int) $request->cholesterol;
        $glucose            = (int) $request->glucose;
        $exercise           = (int) $request->exercise;
        $bodyWeight         = (double) $request->bodyWeight;
        $bodyLength         = (double) $request->bodyLength;
        $bmi                = round ($bodyWeight/($bodyLength*$bodyLength)*10000,2);
        $familyStroke       = (string) $request->familyStroke;
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
        if($atrial_fibrilasi == "i regular"){
            $interpretation_af = "High Risk";
        }elseif($atrial_fibrilasi == "i dont know"){
            $interpretation_af = "Caution";
        }elseif($atrial_fibrilasi == "regular"){
            $interpretation_af = "Low Risk";
        }else{
            $interpretation_af = null;
        }
        // interpretasi smoking
        if($smoking == "yes"){
            $interpretation_smoking = "High Risk";
        }elseif($smoking == "quite"){
            $interpretation_smoking = "Caution";
        }elseif($smoking == "no smoking"){
            $interpretation_smoking = "Low Risk";
        }else{
            $interpretation_smoking = null;
        }

        //$cholesterol
        if($cholesterol  >=240){
            $interpretation_cholestorole = "High Risk";
        }elseif($cholesterol  > 200){
            $interpretation_cholestorole = "Caution";
        }elseif($cholesterol  < 200){
            $interpretation_cholestorole = "Low Risk";
        }else{
            $interpretation_cholestorole = null;
        }

        //glucose
        if($glucose >= 200){
            $interpretation_glucose = "High Risk";
        }elseif($glucose > 150) {
            $interpretation_glucose = "Caution";
        }elseif($glucose < 150){
            $interpretation_glucose = "Low Risk";
        }

        // exercise
        if($exercise <= 50 ){
            $interpretation_exercise = "High Risk";
        }elseif ($exercise < 150){
            $interpretation_exercise = "Caution";
        }elseif ($exercise >= 150){
            $interpretation_exercise = "Low Risk";
        }else{
            $interpretation_exercise = null;
        }
        // bmi
        if($bmi >=25 ){
            $interpretation_bmi = "High Risk";
        }elseif($bmi >=23){
            $interpretation_bmi = "Caution";
        }elseif($bmi < 23){
            $interpretation_bmi = "Low Risk";
        }else{
            $interpretation_bmi = null;
        }

        // family risk
        if($familyStroke){
            $interpretation_family = "High Risk";;
        }elseif ($familyStroke){
            $interpretation_family = "Caution";
        }elseif ($familyStroke){
            $interpretation_family = "Low Risk";
        }else{
            $interpretation_family = null;
        }

        $interpretation = [
            $interpretation_bp,
            $interpretation_af,
            $interpretation_smoking,
            $interpretation_cholestorole,
            $interpretation_glucose,
            $interpretation_exercise,
            $interpretation_bmi,
            $interpretation_family
        ];
        $count_interpretation = array_count_values($interpretation);
        if($count_interpretation['High Risk'] >= 3){
            $stroke_risk = 'High Risk';
        }elseif($count_interpretation['Caution'] >= 4){
            $stroke_risk = 'Caution';
        }else{
            $stroke_risk = 'Low Risk';
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
                'result'        => $count_interpretation,
                'interpretation'=> $stroke_risk,
                'data'          => [
                    'blood_pressure'    => [
                        'result'            => $systole."/".$diastole." mmHg",
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
                        'result'            => $atrial_fibrilasi,
                        'interpretation'    => $interpretation_af,
                        'data'      => [
                            'heart_rate'    => [
                                'value'     => (int) $request->heartRate,
                                'unit'      => 'beat/minute',
                            ],
                        ]
                    ],
                    'smoking'           => [
                        'result'            => $smoking,
                        'interpretation'    => $interpretation_smoking
                    ],
                    'cholesterol'       => [
                        'result'            => $cholesterol,
                        'interpretation'    =>$interpretation_cholestorole,
                        'data'      => [
                            'cholesterol'   => [
                                'value'     => $cholesterol,
                                'unit'      => 'mg/dL',
                            ]
                        ]
                    ],
                    'glucose'           => [
                        'result'    => $glucose,
                        'interpretation'    =>$interpretation_glucose,
                        'data'      => [
                            'glucoseFasting'   => [
                                'value'     => $glucose,
                                'unit'      => 'mg/dL',
                            ]
                        ]
                    ],
                    'exercise'          => [
                        'result'    => $exercise,
                        'interpretation'    => $interpretation_exercise,
                        'data'      => [
                            'exercise'   => [
                                'value'     => $exercise,
                                'unit'      => 'minutes',
                            ]
                        ]
                    ],
                    'bmi'               => [
                        'result'    => $bmi,
                        'interpretation'    => $interpretation_bmi,
                        'data'      => [
                            'bodyWeight'   => [
                                'value'     => $bodyWeight,
                                'unit'      => 'Kg',
                            ],
                            'bodyLength'   => [
                                'value'     => $bodyLength,
                                'unit'      => 'cm',
                            ]
                        ]
                    ],
                    'familyStroke'      => [
                        'result'    => $familyStroke,
                        'interpretation'    => $interpretation_family
                    ],
                ]

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
