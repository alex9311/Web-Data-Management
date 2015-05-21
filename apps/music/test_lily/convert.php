<?php
function convert($music_file_name){
    $myfile = fopen($music_file_name, "w") or die("Unable to open file!");

    $txt = file_get_contents('http://localhost:8080/exist/rest/db/music/'.$music_file_name);
    
    fwrite($myfile, $txt);

    fclose($myfile);

    $musically2ly = fopen('musicxml2lystart.bat', "w");
    
    fwrite($musically2ly, 'musicxml2ly '.$music_file_name);
    
    fclose($musically2ly);

    $out = [];
    $returnval = [];
    
    echo exec("musicxml2lystart.bat", $out, $returnval);

    
    print_r($returnval);
    print_r($out);
    
    shell_exec('lilypond '.substr($music_file_name,0,-3)."ly");
    
    echo "finished converting";
}
?>
