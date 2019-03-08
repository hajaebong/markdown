<?php

namespace App\Http\Controllers;

use App\Document;
use Illuminate\Http\Request;

class DocumentController extends Controller
{
    protected $document;

    //생성자에서 APP\Document 인스턴스를 주입
    public function __construct(Document $document)
    {
        $this->document = $document;
    }

    //뷰에 2개의 데이터를 바인딩 하는데 $index는 왼쪽 사이드 바에 보여줄 목록이며, $content는 본문이다.
    public function show($file = null)
    {
        return view('documents.index',[
            'index' => markdown($this->document->get()),
            'content' => markdown($this->document->get($file ?: '01-welcome.md'))]);
    }
}
