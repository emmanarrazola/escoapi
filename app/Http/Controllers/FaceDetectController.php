<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FaceDetectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('auth.face-login');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $folderpath = public_path()."\\img\\temp\\";
        $threshold = 0.8;

        $img = $request->image_tag;

        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];


        $image_base64 = base64_decode($image_parts[1]);

        $fileName = uniqid() . '.'.$image_type;
  
        $file = $folderpath . $fileName;
        if(file_put_contents($file, $image_base64)){
            $apicon = new \GuzzleHttp\Client([
                'http_errors'=>false,
                'base_uri'=>'http://192.168.2.130:8000'
            ]);
            
            
            $response = $apicon->request('POST', 'api/v1/verification/verify?face_plugins=landmarks,gender,age', [
                'headers'=>[
                    'x-api-key'=>'5b926d9f-0211-4f19-8819-ffe54a514a08'
                ],
                'multipart' => [
                    [
                        'name'     => 'source_image',
                        'contents' => fopen( $file, 'r' ),
                        'filename' => '1001.jpeg'
                    ],
                    [
                        'name'     => 'target_image',
                        'contents' => fopen( $file, 'r' ),
                        'filename' => '1002.jpeg'
                    ]
                ],
            ]);

            $response = json_decode($response->getBody());

            dd($response->result[0]->face_matches[0]->similarity);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
