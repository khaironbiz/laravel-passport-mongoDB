<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Models\Observation;
use App\Models\StrokeRisk;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class StrokeRiskController extends Controller
{
    public function index()
    {

    }
    public function latest(){

        $code_sistole       = "8480-6";
        $code_diastolic     = "8462-4";
        $hr_code            = "8867-4";
        $body_temp_code     = "8310-5";
        $body_weight_code   = "29463-7";
        $code_height    = "8302-2";
        $code_spo2      = "59408-5";
        $code_glucose   = "2345-7";
        $code_chole     = "2093-3";
        $code_UA        = "3084-1";
        $bmi_code       = "39156-5";
        $family         = User::where('family.id_induk', Auth::id());
        $count          = $family->count();
        $id_pasien      = Auth::id();
        $data = [
            'systole'           => $this->lates($code_sistole, $id_pasien)->getOriginalContent(),
            'diastole'          => $this->lates($code_diastolic, $id_pasien)->getOriginalContent(),
            'hearth_rate'       => $this->lates($hr_code, $id_pasien)->getOriginalContent(),
            'body_temperature'  => $this->lates($body_temp_code, $id_pasien)->getOriginalContent(),
            'body_weight'       => $this->lates($body_weight_code, $id_pasien)->getOriginalContent(),
            'body_height'       => $this->lates($code_height, $id_pasien)->getOriginalContent(),
            'oxygen_saturation' => $this->lates($code_spo2, $id_pasien)->getOriginalContent(),
            'blood_glucose'     => $this->lates($code_glucose, $id_pasien)->getOriginalContent(),
            'blood_cholesterole'=> $this->lates($code_chole, $id_pasien)->getOriginalContent(),
            'uric_acid'         => $this->lates($code_UA, $id_pasien)->getOriginalContent(),
            'bmi'               => $this->lates($bmi_code, $id_pasien)->getOriginalContent(),
        ];

        return response()->json([
            'status_code'   => 200,
            'message'       => 'success',
            'data'          => $data

        ]);
    }
    public function pasien(Request $request)
    {

        $code_sistole       = "8480-6";
        $code_diastolic     = "8462-4";
        $hr_code            = "8867-4";
        $body_temp_code     = "8310-5";
        $body_weight_code   = "29463-7";
        $code_height    = "8302-2";
        $code_spo2      = "59408-5";
        $code_glucose   = "2345-7";
        $code_chole     = "2093-3";
        $code_UA        = "3084-1";
        $bmi_code       = "39156-5";
        $id_pasien      = $request->id_pasien;
        $user           = User::find($id_pasien);
        $data_observasi = [
            'systole'           => $this->lates($code_sistole, $id_pasien)->getOriginalContent(),
            'diastole'          => $this->lates($code_diastolic, $id_pasien)->getOriginalContent(),
            'hearth_rate'       => $this->lates($hr_code, $id_pasien)->getOriginalContent(),
            'body_temperature'  => $this->lates($body_temp_code, $id_pasien)->getOriginalContent(),
            'body_weight'       => $this->lates($body_weight_code, $id_pasien)->getOriginalContent(),
            'body_height'       => $this->lates($code_height, $id_pasien)->getOriginalContent(),
            'oxygen_saturation' => $this->lates($code_spo2, $id_pasien)->getOriginalContent(),
            'blood_glucose'     => $this->lates($code_glucose, $id_pasien)->getOriginalContent(),
            'blood_cholesterole'=> $this->lates($code_chole, $id_pasien)->getOriginalContent(),
            'uric_acid'         => $this->lates($code_UA, $id_pasien)->getOriginalContent(),
            'bmi'               => $this->lates($bmi_code, $id_pasien)->getOriginalContent(),
        ];
        if(empty($user)){
            $status_code    = 404;
            $message        = "Id Pasien Salah";
            $data           = [
                'user'      => $user
            ];
        }else{
            $status_code    = 200;
            $message        = "success";
            $data           = [
                'user'          => $user,
                'observation'   => $data_observasi
            ];
        }
        $data_response = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response($data_response, $status_code);

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
        // user
        $id_pasien = $request->id_pasien;
        $user = User::find($id_pasien);
        // algoritma untuk blood pressure
        $systole            = (int) $request->systole;
        $diastole           = (int) $request->diastole;
        $heartRate          = (int) $request->heartRate;
        $atrial_fibrilasi   = (string) $request->atrialFibrilation;
        $smoking            = (string) $request->smoking;
        $cholesterol        = (int) $request->cholesterol;
        $glucose            = (int) $request->glucose;
        $exercise           = (int) $request->exercise;
        $bodyWeight         = (double) $request->bodyWeight;
        $bodyLength         = (double) $request->bodyLength;
        $familyStroke       = (string) $request->familyStroke;
        $data_bp            = $this->bp($systole, $diastole)->getOriginalContent();
        $data_af            = $this->atrial_fibrilasi($heartRate, $atrial_fibrilasi)->getOriginalContent();
        $data_smoking       = $this->smoking($smoking)->getOriginalContent();
        $data_cholesterol   = $this->cholesterol($cholesterol)->getOriginalContent();
        $data_glucose       = $this->glucode($glucose)->getOriginalContent();
        $data_exercise      = $this->exercise($exercise)->getOriginalContent();
        $data_bmi           = $this->bmi($bodyWeight,$bodyLength)->getOriginalContent();
        $data_family_risk   = $this->familyRisk($familyStroke)->getOriginalContent();
        $data_stroke_risk   = [
            'blood_pressure'    => $data_bp,
            'atrialFibrilation' => $data_af,
            'smoking'           => $data_smoking,
            'cholesterol'       => $data_cholesterol,
            'glucose'           => $data_glucose,
            'exercise'          => $data_exercise,
            'bmi'               => $data_bmi,
            'familyStroke'      => $data_family_risk];
//        return response($data_stroke_risk);
        $data_result = [
            $data_stroke_risk['blood_pressure']['interpretation'],
            $data_stroke_risk['atrialFibrilation']['interpretation'],
            $data_stroke_risk['smoking']['interpretation'],
            $data_stroke_risk['cholesterol']['interpretation'],
            $data_stroke_risk['glucose']['interpretation'],
            $data_stroke_risk['exercise']['interpretation'],
            $data_stroke_risk['bmi']['interpretation'],
            $data_stroke_risk['familyStroke']['interpretation'],
        ];
        $result         = array_count_values($data_result);
        if($result['High Risk'] >= 3){
            $interpretation_stroke_risk = 'High Risk';
        }elseif($result['Caution'] >= 4){
            $interpretation_stroke_risk = 'Caution';
        }else{
            $interpretation_stroke_risk = 'Low Risk';
        }
        $stroke_risk  = [
            'result'            => $result,
            'interpretation'    => $interpretation_stroke_risk,
            'date'              => time(),
            'data'              => $data_stroke_risk
        ];

        if ($validator->fails()) {
            $status_code    = 422;
            $message        = "Gagal Validasi";
            $data = [
                'errors' => $validator->errors(),
            ];
        }elseif(empty($user)){
            $status_code    = 404;
            $message        = "Id Pasien Salah";
            $data           = [
                'user'      => $user
            ];
        }else{
            $update_user = $user->update([
                'stroke_risk'   => $stroke_risk
            ]);
            if($update_user){

                $status_code    = 201;
                $message        = "Created";
                $data = [
                    'errors'    => $validator->errors(),
                    'input'     => $request->all(),
                    'stroke_risk'   => $data_stroke_risk
                ];
            }
        }
        $data_post   = [
            'status_code'   => $status_code,
            'message'       => $message,
            'data'          => $data
        ];
        return response()->json($data_post, $status_code );
    }
    private function bp($systole, $diastole)
    {
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
        $response = [
            'result'          => $systole."/".$diastole." mmHg",
            'interpretation'  => $interpretation_bp,
            'data'    => [
                'systole'  => [
                    'result'          => $result_systole,
                    'interpretation'  => $interpretation_systole,
                    'data'            => [
                        'value'       => $systole,
                        'unit'        => "mmHg"
                    ]
                ],
                'diastole'=> [
                    'result'          => $result_diastole,
                    'interpretation'  => $interpretation_diastole,
                    'data'            => [
                        'value'       => $diastole,
                        'unit'        => "mmHg"
                    ]
                ],
            ]
        ];
        return response($response) ;
    }
    private function atrial_fibrilasi($heartRate, $atrial_fibrilasi){
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
        $response = [
            'result'            => $atrial_fibrilasi,
            'interpretation'    => $interpretation_af,
            'data'      => [
                'heart_rate'    => [
                    'value'     => (int) $heartRate,
                    'unit'      => 'beat/minute',
                ],
            ]
        ];
        return response($response);
    }
    private function smoking($smoking){
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
        $response =[
            'result'            => $smoking,
            'interpretation'    => $interpretation_smoking
        ];
        return response($response);
    }
    private function cholesterol($cholesterol){
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
        $data_response = [
            'result'            => $cholesterol,
            'interpretation'    =>$interpretation_cholestorole,
            'data'      => [
                'cholesterol'   => [
                    'value'     => $cholesterol,
                    'unit'      => 'mg/dL',
                ]
            ]
        ];
        return response($data_response);
    }
    private function glucode($glucose){
        //glucose
        if($glucose >= 200){
            $interpretation_glucose = "High Risk";
        }elseif($glucose > 150) {
            $interpretation_glucose = "Caution";
        }elseif($glucose < 150){
            $interpretation_glucose = "Low Risk";
        }else{
            $interpretation_glucose = null;
        }
        $data_response = [
            'result'    => $glucose,
            'interpretation'    =>$interpretation_glucose,
            'data'      => [
                'glucoseFasting'=> [
                    'value'     => $glucose,
                    'unit'      => 'mg/dL',
                ]
            ]
        ];
        return response($data_response);
    }
    private function exercise($exercise){
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
        $data_response = [
            'result'    => $exercise,
            'interpretation'    => $interpretation_exercise,
            'data'      => [
                'exercise'   => [
                    'value'     => $exercise,
                    'unit'      => 'minutes',
                ]
            ]
        ];
        return response($data_response);
    }

    private function bmi($bodyWeight, $bodyLength){
        $bmi = round ($bodyWeight/($bodyLength*$bodyLength)*10000,2);
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
        $data_response = [
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
        ];
        return response($data_response);
    }
    private function familyRisk($familyStroke){
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
        $data_response =[
            'result'    => $familyStroke,
            'interpretation'    => $interpretation_family
        ];
        return response($data_response);
    }
    private function lates($observation_code, $id_pasien){
        $myObservation  = Observation::where([
            'coding.code'   => $observation_code,
            'id_pasien'     => $id_pasien
        ])->latest()->first();

        return response($myObservation);
    }
}
