<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;

class DocsController extends Controller
{
    protected $docs;

    //생성자에서 APP\Document 인스턴스를 주입
    public function __construct(Document $docs)
    {
        $this->docs = $docs;
    }

    //뷰에 2개의 데이터를 바인딩 하는데 $index는 왼쪽 사이드 바에 보여줄 목록이며, $content는 본문이다.
    public function show($file = null)
    {
        //캐시 유효기간을 120분으로 잡음
        $index = \Cache::remember('docs.index', 120, function (){
            return markdown($this->docs->get());
        });


        $content = \Cache::remember("docs.{$file}", 120, function () use ($file){
            return markdown($this->docs->get($file ?: 'installation.md'));
        });

        return view('docs.show',compact('index', 'content'));
    }

    public function image($file)
    {
        $image = $this->docs->image($file);

        return response($image->encode('png'), 200, [
            'Content-Type' => 'image/png'//http응답헤더를 줄수 있는데 Content-Type 헤더로 '이 응답의 본문은 PNG이미지입니다.' 정의
        ]);
    }
}
