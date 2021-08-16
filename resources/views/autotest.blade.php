<html>
<head></head>
<body>
<form>
    <button type="submit" name="type" value="1">Jess Test</button>
    <button name="type" value="2">Feature Test</button>
    <button name="type" value="3">Dusk</button>
</form>
<div style="border: 1px solid; background: black; color: #38c172; min-width: 500px; padding: 10px">{{run_cmd()}}</div>

</body>
</html>
<?php
function run_cmd()
{
    if (isset($_GET['type'])) {
        $cmd = "";
        $type = $_GET['type'];
        if ($type == 1)
            $cmd = "nohup npm run test-one 2>&1 &";
        if ($type == 2)
//            $cmd = " (cd .. &&   nohup php artisan test) &";
//            $cmd = "nohup sh -c 'cd ..;  php artisan test' &";
            $cmd = "cd .. &&  nohup php artisan test  &";
//            $cmd="cd ..;ls -l";
        if ($type == 3)
            $cmd = "cd .. &&  nohup php artisan dusk  &";
//            $cmd = "cd .. &&  ./dusk.command  &";
//            $cmd = "cd..;cd..;nohup php artisan dusk 2>&1 &";
//              $cmd="cd ..;pwd";
        $output = shell_exec($cmd);
        echo '<pre>' . $output . '</pre>';
    }
}



