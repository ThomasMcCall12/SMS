<?php

#te3sting file for testing python

$command = escapeshellcmd('/testing.py');
$output = shell_exec($command);
echo $output;