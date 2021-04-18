<?php
const FILE = 'counter.txt';
$counter = file_get_contents (FILE);
file_put_contents (FILE, ++$counter);
echo $counter;
