<?php

namespace App;

use Illuminate\Support\Facades\File;

class Document
{
    public function get($file = 'documentation.md')
    {
        $content = File::get($this->Path($file));

        return $this->replaceLinks($content);
    }

    private function Path($file)
    {
        $file = ends_with($file, '.md') ? $file : $file . '.md';
        $path = base_path('docs'. DIRECTORY_SEPARATOR . $file);

        if(!File::exists($path)){
            abort(404, '요청하신 파일이 없습니다.');
        }

        return $path;
    }

    protected function replaceLinks($content)
    {
        return str_replace('/docs/{{version}}', '/docs', $content);
    }
}
