<?php

# näitab Array-d loetavalt
function make_array_readable($value)
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}

# näitabvar_dump-i loetavalt
function var_dump_readable($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}

function dd($data)
{
    highlight_string("<?php\n " . var_export($data, true) . "?>");
    echo '<script>document.getElementsByTagName("code")[0].getElementsByTagName("span")[1].remove() ;document.getElementsByTagName("code")[0].getElementsByTagName("span")[document.getElementsByTagName("code")[0].getElementsByTagName("span").length - 1].remove() ; </script>';

}
