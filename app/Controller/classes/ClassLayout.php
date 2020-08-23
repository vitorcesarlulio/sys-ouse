<?php
namespace Classes;

class ClassLayout{

    #Setar as tags do head
    public static function setHead($title , $description , $author='Webdesign em Foco')
    {
        $html="<!doctype html>\n";
        $html.="<html lang='pt-br'>\n";
        $html.="<head>\n";
        $html.="  <meta charset='UTF-8'>\n";
        $html.="  <meta name='viewport' content='width=device-width, initial-scale=1'>\n";
        $html.="  <meta name='author' content='$author'>\n";
        $html.="  <meta name='format-detection' content='telephone=no'>\n";
        $html.="  <meta name='description' content='$description'>\n";
        $html.="  <title>$title</title>\n";
        #FAVICON
        #STYLESHEET
        $html.="</head>\n\n";
        $html.="<body>\n";
        echo $html;
    }

    #Setar as tags do footer
    public static function setFooter()
    {
        #JAVASCRIPT
        $html="</body>\n";
        $html.="</html>";
        echo $html;
    }
}