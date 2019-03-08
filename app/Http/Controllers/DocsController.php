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
        $index = markdown($this->docs->get());
        $content = markdown($this->docs->get($file ?: 'installation.md'));
        return view('docs.show',compact('index', 'content'));
    }
}
