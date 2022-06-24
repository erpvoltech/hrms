<!DOCTYPE html>
<html>

    <body>

        <?php
        $myfile = fopen("policy_update.log", "r") or die("Unable to Open the File!");
        $linecount = 0;
// Output one line until end-of-file
        while (!feof($myfile)) {
            echo fgets($myfile) . "<br>";
            $linecount++;
        }
        fclose($myfile);
        /* if($linecount > 50000){
          $string = file_get_contents($myfile);
          $lines = explode('\n', $string);
          for($i = 0; $i < 11; $i++) {
          unset($lines[$i]);
          }
          } */
        ?>

    </body>
</html>